@csrf
<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="name">Name *</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $teamMember->name ?? '') }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="designation">Designation *</label>
            <input type="text" name="designation" id="designation" class="form-control @error('designation') is-invalid @enderror"
                value="{{ old('designation', $teamMember->designation ?? '') }}"
                placeholder="e.g. Associate, Paralegal, Junior Counsel" required>
            @error('designation')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $teamMember->email ?? '') }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                value="{{ old('phone', $teamMember->phone ?? '') }}">
            @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="form-group mb-3">
    <label for="photo">Photo</label>
    <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
    @error('photo')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(!empty($teamMember?->photo))
    <div class="mt-2">
        <img src="{{ $teamMember->photo_url }}" alt="Current photo" class="rounded" style="width: 70px; height: 70px; object-fit: cover;">
        <small class="text-muted ms-2">Current photo — upload a new one to replace it.</small>
    </div>
    @endif
</div>

<div class="form-group mb-3">
    <label for="qualifications">Qualifications</label>
    <textarea name="qualifications" id="qualifications" rows="2" class="form-control @error('qualifications') is-invalid @enderror"
        placeholder="e.g. LL.B, Karachi University">{{ old('qualifications', $teamMember->qualifications ?? '') }}</textarea>
    @error('qualifications')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="bio">Bio</label>
    <textarea name="bio" id="bio" rows="4" class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $teamMember->bio ?? '') }}</textarea>
    @error('bio')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="years_of_experience">Years of Experience</label>
            <input type="number" name="years_of_experience" id="years_of_experience" min="0" max="60"
                class="form-control @error('years_of_experience') is-invalid @enderror"
                value="{{ old('years_of_experience', $teamMember->years_of_experience ?? 0) }}">
            @error('years_of_experience')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="order">Display Order</label>
            <input type="number" name="order" id="order" min="0"
                class="form-control @error('order') is-invalid @enderror"
                value="{{ old('order', $teamMember->order ?? 0) }}">
            <small class="form-text text-muted">Lower numbers appear first on your profile.</small>
            @error('order')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3 mt-md-4 pt-md-2">
            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                    {{ old('is_active', $teamMember->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active (shown on public profile)</label>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('team-members.index') }}" class="btn btn-secondary">Cancel</a>
</div>
