<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Inventaris</title>
    <style>
        /* CSS Khusus untuk DomPDF */
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0 0 5px 0;
            font-size: 20px;
        }
        .header p {
            margin: 0;
            color: #666;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px 8px;
        }
        th {
            background-color: #f4f4f5;
            font-weight: bold;
            text-align: center;
            font-size: 11px;
            text-transform: uppercase;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .fw-bold { font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN STOK INVENTARIS GUDANG</h2>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y - H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">SKU</th>
                <th class="text-left">Nama Produk</th>
                <th width="15%">Kategori</th>
                <th width="8%">Stok</th>
                <th width="15%">Harga Satuan</th>
                <th width="15%">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandTotal = 0;
            @endphp

            @foreach($products as $index => $product)
                @php
                    // Hitung total harga per baris produk
                    $totalHarga = $product->stock * $product->price;
                    // Tambahkan ke grand total keseluruhan
                    $grandTotal += $totalHarga;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $product->sku }}</td>
                    <td>{{ $product->name }}</td>
                    <td class="text-center">{{ $product->category->name ?? '-' }}</td>
                    <td class="text-center">{{ $product->stock }}</td>
                    <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right fw-bold" style="background-color: #f4f4f5;">GRAND TOTAL VALUASI</td>
                <td class="text-right fw-bold" style="background-color: #f4f4f5;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
