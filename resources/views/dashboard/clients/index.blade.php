<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="My Clients" subtitle="Manage your clients and their accounts" icon="fas fa-user-friends">
            <a href="{{ route('clients.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Client
            </a>
        </x-dashboard.page-header>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('clients.index') }}" class="row g-2">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Search by name, email, phone, CNIC or city..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                        @if(request('search'))
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Clear</a>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Cases</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                            <tr>
                                <td>{{ $client->user?->name }}</td>
                                <td>{{ $client->user?->email }}</td>
                                <td>{{ $client->phone ?? '—' }}</td>
                                <td>{{ $client->city ?? '—' }}</td>
                                <td>{{ $client->cases()->count() }}</td>
                                <td>
                                    <span class="badge bg-{{ $client->is_active ? 'success' : 'secondary' }}">
                                        {{ $client->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this client?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-user-friends fa-3x text-muted mb-3 d-block"></i>
                                    @if(request('search'))
                                    No clients match your search.
                                    @else
                                    No clients yet. <a href="{{ route('clients.create') }}">Add your first client</a>.
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $clients->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
