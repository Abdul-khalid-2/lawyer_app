<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="Edit Client" icon="fas fa-user-edit">
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Clients
            </a>
        </x-dashboard.page-header>

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
