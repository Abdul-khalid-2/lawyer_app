<x-website.layout.master :title="$video->title . ' - Law-Skoolyst'"
    :description="$video->description ? \Illuminate\Support\Str::limit(strip_tags($video->description), 155) : 'Watch ' . $video->title . ' on Law-Skoolyst.'"
    :ogImage="$video->thumbnail_url ?? null">



<!-- Video Detail Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Video Content -->
            <div class="col-lg-8">
                <!-- Video Player -->
                <div class="video-container mb-4"
                    data-video-track-url="{{ route('website.videos.track-view', $video->uuid) }}"
                    data-video-duration="{{ $video->duration ?? 0 }}">
                    <iframe class="video-player"
                        src="{{ $video->embed_url }}?rel=0&modestbranding=1"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>

                <!-- Video Info -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <a href="{{ route('website.videos.index', ['topic' => $video->video_topic]) }}"
                            class="badge bg-danger text-decoration-none mb-2">
                            {{ $video->video_topic }}
                        </a>
                        <h1 class="h2 mb-3">{{ $video->title }}</h1>

                        @if($video->description)
                        <div class="video-description mb-4">
                            <p class="lead">{{ $video->description }}</p>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="video-stats text-center">
                            <div class="row">

                                <div class="col-6">
                                    <!-- <div class="stat-item">
                                        <i class="far fa-clock fa-2x text-success mb-2"></i>
                                        <h4 class="mb-1">{{ $video->duration ? gmdate('i', $video->duration) : 'N/A' }}</h4>
                                        <small class="text-muted">Minutes</small>
                                    </div> -->
                                </div>
                                <div class="col-6">
                                    <div class="stat-item">
                                        <i class="far fa-eye fa-2x text-primary mb-2"></i>
                                        <h4 class="mb-1">{{ $video->view_count }}</h4>
                                        <small class="text-muted">Views</small>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <small class="text-muted">
                                    Published: {{ $video->published_at->format('F j, Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lawyer Information -->
                <div class="card border-0 shadow-sm mb-5 lawyer-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="{{ $video->lawyer->user->profile_image ? asset('website/' . $video->lawyer->user->profile_image) : asset('website/images/male_advocate_avatar.jpg') }}"
                                    alt="{{ $video->lawyer->user->name }}"
                                    class="rounded-circle"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <div class="col">
                                <h4 class="mb-1">{{ $video->lawyer->user->name }}</h4>
                                <p class="text-muted mb-2">
                                    @if($video->lawyer->specializations->count() > 0)
                                    {{ $video->lawyer->specializations->pluck('name')->implode(', ') }}
                                    @else
                                    Legal Expert
                                    @endif
                                </p>
                                <p class="text-muted small mb-2">
                                    {{ $video->lawyer->years_of_experience }}+ years experience
                                </p>
                                @if($video->lawyer->bio)
                                <p class="mb-0 text-muted">
                                    {{ Str::limit($video->lawyer->bio, 150) }}
                                </p>
                                @endif
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('website.lawyers.profile', $video->lawyer->uuid) }}" class="btn btn-outline-primary">
                                    View Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Videos -->
                @if($relatedVideos->count() > 0)
                <div class="related-videos-section">
                    <h3 class="h4 mb-4">Related Videos</h3>
                    <div class="row">
                        @foreach($relatedVideos as $relatedVideo)
                        <div class="col-md-6 mb-4">
                            <div class="card related-video-card h-100 border-0 shadow-sm">
                                <div class="video-thumbnail position-relative">
                                    <img src="{{ $relatedVideo->thumbnail_url }}"
                                        class="card-img-top"
                                        alt="{{ $relatedVideo->title }}"
                                        style="height: 160px; object-fit: cover;">
                                    <div class="video-play-icon">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('website.videos.show', $relatedVideo->uuid) }}"
                                        class="badge bg-danger text-decoration-none mb-2">
                                        {{ $relatedVideo->video_topic }}
                                    </a>
                                    <h6 class="card-title">
                                        <a href="{{ route('website.videos.show', $relatedVideo->uuid) }}"
                                            class="text-dark text-decoration-none">
                                            {{ Str::limit($relatedVideo->title, 50) }}
                                        </a>
                                    </h6>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <small class="text-muted">
                                            <i class="far fa-eye me-1"></i>{{ $relatedVideo->view_count }}
                                        </small>
                                        <small class="text-muted">
                                            {{ $relatedVideo->published_at->format('M j, Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Share Video Widget -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-share-alt me-2"></i>Share This Video</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="fab fa-facebook-f me-1"></i>Facebook
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm flex-fill">
                                <i class="fab fa-twitter me-1"></i>Twitter
                            </a>
                            <a href="#" class="btn btn-outline-danger btn-sm flex-fill">
                                <i class="fab fa-youtube me-1"></i>YouTube
                            </a>
                        </div>
                    </div>
                </div>

                <!-- More from Lawyer -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user-tie me-2 text-primary"></i>
                            More from {{ $video->lawyer->user->name }}
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                        $lawyerVideos = \App\Models\YoutubeVideo::with(['lawyer.user'])
                        ->active()
                        ->where('lawyer_id', $video->lawyer_id)
                        ->where('id', '!=', $video->id)
                        ->limit(5)
                        ->get();
                        @endphp

                        @if($lawyerVideos->count() > 0)
                        @foreach($lawyerVideos as $lawyerVideo)
                        <div class="d-flex mb-3 pb-3 border-bottom">
                            <div class="flex-shrink-0 position-relative">
                                <img src="{{ $lawyerVideo->thumbnail_url }}"
                                    alt="{{ $lawyerVideo->title }}"
                                    class="rounded me-3"
                                    style="width: 80px; height: 60px; object-fit: cover;">
                                <div class="video-play-icon" style="width: 30px; height: 30px;">
                                    <i class="fas fa-play" style="font-size: 12px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('website.videos.show', $lawyerVideo->uuid) }}"
                                        class="text-dark text-decoration-none">
                                        {{ Str::limit($lawyerVideo->title, 40) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="far fa-eye me-1"></i>{{ $lawyerVideo->view_count }}
                                </small>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <p class="text-muted mb-0">No other videos from this lawyer yet.</p>
                        @endif
                    </div>
                </div>

                <!-- Browse All Videos CTA -->
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-video fa-2x mb-3"></i>
                        <h5>Explore More Videos</h5>
                        <p class="small opacity-75 mb-3">Discover more legal educational content</p>
                        <a href="{{ route('website.videos.index') }}" class="btn btn-light btn-sm">
                            Browse All Videos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</x-website.layout.master>
