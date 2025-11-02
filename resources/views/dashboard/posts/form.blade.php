<x-app-layout>
    <main class="main-content">
        <section id="blog-post-form" class="page-section">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0">{{ isset($post) ? 'Edit' : 'Create' }} Blog Post</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ isset($post) ? route('blog-posts.update', $post->id) : route('blog-posts.store') }}" enctype="multipart/form-data">
                                @csrf
                                @if(isset($post))
                                @method('PUT')
                                @endif

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Post Title *</label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                id="title" name="title" value="{{ old('title', $post->title ?? '') }}"
                                                placeholder="Enter post title" required>
                                            @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="blog_category_id" class="form-label">Category</label>
                                            <select class="form-select @error('blog_category_id') is-invalid @enderror"
                                                id="blog_category_id" name="blog_category_id">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('blog_category_id', $post->blog_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('blog_category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="excerpt" class="form-label">Excerpt</label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                        id="excerpt" name="excerpt" rows="2"
                                        placeholder="Brief description of the post">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                                    @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Content *</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror"
                                        id="content" name="content" rows="12"
                                        placeholder="Write your post content here..." required>{{ old('content', $post->content ?? '') }}</textarea>
                                    @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="featured_image" class="form-label">Featured Image</label>
                                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                                id="featured_image" name="featured_image" accept="image/*">
                                            @error('featured_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if(isset($post) && $post->featured_image)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $post->featured_image) }}"
                                                    alt="Featured Image" class="img-thumbnail" style="max-height: 100px;">
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status *</label>
                                            <select class="form-select @error('status') is-invalid @enderror"
                                                id="status" name="status" required>
                                                <option value="draft" {{ old('status', $post->status ?? 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status', $post->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                                                <option value="archived" {{ old('status', $post->status ?? '') == 'archived' ? 'selected' : '' }}>Archived</option>
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tags" class="form-label">Tags</label>
                                    <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                        id="tags" name="tags" value="{{ old('tags', isset($post) && $post->tags ? implode(',', $post->tags) : '') }}"
                                        placeholder="Enter tags separated by commas">
                                    @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Separate tags with commas (e.g., legal, advice, law)</small>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('blog-posts.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>
                                        {{ isset($post) ? 'Update' : 'Create' }} Post
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('scripts')
    <script>
        // Simple slug generation
        document.getElementById('title').addEventListener('blur', function() {
            const title = this.value;
            if (title) {
                // You can add a hidden slug field or generate slug on server side
                console.log('Generated slug from title:', title.toLowerCase().replace(/[^a-z0-9]+/g, '-'));
            }
        });
    </script>
    @endpush
</x-app-layout>