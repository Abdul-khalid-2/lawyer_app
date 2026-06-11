<x-app-layout>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Edit Case</h1>
            <a href="{{ route('cases.show', $case) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Case
            </a>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('cases.update', $case) }}" method="POST">
                            @method('PUT')
                            @include('dashboard.cases.form', ['submitLabel' => 'Update Case'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
