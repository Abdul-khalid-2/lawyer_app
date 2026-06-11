<x-app-layout>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">My Team</h1>
            <a href="{{ route('team-members.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Team Member
            </a>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="row">
            @forelse($teamMembers as $member)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <img src="{{ $member->photo_url }}" alt="{{ $member->name }}"
                            class="rounded-circle mb-3"
                            style="width: 90px; height: 90px; object-fit: cover;">
                        <h5 class="mb-1">{{ $member->name }}</h5>
                        <p class="text-primary mb-1">{{ $member->designation }}</p>
                        @if($member->qualifications)
                        <p class="small text-muted mb-1">{{ Str::limit($member->qualifications, 60) }}</p>
                        @endif
                        <p class="small text-muted mb-2">
                            {{ $member->years_of_experience }} {{ Str::plural('year', $member->years_of_experience) }} experience
                        </p>
                        <span class="badge bg-{{ $member->is_active ? 'success' : 'secondary' }}">
                            {{ $member->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-center gap-2">
                        <a href="{{ route('team-members.edit', $member) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('team-members.destroy', $member) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this team member?')">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5>No team members yet</h5>
                        <p class="text-muted">Add your associates, paralegals and junior counsel — they will appear on your public profile.</p>
                        <a href="{{ route('team-members.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Your First Team Member
                        </a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        {{ $teamMembers->links() }}
    </div>
</x-app-layout>
