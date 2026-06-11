<x-app-layout>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Edit Client</h1>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Clients
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('clients.update', $client) }}" method="POST">
                            @method('PUT')
                            @include('dashboard.clients.form', ['submitLabel' => 'Update Client'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
