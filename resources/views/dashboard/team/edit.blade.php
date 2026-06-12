<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="Edit Team Member" icon="fas fa-user-edit">
            <a href="{{ route('team-members.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Team
            </a>
        </x-dashboard.page-header>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('team-members.update', $teamMember) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @include('dashboard.team.form', ['submitLabel' => 'Update Team Member'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
