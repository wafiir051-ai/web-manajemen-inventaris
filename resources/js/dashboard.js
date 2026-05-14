import Chart from 'chart.js/auto';
window.Chart = Chart;

// Memastikan semua kode berjalan setelah HTML selesai dimuat
document.addEventListener("DOMContentLoaded", () => {

    // --- 1. Mobile Sidebar Toggle Logic ---
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    let isSidebarOpen = false;

    // "Melempar" fungsi ke objek window agar bisa dibaca oleh onclick di Blade
    window.toggleSidebar = function () {
        if (!sidebar || !overlay) return;

        isSidebarOpen = !isSidebarOpen;
        if (isSidebarOpen) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);
            document.body.style.overflow = '';
        }
    };

    // --- 2. Scroll Reveal Animation ---
    // Kode ini yang bertanggung jawab mengubah opacity 0 menjadi 1
    const reveals = document.querySelectorAll(".reveal");
    const revealOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    const revealOnScroll = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("active");
                observer.unobserve(entry.target);
            }
        });
    }, revealOptions);

    reveals.forEach(reveal => revealOnScroll.observe(reveal));

    // --- 3. Chart.js Initialization ---
    const chartCanvas = document.getElementById('inventoryChart');

    // Validasi: Hanya jalankan jika elemen canvas ada di halaman
    if (chartCanvas && typeof Chart !== 'undefined') {
        const ctx = chartCanvas.getContext('2d');

        // Tangkap data dari Blade, atau gunakan array kosong sebagai fallback
        const labels = window.dashboardChartLabels || ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        const dataIn = window.dashboardChartDataIn || [0, 0, 0, 0, 0, 0, 0];
        const dataOut = window.dashboardChartDataOut || [0, 0, 0, 0, 0, 0, 0];

        const gradientIn = ctx.createLinearGradient(0, 0, 0, 400);
        gradientIn.addColorStop(0, 'rgba(2, 132, 199, 0.8)');
        gradientIn.addColorStop(1, 'rgba(2, 132, 199, 0.2)');

        const gradientOut = ctx.createLinearGradient(0, 0, 0, 400);
        gradientOut.addColorStop(0, 'rgba(244, 63, 94, 0.8)');
        gradientOut.addColorStop(1, 'rgba(244, 63, 94, 0.2)');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, // Ganti ini
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: dataIn, // Ganti ini
                        backgroundColor: gradientIn,
                        borderRadius: 6,
                    },
                    {
                        label: 'Barang Keluar',
                        data: dataOut, // Ganti ini
                        backgroundColor: gradientOut,
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', align: 'end' }
                }
            }
        });
    }
});

// Logout Modal Logic
const logoutModal = document.getElementById('logout-modal');
const modalContent = document.getElementById('modal-content');

function handleLogout() {
    logoutModal.classList.remove('hidden');
    logoutModal.classList.add('flex');
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeLogoutModal() {
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        logoutModal.classList.remove('flex');
        logoutModal.classList.add('hidden');
    }, 300);
}
