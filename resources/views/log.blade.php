@extends('master')

@section('title', 'Log Aktivitas')

@section('content')
    <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-4">
            <button onclick="toggleSidebar()" class="md:hidden w-10 h-10 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
            <div class="hidden sm:block">
                <h2 class="text-xl font-bold text-slate-800">Audit & Log Sistem</h2>
                <p class="text-xs text-slate-500">Pantau seluruh aktivitas dan perubahan data dalam sistem inventaris.</p>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <button class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-colors relative">
                <i class="fa-regular fa-bell"></i>
            </button>
        </div>
    </header>

    <div class="p-4 sm:p-8 flex-grow">
        <div class="max-w-4xl mx-auto">

            @if(in_array(auth()->user()->role, ['owner', 'manager', 'auditor']))

                <div class="bg-white p-5 md:p-6 rounded-2xl border border-slate-100 shadow-sm mb-8 reveal flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-50 text-primary rounded-xl flex items-center justify-center text-xl shadow-inner border border-indigo-100">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 mb-0.5">Riwayat Aktivitas</h3>
                            <p class="text-slate-500 text-xs">Menampilkan log sistem secara real-time.</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <button class="px-4 py-2 rounded-lg text-xs font-bold bg-slate-800 text-white shadow-sm transition-all hover:bg-slate-700">Semua</button>
                        <button class="px-4 py-2 rounded-lg text-xs font-bold bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100 transition-all hover:text-slate-900">Penambahan</button>
                        <button class="px-4 py-2 rounded-lg text-xs font-bold bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100 transition-all hover:text-slate-900">Perubahan</button>
                        <button class="px-4 py-2 rounded-lg text-xs font-bold bg-slate-50 text-slate-600 border border-slate-200 hover:bg-slate-100 transition-all hover:text-slate-900">Penghapusan</button>

                        <div class="relative ml-2">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                            <input type="text" placeholder="Cari aktivitas..."
                                class="pl-8 pr-4 py-2 w-48 bg-slate-50 border border-slate-200 rounded-lg text-xs outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                        </div>
                    </div>
                </div>

                <div class="relative timeline-line pl-5 pb-8">
                    @forelse ($groupedLogs as $dateString => $activities)
                        <div class="relative flex items-center mb-6 mt-{{ $loop->first ? '2' : '12' }} reveal">
                            <span class="absolute -left-[27px] bg-[#f8fafc] text-{{ Str::contains($dateString, 'Hari Ini') ? 'primary' : 'slate-400' }} p-1 z-10">
                                <i class="fa-solid fa-calendar-{{ Str::contains($dateString, 'Hari Ini') ? 'day' : 'days' }} text-sm"></i>
                            </span>
                            <h4 class="font-bold text-{{ Str::contains($dateString, 'Hari Ini') ? 'slate-800' : 'slate-500' }} ml-6 uppercase tracking-wider text-xs bg-white px-3 py-1 rounded-full border border-slate-200 shadow-sm">
                                {{ $dateString }}
                            </h4>
                        </div>

                        <div class="space-y-6">
                            @foreach ($activities as $activity)
                                @php
                                    $theme = ['color' => 'slate', 'icon' => 'fa-circle-info', 'title' => 'Aktivitas Sistem'];

                                    if ($activity->event === 'created' || Str::contains($activity->description, 'Masuk')) {
                                        $theme = ['color' => 'emerald', 'icon' => 'fa-plus', 'title' => 'Data Ditambahkan / Masuk'];
                                    } elseif ($activity->event === 'updated') {
                                        $theme = ['color' => 'amber', 'icon' => 'fa-pen-to-square', 'title' => 'Pembaruan Data'];
                                    } elseif ($activity->event === 'deleted') {
                                        $theme = ['color' => 'rose', 'icon' => 'fa-trash-can', 'title' => 'Data Dihapus'];
                                    } elseif (Str::contains($activity->description, 'Keluar')) {
                                        $theme = ['color' => 'indigo', 'icon' => 'fa-truck-fast', 'title' => 'Barang Keluar'];
                                    }
                                @endphp

                                <div class="relative ml-6 reveal delay-100">
                                    <span class="absolute -left-[45px] w-10 h-10 rounded-full bg-{{ $theme['color'] }}-50 border-[3px] border-white flex items-center justify-center text-{{ $theme['color'] }}-500 shadow-sm z-10 hover:scale-110 transition-transform">
                                        <i class="fa-solid {{ $theme['icon'] }} text-sm"></i>
                                    </span>
                                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-{{ $theme['color'] }}-200 transition-all cursor-default group">
                                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 mb-3">
                                            <h5 class="font-bold text-slate-800 text-sm group-hover:text-{{ $theme['color'] }}-600 transition-colors">
                                                {{ $theme['title'] }}
                                            </h5>
                                            <span class="text-[10px] font-bold text-slate-400 bg-slate-50 border border-slate-100 px-2.5 py-1 rounded-full">
                                                <i class="fa-regular fa-clock mr-1"></i> {{ $activity->created_at->format('H:i A') }}
                                            </span>
                                        </div>

                                        <p class="text-sm text-slate-600 mb-4 leading-relaxed">
                                            {{ $activity->description }}
                                        </p>

                                        <div class="flex items-center gap-2 pt-3 border-t border-slate-50">
                                            @if($activity->causer)
                                                <img src="{{ $activity->causer->profile?->avatar ? asset('storage/' . $activity->causer->profile->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($activity->causer->name) . '&background=4F46E5&color=fff&size=200' }}"
                                                    alt="{{ $activity->causer->name }}"
                                                    class="w-6 h-6 rounded-full object-cover border border-slate-200 shadow-sm">

                                                <span class="text-xs font-bold text-slate-700">{{ $activity->causer->name }}
                                                    <span class="font-medium text-slate-400 ml-1">({{ $activity->causer->role ?? 'User' }})</span>
                                                </span>
                                            @else
                                                <div class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-[10px]">
                                                    <i class="fa-solid fa-robot"></i>
                                                </div>
                                                <span class="text-xs font-bold text-slate-700">Sistem Stockflow</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <i class="fa-solid fa-folder-open text-slate-300 text-4xl mb-3"></i>
                            <p class="text-slate-500 font-medium">Belum ada riwayat aktivitas yang tercatat.</p>
                        </div>
                    @endforelse

                    @if($groupedLogs->isNotEmpty())
                    <div class="relative flex justify-center mt-12 reveal">
                        <button class="px-6 py-2.5 rounded-full bg-white border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-primary transition-all shadow-sm z-10 hover:shadow-md">
                            <i class="fa-solid fa-rotate-right mr-2"></i> Muat Aktivitas Terdahulu
                        </button>
                    </div>
                    @endif
                </div>

            @else
                <div class="bg-white p-10 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-5">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">Akses Ditolak</h3>
                    <p class="text-slate-500 mb-6 max-w-md mx-auto">
                        Maaf, Anda tidak memiliki izin (otorisasi) untuk melihat Log Sistem. Halaman ini hanya diperuntukkan bagi tingkat Manajemen dan Auditor untuk keperluan pemantauan sistem.
                    </p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary_dark transition-colors shadow-lg shadow-primary/30">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Dashboard
                    </a>
                </div>
            @endif

        </div>
    </div>
@endsection
