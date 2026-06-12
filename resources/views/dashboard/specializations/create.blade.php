<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="New Specialization" icon="fas fa-tags">
            <a href="{{ route('specializations.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </x-dashboard.page-header>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('specializations.store') }}" method="POST">
                            @include('dashboard.specializations.form', ['specialization' => null, 'submitLabel' => 'Create Specialization'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
