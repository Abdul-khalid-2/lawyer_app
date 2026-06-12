<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="Edit Page" icon="fas fa-file-pen">
            <a href="{{ route('pages.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Pages
            </a>
        </x-dashboard.page-header>

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
