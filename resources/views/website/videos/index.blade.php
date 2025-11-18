@extends('website.layout.master')

@push('css')
<style>
    .video-header {
        background: linear-gradient(135deg, #010a8a 0%, #cc0000 100%);
    }

    .video-search-form .form-control {
        border: none;
        box-shadow: none;
    }

    .video-search-form .btn {
        border: none;
    }

    .video-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }

    .video-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }

    .video-thumbnail {
        position: relative;
        overflow: hidden;
    }

    .video-thumbnail::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        z-index: 1;
    }

    .video-play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(255, 0, 0, 0.8);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .video-card:hover .video-play-icon {
        background: #010a8a;
        transform: translate(-50%, -50%) scale(1.1);
    }

    .video-play-icon i {
        color: white;
        font-size: 24px;
        margin-left: 3px;
    }

    .video-duration {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 2;
    }

    .sidebar-widget .list-group-item {
        border: none;
        padding: 0.75rem 0;
    }

    .sidebar-widget .list-group-item:hover {
        background: transparent;
        color: #010a8a;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 2px;
        border: none;
    }

    .pagination .page-item.active .page-link {
        background: #010a8a;
        border-color: #010a8a;
    }

    .topic-badge {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .topic-badge:hover {
        background: #010a8a;
        color: white;
        border-color: #010a8a;
    }
</style>
@endpush

@section('content')
<!-- Video Header -->
<section class="video-header bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Legal Education Videos</h1>
                <p class="lead mb-4">Expert legal explanations, case analyses, and educational content from verified lawyers</p>

                <!-- Search Form -->
                <form action="{{ route('website.videos.index') }}" method="GET" class="video-search-form">
                    <div class="input-group input-group-lg">
                        <input type="text" name="search" class="form-control"
                            placeholder="Search videos by topic or title..." value="{{ request('search') }}">
                        <button class="btn btn-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Video Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Filters -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <span class="me-3 text-muted">Sort by:</span>
                            <div class="btn-group">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}"
                                    class="btn btn-outline-danger {{ request('sort', 'latest') === 'latest' ? 'active' : '' }}">
                                    Latest
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}"
                                    class="btn btn-outline-danger {{ request('sort') === 'popular' ? 'active' : '' }}">
                                    Popular
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}"
                                    class="btn btn-outline-danger {{ request('sort') === 'featured' ? 'active' : '' }}">
                                    Featured
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <span class="text-muted">Showing {{ $videos->total() }} videos</span>
                    </div>
                </div>

                <!-- Popular Topics -->
                @if($topics->count() > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex flex-wrap gap-2">
                            <span class="text-muted me-2">Topics:</span>
                            @foreach($topics as $topic)
                            <a href="{{ request()->fullUrlWithQuery(['topic' => $topic]) }}"
                                class="badge topic-badge text-decoration-none {{ request('topic') === $topic ? 'bg-danger text-white' : 'text-dark' }}">
                                {{ $topic }}
                            </a>
                            @endforeach
                            @if(request('topic'))
                            <a href="{{ route('website.videos.index') }}" class="badge bg-secondary text-decoration-none">
                                Clear
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Videos Grid -->
                @if($videos->count() > 0)
                <div class="row">
                    @foreach($videos as $video)
                    <div class="col-md-6 col-lg-6 mb-4">
                        <article class="video-card card h-100 border-0 shadow-sm">
                            <div class="video-thumbnail position-relative">
                                <img src="{{ $video->thumbnail_url }}"
                                    class="card-img-top"
                                    alt="{{ $video->title }}"
                                    style="height: 200px; object-fit: cover;">
                                <div class="video-play-icon">
                                    <a href="{{ route('website.videos.show', $video->uuid) }}">
                                        <i class="fas fa-play"></i>
                                    </a>

                                </div>
                                <div class="video-duration">
                                    <!-- {{ $video->duration ? gmdate('i:s', $video->duration) : 'N/A' }} -->
                                </div>
                            </div>

                            <div class="card-body">
                                <a href="{{ route('website.videos.show', $video->uuid) }}"
                                    class="badge bg-danger text-decoration-none mb-2">
                                    {{ $video->video_topic }}
                                </a>

                                <h5 class="card-title">
                                    <a href="{{ route('website.videos.show', $video->uuid) }}"
                                        class="text-dark text-decoration-none">
                                        {{ Str::limit($video->title, 60) }}
                                    </a>
                                </h5>

                                <p class="card-text text-muted small">
                                    {{ Str::limit($video->description, 100) }}
                                </p>
                            </div>

                            <div class="card-footer bg-transparent border-top-0 pt-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $video->lawyer->user->profile_image ? asset('website/' . $video->lawyer->user->profile_image) : asset('website/images/male_advocate_avatar.jpg') }}"
                                            alt="{{ $video->lawyer->user->name }}"
                                            class="rounded-circle me-2"
                                            style="width: 32px; height: 32px; object-fit: cover;">
                                        <small class="text-muted">{{ $video->lawyer->user->name }}</small>
                                    </div>
                                    <small class="text-muted">
                                        <i class="far fa-eye me-1"></i>{{ $video->view_count }}
                                    </small>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted">
                                        {{ $video->published_at->format('M j, Y') }}
                                    </small>
                                    <!-- <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $video->duration ? gmdate('i', $video->duration) . ' min' : 'N/A' }}
                                    </small> -->
                                </div>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($videos->hasPages())
                <div class="mt-4">
                    <nav>
                        {{ $videos->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
                @endif

                @else
                <!-- No Videos Found -->
                <div class="text-center py-5">
                    <i class="fas fa-video fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No videos found</h4>
                    <p class="text-muted">Try adjusting your search or filters</p>
                    <a href="{{ route('website.videos.index') }}" class="btn btn-danger">View All Videos</a>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Featured Videos Widget -->
                @if($featuredVideos->count() > 0)
                <div class="sidebar-widget card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-star me-2 text-warning"></i>Featured Videos</h5>
                    </div>
                    <div class="card-body">
                        @foreach($featuredVideos as $featuredVideo)
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <div class="flex-shrink-0 position-relative">
                                <img src="{{ $featuredVideo->thumbnail_url }}"
                                    alt="{{ $featuredVideo->title }}"
                                    class="rounded me-3"
                                    style="width: 80px; height: 60px; object-fit: cover;">
                                <div class="position-absolute top-50 start-50 translate-middle"
                                    style="z-index: 2;">
                                    <i class="fas fa-play text-white" style="font-size: 12px;"></i>
                                </div>
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50 rounded"></div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('website.videos.show', $featuredVideo->uuid) }}"
                                        class="text-dark text-decoration-none">
                                        {{ Str::limit($featuredVideo->title, 40) }}
                                    </a>
                                </h6>
                                <small class="text-muted d-block">
                                    {{ $featuredVideo->lawyer->user->name }}
                                </small>
                                <small class="text-muted">
                                    <i class="far fa-eye me-1"></i>{{ $featuredVideo->view_count }}
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Popular Lawyers Widget -->
                @if($popularLawyers->count() > 0)
                <div class="sidebar-widget card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-user-tie me-2 text-primary"></i>Top Legal Educators</h5>
                    </div>
                    <div class="card-body">
                        @foreach($popularLawyers as $lawyer)
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <img src="{{ $lawyer->user->profile_image ? asset('website/' . $lawyer->user->profile_image) : asset('website/images/male_advocate_avatar.jpg') }}"
                                alt="{{ $lawyer->user->name }}"
                                class="rounded-circle me-3"
                                style="width: 40px; height: 40px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">
                                    <a href="#" class="text-dark text-decoration-none">
                                        {{ $lawyer->user->name }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    {{ $lawyer->youtube_videos_count }} videos
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Topics Widget -->
                @if($topics->count() > 0)
                <div class="sidebar-widget card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-folder me-2"></i>Video Topics</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($topics->take(10) as $topic)
                            <a href="{{ request()->fullUrlWithQuery(['topic' => $topic]) }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                {{ $topic }}
                                <span class="badge bg-primary rounded-pill">
                                    {{ \App\Models\YoutubeVideo::active()->where('video_topic', $topic)->count() }}
                                </span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- CTA Widget -->
                <div class="sidebar-widget card border-0 shadow-sm bg-dark text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-video fa-2x mb-3 text-danger"></i>
                        <h5>Legal Education</h5>
                        <p class="small opacity-75">Learn from experienced lawyers through educational video content</p>
                        <a href="{{ route('website.videos.index') }}" class="btn btn-danger btn-sm mt-2">
                            Browse All Videos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection