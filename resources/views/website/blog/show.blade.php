@extends('website.layout.master')
@push('css')
    
<script>
    /* Comments Styles */
    .comments-section {
        margin-top: 3rem;
    }

    .comment-item {
        border-left: 3px solid transparent;
        transition: all 0.3s ease;
        position: relative;
    }

    .comment-item:hover {
        border-left-color: #667eea;
        background-color: #f8f9fa;
    }

    .comment-replies {
        margin-left: 2.5rem;
        padding-left: 1.5rem;
        border-left: 2px solid #e9ecef;
        position: relative;
    }

    .comment-replies::before {
        content: '';
        position: absolute;
        left: -1px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, transparent, #667eea, transparent);
    }

    /* Depth-based styling */
    .comment-depth-1 { margin-left: 1rem; }
    .comment-depth-2 { margin-left: 2rem; }
    .comment-depth-3 { margin-left: 3rem; }
    .comment-depth-4 { margin-left: 4rem; }

    /* Responsive */
    @media (max-width: 768px) {
        .comment-replies {
            margin-left: 1rem;
            padding-left: 1rem;
        }
    }

</script>
@endpush

@section('content')
<!-- Blog Post Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('website.blog.index') }}">Blog</a></li>
                        @if($post->category)
                        <li class="breadcrumb-item"><a href="{{ route('website.blog.category', $post->category->slug) }}">{{ $post->category->name }}</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">Article</li>
                    </ol>
                </nav>

                {{-- @if($post->category)
                <a href="{{ route('website.blog.category', $post->category->slug) }}"
                    class="badge bg-primary text-decoration-none mb-3">
                    {{ $post->category->name }}
                </a>
                @endif --}}

                <h1 class="display-5 fw-bold mb-3">{{ $post->title }}</h1>

                <div class="d-flex align-items-center mb-4">
                    <img src="{{ $post->lawyer->user->profile_image ? asset('website/' . $post->lawyer->user->profile_image) : asset('website/images/default-avatar.png') }}"
                        alt="{{ $post->lawyer->user->name }}"
                        class="rounded-circle me-3"
                        style="width: 50px; height: 50px; object-fit: cover;">
                    <div>
                        <h6 class="mb-0">{{ $post->lawyer->user->name }}</h6>
                        <small class="text-muted">
                            {{ $post->published_at->format('F j, Y') }} ·
                            {{-- {{ $post->read_time }} min read · --}}
                            {{ $post->view_count }} views
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Post Content -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Main Content -->
            <div class="col-lg-8">
                @if($post->featured_image)
                <img src="{{ asset('website/' . $post->featured_image) }}"
                    alt="{{ $post->title }}"
                    class="img-fluid rounded mb-4 w-100"
                    style="max-height: 400px; object-fit: cover;">
                @endif

                <!-- Blog Content -->
                <article class="blog-content">
                    @if($post->excerpt)
                    <div class="lead mb-4 p-3 bg-light rounded">
                        {{ $post->excerpt }}
                    </div>
                    @endif

                    <div class="content">
                        {!! $post->content !!}
                    </div>

                    <!-- Tags -->
                    @if($post->tags && is_array($post->tags) && count($post->tags) > 0)
                        <div class="mt-5 pt-4 border-top">
                            <h6 class="mb-3">Tags:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($post->tags as $tag)
                                    @if(!empty(trim($tag)))
                                    <a href="{{ route('website.blog.tag', $tag) }}" 
                                    class="badge bg-light text-dark text-decoration-none">
                                        #{{ $tag }}
                                    </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Author Bio -->
                    <div class="mt-5 p-4 bg-light rounded">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <img src="{{ $post->lawyer->user->profile_image ? asset('website/' . $post->lawyer->user->profile_image) : asset('website/images/default-avatar.png') }}"
                                    alt="{{ $post->lawyer->user->name }}"
                                    class="rounded-circle mb-3 mb-md-0"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <div class="col-md-10">
                                <h5>About {{ $post->lawyer->user->name }}</h5>
                                @if($post->lawyer->bio)
                                <p class="mb-2">{{ Str::limit($post->lawyer->bio, 200) }}</p>
                                @endif
                                <a href="{{ route('website.lawyers.profile', $post->lawyer->uuid) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    View Full Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Related Posts -->
                @if($relatedPosts->count() > 0)
                <div class="mt-5">
                    <h3 class="mb-4">Related Articles</h3>
                    <div class="row">
                        @foreach($relatedPosts as $relatedPost)
                        <div class="col-md-4 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                @if($relatedPost->featured_image)
                                <img src="{{ asset('website/' . $relatedPost->featured_image) }}"
                                    class="card-img-top" alt="{{ $relatedPost->title }}"
                                    style="height: 150px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="{{ route('website.blog.show', $relatedPost->slug) }}"
                                            class="text-dark text-decoration-none">
                                            {{ Str::limit($relatedPost->title, 60) }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        {{ $relatedPost->published_at->format('M j, Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div>
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Blog post content here -->
                            
                            <!-- Comments Section -->
                            @include('website.blog.comments.comments', ['blogPost' => $post])
                        </div>
                        
                        <div class="col-lg-4">
                            <!-- Sidebar content -->
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                @include('website.blog.partials.sidebar', [
                'popularPosts' => $popularPosts,
                'categories' => $categories,
                'tags' => $tags
                ])
            </div>
        </div>
    </div>
</section>
@endsection

@push('css')
<style>
    .blog-content {
        font-size: 1.1rem;
        line-height: 1.8;
    }

    .blog-content .content h2 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #2c3e50;
    }

    .blog-content .content h3 {
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        color: #2c3e50;
    }

    .blog-content .content p {
        margin-bottom: 1.5rem;
    }

    .blog-content .content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }

    .blog-content .content blockquote {
        border-left: 4px solid #667eea;
        padding-left: 1.5rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #6c757d;
    }
</style>
@endpush