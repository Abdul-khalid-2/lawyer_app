@extends('website.layout.master')

@push('css')
<style>
    .auth-section {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 60px 0 40px;
    }
    .auth-card {
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: none;
        overflow: hidden;
        background: white;
        max-width: 600px;
        margin: 0 auto;
    }
    .auth-header {
        background: linear-gradient(135deg, #2980b9, #4a6583);
        color: white;
        padding: 2rem 1.5rem;
        text-align: center;
    }
    .auth-header h1 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: clamp(1.8rem, 4vw, 2.2rem);
    }
    .auth-header p {
        opacity: 0.9;
        margin-bottom: 0;
        font-size: clamp(1rem, 2.5vw, 1.1rem);
    }
    .auth-tabs {
        border-bottom: 1px solid #e9ecef;
        padding: 0;
        margin-bottom: 0;
        background: #f8f9fa;
        display: flex;
    }

    .auth-tabs .nav-item {
        flex: 1;
    }
    .auth-tabs .nav-link {
        padding: 1rem 0.5rem;
        font-weight: 600;
        color: #6c757d;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        font-size: clamp(0.85rem, 2vw, 1rem);
        width: 100%;
        text-align: center;
        white-space: nowrap;
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
        padding: 2rem 1.5rem;
    }
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #2c3e50;
        font-size: 0.9rem;
    }
    .form-control {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
        font-size: 1rem;
        width: 100%;
    }
    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
    }
    .password-toggle {
        position: relative;
        width: 100%;
    }
    .password-toggle-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
        transition: color 0.2s;
        padding: 8px;
        z-index: 2;
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
        font-size: 1rem;
        letter-spacing: 0.5px;
        width: 100%;
        margin-top: 0.5rem;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(52, 152, 219, 0.3);
    }
    .form-check-input:checked {
        background-color: #3498db;
        border-color: #3498db;
    }

    .form-check-label {
        font-size: 0.875rem;
        line-height: 1.4;
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
        margin-top: 1.5rem;
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
        height: 4px;
        margin-top: 0.5rem;
        border-radius: 2px;
        transition: all 0.3s;
        width: 100%;
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
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 0.5rem;
        line-height: 1.4;
    }

    /* Mobile-first responsive adjustments */
    @media (max-width: 768px) {
        .auth-section {
            padding: 40px 15px 30px;
        }

        .auth-header {
            padding: 1.5rem 1rem;
        }

        .auth-body {
            padding: 1.5rem 1rem;
        }

        .auth-tabs .nav-link {
            padding: 0.875rem 0.25rem;
            font-size: 0.85rem;
        }

        .auth-tabs .nav-link i {
            margin-right: 0.25rem !important;
        }

        .form-control {
            padding: 0.675rem 0.875rem;
            font-size: 16px; /* Prevents zoom on iOS */
        }

        .btn-primary {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }

        .row {
            margin-left: -8px;
            margin-right: -8px;
        }

        .row > [class*="col-"] {
            padding-left: 8px;
            padding-right: 8px;
        }
    }

    @media (max-width: 576px) {
        .auth-section {
            padding: 30px 10px 20px;
        }

        .auth-header {
            padding: 1.25rem 0.75rem;
        }

        .auth-body {
            padding: 1.25rem 0.75rem;
        }

        .auth-tabs .nav-link {
            padding: 0.75rem 0.125rem;
            font-size: 0.8rem;
        }

        .auth-tabs .nav-link i {
            display: block;
            margin: 0 auto 0.25rem !important;
            font-size: 1rem;
        }

        .form-label {
            font-size: 0.85rem;
        }

        .form-control {
            padding: 0.625rem 0.75rem;
        }

        .password-toggle-icon {
            right: 8px;
            padding: 6px;
        }

        .btn-primary {
            padding: 0.675rem 1.25rem;
        }

        .auth-footer {
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .auth-footer p {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 400px) {
        .auth-tabs .nav-link {
            font-size: 0.75rem;
            padding: 0.625rem 0.125rem;
        }

        .auth-tabs .nav-link i {
            font-size: 0.9rem;
            margin-bottom: 0.125rem !important;
        }

        .auth-header h1 {
            font-size: 1.6rem;
        }

        .auth-header p {
            font-size: 0.9rem;
        }
    }

    /* Extra small devices */
    @media (max-width: 360px) {
        .auth-section {
            padding: 20px 8px 15px;
        }

        .auth-header {
            padding: 1rem 0.5rem;
        }

        .auth-body {
            padding: 1rem 0.5rem;
        }

        .auth-tabs .nav-link {
            font-size: 0.7rem;
            padding: 0.5rem 0.125rem;
        }

        .form-control {
            padding: 0.5rem 0.625rem;
        }
    }

    /* Large screens */
    @media (min-width: 1200px) {
        .auth-card {
            max-width: 650px;
        }

        .auth-body {
            padding: 2.5rem 2rem;
        }
    }

    /* Fix for very tall screens */
    @media (min-height: 1000px) {
        .auth-section {
            display: flex;
            align-items: center;
            min-height: 100vh;
        }
    }

    /* Improved form spacing */
    .mb-3 {
        margin-bottom: 1rem !important;
    }

    /* Better select styling */
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }

    /* Error message styling */
    .mt-2 {
        margin-top: 0.5rem !important;
    }

    .text-danger {
        font-size: 0.8rem;
    }

    /* Ensure proper touch targets */
    @media (pointer: coarse) {
        .password-toggle-icon {
            padding: 12px;
            min-height: 44px;
            min-width: 44px;
        }

        .btn-primary {
            min-height: 44px;
        }

        .form-check-input {
            transform: scale(1.2);
            margin-right: 8px;
        }
    }

    .dropdown-search-container {
        position: relative;
        width: 100%;
    }

    .dropdown-search-input {
        position: relative;
    }

    .dropdown-search-input i {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .dropdown-search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 8px 8px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .dropdown-option {
        padding: 10px 15px;
        cursor: pointer;
        border-bottom: 1px solid #f8f9fa;
        transition: background-color 0.2s;
    }

    .dropdown-option:hover {
        background-color: #f8f9fa;
    }

    .dropdown-option:last-child {
        border-bottom: none;
    }

    .dropdown-search-results.show {
        display: block;
    }

    /* Selected option display */
    .selected-specialization {
        padding: 10px 15px;
        background: #e9ecef;
        border-radius: 6px;
        margin-top: 5px;
        display: none;
    }
</style>
@endpush

@section('content')
<section class="auth-section">
    <div class="container-fluid px-3 px-sm-4">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <div class="auth-card">
                    <div class="auth-header">
                        <h1>Create Your Account</h1>
                        <p>Join LegalConnect as a Client or Lawyer</p>
                    </div>
                    
                    <ul class="nav nav-tabs auth-tabs" id="registerTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="register-client-tab" data-bs-toggle="tab" data-bs-target="#register-client" type="button" role="tab">
                                <i class="fas fa-user me-1 me-sm-2"></i>
                                <span class="d-none d-sm-inline">Register as</span> Client
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="register-lawyer-tab" data-bs-toggle="tab" data-bs-target="#register-lawyer" type="button" role="tab">
                                <i class="fas fa-gavel me-1 me-sm-2"></i>
                                <span class="d-none d-sm-inline">Lawyer</span> Registration
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

                                    <div class="row g-2 g-sm-3">
                                        <div class="col-12 col-sm-6">
                                            <label for="clientFirstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="clientFirstName" name="first_name" value="{{ old('first_name') }}" required autofocus>
                                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label for="clientLastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="clientLastName" name="last_name" value="{{ old('last_name') }}" required>
                                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label for="clientRegEmail" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="clientRegEmail" name="email" value="{{ old('email') }}" required>
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <div class="mt-3">
                                        <label for="clientRegPassword" class="form-label">Password</label>
                                        <div class="password-toggle">
                                            <input type="password" class="form-control" id="clientRegPassword" name="password" required autocomplete="new-password">
                                            <span class="password-toggle-icon" role="button" aria-label="Toggle password visibility">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                        <div class="password-strength strength-weak"></div>
                                        <div class="form-note">Use 8+ characters with a mix of letters, numbers & symbols</div>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <div class="mt-3">
                                        <label for="clientConfirmPassword" class="form-label">Confirm Password</label>
                                        <div class="password-toggle">
                                            <input type="password" class="form-control" id="clientConfirmPassword" name="password_confirmation" required autocomplete="new-password">
                                            <span class="password-toggle-icon" role="button" aria-label="Toggle password visibility">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>

                                    <button type="submit" class="btn btn-primary">Register as User</button>
                                </form>

                                <div class="auth-footer">
                                    <p>Already have an account? <a class="primary me-2" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#loginModal">Sign In</a></p>
                                </div>
                            </div>

                            <!-- Lawyer Registration Form -->
                            <div class="tab-pane fade" id="register-lawyer" role="tabpanel">
                                <form method="POST" action="{{ route('register') }}" id="lawyerRegistrationForm">
                                    @csrf
                                    <input type="hidden" name="user_type" value="lawyer">

                                    <div class="row g-2 g-sm-3">
                                        <div class="col-12 col-sm-6">
                                            <label for="lawyerFirstName" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="lawyerFirstName" name="first_name" value="{{ old('first_name') }}" required>
                                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <label for="lawyerLastName" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lawyerLastName" name="last_name" value="{{ old('last_name') }}" required>
                                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label for="lawyerRegEmail" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="lawyerRegEmail" name="email" value="{{ old('email') }}" required>
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <div class="mt-3">
                                        <label for="lawyerPhone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="lawyerPhone" name="phone" value="{{ old('phone') }}" required>
                                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                    </div>

                                    <div class="mt-3">
                                        <label for="lawyerSpecialization" class="form-label">Primary Specialization</label>
                                        <div class="dropdown-search-container">
                                            <div class="dropdown-search-input">
                                                <input type="text" class="form-control" placeholder="Search specializations..." id="specializationSearch">
                                                <i class="fas fa-search"></i>
                                            </div>
                                            <div class="dropdown-search-results" id="specializationResults">
                                                @if(isset($specializations) && count($specializations) > 0)
                                                    @foreach($specializations as $specialization)
                                                        <div class="dropdown-option" data-value="{{ $specialization->id }}">
                                                            {{ $specialization->name }}
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="dropdown-option text-muted">No specializations available</div>
                                                @endif
                                            </div>
                                            <input type="hidden" name="specialization_id" id="selectedSpecialization" value="{{ old('specialization_id') }}" required>
                                        </div>
                                        <x-input-error :messages="$errors->get('specialization_id')" class="mt-2" />
                                    </div>

                                    <div class="mt-3">
                                        <label for="lawyerRegPassword" class="form-label">Password</label>
                                        <div class="password-toggle">
                                            <input type="password" class="form-control" id="lawyerRegPassword" name="password" required autocomplete="new-password">
                                            <span class="password-toggle-icon" role="button" aria-label="Toggle password visibility">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                        <div class="password-strength strength-weak"></div>
                                        <div class="form-note">Use 8+ characters with a mix of letters, numbers & symbols</div>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <div class="mt-3">
                                        <label for="lawyerConfirmPassword" class="form-label">Confirm Password</label>
                                        <div class="password-toggle">
                                            <input type="password" class="form-control" id="lawyerConfirmPassword" name="password_confirmation" required autocomplete="new-password">
                                            <span class="password-toggle-icon" role="button" aria-label="Toggle password visibility">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>

                                    <div class="mt-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="lawyerTermsAgree" name="terms" required>
                                        <label class="form-check-label" for="lawyerTermsAgree">
                                            I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>
                                        </label>
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
                
                // Update aria-label for accessibility
                const isVisible = type === 'text';
                this.setAttribute('aria-label', isVisible ? 'Hide password' : 'Show password');
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

        // Prevent zoom on iOS for input fields
        document.addEventListener('touchstart', function() {
            // This helps prevent zoom on focus in iOS
        }, { passive: true });
    });



    // Custom dropdown functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('specializationSearch');
        const resultsContainer = document.getElementById('specializationResults');
        const hiddenInput = document.getElementById('selectedSpecialization');
        const selectedDisplay = document.createElement('div');
        selectedDisplay.className = 'selected-specialization';
        resultsContainer.parentNode.insertBefore(selectedDisplay, resultsContainer.nextSibling);

        if (searchInput && resultsContainer) {
            // Show dropdown on focus
            searchInput.addEventListener('focus', function() {
                resultsContainer.classList.add('show');
                filterOptions();
            });

            // Filter options on input
            searchInput.addEventListener('input', filterOptions);

            // Handle option selection
            resultsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('dropdown-option')) {
                    const value = e.target.getAttribute('data-value');
                    const text = e.target.textContent;
                    
                    hiddenInput.value = value;
                    searchInput.value = '';
                    selectedDisplay.textContent = `Selected: ${text}`;
                    selectedDisplay.style.display = 'block';
                    resultsContainer.classList.remove('show');
                    
                    // Remove any existing selected class
                    document.querySelectorAll('.dropdown-option').forEach(opt => {
                        opt.classList.remove('selected');
                    });
                    e.target.classList.add('selected');
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown-search-container')) {
                    resultsContainer.classList.remove('show');
                }
            });

            function filterOptions() {
                const searchTerm = searchInput.value.toLowerCase();
                const options = resultsContainer.querySelectorAll('.dropdown-option');
                
                options.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });
            }

            // Initialize with existing value
            const initialValue = hiddenInput.value;
            if (initialValue) {
                const selectedOption = resultsContainer.querySelector(`[data-value="${initialValue}"]`);
                if (selectedOption) {
                    selectedDisplay.textContent = `Selected: ${selectedOption.textContent}`;
                    selectedDisplay.style.display = 'block';
                }
            }
        }
    });
</script>
@endpush