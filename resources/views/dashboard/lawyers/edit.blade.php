<x-app-layout>
    <style>
        .profile-tabs .nav-link {
            border: none;
            padding: 1rem 1.5rem;
            color: #19191aff !important;
            font-weight: 500;
        }

        .profile-tabs .nav-link.active {
            color: #667eea;
            border-bottom: 3px solid #667eea;
            background: transparent;
        }

        .form-section {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }
    </style>

    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 mb-0">Edit Profile</h2>
                    <a href="{{ route('lawyer.profile.show') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Profile
                    </a>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Tabs -->
                <ul class="nav nav-tabs profile-tabs mb-4" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" type="button" data-tab="personal">
                            Personal Info
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" type="button" data-tab="professional">
                            Professional Info
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" type="button" data-tab="password">
                            Change Password
                        </button>
                    </li>
                </ul>

                <!-- Single Form for All Data -->
                <form method="POST" action="{{ route('lawyer.profile.update') }}" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    @method('PUT')

                    <!-- Personal Information Tab -->
                    <div class="tab-pane active" id="personal-tab">
                        <div class="form-section">
                            <h5 class="mb-4">Personal Information</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $lawyer->user->name) }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $lawyer->user->email) }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $lawyer->user->phone) }}">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $lawyer->user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $lawyer->user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $lawyer->user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="profile_image" class="form-label">Profile Image</label>
                                <input type="file" class="form-control @error('profile_image') is-invalid @enderror"
                                    id="profile_image" name="profile_image" accept="image/*">
                                @error('profile_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($lawyer->user->profile_image)
                                <div class="mt-2">
                                    <img src="{{ asset('website/' . $lawyer->user->profile_image) }}"
                                        alt="Current Profile Image"
                                        class="rounded-circle"
                                        width="80"
                                        height="80">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information Tab -->
                    <div class="tab-pane" id="professional-tab">
                        <div class="form-section">
                            <h5 class="mb-4">Professional Information</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="bar_number" class="form-label">Bar Number *</label>
                                    <input type="text" class="form-control @error('bar_number') is-invalid @enderror"
                                        id="bar_number" name="bar_number" value="{{ old('bar_number', $lawyer->bar_number) }}" required>
                                    @error('bar_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="license_state" class="form-label">License State *</label>
                                    <input type="text" class="form-control @error('license_state') is-invalid @enderror"
                                        id="license_state" name="license_state" value="{{ old('license_state', $lawyer->license_state) }}" required>
                                    @error('license_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="years_of_experience" class="form-label">Years of Experience *</label>
                                    <input type="number" class="form-control @error('years_of_experience') is-invalid @enderror"
                                        id="years_of_experience" name="years_of_experience"
                                        value="{{ old('years_of_experience', $lawyer->years_of_experience) }}" min="0" required>
                                    @error('years_of_experience')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="firm_name" class="form-label">Firm Name</label>
                                    <input type="text" class="form-control @error('firm_name') is-invalid @enderror"
                                        id="firm_name" name="firm_name" value="{{ old('firm_name', $lawyer->firm_name) }}">
                                    @error('firm_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Specializations & Experience</label>
                                <div class="row">
                                    @foreach($specializations as $specialization)
                                        @php
                                            $isChecked = in_array($specialization->id, old('specializations', $lawyer->specializations->pluck('id')->toArray()));
                                            $pivotExp = old('specialization_experience.' . $specialization->id, $lawyer->specializations->find($specialization->id)->pivot->years_of_experience ?? '');
                                        @endphp

                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input 
                                                    class="form-check-input specialization-checkbox" 
                                                    type="checkbox" 
                                                    id="spec_{{ $specialization->id }}" 
                                                    name="specializations[]" 
                                                    value="{{ $specialization->id }}"
                                                    {{ $isChecked ? 'checked' : '' }}>
                                                <label class="form-check-label" for="spec_{{ $specialization->id }}">
                                                    {{ $specialization->name }}
                                                </label>
                                            </div>

                                            <div class="mb-3 specialization-experience" style="{{ $isChecked ? '' : 'display:none;' }}">
                                                <label for="exp_{{ $specialization->id }}" class="form-label">Years of Experience</label>
                                                <input 
                                                    type="number" 
                                                    class="form-control" 
                                                    id="exp_{{ $specialization->id }}" 
                                                    name="specialization_experience[{{ $specialization->id }}]" 
                                                    min="0"
                                                    value="{{ $pivotExp }}"
                                                    placeholder="Years of experience in {{ $specialization->name }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>




                            <div class="mb-3">
                                <label for="bio" class="form-label">Professional Bio</label>
                                <textarea class="form-control @error('bio') is-invalid @enderror"
                                    id="bio" name="bio" rows="4">{{ old('bio', $lawyer->bio) }}</textarea>
                                @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror"
                                        id="website" name="website" value="{{ old('website', $lawyer->website) }}">
                                    @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="hourly_rate" class="form-label">Hourly Rate (Rs)</label>
                                    <input type="number" step="0.01" class="form-control @error('hourly_rate') is-invalid @enderror"
                                        id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $lawyer->hourly_rate) }}">
                                    @error('hourly_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" value="{{ old('address', $lawyer->address) }}">
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                        id="city" name="city" value="{{ old('city', $lawyer->city) }}">
                                    @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror"
                                        id="state" name="state" value="{{ old('state', $lawyer->state) }}">
                                    @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="zip_code" class="form-label">ZIP Code</label>
                                    <input type="text" class="form-control @error('zip_code') is-invalid @enderror"
                                        id="zip_code" name="zip_code" value="{{ old('zip_code', $lawyer->zip_code) }}">
                                    @error('zip_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="services" class="form-label">Services Offered</label>
                                <textarea class="form-control @error('services') is-invalid @enderror"
                                    id="services" name="services" rows="3">{{ old('services', $lawyer->services) }}</textarea>
                                @error('services')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="awards" class="form-label">Awards & Recognition</label>
                                <textarea class="form-control @error('awards') is-invalid @enderror"
                                    id="awards" name="awards" rows="3">{{ old('awards', $lawyer->awards) }}</textarea>
                                @error('awards')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Profile
                        </button>
                    </div>
                </form>

                <!-- Separate Password Change Form -->
                <div class="tab-pane" id="password-tab">
                    <form method="POST" action="{{ route('lawyer.profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-section">
                            <h5 class="mb-4">Change Password</h5>

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password *</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" required>
                                @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password *</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password *</label>
                                <input type="password" class="form-control"
                                    id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-key me-2"></i>Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('[data-tab]');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');

                    // Update active tab
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    // Show target tab content
                    tabPanes.forEach(pane => pane.classList.remove('active'));
                    document.getElementById(targetTab + '-tab').classList.add('active');
                });
            });
        });
    </script>
    <script>
        document.querySelectorAll('.specialization-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const experienceInput = this.closest('.col-md-6').querySelector('.specialization-experience');
                experienceInput.style.display = this.checked ? '' : 'none';
            });
        });
    </script>
</x-app-layout>