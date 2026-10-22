<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhatsNew;
use App\Models\ActivityLog;

class WhatsNewController extends Controller
{
    public function index()
    {
        $items = WhatsNew::orderBy('date', 'desc')->orderBy('id', 'desc')->get();
        return view('admin.whats-new.index', compact('items'));
    }

    public function create()
    {
        return view('admin.whats-new.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required_without:title_hi|nullable|string|max:500',
            'title_hi' => 'required_without:title_en|nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'content_en' => 'nullable|string',
            'content_hi' => 'nullable|string',
            'date' => 'nullable|date',
            'published_date' => 'nullable|date',
            'link_url' => 'nullable|string|max:500',
            'document_url' => 'nullable|string|max:500',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip,jpg,png|max:30720',
            'file_size' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        $docUrl = $validated['document_url'] ?? null;
        $fileSize = $validated['file_size'] ?? null;

        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $bytes = $file->getSize();
            if ($bytes >= 1048576) {
                $fileSize = round($bytes / 1048576, 2) . ' MB';
            } else {
                $fileSize = round($bytes / 1024, 2) . ' KB';
            }
            $path = $file->store('whats_new', 'public');
            $docUrl = 'storage/' . $path;
        }

        $dateVal = $validated['date'] ?? ($validated['published_date'] ?? now());

        $item = WhatsNew::create([
            'title_en' => $validated['title_en'] ?? $validated['title_hi'],
            'title_hi' => $validated['title_hi'] ?? $validated['title_en'],
            'category' => $validated['category'] ?? 'Update',
            'content_en' => $validated['content_en'] ?? null,
            'content_hi' => $validated['content_hi'] ?? null,
            'date' => $dateVal,
            'link_url' => $validated['link_url'] ?? '#',
            'document_url' => $docUrl,
            'file_size' => $fileSize,
            'is_new' => $request->has('is_new'),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('create', 'whats_new', $item->id, "Created What's New post: {$item->title_en}");

        return redirect()->route('admin.whats-new.index')->with('success', "What's New item '{$item->title_en}' created successfully.");
    }

    public function edit(WhatsNew $whatsNew)
    {
        return view('admin.whats-new.edit', compact('whatsNew'));
    }

    public function update(Request $request, WhatsNew $whatsNew)
    {
        $validated = $request->validate([
            'title_en' => 'required_without:title_hi|nullable|string|max:500',
            'title_hi' => 'required_without:title_en|nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'content_en' => 'nullable|string',
            'content_hi' => 'nullable|string',
            'date' => 'nullable|date',
            'published_date' => 'nullable|date',
            'link_url' => 'nullable|string|max:500',
            'document_url' => 'nullable|string|max:500',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip,jpg,png|max:30720',
            'file_size' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        $docUrl = $whatsNew->document_url;
        $fileSize = $validated['file_size'] ?? $whatsNew->file_size;

        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $bytes = $file->getSize();
            if ($bytes >= 1048576) {
                $fileSize = round($bytes / 1048576, 2) . ' MB';
            } else {
                $fileSize = round($bytes / 1024, 2) . ' KB';
            }
            $path = $file->store('whats_new', 'public');
            $docUrl = 'storage/' . $path;
        } elseif (!empty($validated['document_url'])) {
            $docUrl = $validated['document_url'];
        }

        $dateVal = $validated['date'] ?? ($validated['published_date'] ?? $whatsNew->date);

        $whatsNew->update([
            'title_en' => $validated['title_en'] ?? $whatsNew->title_en,
            'title_hi' => $validated['title_hi'] ?? $whatsNew->title_hi,
            'category' => $validated['category'] ?? ($whatsNew->category ?: 'Update'),
            'content_en' => $validated['content_en'] ?? $whatsNew->content_en,
            'content_hi' => $validated['content_hi'] ?? $whatsNew->content_hi,
            'date' => $dateVal,
            'link_url' => $validated['link_url'] ?? $whatsNew->link_url,
            'document_url' => $docUrl,
            'file_size' => $fileSize,
            'is_new' => $request->has('is_new'),
            'sort_order' => (int) ($validated['sort_order'] ?? $whatsNew->sort_order),
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('update', 'whats_new', $whatsNew->id, "Updated What's New post: {$whatsNew->title_en}");

        return redirect()->route('admin.whats-new.index')->with('success', "What's New item updated successfully.");
    }

    public function destroy(WhatsNew $whatsNew)
    {
        $title = $whatsNew->title_en ?: $whatsNew->title_hi;
        $id = $whatsNew->id;
        $whatsNew->delete();

        ActivityLog::record('delete', 'whats_new', $id, "Deleted What's New post: {$title}");

        return redirect()->route('admin.whats-new.index')->with('success', "What's New item deleted successfully.");
    }
}
