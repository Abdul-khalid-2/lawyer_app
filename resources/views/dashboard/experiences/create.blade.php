<x-app-layout>
    <section id="experience-form" class="page-section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Add Professional Experience</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('experiences.store') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="position" class="form-label">Position Title *</label>
                                        <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                                id="position" name="position" 
                                                value="{{ old('position') }}" 
                                                placeholder="e.g., Senior Attorney, Legal Counsel" required>
                                        @error('position')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="company" class="form-label">Company/Organization *</label>
                                        <input type="text" class="form-control @error('company') is-invalid @enderror" 
                                                id="company" name="company" 
                                                value="{{ old('company') }}" 
                                                placeholder="e.g., Smith & Associates Law Firm" required>
                                        @error('company')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date *</label>
                                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                                id="start_date" name="start_date" 
                                                value="{{ old('start_date') }}" 
                                                max="{{ date('Y-m-d') }}" required>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                                id="end_date" name="end_date" 
                                                value="{{ old('end_date') }}" 
                                                min="{{ old('start_date') }}"
                                                max="{{ date('Y-m-d') }}">
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="is_current" name="is_current" value="1"
                                                    {{ old('is_current') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_current">
                                                I currently work here
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Job Description & Responsibilities</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                            id="description" name="description" rows="4" 
                                            placeholder="Describe your responsibilities, achievements, and key contributions in this role">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Mention key cases handled, legal expertise demonstrated, or significant achievements.
                                </small>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="order" class="form-label">Display Order</label>
                                        <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                                id="order" name="order" 
                                                value="{{ old('order', 0) }}" 
                                                min="0" max="100">
                                        @error('order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Lower numbers appear first in your experience list</small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('experiences.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Back to Experiences
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Save Experience
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const isCurrentCheckbox = document.getElementById('is_current');

            // Set max date for start date to today
            startDateInput.max = new Date().toISOString().split('T')[0];

            // Update end date min date when start date changes
            startDateInput.addEventListener('change', function() {
                endDateInput.min = this.value;
                if (endDateInput.value && endDateInput.value < this.value) {
                    endDateInput.value = this.value;
                }
            });

            // Handle "I currently work here" checkbox
            isCurrentCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    endDateInput.value = '';
                    endDateInput.disabled = true;
                    endDateInput.removeAttribute('required');
                } else {
                    endDateInput.disabled = false;
                    endDateInput.setAttribute('required', 'required');
                }
            });

            // Initialize end date state based on checkbox
            if (isCurrentCheckbox.checked) {
                endDateInput.disabled = true;
                endDateInput.removeAttribute('required');
            }
        });
    </script>
    @endpush
</x-app-layout>