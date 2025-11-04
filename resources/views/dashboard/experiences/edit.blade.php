<x-app-layout>

    <section id="experience-form" class="page-section">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Edit Professional Experience</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('experiences.update', $experience->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="position" class="form-label">Position Title *</label>
                                        <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                                id="position" name="position" 
                                                value="{{ old('position', $experience->position) }}" 
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
                                                value="{{ old('company', $experience->company) }}" 
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
                                                value="{{ old('start_date', $experience->start_date->format('Y-m-d')) }}" 
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
                                                value="{{ old('end_date', $experience->end_date ? $experience->end_date->format('Y-m-d') : '') }}" 
                                                min="{{ old('start_date', $experience->start_date->format('Y-m-d')) }}"
                                                max="{{ date('Y-m-d') }}"
                                                {{ $experience->is_current ? 'disabled' : '' }}>
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="is_current" name="is_current" value="1"
                                                    {{ old('is_current', $experience->is_current) ? 'checked' : '' }}>
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
                                            placeholder="Describe your responsibilities, achievements, and key contributions in this role">{{ old('description', $experience->description) }}</textarea>
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
                                                value="{{ old('order', $experience->order) }}" 
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
                                <div>
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-save me-2"></i> Update Experience
                                    </button>
                                    <a href="{{ route('experiences.index') }}" class="btn btn-outline-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Experience Card -->
                <div class="card mt-4 border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="card-title mb-0">Danger Zone</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Once you delete this experience record, there is no going back. Please be certain.
                        </p>
                        <form action="{{ route('experiences.destroy', $experience->id) }}" method="POST" 
                                onsubmit="return confirm('Are you sure you want to delete this experience record? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i> Delete Experience
                            </button>
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
            } else {
                endDateInput.min = startDateInput.value;
            }
        });
    </script>
    @endpush
</x-app-layout>