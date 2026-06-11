@props(['video'])
<div class="col-md-6 mb-4">
    <article class="lc-card lc-video-card">
        <div class="lc-video-card__thumb">
            <x-website.ui.image :src="$video->thumbnail_url" :alt="$video->title" ratio="16x9"
                :fallback="asset('website/images/male_advocate_avatar.jpg')" />
            <a href="{{ route('website.videos.show', $video->uuid) }}" class="lc-video-card__play" aria-label="Play video">
                <i class="fas fa-play"></i>
            </a>
        </div>

        <div class="lc-card__body">
            <a href="{{ route('website.videos.show', $video->uuid) }}" class="text-decoration-none mb-2">
                <x-website.ui.badge variant="danger">{{ $video->video_topic }}</x-website.ui.badge>
            </a>

            <h5 class="lc-video-card__title">
                <a href="{{ route('website.videos.show', $video->uuid) }}">{{ Str::limit($video->title, 60) }}</a>
            </h5>

            @if($video->description)
                <p class="lc-video-card__desc">{{ Str::limit($video->description, 100) }}</p>
            @endif

            <div class="lc-card__footer lc-video-card__footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <x-website.ui.avatar
                            :src="$video->lawyer->user->profile_image ? asset('website/' . $video->lawyer->user->profile_image) : asset('website/images/male_advocate_avatar.jpg')"
                            :name="$video->lawyer->user->name" size="sm" />
                        <small class="text-muted">{{ $video->lawyer->user->name }}</small>
                    </div>
                    <small class="text-muted"><i class="far fa-eye me-1"></i>{{ $video->view_count }}</small>
                </div>
                <div class="mt-2">
                    <small class="text-muted">{{ $video->published_at?->format('M j, Y') }}</small>
                </div>
            </div>
        </div>
    </article>
</div>
