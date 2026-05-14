@extends('master')

@section('title', 'Data Inventaris')

@section('content')
    <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-4">
            <button onclick="toggleSidebar()" class="md:hidden w-10 h-10 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-primary">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
            <div class="hidden sm:block">
                <h2 class="text-xl font-bold text-slate-800">Katalog Inventaris</h2>
                <p class="text-xs text-slate-500">Kelola semua master data barang Anda di sini.</p>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <button class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-colors relative">
                <i class="fa-regular fa-bell text-lg"></i>
            </button>
        </div>
    </header>

    <div class="p-4 sm:p-8 flex-grow">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 reveal">
            <div class="relative group w-full md:w-auto">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" placeholder="Cari nama produk, SKU, atau kategori..."
                    class="w-full md:w-64 md:focus:w-96 pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm shadow-sm focus:ring-4 focus:ring-primary/20 focus:border-primary outline-none transition-all duration-300">
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <button class="flex-grow md:flex-grow-0 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-filter mr-2"></i> Filter
                </button>

                @can('manage-inventory')
                <button onclick="openModal('modalAdd')" class="flex-grow md:flex-grow-0 bg-primary hover:bg-primary_dark text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-md shadow-indigo-500/30 flex items-center justify-center group">
                    <i class="fa-solid fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i> Tambah Barang
                </button>
                @endcan
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden reveal delay-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">SKU</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Harga (Rp)</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach ($products as $product)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4 font-mono text-slate-500 text-xs font-medium">{{ $product->sku ?? '#EL-0992' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg bg-slate-100 mr-3 border border-slate-200 flex-shrink-0 overflow-hidden">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="Product" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                                    <i class="fa-solid fa-box"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="font-bold text-slate-800">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">{{ $product->category->name ?? 'Tanpa Kategori' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center text-emerald-600 font-bold bg-emerald-50 px-2.5 py-1 rounded-lg w-fit border border-emerald-100">
                                        <i class="fa-solid fa-check text-[10px] mr-1.5"></i> {{ $product->stock }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-800 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openModal('modalDetail_{{ $product->id }}')" class="action-btn w-8 h-8 rounded-lg bg-slate-50 text-indigo-600 border border-slate-200 hover:bg-indigo-50 transition-all flex items-center justify-center" title="Lihat Detail">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>

                                        @can('manage-inventory')
                                        <button onclick="openModal('modalEdit_{{ $product->id }}')" class="action-btn w-8 h-8 rounded-lg bg-slate-50 text-amber-500 border border-slate-200 hover:bg-amber-50 transition-all flex items-center justify-center" title="Edit Barang">
                                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                                        </button>
                                        <form action="{{ route('inventory-data.destroy', $product->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus barang ini?')" class="action-btn w-8 h-8 rounded-lg bg-slate-50 text-rose-500 border border-slate-200 hover:bg-rose-50 transition-all flex items-center justify-center" title="Hapus Barang">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 bg-slate-50/50">
                <p class="text-xs text-slate-500 font-medium">Menampilkan <span class="font-bold text-slate-800">Semua</span> barang</p>
            </div>
        </div>
    </div>

    @can('manage-inventory')
    <div id="modalAdd" class="custom-modal fixed inset-0 z-[60] flex items-center justify-center px-4 opacity-0 invisible pointer-events-none transition-all duration-300">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modalAdd')"></div>
        <div class="modal-panel bg-white rounded-2xl shadow-2xl w-full max-w-lg relative z-10 transform scale-95 translate-y-4 opacity-0 transition-all duration-300 ease-out">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-50 text-primary rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-box-open text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Tambah Barang Baru</h3>
                        <p class="text-xs text-slate-500">Masukkan detail informasi inventaris.</p>
                    </div>
                </div>
                <button onclick="closeModal('modalAdd')" class="text-slate-400 hover:text-rose-500 transition-colors focus:outline-none"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>

            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <form method="POST" action="{{ route('inventory-data.store') }}" class="space-y-5" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Foto Barang</label>
                        <input type="file" name="image" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-primary hover:file:bg-indigo-100" accept="image/*">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Nama Barang <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" placeholder="Contoh: Keyboard Mechanical RGB" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Kategori <span class="text-rose-500">*</span></label>
                        <select name="category_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium text-slate-800">
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Jumlah Stok <span class="text-rose-500">*</span></label>
                            <input type="number" name="stock" placeholder="0" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium text-slate-800">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Harga (Rp) <span class="text-rose-500">*</span></label>
                            <input type="number" name="price" placeholder="0" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:bg-white focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all text-sm font-medium text-slate-800">
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 rounded-b-2xl flex items-center justify-end gap-3 -mx-6 -mb-6 mt-6">
                        <button onclick="closeModal('modalAdd')" type="button" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-primary hover:bg-primary_dark shadow-lg shadow-primary/30 flex items-center gap-2 group transition-all">
                            <i class="fa-solid fa-floppy-disk group-hover:scale-110 transition-transform"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    @foreach ($products as $product)
        <div id="modalDetail_{{ $product->id }}" class="custom-modal fixed inset-0 z-[60] flex items-center justify-center px-4 opacity-0 invisible pointer-events-none transition-all duration-300">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modalDetail_{{ $product->id }}')"></div>
            <div class="modal-panel bg-white rounded-2xl shadow-2xl w-full max-w-lg relative z-10 transform scale-95 translate-y-4 opacity-0 transition-all duration-300 ease-out overflow-hidden">
                <div class="px-6 py-5 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white shadow-sm text-indigo-600 rounded-lg flex items-center justify-center border border-slate-100">
                            <i class="fa-solid fa-list-check text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">Spesifikasi Barang</h3>
                            <p class="text-xs text-slate-500 font-medium">Informasi detail inventaris saat ini.</p>
                        </div>
                    </div>
                    <button onclick="closeModal('modalDetail_{{ $product->id }}')" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-rose-500 hover:border-rose-200 hover:bg-rose-50 transition-all focus:outline-none">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="p-6">
                    <div class="flex flex-col sm:flex-row gap-6">
                        <div class="w-full sm:w-1/3 flex flex-col gap-2">
                            <div class="w-full aspect-square rounded-2xl bg-slate-50 border-2 border-slate-100 overflow-hidden relative group">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 bg-slate-50">
                                        <i class="fa-solid fa-image text-4xl mb-2"></i>
                                        <span class="text-[10px] font-bold uppercase tracking-wider">No Image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="text-center">
                                <span class="inline-block px-3 py-1 bg-slate-100 text-slate-600 font-mono text-[10px] font-bold rounded-lg border border-slate-200">
                                    <i class="fa-solid fa-barcode mr-1"></i> {{ $product->sku ?? 'NO-SKU' }}
                                </span>
                            </div>
                        </div>

                        <div class="w-full sm:w-2/3 space-y-3">
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Produk</p>
                                <p class="text-sm font-bold text-slate-800">{{ $product->name }}</p>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kategori</p>
                                <p class="text-sm font-bold text-indigo-600">{{ $product->category->name ?? 'Tanpa Kategori' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                                    <p class="text-[10px] font-bold text-emerald-600/70 uppercase tracking-wider mb-1">Stok Tersedia</p>
                                    <p class="text-sm font-black text-emerald-700">{{ $product->stock }} <span class="text-xs font-medium">Unit</span></p>
                                </div>
                                <div class="p-3 bg-amber-50 rounded-xl border border-amber-100">
                                    <p class="text-[10px] font-bold text-amber-600/70 uppercase tracking-wider mb-1">Harga Jual</p>
                                    <p class="text-sm font-black text-amber-700"><span class="text-xs font-medium">Rp</span> {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @can('manage-inventory')
        <div id="modalEdit_{{ $product->id }}" class="custom-modal fixed inset-0 z-[60] flex items-center justify-center px-4 opacity-0 invisible pointer-events-none transition-all duration-300">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('modalEdit_{{ $product->id }}')"></div>
            <div class="modal-panel bg-white rounded-2xl shadow-2xl w-full max-w-lg relative z-10 transform scale-95 translate-y-4 opacity-0 transition-all duration-300 ease-out">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-50 text-amber-500 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-pen-to-square text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">Edit Data Barang</h3>
                            <p class="text-xs text-slate-500">Perbarui informasi untuk SKU <span class="font-mono font-bold text-amber-500">{{ $product->sku ?? '-' }}</span></p>
                        </div>
                    </div>
                    <button onclick="closeModal('modalEdit_{{ $product->id }}')" class="text-slate-400 hover:text-rose-500 transition-colors focus:outline-none">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto max-h-[70vh]">
                    <form method="POST" action="{{ route('inventory-data.update', $product->id) }}" class="space-y-5" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 flex items-center gap-4">
                            <div class="w-16 h-16 rounded-lg overflow-hidden bg-white border border-slate-200 flex-shrink-0">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300"><i class="fa-solid fa-box text-xl"></i></div>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Ganti Foto (Opsional)</label>
                                <input type="file" name="image" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-600 hover:file:bg-amber-100 transition-colors cursor-pointer" accept="image/*">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Nama Barang <span class="text-rose-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-amber-500 transition-colors"><i class="fa-solid fa-cube text-sm"></i></div>
                                <input type="text" name="name" value="{{ $product->name }}" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all text-sm font-medium text-slate-800">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Kategori <span class="text-rose-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-amber-500 transition-colors"><i class="fa-solid fa-layer-group text-sm"></i></div>
                                <select name="category_id" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all text-sm font-medium text-slate-800 appearance-none cursor-pointer">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Jumlah Stok <span class="text-rose-500">*</span></label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-amber-500 transition-colors"><i class="fa-solid fa-hashtag text-sm"></i></div>
                                    <input type="number" name="stock" value="{{ $product->stock }}" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all text-sm font-medium text-slate-800">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1">Harga (Rp) <span class="text-rose-500">*</span></label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-amber-500 transition-colors"><i class="fa-solid fa-rupiah-sign text-sm"></i></div>
                                    <input type="number" name="price" value="{{ $product->price }}" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:bg-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all text-sm font-medium text-slate-800">
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 rounded-b-2xl flex items-center justify-end gap-3 -mx-6 -mb-6 mt-6">
                            <button onclick="closeModal('modalEdit_{{ $product->id }}')" type="button" class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 transition-colors">Batal</button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 shadow-lg shadow-amber-500/30 flex items-center gap-2 group transition-all">
                                <i class="fa-solid fa-floppy-disk group-hover:scale-110 transition-transform"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endcan
    @endforeach
@endsection
