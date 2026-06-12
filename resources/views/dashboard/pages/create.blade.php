<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="New Page" icon="fas fa-file-circle-plus">
            <a href="{{ route('pages.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Pages
            </a>
        </x-dashboard.page-header>

        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pages.store') }}" method="POST">
                            @include('dashboard.pages.form', ['page' => null, 'submitLabel' => 'Create Page'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
