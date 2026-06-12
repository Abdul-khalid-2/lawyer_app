@csrf
<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-3">
            <label for="name" class="form-label">Name *</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $specialization->name ?? '') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="icon" class="form-label">Icon <small class="text-muted">(Font Awesome class)</small></label>
            <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror"
                value="{{ old('icon', $specialization->icon ?? '') }}" placeholder="fas fa-gavel">
            @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

<div class="form-group mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $specialization->description ?? '') }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-check form-switch mb-3">
    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
        {{ old('is_active', $specialization->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Active (selectable by lawyers and on the public site)</label>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('specializations.index') }}" class="btn btn-secondary">Cancel</a>
</div>
