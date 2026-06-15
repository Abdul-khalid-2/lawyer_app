<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="Edit Profile" subtitle="Update your account and professional details" icon="fas fa-user-edit">
            <a href="{{ route('lawyer.profile.show') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Profile
            </a>
        </x-dashboard.page-header>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @php
            $personalFields = ['name', 'email', 'phone', 'gender', 'profile_image'];
            $professionalFields = ['bar_number', 'license_state', 'years_of_experience', 'firm_name', 'bio', 'website', 'hourly_rate', 'address', 'city', 'state', 'zip_code', 'country', 'services', 'awards', 'specializations'];
            $hasPersonalErrors = $errors->hasAny($personalFields);
            $hasProfessionalErrors = $errors->hasAny($professionalFields);
            $hasPasswordErrors = $errors->hasAny(['current_password', 'password', 'password_confirmation']);
            $defaultTab = session('active_tab')
                ?? ($hasPasswordErrors ? 'password' : ($hasProfessionalErrors ? 'professional' : 'personal'));
        @endphp

        @if($hasPersonalErrors)
        <div class="alert alert-danger" id="personal-errors">
            <strong>Please fix the following personal info errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($personalFields as $field)
                    @error($field)<li>{{ $message }}</li>@enderror
                @endforeach
            </ul>
        </div>
        @elseif($hasProfessionalErrors)
        <div class="alert alert-danger" id="professional-errors">
            <strong>Please fix the following professional info errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($professionalFields as $field)
                    @error($field)<li>{{ $message }}</li>@enderror
                @endforeach
            </ul>
        </div>
        @elseif($hasPasswordErrors)
        <div class="alert alert-danger" id="password-errors">
            <strong>Please fix the following password errors:</strong>
            <ul class="mb-0 mt-2">
                @error('current_password')<li>{{ $message }}</li>@enderror
                @error('password')<li>{{ $message }}</li>@enderror
                @error('password_confirmation')<li>{{ $message }}</li>@enderror
            </ul>
        </div>
        @endif

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
            <li class="nav-item"><button class="nav-link {{ $defaultTab === 'personal' ? 'active' : '' }}" type="button" data-tab="personal"><i class="fas fa-user me-1"></i> Personal Info</button></li>
            <li class="nav-item"><button class="nav-link {{ $defaultTab === 'professional' ? 'active' : '' }}" type="button" data-tab="professional"><i class="fas fa-briefcase me-1"></i> Professional Info</button></li>
            <!-- <li class="nav-item"><button class="nav-link {{ $defaultTab === 'password' ? 'active' : '' }}" type="button" data-tab="password"><i class="fas fa-key me-1"></i> Change Password</button></li> -->
        </ul>

        <!-- Personal Information -->
        <div class="tab-pane {{ $defaultTab === 'personal' ? 'active' : '' }}" id="personal-tab">
            <form method="POST" action="{{ route('lawyer.profile.update.personal') }}" enctype="multipart/form-data" id="personalForm" novalidate>
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0">Personal Information</h5></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $lawyer->user->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input disabled type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $lawyer->user->email) }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $lawyer->user->phone) }}">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $lawyer->user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $lawyer->user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $lawyer->user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-0">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/*">
                            @error('profile_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @if($lawyer->user->profile_image)
                            <div class="mt-2">
                                <img src="{{ asset('website/' . $lawyer->user->profile_image) }}" alt="Current Profile Image" class="rounded-circle" width="80" height="80" style="object-fit: cover;">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mb-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Personal Info</button>
                </div>
            </form>
        </div>

        <!-- Professional Information -->
        <div class="tab-pane {{ $defaultTab === 'professional' ? 'active' : '' }}" id="professional-tab">
            <form method="POST" action="{{ route('lawyer.profile.update.professional') }}" id="professionalForm" novalidate>
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0">Professional Information</h5></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="bar_number" class="form-label">Bar Number *</label>
                                <input type="text" class="form-control @error('bar_number') is-invalid @enderror" id="bar_number" name="bar_number" value="{{ old('bar_number', $lawyer->bar_number) }}" required>
                                @error('bar_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="license_state" class="form-label">License State *</label>
                                <input type="text" class="form-control @error('license_state') is-invalid @enderror" id="license_state" name="license_state" value="{{ old('license_state', $lawyer->license_state) }}" required>
                                @error('license_state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="years_of_experience" class="form-label">Years of Experience *</label>
                                <input type="number" class="form-control @error('years_of_experience') is-invalid @enderror" id="years_of_experience" name="years_of_experience" value="{{ old('years_of_experience', $lawyer->years_of_experience) }}" min="0" required>
                                @error('years_of_experience')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="firm_name" class="form-label">Firm Name</label>
                                <input type="text" class="form-control @error('firm_name') is-invalid @enderror" id="firm_name" name="firm_name" value="{{ old('firm_name', $lawyer->firm_name) }}">
                                @error('firm_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Specializations &amp; Experience</label>
                            <div class="row">
                                @php $assignedIds = old('specializations', $lawyer->specializations->pluck('id')->toArray()); @endphp
                                @foreach($specializations as $specialization)
                                    @php
                                        $assigned = $lawyer->specializations->firstWhere('id', $specialization->id);
                                        $isChecked = in_array($specialization->id, $assignedIds);
                                        $pivotExp = old('specialization_experience.' . $specialization->id, $assigned?->pivot?->years_of_experience ?? '');
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input specialization-checkbox" type="checkbox" id="spec_{{ $specialization->id }}" name="specializations[]" value="{{ $specialization->id }}" {{ $isChecked ? 'checked' : '' }}>
                                            <label class="form-check-label" for="spec_{{ $specialization->id }}">{{ $specialization->name }}</label>
                                        </div>
                                        <div class="mb-3 specialization-experience" style="{{ $isChecked ? '' : 'display:none;' }}">
                                            <input type="number" class="form-control form-control-sm" id="exp_{{ $specialization->id }}" name="specialization_experience[{{ $specialization->id }}]" min="0" value="{{ $pivotExp }}" placeholder="Years in {{ $specialization->name }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Professional Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4">{{ old('bio', $lawyer->bio) }}</textarea>
                            @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ old('website', $lawyer->website) }}" placeholder="https://example.com">
                                @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="hourly_rate" class="form-label">Hourly Rate (Rs)</label>
                                <input type="number" step="0.01" class="form-control @error('hourly_rate') is-invalid @enderror" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $lawyer->hourly_rate) }}">
                                @error('hourly_rate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $lawyer->address) }}">
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $lawyer->city) }}">
                                @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state', $lawyer->state) }}">
                                @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="zip_code" class="form-label">ZIP Code</label>
                                <input type="text" class="form-control @error('zip_code') is-invalid @enderror" id="zip_code" name="zip_code" value="{{ old('zip_code', $lawyer->zip_code) }}">
                                @error('zip_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="services" class="form-label">Services Offered</label>
                            <textarea class="form-control @error('services') is-invalid @enderror" id="services" name="services" rows="3">{{ old('services', $lawyer->services) }}</textarea>
                            @error('services')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-0">
                            <label for="awards" class="form-label">Awards &amp; Recognition</label>
                            <textarea class="form-control @error('awards') is-invalid @enderror" id="awards" name="awards" rows="3">{{ old('awards', $lawyer->awards) }}</textarea>
                            @error('awards')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mb-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Professional Info</button>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="tab-pane {{ $defaultTab === 'password' ? 'active' : '' }}" id="password-tab">
            <form method="POST" action="{{ route('lawyer.profile.password') }}" id="passwordForm" novalidate>
                @csrf
                @method('PUT')
                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0">Change Password</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password *</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required autocomplete="current-password">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password *</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-0">
                            <label for="password_confirmation" class="form-label">Confirm New Password *</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-key me-2"></i>Change Password</button>
                </div>
            </form>
        </div>
    </div>

    @push('css')
    <style>
        #profileTabs .nav-link { cursor: pointer; }
        .tab-pane { display: none; }
        .tab-pane.active { display: block; }
    </style>
    @endpush

    @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('#profileTabs [data-tab]');
            const panes = document.querySelectorAll('.tab-pane');

            function activateTab(target) {
                tabs.forEach(t => t.classList.toggle('active', t.getAttribute('data-tab') === target));
                panes.forEach(p => p.classList.remove('active'));
                const pane = document.getElementById(target + '-tab');
                if (pane) pane.classList.add('active');
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    activateTab(this.getAttribute('data-tab'));
                });
            });

            document.querySelectorAll('#personalForm, #professionalForm, #passwordForm').forEach(form => {
                form.addEventListener('submit', function (e) {
                    const invalid = form.querySelector(':invalid');
                    if (invalid) {
                        e.preventDefault();
                        invalid.classList.add('is-invalid');
                        invalid.reportValidity();
                        invalid.focus({ preventScroll: false });
                    }
                });

                form.querySelectorAll('input, select, textarea').forEach(field => {
                    field.addEventListener('input', function () {
                        if (this.checkValidity()) {
                            this.classList.remove('is-invalid');
                        }
                    });
                });
            });

            document.querySelectorAll('.specialization-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const wrap = this.closest('.col-md-6').querySelector('.specialization-experience');
                    if (wrap) wrap.style.display = this.checked ? '' : 'none';
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
