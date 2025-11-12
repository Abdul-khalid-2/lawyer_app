<x-app-layout>

    <section id="blog-posts" class="page-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Blog Posts</h2>
                <p class="text-muted">Manage your blog posts and articles</p>
            </div>
            <a href="{{ route('blog-posts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Create Post
            </a>
        </div>

        <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Published</th>
                                <th>Comments</th>
                                <th class="pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                            <tr>
                                <td class="ps-3">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($post->featured_image)
                                        <img src="{{ asset('website/' . $post->featured_image) }}"
                                            alt="{{ $post->title }}" class="rounded me-3"
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                        <div class="rounded me-3 bg-light d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ Str::limit($post->title, 50) }}</h6>
                                            <small class="text-muted d-none d-md-block">{{ $post->slug }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($post->category)
                                    <span class="badge bg-primary">{{ $post->category->name }}</span>
                                    @else
                                    <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                    $statusColors = [
                                    'draft' => 'secondary',
                                    'published' => 'success',
                                    'archived' => 'warning'
                                    ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$post->status] }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $post->view_count }}</span>
                                </td>
                                <td>
                                    @if($post->published_at)
                                    <span class="d-none d-lg-block">{{ $post->published_at->format('M d, Y') }}</span>
                                    <span class="d-lg-none">{{ $post->published_at->format('m/d/y') }}</span>
                                    @else
                                    <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('blog-posts.comments', $post->id) }}" class="btn btn-sm btn-outline-info">
                                        <span class="d-none d-sm-inline">{{ $post->comments_count }}</span>
                                        <i class="fas fa-comments"></i>
                                    </a>
                                </td>
                                <td class="pe-3">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('blog-posts.show', $post->id) }}" class="btn btn-sm btn-outline-info" target="_blank" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('blog-posts.edit', $post->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('blog-posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this post?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                                    <p class="text-muted">No blog posts found</p>
                                    <a href="{{ route('blog-posts.create') }}" class="btn btn-primary">
                                        Create Your First Post
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($posts->hasPages())
                <div class="card-footer">
                    {{ $posts->links() }}
                </div>
                @endif
        </div>
    </section>

    <style>
        /* Responsive table styles */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
       
    </style>
</x-app-layout>