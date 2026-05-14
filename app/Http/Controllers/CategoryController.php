<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();

        return view('category', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' =>'string|max:255',
        ]);

        Category::create ([
            'name' => $request->name,
            'description' =>$request->description,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id) {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
