<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header :title="$case->title" icon="fas fa-briefcase"
            :subtitle="($case->case_number ?? 'No case number') . ' · ' . ucfirst(str_replace('_', ' ', $case->status))">
            <a href="{{ route('admin.cases.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </x-dashboard.page-header>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0">Case Details</h5></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Lawyer:</strong> {{ $case->lawyer?->user?->name ?? '—' }}</p>
                                <p><strong>Client:</strong> {{ $case->client?->user?->name ?? '—' }}</p>
                                <p><strong>Type:</strong> {{ ucfirst($case->type) }}</p>
                                <p><strong>Court:</strong> {{ $case->court_name ?? '—' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Assigned to:</strong> {{ $case->teamMember?->name ?? 'Not assigned' }}</p>
                                <p><strong>Judge:</strong> {{ $case->judge_name ?? '—' }}</p>
                                <p><strong>Filed:</strong> {{ $case->filed_date?->format('d M Y') ?? '—' }}</p>
                                <p><strong>Next hearing:</strong> {{ $case->next_hearing_date?->format('d M Y') ?? '—' }}</p>
                            </div>
                        </div>
                        @if($case->description)
                        <hr><p class="mb-0">{{ $case->description }}</p>
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0">Hearings ({{ $case->hearings->count() }})</h5></div>
                    <div class="card-body">
                        @forelse($case->hearings as $hearing)
                        <div class="border rounded p-3 mb-2">
                            <h6 class="mb-1"><i class="fas fa-calendar"></i> {{ $hearing->hearing_date->format('d M Y') }}
                                <span class="badge bg-{{ $hearing->status_badge }}">{{ ucfirst($hearing->status) }}</span></h6>
                            <p class="small text-muted mb-1">{{ $hearing->court_name ?? '—' }} @if($hearing->purpose) · {{ $hearing->purpose }} @endif</p>
                            @if($hearing->outcome)<p class="small mb-0"><strong>Outcome:</strong> {{ $hearing->outcome }}</p>@endif
                        </div>
                        @empty
                        <p class="text-muted text-center py-3 mb-0">No hearings yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0">Documents ({{ $case->documents->count() }})</h5></div>
                    <div class="card-body">
                        @forelse($case->documents as $document)
                        <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">
                            <span><i class="fas fa-file"></i> {{ Str::limit($document->title, 24) }}</span>
                            <a href="{{ $document->file_url }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-download"></i></a>
                        </div>
                        @empty
                        <p class="text-muted text-center py-3 mb-0">No documents.</p>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Notes ({{ $case->notes->count() }})</h5></div>
                    <div class="card-body">
                        @forelse($case->notes->sortByDesc('created_at') as $note)
                        <div class="border rounded p-2 mb-2 {{ $note->is_private ? 'bg-light' : '' }}">
                            <p class="small mb-1">{{ $note->note }}</p>
                            <small class="text-muted">{{ $note->user?->name }} · {{ $note->created_at->format('d M Y') }}
                                @if($note->is_private)<span class="badge bg-dark">Private</span>@endif</small>
                        </div>
                        @empty
                        <p class="text-muted text-center py-3 mb-0">No notes.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
