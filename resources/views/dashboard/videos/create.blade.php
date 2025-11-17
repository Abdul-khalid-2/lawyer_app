<x-app-layout>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Add New Video</h1>
            <a href="{{ route('videos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Videos
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('videos.store') }}" method="POST" id="videoForm">
                            @csrf

                            <div class="form-group">
                                <label for="title">Video Title *</label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="video_topic">Video Topic *</label>
                                <input type="text" name="video_topic" id="video_topic" class="form-control @error('video_topic') is-invalid @enderror" value="{{ old('video_topic') }}" required>
                                @error('video_topic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="youtube_link">YouTube Embed Code or URL *</label>
                                <textarea name="youtube_link" id="youtube_link" class="form-control @error('youtube_link') is-invalid @enderror" rows="3" placeholder='Paste embed code: &lt;iframe width="560" height="315" src="https://www.youtube.com/embed/VIDEO_ID" ...&gt;&lt;/iframe&gt; OR YouTube URL' required>{{ old('youtube_link') }}</textarea>
                                @error('youtube_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror>
                                <small class="form-text text-muted">
                                    <strong>How to get the embed code:</strong>
                                    <ol class="pl-3 mt-1">
                                        <li>Go to your YouTube video</li>
                                        <li>Click on <strong>"Share"</strong> below the video</li>
                                        <li>Click on <strong>"Embed"</strong></li>
                                        <li>Copy the entire <strong>&lt;iframe&gt;...&lt;/iframe&gt;</strong> code</li>
                                        <li>Paste it in the field above</li>
                                    </ol>
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_active">Active</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_featured">Featured</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save Video</button>
                                <a href="{{ route('videos.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle"></i> Instructions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h6>How to Add YouTube Video:</h6>
                            <ol class="pl-3 mb-0">
                                <li class="mb-2">Find your video on YouTube</li>
                                <li class="mb-2">Click the <strong>"Share"</strong> button below the video</li>
                                <li class="mb-2">Click on <strong>"Embed"</strong> option</li>
                                <li class="mb-2">Copy the entire embed code</li>
                                <li>Paste it in the "YouTube Embed Code" field</li>
                            </ol>
                        </div>

                        <div class="text-center">
                            <img src="https://img.icons8.com/color/96/000000/youtube-play.png" alt="YouTube" class="mb-2">
                            <p class="small text-muted">
                                The system will automatically extract the video ID from the embed code or URL.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-eye"></i> Preview
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="videoPreview" class="text-center">
                            <p class="text-muted">Video preview will appear here after you paste the embed code or URL.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const youtubeLinkInput = document.getElementById('youtube_link');
            const videoPreview = document.getElementById('videoPreview');
            const videoForm = document.getElementById('videoForm');

            function extractVideoId(input) {
                // Try to extract from embed code
                const embedMatch = input.match(/youtube\.com\/embed\/([^"&?\/\s]{11})/);
                if (embedMatch) return embedMatch[1];

                // Try to extract from watch URL
                const watchMatch = input.match(/youtube\.com\/watch\?v=([^"&?\/\s]{11})/);
                if (watchMatch) return watchMatch[1];

                // Try to extract from youtu.be URL
                const shortMatch = input.match(/youtu\.be\/([^"&?\/\s]{11})/);
                if (shortMatch) return shortMatch[1];

                return null;
            }

            function updatePreview() {
                const input = youtubeLinkInput.value.trim();
                
                if (!input) {
                    videoPreview.innerHTML = '<p class="text-muted">Video preview will appear here after you paste the embed code or URL.</p>';
                    return;
                }

                const videoId = extractVideoId(input);
                
                if (videoId) {
                    const embedHtml = `
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" 
                                    src="https://www.youtube.com/embed/${videoId}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                            </iframe>
                        </div>
                        <p class="small text-muted mt-2">Preview: Your video will appear like this on the website.</p>
                    `;
                    videoPreview.innerHTML = embedHtml;
                } else {
                    videoPreview.innerHTML = `
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            Please paste a valid YouTube embed code or URL.
                        </div>
                    `;
                }
            }

            // Update preview on input change
            youtubeLinkInput.addEventListener('input', updatePreview);
            youtubeLinkInput.addEventListener('paste', function(e) {
                // Wait for paste to complete
                setTimeout(updatePreview, 100);
            });

            // Form validation
            videoForm.addEventListener('submit', function(e) {
                const input = youtubeLinkInput.value.trim();
                const videoId = extractVideoId(input);
                
                if (!videoId) {
                    e.preventDefault();
                    alert('Please paste a valid YouTube embed code or URL. Make sure to use the "Embed" code from YouTube.');
                    youtubeLinkInput.focus();
                }
            });

            // Initial preview update
            updatePreview();
        });
    </script>
</x-app-layout>