<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header :title="'Client: ' . $client->user?->name" icon="fas fa-user">
            <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </x-dashboard.page-header>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-user"></i> Details</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Email:</strong> {{ $client->user?->email }}</p>
                        <p class="mb-2"><strong>Phone:</strong> {{ $client->phone ?? '—' }}</p>
                        <p class="mb-2"><strong>CNIC:</strong> {{ $client->cnic ?? '—' }}</p>
                        <p class="mb-2"><strong>City:</strong> {{ $client->city ?? '—' }}</p>
                        <p class="mb-2"><strong>Address:</strong> {{ $client->address ?? '—' }}</p>
                        <p class="mb-0">
                            <strong>Status:</strong>
                            <span class="badge bg-{{ $client->is_active ? 'success' : 'secondary' }}">
                                {{ $client->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                </div>

                @if($client->notes)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-lock"></i> Private Notes</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $client->notes }}</p>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="fas fa-briefcase"></i> Cases ({{ $client->cases->count() }})</h5>
                        <a href="{{ route('cases.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> New Case
                        </a>
                    </div>
                    <div class="card-body">
                        @forelse($client->cases as $case)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">
                                        <a href="{{ route('cases.show', $case) }}">{{ $case->title }}</a>
                                    </h6>
                                    <p class="small text-muted mb-1">
                                        {{ $case->case_number ?? 'No case number' }} · {{ ucfirst($case->type) }}
                                        @if($case->court_name) · {{ $case->court_name }} @endif
                                    </p>
                                    @if($case->next_hearing_date)
                                    <p class="small mb-0">
                                        <i class="fas fa-calendar text-danger"></i>
                                        Next hearing: {{ $case->next_hearing_date->format('d M Y') }}
                                    </p>
                                    @endif
                                </div>
                                <span class="badge bg-{{ $case->status_badge }}">{{ ucfirst(str_replace('_', ' ', $case->status)) }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-briefcase fa-2x mb-2 d-block"></i>
                            No cases for this client yet.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
