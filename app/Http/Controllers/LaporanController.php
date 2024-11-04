<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function MasterLaporan(){

        $user = Auth::user();
        $outlet = Outlet::where('id', $user->id_outlet)->first();
        $today = now()->format('Y-m-d');

        $produks = Produk::where('id_outlet', $outlet->id)->get();

        if ($outlet) {
            $produkOutlet = Produk::where('id_outlet', $outlet->id)
                ->count();

            $transaksiOutlet = Transaksi::where('id_outlet', $outlet->id)
                ->count();

            $pendapatanOutlet = Transaksi::where('id_outlet', $outlet->id)
                ->sum('total_belanja');

            $keuntunganOutlet = Transaksi::where('id_outlet', $outlet->id)
                ->sum('total_keuntungan');


            $topProdukTerjual = DetailTransaksi::whereHas('Transaksi', function ($query) use ($user) {
                $query->where('id_outlet', $user->id_outlet);
            })
                ->select('id_produk', DB::raw('SUM(jumlah_barang) as total_terjual'))
                ->groupBy('id_produk')
                ->get();
        }




        return view('Pemilik.laporan.laporan', [
            'title' => 'Laporan Outlet',
            'Produk' => $produks,
            'ProdukOutlet' => $produkOutlet,
            'TransaksiOutlet' => $transaksiOutlet,
            'PendapatanOutlet' => $pendapatanOutlet,
            'KeuntunganOutlet' => $keuntunganOutlet,
            'TopProdukTerjual' => $topProdukTerjual,
        ]);
    }

    public function ProdukTerjual(Request $request)
    {
        $productId = $request->input('product');
        $period = $request->input('period');

        // Define start and end dates based on the selected period
        switch ($period) {
            case 'minggu':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case 'bulan':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'hari': // For today
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
            default: // Fallback if no valid period
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
        }

        // Generate all dates in the range
        $dateRange = [];
        $date = $startDate->copy();
        while ($date->lte($endDate)) {
            $dateRange[] = $date->format('Y-m-d');
            $date->addDay();
        }

        // Group by date and calculate total quantity sold
        $data = DetailTransaksi::join('transaksi', 'detail_transaksi.id_transaksi', '=', 'transaksi.id')
            ->where('detail_transaksi.id_produk', $productId)
            ->whereBetween('transaksi.tanggal_transaksi', [$startDate, $endDate])
            ->selectRaw('DATE(transaksi.tanggal_transaksi) as date, SUM(detail_transaksi.jumlah_barang) as total_barang')
            ->groupBy('date')
            ->get()
            ->keyBy('date'); // Use date as key for easy access

        // Prepare final data with all dates, filling missing dates with zero
        $result = [];
        foreach ($dateRange as $date) {
            $totalQty = $data->has($date) ? $data->get($date)->total_barang : 0; // Default to 0 if no data
            $result[] = [
                'date' => $date,
                'total_barang' => $totalQty
            ];
        }

        return response()->json($result);
    }

    public function KalenderPendapatan(Request $request)
    {
        $user = Auth::user();
        $outlet = $user->outlet;

        $pendapatan = DB::table('transaksi')
            ->where('id_outlet', $outlet->id)
            ->select(
                DB::raw('DATE(tanggal_transaksi) as date'),
                DB::raw('SUM(total_belanja) as total_belanja')
            )
            ->groupBy('date')
            ->orderBy('date') // Optional: to sort the dates
            ->get();

        // Map earnings data to FullCalendar's event format
        $events = $pendapatan->map(function ($earning) {
            return [
                'title' => $earning->total_belanja, // Format as needed
                'start' => $earning->date,
                'allDay' => true
            ];
        });

        return response()->json($events);
    }

    public function getTransactionDetails(Request $request)
    {
        $user = Auth::user();
        $date = $request->query('date');

        $details = DB::table('detail_transaksi')
            ->join('transaksi', 'detail_transaksi.id_transaksi', '=', 'transaksi.id')
            ->join('produk', 'detail_transaksi.id_produk', '=', 'produk.id')
            ->whereDate('transaksi.tanggal_transaksi', $date)
            ->where('transaksi.id_outlet', $user->id_outlet)
            ->select(
                'produk.nama_produk as nama_produk',
                DB::raw('SUM(detail_transaksi.jumlah_barang) as total_barang'), // Aggregate quantity
                DB::raw('SUM(detail_transaksi.subtotal) as subtotal'), // Aggregate subtotal
                'detail_transaksi.status as status'
            )
            ->groupBy('produk.nama_produk', 'detail_transaksi.status') // Grouping by product name and status
            ->orderBy('produk.nama_produk') // Optional: Order by product name for better readability
            ->get();

        return response()->json($details);
    }


}
