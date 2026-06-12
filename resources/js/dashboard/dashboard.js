/**
 * Dashboard bundle — single Vite entry for the admin/lawyer area.
 */
import initSidebar, { initTooltips } from './modules/sidebar';

initSidebar();

document.addEventListener('DOMContentLoaded', () => {
    initTooltips();
});
