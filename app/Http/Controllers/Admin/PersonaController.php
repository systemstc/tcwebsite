<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\ActivityLog;

class PersonaController extends Controller
{
    public function index()
    {
        $personas = Persona::orderBy('sort_order')->get();
        return view('admin.personas.index', compact('personas'));
    }

    public function create()
    {
        return view('admin.personas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_hi' => 'required|string|max:150',
            'title_en' => 'nullable|string|max:150',
            'subtitle_hi' => 'nullable|string',
            'subtitle_en' => 'nullable|string',
            'avatar_url' => 'nullable|string',
            'avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'link_url' => 'nullable|string',
            'sort_order' => 'integer',
        ]);

        $avatarUrl = $validated['avatar_url'] ?? 'assets/images/persona_investor.png';
        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('personas', 'public');
            $avatarUrl = 'storage/' . $path;
        }

        $persona = Persona::create([
            'title_hi' => $validated['title_hi'],
            'title_en' => $validated['title_en'] ?? null,
            'subtitle_hi' => $validated['subtitle_hi'] ?? null,
            'subtitle_en' => $validated['subtitle_en'] ?? null,
            'avatar_url' => $avatarUrl,
            'link_url' => $validated['link_url'] ?? '#',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('create', 'personas', $persona->id, "Created persona: {$persona->title_hi}");

        return redirect()->route('admin.personas.index')->with('success', 'User persona created successfully.');
    }

    public function edit(Persona $persona)
    {
        return view('admin.personas.edit', compact('persona'));
    }

    public function update(Request $request, Persona $persona)
    {
        $validated = $request->validate([
            'title_hi' => 'required|string|max:150',
            'title_en' => 'nullable|string|max:150',
            'subtitle_hi' => 'nullable|string',
            'subtitle_en' => 'nullable|string',
            'avatar_url' => 'nullable|string',
            'avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'link_url' => 'nullable|string',
            'sort_order' => 'integer',
        ]);

        $avatarUrl = $validated['avatar_url'] ?? $persona->avatar_url;
        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('personas', 'public');
            $avatarUrl = 'storage/' . $path;
        }

        $persona->update([
            'title_hi' => $validated['title_hi'],
            'title_en' => $validated['title_en'] ?? null,
            'subtitle_hi' => $validated['subtitle_hi'] ?? null,
            'subtitle_en' => $validated['subtitle_en'] ?? null,
            'avatar_url' => $avatarUrl,
            'link_url' => $validated['link_url'] ?? '#',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('update', 'personas', $persona->id, "Updated persona: {$persona->title_hi}");

        return redirect()->route('admin.personas.index')->with('success', 'User persona updated successfully.');
    }

    public function destroy(Persona $persona)
    {
        $title = $persona->title_hi;
        $id = $persona->id;
        $persona->delete();

        ActivityLog::record('delete', 'personas', $id, "Deleted persona: {$title}");

        return redirect()->route('admin.personas.index')->with('success', 'User persona deleted successfully.');
    }
}
