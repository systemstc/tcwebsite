<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::latest();

        // Search
        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('file_name', 'like', "%{$s}%")
                  ->orWhere('extension', 'like', "%{$s}%");
            });
        }

        // Filter by Type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('file_type', $request->type);
        }

        $media = $query->paginate(24)->withQueryString();

        // Statistics
        $totalFiles = Media::count();
        $totalImages = Media::where('file_type', 'image')->count();
        $totalDocs = Media::where('file_type', 'document')->count();
        $totalBytes = Media::sum('size_bytes');
        $totalSizeFormatted = $this->formatBytes($totalBytes);

        return view('admin.media.index', compact(
            'media',
            'totalFiles',
            'totalImages',
            'totalDocs',
            'totalSizeFormatted'
        ));
    }

    public function upload(Request $request)
    {
        // Support either 'files' array or single 'file'
        $filesToUpload = [];
        if ($request->hasFile('files')) {
            $filesToUpload = $request->file('files');
        } elseif ($request->hasFile('file')) {
            $filesToUpload = [$request->file('file')];
        } elseif ($request->hasFile('image')) {
            $filesToUpload = [$request->file('image')];
        } elseif ($request->hasFile('pdf')) {
            $filesToUpload = [$request->file('pdf')];
        }

        if (empty($filesToUpload)) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'No files provided for upload.'], 422);
            }
            return redirect()->back()->with('error', 'Please select at least one file to upload.');
        }

        $targetDir = public_path('uploads/media');
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0777, true, true);
        }

        $uploadedRecords = [];

        foreach ($filesToUpload as $file) {
            if (!$file->isValid()) continue;

            $origName = $file->getClientOriginalName();
            $baseName = pathinfo($origName, PATHINFO_FILENAME);
            $ext = strtolower($file->getClientOriginalExtension());
            $sizeBytes = $file->getSize();
            $sizeFormatted = $this->formatBytes($sizeBytes);
            $mime = $file->getMimeType();

            // Categorize file type
            $fileType = 'file';
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'bmp', 'ico'])) {
                $fileType = 'image';
            } elseif (in_array($ext, ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'rtf', 'csv'])) {
                $fileType = 'document';
            } elseif (in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm', 'wmv'])) {
                $fileType = 'video';
            } elseif (in_array($ext, ['mp3', 'wav', 'ogg', 'aac', 'flac'])) {
                $fileType = 'audio';
            } elseif (in_array($ext, ['zip', 'rar', 'tar', 'gz', '7z'])) {
                $fileType = 'archive';
            }

            // Safe unique file name
            $safeSlug = Str::slug($baseName);
            $fileName = ($safeSlug ?: 'file') . '_' . time() . '_' . Str::random(5) . '.' . $ext;

            $file->move($targetDir, $fileName);

            $relativeUrl = '/uploads/media/' . $fileName;
            $fullUrl = asset('uploads/media/' . $fileName);

            $media = Media::create([
                'name' => ucwords(str_replace(['_', '-'], ' ', $baseName)),
                'file_name' => $fileName,
                'disk_path' => 'uploads/media/' . $fileName,
                'url' => $fullUrl,
                'file_type' => $fileType,
                'mime_type' => $mime,
                'extension' => $ext,
                'size_bytes' => $sizeBytes,
                'size_formatted' => $sizeFormatted,
                'user_id' => auth()->id(),
            ]);

            ActivityLog::record('create', 'media', $media->id, "Uploaded media file: {$origName}");
            $uploadedRecords[] = $media;
        }

        if ($request->expectsJson() || $request->ajax()) {
            $last = end($uploadedRecords);
            return response()->json([
                'success' => true,
                'message' => count($uploadedRecords) . ' file(s) uploaded successfully.',
                'url' => $last ? $last->url : null,
                'relative_url' => $last ? '/uploads/media/' . $last->file_name : null,
                'file_name' => $last ? $last->file_name : null,
                'name' => $last ? $last->name : null,
                'file_type' => $last ? $last->file_type : null,
                'size' => $last ? $last->size_formatted : null,
                'items' => $uploadedRecords,
            ]);
        }

        return redirect()->route('admin.media.index')->with('success', count($uploadedRecords) . ' file(s) uploaded successfully!');
    }

    public function destroy(Media $media)
    {
        $id = $media->id;
        $name = $media->name;
        $filePath = public_path($media->disk_path);

        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $media->delete();
        ActivityLog::record('delete', 'media', $id, "Deleted media file: {$name}");

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'File deleted successfully.']);
        }

        return redirect()->route('admin.media.index')->with('success', 'File deleted successfully.');
    }

    public function listApi(Request $request)
    {
        $query = Media::latest();

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('file_type', $request->type);
        }

        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where('name', 'like', "%{$s}%")
                  ->orWhere('file_name', 'like', "%{$s}%");
        }

        $items = $query->take(60)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'file_name' => $item->file_name,
                'url' => $item->url,
                'relative_url' => '/' . $item->disk_path,
                'file_type' => $item->file_type,
                'extension' => $item->extension,
                'size' => $item->size_formatted,
                'icon' => $item->icon,
                'created_at' => $item->created_at->format('M d, Y'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $items,
        ]);
    }

    public function syncExisting()
    {
        $directories = [
            public_path('uploads/media') => 'uploads/media',
            public_path('uploads/documents') => 'uploads/documents',
            public_path('uploads/pages') => 'uploads/pages',
            public_path('assets/documents') => 'assets/documents',
        ];

        $count = 0;
        foreach ($directories as $absPath => $relPath) {
            if (!File::exists($absPath)) continue;

            $files = File::files($absPath);
            foreach ($files as $file) {
                $fileName = $file->getFilename();
                $diskPath = $relPath . '/' . $fileName;

                // Check if already indexed
                if (Media::where('disk_path', $diskPath)->exists()) continue;

                $ext = strtolower($file->getExtension());
                $sizeBytes = $file->getSize();
                $baseName = pathinfo($fileName, PATHINFO_FILENAME);

                $fileType = 'file';
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) {
                    $fileType = 'image';
                } elseif (in_array($ext, ['pdf', 'doc', 'docx', 'xls', 'xlsx'])) {
                    $fileType = 'document';
                }

                Media::create([
                    'name' => ucwords(str_replace(['_', '-'], ' ', $baseName)),
                    'file_name' => $fileName,
                    'disk_path' => $diskPath,
                    'url' => asset($diskPath),
                    'file_type' => $fileType,
                    'extension' => $ext,
                    'size_bytes' => $sizeBytes,
                    'size_formatted' => $this->formatBytes($sizeBytes),
                    'user_id' => auth()->id() ?? 1,
                ]);
                $count++;
            }
        }

        return redirect()->route('admin.media.index')->with('success', "Synced {$count} existing file(s) into Media Library!");
    }

    private function formatBytes($bytes, $precision = 2)
    {
        if ($bytes <= 0) return '0 B';
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
