// --- 1. Animasi Slide-Down Form Tambah User ---
window.toggleAddUserPanel = function () {
    const panel = document.getElementById('addUserPanel');
    const icon = document.getElementById('plusIcon');

    if (panel.classList.contains('max-h-0')) {
        panel.classList.remove('max-h-0', 'opacity-0');
        panel.classList.add('max-h-[500px]', 'opacity-100');
        icon.classList.add('rotate-45', 'text-rose-400');
    } else {
        panel.classList.remove('max-h-[500px]', 'opacity-100');
        panel.classList.add('max-h-0', 'opacity-0');
        icon.classList.remove('rotate-45', 'text-rose-400');
    }
}

// --- 2. Animasi Dropdown Role ---
let openMenuId = null;

window.toggleRoleMenu = function (menuId) {
    const menu = document.getElementById(menuId);

    if (openMenuId && openMenuId !== menuId) {
        window.closeMenu(document.getElementById(openMenuId));
    }

    if (menu.classList.contains('opacity-0')) {
        menu.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
        menu.classList.add('opacity-100', 'scale-100', 'pointer-events-auto');
        openMenuId = menuId;
    } else {
        window.closeMenu(menu);
    }
}

window.closeMenu = function (menu) {
    if (!menu) return;
    menu.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
    menu.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
    openMenuId = null;
}

// Menutup dropdown role jika user melakukan klik di luar menu
document.addEventListener('click', function (event) {
    if (openMenuId) {
        const currentMenu = document.getElementById(openMenuId);
        const button = currentMenu.previousElementSibling;

        if (!currentMenu.contains(event.target) && !button.contains(event.target)) {
            window.closeMenu(currentMenu);
        }
    }
});

// --- 3. Reveal Animations On Scroll ---
// (Bagian ini tidak perlu diubah karena event listener berjalan otomatis)
document.addEventListener("DOMContentLoaded", () => {
    const reveals = document.querySelectorAll(".reveal");
    const revealOptions = { threshold: 0.1, rootMargin: "0px 0px -20px 0px" };
    const toggleAddUserBtn = document.getElementById('toggleAddUserBtn');
    const cancelAddUserBtn = document.getElementById('cancelAddUserBtn');

    if (toggleAddUserBtn) {
        toggleAddUserBtn.addEventListener('click', window.toggleAddUserPanel);
    }
    if (cancelAddUserBtn) {
        cancelAddUserBtn.addEventListener('click', window.toggleAddUserPanel);
    }

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
