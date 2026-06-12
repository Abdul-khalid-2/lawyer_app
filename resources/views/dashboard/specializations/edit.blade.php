<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="Edit Specialization" icon="fas fa-tags">
            <a href="{{ route('specializations.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </x-dashboard.page-header>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('specializations.update', $specialization) }}" method="POST">
                            @method('PUT')
                            @include('dashboard.specializations.form', ['submitLabel' => 'Update Specialization'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
