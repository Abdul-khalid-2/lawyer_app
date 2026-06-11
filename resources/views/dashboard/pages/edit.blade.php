<x-app-layout>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Edit Page</h1>
            <a href="{{ route('pages.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Pages
            </a>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pages.update', $page) }}" method="POST">
                            @method('PUT')
                            @include('dashboard.pages.form', ['submitLabel' => 'Update Page'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
