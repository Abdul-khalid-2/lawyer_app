@csrf
<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="name">Full Name *</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $client?->user?->name) }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="email">Email (used to log in) *</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $client?->user?->email) }}" required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="password">Password {{ $client ? '(leave blank to keep current)' : '*' }}</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                {{ $client ? '' : 'required' }}>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                {{ $client ? '' : 'required' }}>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                value="{{ old('phone', $client?->phone) }}">
            @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="cnic">CNIC</label>
            <input type="text" name="cnic" id="cnic" class="form-control @error('cnic') is-invalid @enderror"
                value="{{ old('cnic', $client?->cnic) }}" placeholder="42101-1234567-1">
            @error('cnic')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-3">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                value="{{ old('address', $client?->address) }}">
            @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="city">City</label>
            <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror"
                value="{{ old('city', $client?->city) }}">
            @error('city')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="form-group mb-3">
    <label for="notes">Private Notes <small class="text-muted">(never visible to the client)</small></label>
    <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $client?->notes) }}</textarea>
    @error('notes')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@if($client)
<div class="form-group mb-3">
    <div class="form-check form-switch">
        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
            {{ old('is_active', $client->is_active) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Active</label>
    </div>
</div>
@endif

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancel</a>
</div>
