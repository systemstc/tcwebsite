<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\ActivityLog;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('sort_order')->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_hi' => 'required|string',
            'title_en' => 'nullable|string',
            'link_url' => 'nullable|string',
            'sort_order' => 'integer',
        ]);

        $announcement = Announcement::create([
            'title_hi' => $validated['title_hi'],
            'title_en' => $validated['title_en'] ?? null,
            'link_url' => $validated['link_url'] ?? '#',
            'is_new' => $request->has('is_new'),
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('create', 'announcements', $announcement->id, "Created announcement: {$announcement->title_hi}");

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement added successfully.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title_hi' => 'required|string',
            'title_en' => 'nullable|string',
            'link_url' => 'nullable|string',
            'sort_order' => 'integer',
        ]);

        $announcement->update([
            'title_hi' => $validated['title_hi'],
            'title_en' => $validated['title_en'] ?? null,
            'link_url' => $validated['link_url'] ?? '#',
            'is_new' => $request->has('is_new'),
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('update', 'announcements', $announcement->id, "Updated announcement: {$announcement->title_hi}");

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $title = $announcement->title_hi;
        $id = $announcement->id;
        $announcement->delete();

        ActivityLog::record('delete', 'announcements', $id, "Deleted announcement: {$title}");

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted successfully.');
    }
}
