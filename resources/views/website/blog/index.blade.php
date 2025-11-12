@extends('website.layout.master')

@push('css')
<style>
    .blog-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .blog-search-form .form-control {
        border: none;
        box-shadow: none;
    }

    .blog-search-form .btn {
        border: none;
    }

    .blog-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }

    .blog-card .card-title a:hover {
        color: #667eea !important;
    }

    .sidebar-widget .list-group-item {
        border: none;
        padding: 0.75rem 0;
    }

    .sidebar-widget .list-group-item:hover {
        background: transparent;
        color: #667eea;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 2px;
        border: none;
    }

    .pagination .page-item.active .page-link {
        background: #667eea;
        border-color: #667eea;
    }
</style>
@endpush

@section('content')
<!-- Blog Header -->
<section class="blog-header bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Legal Insights & Articles</h1>
                <p class="lead mb-4">Expert legal advice, case studies, and industry insights from experienced lawyers</p>

                <!-- Search Form -->
                <form action="{{ route('website.blog.index') }}" method="GET" class="blog-search-form">
                    <div class="input-group input-group-lg">
                        <input type="text" name="search" class="form-control"
                            placeholder="Search articles..." value="{{ request('search') }}">
                        <button class="btn btn-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <!-- <div class="col-lg-4 text-lg-end">
                <img src="{{ asset('website/images/blog-hero.svg') }}" alt="Legal Blog" class="img-fluid" style="max-height: 200px;">
            </div> -->
        </div>
    </div>
</section>

<!-- Blog Content -->
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
                                    class="btn btn-outline-primary {{ request('sort', 'latest') === 'latest' ? 'active' : '' }}">
                                    Latest
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}"
                                    class="btn btn-outline-primary {{ request('sort') === 'popular' ? 'active' : '' }}">
                                    Popular
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}"
                                    class="btn btn-outline-primary {{ request('sort') === 'featured' ? 'active' : '' }}">
                                    Featured
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <span class="text-muted">Showing {{ $posts->total() }} articles</span>
                    </div>
                </div>

                <!-- Blog Posts Grid -->
                @if($posts->count() > 0)
                <div class="row">
                    @foreach($posts as $post)
                    <div class="col-md-6 col-lg-6 mb-4">
                        <article class="blog-card card h-100 border-0 shadow-sm">
                            @if($post->featured_image)
                            <img src="{{ asset('website/' . $post->featured_image) }}"
                                class="card-img-top" alt="{{ $post->title }}"
                                style="height: 200px; object-fit: cover;">
                            @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                style="height: 200px;">
                                <i class="fas fa-newspaper fa-3x text-muted"></i>
                            </div>
                            @endif

                            <div class="card-body">
                                @if($post->category)
                                <a href="{{ route('website.blog.category', $post->category->slug) }}"
                                    class="badge bg-primary text-decoration-none mb-2">
                                    {{ $post->category->name }}
                                </a>
                                @endif

                                <h5 class="card-title">
                                    <a href="{{ route('website.blog.show', $post->slug) }}"
                                        class="text-dark text-decoration-none">
                                        {{ Str::limit($post->title, 60) }}
                                    </a>
                                </h5>

                                <p class="card-text text-muted">
                                    {{ Str::limit(strip_tags($post->excerpt ?: $post->content), 120) }}
                                </p>
                            </div>

                            <div class="card-footer bg-transparent border-top-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $post->lawyer->user->profile_image ? asset('website/' . $post->lawyer->user->profile_image) : asset('website/images/male_advocate_avatar.jpg') }}"
                                            alt="{{ $post->lawyer->user->name }}"
                                            class="rounded-circle me-2"
                                            style="width: 32px; height: 32px; object-fit: cover;">
                                        <small class="text-muted">{{ $post->lawyer->user->name }}</small>
                                    </div>
                                    {{-- <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>{{ $post->read_time }} min read
                                    </small> --}}
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted">
                                        {{ $post->published_at->format('M j, Y') }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="far fa-eye me-1"></i>{{ $post->view_count }}
                                    </small>
                                </div>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                <div class="card-footer">
                    <nav>
                        {{ $posts->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
                @endif

                @else
                <!-- No Posts Found -->
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No articles found</h4>
                    <p class="text-muted">Try adjusting your search or filters</p>
                    <a href="{{ route('website.blog.index') }}" class="btn btn-primary">View All Articles</a>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Categories Widget -->
                <div class="sidebar-widget card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-folder me-2"></i>Categories</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @foreach($categories as $category)
                            <a href="{{ route('website.blog.category', $category->slug) }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                {{ $category->name }}
                                <span class="badge bg-primary rounded-pill">{{ $category->blog_posts_count ?? 0 }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Popular Posts Widget -->
                <div class="sidebar-widget card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-fire me-2"></i>Popular Articles</h5>
                    </div>
                    <div class="card-body">
                        @foreach($popularPosts as $popularPost)
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            @if($popularPost->featured_image)
                            <img src="{{ asset('website/' . $popularPost->featured_image) }}"
                                alt="{{ $popularPost->title }}"
                                class="flex-shrink-0 me-3 rounded"
                                style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                            <div class="flex-shrink-0 me-3 bg-light rounded d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-newspaper text-muted"></i>
                            </div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('website.blog.show', $popularPost->slug) }}"
                                        class="text-dark text-decoration-none">
                                        {{ Str::limit($popularPost->title, 50) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    {{ $popularPost->published_at->format('M j') }} ·
                                    <i class="far fa-eye me-1"></i>{{ $popularPost->view_count }}
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tags Widget -->
                @if($tags->count() > 0)
                <div class="sidebar-widget card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Popular Tags</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($tags->take(15) as $tag)
                                @php
                                    // If tag is stored as JSON array, parse it
                                    if (str_starts_with($tag, '["') && str_ends_with($tag, '"]')) {
                                        $tagArray = json_decode($tag, true);
                                        $displayTags = is_array($tagArray) ? $tagArray : [$tag];
                                    } else {
                                        // If tag is comma-separated string, split it
                                        $displayTags = explode(',', $tag);
                                    }
                                @endphp
                                
                                @foreach($displayTags as $individualTag)
                                    @php
                                        $cleanTag = trim($individualTag);
                                        // Remove any remaining quotes or brackets
                                        $cleanTag = trim($cleanTag, '[]"\'');
                                    @endphp
                                    @if(!empty($cleanTag))
                                        <a href="{{ route('website.blog.tag', $cleanTag) }}"
                                        class="badge bg-light text-dark text-decoration-none">
                                            #{{ $cleanTag }}
                                        </a>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Newsletter Widget -->
                <div class="sidebar-widget card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-envelope fa-2x mb-3"></i>
                        <h5>Stay Updated</h5>
                        <p class="small opacity-75">Get the latest legal insights delivered to your inbox</p>
                        <form class="mt-3">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Your email">
                                <button class="btn btn-light" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

