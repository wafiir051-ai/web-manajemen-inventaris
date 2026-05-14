@extends('master')

@section('content')
<header
    class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30 transition-all">

    <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()"
            class="md:hidden w-10 h-10 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-accent-500">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        <h2 class="text-xl font-bold text-slate-800 hidden sm:block">Ringkasan Dashboard</h2>
    </div>

    <div class="flex items-center space-x-3 sm:space-x-5">
        <div class="relative hidden md:block">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" placeholder="Cari SKU atau Produk..."
                class="pl-10 pr-4 py-2 bg-slate-100 border-transparent rounded-full text-sm focus:ring-2 focus:ring-accent-500 focus:bg-white focus:border-accent-300 outline-none w-64 transition-all">
        </div>

        <button
            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-colors relative">
            <i class="fa-regular fa-bell text-lg"></i>
            <span
                class="absolute top-2 right-2 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white animate-pulse"></span>
        </button>
    </div>
</header>

<div class="p-4 sm:p-8 flex-grow">

    <div class="mb-8 reveal">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-1">Halo, Selamat Datang Kembali! 👋</h1>
        <p class="text-slate-500">Berikut adalah status operasional gudang Anda hari ini, <span
                class="font-medium text-slate-700">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-shadow duration-300 reveal">
            <p class="text-slate-500 text-sm font-medium mb-1">Total Produk di Gudang</p>
            <h3 class="text-3xl font-bold text-slate-900 leading-tight">{{ number_format($totalStock ?? 0, 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-shadow duration-300 border-b-4 border-b-rose-500 reveal delay-100">
            <p class="text-slate-500 text-sm font-medium mb-1">Peringatan Stok Rendah</p>
            <h3 class="text-3xl font-bold text-slate-900 leading-tight">{{ number_format($lowStockCount ?? 0) }} <span class="text-sm font-medium text-slate-400 ml-1">Barang</span></h3>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-shadow duration-300 reveal delay-200">
            <p class="text-slate-500 text-sm font-medium mb-1">Estimasi Nilai Inventaris</p>
            <h3 class="text-2xl font-bold text-slate-900 leading-tight">Rp {{ number_format($totalValue ?? 0, 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-shadow duration-300 reveal delay-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-indigo-50 text-primary rounded-xl flex items-center justify-center text-xl shadow-inner border border-indigo-100">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-[10px] font-bold text-emerald-600"><i class="fa-solid fa-arrow-down mr-1"></i>{{ $inToday ?? 0 }} Masuk</span>
                    <span class="text-[10px] font-bold text-rose-600"><i class="fa-solid fa-arrow-up mr-1"></i>{{ $outToday ?? 0 }} Keluar</span>
                </div>
            </div>
            <p class="text-slate-500 text-sm font-medium mb-1">Total Pergerakan Hari Ini</p>
            <h3 class="text-3xl font-bold text-slate-900 leading-tight">{{ number_format($totalTransactionsToday ?? 0) }} <span class="text-sm font-medium text-slate-400 ml-1">Transaksi</span></h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm reveal">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="font-bold text-lg text-slate-900">Statistik Pergerakan Barang</h3>
                    <p class="text-sm text-slate-500">Data 7 hari terakhir (Masuk vs Keluar)</p>
                </div>
                <select
                    class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-accent-500">
                    <option>Minggu Ini</option>
                    <option>Bulan Ini</option>
                    <option>Tahun Ini</option>
                </select>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="inventoryChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col reveal delay-100">
            <h3 class="font-bold text-lg text-slate-900 mb-6">Aksi Cepat</h3>

            <div class="space-y-3 flex-grow">
                @can('make-transaction')
                <a href="{{ route('transaction.index') }}"
                    class="w-full bg-accent-600 hover:bg-accent-700 text-white font-semibold py-3.5 px-4 rounded-xl transition-all shadow-md shadow-accent-500/20 flex items-center justify-center gap-2 group">
                    <i class="fa-solid fa-arrow-right-to-bracket group-hover:-translate-y-0.5 transition-transform"></i>
                    Barang Masuk Baru
                </a>
                <a href="{{ route('transaction.index') }}"
                    class="w-full bg-white border-2 border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold py-3.5 px-4 rounded-xl transition-all flex items-center justify-center gap-2 group">
                    <i
                        class="fa-solid fa-arrow-right-from-bracket text-rose-500 group-hover:-translate-y-0.5 transition-transform"></i>
                    Catat Barang Keluar
                </a>
                @endcan

                <a href="{{ route('reports.pdf') }}"
                    class="w-full bg-white border-2 border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold py-3.5 px-4 rounded-xl transition-all flex items-center justify-center gap-2 group">
                    <i class="fa-solid fa-file-pdf text-rose-500 group-hover:-translate-y-0.5 transition-transform"></i>
                    Ekspor Laporan PDF
                </a>
                <a href="{{ route('reports.excel')}}"
                    class="w-full bg-white border-2 border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold py-3.5 px-4 rounded-xl transition-all flex items-center justify-center gap-2 group">
                    <i
                        class="fa-solid fa-file-excel text-emerald-600 group-hover:-translate-y-0.5 transition-transform"></i>
                    Ekspor Laporan Excel
                </a>
            </div>

            <div class="mt-6 p-4 bg-slate-50 rounded-xl border border-slate-100 flex items-center gap-3">
                <div class="relative flex h-3 w-3">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </div>
                <p class="text-sm text-slate-600 font-medium">Sistem berjalan optimal</p>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script>
        // Melempar data grafik dari PHP ke JavaScript
        window.dashboardChartLabels = {!! json_encode($chartLabels ?? []) !!};
        window.dashboardChartDataIn = {!! json_encode($chartDataIn ?? []) !!};
        window.dashboardChartDataOut = {!! json_encode($chartDataOut ?? []) !!};
    </script>
@endpush
