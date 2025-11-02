<x-app-layout>

    <section id="blog-category-form" class="page-section">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{ isset($category) ? 'Edit' : 'Create' }} Blog Category</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ isset($category) ? route('blog-categories.update', $category->id) : route('blog-categories.store') }}">
                            @csrf
                            @if(isset($category))
                            @method('PUT')
                            @endif

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Category Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $category->name ?? '') }}"
                                            placeholder="Enter category name" required>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="icon" class="form-label">Icon</label>
                                        <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                            id="icon" name="icon" value="{{ old('icon', $category->icon ?? '') }}"
                                            placeholder="fas fa-folder">
                                        @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Use FontAwesome class names (e.g., fas fa-folder)
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    id="description" name="description" rows="3"
                                    placeholder="Enter category description">{{ old('description', $category->description ?? '') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                        value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active Category
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('blog-categories.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    {{ isset($category) ? 'Update' : 'Create' }} Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>