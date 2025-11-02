<x-app-layout>

    <section id="blog-categories" class="page-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Blog Categories</h2>
                <p class="text-muted">Manage your blog categories</p>
            </div>
            <a href="{{ route('blog-categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Create Category
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Posts</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($category->icon)
                                        <i class="{{ $category->icon }} me-2 text-primary"></i>
                                        @endif
                                        {{ $category->name }}
                                    </div>
                                </td>
                                <td>
                                    <code>{{ $category->slug }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $category->blog_posts_count }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $category->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('blog-categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('blog-categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this category?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>
                                    <p class="text-muted">No blog categories found</p>
                                    <a href="{{ route('blog-categories.create') }}" class="btn btn-primary">
                                        Create Your First Category
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($categories->hasPages())
                <div class="card-footer">
                    {{ $categories->links() }}
                </div>
                @endif
            </div>
        </div>
    </section>

</x-app-layout>