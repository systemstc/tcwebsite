<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\ActivityLog;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_hi' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'subtitle_hi' => 'nullable|string',
            'subtitle_en' => 'nullable|string',
            'image_url' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'link_url' => 'nullable|string|max:255',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $imageUrl = $validated['image_url'] ?? 'assets/images/BANNER-1-1.png';
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('banners', 'public');
            $imageUrl = 'storage/' . $path;
        }

        $banner = Banner::create([
            'title_hi' => $validated['title_hi'] ?? null,
            'title_en' => $validated['title_en'] ?? null,
            'subtitle_hi' => $validated['subtitle_hi'] ?? null,
            'subtitle_en' => $validated['subtitle_en'] ?? null,
            'image_url' => $imageUrl,
            'link_url' => $validated['link_url'] ?? '#',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('create', 'banners', $banner->id, "Created banner: {$banner->title_hi}");

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title_hi' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'subtitle_hi' => 'nullable|string',
            'subtitle_en' => 'nullable|string',
            'image_url' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'link_url' => 'nullable|string|max:255',
            'sort_order' => 'integer',
        ]);

        $imageUrl = $validated['image_url'] ?? $banner->image_url;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('banners', 'public');
            $imageUrl = 'storage/' . $path;
        }

        $banner->update([
            'title_hi' => $validated['title_hi'] ?? null,
            'title_en' => $validated['title_en'] ?? null,
            'subtitle_hi' => $validated['subtitle_hi'] ?? null,
            'subtitle_en' => $validated['subtitle_en'] ?? null,
            'image_url' => $imageUrl,
            'link_url' => $validated['link_url'] ?? '#',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('update', 'banners', $banner->id, "Updated banner: {$banner->title_hi}");

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $title = $banner->title_hi;
        $id = $banner->id;
        $banner->delete();

        ActivityLog::record('delete', 'banners', $id, "Deleted banner: {$title}");

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }
}
