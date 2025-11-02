<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('category', 'lawyer.user')
            ->where('lawyer_id', Auth::user()->lawyer->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::where('is_active', true)->get();
        return view('dashboard.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string', // Made nullable since we're using structure
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
            'tags' => 'nullable|string',
            'structure' => 'required|json',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get the lawyer ID
            $lawyer = Auth::user()->lawyer;

            if (!$lawyer) {
                return response()->json([
                    'success' => false,
                    'message' => 'You need to complete your lawyer profile first.'
                ], 422);
            }

            $structureData = json_decode($request->structure, true);

            // Process images from base64 to file storage
            $processedData = $this->processImages($structureData, $lawyer->id);

            // Extract individual element data for separate columns
            $elementData = $this->extractElementData($processedData);

            // Generate unique slug
            $slug = $this->generateUniqueSlug($request->title);

            $blogData = [
                'uuid' => Str::uuid(),
                'lawyer_id' => $lawyer->id,
                'blog_category_id' => $request->blog_category_id,
                'title' => $request->title,
                'slug' => $slug,
                'excerpt' => $request->excerpt,
                'content' => $this->generateContentFromStructure($processedData),
                'structure' => $processedData,
                'status' => $request->status,
                'published_at' => $request->status === 'published' ? now() : null,
            ];

            // Handle tags
            if ($request->tags) {
                $blogData['tags'] = json_encode(array_map('trim', explode(',', $request->tags)));
            }

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                $blogData['featured_image'] = $request->file('featured_image')->store('blog-images', 'public');
            }

            // Add canvas elements data
            $blogData = array_merge($blogData, $elementData);

            $blogPost = BlogPost::create($blogData);

            return response()->json([
                'success' => true,
                'message' => 'Blog post created successfully!',
                'redirect_url' => route('blog-posts.show', $blogPost->id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create blog post: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process images from base64 to file storage
     */
    private function processImages($data, $lawyerId)
    {
        if (!isset($data['elements']) || !is_array($data['elements'])) {
            return $data;
        }

        $folderName = 'lawyer-' . $lawyerId;
        $processedImages = [];

        foreach ($data['elements'] as &$element) {
            if (in_array($element['type'], ['image', 'banner'])) {
                if (isset($element['content']['src']) && $this->isBase64Image($element['content']['src'])) {
                    $filePath = $this->saveBase64Image($element['content']['src'], $folderName);
                    if ($filePath) {
                        $processedImages[$element['content']['src']] = $filePath;
                        $element['content']['src'] = $filePath;
                    }
                }
            }

            // Process HTML content for base64 images
            foreach ($element['content'] as $key => &$value) {
                if (is_string($value) && $this->containsBase64Image($value)) {
                    $value = $this->processHtmlImages($value, $folderName, $processedImages);
                }
            }
        }

        return $data;
    }

    /**
     * Check if string is a base64 image
     */
    private function isBase64Image($string)
    {
        if (!is_string($string)) return false;
        return strpos($string, 'data:image/') === 0 && strpos($string, 'base64,') !== false;
    }

    /**
     * Save base64 image to storage
     */
    private function saveBase64Image($base64Image, $folderName)
    {
        try {
            preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches);
            $imageType = $matches[1] ?? 'jpeg';
            $imageData = base64_decode(substr($base64Image, strpos($base64Image, ',') + 1));

            if (!$imageData) {
                throw new \Exception('Invalid base64 image data');
            }

            $filename = Str::uuid() . '.' . $imageType;
            $filePath = "lawyers/{$folderName}/blog/images/{$filename}";

            Storage::disk('website')->put($filePath, $imageData);

            return $filePath;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Process HTML content and replace base64 images
     */
    private function processHtmlImages($html, $folderName, &$processedImages = [])
    {
        preg_match_all('/src="(data:image\/[^"]+)"/', $html, $matches);

        if (empty($matches[1])) {
            return $html;
        }

        foreach ($matches[1] as $base64Image) {
            if ($this->isBase64Image($base64Image)) {
                if (isset($processedImages[$base64Image])) {
                    $html = str_replace($base64Image, $processedImages[$base64Image], $html);
                } else {
                    $imagePath = $this->saveBase64Image($base64Image, $folderName);
                    if ($imagePath) {
                        $processedImages[$base64Image] = $imagePath;
                        $html = str_replace($base64Image, $imagePath, $html);
                    }
                }
            }
        }

        return $html;
    }

    /**
     * Check if HTML contains base64 images
     */
    private function containsBase64Image($html)
    {
        return is_string($html) && strpos($html, 'data:image/') !== false;
    }

    /**
     * Extract individual element data from structure for separate columns
     */
    private function extractElementData($formData)
    {
        $elementData = [
            'banner' => [],
            'image' => [],
            'rich_text' => [],
            'text_left_image_right' => [],
            'canvas_elements' => []
        ];

        if (isset($formData['elements']) && is_array($formData['elements'])) {
            foreach ($formData['elements'] as $element) {
                $type = $element['type'] ?? null;
                $content = $element['content'] ?? [];
                $position = $element['position'] ?? 0;

                $elementInfo = [
                    'id' => $element['id'] ?? uniqid(),
                    'type' => $type,
                    'content' => $content,
                    'position' => $position,
                    'created_at' => now()->toISOString()
                ];

                // Map element types to database columns
                switch ($type) {
                    case 'banner':
                        $elementData['banner'][] = $elementInfo;
                        break;
                    case 'image':
                        $elementData['image'][] = $elementInfo;
                        break;
                    case 'text':
                        $elementData['rich_text'][] = $elementInfo;
                        break;
                    case 'columns':
                        $elementData['text_left_image_right'][] = $elementInfo;
                        break;
                }

                // Always add to canvas_elements for general storage
                $elementData['canvas_elements'][] = $elementInfo;
            }
        }

        return $elementData;
    }

    /**
     * Generate HTML content from structure for the main content field
     */
    private function generateContentFromStructure($structureData)
    {
        if (!isset($structureData['elements']) || !is_array($structureData['elements'])) {
            return '';
        }

        $content = '';
        foreach ($structureData['elements'] as $element) {
            $content .= $this->renderElementForContent($element);
        }

        return $content;
    }

    /**
     * Render individual element for main content field
     */
    private function renderElementForContent($element)
    {
        $templates = [
            'heading' => fn($el) => "<{$el['content']['level']}>{$el['content']['text']}</{$el['content']['level']}>",
            'text' => fn($el) => $el['content']['content'],
            'image' => fn($el) => $el['content']['src'] ?
                "<figure><img src=\"" . Storage::disk('public')->url($el['content']['src']) . "\" alt=\"{$el['content']['alt']}\">" .
                ($el['content']['caption'] ? "<figcaption>{$el['content']['caption']}</figcaption>" : "") . "</figure>" : '',
            'banner' => fn($el) => $el['content']['src'] ?
                "<div class=\"banner\"><img src=\"" . Storage::disk('public')->url($el['content']['src']) . "\" alt=\"Banner\">" .
                "<div class=\"banner-content\"><h2>{$el['content']['title']}</h2><p>{$el['content']['subtitle']}</p></div></div>" : '',
            'columns' => fn($el) => "<div class=\"row\"><div class=\"col-md-6\">{$el['content']['left']}</div><div class=\"col-md-6\">{$el['content']['right']}</div></div>"
        ];

        return $templates[$element['type']]($element) ?? '';
    }

    /**
     * Generate unique slug for blog post
     */
    private function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        $query = BlogPost::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            $query = BlogPost::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    public function show(BlogPost $blogPost)
    {
        // Increment view count
        $blogPost->increment('view_count');

        return view('blog-posts.show', compact('blogPost'));
    }

    public function edit(BlogPost $blogPost)
    {
        // Check if the user owns this post
        if ($blogPost->lawyer_id !== Auth::user()->lawyer->id) {
            abort(403);
        }

        $categories = BlogCategory::where('is_active', true)->get();
        return view('blog-posts.form', compact('post', 'categories'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        // Check if the user owns this post
        if ($blogPost->lawyer_id !== Auth::user()->lawyer->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
            'tags' => 'nullable|string'
        ]);

        // Update slug if title changed
        if ($blogPost->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        }

        // Handle tags
        if ($request->tags) {
            $validated['tags'] = json_encode(array_map('trim', explode(',', $request->tags)));
        } else {
            $validated['tags'] = null;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($blogPost->featured_image) {
                Storage::disk('website')->delete($blogPost->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blog-images', 'public');
        }

        // Update published_at based on status
        if ($validated['status'] === 'published' && $blogPost->status !== 'published') {
            $validated['published_at'] = now();
        }

        $blogPost->update($validated);

        return redirect()->route('blog-posts.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blogPost)
    {
        // Check if the user owns this post
        if ($blogPost->lawyer_id !== Auth::user()->lawyer->id) {
            abort(403);
        }

        // Delete featured image if exists
        if ($blogPost->featured_image) {
            Storage::disk('public')->delete($blogPost->featured_image);
        }

        $blogPost->delete();

        return redirect()->route('blog-posts.index')
            ->with('success', 'Blog post deleted successfully.');
    }
}
