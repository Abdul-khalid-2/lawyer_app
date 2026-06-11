<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate(10);

        return view('dashboard.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('dashboard.pages.create');
    }

    public function store(PageRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');

        Page::create($validated);

        return redirect()->route('pages.index')
            ->with('success', 'Page created successfully!');
    }

    public function edit(Page $page)
    {
        return view('dashboard.pages.edit', compact('page'));
    }

    public function update(PageRequest $request, Page $page)
    {
        $validated = $request->validated();
        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');

        $page->update($validated);

        return redirect()->route('pages.index')
            ->with('success', 'Page updated successfully!');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('pages.index')
            ->with('success', 'Page deleted successfully!');
    }

    /**
     * Public page view by slug.
     */
    public function show(string $slug)
    {
        $page = Page::published()->where('slug', $slug)->firstOrFail();

        return view('website.page', compact('page'));
    }
}
