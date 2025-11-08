<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $categories = BlogCategory::where('is_active', true)->get();
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

        // Related posts
        $relatedPosts = $this->getRelatedPosts($post);
        $popularPosts = $this->getPopularPosts();
        $categories = BlogCategory::where('is_active', true)->get();
        $tags = $this->getAllTags();

        return view('website.blog.show', compact(
            'post',
            'relatedPosts',
            'popularPosts',
            'categories',
            'tags'
        ));
    }

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

        $popularPosts = $this->getPopularPosts();
        $categories = BlogCategory::where('is_active', true)->get();
        $tags = $this->getAllTags();

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
        $posts = BlogPost::with(['lawyer.user', 'category'])
            ->where('tags', 'like', '%"' . $tag . '"%')
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $popularPosts = $this->getPopularPosts();
        $categories = BlogCategory::where('is_active', true)->get();
        $tags = $this->getAllTags();

        return view('website.blog.tag', compact(
            'tag',
            'posts',
            'popularPosts',
            'categories',
            'tags'
        ));
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

    private function getPopularPosts($limit = 5)
    {
        return BlogPost::with(['lawyer.user', 'category'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('view_count', 'desc')
            ->limit($limit)
            ->get();
    }

    private function getRecentPosts($limit = 5)
    {
        return BlogPost::with(['lawyer.user', 'category'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    private function getRelatedPosts($post, $limit = 3)
    {
        return BlogPost::with(['lawyer.user', 'category'])
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
