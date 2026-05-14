@extends('master')

@section('title', 'Transaksi')

@section('content')
    <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-4">
            <button onclick="toggleSidebar()" class="md:hidden w-10 h-10 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-dark">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
            <div class="hidden sm:block">
                <h2 class="text-xl font-bold text-slate-800">Kelola Transaksi</h2>
                <p class="text-xs text-slate-500">Catat pergerakan stok barang masuk dan keluar.</p>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <button class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-colors">
                <i class="fa-regular fa-bell"></i>
            </button>
        </div>
    </header>

    <div class="p-4 sm:p-8 flex-grow">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6 reveal">

                    @if(in_array(auth()->user()->role, ['owner', 'manager', 'staff']))
                        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-[100px] z-0 pointer-events-none"></div>

                            <div class="relative z-10">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 bg-indigo-50 text-primary rounded-lg flex items-center justify-center text-lg">
                                        <i class="fa-solid fa-file-signature"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-xl text-slate-900">Input Transaksi Baru</h3>
                                        <p class="text-sm text-slate-500">Isi detail di bawah ini untuk mencatat aktivitas gudang.</p>
                                    </div>
                                </div>

                                @if ($errors->any())
                                    <div class="bg-red-100 text-red-600 p-4 rounded-lg mb-4">
                                        <ul class="list-disc list-inside text-sm font-medium">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form class="space-y-5" action="{{ route('transaction.store') }}" method="POST">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Tipe Transaksi</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                                </div>
                                                <select name="type" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm appearance-none cursor-pointer">
                                                    <option value="inbound">Barang Masuk (Inbound)</option>
                                                    <option value="outbound">Barang Keluar (Outbound)</option>
                                                </select>
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Pilih Barang</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                    <i class="fa-solid fa-box"></i>
                                                </div>
                                                <select name="product_id" id="product-select" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm appearance-none cursor-pointer">
                                                    <option disabled selected>Pilih produk dari katalog...</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Jumlah (Qty)</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                    <i class="fa-solid fa-hashtag"></i>
                                                </div>
                                                <input type="number" name="quantity" placeholder="0" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Harga Satuan (Rp)</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                    <i class="fa-solid fa-rupiah-sign text-xs"></i>
                                                </div>
                                                <input type="number" id="price-input" name="price" placeholder="0" readonly class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Catatan Transaksi</label>
                                        <div class="relative">
                                            <div class="absolute top-3 left-3 flex items-start pointer-events-none text-slate-400">
                                                <i class="fa-solid fa-align-left mt-0.5"></i>
                                            </div>
                                            <textarea rows="3" name="description" placeholder="Contoh: Restock dari Supplier A atau Penjualan Customer..." class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm resize-none"></textarea>
                                        </div>
                                    </div>

                                    <button type="submit" class="w-full bg-primary hover:bg-primary_hover text-white py-3.5 rounded-xl font-bold text-sm transition-all shadow-md shadow-primary/20 flex items-center justify-center gap-2 group mt-2">
                                        <i class="fa-solid fa-floppy-disk group-hover:scale-110 transition-transform"></i>
                                        Simpan Transaksi
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="bg-white p-10 rounded-2xl border border-slate-100 shadow-sm text-center h-full flex flex-col items-center justify-center">
                            <div class="w-20 h-20 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center text-3xl mx-auto mb-5 border border-slate-100">
                                <i class="fa-solid fa-eye"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">Mode Read-Only (Auditor)</h3>
                            <p class="text-slate-500 mb-0 max-w-sm mx-auto text-sm">
                                Anda login sebagai Auditor. Sesuai dengan kebijakan sistem, Anda hanya diizinkan untuk melihat laporan dan aktivitas data, tetapi <b>tidak memiliki otorisasi</b> untuk melakukan input transaksi baru.
                            </p>
                        </div>
                    @endif

                </div>

                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm reveal delay-100 h-full flex flex-col">
                        <h3 class="font-bold text-lg text-slate-900 mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-primary"></i> Ringkasan Hari Ini
                        </h3>

                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-xl text-center shadow-sm">
                                <i class="fa-solid fa-arrow-down text-emerald-500 mb-2 text-xl"></i>
                                <p class="text-[10px] text-slate-500 font-bold uppercase mb-1">Masuk</p>
                                <h4 class="text-3xl font-black text-emerald-600">{{ number_format($inboundToday) }}</h4>
                            </div>
                            <div class="bg-rose-50 border border-rose-100 p-4 rounded-xl text-center shadow-sm">
                                <i class="fa-solid fa-arrow-up text-rose-500 mb-2 text-xl"></i>
                                <p class="text-[10px] text-slate-500 font-bold uppercase mb-1">Keluar</p>
                                <h4 class="text-3xl font-black text-rose-600">{{ number_format($outboundToday) }}</h4>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-6 flex-grow flex flex-col">
                            <h4 class="text-xs font-bold text-slate-500 uppercase mb-4 text-center">Rasio Transaksi</h4>
                            <div class="relative w-full flex-grow min-h-[220px] flex items-center justify-center">
                                <canvas id="valuationChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Melempar data dari PHP/Laravel ke variabel global JavaScript (window)
        window.chartData = {!! json_encode([(int) $inboundToday, (int) $outboundToday]) !!};
    </script>
@endpush
