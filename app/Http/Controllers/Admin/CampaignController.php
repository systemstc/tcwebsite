<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\ActivityLog;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::orderBy('sort_order')->get();
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.campaigns.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_hi' => 'required|string|max:200',
            'title_en' => 'nullable|string|max:200',
            'image_url' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'link_url' => 'nullable|string',
            'type' => 'required|string',
            'sort_order' => 'integer',
        ]);

        $imageUrl = $validated['image_url'] ?? 'assets/images/make_in_india.png';
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('campaigns', 'public');
            $imageUrl = 'storage/' . $path;
        }

        $campaign = Campaign::create([
            'title_hi' => $validated['title_hi'],
            'title_en' => $validated['title_en'] ?? null,
            'image_url' => $imageUrl,
            'link_url' => $validated['link_url'] ?? '#',
            'type' => $validated['type'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('create', 'campaigns', $campaign->id, "Created campaign: {$campaign->title_hi}");

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign banner created successfully.');
    }

    public function edit(Campaign $campaign)
    {
        return view('admin.campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'title_hi' => 'required|string|max:200',
            'title_en' => 'nullable|string|max:200',
            'image_url' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'link_url' => 'nullable|string',
            'type' => 'required|string',
            'sort_order' => 'integer',
        ]);

        $imageUrl = $validated['image_url'] ?? $campaign->image_url;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('campaigns', 'public');
            $imageUrl = 'storage/' . $path;
        }

        $campaign->update([
            'title_hi' => $validated['title_hi'],
            'title_en' => $validated['title_en'] ?? null,
            'image_url' => $imageUrl,
            'link_url' => $validated['link_url'] ?? '#',
            'type' => $validated['type'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('update', 'campaigns', $campaign->id, "Updated campaign: {$campaign->title_hi}");

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign banner updated successfully.');
    }

    public function destroy(Campaign $campaign)
    {
        $title = $campaign->title_hi;
        $id = $campaign->id;
        $campaign->delete();

        ActivityLog::record('delete', 'campaigns', $id, "Deleted campaign: {$title}");

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign banner deleted successfully.');
    }
}
