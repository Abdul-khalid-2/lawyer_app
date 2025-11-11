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