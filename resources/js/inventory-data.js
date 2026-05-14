// 1. Scroll Reveal Animation (TETAP SAMA)
document.addEventListener("DOMContentLoaded", () => {
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
});

// 2. Fungsi Buka & Tutup Modal (YANG BARU)
window.openModal = function (modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('modal-active');
        // Tailwind class untuk visibility
        modal.classList.remove('opacity-0', 'invisible', 'pointer-events-none');

        // Animasi panel
        const panel = modal.querySelector('.modal-panel');
        if (panel) {
            panel.classList.remove('scale-95', 'translate-y-4', 'opacity-0');
            panel.classList.add('scale-100', 'translate-y-0', 'opacity-100');
        }

        document.body.style.overflow = 'hidden';
    }
};

window.closeModal = function (modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        // Balikkan animasi panel
        const panel = modal.querySelector('.modal-panel');
        if (panel) {
            panel.classList.remove('scale-100', 'translate-y-0', 'opacity-100');
            panel.classList.add('scale-95', 'translate-y-4', 'opacity-0');
        }

        // Timeout sedikit biar animasinya jalan sebelum di-hide total
        setTimeout(() => {
            modal.classList.remove('modal-active');
            modal.classList.add('opacity-0', 'invisible', 'pointer-events-none');
            document.body.style.overflow = '';
        }, 200);
    }
};
