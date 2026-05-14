<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    private $rowNumber = 0;

    /**
    * Mengambil semua data produk beserta relasi kategorinya
    */
    public function collection()
    {
        return Product::with('category')->get();
    }

    /**
    * Mengatur judul/header untuk setiap kolom (Baris pertama Excel)
    */
    public function headings(): array
    {
        return [
            'No',
            'SKU',
            'Nama Produk',
            'Kategori',
            'Stok',
            'Harga Satuan',
            'Total Harga'
        ];
    }

    /**
    * Memetakan data dari database ke dalam urutan kolom
    */
    public function map($product): array
    {
        $this->rowNumber++;
        $totalHarga = $product->stock * $product->price;

        return [
            $this->rowNumber,
            $product->sku,
            $product->name,
            $product->category->name ?? 'Tanpa Kategori',
            $product->stock,
            $product->price,
            $totalHarga
        ];
    }

    /**
    * (Opsional) Mengatur gaya / styling pada file Excel
    */
    public function styles(Worksheet $sheet)
    {
        return [
            // Baris pertama (header) akan ditebalkan (bold)
            1 => ['font' => ['bold' => true]],
        ];
    }
}
