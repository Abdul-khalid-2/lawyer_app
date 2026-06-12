<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header :title="$client->user?->name" icon="fas fa-user"
            :subtitle="'Client of ' . ($client->lawyer?->user?->name ?? 'no lawyer')">
            <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </x-dashboard.page-header>

        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header"><h5 class="card-title mb-0">Details</h5></div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Email:</strong> {{ $client->user?->email }}</p>
                        <p class="mb-2"><strong>Phone:</strong> {{ $client->phone ?? '—' }}</p>
                        <p class="mb-2"><strong>CNIC:</strong> {{ $client->cnic ?? '—' }}</p>
                        <p class="mb-2"><strong>City:</strong> {{ $client->city ?? '—' }}</p>
                        <p class="mb-2"><strong>Address:</strong> {{ $client->address ?? '—' }}</p>
                        <p class="mb-2"><strong>Primary Lawyer:</strong> {{ $client->lawyer?->user?->name ?? '—' }}</p>
                        <p class="mb-0"><strong>Status:</strong>
                            <span class="badge bg-{{ $client->is_active ? 'success' : 'secondary' }}">{{ $client->is_active ? 'Active' : 'Inactive' }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header"><h5 class="card-title mb-0">Cases ({{ $client->cases->count() }})</h5></div>
                    <div class="card-body">
                        @forelse($client->cases as $case)
                        <div class="d-flex justify-content-between align-items-start border rounded p-3 mb-2">
                            <div>
                                <h6 class="mb-1"><a href="{{ route('admin.cases.show', $case) }}">{{ $case->title }}</a></h6>
                                <p class="small text-muted mb-0">{{ $case->case_number ?? 'No number' }} · {{ ucfirst($case->type) }}</p>
                            </div>
                            <span class="badge bg-{{ $case->status_badge }}">{{ ucfirst(str_replace('_', ' ', $case->status)) }}</span>
                        </div>
                        @empty
                        <p class="text-muted text-center py-3 mb-0">No cases for this client.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
