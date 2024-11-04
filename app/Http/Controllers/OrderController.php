<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\Produk;
use App\Models\Transaksi;
use Mike42\Escpos\Printer;
use App\Models\DetailOrder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\CapabilityProfile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class OrderController extends Controller
{
    // TAMPILAN KONTROL
    // USER 

    // 1. MENAMPILKAN DAFTAR MENU OUTLET

    public function MenuOutlet($uid)
    {

        // Fetch the outlet by UID and load its products
        $outlet = Outlet::with('produk')->where('uid', $uid)->firstOrFail();

        $jumlahproduk = Produk::where('id_outlet', $outlet->id)->count('id');

        $currentTime = now()->setTimezone('Asia/Jakarta')->toTimeString();

        // Ambil jam buka dan tutup dari outlet
        $startHour = $outlet->jam_buka;  // Jam mulai operasional dari database
        $endHour = $outlet->jam_tutup;   // Jam tutup operasional dari database

        // Pengecekan jam operasional outlet
        $isOpen = ($currentTime >= $startHour && $currentTime < $endHour);

        // Ambil produk yang terkait dengan outlet
        $produks = Produk::with(['DetailTransaksi', 'Kategori']) // Eager load kategoris
            ->leftJoin('detail_transaksi', 'produk.id', '=', 'detail_transaksi.id_produk')
            ->leftJoin('kategori', 'produk.id_kategori', '=', 'kategori.id')
            ->select(
                'produk.id',
                'produk.nama_produk',
                'produk.harga_jual',
                'produk.id_kategori',
                'produk.foto',
                'produk.sku',
                'produk.status',
                'produk.harga_diskon',
                'produk.deskripsi',
                'kategori.nama_kategori',
                DB::raw('COALESCE(SUM(detail_transaksi.jumlah_barang), 0) as total_sold')
            )
            ->where('produk.id_outlet', $outlet->id)
            ->groupBy('produk.id', 'produk.nama_produk', 'produk.harga_jual', 'produk.id_kategori', 'produk.foto', 'produk.sku', 'produk.status', 'produk.harga_diskon', 'kategori.nama_kategori')
            ->orderBy('total_sold', 'desc')
            ->orderBy('produk.nama_produk', 'asc')
            ->get();

        // Group products by category name
        $groupedProduks = $produks->groupBy('nama_kategori');

        return view('User.outlet-menu', [
            'title' => 'Order ' . $outlet->nama_outlet,  // or 'Nama Resto' if you want to use a static title
            'outlet' => $outlet,
            'JumlahProduk' => $jumlahproduk,
            'Produk' => $produks,
            'groupedProduks' => $groupedProduks,
            'isOpen' => $isOpen,
        ]);
    }

    // 2. MEMBUAT SESION ID
    public function checkout(Request $request)
    {
        // Validate and store the products data
        $data = $request->validate([
            'products' => 'required|array',
            'id_outlet' => 'required|integer|exists:outlet,id', // Validate id_outlet
        ]);

        // Create a unique session ID or identifier
        $sessionId = Str::uuid()->toString(); // Or any other method to create a unique ID

        // Store the products and outlet ID in session
        session(['checkout_data' => $data['products'], 'id_outlet' => $data['id_outlet']]);

        // Return the session ID in the response
        return response()->json(['sessionId' => $sessionId]);
    }

    // 3. MENAMPILKAN FORM CHECKOUT
    public function showCheckout($sessionId)
    {
        // Retrieve the product data and outlet ID from the session
        $products = session('checkout_data', []);
        $idOutlet = session('id_outlet'); // Get the id_outlet from the session

        // Extract product IDs from the session data
        $productIds = array_column($products, 'id');

        // Fetch product details (including photo) from the database based on the IDs
        $detailedProducts = DB::table('produk')
            ->whereIn('id', $productIds)
            ->get()
            ->map(function ($product) use ($products) {
                // Match the quantity from session data
                foreach ($products as $item) {
                    if ($item['id'] == $product->id) {
                        $product->quantity = $item['quantity'];
                        $product->price = $item['price'];
                        break;
                    }
                }
                return $product;
            });

        // Fetch outlet details for display (assuming you have an Outlet model)
        $outlet = DB::table('outlet')->where('id', $idOutlet)->first();

        // Pass the detailed product information and outlet details to the view
        return view('User.checkout', [
            'title' => 'Checkout',
            'produks' => $detailedProducts,
            'outlet' => $outlet, // Pass the outlet information
        ]);
    }

    // 4. TAMBAH ORDERAN
    public function StoreOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // Validasi Order
            'resi' => 'nullable|string|max:13',
            'id_outlet' => 'required|integer',
            'nama_pemesan' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'tanggal_order' => 'required|date',
            'lokasi' => 'nullable|string',
            'detail_lokasi' => 'nullable|string',
            'jam_ambil' => 'nullable|date_format:H:i',
            'pembayaran' => 'nullable|string',
            'metode' => 'nullable|string',

            'total_belanja' => 'required|numeric',
            'total_barang' => 'required|integer',

            'status' => 'nullable|string',
            'catatan' => 'nullable|string',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',

            // Validasi Detail Order
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|integer',
            'items.*.subtotal' => 'required|integer',
        ]);

        if ($validator->fails()) {
            dd($validator->errors());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Mulai order database
        DB::beginTransaction();

        try {

            $resiNumber = $this->generateResi();
            $alamat_tujuan = trim($request->detail_lokasi . ', ' . $request->lokasi);

            // Simpan data order
            $order = Order::create([
                'resi' => $resiNumber,
                'id_outlet' => $request->id_outlet,
                'nama_pemesan' => $request->nama_pemesan,
                'no_telp' => $request->no_telp,
                'tanggal_order' => $request->tanggal_order,
                'alamat_tujuan' => $alamat_tujuan,
                'jam_ambil' => $request->jam_ambil,
                'pembayaran' => $request->pembayaran,
                'metode' => $request->metode,

                'total_belanja' => $request->total_belanja,
                'total_barang' => $request->total_barang,
                // 'total_keuntungan' => $request->total_keuntungan,

                'status' => 'Pending',
                'catatan' => $request->catatan,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            $totalKeuntungan = 0;

            // Simpan data detail order
            foreach ($request->items as $item) {
                $produk = Produk::find($item['product_id']);

                if ($produk) {
                    $keuntungan = ($item['subtotal'] - ($produk->harga_modal * $item['quantity']));

                    // Tambahkan keuntungan ke total keuntungan
                    $totalKeuntungan += $keuntungan;

                    DetailOrder::create([
                        'id_order' => $order->id,
                        'id_produk' => $item['product_id'],
                        'jumlah_barang' => $item['quantity'],
                        'subtotal' => $item['subtotal'],
                        'keuntungan' => $keuntungan,
                    ]);
                }
            }

            // Update transaksi dengan total keuntungan yang telah dihitung
            $order->update([
                'total_keuntungan' => $totalKeuntungan,
            ]);

            // Commit transaksi jika semua berhasil
            DB::commit();

            return response()->json(['message' => 'Order berhasil disimpan', 'resi' => $order->resi]);

        } catch (Exception $e) {
            // Log the exception and return an error response
            Log::error('Order error:', ['exception' => $e]);
            return response()->json(['error' => 'Failed to save Order: ' . $e->getMessage()], 500);
        }

    }

    // 5. WAITING ORDER
    public function WaitingOrder(Request $request, $resi)
    {

        $order = Order::where('resi', $resi)->firstOrFail();

        $detailOrder = DetailOrder::where('id_order', $order->id)->get();

        return view('User.waiting-order', [
            'title' => 'Waiting Order',
            'order' => $order,
            'detailOrder' => $detailOrder,
        ]);
    }

    // 6. MEMBUAT RESI OTOMATIS
    protected function generateResi()
    {
        function getRandomLetters($length)
        {
            $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            return substr(str_shuffle($letters), 0, $length);
        }

        function getRandomDigits($length)
        {
            $digits = '0123456789';
            return substr(str_shuffle($digits), 0, $length);
        }

        $now = new \DateTime();
        $year = $now->format('y'); // Last 2 digits of the year
        $month = $now->format('m'); // Month with leading zero

        $resiNumber = getRandomLetters(2) . $month . $year . getRandomLetters(2) . getRandomDigits(5);

        return strtoupper($resiNumber);
    }

    // 7. UPDATE STATUS ORDER
    public function UpdateStatusOrder(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
        }

        $order->status = $request->status;
        $order->save();

        if ($order->status == 'Rejected') {
            $this->WaOrderRejected($order);
        }

        if ($order->status == 'Finish') {
            if ($order->metode == 'PickUp') {
                $this->WaOrderFinishPickUp($order);
            } else {
                $this->WaOrderFinishDelivery($order);
            }
        }

        if ($order->status == 'Process') {
            $this->print($order, $order->DetailOrder);
        }

        if ($order->status == 'Completed') {  
            $this->TransferData($order->id);
        }


        return response()->json(['success' => true]);
    }

    // 8. CEK ORDER
    // Cek Waiting Order
    public function checkOrders()
    {
        $user = Auth::user();

        $hasOrders = Order::where('id_outlet', $user->id_outlet)
            ->where('status', 'Waiting')
            ->exists();

        return response()->json(['hasOrders' => $hasOrders]);
    }

    // Hitung Waiting Order
    public function getOrderCount()
    {
        $user = Auth::user();

        $orderCount = Order::where('id_outlet', $user->id_outlet)
            ->where('status', 'Waiting')
            ->count();

        return response()->json(['orderCount' => $orderCount]);
    }

    // Hitung Process Order
    public function getOrderProcessCount()
    {
        $user = Auth::user();

        $orderCount = Order::where('id_outlet', $user->id_outlet)
            ->where('status', 'Process')
            ->count();

        return response()->json(['orderCount' => $orderCount]);
    }

    public function getOrderFinishCount()
    {
        $user = Auth::user();

        $orderCount = Order::where('id_outlet', $user->id_outlet)
            ->where('status', 'Finish')
            ->count();

        return response()->json(['orderCount' => $orderCount]);
    }

    // 9. LIST WAITING ORDER
    public function ListWaitingOrders()
    {
        $user = Auth::user();
        $outlet = $user->outlet;

        $orders = Order::with('DetailOrder')
            ->where('id_outlet', $outlet->id)
            ->where('status', 'Waiting')
            ->get();

        return view('Karyawan.waiting-order', [
            'title' => 'List Order',
            'outlet' => $outlet,
            'orders' => $orders,
        ]);
    }
    // 10. LIST PROCESS ORDER
    public function ListProcessOrders()
    {
        $user = Auth::user();
        $outlet = $user->outlet;

        $orders = Order::with('DetailOrder')
            ->where('id_outlet', $outlet->id)
            ->where('status', 'Process')
            ->get();

        return view('Karyawan.process-order', [
            'title' => 'Process Order',
            'outlet' => $outlet,
            'orders' => $orders,
        ]);
    }

    // 11. LIST FINISH & COMPLETED ORDER
    public function ListFinalOrder(Request $request)
    {
        $user = Auth::user();
        $outlet = $user->outlet;

        $perPage = $request->get('per_page');

        // Filter Tanggal Transaksi
        $dateRange = $request->get('date_range');
        $startDate = null;
        $endDate = null;

        if ($dateRange) {
            // Pecahkan rentang tanggal jika ada dua tanggal (range), atau gunakan satu tanggal
            $dates = explode(" to ", $dateRange);

            if (count($dates) == 2) {
                // Jika ada 2 tanggal, tetapkan sebagai start_date dan end_date
                [$startDate, $endDate] = $dates;
            } else {
                // Jika hanya 1 tanggal, gunakan tanggal tersebut sebagai start_date dan end_date
                $startDate = $dateRange;
                $endDate = $dateRange;
            }
        }

        $query = Order::query();

        // Filter berdasarkan tanggal tertentu atau rentang tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_order', [$startDate, $endDate]);
        }

        $orders = $query->with('DetailOrder.Produk')
            ->where('id_outlet', $outlet->id)
            ->whereIn('status', ['Finish', 'Completed'])
            ->paginate($perPage);

        return view('Karyawan.completed-order', [
            'title' => 'Completed Order',
            'outlet' => $outlet,
            'orders' => $orders,
        ]);
    }

    // 12. COPY ORDER TO TRANSAKSI 
    public function TransferData($orderId){
        DB::beginTransaction();

        try {
            // Fetch the order and related detail orders
            $order = Order::with('DetailOrder')->findOrFail($orderId);

            // Copy data from order to transaksi
            $transaksi = Transaksi::create([
                'resi' => $order->resi,
                'status' => 'Selesai',
                'catatan' => $order->catatan,
                'tanggal_transaksi' => $order->tanggal_order,
                'nama_pembeli' => $order->nama_pemesan,
                'total_barang' => $order->total_barang,
                'total_belanja' => $order->total_belanja,
                'total_keuntungan' => $order->total_keuntungan,
                'id_outlet' => $order->id_outlet,
            ]);

            // Copy detail orders to detail transaksi
            foreach ($order->DetailOrder as $detailOrder) {
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $detailOrder->id_produk,
                    'jumlah_barang' => $detailOrder->jumlah_barang,
                    'subtotal' => $detailOrder->subtotal,
                    'keuntungan' => $detailOrder->keuntungan,
                    'status' => 'Normal',
                    'diskon' => 0,
                ]);
            }

            DB::commit();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    // Reject 
    public function WaOrderRejected($order)
    {
        $waNama = $order->nama_pemesan;
        $waResi = $order->resi;
        $waOrder = $order->no_telp;
        $waOutlet = $order->Outlet->nama_outlet;
        $waUid = $order->Outlet->uid;
        // $waTotal = $order->total_belanja;
        $token = 'euEVyX1WLFFji@5ipREk';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $waOrder,
                'message' => "😞 *Maaf, $waNama.* 😞\n\n" .
                    "🛑 *Pesanan Anda telah ditolak!*\n" .
                    "Mohon maaf atas ketidaknyamanan ini.\n\n" .
                    "🍽️ Silakan order kembali di:\n" .
                    "👉 https://mykantin.my.id/order/$waUid\n\n" .
                    "📝 *Kami akan berusaha lebih baik di masa depan!*\n" .
                    "📅 Terima kasih telah berbelanja di *$waOutlet*! 😊",
                'delay' => '10',
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            Log::error('WhatsApp send error:', ['error' => $error_msg]);
        }
        curl_close($curl);

        // Optionally log the response or handle it further
        Log::info('WhatsApp response:', ['response' => $response]);
    }

    // Finish PickUp
    public function WaOrderFinishPickUp($order)
    {
        $waNama = $order->nama_pemesan;
        $waResi = $order->resi;
        $waJam = $order->jam_ambil;
        $waOrder = $order->no_telp;
        $waOutlet = $order->Outlet->nama_outlet;
        // $waTotal = $order->total_belanja;
        $token = 'euEVyX1WLFFji@5ipREk';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $waOrder,
                'message' => "🎉 *Halo, $waNama!* 🎉\n\n" .
                    "*Orderan Anda telah selesai dibuat!* 🥳\n\n" .
                    "🕒 *Jangan lupa untuk mengambil pesanan Anda pada jam: $waJam.*\n\n" .
                    "🔍 Untuk cek total biaya, silakan klik tautan berikut:\n" .
                    "👉 https://mykantin.my.id/waiting-order/$waResi\n\n" .
                    "📅 Terima kasih telah berbelanja di *$waOutlet*! 😊",
                'delay' => '10',
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            Log::error('WhatsApp send error:', ['error' => $error_msg]);
        }
        curl_close($curl);

        // Optionally log the response or handle it further
        Log::info('WhatsApp response:', ['response' => $response]);
    }

    // Finish Delivery
    public function WaOrderFinishDelivery($order)
    {
        $waNama = $order->nama_pemesan;
        $waResi = $order->resi;
        $waJam = $order->jam_ambil;
        $waOrder = $order->no_telp;
        $waOutlet = $order->Outlet->nama_outlet;
        // $waTotal = $order->total_belanja;
        $token = 'euEVyX1WLFFji@5ipREk';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $waOrder,
                'message' => "🎉 *Halo, $waNama!* 🎉\n\n" .
                    "*Orderan Anda telah selesai dibuat, akan segera kami kirim ke lokasi Anda!* 🚚\n\n" .
                    "🔍 Untuk cek orderan anda, silakan klik tautan berikut:\n" .
                    "👉 https://mykantin.my.id/waiting-order/$waResi\n\n" .
                    "📅 Terima kasih telah berbelanja di *$waOutlet*! 😊",
                'delay' => '10',
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            Log::error('WhatsApp send error:', ['error' => $error_msg]);
        }
        curl_close($curl);

        // Optionally log the response or handle it further
        Log::info('WhatsApp response:', ['response' => $response]);
    }

    // PRINT THERMAL
    public function print($order, $detailOrder)
    {
        // Menghubungkan ke printer dengan nama printer
        $profile = CapabilityProfile::load('simple');
        $connector = new WindowsPrintConnector("TP806");
        $printer = new Printer($connector, $profile);

        // Nama dan informasi toko
        $tokoName = Auth::user()->Outlet->nama_outlet . "\n";
        $tokoAddress = Auth::user()->Outlet->alamat . "\n";

        // Informasi struk
        $kasir = "Nama Pembeli: " . $order->nama_pemesan;
        $tanggal = "Tanggal: " . Carbon::now()->format('d-m-Y H:i:s');
        $nomorStruk = "Nomor: " . $order->resi;
        $nomorStruk = "Metode: " . $order->metode;

        // Pengaturan format
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2, 2);
        $printer->text($tokoName . "\n");
        $printer->setTextSize(1, 1);
        $printer->text($tokoAddress . "\n\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text($kasir . "\n");
        $printer->text($tanggal . "\n");
        $printer->text($nomorStruk . "\n");
        $printer->text(str_repeat("-", 47) . "\n"); // Lebar garis diperkecil untuk memberi margin kanan

        // Header kolom barang
        $printer->setEmphasis(true);
        $printer->text(str_pad("Produk", 30) . str_pad("Total", 16, ' ', STR_PAD_LEFT) . " \n"); // Header dengan margin kanan
        $printer->setEmphasis(false);
        $printer->text(str_repeat("-", 47) . "\n"); // Garis pemisah lebih lebar

        $total = 0;
        foreach ($detailOrder as $item) {
            // Nama barang dicetak di baris pertama
            $printer->text($item->Produk->nama_produk . "\n");

            // Detail barang: Qty x Harga, Total dengan indentasi
            $qty = "  " . $item->jumlah_barang . " " . $item->Produk->Unit->nama_unit . " x " . number_format(($item->subtotal / $item->jumlah_barang), 0, ',', '.'); // Tambahan spasi untuk indentasi
            $subtotal = number_format($item->subtotal, 0, ',', '.'); // Total harga

            // Menampilkan detail barang dengan margin kanan
            $printer->text(
                str_pad($qty, 30) . // Format Qty pcs x Harga dengan indentasi
                str_pad($subtotal, 16, ' ', STR_PAD_LEFT) . " \n" // Subtotal dengan margin kanan 1 karakter
            );

            $total += $item->jumlah_barang * $item->harga_jual;
        }

        $printer->text(str_repeat("-", 47) . "\n");

        // Total
        $printer->text(str_pad("Total", 30) . str_pad(number_format($order->total_belanja, 0, ',', '.'), 16, ' ', STR_PAD_LEFT) . " \n");
        $printer->text(str_repeat("-", 47) . "\n");
        $printer->setEmphasis(true);
        $printer->text(str_pad("Total Belanja", 30) . str_pad(number_format($order->total_belanja, 0, ',', '.'), 16, ' ', STR_PAD_LEFT) . " \n");
        $printer->setEmphasis(false);

        // Catatan (Notes)
        $printer->text("Catatan:\n");
        $printer->text($order->catatan . "\n"); // Assuming $order->catatan is a string containing notes

        $printer->feed(); // Add a feed for better spacing before cutting

        //$printer->text(str_pad($method == 'debt' ? 'Catat Hutang' : $method, 30) . str_pad(number_format($payment, 0, ',', '.'), 16, ' ', STR_PAD_LEFT) . " \n");
        // if ($method == 'cash') {
        //     $printer->text(str_pad("Kembali", 30) . str_pad(number_format($payment - $cart->total_belanja, 0, ',', '.'), 16, ' ', STR_PAD_LEFT) . " \n");
        // }
        // $printer->text(str_repeat("-", 47) . "\n\n");

        // Ucapan terima kasih
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Terima Kasih Atas Kunjungan Anda!\n");
        // $printer->text("Barang yang sudah dibeli tidak dapat\n");
        // $printer->text("dikembalikan.\n");
        $printer->feed();
        $printer->text("CSR By PT. SUCOFINDO CILACAP\n");
        $printer->text("--- SUCOFINDO untuk UMKM ---\n");
        $printer->feed(3); // Jarak sebelum potong kertas
        $printer->cut();
        $printer->close();
    }






}
