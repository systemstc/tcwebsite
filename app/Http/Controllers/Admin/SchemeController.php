<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Scheme;
use App\Models\ActivityLog;

class SchemeController extends Controller
{
    public function index()
    {
        $schemes = Scheme::orderBy('sort_order')->get();
        return view('admin.schemes.index', compact('schemes'));
    }

    public function create()
    {
        return view('admin.schemes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_hi' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_hi' => 'nullable|string',
            'description_en' => 'nullable|string',
            'category' => 'required|string',
            'link_url' => 'nullable|string',
            'sort_order' => 'integer',
        ]);

        $scheme = Scheme::create([
            'title_hi' => $validated['title_hi'],
            'title_en' => $validated['title_en'] ?? null,
            'description_hi' => $validated['description_hi'] ?? null,
            'description_en' => $validated['description_en'] ?? null,
            'category' => $validated['category'],
            'link_url' => $validated['link_url'] ?? '#',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('create', 'schemes', $scheme->id, "Created scheme: {$scheme->title_hi}");

        return redirect()->route('admin.schemes.index')->with('success', 'Scheme created successfully.');
    }

    public function edit(Scheme $scheme)
    {
        return view('admin.schemes.edit', compact('scheme'));
    }

    public function update(Request $request, Scheme $scheme)
    {
        $validated = $request->validate([
            'title_hi' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_hi' => 'nullable|string',
            'description_en' => 'nullable|string',
            'category' => 'required|string',
            'link_url' => 'nullable|string',
            'sort_order' => 'integer',
        ]);

        $scheme->update([
            'title_hi' => $validated['title_hi'],
            'title_en' => $validated['title_en'] ?? null,
            'description_hi' => $validated['description_hi'] ?? null,
            'description_en' => $validated['description_en'] ?? null,
            'category' => $validated['category'],
            'link_url' => $validated['link_url'] ?? '#',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('update', 'schemes', $scheme->id, "Updated scheme: {$scheme->title_hi}");

        return redirect()->route('admin.schemes.index')->with('success', 'Scheme updated successfully.');
    }

    public function destroy(Scheme $scheme)
    {
        $title = $scheme->title_hi;
        $id = $scheme->id;
        $scheme->delete();

        ActivityLog::record('delete', 'schemes', $id, "Deleted scheme: {$title}");

        return redirect()->route('admin.schemes.index')->with('success', 'Scheme deleted successfully.');
    }
}
