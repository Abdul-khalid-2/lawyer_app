{{-- resources/views/lawyers/index.blade.php --}}
<x-app-layout>
    @push('css')
    <style>
        .lawyer-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 2px solid var(--d-border);
            border-radius: 50%;
        }
        .specialization-badge {
            background-color: var(--d-primary-soft);
            color: var(--d-primary);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            margin-right: 4px;
        }
    </style>
    @endpush

    <!-- Lawyers Page -->
    <section id="lawyers" class="page-section">
        <x-dashboard.page-header title="Lawyers" subtitle="Manage lawyers on the platform" icon="fas fa-gavel">
            <a href="{{ route('lawyers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Lawyer
            </a>
        </x-dashboard.page-header>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Filters and Search -->
        <form method="GET" action="{{ route('lawyers.index') }}">
            <div class="row mb-4">
                <div class="col-lg-4 mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Search lawyers..." value="{{ request('search') }}">
                </div>
                <div class="col-lg-2 mb-3">
                    <select class="form-control" name="specialization">
                        <option value="">All Specializations</option>
                        @foreach($specializations as $specialization)
                        <option value="{{ $specialization->id }}" {{ request('specialization') == $specialization->id ? 'selected' : '' }}>
                            {{ $specialization->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 mb-3">
                    <select class="form-control" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-lg-2 mb-3">
                    <select class="form-control" name="sort">
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Sort by Name</option>
                        <option value="experience" {{ request('sort') == 'experience' ? 'selected' : '' }}>Sort by Experience</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                    </select>
                </div>
                <div class="col-lg-2 mb-3">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <!-- Lawyers Table -->
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Lawyer</th>
                            <th>Specializations</th>
                            <th>Experience</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lawyers as $lawyer)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $lawyer->user->profile_image ? asset('website/' . $lawyer->user->profile_image) : 'https://images.pexels.com/photos/1040880/pexels-photo-1040880.jpeg?auto=compress&cs=tinysrgb&w=150&h=150&fit=crop&crop=face' }}" alt="{{ $lawyer->full_name }}" class="rounded-circle lawyer-img me-3">
                                    <div>
                                        <h6 class="mb-0">{{ $lawyer->full_name }}</h6>
                                        <small class="text-muted">{{ $lawyer->bar_number ?? 'No bar number' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @foreach($lawyer->specializations->take(2) as $specialization)
                                <span class="specialization-badge">{{ $specialization->name }}</span>
                                @endforeach
                                @if($lawyer->specializations->count() > 2)
                                <span class="badge bg-secondary">+{{ $lawyer->specializations->count() - 2 }} more</span>
                                @endif
                            </td>
                            <td>{{ $lawyer->years_of_experience }} years</td>
                            <td>
                                <small class="text-muted">{{ $lawyer->email }}</small><br>
                                <small class="text-muted">{{ $lawyer->phone ?? 'No phone' }}</small>
                            </td>
                            <td>
                                <span class="badge-status {{ $lawyer->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $lawyer->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if($lawyer->is_verified)
                                <span class="badge-status bg-info mt-1">Verified</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('lawyers.show', $lawyer) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('lawyers.edit', $lawyer) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('lawyers.destroy', $lawyer) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this lawyer?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-user-slash fa-2x text-muted mb-2"></i>
                                <p class="text-muted">No lawyers found</p>
                                <a href="{{ route('lawyers.create') }}" class="btn btn-primary">Add First Lawyer</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($lawyers->hasPages())
            <div class="card-footer bg-white border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Showing {{ $lawyers->firstItem() }} to {{ $lawyers->lastItem() }} of {{ $lawyers->total() }} lawyers</span>
                    {{ $lawyers->links() }}
                </div>
            </div>
            @endif
        </div>
    </section>
</x-app-layout>