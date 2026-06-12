<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="All Clients" subtitle="Every client registered on the platform" icon="fas fa-user-friends" />

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.clients.index') }}" class="row g-2">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Search name, email, phone, CNIC, city..." value="{{ request('search') }}">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                        @if(request('search'))<a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">Clear</a>@endif
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
                                <th>Primary Lawyer</th>
                                <th>City</th>
                                <th>Cases</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                            <tr>
                                <td>{{ $client->user?->name }}</td>
                                <td>{{ $client->user?->email }}</td>
                                <td>{{ $client->lawyer?->user?->name ?? '—' }}</td>
                                <td>{{ $client->city ?? '—' }}</td>
                                <td>{{ $client->cases_count }}</td>
                                <td><span class="badge bg-{{ $client->is_active ? 'success' : 'secondary' }}">{{ $client->is_active ? 'Active' : 'Inactive' }}</span></td>
                                <td><a href="{{ route('admin.clients.show', $client) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a></td>
                            </tr>
                            @empty
                            <x-dashboard.empty-state :colspan="7" icon="fas fa-user-friends" title="No clients found"
                                message="No clients match your search." />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
