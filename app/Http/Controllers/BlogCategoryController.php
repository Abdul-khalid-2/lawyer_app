<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::withCount('blog_posts')
            ->orderBy('name')
            ->paginate(10);

        return view('dashboard.blogs.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.blogs.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['uuid'] = Str::uuid();
        $validated['is_active'] = $request->has('is_active');

        BlogCategory::create($validated);

        return redirect()->route('blog-categories.index')
            ->with('success', 'Blog category created successfully.');
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('dashboard.blogs.form', ['category' => $blogCategory]);
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name,' . $blogCategory->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $blogCategory->update($validated);

        return redirect()->route('blog-categories.index')
            ->with('success', 'Blog category updated successfully.');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        // Check if category has posts
        if ($blogCategory->blog_posts_count > 0) {
            return redirect()->route('blog-categories.index')
                ->with('error', 'Cannot delete category with associated posts.');
        }

        $blogCategory->delete();

        return redirect()->route('blog-categories.index')
            ->with('success', 'Blog category deleted successfully.');
    }
}
