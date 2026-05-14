<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockflow - Buat Akun Baru</title>

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-800 bg-slate-50 antialiased min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- Elemen Dekoratif Latar Belakang -->
    <div class="blob bg-primary w-[500px] h-[500px] rounded-full -top-64 -left-64"></div>
    <div class="blob bg-purple-400 w-[400px] h-[400px] rounded-full bottom-0 -right-32"></div>

    <!-- Navbar Sederhana -->
    <nav class="w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="index.html" class="flex items-center group">
                    <div class="w-10 h-10 bg-primary text-white rounded-lg flex items-center justify-center font-bold text-xl mr-3 group-hover:rotate-12 transition-transform duration-300">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <span class="font-bold text-2xl text-dark tracking-tight">Stock<span class="text-primary">Flow</span></span>
                </a>
                <a href="{{ route('welcome') }}" class="text-slate-600 hover:text-primary font-medium transition-colors flex items-center">
                    <i class="fa-solid fa-arrow-left mr-2 text-sm"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <!-- Kontainer Utama Form -->
    <main class="flex-grow flex items-center justify-center px-4 py-12 md:py-20">
        <div class="max-w-xl w-full animate-fade-in-up">

            <!-- Card Form -->
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-indigo-100/50 border border-slate-100 overflow-hidden">
                <div class="p-8 md:p-12">

                    <!-- Header Form -->
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-extrabold text-dark mb-3">Mulai kembali Perjalanan Anda</h2>
                        <p class="text-slate-500">Masukkan akun untuk mengelola stok barang dengan sistem tercanggih.</p>
                    </div>

                    <form action="{{ route('login')}}" method="POST" class="space-y-5">

                        <!-- Input Email -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Alamat Email</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <input type="email" name="email" id="email" placeholder="nama@perusahaan.com" class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl transition-all" required>
                            </div>
                        </div>

                        <!-- Baris Password (Grid 2 Kolom di Desktop) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Password</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                                        <i class="fa-solid fa-lock"></i>
                                    </div>
                                    <input type="password" name="password" id="password" placeholder="••••••••" class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl transition-all" required>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Konfirmasi</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                                        <i class="fa-solid fa-shield-check"></i>
                                    </div>
                                    <input type="password" name="password_confirmation" id="passwordConfirmation" placeholder="••••••••" class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl transition-all" required>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Register Utama -->
                        <button type="submit" class="w-full bg-primary hover:bg-primary_hover text-white py-4 rounded-2xl font-bold text-lg transition-all transform hover:-translate-y-1 shadow-xl shadow-primary/30 mt-4 active:scale-95">
                            Masuk Sekarang
                        </button>

                        <!-- Pembatas (Or) -->
                        <div class="relative flex items-center py-4">
                            <div class="flex-grow border-t border-slate-200"></div>
                            <span class="flex-shrink mx-4 text-slate-400 text-xs font-bold uppercase tracking-widest">Atau</span>
                            <div class="flex-grow border-t border-slate-200"></div>
                        </div>

                        <!-- Tombol Google -->
                        <button type="button" class="w-full flex items-center justify-center gap-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 py-3.5 rounded-2xl font-semibold transition-all shadow-sm active:scale-95">
                            <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" class="w-5 h-5" alt="Google Logo">
                            <a href="{{ url('auth/google') }}">Masuk dengan Google</a>
                        </button>
                    </form>

                    <!-- Link ke Login -->
                    <p class="text-center mt-10 text-slate-600">
                        Belum memiliki akun?
                        <a href="{{ route('register.show')}}" class="text-primary font-bold hover:underline decoration-2 underline-offset-4">Daftar di sini</a>
                    </p>
                </div>
            </div>

            <!-- Footer Sederhana Bawah Form -->
            <p class="text-center mt-8 text-slate-400 text-sm">
                &copy; 2026 InvenPro Technologies. Dibuat dengan <i class="fa-solid fa-heart text-red-400"></i> di Bandung.
            </p>
        </div>
    </main>

</body>
</html>
