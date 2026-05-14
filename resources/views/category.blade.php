@extends('master')

@section('title', 'Kategori')

@section('content')
<div id="url-provider" data-store-url="{{ route('category.store') }}" style="display: none;"></div>

<header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30">
    <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()"
            class="md:hidden w-10 h-10 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-accent-500">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        <div class="hidden sm:block">
            <h2 class="text-xl font-bold text-slate-800 hidden sm:block">Kategori</h2>
            <p class="text-xs text-slate-500">Kelola semua kategori data barang Anda di sini.</p>
        </div>
    </div>
</header>

<div class="p-4 sm:p-8 flex-grow">
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 reveal">
            <div class="space-y-1">
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Kategori</h3>
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span>Total {{ $categories->count() }} Kategori Terdaftar</span>
                </div>
            </div>

            @can('manage-inventory')
            <button onclick="openCreateModal()"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all duration-300 shadow-lg shadow-indigo-200 group active:scale-95">
                <i class="fa-solid fa-plus transition-transform duration-500 group-hover:rotate-180"></i>
                <span>Buat Kategori Baru</span>
            </button>
            @endcan
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden reveal delay-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center w-16">No</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Info Kategori</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($categories as $category)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4 text-slate-500 font-medium text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">
                                        <i class="fa-solid fa-folder-open text-sm"></i>
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 block">{{ $category->name }}</span>
                                        <span class="text-xs text-slate-500">{{ $category->description ? Str::limit($category->description, 40) : 'Tidak ada deskripsi' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick='openDetailModal(@json($category->name), @json($category->description), @json($category->created_at ? $category->created_at->format("d M Y") : "-"))'
                                        class="w-9 h-9 rounded-lg bg-white text-indigo-500 border border-slate-200 hover:bg-indigo-50 transition-all flex items-center justify-center"
                                        title="Lihat Detail">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </button>

                                    @can('manage-inventory')
                                    <button onclick='openEditModal(@json($category->id), @json($category->name), @json($category->description))'
                                        class="w-9 h-9 rounded-lg bg-white text-amber-500 border border-slate-200 hover:bg-amber-50 transition-all flex items-center justify-center"
                                        title="Edit Kategori">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </button>

                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')"
                                            class="w-9 h-9 rounded-lg bg-white text-rose-500 border border-slate-200 hover:bg-rose-50 hover:border-rose-200 shadow-sm transition-all flex items-center justify-center"
                                            title="Hapus Kategori">
                                            <i class="fa-regular fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-folder-open text-4xl text-slate-300 mb-3"></i>
                                    <p class="font-medium text-slate-600">Belum ada data kategori</p>
                                    @can('manage-inventory')
                                    <p class="text-xs mt-1">Silakan tambahkan kategori baru terlebih dahulu.</p>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@can('manage-inventory')
<div id="createModal" class="fixed inset-0 z-[60] flex items-center justify-center px-4 opacity-0 pointer-events-none transition-all duration-300">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeCreateModal()"></div>

    <div class="modal-panel bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 transform scale-95 translate-y-4 opacity-0 transition-all duration-300 overflow-hidden">
        <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-900">Tambah Kategori</h3>
                <p class="text-xs text-slate-500 mt-1">Lengkapi detail kategori inventaris baru.</p>
            </div>
            <button onclick="closeCreateModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-400 hover:text-rose-500 hover:border-rose-100 transition-all shadow-sm">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('category.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Nama Kategori</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                        <i class="fa-solid fa-tag"></i>
                    </div>
                    <input type="text" name="name" placeholder="Masukan nama kategori..." required
                        class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 outline-none transition-all text-sm font-semibold text-slate-800 placeholder:text-slate-400 placeholder:font-normal">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Deskripsi Singkat</label>
                <div class="relative group">
                    <div class="absolute top-4 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                        <i class="fa-solid fa-align-left"></i>
                    </div>
                    <textarea name="description" rows="4" placeholder="Jelaskan penggunaan kategori ini..."
                        class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 outline-none transition-all text-sm font-semibold text-slate-800 placeholder:text-slate-400 placeholder:font-normal resize-none"></textarea>
                </div>
                <p class="text-[10px] text-slate-400 italic ml-1">*Deskripsi membantu staf gudang mengenali kelompok barang.</p>
            </div>

            <div class="pt-4 flex items-center gap-3">
                <button type="button" onclick="closeCreateModal()"
                    class="flex-1 px-5 py-3.5 rounded-2xl text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition-all active:scale-95">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 px-5 py-3.5 rounded-2xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center justify-center gap-2 active:scale-95 group">
                    <i class="fa-solid fa-check group-hover:scale-125 transition-transform"></i>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="fixed inset-0 z-[60] flex items-center justify-center px-4 opacity-0 pointer-events-none transition-all duration-300">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="modal-panel bg-white rounded-2xl shadow-2xl w-full max-w-md relative z-10 transform scale-95 translate-y-4 opacity-0 transition-all duration-300">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-xl font-bold text-slate-900">Edit Kategori</h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-rose-500"><i class="fa-solid fa-xmark text-xl"></i></button>
        </div>
        <form id="editForm" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Kategori</label>
                <input type="text" name="name" id="editNameInput" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" id="editDescInput" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all resize-none"></textarea>
            </div>
            <div class="pt-4 flex items-center justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 rounded-xl text-slate-600 font-bold border border-slate-200 hover:bg-slate-50 transition-all">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold shadow-lg shadow-amber-500/30 transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endcan

<div id="detailModal" class="fixed inset-0 z-[70] flex items-center justify-center px-4 opacity-0 pointer-events-none transition-all duration-300">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeDetailModal()"></div>
    <div id="detailPanel" class="bg-white rounded-2xl shadow-2xl w-full max-w-sm relative z-10 transform scale-95 opacity-0 transition-all duration-300 p-8 text-center">
        <div class="w-20 h-20 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-folder-open text-3xl"></i>
        </div>
        <h3 id="detailName" class="text-2xl font-bold text-slate-800 mb-2">---</h3>
        <p id="detailDesc" class="text-slate-500 text-sm mb-6">---</p>
        <div class="bg-slate-50 rounded-xl p-4 mb-6 flex justify-between items-center text-xs">
            <span class="text-slate-400 font-bold uppercase">Dibuat Pada</span>
            <span id="detailDate" class="text-slate-700 font-semibold">---</span>
        </div>
        <button onclick="closeDetailModal()" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-colors">Tutup Detail</button>
    </div>
</div>
@endsection
