<x-app-layout>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Add Team Member</h1>
            <a href="{{ route('team-members.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Team
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('team-members.store') }}" method="POST" enctype="multipart/form-data">
                            @include('dashboard.team.form', ['teamMember' => null, 'submitLabel' => 'Add Team Member'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
