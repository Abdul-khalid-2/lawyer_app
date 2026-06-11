<x-app-layout>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">CMS Pages</h1>
            <a href="{{ route('pages.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Page
            </a>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $page)
                            <tr>
                                <td>{{ $page->title }}</td>
                                <td><code>/page/{{ $page->slug }}</code></td>
                                <td>
                                    <span class="badge bg-{{ $page->is_published ? 'success' : 'secondary' }}">
                                        {{ $page->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td>{{ $page->updated_at->format('d M Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if($page->is_published)
                                        <a href="{{ route('website.page', $page->slug) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        @endif
                                        <a href="{{ route('pages.edit', $page) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('pages.destroy', $page) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this page?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-file-alt fa-3x text-muted mb-3 d-block"></i>
                                    No pages yet. Create About, Terms, Privacy or FAQ pages here.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $pages->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
