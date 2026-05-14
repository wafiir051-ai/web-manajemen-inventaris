<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction; // Pastikan model ini sudah dibuat
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $products = Product::all();
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

        $transactions = Transaction::with('product')->latest()->get();

        return view('transaction', compact(
            'transactions', 'products',
            'inboundToday', 'inboundPercentage',
            'outboundToday', 'outboundPercentage'
        ));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'type'        => 'required|string', // Contoh: "Barang Masuk (Inbound)"
            'product_id'  => 'required|exists:products,id',
            'quantity'    => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        // 2. Gunakan Database Transaction agar data konsisten
        // (Jika simpan transaksi gagal, stok tidak terlanjur berubah)
        DB::transaction(function () use ($validated) {
            $product = Product::findOrFail($validated['product_id']);

            $price = $product->price;

            // Simpan data transaksi
            Transaction::create([
                'type'        => $validated['type'],
                'product_id'  => $validated['product_id'],
                'quantity'    => $validated['quantity'],
                'price'       => $price,
                'description' => $validated['description'],
            ]);

            // 3. Logika Update Stok Otomatis
            $product = Product::findOrFail($validated['product_id']);

            if (str_contains(strtolower($validated['type']), 'inbound')) {
                // Ganti increment menjadi seperti ini:
                $product->stock += $validated['quantity'];
                $actionType = 'Barang Masuk';
            } else {
                // Ganti decrement menjadi seperti ini:
                $product->stock -= $validated['quantity'];
                $actionType = 'Barang Keluar';
            }
            $product->save(); // <-- Wajib dipanggil agar Eloquent Event menyala dan Spatie mendeteksi perubahan

            activity()
                ->performedOn($product) // Hubungkan log ini ke produk terkait
                ->causedBy(auth()->user()) // Buka komen ini kalau Anda pakai sistem Login (mencatat siapa pelakunya)
                ->event($actionType)
                ->log("Mencatat {$actionType} sebanyak {$validated['quantity']} unit untuk produk {$product->name}. Catatan: {$validated['description']}");
        });

        return redirect()->back()->with('success', 'Transaksi berhasil disimpan dan stok telah diperbarui!');
    }
}
