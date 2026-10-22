<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\ActivityLog;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::orderBy('published_date', 'desc')->get();
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_hi' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'category' => 'required|string',
            'description_hi' => 'nullable|string',
            'description_en' => 'nullable|string',
            'file_url' => 'nullable|string',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:20480',
            'file_size' => 'nullable|string',
            'published_date' => 'nullable|date',
            'sort_order' => 'integer',
        ]);

        $fileUrl = $validated['file_url'] ?? 'assets/images/sample_doc.pdf';
        $fileSize = $validated['file_size'] ?? '1.5 MB';
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileSize = round($file->getSize() / 1048576, 2) . ' MB';
            $path = $file->store('documents', 'public');
            $fileUrl = 'storage/' . $path;
        }

        $doc = Document::create([
            'title_hi' => $validated['title_hi'],
            'title_en' => $validated['title_en'] ?? null,
            'category' => $validated['category'],
            'description_hi' => $validated['description_hi'] ?? null,
            'description_en' => $validated['description_en'] ?? null,
            'file_url' => $fileUrl,
            'file_size' => $fileSize,
            'published_date' => $validated['published_date'] ?? now(),
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('create', 'documents', $doc->id, "Created document: {$doc->title_hi}");

        return redirect()->route('admin.documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title_hi' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'category' => 'required|string',
            'description_hi' => 'nullable|string',
            'description_en' => 'nullable|string',
            'file_url' => 'nullable|string',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:20480',
            'file_size' => 'nullable|string',
            'published_date' => 'nullable|date',
            'sort_order' => 'integer',
        ]);

        $fileUrl = $validated['file_url'] ?? $document->file_url;
        $fileSize = $validated['file_size'] ?? $document->file_size;
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileSize = round($file->getSize() / 1048576, 2) . ' MB';
            $path = $file->store('documents', 'public');
            $fileUrl = 'storage/' . $path;
        }

        $document->update([
            'title_hi' => $validated['title_hi'],
            'title_en' => $validated['title_en'] ?? null,
            'category' => $validated['category'],
            'description_hi' => $validated['description_hi'] ?? null,
            'description_en' => $validated['description_en'] ?? null,
            'file_url' => $fileUrl,
            'file_size' => $fileSize,
            'published_date' => $validated['published_date'] ?? $document->published_date,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('update', 'documents', $document->id, "Updated document: {$document->title_hi}");

        return redirect()->route('admin.documents.index')->with('success', 'Document updated successfully.');
    }

    public function destroy(Document $document)
    {
        $title = $document->title_hi;
        $id = $document->id;
        $document->delete();

        ActivityLog::record('delete', 'documents', $id, "Deleted document: {$title}");

        return redirect()->route('admin.documents.index')->with('success', 'Document deleted successfully.');
    }
}
