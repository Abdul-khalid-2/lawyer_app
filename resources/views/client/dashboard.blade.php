<x-app-layout>
    <div class="container-fluid">
        <h1 class="h3 mb-4">My Dashboard</h1>

        @if($nextHearing)
        <div class="alert alert-warning d-flex align-items-center">
            <i class="fas fa-gavel fa-2x me-3"></i>
            <div>
                <strong>Upcoming hearing:</strong>
                {{ $nextHearing->hearing_date->format('l, d M Y') }}
                @if($nextHearing->hearing_time)
                at {{ \Carbon\Carbon::parse($nextHearing->hearing_time)->format('h:i A') }}
                @endif
                — <a href="{{ route('client.cases.show', $nextHearing->legalCase) }}">{{ $nextHearing->legalCase?->title }}</a>
                @if($nextHearing->court_name)
                <span class="text-muted">({{ $nextHearing->court_name }})</span>
                @endif
            </div>
        </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card text-white stats-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Total Cases</h6>
                            <h2 class="mb-0">{{ $caseStats['total'] }}</h2>
                        </div>
                        <i class="fas fa-briefcase fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-white stats-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Ongoing</h6>
                            <h2 class="mb-0">{{ $caseStats['active'] }}</h2>
                        </div>
                        <i class="fas fa-spinner fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-white stats-card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Closed</h6>
                            <h2 class="mb-0">{{ $caseStats['closed'] }}</h2>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header"><h5 class="card-title mb-0"><i class="fas fa-user-tie"></i> My Lawyer</h5></div>
                    <div class="card-body text-center">
                        @if($lawyer)
                        <img src="{{ $lawyer->profile_image_url }}" alt="{{ $lawyer->full_name }}"
                            class="rounded-circle mb-3" style="width: 90px; height: 90px; object-fit: cover;">
                        <h5 class="mb-1">{{ $lawyer->full_name }}</h5>
                        @if($lawyer->firm_name)
                        <p class="text-primary mb-1">{{ $lawyer->firm_name }}</p>
                        @endif
                        <p class="small text-muted mb-2">{{ $lawyer->city }}{{ $lawyer->state ? ', ' . $lawyer->state : '' }}</p>
                        <a href="{{ route('website.lawyers.profile', $lawyer->uuid) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> View Public Profile
                        </a>
                        @else
                        <p class="text-muted mb-0">No lawyer assigned yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="fas fa-briefcase"></i> Recent Cases</h5>
                        <a href="{{ route('client.cases.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        @forelse($recentCases as $case)
                        <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2">
                            <div>
                                <a href="{{ route('client.cases.show', $case) }}" class="fw-bold">{{ $case->title }}</a>
                                <p class="small text-muted mb-0">
                                    {{ $case->case_number ?? 'No case number' }} · {{ ucfirst($case->type) }}
                                    @if($case->next_hearing_date)
                                    · next hearing {{ $case->next_hearing_date->format('d M Y') }}
                                    @endif
                                </p>
                            </div>
                            <span class="badge bg-{{ $case->status_badge }}">{{ ucfirst(str_replace('_', ' ', $case->status)) }}</span>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-briefcase fa-2x mb-2 d-block"></i>
                            No cases to show yet.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
