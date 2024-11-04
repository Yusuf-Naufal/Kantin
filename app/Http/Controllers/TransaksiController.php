<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Transaksi;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class TransaksiController extends Controller
{
    // KONTROL TAMPILAN 
    // ADMIN 
    // 1. Tampilan Riwayat Transaksi

    public function AdminIndexTransaksi(Request $request)
    {
        $perPage = $request->get('per_page', 10);

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

        $query = Transaksi::query();

        // Filter berdasarkan tanggal tertentu atau rentang tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }

        $transaksi = $query
            ->orderBy('tanggal_transaksi','desc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('Admin.transaksi.transaksi-index', [
            'transaksis' => $transaksi,
            'title' => 'Riwayat Transaksi'
        ]);
    }

    // 2. Tampilan Edit Transaksi
    public function AdminEditTransaksi($resi)
    {
        // Cari transaksi berdasarkan resi
        $transaksi = Transaksi::with('DetailTransaksi.Produk')
            ->where('resi', $resi)
            ->firstOrFail();

        // Ambil ID outlet dari transaksi yang ditemukan
        $OutletId = $transaksi->id_outlet;

        // Ambil ID produk yang sudah ada di dalam transaksi
        $produkIdsInTransaksi = $transaksi->DetailTransaksi->pluck('Produk.id');

        // Ambil semua produk yang belum ada dalam transaksi
        $produksYangBelumAda = Produk::where('id_outlet', $OutletId)
            ->whereNotIn('id', $produkIdsInTransaksi)
            ->get();

        // Ambil semua produk di outlet tersebut
        $semuaProduks = Produk::where('id_outlet', $OutletId)->get();

        return view('Admin.transaksi.edit-transaksi', [
            'transaksi' => $transaksi,
            'detailTransaksi' => $transaksi->DetailTransaksi,
            'semuaProduks' => $semuaProduks,
            'produksYangBelumAda' => $produksYangBelumAda,
            'title' => 'Edit Transaksi',
        ]);
    }

    // PEMILIK 

    // 1. Tampilan Riwayat Transaksi 

    public function MasterIndexTransaksi(Request $request){
        $IdOutlet = Auth::user()->id_outlet;
        $perPage = $request->get('per_page', 10);

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

        $query = Transaksi::query();

        // Filter berdasarkan tanggal tertentu atau rentang tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }

        $transaksi = $query-> where('id_outlet', $IdOutlet)
                ->orderBy('tanggal_transaksi','desc')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

        return view('Pemilik.transaksi.transaksi', [
            'transaksis' => $transaksi,
            'title' => 'Riwayat Transaksi'
        ]);
    }
    
    // . Tampil Form Edit Transaksi 

    public function MasterEditTransaksi($resi)
    {
        $OutletId = Auth::user()->id_outlet;

        // Fetch the transaction and its details
        $transaksi = Transaksi::with('DetailTransaksi.Produk')->where('resi', $resi)->where('id_outlet', $OutletId)->firstOrFail();

        // Ambil ID produk yang sudah ada di dalam transaksi
        $produkIdsInTransaksi = $transaksi->DetailTransaksi->pluck('produk.id');

        // Ambil semua produk yang belum ada dalam transaksi
        $produksYangBelumAda = Produk::where('id_outlet', $OutletId)
            ->whereNotIn('id', $produkIdsInTransaksi)
            ->get();

        // Ambil semua produk tanpa filter
        $semuaProduks = Produk::where('id_outlet', $OutletId)->get();



        return view('Pemilik.transaksi.edit-transaksi', [
            'transaksi' => $transaksi,
            'detailTransaksi' => $transaksi->DetailTransaksi,
            'semuaProduks' => $semuaProduks,
            'produksYangBelumAda' => $produksYangBelumAda,
            'title' => 'Edit Transaksi',
        ]);

    }

    public function FilterTransaksiProduk(Request $request){

        $IdOutlet = Auth::user()->id_outlet;

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

        $query = Transaksi::query();

        // Filter berdasarkan tanggal tertentu atau rentang tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }

        // Query to get sold product details
        $details = DB::table('detail_transaksi')
            ->join('transaksi', 'detail_transaksi.id_transaksi', '=', 'transaksi.id')
            ->join('produk', 'detail_transaksi.id_produk', '=', 'produk.id')
            ->whereBetween('transaksi.tanggal_transaksi', [$startDate, $endDate])
            ->where('transaksi.id_outlet', $IdOutlet)
            ->select(
                'produk.nama_produk as nama_produk',
                DB::raw('SUM(detail_transaksi.jumlah_barang) as total_barang'), // Aggregate quantity
                DB::raw('SUM(detail_transaksi.subtotal) as subtotal') // Aggregate subtotal
            )
            ->groupBy('produk.nama_produk')
            ->orderBy('produk.nama_produk')
            ->get();

        return view('Pemilik.produk.filter-produk-terjual', [
            'title' => 'Find Produk Sell',
            'details' => $details,
            'dateRange' => $dateRange,
        ]);
    }


    // PEMILIK DAN ADMIN
    // 1. Menampilkan Detail Transaksi
    public function DetailTransaksi($resi)
    {
        $transaksi = Transaksi::where('resi', $resi)->firstOrFail();

        // Retrieve the transaction details, such as detail_transaksi
        $detailTransaksi = DetailTransaksi::with('Produk')
            ->join('produk', 'detail_transaksi.id_produk', '=', 'produk.id')
            ->where('detail_transaksi.id_transaksi', $transaksi->id)
            ->orderBy('produk.nama_produk', 'asc')
            ->select('detail_transaksi.*')
            ->get();

        if (Auth::user()->role === 'Admin') {
            return view('Admin.transaksi.detail-transaksi', [
                'transaksi' => $transaksi,
                'detailTransaksis' => $detailTransaksi,
                'title' => 'Detail Transaksi'
            ]);
        } else {
            return view('Pemilik.transaksi.detail-transaksi', [
                'transaksi' => $transaksi,
                'detailTransaksis' => $detailTransaksi,
                'title' => 'Detail Transaksi'
            ]);
        }
    }


    // KONTROL QUERY
    // KARYAWAN DAN PEMILIK 
    // 1. Tambah Transaksi dan DetailTransaksi
    
    public function StoreTransaksi(Request $request)
    {
        try {
            $validated = $request->validate([
                'resi' => 'required|string|max:13',
                'tanggal_transaksi' => 'required|date',
                'total_barang' => 'required|integer',
                'total_belanja' => 'required|numeric',
                'nama_pembeli' => 'nullable|string',
                'catatan' => 'nullable|string',
                'id_outlet' => 'required|integer',
                'status' => 'required|string',
                'orderItems' => 'required|array',
                'orderItems.*.productId' => 'required|integer',
                'orderItems.*.jumlah_barang' => 'required|integer',
                'orderItems.*.subtotal' => 'required|numeric',
            ]);


            // DB::transaction(function () use ($validated) {
                // Insert into transaksi
                $transaksi = Transaksi::create([
                    'resi' => $validated['resi'],
                    'tanggal_transaksi' => $validated['tanggal_transaksi'],
                    'total_barang' => $validated['total_barang'],
                    'total_belanja' => $validated['total_belanja'],
                    'nama_pembeli' => $validated['nama_pembeli'],
                    'catatan' => $validated['catatan'],
                    'id_outlet' => $validated['id_outlet'],
                    'status' => $validated['status'],
                ]);

                // Inisialisasi total keuntungan
                $totalKeuntungan = 0;

                // Insert into detail_transaksi
                foreach ($validated['orderItems'] as $item) {
                    // Ambil produk berdasarkan id_produk
                    $produk = Produk::find($item['productId']);

                    if ($produk) {
                        // Hitung keuntungan: (harga jual - harga modal) * jumlah barang
                        $keuntungan = ($item['subtotal'] - ($produk->harga_modal * $item['jumlah_barang']));

                        // Tentukan status untuk DetailTransaksi
                        if($produk->status == 'Aktif' || $produk->status == 'Baru'){
                            $status = 'Normal';
                        }else{
                            $status = $produk->status;
                        }

                        $diskon = $produk->diskon;

                        // Tambahkan keuntungan ke total keuntungan
                        $totalKeuntungan += $keuntungan;

                        // Simpan detail transaksi termasuk keuntungan
                        $detailTransaksi = DetailTransaksi::create([
                            'id_transaksi' => $transaksi->id,
                            'id_produk' => $item['productId'],
                            'jumlah_barang' => $item['jumlah_barang'],
                            'subtotal' => $item['subtotal'],
                            'keuntungan' => $keuntungan, 
                            'status' => $status,
                            'diskon' => $diskon,
                        ]);
                    }
                }

                // Update transaksi dengan total keuntungan yang telah dihitung
                $transaksi->update([
                    'total_keuntungan' => $totalKeuntungan,
                ]);

            // });

            $this->print($transaksi, $transaksi->DetailTransaksi, $transaksi->resi);

            return response()->json(['message' => 'Transaction saved successfully']);
        } catch (Exception $e) {
            // Log the exception and return an error response
            Log::error('Transaction error:', ['exception' => $e]);
            return response()->json(['error' => 'Failed to save transaction'], 500);
        }
    }
    

    // PEMILIK DAN ADMIN
    // 1. Update data Transaksi dan DetailTransaksi
    public function UpdateTransaksi(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'produk' => 'required|array',
                'produk.*.id' => 'required|exists:produk,id',
                'produk.*.jumlah_barang' => 'required|integer|min:1',
                'produk.*.status' => 'nullable|string',  // Validate product status
                'produk.*.diskon' => 'nullable|numeric|min:0|max:100',  // Validate discount as a percentage
                'tanggal_transaksi' => 'required|date',
                'catatan' => 'nullable|string',
                'nama_pembeli' => 'nullable|string',
            ]);

            DB::transaction(function () use ($validatedData, $id) {
                DetailTransaksi::where('id_transaksi', $id)->delete();

                foreach ($validatedData['produk'] as $item) {
                    $product = Produk::find($item['id']);
                    if (!$product) {
                        throw new \Exception("Product with ID {$item['id']} not found.");
                    }

                    $price = $product->harga_jual;
                    $qty = $item['jumlah_barang'];
                    $subtotal = $price * $qty;
                    $untung = $subtotal - ($qty * $product->harga_modal);

                    // Check if the status is 'Diskon' and apply discount
                    if (isset($item['status']) && $item['status'] === 'Diskon') {
                        $diskon = isset($item['diskon']) ? floatval($item['diskon']) : 0; // Get the discount
                        if ($diskon > 0 && $diskon <= 100) {
                            $subtotal -= ($subtotal * ($diskon / 100));
                            $untung = $subtotal - ($qty * $product->harga_modal); // Apply discount
                        }
                    }

                    DetailTransaksi::create([
                        'id_transaksi' => $id,
                        'id_produk' => $item['id'],
                        'jumlah_barang' => $qty,
                        'subtotal' => $subtotal,
                        'keuntungan' => $untung,
                        'status' => $item['status'] ?? 'default_status',  // Default if no status
                        'diskon' => $item['diskon'] ?? 0,  // Default if no discount provided
                    ]);
                }

                // Calculate totals
                $totalQty = DetailTransaksi::where('id_transaksi', $id)->sum('jumlah_barang');
                $totalBelanja = DetailTransaksi::where('id_transaksi', $id)
                    ->join('produk', 'detail_transaksi.id_produk', '=', 'produk.id')
                    ->sum('subtotal'); // Use subtotal directly for total shopping amount
                $totalUntung = DetailTransaksi::where('id_transaksi', $id)
                    ->join('produk', 'detail_transaksi.id_produk', '=', 'produk.id')
                    ->sum('keuntungan'); // Use subtotal directly for total shopping amount



                $transaksi = Transaksi::findOrFail($id);
                $transaksi->catatan = $validatedData['catatan'];
                $transaksi->nama_pembeli = $validatedData['nama_pembeli'];
                $transaksi->tanggal_transaksi = $validatedData['tanggal_transaksi'];
                $transaksi->total_barang = $totalQty;
                $transaksi->total_belanja = $totalBelanja;
                $transaksi->total_keuntungan = $totalUntung;
                $transaksi->save();
            });

            return response()->json(['message' => 'Transaksi Berhasil Diupdate!!']);
        } catch (Exception $e) {
            Log::error('Error updating transaksi for ID ' . $id . ': ' . $e->getMessage());
            return response()->json(['message' => 'Error updating transaksi'], 500);
        }

    }

    // 2. Ubah status Transaksi
    public function UpdateStatusTransaksi(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'catatan' => 'required|string',
                'status' => 'nullable|string',
            ]);

            // Debug: Pastikan ID transaksi ditemukan
            $transaksi = Transaksi::findOrFail($id);

            // Debug: Periksa apakah transaksi benar-benar ditemukan
            if (!$transaksi) {
                return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
            }

            // Lakukan perubahan status transaksi dan catatan
            $transaksi->catatan = $validatedData['catatan'];
            $transaksi->status = $validatedData['status'];
            $transaksi->save(); // Jangan lupa simpan perubahan!


            return response()->json(['success' => true, 'message' => 'Transaksi Berhasil Diubah!!']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error Status Pesanan'], 500);
        }
    }

    // 3. Hapus Transaksi
    public function DestroyTransaksi($id){
        try {
            // Find the transaction by ID
            $transaksi = Transaksi::findOrFail($id);

            $transaksi->DetailTransaksi()->delete();

            $transaksi->delete();

            if (Auth::user()->role === 'Admin') {
                return redirect()->route('')->with('success', 'Transaction Berhasil Dihapus!');
            } else {
                // Redirect with a success message
                return redirect()->route('pemilik-transaksi')->with('success', 'Transaksi Berhasil Dihapus!');
            }
        }catch(Exception $e){
            return back()->with('error','Transaksi gagal dihapus');
        }
    }

    // 4. Konvert to PDF
    public function ExportToPDF($id)
    {
        // Retrieve the transaksi record by its ID
        $transaksi = Transaksi::with('DetailTransaksi', 'Outlet')->findOrFail($id);

        // Load the view with the data
        $pdf = Pdf::loadView('Pemilik.transaksi.pdf-layout', [
            'transaksi' => $transaksi,
            'detailTransaksis' => $transaksi->DetailTransaksi,
        ]);

        // Return the PDF for download
        return $pdf->download('transaksi_' . $transaksi->resi . '.pdf');
    }

    // PRINT THERMAL
    public function print($transaksi, $detailTransaksi, $resi)
    {
        // Menghubungkan ke printer dengan nama printer
        $profile = CapabilityProfile::load('simple');
        $connector = new WindowsPrintConnector("TP806");
        $printer = new Printer($connector, $profile);

        // Nama dan informasi toko
        $tokoName = Auth::user()->Outlet->nama_outlet . "\n";
        $tokoAddress = Auth::user()->Outlet->alamat . "\n";

        // Informasi struk
        $kasir = "Nama Pembeli: " . $transaksi->nama_pembeli;
        $tanggal = "Tanggal: " . Carbon::now()->format('d-m-Y H:i:s');
        $nomorStruk = "Nomor: " . $resi;        

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
        foreach ($detailTransaksi as $item) {
            // Nama barang dicetak di baris pertama
            $printer->text($item->Produk->nama_produk . "\n");

            // Detail barang: Qty x Harga, Total dengan indentasi
            $qty = "  " . $item->jumlah_barang . " ". $item->Produk->Unit->nama_unit ." x " . number_format($item->Produk->harga_jual, 0, ',', '.'); // Tambahan spasi untuk indentasi
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
        $printer->text(str_pad("Total", 30) . str_pad(number_format($transaksi->total_belanja, 0, ',', '.'), 16, ' ', STR_PAD_LEFT) . " \n");
        $printer->text(str_repeat("-", 47) . "\n");
        $printer->setEmphasis(true);
        $printer->text(str_pad("Total Belanja", 30) . str_pad(number_format($transaksi->total_belanja, 0, ',', '.'), 16, ' ', STR_PAD_LEFT) . " \n");
        $printer->setEmphasis(false);

        // Catatan (Notes)
        $printer->text("Catatan:\n");
        $printer->text($transaksi->catatan . "\n"); // Assuming $transaksi->catatan is a string containing notes

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
