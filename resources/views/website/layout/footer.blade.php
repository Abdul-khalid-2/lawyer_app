<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h4 class="mb-4">Law-Skoolyst</h4>
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
                    <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@Law-Skoolyst.com</li>
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
            <p class="mb-0">&copy; 2023 Law-Skoolyst. All rights reserved.</p>
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
