<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_emblem_file' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'site_logo_file' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:5120',
        ]);

        // 1. Handle State Emblem Upload & Removal
        if ($request->hasFile('site_emblem_file')) {
            $path = $request->file('site_emblem_file')->store('settings', 'public');
            Setting::set('site_emblem', 'storage/' . $path, 'branding', 'image');
        } elseif ($request->filled('remove_site_emblem')) {
            Setting::set('site_emblem', null, 'branding', 'image');
        }

        // 2. Handle Official Logo Upload & Removal
        if ($request->hasFile('site_logo_file')) {
            $path = $request->file('site_logo_file')->store('settings', 'public');
            Setting::set('site_logo', 'storage/' . $path, 'branding', 'image');
        } elseif ($request->filled('remove_site_logo')) {
            Setting::set('site_logo', null, 'branding', 'image');
        }

        // 3. Process remaining non-file text settings
        $data = $request->except(['_token', 'site_emblem_file', 'site_logo_file', 'remove_site_emblem', 'remove_site_logo']);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        ActivityLog::record('update_settings', 'settings', null, 'System settings updated by ' . (auth()->user() ? auth()->user()->name : 'Admin'));

        return redirect()->back()->with('success', 'Settings and branding images saved successfully.');
    }
}
