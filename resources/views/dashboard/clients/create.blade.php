<x-app-layout>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Add Client</h1>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Clients
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('clients.store') }}" method="POST">
                            @include('dashboard.clients.form', ['client' => null, 'submitLabel' => 'Create Client'])
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-info-circle"></i> About Client Accounts</h5>
                    </div>
                    <div class="card-body">
                        <p class="small mb-2">Creating a client also creates a login account for them.</p>
                        <ul class="small text-muted ps-3 mb-0">
                            <li>The client logs in with the email and password you set.</li>
                            <li>They can see their cases, hearings and documents you mark visible.</li>
                            <li>Your private notes are never shown to them.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
