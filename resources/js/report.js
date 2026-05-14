document.addEventListener("DOMContentLoaded", () => {
    // --- 1. Animasi Reveal (Sama seperti sebelumnya) ---
    const reveals = document.querySelectorAll(".reveal");
    const revealOptions = { threshold: 0.1, rootMargin: "0px 0px -20px 0px" };

    const revealOnScroll = new IntersectionObserver(function (entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("active");
                observer.unobserve(entry.target);
            }
        });
    }, revealOptions);

    reveals.forEach(reveal => revealOnScroll.observe(reveal));

    // --- 2. Setup Chart.js ---
    const ctx = document.getElementById('valuationChart');

    // Pastikan ctx ada DAN data dari Blade (window.chartLabels) sudah terdefinisi
    if (ctx && window.chartLabels && window.chartData) {

        // Ambil data dari variabel global yang dideklarasikan di file Blade
        const labels = window.chartLabels;
        const dataValues = window.chartData;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: dataValues,
                    backgroundColor: [
                        '#3b82f6', // blue-500
                        '#a855f7', // purple-500
                        '#f59e0b', // amber-500
                        '#10b981', // emerald-500
                        '#f43f5e'  // rose-500
                    ],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0
                                    }).format(context.parsed);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }
});
