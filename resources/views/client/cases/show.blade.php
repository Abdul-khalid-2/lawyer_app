<x-app-layout>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h1 class="h3 mb-1">{{ $case->title }}</h1>
                <p class="text-muted mb-0">
                    {{ $case->case_number ?? 'No case number' }} ·
                    <span class="badge bg-{{ $case->status_badge }}">{{ ucfirst(str_replace('_', ' ', $case->status)) }}</span>
                </p>
            </div>
            <a href="{{ route('client.cases.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to My Cases
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                {{-- Case details --}}
                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0"><i class="fas fa-info-circle"></i> Case Details</h5></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Lawyer:</strong> {{ $case->lawyer?->full_name }}</p>
                                <p><strong>Type:</strong> {{ ucfirst($case->type) }}</p>
                                <p><strong>Court:</strong> {{ $case->court_name ?? '—' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Handled by:</strong> {{ $case->teamMember?->name ?? $case->lawyer?->full_name }}</p>
                                <p><strong>Filed:</strong> {{ $case->filed_date?->format('d M Y') ?? '—' }}</p>
                                <p><strong>Next hearing:</strong>
                                    @if($case->next_hearing_date)
                                    <span class="text-danger fw-bold">{{ $case->next_hearing_date->format('d M Y') }}</span>
                                    @else
                                    —
                                    @endif
                                </p>
                            </div>
                        </div>
                        @if($case->description)
                        <hr>
                        <p class="mb-0">{{ $case->description }}</p>
                        @endif
                    </div>
                </div>

                {{-- Hearings timeline --}}
                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0"><i class="fas fa-gavel"></i> Hearings</h5></div>
                    <div class="card-body">
                        @forelse($case->hearings as $hearing)
                        <div class="border rounded p-3 mb-2">
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
                        @empty
                        <p class="text-muted text-center py-3 mb-0">No hearings scheduled yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Updates from lawyer (client-visible notes) --}}
                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0"><i class="fas fa-comment-dots"></i> Updates from Your Lawyer</h5></div>
                    <div class="card-body">
                        @forelse($notes as $note)
                        <div class="border rounded p-3 mb-2">
                            <p class="mb-1">{{ $note->note }}</p>
                            <p class="small text-muted mb-0">{{ $note->user?->name }} · {{ $note->created_at->format('d M Y') }}</p>
                        </div>
                        @empty
                        <p class="text-muted text-center py-3 mb-0">No updates yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- Documents --}}
                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0"><i class="fas fa-file-alt"></i> Documents</h5></div>
                    <div class="card-body">
                        @forelse($documents as $document)
                        <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">
                            <div>
                                <a href="{{ $document->file_url }}" target="_blank">
                                    <i class="fas fa-file"></i> {{ Str::limit($document->title, 30) }}
                                </a>
                                <p class="small text-muted mb-0">{{ strtoupper($document->file_type) }} · {{ $document->human_file_size }}</p>
                            </div>
                            <a href="{{ $document->file_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                        @empty
                        <p class="text-muted text-center py-3 mb-0">No documents shared with you yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
