<x-app-layout>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">My Cases</h1>
            <a href="{{ route('cases.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Case
            </a>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('cases.index') }}" class="row g-2">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Search title, number, court..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            @foreach(\App\Models\LegalCase::STATUSES as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="type" class="form-select">
                            <option value="">All Types</option>
                            @foreach(\App\Models\LegalCase::TYPES as $type)
                            <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="client_id" class="form-select">
                            <option value="">All Clients</option>
                            @foreach($clients as $clientOption)
                            <option value="{{ $clientOption->id }}" {{ request('client_id') == $clientOption->id ? 'selected' : '' }}>
                                {{ $clientOption->user?->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                        @if(request()->hasAny(['search', 'status', 'type', 'client_id']))
                        <a href="{{ route('cases.index') }}" class="btn btn-secondary">Clear</a>
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
                                <th>Client</th>
                                <th>Type</th>
                                <th>Court</th>
                                <th>Next Hearing</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cases as $case)
                            <tr>
                                <td>{{ $case->case_number ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('cases.show', $case) }}">{{ Str::limit($case->title, 40) }}</a>
                                </td>
                                <td>{{ $case->client?->user?->name }}</td>
                                <td>{{ ucfirst($case->type) }}</td>
                                <td>{{ Str::limit($case->court_name, 25) ?? '—' }}</td>
                                <td>
                                    @if($case->next_hearing_date)
                                    {{ $case->next_hearing_date->format('d M Y') }}
                                    @else
                                    —
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $case->status_badge }}">
                                        {{ ucfirst(str_replace('_', ' ', $case->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('cases.edit', $case) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('cases.destroy', $case) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this case?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-briefcase fa-3x text-muted mb-3 d-block"></i>
                                    @if(request()->hasAny(['search', 'status', 'type', 'client_id']))
                                    No cases match your filters.
                                    @else
                                    No cases yet. <a href="{{ route('cases.create') }}">Create your first case</a>.
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $cases->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
