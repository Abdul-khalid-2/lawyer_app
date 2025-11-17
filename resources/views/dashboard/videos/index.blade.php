<x-app-layout>


    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">YouTube Videos</h1>
            <a href="{{ route('videos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Video
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
                                <th>Thumbnail</th>
                                <th>Title</th>
                                <th>Topic</th>
                                <th>Views</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Display Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($videos as $video)
                            <tr>
                                <td>
                                    @if($video->thumbnail_url)
                                    <img src="{{ $video->thumbnail_url }}" alt="Thumbnail" style="width: 80px; height: 60px; object-fit: cover;">
                                    @else
                                    <div style="width: 80px; height: 60px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-video text-muted"></i>
                                    </div>
                                    @endif
                                </td>
                                <td>{{ Str::limit($video->title, 50) }}</td>
                                <td>{{ $video->video_topic }}</td>
                                <td>{{ $video->view_count }}</td>
                                <td>
                                    <span class="badge badge-{{ $video->is_active ? 'success' : 'secondary' }}">
                                        {{ $video->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $video->is_featured ? 'warning' : 'secondary' }}">
                                        {{ $video->is_featured ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td>{{ $video->display_count }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('videos.edit', $video) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('videos.destroy', $video) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No videos found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $videos->links() }}
            </div>
        </div>
    </div>
    <style>
        /* Responsive table styles */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</x-app-layout>