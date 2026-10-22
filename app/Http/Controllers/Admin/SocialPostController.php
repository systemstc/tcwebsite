<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialPost;
use App\Models\ActivityLog;
use App\Services\SocialMediaFetcherService;

class SocialPostController extends Controller
{
    public function index(Request $request)
    {
        $query = SocialPost::query();

        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }

        $posts = $query->orderBy('platform')->orderBy('sort_order')->paginate(20);
        $counts = [
            'all' => SocialPost::count(),
            'twitter' => SocialPost::where('platform', 'twitter')->count(),
            'youtube' => SocialPost::where('platform', 'youtube')->count(),
            'facebook' => SocialPost::where('platform', 'facebook')->count(),
            'instagram' => SocialPost::where('platform', 'instagram')->count(),
        ];

        return view('admin.social_posts.index', compact('posts', 'counts'));
    }

    /**
     * One-Click Quick Store: Paste link only, system auto-detects and auto-fetches everything!
     */
    public function quickStore(Request $request)
    {
        $request->validate([
            'post_url' => 'required|url',
        ]);

        $details = SocialMediaFetcherService::fetchPostDetails($request->post_url);

        // Calculate next sort order
        $maxOrder = SocialPost::where('platform', $details['platform'])->max('sort_order') ?? 0;
        $details['sort_order'] = $maxOrder + 1;

        $post = SocialPost::create($details);

        ActivityLog::record('create', 'social_posts', $post->id, "Quick-added {$post->getPlatformLabel()} post via link: {$post->post_url}");

        return redirect()->route('admin.social-posts.index', ['platform' => $post->platform])
            ->with('success', "Success! Detected {$post->getPlatformLabel()} and added the post to the front-end feed automatically.");
    }

    /**
     * API for fetching metadata live while typing/pasting in the form
     */
    public function fetchMetadata(Request $request)
    {
        $url = $request->query('url');
        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['success' => false, 'message' => 'Invalid URL']);
        }

        $details = SocialMediaFetcherService::fetchPostDetails($url);
        return response()->json(['success' => true, 'data' => $details]);
    }

    public function create()
    {
        return view('admin.social_posts.create');
    }

    public function store(Request $request)
    {
        $url = $request->input('post_url');
        $detectedPlatform = $url ? SocialMediaFetcherService::detectPlatform($url) : 'twitter';

        $validated = $request->validate([
            'platform' => 'nullable|in:twitter,youtube,facebook,instagram',
            'post_url' => 'required|url',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'author_name' => 'nullable|string|max:150',
            'author_handle' => 'nullable|string|max:100',
            'post_date' => 'nullable|string|max:100',
            'likes_count' => 'nullable|string|max:50',
            'comments_count' => 'nullable|string|max:50',
            'shares_count' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'media_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $platform = $validated['platform'] ?: $detectedPlatform;
        $autoDetails = SocialMediaFetcherService::fetchPostDetails($validated['post_url'], $platform);

        $mediaImage = $autoDetails['media_image'];

        // Custom image upload overrides auto thumbnail
        if ($request->hasFile('media_image_file')) {
            $path = $request->file('media_image_file')->store('social_posts', 'public');
            $mediaImage = 'storage/' . $path;
        }

        $post = SocialPost::create([
            'platform' => $platform,
            'post_url' => $validated['post_url'],
            'title' => $validated['title'] ?: $autoDetails['title'],
            'content' => $validated['content'] ?: $autoDetails['content'],
            'media_image' => $mediaImage,
            'author_name' => $validated['author_name'] ?: $autoDetails['author_name'],
            'author_handle' => $validated['author_handle'] ?: $autoDetails['author_handle'],
            'post_date' => $validated['post_date'] ?: $autoDetails['post_date'],
            'likes_count' => $validated['likes_count'] ?: $autoDetails['likes_count'],
            'comments_count' => $validated['comments_count'] ?: $autoDetails['comments_count'],
            'shares_count' => $validated['shares_count'] ?: $autoDetails['shares_count'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('create', 'social_posts', $post->id, "Added new {$post->getPlatformLabel()} post: " . ($post->title ?? $post->post_url));

        return redirect()->route('admin.social-posts.index', ['platform' => $post->platform])
            ->with('success', "{$post->getPlatformLabel()} post added successfully.");
    }

    public function edit(SocialPost $socialPost)
    {
        return view('admin.social_posts.edit', compact('socialPost'));
    }

    public function update(Request $request, SocialPost $socialPost)
    {
        $validated = $request->validate([
            'platform' => 'required|in:twitter,youtube,facebook,instagram',
            'post_url' => 'required|url',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'author_name' => 'nullable|string|max:150',
            'author_handle' => 'nullable|string|max:100',
            'post_date' => 'nullable|string|max:100',
            'likes_count' => 'nullable|string|max:50',
            'comments_count' => 'nullable|string|max:50',
            'shares_count' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'media_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $mediaImage = $socialPost->media_image;

        // Custom image upload
        if ($request->hasFile('media_image_file')) {
            $path = $request->file('media_image_file')->store('social_posts', 'public');
            $mediaImage = 'storage/' . $path;
        }

        $socialPost->update([
            'platform' => $validated['platform'],
            'post_url' => $validated['post_url'],
            'title' => $validated['title'] ?? null,
            'content' => $validated['content'] ?? null,
            'media_image' => $mediaImage,
            'author_name' => $validated['author_name'] ?? 'Ministry of Textiles',
            'author_handle' => $validated['author_handle'] ?? '@TexMinIndia',
            'post_date' => $validated['post_date'] ?? $socialPost->post_date,
            'likes_count' => $validated['likes_count'] ?? $socialPost->likes_count,
            'comments_count' => $validated['comments_count'] ?? $socialPost->comments_count,
            'shares_count' => $validated['shares_count'] ?? $socialPost->shares_count,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('update', 'social_posts', $socialPost->id, "Updated {$socialPost->getPlatformLabel()} post: " . ($socialPost->title ?? $socialPost->post_url));

        return redirect()->route('admin.social-posts.index', ['platform' => $socialPost->platform])
            ->with('success', "{$socialPost->getPlatformLabel()} post updated successfully.");
    }

    public function destroy(SocialPost $socialPost)
    {
        $platform = $socialPost->getPlatformLabel();
        ActivityLog::record('delete', 'social_posts', $socialPost->id, "Deleted {$platform} post: " . ($socialPost->title ?? $socialPost->post_url));
        $socialPost->delete();

        return redirect()->route('admin.social-posts.index')->with('success', "{$platform} post deleted successfully.");
    }
}
