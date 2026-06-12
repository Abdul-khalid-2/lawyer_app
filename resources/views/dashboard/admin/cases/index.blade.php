<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="All Cases" subtitle="Every case across the platform" icon="fas fa-briefcase" />

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.cases.index') }}" class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search title, number, court..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            @foreach(\App\Models\LegalCase::STATUSES as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="type" class="form-select">
                            <option value="">All Types</option>
                            @foreach(\App\Models\LegalCase::TYPES as $type)
                            <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                        @if(request()->hasAny(['search', 'status', 'type']))
                        <a href="{{ route('admin.cases.index') }}" class="btn btn-secondary">Clear</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Case No.</th>
                                <th>Title</th>
                                <th>Lawyer</th>
                                <th>Client</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cases as $case)
                            <tr>
                                <td>{{ $case->case_number ?? '—' }}</td>
                                <td><a href="{{ route('admin.cases.show', $case) }}">{{ Str::limit($case->title, 40) }}</a></td>
                                <td>{{ $case->lawyer?->user?->name ?? '—' }}</td>
                                <td>{{ $case->client?->user?->name ?? '—' }}</td>
                                <td>{{ ucfirst($case->type) }}</td>
                                <td><span class="badge bg-{{ $case->status_badge }}">{{ ucfirst(str_replace('_', ' ', $case->status)) }}</span></td>
                                <td><a href="{{ route('admin.cases.show', $case) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a></td>
                            </tr>
                            @empty
                            <x-dashboard.empty-state :colspan="7" icon="fas fa-briefcase" title="No cases found"
                                message="No cases match your filters." />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $cases->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
