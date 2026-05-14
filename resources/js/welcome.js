// Inisialisasi library animasi saat scroll
AOS.init({
    once: true, // Animasi hanya berjalan satu kali saat di-scroll
    offset: 50, // Jarak trigger animasi
});

// Efek Navbar transparan saat di atas, berbayang saat di-scroll
window.addEventListener('scroll', () => {
    const nav = document.getElementById('navbar');
    if (window.scrollY > 20) {
        nav.classList.add('shadow-sm');
        nav.classList.remove('py-2');
    } else {
        nav.classList.remove('shadow-sm');
        nav.classList.add('py-2');
    }
});
