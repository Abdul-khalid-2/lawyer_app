<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="All Users" subtitle="Every account on the platform" icon="fas fa-user" />

        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

        <!-- Role tiles -->
        <div class="row mb-2">
            <div class="col-md-3 col-6 mb-3">
                <x-dashboard.stat-card label="Total Users" :value="$roleCounts['all']" icon="fas fa-users" variant="primary" />
            </div>
            <div class="col-md-3 col-6 mb-3">
                <x-dashboard.stat-card label="Super Admins" :value="$roleCounts['super_admin']" icon="fas fa-crown" variant="warning" />
            </div>
            <div class="col-md-3 col-6 mb-3">
                <x-dashboard.stat-card label="Lawyers" :value="$roleCounts['lawyer']" icon="fas fa-gavel" variant="info" />
            </div>
            <div class="col-md-3 col-6 mb-3">
                <x-dashboard.stat-card label="Clients" :value="$roleCounts['client']" icon="fas fa-user-friends" variant="success" />
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Search name, email, phone..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="role" class="form-select">
                            <option value="">All Roles</option>
                            <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="lawyer" {{ request('role') === 'lawyer' ? 'selected' : '' }}>Lawyer</option>
                            <option value="client" {{ request('role') === 'client' ? 'selected' : '' }}>Client</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                        @if(request()->hasAny(['search', 'role', 'status']))<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Clear</a>@endif
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
                                <th>Role</th>
                                <th>Phone</th>
                                <th>Joined</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @php $badge = ['super_admin'=>'warning','lawyer'=>'info','client'=>'success'][$user->role] ?? 'secondary'; @endphp
                                    <span class="badge bg-{{ $badge }}">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                                </td>
                                <td>{{ $user->phone ?? '—' }}</td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td><span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
                                <td>
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-{{ $user->is_active ? 'warning' : 'success' }}"
                                            onclick="return confirm('{{ $user->is_active ? 'Deactivate' : 'Activate' }} this user?')">
                                            <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    @else
                                    <span class="badge bg-light text-muted">You</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <x-dashboard.empty-state :colspan="7" icon="fas fa-user" title="No users found"
                                message="No users match your filters." />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
