<x-app-layout>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">New Case</h1>
            <a href="{{ route('cases.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Cases
            </a>
        </div>

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
