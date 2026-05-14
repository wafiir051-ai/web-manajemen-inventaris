// --- Sidebar ---
window.toggleSidebar = function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (!sidebar) return;
    sidebar.classList.toggle('-translate-x-full');
    overlay?.classList.toggle('hidden');
};

// --- Helper Animasi ---
function animateIn(modalId) {
    const modal = document.getElementById(modalId);
    const panel = modal.querySelector('.modal-panel') || modal.querySelector('div:nth-child(2)');
    modal.classList.remove('opacity-0', 'pointer-events-none');
    setTimeout(() => {
        panel.classList.remove('scale-95', 'translate-y-4', 'opacity-0');
        panel.classList.add('scale-100', 'translate-y-0', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

function animateOut(modalId) {
    const modal = document.getElementById(modalId);
    const panel = modal.querySelector('.modal-panel') || modal.querySelector('div:nth-child(2)');
    panel.classList.add('scale-95', 'translate-y-4', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('opacity-0', 'pointer-events-none');
        document.body.style.overflow = '';
    }, 300);
}

// --- Logic Modal Create ---
window.openCreateModal = () => animateIn('createModal');
window.closeCreateModal = () => animateOut('createModal');

// --- Logic Modal Edit ---
window.openEditModal = (id, name, desc) => {
    const form = document.getElementById('editForm');
    form.action = `/category/${id}`; // Sesuaikan route update Anda
    document.getElementById('editNameInput').value = name;
    document.getElementById('editDescInput').value = desc;
    animateIn('editModal');
};
window.closeEditModal = () => animateOut('editModal');

// --- Logic Modal Detail ---
window.openDetailModal = (name, desc, date) => {
    document.getElementById('detailName').innerText = name;
    document.getElementById('detailDesc').innerText = desc || 'Tidak ada deskripsi';
    document.getElementById('detailDate').innerText = date;

    // Khusus detail modal id panelnya berbeda sedikit di struktur Anda
    const modal = document.getElementById('detailModal');
    const panel = document.getElementById('detailPanel');
    modal.classList.remove('opacity-0', 'pointer-events-none');
    setTimeout(() => {
        panel.classList.remove('scale-95', 'opacity-0');
        panel.classList.add('scale-100', 'opacity-100');
    }, 10);
};
window.closeDetailModal = () => {
    const panel = document.getElementById('detailPanel');
    panel.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        document.getElementById('detailModal').classList.add('opacity-0', 'pointer-events-none');
    }, 300);
};

// --- Intersection Observer (Reveal) ---
document.addEventListener("DOMContentLoaded", () => {
    const reveals = document.querySelectorAll(".reveal");
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("active");
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    reveals.forEach(el => observer.observe(el));
});
