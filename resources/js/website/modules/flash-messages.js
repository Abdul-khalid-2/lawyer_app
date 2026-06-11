/**
 * Flash messages — shows SweetAlert popups for session success/error.
 * Reads payload from the #lc-flash JSON block rendered by the layout component.
 */
export default function initFlashMessages() {
    const el = document.getElementById('lc-flash');
    if (!el || typeof Swal === 'undefined') return;

    let flash;
    try {
        flash = JSON.parse(el.textContent);
    } catch {
        return;
    }

    if (flash.success) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: flash.success,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK',
        });
    }

    if (flash.error) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: flash.error,
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    }
}
