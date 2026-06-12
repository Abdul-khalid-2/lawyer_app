/**
 * Sidebar toggle (mobile slide-in + desktop collapse) and tooltips.
 * Exposes toggleSidebar/closeSidebar globally for the inline onclick handlers
 * in the header/sidebar markup.
 */
export default function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const header = document.querySelector('.header');
    const mainContent = document.querySelector('.main-content');

    window.toggleSidebar = function () {
        if (!sidebar) return;
        if (window.innerWidth < 768) {
            sidebar.classList.toggle('active');
            overlay?.classList.toggle('active');
        } else {
            sidebar.classList.toggle('collapsed');
            header?.classList.toggle('collapsed');
            mainContent?.classList.toggle('collapsed');
        }
    };

    window.closeSidebar = function () {
        sidebar?.classList.remove('active');
        overlay?.classList.remove('active');
    };

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) window.closeSidebar();
    });
}

export function initTooltips() {
    if (typeof bootstrap === 'undefined') return;
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((el) => {
        new bootstrap.Tooltip(el);
    });
}
