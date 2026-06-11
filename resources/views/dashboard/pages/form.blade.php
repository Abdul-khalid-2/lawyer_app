@csrf
<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-3">
            <label for="title">Title *</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title', $page?->title) }}" required>
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="slug">Slug <small class="text-muted">(blank = auto from title)</small></label>
            <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                value="{{ old('slug', $page?->slug) }}" placeholder="about-us">
            @error('slug')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="form-group mb-3">
    <label for="meta_description">Meta Description</label>
    <input type="text" name="meta_description" id="meta_description" maxlength="255"
        class="form-control @error('meta_description') is-invalid @enderror"
        value="{{ old('meta_description', $page?->meta_description) }}">
    @error('meta_description')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="content">Content <small class="text-muted">(HTML allowed)</small></label>
    <textarea name="content" id="content" rows="14" class="form-control @error('content') is-invalid @enderror">{{ old('content', $page?->content) }}</textarea>
    @error('content')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-check form-switch mb-3">
    <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1"
        {{ old('is_published', $page?->is_published) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_published">Published (visible on the website &amp; footer)</label>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('pages.index') }}" class="btn btn-secondary">Cancel</a>
</div>
