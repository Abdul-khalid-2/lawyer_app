<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - LegalConsultent</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #2c5aa0;
            --primary-dark: #1e3d72;
            --secondary: #d4af37;
            --accent: #8b4513;
            --dark: #1a1a1a;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            line-height: 1.7;
            color: #333;
            min-height: 100vh;
            background: #fefefe;
        }

        /* ==================== HERO HEADER ==================== */
        .page-hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 100px 0 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .back-button {
            position: absolute;
            top: 30px;
            left: 30px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-5px);
        }

        .hero-meta {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .hero-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            backdrop-filter: blur(10px);
        }

        /* ==================== CONTENT CANVAS ==================== */
        .content-wrapper {
            padding: 40px 0;
        }

        .canvas-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        }

        /* ==================== ELEMENTS ==================== */
        .page-element {
            margin-bottom: 3rem;
            padding: 2rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            /* border-left: 4px solid transparent; */
        }

        /* Element Type Specific Styles */
        .element-heading {
            border-left-color: var(--primary);
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        }

        .element-heading h1,
        .element-heading h2,
        .element-heading h3 {
            color: var(--primary-dark);
            margin: 0;
            font-weight: 600;
            line-height: 1.3;
        }

        .element-text {
            background: #ffffff;
            border: 1px solid #e8e8e8;
        }

        .element-image {
            text-align: center;
            padding: 2rem !important;
            background: #fafafa;
            border: 1px solid #e8e8e8;
        }

        .element-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .element-banner {
            padding: 0 !important;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e8e8e8;
        }

        .element-banner img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
        }

        .element-columns {
            background: #ffffff;
            border: 1px solid #e8e8e8;
        }

        /* Element Badge */
        .element-badge {
            background: var(--primary);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        /* Banner Caption */
        .banner-caption {
            padding: 2rem;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            color: white;
            text-align: center;
        }

        .banner-caption h3 {
            color: white;
            margin-bottom: 0.5rem;
        }

        /* Image Caption */
        .image-caption {
            font-style: italic;
            color: #666;
            text-align: center;
            margin-top: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 6px;
            /* border-left: 3px solid var(--secondary); */
        }

        /* Two Column Layout */
        .two-col {
            display: flex;
            gap: 2rem;
            align-items: flex-start;
        }

        .two-col .col-left,
        .two-col .col-right {
            flex: 1;
        }

        /* Rich Text Content */
        .rich-text-content {
            color: #444;
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .rich-text-content h1,
        .rich-text-content h2,
        .rich-text-content h3 {
            color: var(--primary-dark);
            margin-top: 2rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--secondary);
            padding-bottom: 0.5rem;
        }

        .rich-text-content ul,
        .rich-text-content ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }

        .rich-text-content blockquote {
            /* border-left: 4px solid var(--secondary); */
            padding-left: 1.5rem;
            margin: 2rem 0;
            font-style: italic;
            color: #666;
            background: #fafafa;
            padding: 1.5rem;
            border-radius: 0 8px 8px 0;
        }

        /* CKEditor Content Styles */
        .ck-content {
            font-family: 'Georgia', 'Times New Roman', serif;
            line-height: 1.8;
            color: #444;
            font-size: 1.1rem;
        }

        .ck-content h1,
        .ck-content h2,
        .ck-content h3,
        .ck-content h4,
        .ck-content h5,
        .ck-content h6 {
            margin-top: 2em;
            margin-bottom: 1em;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .ck-content h1 {
            font-size: 2.2rem;
            border-bottom: 3px solid var(--secondary);
            padding-bottom: 0.5rem;
        }

        .ck-content h2 {
            font-size: 1.8rem;
        }

        .ck-content h3 {
            font-size: 1.5rem;
        }

        .ck-content h4 {
            font-size: 1.3rem;
        }

        .ck-content h5 {
            font-size: 1.1rem;
        }

        .ck-content h6 {
            font-size: 1rem;
        }

        .ck-content p {
            margin-bottom: 1.5em;
        }

        .ck-content ul,
        .ck-content ol {
            margin-bottom: 1.5em;
            padding-left: 2em;
        }

        .ck-content ul {
            list-style-type: disc;
        }

        .ck-content ol {
            list-style-type: decimal;
        }

        .ck-content blockquote {
            /* border-left: 4px solid var(--secondary); */
            padding-left: 1.5em;
            margin: 2em 0;
            font-style: italic;
            color: #666;
            background: #fafafa;
            padding: 1.5em;
            border-radius: 0 8px 8px 0;
        }

        .ck-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 2em 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .ck-content table th,
        .ck-content table td {
            border: 1px solid #ddd;
            padding: 1em;
            text-align: left;
        }

        .ck-content table th {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
        }

        .ck-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .ck-content a {
            color: var(--primary);
            text-decoration: none;
            border-bottom: 1px solid var(--primary);
            transition: all 0.3s ease;
        }

        .ck-content a:hover {
            color: var(--primary-dark);
            border-bottom-color: var(--primary-dark);
        }

        /* Blog Post Meta */
        .post-meta {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            /* border-left: 4px solid var(--secondary); */
        }

        .post-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .meta-item i {
            color: var(--primary);
            width: 20px;
        }

        /* Tags */
        .post-tags {
            margin: 2rem 0;
        }

        .tag {
            display: inline-block;
            background: #e9ecef;
            color: #495057;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            margin: 0.2rem;
            border: 1px solid #dee2e6;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.4;
        }

        /* Footer */
        .page-footer {
            background: var(--primary-dark);
            color: #e2e8f0;
            padding: 3rem 0;
            margin-top: 4rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .back-button {
                top: 15px;
                left: 15px;
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }

            .canvas-container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .page-element {
                padding: 1.5rem;
                margin-bottom: 2rem;
            }

            .two-col {
                flex-direction: column;
                gap: 1.5rem;
            }

            .ck-content h1 {
                font-size: 1.8rem;
            }

            .ck-content h2 {
                font-size: 1.5rem;
            }

            .ck-content h3 {
                font-size: 1.3rem;
            }

            .hero-meta {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Back Button -->
    <a href="{{ route('blog-posts.index') }}" class="back-button">
        <i class="fas fa-arrow-left"></i>
        <span>Back to Posts</span>
    </a>

    <!-- Hero Header -->
    <div class="page-hero">
        <div class="hero-content container">
            <h1 class="hero-title">{{ $post->title }}</h1>

            @if($post->excerpt)
            <p class="hero-subtitle">{{ $post->excerpt }}</p>
            @endif

            <div class="hero-meta">
                <div class="hero-meta-item">
                    <i class="fas fa-user"></i>
                    <span>By {{ $post->lawyer->user->name ?? 'Author' }}</span>
                </div>
                <div class="hero-meta-item">
                    <i class="fas fa-calendar"></i>
                    <span>Published: {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}</span>
                </div>
                <div class="hero-meta-item">
                    <i class="fas fa-eye"></i>
                    <span>{{ $post->view_count }} Views</span>
                </div>
                @if($post->category)
                <div class="hero-meta-item">
                    <i class="fas fa-folder"></i>
                    <span>{{ $post->category->name }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Content Canvas -->
    <div class="content-wrapper">
        <div class="container">
            <div class="canvas-container" id="pageCanvas">
                <!-- Blog Post Meta Information -->
                <div class="post-meta">
                    <div class="post-meta-grid">
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>Read Time: {{ $post->read_time }} min</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Created: {{ $post->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-tags"></i>
                            <span>Category: {{ $post->category->name ?? 'Uncategorized' }}</span>
                        </div>
                    </div>

                    @if($post->tags && count(json_decode($post->tags, true)) > 0)
                    <div class="post-tags">
                        <strong>Tags:</strong>
                        @foreach(json_decode($post->tags, true) as $tag)
                        <span class="tag">#{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Featured Image -->
                @if($post->featured_image)
                <div class="page-element element-image">
                    <img src="{{ asset('website/' . $post->featured_image) }}"
                        alt="{{ $post->title }}"
                        class="img-fluid">
                </div>
                @endif

                <!-- Dynamic Content Elements -->
                @if(isset($post->structure['elements']) && count($post->structure['elements']) > 0)
                @foreach($post->structure['elements'] as $index => $element)
                @php
                $elementType = $element['type'] ?? '';
                $elementContent = $element['content'] ?? [];
                $elementPosition = $element['position'] ?? $index;
                @endphp

                @switch($elementType)
                @case('heading')
                <div class="page-element element-heading">
                    <div class="element-badge">
                        <i class="fas fa-heading"></i>
                        Heading
                    </div>
                    <{{ $elementContent['level'] ?? 'h2' }} class="mb-0">
                        {{ $elementContent['text'] ?? 'Heading Text' }}
                    </{{ $elementContent['level'] ?? 'h2' }}>
                </div>
                @break

                @case('text')
                <div class="page-element element-text">
                    <div class="element-badge">
                        <i class="fas fa-paragraph"></i>
                        Content
                    </div>
                    <div class="ck-content rich-text-content">
                        {!! $elementContent['content'] ?? '<p>Content goes here...</p>' !!}
                    </div>
                </div>
                @break

                @case('image')
                <div class="page-element element-image">
                    <div class="element-badge">
                        <i class="fas fa-image"></i>
                        Image
                    </div>
                    @if(isset($elementContent['src']) && $elementContent['src'])
                    <img src="{{ $elementContent['src'] }}"
                        alt="{{ $elementContent['alt'] ?? 'Legal Content Image' }}"
                        style="max-height: 400px;">
                    @else
                    <div class="text-center py-4 bg-light rounded text-muted">
                        <i class="fas fa-image fa-2x mb-2"></i>
                        <p>No Image Available</p>
                    </div>
                    @endif
                    @if(isset($elementContent['caption']) && $elementContent['caption'])
                    <div class="image-caption mt-3">
                        {{ $elementContent['caption'] }}
                    </div>
                    @endif
                </div>
                @break

                @case('banner')
                <div class="page-element element-banner">
                    <div class="element-badge">
                        <i class="fas fa-banner"></i>
                        Banner
                    </div>
                    @if(isset($elementContent['src']) && $elementContent['src'])
                    <img src="{{ $elementContent['src'] }}"
                        alt="{{ $elementContent['alt'] ?? 'Legal Banner' }}"
                        style="max-height: 400px;">
                    @else
                    <div class="text-center py-5 bg-light text-muted">
                        <i class="fas fa-image fa-3x mb-3"></i>
                        <p>No Banner Image</p>
                    </div>
                    @endif
                    @if(isset($elementContent['title']) || isset($elementContent['subtitle']))
                    <div class="banner-caption">
                        @if(isset($elementContent['title']))
                        <h3 class="mb-2 text-white">{{ $elementContent['title'] }}</h3>
                        @endif
                        @if(isset($elementContent['subtitle']))
                        <p class="mb-0">{{ $elementContent['subtitle'] }}</p>
                        @endif
                    </div>
                    @endif
                </div>
                @break

                @case('columns')
                <div class="page-element element-columns">
                    <div class="element-badge">
                        <i class="fas fa-columns"></i>
                        Two Columns
                    </div>
                    <div class="two-col">
                        <div class="col-left">
                            @if(isset($elementContent['left']))
                            <div class="ck-content rich-text-content">
                                {!! $elementContent['left'] !!}
                            </div>
                            @else
                            <p class="text-muted">Legal content goes here...</p>
                            @endif
                        </div>
                        <div class="col-right">
                            @if(isset($elementContent['right']))
                            <div class="ck-content rich-text-content">
                                {!! $elementContent['right'] !!}
                            </div>
                            @else
                            <p class="text-muted">Additional legal insights...</p>
                            @endif
                        </div>
                    </div>
                </div>
                @break

                @default
                <div class="page-element">
                    <div class="element-badge">
                        <i class="fas fa-question"></i>
                        Content Element
                    </div>
                    <p>This content element couldn't be displayed properly.</p>
                </div>
                @endswitch
                @endforeach
                @else
                <!-- Fallback to traditional content if no structure -->
                @if($post->content)
                <div class="page-element element-text">
                    <div class="ck-content rich-text-content">
                        {!! $post->content !!}
                    </div>
                </div>
                @else
                <div class="empty-state">
                    <i class="fas fa-file-alt"></i>
                    <h3>No Content Available</h3>
                    <p>This blog post doesn't have any content yet.</p>
                </div>
                @endif
                @endif

                <!-- Author Bio Section -->
                <div class="page-element element-text mt-5">
                    <div class="element-badge">
                        <i class="fas fa-user-tie"></i>
                        About the Author
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            @if($post->lawyer->user->profile_image)
                            <img src="{{ asset('website/' . $post->lawyer->user->profile_image) }}"
                                alt="{{ $post->lawyer->user->name }}"
                                class="rounded-circle img-fluid" style="max-width: 100px;">
                            @else
                            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                                style="width: 100px; height: 100px; font-size: 2rem;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-10">
                            <h4>{{ $post->lawyer->user->name }}</h4>
                            <p class="text-muted mb-2">
                                {{ $post->lawyer->firm_name ?? 'Legal Consultant' }}
                            </p>
                            @if($post->lawyer->bio)
                            <p class="mb-0">{{ Str::limit($post->lawyer->bio, 200) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="page-footer">
        <div class="container">
            <div class="text-center">
                <div class="footer-brand mb-2" style="font-size: 1.5rem; font-weight: 700; color: white;">
                    LegalConsultent
                </div>
                <p class="mb-2">Professional Legal Consulting Services</p>
                <p class="mb-0">&copy; {{ date('Y') }} LegalConsultent. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add fade-in animation to elements
            const elements = document.querySelectorAll('.page-element');
            elements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    element.style.transition = 'all 0.6s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 150);
            });

            // Make images in CKEditor content responsive
            document.querySelectorAll('.ck-content img').forEach(img => {
                img.classList.add('img-fluid');
            });

            // Add table responsive wrapper
            document.querySelectorAll('.ck-content table').forEach(table => {
                const wrapper = document.createElement('div');
                wrapper.className = 'table-responsive';
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>