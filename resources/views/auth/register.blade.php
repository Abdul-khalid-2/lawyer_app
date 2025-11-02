@extends('website.layout.master')

@push('css')
<style>
    .auth-section {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 80px 0 60px;
    }
    .auth-card {
        border-radius: 16px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        border: none;
        overflow: hidden;
        background: white;
        max-width: 600px;
        margin: 0 auto;
    }
    .auth-header {
        background: linear-gradient(135deg, #2980b9, #4a6583);
        color: white;
        padding: 2.5rem 2rem;
        text-align: center;
    }
    .auth-header h1 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 2.2rem;
    }
    .auth-header p {
        opacity: 0.9;
        margin-bottom: 0;
        font-size: 1.1rem;
    }
    .auth-tabs {
        border-bottom: 1px solid #e9ecef;
        padding: 0 2rem;
        margin-bottom: 0;
        background: #f8f9fa;
    }
    .auth-tabs .nav-link {
        padding: 1.25rem 2rem;
        font-weight: 600;
        color: #6c757d;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        font-size: 1rem;
        width: 100%;
        text-align: center;
    }
    .auth-tabs .nav-link.active {
        color: #2c3e50;
        background: transparent;
        border-bottom: 3px solid #3498db;
    }
    .auth-tabs .nav-link:hover {
        color: #2c3e50;
        border-bottom: 3px solid rgba(52, 152, 219, 0.5);
    }
    .auth-body {
        padding: 2.5rem 2rem;
    }
    .form-label {
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: #2c3e50;
        font-size: 0.95rem;
    }
    .form-control {
        padding: 0.875rem 1.25rem;
        border-radius: 10px;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
    }
    .password-toggle {
        position: relative;
    }
    .password-toggle-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
        transition: color 0.2s;
    }
    .password-toggle-icon:hover {
        color: #3498db;
    }
    .btn-primary {
        background: linear-gradient(135deg, #3498db, #2980b9);
        border: none;
        padding: 0.875rem 2rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-size: 1.05rem;
        letter-spacing: 0.5px;
        width: 100%;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(52, 152, 219, 0.3);
    }
    .form-check-input:checked {
        background-color: #3498db;
        border-color: #3498db;
    }
    .form-check-label a {
        color: #3498db;
        text-decoration: none;
        font-weight: 500;
    }
    .form-check-label a:hover {
        text-decoration: underline;
    }
    .auth-footer {
        text-align: center;
        padding-top: 1.5rem;
        border-top: 1px solid #e9ecef;
        margin-top: 2rem;
    }
    .auth-footer a {
        color: #3498db;
        text-decoration: none;
        font-weight: 500;
    }
    .auth-footer a:hover {
        text-decoration: underline;
    }
    .password-strength {
        height: 5px;
        margin-top: 0.5rem;
        border-radius: 3px;
        transition: all 0.3s;
    }
    .strength-weak {
        background-color: #e74c3c;
        width: 25%;
    }
    .strength-fair {
        background-color: #f39c12;
        width: 50%;
    }
    .strength-good {
        background-color: #3498db;
        width: 75%;
    }
    .strength-strong {
        background-color: #2ecc71;
        width: 100%;
    }
    .form-note {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }
</style>
@endpush

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="auth-card">
                    <div class="auth-header">
                        <h1>Create Your Account</h1>
                        <p>Join LegalConnect as a Client or Lawyer</p>
                    </div>
                    
                    <ul class="nav nav-tabs auth-tabs" id="registerTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="register-client-tab" data-bs-toggle="tab" data-bs-target="#register-client" type="button" role="tab">
                                <i class="fas fa-user me-2"></i> Register as Client
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="register-lawyer-tab" data-bs-toggle="tab" data-bs-target="#register-lawyer" type="button" role="tab">
                                <i class="fas fa-gavel me-2"></i> Register as Lawyer
                            </button>
                        </li>
                    </ul>
                    
                    <div class="auth-body">
                        <div class="tab-content" id="registerTabsContent">
                            <!-- Client Registration Form -->
                            <div class="tab-pane fade show active" id="register-client" role="tabpanel">
                                <form method="POST" action="{{ route('register') }}" id="clientRegistrationForm">
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
                                        <div class="password-toggle">
                                            <input type="password" class="form-control" id="clientRegPassword" name="password" required autocomplete="new-password">
                                            <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
                                        </div>
                                        <div class="password-strength strength-weak"></div>
                                        <div class="form-note">Use 8+ characters with a mix of letters, numbers & symbols</div>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="clientConfirmPassword" class="form-label">Confirm Password</label>
                                        <div class="password-toggle">
                                            <input type="password" class="form-control" id="clientConfirmPassword" name="password_confirmation" required autocomplete="new-password">
                                            <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
                                        </div>
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>

                                    <div class="mb-4 form-check">
                                        <input type="checkbox" class="form-check-input" id="termsAgree" name="terms" required>
                                        <label class="form-check-label" for="termsAgree">I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a></label>
                                        <x-input-error :messages="$errors->get('terms')" class="mt-2" />
                                    </div>

                                    <button type="submit" class="btn btn-primary">Register as Client</button>
                                </form>

                                <div class="auth-footer">
                                    <p>Already have an account? <a  class="primary me-2" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#loginModal">Sign In</a></p>
                                </div>
                            </div>

                            <!-- Lawyer Registration Form -->
                            <div class="tab-pane fade" id="register-lawyer" role="tabpanel">
                                <form method="POST" action="{{ route('register') }}" id="lawyerRegistrationForm">
                                    @csrf
                                    <input type="hidden" name="user_type" value="lawyer">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="lawyerFirstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="lawyerFirstName" name="first_name" value="{{ old('first_name') }}" required>
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
                                        <input type="tel" class="form-control" id="lawyerPhone" name="phone" value="{{ old('phone') }}" required>
                                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="lawyerSpecialization" class="form-label">Primary Specialization</label>
                                        <select class="form-control" id="lawyerSpecialization" name="specialization_id" required>
                                            <option value="">Select Specialization</option>
                                            @if(isset($specializations) && count($specializations) > 0)
                                                @foreach($specializations as $specialization)
                                                    <option value="{{ $specialization->id }}" {{ old('specialization_id') == $specialization->id ? 'selected' : '' }}>
                                                        {{ $specialization->name }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="">Loading specializations...</option>
                                            @endif
                                        </select>
                                        <x-input-error :messages="$errors->get('specialization_id')" class="mt-2" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="lawyerRegPassword" class="form-label">Password</label>
                                        <div class="password-toggle">
                                            <input type="password" class="form-control" id="lawyerRegPassword" name="password" required autocomplete="new-password">
                                            <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
                                        </div>
                                        <div class="password-strength strength-weak"></div>
                                        <div class="form-note">Use 8+ characters with a mix of letters, numbers & symbols</div>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="lawyerConfirmPassword" class="form-label">Confirm Password</label>
                                        <div class="password-toggle">
                                            <input type="password" class="form-control" id="lawyerConfirmPassword" name="password_confirmation" required autocomplete="new-password">
                                            <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
                                        </div>
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>

                                    <div class="mb-4 form-check">
                                        <input type="checkbox" class="form-check-input" id="lawyerTermsAgree" name="terms" required>
                                        <label class="form-check-label" for="lawyerTermsAgree">I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a></label>
                                        <x-input-error :messages="$errors->get('terms')" class="mt-2" />
                                    </div>

                                    <button type="submit" class="btn btn-primary">Register as Lawyer</button>
                                </form>

                                <div class="auth-footer">
                                    <p>Already have an account? <a class="primary me-2" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#loginModal">Sign In</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password visibility toggle
        const toggleIcons = document.querySelectorAll('.password-toggle-icon');
        toggleIcons.forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });

        // Password strength indicator for both forms
        const passwordInputs = document.querySelectorAll('input[type="password"][name="password"]');
        passwordInputs.forEach(input => {
            input.addEventListener('input', function() {
                const strengthBar = this.parentElement.nextElementSibling;
                const password = this.value;
                let strength = 0;
                
                if (password.length >= 8) strength++;
                if (/[a-z]/.test(password)) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;
                
                strengthBar.className = 'password-strength';
                if (password.length === 0) {
                    strengthBar.classList.add('strength-weak');
                    strengthBar.style.width = '0%';
                } else if (strength <= 2) {
                    strengthBar.classList.add('strength-weak');
                    strengthBar.style.width = '25%';
                } else if (strength === 3) {
                    strengthBar.classList.add('strength-fair');
                    strengthBar.style.width = '50%';
                } else if (strength === 4) {
                    strengthBar.classList.add('strength-good');
                    strengthBar.style.width = '75%';
                } else {
                    strengthBar.classList.add('strength-strong');
                    strengthBar.style.width = '100%';
                }
            });
        });

        // Real-time password confirmation validation for both forms
        const confirmPasswordInputs = document.querySelectorAll('input[name="password_confirmation"]');
        confirmPasswordInputs.forEach(confirmInput => {
            confirmInput.addEventListener('input', function() {
                const form = this.closest('form');
                const passwordInput = form.querySelector('input[name="password"]');
                const password = passwordInput.value;
                const confirmPassword = this.value;
                
                if (confirmPassword && password !== confirmPassword) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
        });

        // Reset forms when switching tabs
        const tabButtons = document.querySelectorAll('#registerTabs button');
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Clear any validation errors when switching tabs
                const forms = document.querySelectorAll('.tab-pane form');
                forms.forEach(form => {
                    const inputs = form.querySelectorAll('.is-invalid');
                    inputs.forEach(input => {
                        input.classList.remove('is-invalid');
                    });
                });
            });
        });
    });
</script>
@endpush