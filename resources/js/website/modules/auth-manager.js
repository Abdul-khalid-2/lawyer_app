/**
 * AuthManager — AJAX login handling for the login modal forms.
 * Moved from the inline script in website/layout/master.blade.php.
 */
export default class AuthManager {
    init() {
        this.setupLoginForms();
    }

    setupLoginForms() {
        document.querySelectorAll('form[action*="login"]').forEach((form) => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleLogin(form);
            });
        });
    }

    async handleLogin(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Logging in...';

        try {
            const formData = new FormData(form);

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json();

            if (data.success) {
                window.location.href = data.redirect;
            } else {
                this.showError(data.message || 'Login failed');
            }
        } catch (error) {
            this.showError('Network error. Please try again.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    }

    showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: message,
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK',
        });
    }
}
