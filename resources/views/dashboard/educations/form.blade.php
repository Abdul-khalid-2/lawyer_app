<x-app-layout>

    <section id="education-form" class="page-section">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{ isset($education) ? 'Edit' : 'Add' }} Education</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST"
                            action="{{ isset($education) ? route('educations.update', $education->id) : route('educations.store') }}">
                            @csrf
                            @if(isset($education))
                            @method('PUT')
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="degree" class="form-label">Degree *</label>
                                        <input type="text" class="form-control @error('degree') is-invalid @enderror"
                                            id="degree" name="degree"
                                            value="{{ old('degree', $education->degree ?? '') }}"
                                            placeholder="e.g., Juris Doctor (J.D.)" required>
                                        @error('degree')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="institution" class="form-label">Institution *</label>
                                        <input type="text" class="form-control @error('institution') is-invalid @enderror"
                                            id="institution" name="institution"
                                            value="{{ old('institution', $education->institution ?? '') }}"
                                            placeholder="e.g., Harvard Law School" required>
                                        @error('institution')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="graduation_year" class="form-label">Graduation Year *</label>
                                        <input type="number" class="form-control @error('graduation_year') is-invalid @enderror"
                                            id="graduation_year" name="graduation_year"
                                            value="{{ old('graduation_year', $education->graduation_year ?? '') }}"
                                            min="1900" max="{{ date('Y') + 5 }}"
                                            placeholder="e.g., 2020" required>
                                        @error('graduation_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="order" class="form-label">Display Order</label>
                                        <input type="number" class="form-control @error('order') is-invalid @enderror"
                                            id="order" name="order"
                                            value="{{ old('order', $education->order ?? 0) }}"
                                            min="0" max="100">
                                        @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Lower numbers appear first</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    id="description" name="description" rows="3"
                                    placeholder="Additional details about your education, achievements, or coursework">{{ old('description', $education->description ?? '') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('educations.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    {{ isset($education) ? 'Update' : 'Save' }} Education
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>