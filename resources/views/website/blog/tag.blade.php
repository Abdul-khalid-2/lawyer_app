<x-website.layout.master :title="'#' . $tag . ' - Law-Skoolyst Blog'"
    :description="'Legal articles tagged ' . $tag . ' on Law-Skoolyst.'">


<!-- Tag Header -->
<x-website.sections.page-hero icon="fas fa-tag"
    :title="'#' . $tag"
    :subtitle="$posts->total() . ' ' . Str::plural('article', $posts->total()) . ' tagged with this topic'">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-3">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('website.blog.index') }}">Blog</a></li>
            <li class="breadcrumb-item active text-white">Tag: {{ $tag }}</li>
        </ol>
    </nav>
    <form action="{{ route('website.blog.index') }}" method="GET" class="lc-hero-search">
        <div class="input-group input-group-lg">
            <input type="text" name="search" class="form-control"
                placeholder="Search articles..." value="{{ request('search') }}">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
</x-website.sections.page-hero>

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
                        <span class="text-muted">Showing {{ $posts->count() }} of {{ $posts->total() }} articles</span>
                    </div>
                </div>

                <!-- Blog Posts Grid -->
                @if($posts->count() > 0)
                <div class="row">
                    @foreach($posts as $post)
                        <x-website.cards.blog-card :post="$post" :showTags="true" />
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
                    <i class="fas fa-tag fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No articles found with this tag</h4>
                    <p class="text-muted">Try browsing other tags or categories</p>
                    <div class="mt-4">
                        <a href="{{ route('website.blog.index') }}" class="btn btn-primary me-2">View All Articles</a>
                        <a href="{{ route('website.blog.tags') }}" class="btn btn-outline-primary">Browse All Tags</a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Current Tag Info -->
                <div class="sidebar-widget card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>About This Tag</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <span class="badge bg-primary tag-badge mb-3">#{{ $tag }}</span>
                            <p class="text-muted mb-3">
                                Explore {{ $posts->total() }} articles tagged with "{{ $tag }}"
                            </p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('website.blog.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to All Articles
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Tags -->
                @if($relatedTags && $relatedTags->count() > 0)
                <div class="sidebar-widget card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Related Tags</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($relatedTags as $relatedTag)
                                @if($relatedTag !== $tag)
                                <a href="{{ route('website.blog.tag', $relatedTag) }}"
                                   class="badge bg-light text-dark text-decoration-none">
                                    #{{ $relatedTag }}
                                </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

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
</x-website.layout.master>