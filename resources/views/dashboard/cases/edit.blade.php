<x-app-layout>
    <div class="container-fluid">
        <x-dashboard.page-header title="Edit Case" icon="fas fa-folder-open">
            <a href="{{ route('cases.show', $case) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Case
            </a>
        </x-dashboard.page-header>

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
