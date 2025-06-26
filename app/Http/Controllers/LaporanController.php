<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Penjualan;
use App\Models\DetailPenjualanProduk;
use App\Models\Produk;
use App\Models\Kategori;
use Symfony\Component\HttpFoundation\StreamedResponse; 

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
        }

        $totalPendapatan = Penjualan::whereBetween('tanggal_penjualan', [$startDate, $endDate])->sum('total_pendapatan');
        $totalKeuntungan = Penjualan::whereBetween('tanggal_penjualan', [$startDate, $endDate])->sum('total_keuntungan');

        $keuntunganHarian = Penjualan::select(
            DB::raw('DATE(tanggal_penjualan) as tanggal'),
            DB::raw('SUM(total_pendapatan) as total_pendapatan_harian'),
            DB::raw('SUM(total_keuntungan) as total_keuntungan_harian')
        )
        ->whereBetween('tanggal_penjualan', [$startDate, $endDate])
        ->groupBy(DB::raw('DATE(tanggal_penjualan)'))
        ->orderBy('tanggal', 'desc')
        ->take(5)
        ->get()
        ->sortBy('tanggal')
        ->values();

        $keuntunganMingguan = Penjualan::select(
        DB::raw("YEAR(tanggal_penjualan) as tahun"),
        DB::raw("WEEK(tanggal_penjualan, 1) as minggu_ke"),
        DB::raw("SUM(total_pendapatan) as total_pendapatan_mingguan"),
        DB::raw("SUM(total_keuntungan) as total_keuntungan_mingguan")
        )
        ->whereBetween('tanggal_penjualan', [$startDate, $endDate])
        ->groupBy('tahun', 'minggu_ke')
        ->orderBy('tahun', 'desc')
        ->orderBy('minggu_ke', 'desc')
        ->take(5)
        ->get()
        ->sortBy(function ($item) {
            return $item->tahun . '-' . str_pad($item->minggu_ke, 2, '0', STR_PAD_LEFT);
        })
        ->values();

        $keuntunganBulanan = Penjualan::select(
        DB::raw("YEAR(tanggal_penjualan) as tahun"),
        DB::raw("MONTH(tanggal_penjualan) as bulan"),
        DB::raw("SUM(total_pendapatan) as total_pendapatan_bulanan"),
        DB::raw("SUM(total_keuntungan) as total_keuntungan_bulanan")
        )
        ->whereBetween('tanggal_penjualan', [$startDate, $endDate])
        ->groupBy('tahun', 'bulan')
        ->orderBy('tahun', 'desc')
        ->orderBy('bulan', 'desc')
        ->take(5)
        ->get()
        ->sortBy(function ($item) {
            return $item->tahun . '-' . str_pad($item->bulan, 2, '0', STR_PAD_LEFT);
        })
        ->values();


        $produkTerlaris = DetailPenjualanProduk::select(
                'produk.nama_produk',
                DB::raw('SUM(detail_penjualan_produk.jumlah_terjual) as total_terjual')
            )
            ->join('produk', 'detail_penjualan_produk.id_produk', '=', 'produk.id')
            ->join('penjualan', 'detail_penjualan_produk.id_penjualan', '=', 'penjualan.id')
            ->whereBetween('penjualan.tanggal_penjualan', [$startDate, $endDate])
            ->groupBy('produk.nama_produk')
            ->orderBy('total_terjual', 'desc')
            ->limit(5)
            ->get();
        
        $kategoriTerlaris = DetailPenjualanProduk::select(
                'kategori.nama_kategori',
                DB::raw('SUM(detail_penjualan_produk.jumlah_terjual) as total_terjual_kategori')
            )
            ->join('produk', 'detail_penjualan_produk.id_produk', '=', 'produk.id')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->join('penjualan', 'detail_penjualan_produk.id_penjualan', '=', 'penjualan.id')
            ->whereBetween('penjualan.tanggal_penjualan', [$startDate, $endDate])
            ->groupBy('kategori.nama_kategori')
            ->orderBy('total_terjual_kategori', 'desc')
            ->limit(5)
            ->get();

        return view('laporan.index', compact(
            'totalPendapatan',
            'totalKeuntungan',
            'keuntunganHarian',
            'keuntunganMingguan',
            'keuntunganBulanan',
            'produkTerlaris',
            'kategoriTerlaris',
            'startDate',
            'endDate'
        ));
    }

    public function showProfitReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'period' => 'required|in:daily,weekly,monthly',
        ]);

        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));
        $period = $request->input('period');

        $query = Penjualan::select(
            DB::raw('SUM(total_pendapatan) as total_pendapatan'),
            DB::raw('SUM(total_keuntungan) as total_keuntungan')
        )
        ->whereBetween('tanggal_penjualan', [$startDate, $endDate]);

        if ($period == 'daily') {
            $query->selectRaw('DATE(tanggal_penjualan) as periode_label')
                  ->groupBy('periode_label')
                  ->orderBy('periode_label', 'asc');
        } elseif ($period == 'weekly') {
            $query->selectRaw('WEEK(tanggal_penjualan, 1) as periode_label, YEAR(tanggal_penjualan) as tahun')
                  ->groupBy('tahun', 'periode_label')
                  ->orderBy('tahun', 'asc')
                  ->orderBy('periode_label', 'asc');
        } elseif ($period == 'monthly') {
            $query->selectRaw('MONTH(tanggal_penjualan) as periode_label, YEAR(tanggal_penjualan) as tahun')
                  ->groupBy('tahun', 'periode_label')
                  ->orderBy('tahun', 'asc')
                  ->orderBy('periode_label', 'asc');
        }

        $reportData = $query->get();

        return view('laporan.profit_report', compact('reportData', 'startDate', 'endDate', 'period'));
    }
}
