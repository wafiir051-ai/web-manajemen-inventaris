<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-800 overflow-x-hidden">

    <div id="sidebar-overlay"
        class="fixed inset-0 bg-slate-900/50 z-40 hidden opacity-0 transition-opacity duration-300 md:hidden backdrop-blur-sm"
        onclick="toggleSidebar()"></div>

    <aside id="sidebar"
        class="fixed inset-y-0 left-0 w-64 bg-white border-r border-slate-200 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col shadow-2xl md:shadow-none">

        <div class="h-20 flex items-center justify-between px-6 border-b border-slate-100">
            <a href="#" class="flex items-center group">
                <div class="w-8 h-8 bg-accent-600 text-white rounded flex items-center justify-center font-bold mr-3 group-hover:rotate-12 transition-transform duration-300 shadow-md shadow-accent-500/30">
                    <i class="fa-solid fa-box-open text-sm"></i>
                </div>
                <span class="font-bold text-xl tracking-tight text-slate-900">Stock<span class="text-accent-600">flow</span></span>
            </a>
            <button onclick="toggleSidebar()" class="md:hidden text-slate-400 hover:text-rose-500 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <nav class="flex-grow py-6 overflow-y-auto px-3">
            <div class="px-3 mb-3 text-xs font-bold text-slate-400 uppercase tracking-wider">Utama</div>

            <a href="{{ route('dashboard') }}"
               class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center px-3 py-2.5 rounded-lg text-slate-600 mb-1">
                <i class="fa-solid fa-chart-pie w-6 text-center mr-2 {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-slate-400' }}"></i>
                <span>Dashboard</span>
            </a>

            @can('manage-inventory')
            <a href="{{ route('category.index') }}"
               class="sidebar-link {{ request()->routeIs('category.*') ? 'active' : '' }} flex items-center px-3 py-2.5 rounded-lg text-slate-600 mb-1">
                <i class="fa-solid fa-layer-group w-6 text-center mr-2 {{ request()->routeIs('category.*') ? 'text-primary' : 'text-slate-400' }}"></i>
                <span>Kategori</span>
            </a>
            @endcan

            <a href="{{ route('inventory-data.index') }}"
               class="sidebar-link {{ request()->routeIs('inventory-data.*') ? 'active' : '' }} flex items-center px-3 py-2.5 rounded-lg text-slate-600 mb-1">
                <i class="fa-solid fa-boxes-stacked w-6 text-center mr-2 {{ request()->routeIs('inventory-data.*') ? 'text-primary' : 'text-slate-400' }}"></i>
                <span>Data Inventaris</span>
            </a>

            @can('make-transaction')
            <a href="{{ route('transaction.index') }}"
               class="sidebar-link {{ request()->routeIs('transaction.*') ? 'active' : '' }} flex items-center px-3 py-2.5 rounded-lg text-slate-600 mb-1">
                <i class="fa-solid fa-arrow-right-arrow-left w-6 text-center mr-2 {{ request()->routeIs('transaction.*') ? 'text-primary' : 'text-slate-400' }}"></i>
                <span>Transaksi</span>
            </a>
            @endcan

            <div class="px-3 mt-8 mb-3 text-xs font-bold text-slate-400 uppercase tracking-wider">Laporan & Audit</div>

            <a href="{{ route('report') }}"
               class="sidebar-link {{ request()->routeIs('report') ? 'active' : '' }} flex items-center px-3 py-2.5 rounded-lg text-slate-600 mb-1">
                <i class="fa-solid fa-file-invoice w-6 text-center mr-2 {{ request()->routeIs('report') ? 'text-primary' : 'text-slate-400' }}"></i>
                <span>Laporan Stok</span>
            </a>

            @can('isOwner')
            <a href="{{ route('log.index')}}" class="sidebar-link flex items-center px-3 py-2.5 rounded-lg text-slate-600 mb-1">
                <i class="fa-solid fa-clock-rotate-left w-6 text-center mr-2 text-slate-400"></i>
                <span>Log Aktivitas</span>
            </a>
            @endcan

            <div class="px-3 mt-8 mb-3 text-xs font-bold text-slate-400 uppercase tracking-wider">Sistem</div>

            @can('isOwner')
            <a href="{{ route('user-management.index') }}" class="sidebar-link flex items-center px-3 py-2.5 rounded-lg text-slate-600 mb-1">
                <i class="fa-solid fa-users-gear w-6 text-center mr-2 text-slate-400"></i>
                <span>Manajemen User</span>
            </a>
            @endcan

            <a href="{{ route('profile.edit') }}" class="sidebar-link flex items-center px-3 py-2.5 rounded-lg text-slate-600 mb-1">
                <i class="fa-solid fa-id-badge w-6 text-center mr-2 text-slate-400"></i>
                <span>Profil</span>
            </a>

            <div class="mt-8 pt-4 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-3 py-2.5 rounded-lg text-rose-500 hover:bg-rose-50 transition-all duration-300 group">
                        <i class="fa-solid fa-right-from-bracket w-6 text-center mr-2 group-hover:-translate-x-1 transition-transform"></i>
                        <span class="font-semibold">Keluar Aplikasi</span>
                    </button>
                </form>
            </div>
        </nav>

        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            <a href="#" class="flex items-center p-2 rounded-xl hover:bg-white hover:shadow-sm border border-transparent hover:border-slate-200 transition-all group">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-accent-500 to-primary flex items-center justify-center text-white font-bold mr-3 shadow-sm group-hover:scale-105 transition-transform">
                    <img src="{{ auth()->user()->profile?->avatar ? asset('storage/' . auth()->user()->profile->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=4F46E5&color=fff&size=200' }}" alt="User Avatar" class="w-full h-full rounded-full object-cover">
                </div>
                <div class="overflow-hidden flex-grow">
                    <p class="text-sm font-bold text-slate-900 truncate"> {{ auth()->user()->name }} </p>
                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                </div>
                <i class="fa-solid fa-chevron-right text-xs text-slate-400 group-hover:text-primary transition-colors"></i>
            </a>
        </div>
    </aside>

    <main class="md:ml-64 min-h-screen flex flex-col transition-all duration-300">
        @yield('content')

        <footer class="bg-white border-t border-slate-200 py-4 px-8 mt-auto">
            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-slate-500 gap-2">
                <p>&copy; 2026 Stockflow Manajemen Inventaris.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-accent-600 transition-colors">Bantuan</a>
                    <a href="#" class="hover:text-accent-600 transition-colors">Hubungi Dukungan</a>
                </div>
            </div>
        </footer>
    </main>

    @stack('scripts')
</body>
</html>
