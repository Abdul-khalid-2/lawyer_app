<x-website.layout.master :title="$category->name . ' Articles - Law-Skoolyst Blog'"
    :description="$category->description ? \Illuminate\Support\Str::limit(strip_tags($category->description), 155) : 'Browse legal articles in the ' . $category->name . ' category on Law-Skoolyst.'">


<!-- Blog Header -->
<section class="blog-header bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center mb-3">
                    <a href="{{ route('website.blog.index') }}" class="text-white text-decoration-none me-3">
                        <i class="fas fa-arrow-left me-2"></i>Back to All Articles
                    </a>
                    <span class="category-badge">{{ $category->name }}</span>
                </div>
                <h1 class="display-4 fw-bold mb-3">{{ $category->name }} Articles</h1>
                <p class="lead mb-4">{{ $category->description ?? 'Explore expert legal insights and articles about ' . $category->name }}</p>

                <!-- Search Form -->
                <form action="{{ route('website.blog.category', $category->slug) }}" method="GET" class="blog-search-form">
                    <div class="input-group input-group-lg">
                        <input type="text" name="search" class="form-control"
                            placeholder="Search {{ $category->name }} articles..." value="{{ request('search') }}">
                        <button class="btn btn-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Category Info & Filters -->
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
                        <span class="text-muted">Showing {{ $posts->total() }} articles in {{ $category->name }}</span>
                    </div>
                </div>

                <!-- Blog Posts Grid -->
                @if($posts->count() > 0)
                <div class="row">
                    @foreach($posts as $post)
                        <x-website.cards.blog-card :post="$post" />
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
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No articles found in {{ $category->name }}</h4>
                    <p class="text-muted">Try adjusting your search or browse other categories</p>
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
                            @foreach($categories as $cat)
                            <a href="{{ route('website.blog.category', $cat->slug) }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $cat->id === $category->id ? 'active' : '' }}">
                                {{ $cat->name }}
                                <span class="badge bg-primary rounded-pill">
                                    {{ $cat->blog_posts_count ?? $cat->posts_count ?? 0 }}
                                </span>
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
                            if (str_starts_with($tag, '["') && str_ends_with($tag, '"]')) {
                            $tagArray = json_decode($tag, true);
                            $displayTags = is_array($tagArray) ? $tagArray : [$tag];
                            } else {
                            $displayTags = explode(',', $tag);
                            }
                            @endphp

                            @foreach($displayTags as $individualTag)
                            @php
                            $cleanTag = trim($individualTag);
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
</x-website.layout.master>