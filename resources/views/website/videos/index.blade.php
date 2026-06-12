<x-website.layout.master title="Legal Videos - Law-Skoolyst"
    description="Watch legal explainer videos and guides from verified lawyers on Law-Skoolyst.">



<!-- Video Header -->
<x-website.sections.page-hero icon="fas fa-play-circle"
    title="Legal Education Videos"
    subtitle="Expert legal explanations, case analyses, and educational content from verified lawyers.">
    <form action="{{ route('website.videos.index') }}" method="GET" class="lc-hero-search">
        <div class="input-group input-group-lg">
            <input type="text" name="search" class="form-control"
                placeholder="Search videos by topic or title..." value="{{ request('search') }}">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
</x-website.sections.page-hero>

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
                        <x-website.cards.video-card :video="$video" />
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
</x-website.layout.master>
