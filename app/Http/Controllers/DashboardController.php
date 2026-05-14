<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function show() {
        // 1. Menghitung Total Stok Produk di Gudang
        $totalStock = Product::sum('stock');

        // 2. Menghitung Total Nilai Inventaris (Stok * Harga)
        // Menggunakan selectRaw agar kalkulasi dilakukan langsung di database (lebih cepat)
        $totalValue = Product::selectRaw('SUM(stock * price) as total')->value('total') ?? 0;

        // 3. Menghitung Peringatan Stok Rendah (Misal batas peringatan adalah stok <= 10)
        $lowStockThreshold = 10;
        $lowStockCount = Product::where('stock', '<=', $lowStockThreshold)->count();

        // 4. Pergerakan/Transaksi Hari Ini
        $today = Carbon::today();

        $totalTransactionsToday = Transaction::whereDate('created_at', $today)->count();
        // Asumsi nilai kolom 'type' di database kamu adalah 'in' dan 'out' (Sesuaikan jika kamu memakai 'masuk'/'keluar')
        $inToday = Transaction::whereDate('created_at', $today)->where('type', 'inbound')->count();
        $outToday = Transaction::whereDate('created_at', $today)->where('type', 'outbound')->count();

        // 5. Menyiapkan Data Grafik 7 Hari Terakhir
        $chartLabels = [];
        $chartDataIn = [];
        $chartDataOut = [];

        // Looping 7 hari ke belakang hingga hari ini
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            // Nama hari (Sen, Sel, Rab, dll)
            $chartLabels[] = $date->translatedFormat('D');

            // Jumlah qty masuk pada tanggal tersebut
            $chartDataIn[] = Transaction::whereDate('created_at', $date)
                ->where('type', 'inbound')
                ->sum('quantity');

            // Jumlah qty keluar pada tanggal tersebut
            $chartDataOut[] = Transaction::whereDate('created_at', $date)
                ->where('type', 'outbound')
                ->sum('quantity');
        }

        return view('dashboard', compact(
            'totalStock',
            'totalValue',
            'lowStockCount',
            'totalTransactionsToday',
            'inToday',
            'outToday',
            'chartLabels',
            'chartDataIn',
            'chartDataOut'
        ));
    }
}
