<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImportantLink;
use App\Models\ActivityLog;

class ImportantLinkController extends Controller
{
    public function index()
    {
        $links = ImportantLink::orderBy('sort_order')->get();
        return view('admin.important-links.index', compact('links'));
    }

    public function create()
    {
        return view('admin.important-links.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_hi' => 'required|string|max:200',
            'title_en' => 'nullable|string|max:200',
            'url' => 'required|string',
            'target' => 'required|string',
            'category' => 'required|string',
            'sort_order' => 'integer',
        ]);

        $link = ImportantLink::create([
            'title_hi' => $validated['title_hi'],
            'title_en' => $validated['title_en'] ?? null,
            'url' => $validated['url'],
            'target' => $validated['target'],
            'category' => $validated['category'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('create', 'important_links', $link->id, "Created link: {$link->title_hi}");

        return redirect()->route('admin.important-links.index')->with('success', 'Important link created successfully.');
    }

    public function edit(ImportantLink $importantLink)
    {
        return view('admin.important-links.edit', compact('importantLink'));
    }

    public function update(Request $request, ImportantLink $importantLink)
    {
        $validated = $request->validate([
            'title_hi' => 'required|string|max:200',
            'title_en' => 'nullable|string|max:200',
            'url' => 'required|string',
            'target' => 'required|string',
            'category' => 'required|string',
            'sort_order' => 'integer',
        ]);

        $importantLink->update([
            'title_hi' => $validated['title_hi'],
            'title_en' => $validated['title_en'] ?? null,
            'url' => $validated['url'],
            'target' => $validated['target'],
            'category' => $validated['category'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('update', 'important_links', $importantLink->id, "Updated link: {$importantLink->title_hi}");

        return redirect()->route('admin.important-links.index')->with('success', 'Important link updated successfully.');
    }

    public function destroy(ImportantLink $importantLink)
    {
        $title = $importantLink->title_hi;
        $id = $importantLink->id;
        $importantLink->delete();

        ActivityLog::record('delete', 'important_links', $id, "Deleted link: {$title}");

        return redirect()->route('admin.important-links.index')->with('success', 'Important link deleted successfully.');
    }
}
