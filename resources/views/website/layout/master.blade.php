<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LegalConnect - Find the Right Lawyer for Your Needs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('website/css/global.css') }}">

    @stack('css')


</head>

<body>

    @include('website.layout.navigation')

    @yield('content')
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h4 class="mb-4">LegalConnect</h4>
                    <p>Connecting clients with the right legal professionals since 2023. Our mission is to make legal representation accessible to everyone.</p>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5 class="mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home">Home</a></li>
                        <li class="mb-2"><a href="#lawyers">Find Lawyers</a></li>
                        <li class="mb-2"><a href="#how-it-works">How It Works</a></li>
                        <li class="mb-2"><a href="#about">About Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5 class="mb-4">For Lawyers</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Join as Lawyer</a></li>
                        <li class="mb-2"><a href="#">Lawyer Login</a></li>
                        <li class="mb-2"><a href="#">Resources</a></li>
                        <li class="mb-2"><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4 mb-4">
                    <h5 class="mb-4">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Legal Street, Law City</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> (555) 123-4567</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@legalconnect.com</li>
                    </ul>
                    <div class="d-flex mt-3">
                        <a href="#" class="me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-linkedin-in fa-lg"></i></a>
                        <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr class="mt-4 mb-4">
            <div class="text-center">
                <p class="mb-0">&copy; 2023 LegalConnect. All rights reserved.</p>
            </div>
        </div>
    </footer>




    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login to Your Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </form>

                            <div class="text-center mt-3">
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">Forgot your password?</a>
                                @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            @endif

            // Check for error message
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>

    <script>
        // public/js/auth.js
        class AuthManager {
            init() {
                this.setupLoginForms();
            }

            setupLoginForms() {
                // Setup all login forms on the page
                document.querySelectorAll('form[action*="login"]').forEach(form => {
                    form.addEventListener('submit', (e) => {
                        e.preventDefault();
                        this.handleLogin(form);
                    });
                });
            }

            async handleLogin(form) {
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;

                // Show loading
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Logging in...';

                try {
                    const formData = new FormData(form);

                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
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
                // Simple error display - you can customize this
                alert(message); // Or use your preferred notification system
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            new AuthManager().init();
        });
    </script>

    @stack('js')

</body>

</html>