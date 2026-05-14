<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product; // <-- BARU: Pastikan Model Product di-import
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // <-- BARU: Import DB facade untuk raw query
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ProductsExport; // <-- Import class export yang baru kita buat
use Maatwebsite\Excel\Facades\Excel; // <-- Import facade Excel

class ReportController extends Controller
{
    public function show() {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // --- 1. LOGIKA PEMASUKAN (INBOUND) ---
        $inboundToday = Transaction::where('type', 'inbound')
            ->whereDate('created_at', $today)
            ->sum('quantity');

        $inboundYesterday = Transaction::where('type', 'inbound')
            ->whereDate('created_at', $yesterday)
            ->sum('quantity');

        $inboundPercentage = 0;
        if ($inboundYesterday > 0) {
            $inboundPercentage = (($inboundToday - $inboundYesterday) / $inboundYesterday) * 100;
        } elseif ($inboundToday > 0) {
            $inboundPercentage = 100;
        }

        // --- 2. LOGIKA PENGELUARAN (OUTBOUND) ---
        $outboundToday = Transaction::where('type', 'outbound')
            ->whereDate('created_at', $today)
            ->sum('quantity');

        $outboundYesterday = Transaction::where('type', 'outbound')
            ->whereDate('created_at', $yesterday)
            ->sum('quantity');

        $outboundPercentage = 0;
        if ($outboundYesterday > 0) {
            $outboundPercentage = (($outboundToday - $outboundYesterday) / $outboundYesterday) * 100;
        } elseif ($outboundToday > 0) {
            $outboundPercentage = 100;
        }

        // --- 3. BARU: LOGIKA VALUASI ASET ---
        // Menghitung total nilai seluruh aset (stok * harga)
        $totalValuation = Product::sum(DB::raw('stock * price'));

        // Menghitung nilai aset dikelompokkan per kategori
        $categoryValuations = Product::select('category_id', DB::raw('SUM(stock * price) as total_value'))
            ->groupBy('category_id')
            ->orderByDesc('total_value')
            ->get();

        $transactions = Transaction::with('product')->latest()->get();

        $lowStockProduct = Product::orderBy('stock', 'asc')->first();

        // Insight 2: Cari produk dengan aset mengendap paling tinggi (Stok x Harga tertinggi)
        $highestValueProduct = Product::selectRaw('*, (stock * price) as total_value')
            ->orderBy('total_value', 'desc')
            ->first();

        // Insight 3: Kesehatan Sistem (Cek jumlah transaksi/pergerakan hari ini)
        $todayActivityCount = Transaction::whereDate('created_at', Carbon::today())->count();

        return view('report', compact(
            'transactions',
            'inboundToday', 'inboundPercentage',
            'outboundToday', 'outboundPercentage',
            'totalValuation', 'categoryValuations',
            'lowStockProduct', 'highestValueProduct',
            'todayActivityCount'
        ));
    }

    public function exportPdf()
    {
        // Ambil semua data produk beserta relasi kategorinya
        $products = Product::with('category')->orderBy('name', 'asc')->get();

        // Load view PDF dan kirim data produk
        $pdf = Pdf::loadView('reports.pdf', compact('products'));

        // Atur ukuran kertas menjadi A4 dan orientasi portrait (opsional tapi disarankan)
        $pdf->setPaper('A4', 'portrait');

        // Download otomatis filenya
        return $pdf->download('Laporan-Inventaris-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel()
    {
        // Akan otomatis mengunduh file dengan nama Laporan-Inventaris-Tanggal.xlsx
        return Excel::download(new ProductsExport, 'Laporan-Inventaris-' . date('Y-m-d') . '.xlsx');
    }
}
