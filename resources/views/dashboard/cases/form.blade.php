@csrf
<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-3">
            <label for="title">Case Title *</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title', $case?->title) }}" required>
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="case_number">Case Number</label>
            <input type="text" name="case_number" id="case_number" class="form-control @error('case_number') is-invalid @enderror"
                value="{{ old('case_number', $case?->case_number) }}" placeholder="e.g. CIV-123/2026">
            @error('case_number')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="client_id">Client *</label>
            <select name="client_id" id="client_id" class="form-select @error('client_id') is-invalid @enderror" required>
                <option value="">Select client...</option>
                @foreach($clients as $clientOption)
                <option value="{{ $clientOption->id }}" {{ old('client_id', $case?->client_id) == $clientOption->id ? 'selected' : '' }}>
                    {{ $clientOption->user?->name }}
                </option>
                @endforeach
            </select>
            @error('client_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="team_member_id">Assigned Team Member</label>
            <select name="team_member_id" id="team_member_id" class="form-select @error('team_member_id') is-invalid @enderror">
                <option value="">None</option>
                @foreach($teamMembers as $member)
                <option value="{{ $member->id }}" {{ old('team_member_id', $case?->team_member_id) == $member->id ? 'selected' : '' }}>
                    {{ $member->name }} ({{ $member->designation }})
                </option>
                @endforeach
            </select>
            @error('team_member_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="type">Case Type *</label>
            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                @foreach(\App\Models\LegalCase::TYPES as $type)
                <option value="{{ $type }}" {{ old('type', $case?->type ?? 'civil') === $type ? 'selected' : '' }}>
                    {{ ucfirst($type) }}
                </option>
                @endforeach
            </select>
            @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="court_name">Court Name</label>
            <input type="text" name="court_name" id="court_name" class="form-control @error('court_name') is-invalid @enderror"
                value="{{ old('court_name', $case?->court_name) }}" placeholder="e.g. Sindh High Court">
            @error('court_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="judge_name">Judge Name</label>
            <input type="text" name="judge_name" id="judge_name" class="form-control @error('judge_name') is-invalid @enderror"
                value="{{ old('judge_name', $case?->judge_name) }}">
            @error('judge_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="form-group mb-3">
    <label for="description">Description</label>
    <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $case?->description) }}</textarea>
    @error('description')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="status">Status *</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                @foreach(\App\Models\LegalCase::STATUSES as $status)
                <option value="{{ $status }}" {{ old('status', $case?->status ?? 'pending') === $status ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
                @endforeach
            </select>
            @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="filed_date">Filed Date</label>
            <input type="date" name="filed_date" id="filed_date" class="form-control @error('filed_date') is-invalid @enderror"
                value="{{ old('filed_date', $case?->filed_date?->format('Y-m-d')) }}">
            @error('filed_date')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3 mt-md-4 pt-md-2">
            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input" id="is_visible_to_client" name="is_visible_to_client" value="1"
                    {{ old('is_visible_to_client', $case?->is_visible_to_client ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_visible_to_client">Visible to client</label>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('cases.index') }}" class="btn btn-secondary">Cancel</a>
</div>
