<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Outlet;
use App\Models\Produk;
use App\Models\Pengajuan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // ADMIN DASHBOARD 
    public function AdminDashboard()
    {
        $allUser = User::count();
        $allOutlet = Outlet::count();
        $allProduk = Produk::count();
        $allPengajuan = Pengajuan::where('status', 'Pending')->count();

        $outlets = Outlet::all();

        $penghasilanPerOutlet = [];
        $totalPenghasilan = 0;

        foreach ($outlets as $outlet) {
            // 1. Penghasilan total tiap outlet
            $penghasilanOutlet = Transaksi::where('id_outlet', $outlet->id)
                ->sum('total_belanja');

            $penghasilanPerOutlet[] = [
                'nama_outlet' => $outlet->nama_outlet,
                'penghasilan' => $penghasilanOutlet
            ];

            $totalPenghasilan += $penghasilanOutlet;
        }

        $totalpenghasilan = Transaksi::sum('total_belanja');

        // Mendapatkan penghasilan tertinggi minggu ini
        $penghasilanTertinggi = Transaksi::whereBetween('tanggal_transaksi', [now()->startOfWeek(), now()->endOfWeek()])
            ->orderBy('total_belanja', 'desc') // Mengurutkan berdasarkan total_belanja secara menurun
            ->first();

        // Menghitung penghasilan per minggu
        $penghasilanTiapMinggu = [];
        $startDate = now()->startOfMonth(); // Awal bulan ini
        $weeksInMonth = now()->endOfMonth()->weekOfMonth; // Total minggu dalam bulan ini

        for ($i = 0; $i < $weeksInMonth; $i++) {
            $weekStart = $startDate->copy()->addWeeks($i)->startOfWeek(); // Awal minggu
            $weekEnd = $startDate->copy()->addWeeks($i)->endOfWeek(); // Akhir minggu

            // Hitung total penghasilan untuk minggu ini
            $totalPenghasilanMinggu = Transaksi::whereBetween('tanggal_transaksi', [$weekStart, $weekEnd])
                ->sum('total_belanja');

            $penghasilanTiapMinggu[] = [
                'minggu' => $i + 1,
                'total_penghasilan' => $totalPenghasilanMinggu,
                'periode' => $weekStart->format('d M') . ' - ' . $weekEnd->format('d M Y'),
            ];
        }

        // Sort by penghasilan terbesar - terkecil
        usort($penghasilanPerOutlet, function ($a, $b) {
            return $b['penghasilan'] <=> $a['penghasilan'];
        });

        return view('Admin.dashboard', [
            'title' => 'Dashboard Admin',
            'outlets' => $outlets,
            'AllUser' => $allUser,
            'AllOutlet' => $allOutlet,
            'AllProduk' => $allProduk,
            'AllPengajuan' => $allPengajuan,
            'PenghasilanOutlet' => $penghasilanPerOutlet,
            'TotalPenghasilan' => $totalpenghasilan,
            'PenghasilanTertinggi' => $penghasilanTertinggi,
            'PenghasilanTiapMinggu' => $penghasilanTiapMinggu,
        ]);
    }

    public function GrafikPenghasilanOutlet(Request $request)
    {
        $periode = $request->get('periode', 'minggu');
        $startDate = null;
        $endDate = null;

        // Tentukan startDate dan endDate berdasarkan periode yang dipilih
        switch ($periode) {
            case 'bulan':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'tahun':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
            default:
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
        }

        $dateRange = [];

        if ($periode === 'tahun') {
            // Untuk periode 'tahun', gunakan label bulanan (contoh: Januari, Februari)
            $date = $startDate->copy();
            while ($date->lte($endDate)) {
                $dateRange[] = $date->format('F'); // Nama bulan
                $date->addMonth();
            }

            // Query untuk mengambil data penghasilan berdasarkan bulan dan outlet
            $query = DB::table('transaksi')
                ->select(DB::raw('DATE_FORMAT(tanggal_transaksi, "%M") as label, id_outlet, SUM(total_belanja) as total_penghasilan, COUNT(id) as total_transaksi'))
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->groupBy('label', 'id_outlet');

        } else {
            // Untuk periode selain 'tahun', gunakan label harian
            $date = $startDate->copy();
            while ($date->lte($endDate)) {
                $dateRange[] = $date->format('Y-m-d'); // Format harian
                $date->addDay();
            }

            // Query untuk mengambil data penghasilan berdasarkan hari dan outlet
            $query = DB::table('transaksi')
                ->select(DB::raw('DATE(tanggal_transaksi) as label, id_outlet, SUM(total_belanja) as total_penghasilan, COUNT(id) as total_transaksi'))
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->groupBy('label', 'id_outlet');
        }

        $data = $query->get()->groupBy('id_outlet');

        // Ambil nama outlet dari tabel 'outlet'
        $outlets = DB::table('outlet')->get()->keyBy('id');

        // Hasilkan data per outlet
        $result = [];
        foreach ($data as $id_outlet => $transactions) {
            $outletName = isset($outlets[$id_outlet]) ? $outlets[$id_outlet]->nama_outlet : 'Unknown Outlet';

            // Isi tanggal atau bulan yang tidak ada transaksi dengan 0
            $filledData = array_map(function ($date) use ($transactions) {
                $transaction = $transactions->firstWhere('label', $date);
                return [
                    'label' => $date,
                    'total_penghasilan' => $transaction->total_penghasilan ?? 0,
                    'total_transaksi' => $transaction->total_transaksi ?? 0
                ];
            }, $dateRange);

            $result[] = [
                'nama_outlet' => $outletName,
                'data' => $filledData
            ];
        }

        return response()->json($result);
    }



    // MASTER DASHBOARD
    public function MasterDashboard()
    {
        $user = Auth::user();
        $outlet = Outlet::where('id', $user->id_outlet)->first();
        $today = now()->format('Y-m-d');

        // Penghasilan Hari ini
        $pendapatanHariIni = Transaksi::where('id_outlet', $user->id_outlet)
            ->whereDate('tanggal_transaksi', $today)
            ->sum('total_belanja');

        // Keuntungan Hari ini
        $keuntunganHariIni = Transaksi::where('id_outlet', $user->id_outlet)
            ->whereDate('tanggal_transaksi', $today)
            ->sum('total_keuntungan');

        // Produk yang terjual hari ini
        $produkTerjual = DetailTransaksi::whereHas('Transaksi', function ($query) use ($today, $user) {
            $query->whereDate('tanggal_transaksi', $today)
                ->where('id_outlet', $user->id_outlet);
        })
            ->select('id_produk', DB::raw('SUM(jumlah_barang) as total_terjual'))
            ->groupBy('id_produk')
            ->get();

        return view('Pemilik.dashboard', [
            'title' => 'Dashboard Master',
            'outlet' => $outlet,
            'TransaksiHariIni' => $pendapatanHariIni,
            'KeuntunganHariIni' => $keuntunganHariIni,
            'ProdukTerjual' => $produkTerjual,
        ]);
    }

    public function GrafikOutlet(Request $request)
    {
        $periode = $request->get('periode', 'hari');
        $startDate = null;
        $endDate = null;

        switch ($periode) {
            case 'minggu':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case 'bulan':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'tahun':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
            default:
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
        }

        // Generate date range
        $dateRange = [];

        if ($periode === 'tahun') {
            // For 'tahun', generate month labels (e.g., January, February)
            $date = $startDate->copy();
            while ($date->lte($endDate)) {
                $dateRange[] = $date->format('F'); // Format month as full name
                $date->addMonth();
            }

            // Adjust the query for grouping by month
            $query = DB::table('transaksi')
                ->select(DB::raw('DATE_FORMAT(tanggal_transaksi, "%M") as label, SUM(total_belanja) as total_penghasilan, COUNT(id) as total_transaksi'))
                ->groupBy('label')
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->where('id_outlet', Auth::user()->id_outlet);
        } else {
            // For other periods (hari, minggu, bulan), use daily labels
            $date = $startDate->copy();
            while ($date->lte($endDate)) {
                $dateRange[] = $date->format('Y-m-d');
                $date->addDay();
            }

            $query = DB::table('transaksi')
                ->select(DB::raw('DATE(tanggal_transaksi) as label, SUM(total_belanja) as total_penghasilan, COUNT(id) as total_transaksi'))
                ->groupBy('label')
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->where('id_outlet', Auth::user()->id_outlet);
        }

        $data = $query->get()->keyBy('label');

        // Fill missing dates or months with zero values
        $result = array_map(function ($date) use ($data) {
            return $data->get($date, (object) [
                'label' => $date,
                'total_penghasilan' => 0,
                'total_transaksi' => 0
            ]);
        }, $dateRange);

        return response()->json($result);
    }




    // POS DASHBOARD / KARYAWAN DASHBOARD
    public function KasirDashboard()
    {
        $user = Auth::user();

        // Dapatkan outlets yang terkait dengan pengguna ini
        $outlet = $user->outlet;


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

        return view('Karyawan.dashboard', [
            'outlet' => $outlet,
            'User' => $user,
            'Produk' => $produks,
            'groupedProduks' => $groupedProduks,
            'title' => 'Kasir',
        ]);
    }




    // HOME DASHBOARD 
    public function HomeDashboard()
    {

        $produkPromo = Produk::where('status', 'Promo')->get();

        $produkDiskon = Produk::where('status', 'Diskon')->get();

        $produkFavorit = Produk::with(['DetailTransaksi', 'Kategori', 'Outlet'])
            ->select('produk.*', DB::raw('SUM(detail_transaksi.jumlah_barang) as total_barang'))
            ->join('detail_transaksi', 'produk.id', '=', 'detail_transaksi.id_produk')
            ->groupBy('produk.id')
            ->having('total_barang', '>', 100)
            ->orderBy('id_kategori')
            ->orderBy('total_barang', 'desc')
            ->orderBy('nama_produk', 'asc')
            ->get()
            ->groupBy('id_kategori')
            ->map(function ($items) {
                return $items->take(2);
            });


        return view('home', [
            'title' => 'My Kantin',
            'promos' => $produkPromo,
            'diskons' => $produkDiskon,
            'favorits' => $produkFavorit,
        ]);
    }

    // DAFTAR OUTLET 
    public function DaftarOutlet()
    {
        $outlet = Outlet::with([
            'Produk' => function ($query) {
                // Get products ordered by total sales from detail_transaksi
                $query->select('produk.*')
                    ->join('detail_transaksi', 'produk.id', '=', 'detail_transaksi.id_produk')
                    ->selectRaw('SUM(detail_transaksi.jumlah_barang) as total_barang') // Sum of sold quantities
                    ->groupBy('produk.id')
                    ->havingRaw('SUM(detail_transaksi.jumlah_barang) > 0') // Filter out products not sold
                    ->take(8); // Limit to top 10 products
            }
        ])->get();


        return view('User.daftar-outlet', [
            'title' => 'Daftar Outlet',
            'outlets' => $outlet,
        ]);
    }

    public function DaftarProduk()
    {
        $produks = Produk::all(); // Retrieve all products
        return view('User.daftar-produk', [
            'title' => 'Daftar Produk',
            'produks' => $produks, // Pass the products to the view
        ]);
    }

    public function SearchProduk(Request $request)
    {
        $searchQuery = $request->input('search');
        $produks = Produk::where('nama_produk', 'like', '%' . $searchQuery . '%')->get();

        return view('User.daftar-produk', [
            'title' => 'Daftar Produk',
            'produks' => $produks, // Pass the filtered products to the view
        ]);
    }



}
