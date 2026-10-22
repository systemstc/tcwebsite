<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender;
use App\Models\ActivityLog;

class TenderController extends Controller
{
    public function index()
    {
        $tenders = Tender::orderBy('created_at', 'desc')->get();
        return view('admin.tenders.index', compact('tenders'));
    }

    public function create()
    {
        return view('admin.tenders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference_no' => 'nullable|string|max:100',
            'title_hi' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'type' => 'required|string',
            'published_date' => 'nullable|date',
            'closing_date' => 'nullable|date',
            'document_url' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'status' => 'required|string',
            'sort_order' => 'integer',
        ]);

        $docUrl = $validated['document_url'] ?? 'assets/images/sample_doc.pdf';
        if ($request->hasFile('document_file')) {
            $path = $request->file('document_file')->store('tenders', 'public');
            $docUrl = 'storage/' . $path;
        }

        $tender = Tender::create([
            'reference_no' => $validated['reference_no'] ?? null,
            'title_hi' => $validated['title_hi'],
            'title_en' => $validated['title_en'] ?? null,
            'type' => $validated['type'],
            'published_date' => $validated['published_date'] ?? now(),
            'closing_date' => $validated['closing_date'] ?? null,
            'document_url' => $docUrl,
            'status' => $validated['status'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('create', 'tenders', $tender->id, "Created tender/vacancy: {$tender->title_hi}");

        return redirect()->route('admin.tenders.index')->with('success', 'Tender/Vacancy created successfully.');
    }

    public function edit(Tender $tender)
    {
        return view('admin.tenders.edit', compact('tender'));
    }

    public function update(Request $request, Tender $tender)
    {
        $validated = $request->validate([
            'reference_no' => 'nullable|string|max:100',
            'title_hi' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'type' => 'required|string',
            'published_date' => 'nullable|date',
            'closing_date' => 'nullable|date',
            'document_url' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'status' => 'required|string',
            'sort_order' => 'integer',
        ]);

        $docUrl = $validated['document_url'] ?? $tender->document_url;
        if ($request->hasFile('document_file')) {
            $path = $request->file('document_file')->store('tenders', 'public');
            $docUrl = 'storage/' . $path;
        }

        $tender->update([
            'reference_no' => $validated['reference_no'] ?? null,
            'title_hi' => $validated['title_hi'],
            'title_en' => $validated['title_en'] ?? null,
            'type' => $validated['type'],
            'published_date' => $validated['published_date'] ?? $tender->published_date,
            'closing_date' => $validated['closing_date'] ?? null,
            'document_url' => $docUrl,
            'status' => $validated['status'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('update', 'tenders', $tender->id, "Updated tender/vacancy: {$tender->title_hi}");

        return redirect()->route('admin.tenders.index')->with('success', 'Tender/Vacancy updated successfully.');
    }

    public function destroy(Tender $tender)
    {
        $title = $tender->title_hi;
        $id = $tender->id;
        $tender->delete();

        ActivityLog::record('delete', 'tenders', $id, "Deleted tender/vacancy: {$title}");

        return redirect()->route('admin.tenders.index')->with('success', 'Tender/Vacancy deleted successfully.');
    }
}
