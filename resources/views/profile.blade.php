@extends('master')

@section('title', 'Profil')

@section('content')
    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
        <div class="flex items-center p-2 rounded-xl hover:bg-white hover:shadow-sm transition-all cursor-pointer group" >
            <div
                class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-white font-bold mr-3 text-xs shadow-sm group-hover:scale-105 transition-transform">
                <img src="https://ui-avatars.com/api/?name=Farel+Al+Gifary&background=4F46E5&color=fff" alt="Avatar"
                    class="rounded-full">
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-bold text-slate-900 truncate">{{ $user->name }}</p>
                <p class="text-[10px] text-slate-500 truncate uppercase font-semibold">{{ $user->role }}</p>
            </div>
        </div>
    </div>

    <header
        class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-4">
            <button onclick="toggleSidebar()"
                class="md:hidden w-10 h-10 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-dark">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
            <div class="hidden sm:block">
                <h2 class="text-xl font-bold text-slate-800">Pengaturan Profil</h2>
                <p class="text-xs text-slate-500">Kelola informasi pribadi dan preferensi akun Anda.</p>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <button
                class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-colors relative">
                <i class="fa-regular fa-bell"></i>
            </button>
        </div>
    </header>

    <div class="p-4 sm:p-8 flex-grow">
        <div class="max-w-6xl mx-auto">

            <div
                class="w-full h-40 md:h-48 rounded-t-3xl bg-gradient-to-r from-primary via-indigo-500 to-purple-600 relative overflow-hidden reveal shadow-md">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10">
                </div>
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/20 rounded-full blur-2xl"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 px-4 sm:px-8 -mt-16 md:-mt-20 relative z-10 pb-12">

                <div class="lg:col-span-1 reveal delay-100">
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-slate-100 flex flex-col items-center text-center p-6 pt-0 relative h-full">

                        <form id="avatar-form" action=" {{ route('profile.avatar.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div id="avatar-trigger" class="relative -mt-12 mb-4 group cursor-pointer">
                                <div class="w-28 h-28 rounded-full border-4 border-white shadow-lg overflow-hidden bg-white">
                                    <img src="{{ auth()->user()->profile?->avatar ? asset('storage/' . auth()->user()->profile->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=4F46E5&color=fff&size=200' }}"
                                        alt="Foto Profil" class="w-full h-full object-cover">
                                </div>
                                <div
                                    class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <i class="fa-solid fa-camera text-white text-xl"></i>
                                </div>
                                <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*">
                                <div
                                    class="absolute bottom-1 right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full">
                                </div>
                            </div>
                        </form>
4
                        <h3 class="text-xl font-black text-slate-900 mb-1">{{ $user->name }}</h3>
                        <div
                            class="flex items-center gap-2 text-primary font-semibold text-sm mb-4 px-3 py-1 bg-indigo-50 rounded-full">
                            {{ $user->role }}
                        </div>

                        <p class="text-xs text-slate-500 mb-6 leading-relaxed">
                            Bertanggung jawab atas pengelolaan sistem inventaris, pengembangan fitur baru, dan
                            manajemen pengguna Stockflow.
                        </p>

                        <div class="w-full space-y-3 mb-6">
                            <div
                                class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <div class="flex items-center gap-3 text-slate-600 text-sm">
                                    <i class="fa-solid fa-envelope text-slate-400"></i> Email
                                </div>
                                <span class="text-xs font-semibold text-slate-800">{{ $user->email }}</span>
                            </div>
                            <div
                                class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <div class="flex items-center gap-3 text-slate-600 text-sm">
                                    <i class="fa-solid fa-shield-halved text-slate-400"></i> Hak Akses
                                </div>
                                <span class="text-xs font-semibold text-emerald-600">{{ $user->role }}</span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="lg:col-span-2 reveal delay-200">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-[100px] pointer-events-none">
                        </div>

                        <div class="flex items-center gap-3 mb-8">
                            <div
                                class="w-10 h-10 bg-indigo-50 text-primary rounded-lg flex items-center justify-center text-lg">
                                <i class="fa-solid fa-user-pen"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-xl text-slate-900">Detail Informasi</h3>
                                <p class="text-sm text-slate-500">Perbarui data diri dan deskripsi profil Anda.</p>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="bg-red-100 text-red-600 p-4 mb-4 rounded-xl">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update')}}" class="space-y-6">
                            @csrf

                            @method('PATCH')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="input-group">
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Nama
                                        Lengkap</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 transition-colors">
                                            <i class="fa-solid fa-user text-sm"></i>
                                        </div>
                                        <input type="text" name="name" value="{{ old('name', auth()->user()->name)}}"
                                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium text-slate-800">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Posisi
                                        / Role <span class="text-rose-500">*</span></label>
                                    <div class="relative opacity-70 cursor-not-allowed">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                            <i class="fa-solid fa-briefcase text-sm"></i>
                                        </div>
                                        <input type="text" value="{{ $user->role }}" disabled
                                            class="w-full pl-11 pr-4 py-3.5 bg-slate-100 border border-slate-200 rounded-xl text-sm font-medium text-slate-600 cursor-not-allowed">
                                        <div
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                            <i class="fa-solid fa-lock text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group">
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Nomor
                                    Telepon</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 transition-colors">
                                        <i class="fa-solid fa-phone text-sm"></i>
                                    </div>
                                    <input type="text" name="phone_number" value="{{ old('phone_number', auth()->user()->profile->phone_number ?? '') }}" placeholder="+62 8XX XXXX XXXX"
                                        class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium text-slate-800">
                                </div>
                            </div>

                            <div class="input-group">
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Deskripsi
                                    & Biografi</label>
                                <div class="relative">
                                    <div
                                        class="absolute top-4 left-4 flex items-start pointer-events-none text-slate-400 transition-colors">
                                        <i class="fa-solid fa-align-left text-sm"></i>
                                    </div>
                                    <textarea rows="4" name="description"
                                        class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium text-slate-800 resize-none leading-relaxed">{{ old('description', auth()->user()->profile->description ?? '') }}</textarea>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-2 ml-1">Maksimal 250 karakter. Deskripsi ini
                                    akan terlihat oleh admin lain.</p>
                            </div>

                            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                                <button type="button"
                                    class="px-6 py-3 rounded-xl text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 hover:text-slate-800 transition-colors">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary_hover shadow-lg shadow-primary/30 flex items-center gap-2 group transition-all">
                                    <i class="fa-solid fa-floppy-disk group-hover:scale-110 transition-transform"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    <div
                        class="mt-6 bg-white rounded-2xl shadow-sm border border-rose-100 p-6 reveal delay-300 relative overflow-hidden group">
                        <div class="absolute top-0 left-0 w-1 h-full bg-rose-500"></div>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-slate-800 flex items-center gap-2">
                                    <i class="fa-solid fa-shield text-rose-500"></i> Keamanan Kata Sandi
                                </h4>
                                <p class="text-xs text-slate-500 mt-1">Sangat disarankan untuk mengubah kata sandi
                                    Anda secara berkala.</p>
                            </div>
                            <button
                                class="px-5 py-2.5 bg-rose-50 text-rose-600 border border-rose-200 rounded-xl text-xs font-bold hover:bg-rose-500 hover:text-white transition-colors">
                                Ubah Kata Sandi
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
