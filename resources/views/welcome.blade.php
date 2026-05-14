<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockflow - Smart Inventory Management</title>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-800 bg-slate-50 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Navbar -->
    <nav class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-20">
                <a href="index.html" class="flex-shrink-0 flex items-center group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-primary text-white rounded-lg flex items-center justify-center font-bold text-lg sm:text-xl mr-2 sm:mr-3 group-hover:rotate-12 transition-transform duration-300">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <span class="font-bold text-xl sm:text-2xl text-dark tracking-tight">Stock<span class="text-primary">Flow</span></span>
                </a>

                <!-- Desktop & Tablet Menu -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <button class="text-slate-600 hover:text-primary font-medium transition-colors px-2 sm:px-3 py-2 text-sm sm:text-base"><a href="{{ route('login.show') }}">Masuk</a></button>
                    <a href="{{ route('register.show') }}" class="bg-primary hover:bg-primary_hover text-white px-4 sm:px-6 py-2 sm:py-2.5 rounded-full font-medium text-sm sm:text-base transition-all transform hover:-translate-y-0.5 shadow-lg shadow-primary/30 whitespace-nowrap">
                        Daftar <span class="hidden xs:inline">Sekarang</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="bg-blob"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">

                <!-- Hero Left: Content -->
                <div class="max-w-2xl" data-aos="fade-right" data-aos-duration="1000">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-50 text-brand-700 font-medium text-sm mb-6 border border-brand-100">
                        <span class="flex h-2 w-2 rounded-full bg-brand-600"></span>
                        Versi 2.0 Kini Tersedia
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                        Kelola Inventaris Anda, <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-indigo-600">Lebih Cerdas.</span>
                    </h1>
                    <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                        Tinggalkan cara manual. StockFlow adalah web manajemen inventaris cerdas yang membantu Anda melacak stok real-time, mencegah overstock, dan mengotomatiskan laporan gudang hanya dalam hitungan detik.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register.show') }}" class="inline-flex justify-center items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold px-8 py-4 rounded-full transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-900/20 text-lg">
                            Start Now
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </a>
                        <a href="#" class="inline-flex justify-center items-center gap-2 bg-white border-2 border-slate-200 hover:border-slate-300 text-slate-700 font-semibold px-8 py-4 rounded-full transition-all duration-300 hover:bg-slate-50 text-lg">
                            <i class="fa-regular fa-circle-play text-brand-600"></i>
                            Lihat Demo
                        </a>
                    </div>
                </div>

                <!-- Hero Right: Image -->
                <div class="relative lg:ml-10" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl shadow-brand-900/20 border border-slate-100 animate-float">
                        <!-- Mac OS Window Dots -->
                        <div class="absolute top-0 left-0 w-full h-8 bg-slate-100/90 backdrop-blur border-b border-slate-200 flex items-center px-4 gap-2 z-10">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                        </div>
                        <!-- Using Unsplash for realistic dashboard/warehouse feel -->
                        <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Dashboard Inventaris" class="w-full h-auto object-cover pt-8">

                        <!-- Floating Badge Overlay -->
                        <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-xl border border-slate-100 flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xl">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Status Gudang</p>
                                <p class="text-sm font-bold text-slate-900">Sinkronisasi 100%</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                <h2 class="text-brand-600 font-semibold tracking-wide uppercase text-sm mb-3">Keunggulan Eksklusif</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Fitur Canggih yang Tidak Dimiliki Kompetitor</h3>
                <p class="text-slate-600 text-lg">Stockflow tidak hanya mencatat barang, tetapi berpikir layaknya asisten manajer gudang pribadi Anda.</p>
            </div>

            <!-- Features Grid (6 Cards) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- Card 1 -->
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-8 hover:bg-white transition-all duration-300 hover:shadow-xl hover:shadow-brand-500/10 hover:-translate-y-2 group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-file-export"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Integrasi PDF & Excel</h4>
                    <p class="text-slate-600 leading-relaxed">Ekspor laporan stok barang Anda ke format PDF profesional atau Excel secara instan. Impor data ribuan produk dari spreadsheet hanya dengan satu kali klik tanpa input manual.</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-8 hover:bg-white transition-all duration-300 hover:shadow-xl hover:shadow-brand-500/10 hover:-translate-y-2 group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Audit Opname 1-Klik via HP</h4>
                    <p class="text-slate-600 leading-relaxed">Ubah smartphone apapun menjadi scanner barcode profesional. Lakukan stock opname ribuan barang secara paralel bersama tim tanpa alat tambahan.</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-8 hover:bg-white transition-all duration-300 hover:shadow-xl hover:shadow-brand-500/10 hover:-translate-y-2 group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Smart Auto-PO Supplier</h4>
                    <p class="text-slate-600 leading-relaxed">Sistem secara otomatis menyusun draf Purchase Order (PO) PDF ke supplier Anda tepat saat stok menyentuh batas minimum yang ditetapkan.</p>
                </div>

                <!-- Card 4 -->
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-8 hover:bg-white transition-all duration-300 hover:shadow-xl hover:shadow-brand-500/10 hover:-translate-y-2 group" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-network-wired"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Routing Multi-Gudang Dinamis</h4>
                    <p class="text-slate-600 leading-relaxed">Punya banyak cabang? Sistem kami otomatis memproses pesanan dari gudang terdekat dengan pelanggan untuk menghemat biaya ongkos kirim.</p>
                </div>

                <!-- Card 5 -->
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-8 hover:bg-white transition-all duration-300 hover:shadow-xl hover:shadow-brand-500/10 hover:-translate-y-2 group" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-hourglass-end"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Pelacakan FEFO & Batch</h4>
                    <p class="text-slate-600 leading-relaxed">Sangat cocok untuk produk makanan & farmasi. Prioritaskan pengeluaran barang berdasarkan First Expired First Out (FEFO) secara sistematis.</p>
                </div>

                <!-- Card 6 -->
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-8 hover:bg-white transition-all duration-300 hover:shadow-xl hover:shadow-brand-500/10 hover:-translate-y-2 group" data-aos="fade-up" data-aos-delay="600">
                    <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Valuasi Aset Real-time</h4>
                    <p class="text-slate-600 leading-relaxed">Ketahui persis berapa nilai uang yang tertahan di gudang Anda setiap detiknya dengan laporan akuntansi inventaris berstandar internasional.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 bg-brand-600 relative overflow-hidden" data-aos="zoom-in">
        <!-- Abstract background elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-brand-700 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>

        <div class="max-w-4xl mx-auto px-4 relative z-10 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Siap Mengubah Cara Anda Berbisnis?</h2>
            <p class="text-brand-100 text-lg mb-10">Bergabung dengan 10.000+ perusahaan yang telah meningkatkan efisiensi gudang mereka hingga 80% menggunakan Stockflow.</p>
            <a href="{{ route('register.show')}}" class="inline-block bg-white text-brand-600 font-bold px-10 py-4 rounded-full transition-all duration-300 hover:scale-105 hover:shadow-2xl text-lg">
                Buat Akun Gratis Sekarang
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 pt-20 pb-10 border-t border-slate-800 text-slate-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">

                <!-- Brand Col -->
                <div data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center text-white">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <span class="font-bold text-2xl tracking-tight text-white">Stockflow<span class="text-brand-500">.</span></span>
                    </div>
                    <p class="text-slate-400 mb-6 leading-relaxed">
                        Sistem manajemen inventaris generasi masa depan. Dibangun dengan cinta di Bandung, untuk bisnis di seluruh dunia.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-brand-500 hover:text-white transition-all duration-300"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-brand-500 hover:text-white transition-all duration-300"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-brand-500 hover:text-white transition-all duration-300"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Product Col -->
                <div data-aos="fade-up" data-aos-delay="200">
                    <h4 class="text-white font-semibold text-lg mb-6">Produk</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-brand-400 transition-colors">Fitur Utama</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition-colors">Harga & Paket</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition-colors">Integrasi API</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition-colors">Aplikasi Mobile</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition-colors">Update Versi 2.0</a></li>
                    </ul>
                </div>

                <!-- Company Col -->
                <div data-aos="fade-up" data-aos-delay="300">
                    <h4 class="text-white font-semibold text-lg mb-6">Perusahaan</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-brand-400 transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition-colors">Karir <span class="bg-brand-500/20 text-brand-400 text-xs px-2 py-0.5 rounded ml-2">Hiring</span></a></li>
                        <li><a href="#" class="hover:text-brand-400 transition-colors">Blog & Edukasi</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition-colors">Studi Kasus</a></li>
                        <li><a href="#" class="hover:text-brand-400 transition-colors">Mitra Partner</a></li>
                    </ul>
                </div>

                <!-- Contact Col -->
                <div data-aos="fade-up" data-aos-delay="400">
                    <h4 class="text-white font-semibold text-lg mb-6">Hubungi Kami</h4>
                    <ul class="space-y-4 text-slate-400">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot mt-1 text-brand-500"></i>
                            <span>Desa Kumpay, Subang<br>Jawa Barat, Indonesia 40132</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-brand-500"></i>
                            <a href="mailto:halo@stockflow.id" class="hover:text-white transition-colors">halo@stockflow.id</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-brand-500"></i>
                            <span>+62 811-2233-4455</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Copyright -->
            <div class="border-t border-slate-800 pt-8 mt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-500 text-sm">
                    &copy; 2026 Stockflow. Hak cipta dilindungi undang-undang.
                </p>
                <div class="flex gap-6 text-sm text-slate-500">
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Keamanan Sistem</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script> AOS.init(); </script>
</body>
</html>
