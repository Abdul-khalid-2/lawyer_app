<x-app-layout>
    <div class="container-fluid">
        <h1 class="h3 mb-4">Schedule</h1>

        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="card h-100">
                    <div class="card-header"><h5 class="card-title mb-0"><i class="fas fa-gavel"></i> My Case Hearings</h5></div>
                    <div class="card-body">
                        @forelse($hearings as $hearing)
                        <div class="border rounded p-3 mb-2 {{ $hearing->status === 'scheduled' && $hearing->hearing_date->isFuture() ? 'border-danger' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">
                                        {{ $hearing->hearing_date->format('D, d M Y') }}
                                        @if($hearing->hearing_time)
                                        at {{ \Carbon\Carbon::parse($hearing->hearing_time)->format('h:i A') }}
                                        @endif
                                    </h6>
                                    <p class="small text-muted mb-1">
                                        <a href="{{ route('client.cases.show', $hearing->legalCase) }}">{{ $hearing->legalCase?->title }}</a>
                                    </p>
                                    <p class="small text-muted mb-0">
                                        {{ $hearing->court_name ?? '—' }}
                                        @if($hearing->room) · {{ $hearing->room }} @endif
                                        @if($hearing->purpose) · {{ $hearing->purpose }} @endif
                                    </p>
                                </div>
                                <span class="badge bg-{{ $hearing->status_badge }}">{{ ucfirst($hearing->status) }}</span>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center py-4 mb-0">No hearings on your cases yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-check"></i>
                            {{ $lawyer?->full_name ?? 'Lawyer' }}'s Availability
                        </h5>
                    </div>
                    <div class="card-body">
                        @forelse($publicSlots as $slot)
                        <div class="d-flex align-items-center border rounded p-3 mb-2">
                            <i class="fas fa-clock text-success fa-lg me-3"></i>
                            <div>
                                <h6 class="mb-0">{{ $slot->start_datetime->format('D, d M Y') }}</h6>
                                <p class="small text-muted mb-0">
                                    {{ $slot->start_datetime->format('h:i A') }} – {{ $slot->end_datetime->format('h:i A') }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center py-4 mb-0">No public availability published.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
