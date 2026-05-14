@extends('master')

@section('title', 'Laporan Stok')

@section('content')
    <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-4">
            <button onclick="toggleSidebar()" class="md:hidden w-10 h-10 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
            <div class="hidden sm:block">
                <h2 class="text-xl font-bold text-slate-800">Laporan & Analitik</h2>
                <p class="text-xs text-slate-500">Ringkasan pergerakan aset dan valuasi gudang Anda.</p>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <button class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-colors relative">
                <i class="fa-regular fa-bell"></i>
                <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border-2 border-white"></span>
            </button>
        </div>
    </header>

    <div class="p-4 sm:p-8 flex-grow">
        <div class="max-w-7xl mx-auto">

            @if(in_array(auth()->user()->role, ['owner', 'manager', 'auditor']))

                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-100 shadow-sm mb-6 reveal flex flex-col md:flex-row md:items-center justify-between gap-4 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-2 h-full bg-primary"></div>
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-1">Laporan Stok Periode Ini</h3>
                        <p class="text-slate-500 text-sm">Data diakumulasikan secara real-time berdasarkan aktivitas sistem.</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('reports.excel') }}" class="flex items-center gap-2 bg-white border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm group">
                            <i class="fa-solid fa-file-excel text-emerald-600 group-hover:scale-110 transition-transform"></i> Ekspor Excel
                        </a>
                        <a href="{{ route('reports.pdf') }}" class="flex items-center gap-2 bg-white border border-slate-200 hover:border-rose-300 hover:bg-rose-50 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm group">
                            <i class="fa-solid fa-file-pdf text-rose-600 group-hover:scale-110 transition-transform"></i> Unduh PDF
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm reveal delay-100 flex items-center justify-between relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 opacity-5 text-emerald-600 text-8xl pointer-events-none">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm">
                                    <i class="fa-solid fa-arrow-down"></i>
                                </span>
                                <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider">Pemasukan Hari Ini</h4>
                            </div>
                            <h2 class="text-3xl font-black text-slate-800">{{ number_format($inboundToday) }} <span class="text-sm font-medium text-slate-400">Item Ditambahkan</span></h2>
                        </div>
                        <div class="text-right">
                            @php
                                $isInboundPositive = $inboundPercentage >= 0;
                            @endphp
                            <span class="px-2 py-1 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-lg text-xs font-bold {{ $isInboundPositive ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-600' }}">{{ $isInboundPositive ? '+' : '' }}{{ number_format($inboundPercentage, 1) }}%</span>
                            <p class="text-xs text-slate-400 mt-1">vs kemarin</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm reveal delay-100 flex items-center justify-between relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 opacity-5 text-rose-600 text-8xl pointer-events-none">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-sm">
                                    <i class="fa-solid fa-arrow-up"></i>
                                </span>
                                <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider">Pengeluaran Hari Ini</h4>
                            </div>
                            <h2 class="text-3xl font-black text-slate-800">{{ number_format($outboundToday) }}<span class="text-sm font-medium text-slate-400">Item Terkirim</span></h2>
                        </div>
                        <div class="text-right">
                            @php
                                $isOutboundPositive = $outboundPercentage >= 0;
                            @endphp
                            <span class="px-2 py-1 bg-slate-100 border border-slate-200 text-slate-600 rounded-lg text-xs font-bold {{ $isOutboundPositive ? 'bg-rose-50 text-rose-600' : 'bg-slate-100 text-slate-600' }}">{{ $isOutboundPositive ? '+' : '' }}{{ number_format($outboundPercentage, 1) }}%</span>
                            <p class="text-xs text-slate-400 mt-1">vs kemarin</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm reveal delay-200 flex flex-col">
                        <div class="mb-4">
                            <h4 class="font-bold text-slate-800">Distribusi Valuasi</h4>
                            <p class="text-xs text-slate-500">Persentase nilai aset per kategori</p>
                        </div>
                        <div class="relative w-full flex-grow min-h-[250px] flex items-center justify-center">
                            <canvas id="valuationChart"></canvas>
                        </div>
                    </div>

                    <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm reveal delay-200">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h4 class="font-bold text-slate-800">Valuasi Nilai per Kategori</h4>
                                <p class="text-xs text-slate-500">Estimasi aset yang terikat di gudang.</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-1">Total Aset</p>
                                <h3 class="text-xl font-black text-primary">Rp {{ number_format($totalValuation, 0, ',', '.') }}</h3>
                            </div>
                        </div>

                        <div class="space-y-6">
                            @forelse($categoryValuations as $index => $cat)
                                @php
                                    $percentage = $totalValuation > 0 ? ($cat->total_value / $totalValuation) * 100 : 0;
                                    $colors = ['blue', 'purple', 'amber', 'emerald', 'rose'];
                                    $color = $colors[$index % count($colors)];
                                @endphp
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="font-bold text-slate-700 flex items-center gap-2 capitalize">
                                            <i class="fa-solid fa-layer-group text-{{ $color }}-500"></i> {{ $cat->category->name ?? 'Tanpa Kategori' }}
                                        </span>
                                        <span class="font-bold text-slate-900">
                                            Rp {{ number_format($cat->total_value, 0, ',', '.') }}
                                            <span class="text-xs text-slate-400 font-normal ml-1">({{ number_format($percentage, 1) }}%)</span>
                                        </span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                        <div class="bg-{{ $color }}-500 h-full rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-slate-400 text-sm">
                                    Belum ada data valuasi kategori.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="reveal delay-300">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fa-solid fa-wand-magic-sparkles text-primary"></i>
                        <h4 class="font-bold text-slate-800">Stockflow AI Insights</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm border-l-4 border-l-amber-500 group hover:shadow-md transition-all">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                                <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full uppercase tracking-tighter">Prioritas Tinggi</span>
                            </div>
                            @if($lowStockProduct)
                                <h5 class="font-bold text-slate-800 text-sm mb-1">Perlu Restock: {{ Str::limit($lowStockProduct->name, 15) }}</h5>
                                <p class="text-xs text-slate-500 leading-relaxed mb-4">Stok tersisa <b>{{ $lowStockProduct->stock }} unit</b>. Segera lakukan pemesanan ulang agar operasional tidak terganggu.</p>
                            @else
                                <h5 class="font-bold text-slate-800 text-sm mb-1">Stok Aman</h5>
                                <p class="text-xs text-slate-500 leading-relaxed mb-4">Belum ada data produk atau semua stok masih dalam batas aman.</p>
                            @endif

                            @hasanyrole('owner|manager')
                            <button class="w-full py-2 bg-slate-50 text-slate-600 text-xs font-bold rounded-lg hover:bg-amber-500 hover:text-white transition-colors border border-slate-200 border-dashed group-hover:border-transparent">Buat Pesanan Pembelian</button>
                            @endhasanyrole
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm border-l-4 border-l-indigo-500 group hover:shadow-md transition-all">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                    <i class="fa-solid fa-chart-pie"></i>
                                </div>
                                <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full uppercase tracking-tighter">Optimasi Aset</span>
                            </div>
                            @if($highestValueProduct && $highestValueProduct->total_value > 0)
                                <h5 class="font-bold text-slate-800 text-sm mb-1">Aset Tertinggi: {{ Str::limit($highestValueProduct->name, 15) }}</h5>
                                <p class="text-xs text-slate-500 leading-relaxed mb-4">Modal senilai <b>Rp {{ number_format($highestValueProduct->total_value, 0, ',', '.') }}</b> terikat pada {{ $highestValueProduct->stock }} unit barang ini. Pantau perputarannya!</p>
                            @else
                                <h5 class="font-bold text-slate-800 text-sm mb-1">Evaluasi Aset</h5>
                                <p class="text-xs text-slate-500 leading-relaxed mb-4">Tambahkan data harga dan stok untuk melihat barang dengan nilai kapital terbesar.</p>
                            @endif
                            <a href="{{ route('inventory-data.index') }}" class="block text-center w-full py-2 bg-slate-50 text-slate-600 text-xs font-bold rounded-lg hover:bg-indigo-500 hover:text-white transition-colors border border-slate-200 border-dashed group-hover:border-transparent">Lihat Detail Inventaris</a>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm border-l-4 border-l-emerald-500 group hover:shadow-md transition-all">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <i class="fa-solid fa-credit-card"></i>
                                </div>
                                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full uppercase tracking-tighter">Kesehatan Data</span>
                            </div>
                            @if($todayActivityCount > 0)
                                <h5 class="font-bold text-slate-800 text-sm mb-1">Sistem Aktif & Optimal</h5>
                                <p class="text-xs text-slate-500 leading-relaxed mb-4">Terdapat <b>{{ $todayActivityCount }} pergerakan transaksi</b> hari ini. Tidak ada anomali terdeteksi, pertahankan performa!</p>
                            @else
                                <h5 class="font-bold text-slate-800 text-sm mb-1">Sistem Standby</h5>
                                <p class="text-xs text-slate-500 leading-relaxed mb-4">Belum ada aktivitas transaksi atau pergerakan barang yang tercatat pada hari ini.</p>
                            @endif

                            @hasanyrole('owner|manager|auditor')
                            <button class="w-full py-2 bg-slate-50 text-slate-600 text-xs font-bold rounded-lg hover:bg-emerald-500 hover:text-white transition-colors border border-slate-200 border-dashed group-hover:border-transparent">Jadwalkan Audit Baru</button>
                            @endhasanyrole
                        </div>

                    </div>
                </div>

            @else
                <div class="bg-white p-10 rounded-2xl border border-slate-100 shadow-sm text-center mt-10">
                    <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-5">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">Akses Laporan Ditolak</h3>
                    <p class="text-slate-500 mb-6 max-w-md mx-auto">
                        Maaf, Anda tidak memiliki izin untuk melihat data Laporan dan Valuasi Finansial. Halaman ini hanya diperuntukkan bagi tingkat Manajemen dan Auditor.
                    </p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary_dark transition-colors shadow-lg shadow-primary/30">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Memastikan variabel chart hanya di-render jika data dikirim (untuk menghindari error js jika diakses staf)
        @if(isset($categoryValuations))
            window.chartLabels = {!! json_encode($categoryValuations->map(fn($c) => $c->category->name ?? 'Lainnya')) !!};
            window.chartData = {!! json_encode($categoryValuations->pluck('total_value')) !!};
        @endif
    </script>
@endpush
