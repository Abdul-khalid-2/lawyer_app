<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="Specializations" subtitle="Legal practice areas lawyers can be tagged with" icon="fas fa-tags">
            <a href="{{ route('specializations.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> New Specialization</a>
        </x-dashboard.page-header>

        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('specializations.index') }}" class="row g-2">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Search specializations..." value="{{ request('search') }}">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                        @if(request('search'))<a href="{{ route('specializations.index') }}" class="btn btn-secondary">Clear</a>@endif
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
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Lawyers</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($specializations as $specialization)
                            <tr>
                                <td><i class="{{ $specialization->icon ?? 'fas fa-gavel' }} text-primary"></i></td>
                                <td class="fw-semibold">{{ $specialization->name }}</td>
                                <td>{{ Str::limit($specialization->description, 60) ?: '—' }}</td>
                                <td>{{ $specialization->lawyers_count }}</td>
                                <td><span class="badge bg-{{ $specialization->is_active ? 'success' : 'secondary' }}">{{ $specialization->is_active ? 'Active' : 'Inactive' }}</span></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('specializations.edit', $specialization) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('specializations.destroy', $specialization) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this specialization?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <x-dashboard.empty-state :colspan="6" icon="fas fa-tags" title="No specializations yet"
                                message="Create your first practice area.">
                                <a href="{{ route('specializations.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> New Specialization</a>
                            </x-dashboard.empty-state>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $specializations->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
