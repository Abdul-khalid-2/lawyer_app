<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WebsiteBlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with(['lawyer.user', 'category'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%")
                    ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                    ->orWhereHas('lawyer.user', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by tag
        if ($request->has('tag') && $request->tag) {
            $query->where('tags', 'like', '%"' . $request->tag . '"%');
        }

        // Sort options
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'featured':
                $query->where('is_featured', true)->orderBy('published_at', 'desc');
                break;
            default:
                $query->orderBy('published_at', 'desc');
        }

        $posts = $query->paginate(9);

        // Prepare structure for display
        foreach ($posts as $post) {
            if ($post->structure) {
                $post->structure = $this->prepareForDisplay($post->structure);
            }
        }

        $categories = BlogCategory::withCount([
            'blog_posts',
            'published_posts as published_posts_count'
        ])->get();
        $popularPosts = $this->getPopularPosts();
        $recentPosts = $this->getRecentPosts();
        $tags = $this->getAllTags();

        return view('website.blog.index', compact(
            'posts',
            'categories',
            'popularPosts',
            'recentPosts',
            'tags',
            'request'
        ));
    }

    public function show($slug)
    {
        $post = BlogPost::with(['lawyer.user', 'category'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        // Increment view count
        $post->increment('view_count');

        // Prepare structure for display
        if ($post->structure) {
            $post->structure = $this->prepareForDisplay($post->structure);
        }

        // Related posts
        $relatedPosts = $this->getRelatedPosts($post);
        $popularPosts = $this->getPopularPosts();
        $categories = BlogCategory::withCount([
            'blog_posts',
            'published_posts as published_posts_count'
        ])->get();
        $tags = $this->getAllTags();

        return view('website.blog.show', compact(
            'post',
            'relatedPosts',
            'popularPosts',
            'categories',
            'tags'
        ));
    }
    // ---------------------------------------------
    /**
     * Prepare data for display by converting image paths to URLs
     */
    private function prepareForDisplay($structure)
    {
        if (!isset($structure['elements']) || !is_array($structure['elements'])) {
            return $structure;
        }

        foreach ($structure['elements'] as &$element) {
            if (isset($element['content'])) {
                // Convert image paths to URLs
                if (isset($element['content']['src']) && is_string($element['content']['src'])) {
                    $element['content']['src'] = $this->getCorrectImageUrl($element['content']['src']);
                }

                // Process HTML content for image paths
                foreach ($element['content'] as $key => &$value) {
                    if (is_string($value)) {
                        $value = $this->convertImagePathsToUrls($value);
                    }
                }
            }
        }

        return $structure;
    }

    /**
     * Get correct image URL with proper domain and path
     */
    private function getCorrectImageUrl($path)
    {
        // If it's already a full URL, return as is
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // If it's a storage path from website disk, generate proper URL
        if (strpos($path, 'lawyers/') === 0 || strpos($path, 'blog-images/') === 0) {
            // Check if file exists in storage
            if (Storage::disk('website')->exists($path)) {
                return Storage::disk('website')->url($path);
            }
        }

        // For featured images and other paths
        if (strpos($path, '/') !== false) {
            return asset('website/' . $path);
        }

        // Default fallback
        return asset('website/' . $path);
    }

    /**
     * Convert storage paths to URLs in HTML content
     */
    private function convertImagePathsToUrls($content)
    {
        if (empty($content) || !is_string($content)) {
            return $content;
        }

        // Replace image paths in src attributes for website disk
        $content = preg_replace_callback(
            '/src=(["\'])(lawyers\/[^\1]+?\.(jpg|jpeg|png|gif|webp))\1/i',
            function ($matches) {
                return 'src=' . $matches[1] . $this->getCorrectImageUrl($matches[2]) . $matches[1];
            },
            $content
        );

        // Replace other image paths
        $content = preg_replace_callback(
            '/src=(["\'])(blog-images\/[^\1]+?\.(jpg|jpeg|png|gif|webp))\1/i',
            function ($matches) {
                return 'src=' . $matches[1] . $this->getCorrectImageUrl($matches[2]) . $matches[1];
            },
            $content
        );

        return $content;
    }
    // ---------------------------------------------
    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $posts = BlogPost::with(['lawyer.user', 'category'])
            ->where('blog_category_id', $category->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        // Prepare structure for display
        foreach ($posts as $post) {
            if ($post->structure) {
                $post->structure = $this->prepareForDisplay($post->structure);
            }
        }

        $popularPosts = $this->getPopularPosts();
        $categoriesCount = BlogCategory::where('is_active', true)->get();
        $categories = BlogCategory::get();
        $tags = $this->getAllTags();

        abort(404);
        return view('website.blog.category', compact(
            'category',
            'posts',
            'popularPosts',
            'categories',
            'tags'
        ));
    }

    public function tag($tag)
    {
        $cleanTag = trim($tag, '[]"\'');

        $posts = BlogPost::with(['lawyer.user', 'category'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(function ($query) use ($cleanTag) {
                // Search in JSON tags array
                $query->whereJsonContains('tags', $cleanTag)
                    ->orWhere('tags', 'like', '%"' . $cleanTag . '"%')
                    ->orWhere('tags', 'like', '%' . $cleanTag . '%');
            })
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        // Prepare structure for display
        foreach ($posts as $post) {
            if ($post->structure) {
                $post->structure = $this->prepareForDisplay($post->structure);
            }
        }

        $popularPosts = $this->getPopularPosts();
        $categories = BlogCategory::where('is_active', true)->get();
        $tags = $this->getAllTags();

        // Get related tags (tags that appear together with the current tag)
        $relatedTags = $this->getRelatedTags($cleanTag);

        return view('website.blog.tag', compact(
            'tag',
            'posts',
            'popularPosts',
            'categories',
            'tags',
            'relatedTags'
        ));
    }

    private function getRelatedTags($currentTag)
    {
        // Get posts with the current tag
        $postsWithTag = BlogPost::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(function ($query) use ($currentTag) {
                $query->whereJsonContains('tags', $currentTag)
                    ->orWhere('tags', 'like', '%"' . $currentTag . '"%')
                    ->orWhere('tags', 'like', '%' . $currentTag . '%');
            })
            ->get();

        // Collect all tags from these posts
        $relatedTags = collect();

        foreach ($postsWithTag as $post) {
            if ($post->tags) {
                $postTags = [];
                if (is_string($post->tags)) {
                    if (str_starts_with($post->tags, '[') && str_ends_with($post->tags, ']')) {
                        $postTags = json_decode($post->tags, true) ?? [];
                    } else {
                        $postTags = array_map('trim', explode(',', $post->tags));
                    }
                } elseif (is_array($post->tags)) {
                    $postTags = $post->tags;
                }

                foreach ($postTags as $tag) {
                    $cleanTag = trim($tag);
                    if (!empty($cleanTag) && $cleanTag !== $currentTag) {
                        $relatedTags->push($cleanTag);
                    }
                }
            }
        }

        // Count occurrences and return top 10
        return $relatedTags->countBy()->sortDesc()->keys()->take(10);
    }

    public function author($uuid)
    {
        $lawyer = Lawyer::with('user')
            ->where('uuid', $uuid)
            ->firstOrFail();

        $posts = BlogPost::with(['lawyer.user', 'category'])
            ->where('lawyer_id', $lawyer->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        // Prepare structure for display
        foreach ($posts as $post) {
            if ($post->structure) {
                $post->structure = $this->prepareForDisplay($post->structure);
            }
        }

        $popularPosts = $this->getPopularPosts();
        $categories = BlogCategory::where('is_active', true)->get();
        $tags = $this->getAllTags();

        return view('website.blog.author', compact(
            'lawyer',
            'posts',
            'popularPosts',
            'categories',
            'tags'
        ));
    }

    /**
     * Prepare data for display by converting image paths to URLs
     */


    private function getPopularPosts($limit = 5)
    {
        $posts = BlogPost::with(['lawyer.user', 'category'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('view_count', 'desc')
            ->limit($limit)
            ->get();

        // Prepare structure for display
        foreach ($posts as $post) {
            if ($post->structure) {
                $post->structure = $this->prepareForDisplay($post->structure);
            }
        }

        return $posts;
    }

    private function getRecentPosts($limit = 5)
    {
        $posts = BlogPost::with(['lawyer.user', 'category'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();

        // Prepare structure for display
        foreach ($posts as $post) {
            if ($post->structure) {
                $post->structure = $this->prepareForDisplay($post->structure);
            }
        }

        return $posts;
    }

    private function getRelatedPosts($post, $limit = 3)
    {
        $posts = BlogPost::with(['lawyer.user', 'category'])
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where(function ($query) use ($post) {
                $query->where('blog_category_id', $post->blog_category_id)
                    ->orWhere('tags', 'like', '%"' . $post->tags[0] . '"%');
            })
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();

        // Prepare structure for display
        foreach ($posts as $blogPost) {
            if ($blogPost->structure) {
                $blogPost->structure = $this->prepareForDisplay($blogPost->structure);
            }
        }

        return $posts;
    }

    private function getAllTags()
    {
        return BlogPost::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereNotNull('tags')
            ->get()
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->filter()
            ->values();
    }
}
