<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="New Case" icon="fas fa-folder-plus">
            <a href="{{ route('cases.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Cases
            </a>
        </x-dashboard.page-header>

        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('cases.store') }}" method="POST">
                            @include('dashboard.cases.form', ['case' => null, 'submitLabel' => 'Create Case'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
