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
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <ul class="nav nav-tabs auth-tabs mb-4" id="loginTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="client-tab" data-bs-toggle="tab" data-bs-target="#client-login" type="button" role="tab">Client Login</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="lawyer-tab" data-bs-toggle="tab" data-bs-target="#lawyer-login" type="button" role="tab">Lawyer Login</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="loginTabsContent">
                        <!-- Client Login Form -->
                        <div class="tab-pane fade show active" id="client-login" role="tabpanel">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <input type="hidden" name="user_type" value="client">

                                <div class="mb-3">
                                    <label for="clientEmail" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="clientEmail" name="email" value="{{ old('email') }}" required autofocus>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <label for="clientPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="clientPassword" name="password" required>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Login as Client</button>
                            </form>

                            <div class="text-center mt-3">
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">Forgot your password?</a>
                                @endif
                            </div>
                        </div>

                        <!-- Lawyer Login Form -->
                        <div class="tab-pane fade" id="lawyer-login" role="tabpanel">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <input type="hidden" name="user_type" value="lawyer">

                                <div class="mb-3">
                                    <label for="lawyerEmail" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="lawyerEmail" name="email" value="{{ old('email') }}" required autofocus>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <label for="lawyerPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="lawyerPassword" name="password" required>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberLawyer" name="remember">
                                    <label class="form-check-label" for="rememberLawyer">Remember me</label>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Login as Lawyer</button>
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
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create an Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs auth-tabs mb-4" id="registerTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="register-client-tab" data-bs-toggle="tab" data-bs-target="#register-client" type="button" role="tab">Client Registration</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="register-lawyer-tab" data-bs-toggle="tab" data-bs-target="#register-lawyer" type="button" role="tab">Lawyer Registration</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="registerTabsContent">
                        <!-- Client Registration Form -->
                        <div class="tab-pane fade show active" id="register-client" role="tabpanel">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <input type="hidden" name="user_type" value="client">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="clientFirstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="clientFirstName" name="first_name" value="{{ old('first_name') }}" required autofocus>
                                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="clientLastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="clientLastName" name="last_name" value="{{ old('last_name') }}" required>
                                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="clientRegEmail" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="clientRegEmail" name="email" value="{{ old('email') }}" required>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <label for="clientRegPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="clientRegPassword" name="password" required autocomplete="new-password">
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <label for="clientConfirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="clientConfirmPassword" name="password_confirmation" required autocomplete="new-password">
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="termsAgree" name="terms" required>
                                    <label class="form-check-label" for="termsAgree">I agree to the <a href="#">Terms & Conditions</a></label>
                                    <x-input-error :messages="$errors->get('terms')" class="mt-2" />
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Register as Client</button>
                            </form>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}">Already registered?</a>
                            </div>
                        </div>

                        <!-- Lawyer Registration Form -->
                        <div class="tab-pane fade" id="register-lawyer" role="tabpanel">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <input type="hidden" name="user_type" value="lawyer">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="lawyerFirstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="lawyerFirstName" name="first_name" value="{{ old('first_name') }}" required autofocus>
                                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lawyerLastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lawyerLastName" name="last_name" value="{{ old('last_name') }}" required>
                                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="lawyerRegEmail" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="lawyerRegEmail" name="email" value="{{ old('email') }}" required>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <label for="lawyerPhone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="lawyerPhone" name="phone" value="{{ old('phone') }}">
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <label for="lawyerSpecialization" class="form-label">Primary Specialization</label>
                                    <select class="form-control" id="lawyerSpecialization" name="specialization">
                                        <option value="">Loading...</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('specialization')" class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <label for="lawyerRegPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="lawyerRegPassword" name="password" required autocomplete="new-password">
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <label for="lawyerConfirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="lawyerConfirmPassword" name="password_confirmation" required autocomplete="new-password">
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="lawyerTermsAgree" name="terms" required>
                                    <label class="form-check-label" for="lawyerTermsAgree">I agree to the <a href="#">Terms & Conditions</a></label>
                                    <x-input-error :messages="$errors->get('terms')" class="mt-2" />
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Register as Lawyer</button>
                            </form>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}">Already registered?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("{{ route('specializations.list') }}")
                .then(response => response.json())
                .then(data => {
                    let specializationSelect = document.getElementById("lawyerSpecialization");
                    specializationSelect.innerHTML = '<option value="">Select Specialization</option>';

                    data.forEach(spec => {
                        specializationSelect.innerHTML += `<option value="${spec.id}">${spec.name}</option>`;
                    });

                    // Restore old value if validation failed
                    @if(old('specialization'))
                    specializationSelect.value = "{{ old('specialization') }}";
                    @endif
                })
                .catch(err => {
                    console.error("Error loading specializations:", err);
                });
        });
    </script>

    @stack('js')

</body>

</html>