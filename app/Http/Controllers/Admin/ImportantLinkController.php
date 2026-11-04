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
        $links = ImportantLink::orderBy('sort_order')->orderBy('id', 'asc')->get();
        return view('admin.important-links.index', compact('links'));
    }

    public function create()
    {
        return view('admin.important-links.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required_without:title_hi|nullable|string|max:200',
            'title_hi' => 'nullable|string|max:200',
            'url' => 'required|string|max:500',
            'target' => 'nullable|string|max:20',
            'category' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        $titleEn = trim($request->input('title_en') ?? '');
        $titleHi = trim($request->input('title_hi') ?? '');
        if (empty($titleHi) && !empty($titleEn)) $titleHi = $titleEn;
        if (empty($titleEn) && !empty($titleHi)) $titleEn = $titleHi;

        $link = ImportantLink::create([
            'title_hi' => $titleHi,
            'title_en' => $titleEn,
            'url' => $validated['url'],
            'target' => $request->input('target') ?: '_blank',
            'category' => $request->input('category') ?: 'Government Portals',
            'sort_order' => (int)($request->input('sort_order') ?? 0),
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('create', 'important_links', $link->id, "Created portal/link: {$link->title_en}");

        return redirect()->route('admin.important-links.index')->with('success', 'Portal / Related link created successfully.');
    }

    public function edit(ImportantLink $importantLink)
    {
        return view('admin.important-links.edit', compact('importantLink'));
    }

    public function update(Request $request, ImportantLink $importantLink)
    {
        $validated = $request->validate([
            'title_en' => 'required_without:title_hi|nullable|string|max:200',
            'title_hi' => 'nullable|string|max:200',
            'url' => 'required|string|max:500',
            'target' => 'nullable|string|max:20',
            'category' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        $titleEn = trim($request->input('title_en') ?? '');
        $titleHi = trim($request->input('title_hi') ?? '');
        if (empty($titleHi) && !empty($titleEn)) $titleHi = $titleEn;
        if (empty($titleEn) && !empty($titleHi)) $titleEn = $titleHi;

        $importantLink->update([
            'title_hi' => $titleHi,
            'title_en' => $titleEn,
            'url' => $validated['url'],
            'target' => $request->input('target') ?: ($importantLink->target ?: '_blank'),
            'category' => $request->input('category') ?: ($importantLink->category ?: 'Government Portals'),
            'sort_order' => (int)($request->input('sort_order') ?? 0),
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('update', 'important_links', $importantLink->id, "Updated portal/link: {$importantLink->title_en}");

        return redirect()->route('admin.important-links.index')->with('success', 'Portal / Related link updated successfully.');
    }

    public function destroy(ImportantLink $importantLink)
    {
        $title = $importantLink->title_en ?: $importantLink->title_hi;
        $id = $importantLink->id;
        $importantLink->delete();

        ActivityLog::record('delete', 'important_links', $id, "Deleted portal/link: {$title}");

        return redirect()->route('admin.important-links.index')->with('success', 'Portal / Related link deleted successfully.');
    }
}
