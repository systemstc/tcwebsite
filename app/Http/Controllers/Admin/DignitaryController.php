<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dignitary;
use App\Models\ActivityLog;

class DignitaryController extends Controller
{
    public function index()
    {
        $dignitaries = Dignitary::orderBy('sort_order')->get();
        return view('admin.dignitaries.index', compact('dignitaries'));
    }

    public function create()
    {
        return view('admin.dignitaries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_hi' => 'required|string|max:150',
            'name_en' => 'required|string|max:150',
            'designation_hi' => 'required|string|max:200',
            'designation_en' => 'required|string|max:200',
            'type' => 'required|string',
            'photo_url' => 'nullable|string',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'quote_hi' => 'nullable|string',
            'quote_en' => 'nullable|string',
            'quote_date' => 'nullable|string',
            'profile_link' => 'nullable|string',
            'sort_order' => 'integer',
        ]);

        $photoUrl = $validated['photo_url'] ?? 'assets/images/giriraj_singh.png';
        if ($request->hasFile('photo_file')) {
            $path = $request->file('photo_file')->store('dignitaries', 'public');
            $photoUrl = 'storage/' . $path;
        }

        $dignitary = Dignitary::create([
            'name_hi' => $validated['name_hi'],
            'name_en' => $validated['name_en'],
            'designation_hi' => $validated['designation_hi'],
            'designation_en' => $validated['designation_en'],
            'type' => $validated['type'],
            'photo_url' => $photoUrl,
            'quote_hi' => $validated['quote_hi'] ?? null,
            'quote_en' => $validated['quote_en'] ?? null,
            'quote_date' => $validated['quote_date'] ?? null,
            'profile_link' => $validated['profile_link'] ?? '#',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('create', 'dignitaries', $dignitary->id, "Created dignitary: {$dignitary->name_hi}");

        return redirect()->route('admin.dignitaries.index')->with('success', 'Dignitary created successfully.');
    }

    public function edit(Dignitary $dignitary)
    {
        return view('admin.dignitaries.edit', compact('dignitary'));
    }

    public function update(Request $request, Dignitary $dignitary)
    {
        $validated = $request->validate([
            'name_hi' => 'required|string|max:150',
            'name_en' => 'required|string|max:150',
            'designation_hi' => 'required|string|max:200',
            'designation_en' => 'required|string|max:200',
            'type' => 'required|string',
            'photo_url' => 'nullable|string',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'quote_hi' => 'nullable|string',
            'quote_en' => 'nullable|string',
            'quote_date' => 'nullable|string',
            'profile_link' => 'nullable|string',
            'sort_order' => 'integer',
        ]);

        $photoUrl = $validated['photo_url'] ?? $dignitary->photo_url;
        if ($request->hasFile('photo_file')) {
            $path = $request->file('photo_file')->store('dignitaries', 'public');
            $photoUrl = 'storage/' . $path;
        }

        $dignitary->update([
            'name_hi' => $validated['name_hi'],
            'name_en' => $validated['name_en'],
            'designation_hi' => $validated['designation_hi'],
            'designation_en' => $validated['designation_en'],
            'type' => $validated['type'],
            'photo_url' => $photoUrl,
            'quote_hi' => $validated['quote_hi'] ?? null,
            'quote_en' => $validated['quote_en'] ?? null,
            'quote_date' => $validated['quote_date'] ?? null,
            'profile_link' => $validated['profile_link'] ?? '#',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('update', 'dignitaries', $dignitary->id, "Updated dignitary: {$dignitary->name_hi}");

        return redirect()->route('admin.dignitaries.index')->with('success', 'Dignitary updated successfully.');
    }

    public function destroy(Dignitary $dignitary)
    {
        $name = $dignitary->name_hi;
        $id = $dignitary->id;
        $dignitary->delete();

        ActivityLog::record('delete', 'dignitaries', $id, "Deleted dignitary: {$name}");

        return redirect()->route('admin.dignitaries.index')->with('success', 'Dignitary deleted successfully.');
    }
}
