<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header :title="$case->title" icon="fas fa-briefcase"
            :subtitle="($case->case_number ?? 'No case number') . ' · ' . ucfirst(str_replace('_', ' ', $case->status))">
            <a href="{{ route('cases.edit', $case) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('cases.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </x-dashboard.page-header>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <ul class="nav nav-tabs mb-3" id="caseTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                    <i class="fas fa-info-circle"></i> Overview
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">
                    <i class="fas fa-file-alt"></i> Documents <span class="badge bg-secondary">{{ $case->documents->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab">
                    <i class="fas fa-sticky-note"></i> Notes <span class="badge bg-secondary">{{ $case->notes->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="hearings-tab" data-bs-toggle="tab" data-bs-target="#hearings" type="button" role="tab">
                    <i class="fas fa-gavel"></i> Hearings <span class="badge bg-secondary">{{ $case->hearings->count() }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content" id="caseTabsContent">
            {{-- Overview --}}
            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header"><h5 class="card-title mb-0">Case Details</h5></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Client:</strong>
                                            <a href="{{ route('clients.show', $case->client) }}">{{ $case->client?->user?->name }}</a>
                                        </p>
                                        <p><strong>Type:</strong> {{ ucfirst($case->type) }}</p>
                                        <p><strong>Court:</strong> {{ $case->court_name ?? '—' }}</p>
                                        <p><strong>Judge:</strong> {{ $case->judge_name ?? '—' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Assigned to:</strong> {{ $case->teamMember?->name ?? 'Not assigned' }}</p>
                                        <p><strong>Filed:</strong> {{ $case->filed_date?->format('d M Y') ?? '—' }}</p>
                                        <p><strong>Next hearing:</strong>
                                            @if($case->next_hearing_date)
                                            <span class="text-danger fw-bold">{{ $case->next_hearing_date->format('d M Y') }}</span>
                                            @else
                                            —
                                            @endif
                                        </p>
                                        <p><strong>Client visibility:</strong>
                                            <span class="badge bg-{{ $case->is_visible_to_client ? 'success' : 'secondary' }}">
                                                {{ $case->is_visible_to_client ? 'Visible to client' : 'Hidden from client' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                @if($case->description)
                                <hr>
                                <p class="mb-0">{{ $case->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header"><h5 class="card-title mb-0">Change Status</h5></div>
                            <div class="card-body">
                                <form action="{{ route('cases.status', $case) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group">
                                        <select name="status" class="form-select">
                                            @foreach(\App\Models\LegalCase::STATUSES as $status)
                                            <option value="{{ $status }}" {{ $case->status === $status ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Documents --}}
            <div class="tab-pane fade" id="documents" role="tabpanel">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                @forelse($case->documents as $document)
                                <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2 flex-wrap gap-2">
                                    <div>
                                        <a href="{{ $document->file_url }}" target="_blank" class="fw-bold">
                                            <i class="fas fa-file"></i> {{ $document->title }}
                                        </a>
                                        <p class="small text-muted mb-0">
                                            {{ strtoupper($document->file_type) }} · {{ $document->human_file_size }}
                                            · uploaded {{ $document->created_at->format('d M Y') }} by {{ $document->uploader?->name }}
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="{{ route('cases.documents.visibility', [$case, $document]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-{{ $document->is_visible_to_client ? 'success' : 'secondary' }}"
                                                title="Toggle client visibility">
                                                <i class="fas fa-{{ $document->is_visible_to_client ? 'eye' : 'eye-slash' }}"></i>
                                                {{ $document->is_visible_to_client ? 'Visible to client' : 'Hidden from client' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('cases.documents.destroy', [$case, $document]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this document?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-file-alt fa-2x mb-2 d-block"></i>
                                    No documents uploaded yet.
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header"><h5 class="card-title mb-0">Upload Document</h5></div>
                            <div class="card-body">
                                <form action="{{ route('cases.documents.store', $case) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="doc_title">Title *</label>
                                        <input type="text" name="title" id="doc_title" class="form-control" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="document">File * <small class="text-muted">(pdf, doc, docx, jpg, png — max 10MB)</small></label>
                                        <input type="file" name="document" id="document" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input type="checkbox" class="form-check-input" id="doc_visible" name="is_visible_to_client" value="1">
                                        <label class="form-check-label" for="doc_visible">Visible to client</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-upload"></i> Upload
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            <div class="tab-pane fade" id="notes" role="tabpanel">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                @forelse($case->notes->sortByDesc('created_at') as $note)
                                <div class="border rounded p-3 mb-2 {{ $note->is_private ? 'bg-light' : '' }}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <p class="mb-1">{{ $note->note }}</p>
                                            <p class="small text-muted mb-0">
                                                {{ $note->user?->name }} · {{ $note->created_at->format('d M Y H:i') }}
                                                @if($note->is_private)
                                                <span class="badge bg-dark"><i class="fas fa-lock"></i> Private</span>
                                                @else
                                                <span class="badge bg-success"><i class="fas fa-eye"></i> Client can see</span>
                                                @endif
                                            </p>
                                        </div>
                                        <form action="{{ route('cases.notes.destroy', [$case, $note]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this note?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-sticky-note fa-2x mb-2 d-block"></i>
                                    No notes yet.
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header"><h5 class="card-title mb-0">Add Note</h5></div>
                            <div class="card-body">
                                <form action="{{ route('cases.notes.store', $case) }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <textarea name="note" rows="4" class="form-control" placeholder="Write a note..." required></textarea>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                        <input type="checkbox" class="form-check-input" id="note_private" name="is_private" value="1" checked>
                                        <label class="form-check-label" for="note_private">Private (hidden from client)</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-plus"></i> Add Note
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hearings --}}
            <div class="tab-pane fade" id="hearings" role="tabpanel">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                @forelse($case->hearings as $hearing)
                                <div class="border rounded p-3 mb-2">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                        <div>
                                            <h6 class="mb-1">
                                                <i class="fas fa-calendar"></i>
                                                {{ $hearing->hearing_date->format('d M Y') }}
                                                @if($hearing->hearing_time)
                                                at {{ \Carbon\Carbon::parse($hearing->hearing_time)->format('h:i A') }}
                                                @endif
                                                <span class="badge bg-{{ $hearing->status_badge }}">{{ ucfirst($hearing->status) }}</span>
                                            </h6>
                                            <p class="small text-muted mb-1">
                                                {{ $hearing->court_name ?? '—' }}
                                                @if($hearing->room) · {{ $hearing->room }} @endif
                                                @if($hearing->purpose) · {{ $hearing->purpose }} @endif
                                            </p>
                                            @if($hearing->outcome)
                                            <p class="small mb-0"><strong>Outcome:</strong> {{ $hearing->outcome }}</p>
                                            @endif
                                        </div>
                                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#hearing-edit-{{ $hearing->id }}">
                                            <i class="fas fa-edit"></i> Update
                                        </button>
                                    </div>
                                    <div class="collapse mt-3" id="hearing-edit-{{ $hearing->id }}">
                                        <form action="{{ route('cases.hearings.update', [$case, $hearing]) }}" method="POST" class="border-top pt-3">
                                            @csrf
                                            @method('PATCH')
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <select name="status" class="form-select form-select-sm">
                                                        @foreach(\App\Models\CaseHearing::STATUSES as $status)
                                                        <option value="{{ $status }}" {{ $hearing->status === $status ? 'selected' : '' }}>
                                                            {{ ucfirst($status) }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="outcome" class="form-control form-control-sm"
                                                        placeholder="Outcome / remarks" value="{{ $hearing->outcome }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-sm btn-primary w-100">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-gavel fa-2x mb-2 d-block"></i>
                                    No hearings scheduled yet.
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header"><h5 class="card-title mb-0">Schedule Hearing</h5></div>
                            <div class="card-body">
                                <form action="{{ route('cases.hearings.store', $case) }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="hearing_date">Date *</label>
                                        <input type="date" name="hearing_date" id="hearing_date" class="form-control" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="hearing_time">Time</label>
                                        <input type="time" name="hearing_time" id="hearing_time" class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="hearing_court">Court</label>
                                        <input type="text" name="court_name" id="hearing_court" class="form-control"
                                            value="{{ $case->court_name }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="hearing_room">Room</label>
                                        <input type="text" name="room" id="hearing_room" class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="hearing_purpose">Purpose</label>
                                        <input type="text" name="purpose" id="hearing_purpose" class="form-control"
                                            placeholder="e.g. Recording of evidence">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-calendar-plus"></i> Schedule
                                    </button>
                                    <small class="text-muted d-block mt-2">This will also appear on your calendar automatically.</small>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
