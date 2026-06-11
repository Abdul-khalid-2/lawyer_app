@props(['post', 'showTags' => false])
<div class="col-md-6 mb-4">
    <article class="lc-card lc-blog-card">
        @if($post->featured_image)
            <x-website.ui.image :src="asset('website/' . $post->featured_image)" :alt="$post->title"
                ratio="16x9" class="lc-blog-card__img" />
        @else
            <div class="lc-blog-card__placeholder">
                <i class="fas fa-newspaper"></i>
            </div>
        @endif

        <div class="lc-card__body">
            @if($post->category)
                <a href="{{ route('website.blog.category', $post->category->slug) }}" class="text-decoration-none mb-2">
                    <x-website.ui.badge variant="verified">{{ $post->category->name }}</x-website.ui.badge>
                </a>
            @endif

            <h5 class="lc-blog-card__title">
                <a href="{{ route('website.blog.show', $post->slug) }}">{{ Str::limit($post->title, 60) }}</a>
            </h5>

            <p class="lc-blog-card__excerpt">{{ Str::limit(strip_tags($post->excerpt ?: $post->content), 120) }}</p>

            @if($showTags && $post->tags)
                @php
                    $postTags = [];
                    if (is_string($post->tags)) {
                        $postTags = (str_starts_with($post->tags, '[') && str_ends_with($post->tags, ']'))
                            ? (json_decode($post->tags, true) ?? [])
                            : array_map('trim', explode(',', $post->tags));
                    } elseif (is_array($post->tags)) {
                        $postTags = $post->tags;
                    }
                @endphp
                <div class="d-flex flex-wrap gap-1 mb-3">
                    @foreach(array_slice($postTags, 0, 3) as $postTag)
                        @if(!empty(trim($postTag)))
                            <a href="{{ route('website.blog.tag', trim($postTag)) }}" class="text-decoration-none">
                                <x-website.ui.badge variant="neutral">#{{ trim($postTag) }}</x-website.ui.badge>
                            </a>
                        @endif
                    @endforeach
                    @if(count($postTags) > 3)
                        <x-website.ui.badge variant="neutral">+{{ count($postTags) - 3 }} more</x-website.ui.badge>
                    @endif
                </div>
            @endif

            <div class="lc-card__footer lc-blog-card__footer">
                <div class="d-flex align-items-center gap-2">
                    <x-website.ui.avatar
                        :src="$post->lawyer->user->profile_image ? asset('website/' . $post->lawyer->user->profile_image) : asset('website/images/male_advocate_avatar.jpg')"
                        :name="$post->lawyer->user->name" size="sm" />
                    <small class="text-muted">{{ $post->lawyer->user->name }}</small>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <small class="text-muted">{{ $post->published_at?->format('M j, Y') }}</small>
                    <small class="text-muted"><i class="far fa-eye me-1"></i>{{ $post->view_count }}</small>
                </div>
            </div>
        </div>
    </article>
</div>
