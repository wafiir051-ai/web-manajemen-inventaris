<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class InventoryDataController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::all();

        return view('inventory-data', compact('categories'), compact('products'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255|string',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return redirect()->route('inventory-data.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('inventory-data.index')->with('success', 'Product berhasil dihapus!');
    }

    public function update(Request $request, $id) {
        // 1. Tetap gunakan 'required' agar data penting tidak dikosongkan saat diedit
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Image boleh kosong saat update
        ]);

        // Biasakan gunakan singular ($product) karena yang dipanggil hanya 1 barang
        $product = Product::findOrFail($id);

        // 2. Siapkan data apa saja yang akan di-update (TIDAK TERMASUK GAMBAR DULU)
        $dataToUpdate = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'price' => $request->price,
        ];

        // 3. Cek apakah ada file gambar BARU yang diupload
        if ($request->hasFile('image')) {
            // Jika ada, simpan gambar baru dan tambahkan ke array $dataToUpdate
            $dataToUpdate['image'] = $request->file('image')->store('products', 'public');

            // (Opsional tapi disarankan) Anda bisa menambahkan kode untuk menghapus gambar lama di sini
        }

        // 4. Update datanya ke database
        $product->update($dataToUpdate);

        // 5. Kembalikan user ke halaman index dengan pesan sukses
        return redirect()->route('inventory-data.index')->with('success', 'Data barang berhasil diperbarui!');
    }
}
