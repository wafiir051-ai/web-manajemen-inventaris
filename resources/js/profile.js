// Scroll Reveal Animation Logic
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

document.addEventListener("DOMContentLoaded", () => {
    const avatarTrigger = document.getElementById('avatar-trigger');
    const avatarInput = document.getElementById('avatar-input');
    const avatarForm = document.getElementById('avatar-form');

    // 1. Saat area foto diklik, buka jendela pilih file
    if (avatarTrigger && avatarInput) {
        avatarTrigger.addEventListener('click', () => {
            avatarInput.click();
        });
    }

    // 2. Saat file selesai dipilih, otomatis submit form
    if (avatarInput && avatarForm) {
        avatarInput.addEventListener('change', () => {
            avatarForm.submit();
        });
    }

    // --- Logic Scroll Reveal kamu tetap di bawah sini ---
    const reveals = document.querySelectorAll(".reveal");
    const revealOnScroll = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("active");
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    reveals.forEach(reveal => revealOnScroll.observe(reveal));
});
