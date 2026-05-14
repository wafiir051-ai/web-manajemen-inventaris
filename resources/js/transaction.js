import Chart from 'chart.js/auto';
window.Chart = Chart;

// 1. Mobile Sidebar Toggle
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebar-overlay');
let isSidebarOpen = false;

function toggleSidebar() {
    isSidebarOpen = !isSidebarOpen;
    if (isSidebarOpen) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        setTimeout(() => { overlay.classList.remove('opacity-0'); overlay.classList.add('opacity-100'); }, 10);
        document.body.style.overflow = 'hidden';
    } else {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.remove('opacity-100');
        overlay.classList.add('opacity-0');
        setTimeout(() => { overlay.classList.add('hidden'); }, 300);
        document.body.style.overflow = '';
    }
};

document.addEventListener("DOMContentLoaded", () => {
    // 2. Animasi Reveal saat di Scroll
    const reveals = document.querySelectorAll(".reveal");
    const revealOptions = { threshold: 0.1 };
    const productSelect = document.getElementById('product-select');
    const priceInput = document.getElementById('price-input');

    productSelect.addEventListener('change', function () {
        // Ambil atribut data-price dari option yang sedang dipilih
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');

        // Masukkan harganya ke input harga
        if (price) {
            priceInput.value = price;
        } else {
            priceInput.value = 0;
        }
    });

    const revealOnScroll = new IntersectionObserver(function (entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("active");
                observer.unobserve(entry.target);
            }
        });
    }, revealOptions);

    reveals.forEach(reveal => revealOnScroll.observe(reveal));

    // 3. Setup Chart.js Doughnut Chart
    const ctx = document.getElementById('valuationChart');
    if (ctx && window.chartData) {

        const dataValues = window.chartData;
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Barang Masuk', 'Barang Keluar'],
                datasets: [{
                    data: dataValues,
                    backgroundColor: ['#10b981', '#f43f5e'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { family: "'Inter', sans-serif", size: 12, weight: '600' }
                        }
                    }
                }
            }
        });
    }
});
