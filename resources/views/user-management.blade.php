@extends('master')

@section('title', 'Manajemen User & Akses')

@section('content')
    <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-4">
            <button onclick="toggleSidebar()" class="md:hidden w-10 h-10 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
            <div class="hidden sm:block">
                <h2 class="text-xl font-bold text-slate-800">Manajemen User & Akses</h2>
                <p class="text-xs text-slate-500">Kelola tim, hak akses, dan peran pengguna sistem Stockflow.</p>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <button class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-colors relative">
                <i class="fa-regular fa-bell"></i>
            </button>
        </div>
    </header>

    <div class="p-4 sm:p-8 flex-grow">
        <div class="max-w-7xl mx-auto">

            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-sm font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            @if(in_array(auth()->user()->role, ['owner', 'manager']))

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm mb-8 reveal overflow-hidden">
                    <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-4 relative z-10 bg-white">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-indigo-50 text-primary rounded-xl flex items-center justify-center text-xl shadow-inner border border-indigo-100">
                                <i class="fa-solid fa-users-gear"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 mb-0.5">Daftar Pengguna Sistem</h3>
                                <p class="text-slate-500 text-xs">Total {{ $users->count() }} pengguna terdaftar.</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="relative hidden sm:block">
                                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                                <input type="text" placeholder="Cari nama/email..." class="pl-8 pr-4 py-2 w-56 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                            </div>
                            <button id="toggleAddUserBtn" class="flex items-center gap-2 bg-primary hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-primary/20 group">
                                <i class="fa-solid fa-plus transition-transform duration-300" id="plusIcon"></i>
                                <span>Tambah Tim</span>
                            </button>
                        </div>
                    </div>

                    <div id="addUserPanel" class="max-h-0 opacity-0 overflow-hidden transition-all duration-500 ease-in-out bg-slate-50/50">
                        <div class="p-6 md:p-8 border-t border-slate-100">
                            <div class="flex items-center gap-2 mb-6">
                                <i class="fa-solid fa-user-plus text-primary"></i>
                                <h4 class="font-bold text-slate-800">Registrasi Akun Baru</h4>
                            </div>

                            <form action="{{ route('user-management.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                                @csrf
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2 ml-1">Nama Lengkap</label>
                                    <input type="text" name="name" required placeholder="Contoh: Budi Santoso" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2 ml-1">Alamat Email</label>
                                    <input type="email" name="email" required placeholder="budi@stockflow.com" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2 ml-1">Password</label>
                                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2 ml-1">Role Akses</label>
                                    <select name="role" required class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-sm appearance-none cursor-pointer">
                                        <option value="staff" selected>Staf Operasional</option>
                                        <option value="manager">Manager Gudang</option>
                                        <option value="auditor">Auditor (Hanya Lihat)</option>
                                        @if(auth()->user()->role === 'owner')
                                        <option value="owner">Owner / Super Admin</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="md:col-span-2 lg:col-span-4 flex justify-end mt-2">
                                    <button type="button" id="cancelAddUserBtn" class="px-5 py-2.5 text-slate-500 text-sm font-bold hover:bg-slate-100 rounded-xl transition-colors mr-2">Batal</button>
                                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center gap-2">
                                        <i class="fa-solid fa-floppy-disk"></i> Simpan Akun
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm reveal delay-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 border-b border-slate-100">
                                    <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-wider">Profil Pengguna</th>
                                    <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-wider">Status Akses</th>
                                    <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-wider text-center">Role / Jabatan</th>
                                    <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-wider text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">

                                @forelse($users as $user)
                                    @php
                                        // Setup warna avatar berdasarkan role
                                        $avatarColors = [
                                            'owner' => '4F46E5', // Indigo
                                            'manager' => '3B82F6', // Blue
                                            'staff' => '10B981', // Emerald
                                            'auditor' => 'F59E0B' // Amber
                                        ];
                                        $avatarBg = $avatarColors[$user->role] ?? '64748B';

                                        // Setup class tombol role berdasarkan role saat ini
                                        $roleStyles = [
                                            'owner' => ['bg' => 'bg-purple-50 hover:bg-purple-100 border-purple-100 text-purple-700', 'icon' => 'fa-user-tie', 'label' => 'Owner'],
                                            'manager' => ['bg' => 'bg-blue-50 hover:bg-blue-100 border-blue-100 text-blue-700', 'icon' => 'fa-user-gear', 'label' => 'Manager'],
                                            'staff' => ['bg' => 'bg-emerald-50 hover:bg-emerald-100 border-emerald-100 text-emerald-700', 'icon' => 'fa-user', 'label' => 'Staff'],
                                            'auditor' => ['bg' => 'bg-amber-50 hover:bg-amber-100 border-amber-100 text-amber-700', 'icon' => 'fa-user-shield', 'label' => 'Auditor'],
                                        ];
                                        $currentStyle = $roleStyles[$user->role] ?? $roleStyles['staff'];
                                    @endphp

                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background={{ $avatarBg }}&color=fff" class="w-10 h-10 rounded-full border-2 border-white shadow-sm object-cover">
                                                <div>
                                                    <p class="text-sm font-bold text-slate-900">{{ $user->name }}</p>
                                                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold border border-emerald-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="relative inline-block text-left">
                                                <button onclick="window.toggleRoleMenu('roleMenu-{{ $user->id }}')" class="inline-flex items-center justify-between w-40 px-3 py-1.5 border {{ $currentStyle['bg'] }} text-xs font-bold rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-opacity-20">
                                                    <span class="flex items-center gap-2"><i class="fa-solid {{ $currentStyle['icon'] }}"></i> {{ $currentStyle['label'] }}</span>
                                                    <i class="fa-solid fa-chevron-down text-[10px] opacity-70"></i>
                                                </button>

                                                <div id="roleMenu-{{ $user->id }}" class="absolute z-50 mt-2 w-48 rounded-xl bg-white shadow-lg border border-slate-100 opacity-0 scale-95 pointer-events-none origin-top transition-all duration-200 left-1/2 -translate-x-1/2 overflow-hidden">
                                                    <form action="{{ route('user-management.update', $user->id) }}" method="POST" class="p-2 space-y-1">
                                                        @csrf
                                                        @method('PUT')

                                                        @if(auth()->user()->role === 'owner')
                                                        <button type="submit" name="role" value="owner" class="w-full text-left px-3 py-2 text-xs font-bold rounded-lg flex items-center gap-2 transition-colors {{ $user->role === 'owner' ? 'bg-purple-50 text-purple-700' : 'text-slate-600 hover:bg-purple-50 hover:text-purple-600' }}">
                                                            <i class="fa-solid fa-user-tie w-4"></i> Owner
                                                            @if($user->role === 'owner') <i class="fa-solid fa-check ml-auto text-purple-500"></i> @endif
                                                        </button>
                                                        @endif

                                                        <button type="submit" name="role" value="manager" class="w-full text-left px-3 py-2 text-xs font-bold rounded-lg flex items-center gap-2 transition-colors {{ $user->role === 'manager' ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-600' }}">
                                                            <i class="fa-solid fa-user-gear w-4"></i> Manager
                                                            @if($user->role === 'manager') <i class="fa-solid fa-check ml-auto text-blue-500"></i> @endif
                                                        </button>

                                                        <button type="submit" name="role" value="staff" class="w-full text-left px-3 py-2 text-xs font-bold rounded-lg flex items-center gap-2 transition-colors {{ $user->role === 'staff' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                                                            <i class="fa-solid fa-user w-4"></i> Staff
                                                            @if($user->role === 'staff') <i class="fa-solid fa-check ml-auto text-emerald-500"></i> @endif
                                                        </button>

                                                        <button type="submit" name="role" value="auditor" class="w-full text-left px-3 py-2 text-xs font-bold rounded-lg flex items-center gap-2 transition-colors {{ $user->role === 'auditor' ? 'bg-amber-50 text-amber-700' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-600' }}">
                                                            <i class="fa-solid fa-user-shield w-4"></i> Auditor
                                                            @if($user->role === 'auditor') <i class="fa-solid fa-check ml-auto text-amber-500"></i> @endif
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center justify-end gap-2">
                                                <button class="w-8 h-8 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors flex items-center justify-center" title="Edit Pengguna">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>

                                                @if($user->id !== auth()->id())
                                                    <form action="{{ route('user-management.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                                        @csrf
                                                        @method('DELETE')

                                                        @if(auth()->user()->role === 'owner')
                                                        <button type="submit" class="w-8 h-8 rounded-lg text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-colors flex items-center justify-center" title="Hapus Pengguna">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                        @endif
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-slate-500 text-sm">
                                            <i class="fa-solid fa-users text-4xl text-slate-300 mb-3 block"></i>
                                            Belum ada pengguna terdaftar selain Anda.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

            @else
                <div class="bg-white p-10 rounded-2xl border border-slate-100 shadow-sm text-center mt-4">
                    <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-5">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">Area Terlarang</h3>
                    <p class="text-slate-500 mb-6 max-w-md mx-auto">
                        Maaf, Anda tidak memiliki izin otorisasi untuk mengakses halaman Manajemen Akses. Pengaturan sistem, tim, dan jabatan hanya dapat dilakukan oleh Owner atau Manajer.
                    </p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary_dark transition-colors shadow-lg shadow-primary/30">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Beranda
                    </a>
                </div>
            @endif

        </div>
    </div>
@endsection
