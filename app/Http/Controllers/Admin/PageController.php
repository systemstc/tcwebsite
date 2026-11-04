<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\ActivityLog;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::query();

        // 1. Search Query (Title, Slug, Description)
        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function($q) use ($s) {
                $q->where('title_en', 'like', "%{$s}%")
                  ->orWhere('title_hi', 'like', "%{$s}%")
                  ->orWhere('slug', 'like', "%{$s}%");
            });
        }

        // 2. Filter by Menu Location
        if ($request->filled('menu') && $request->menu !== 'all') {
            if ($request->menu === 'none') {
                $query->where(function($q) {
                    $q->whereNull('menu_location')
                      ->orWhere('menu_location', '')
                      ->orWhere('menu_location', 'none');
                });
            } else {
                $query->where('menu_location', $request->menu);
            }
        }

        // 3. Filter by Status (Published / Draft)
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('is_active', $request->status === 'published' ? 1 : 0);
        }

        // 4. Filter by Template
        if ($request->filled('template') && $request->template !== 'all') {
            $query->where('template_type', $request->template);
        }

        // 5. Sorting
        $sort = $request->input('sort', 'updated');
        switch ($sort) {
            case 'title':
                $query->orderBy('title_en', 'asc');
                break;
            case 'order':
                $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
                break;
            case 'newest':
                $query->orderBy('id', 'desc');
                break;
            case 'updated':
            default:
                $query->orderBy('updated_at', 'desc');
                break;
        }

        // Counts for quick filter pills
        $totalCount = Page::count();
        $publishedCount = Page::where('is_active', true)->count();
        $draftCount = Page::where('is_active', false)->count();
        $ministryCount = Page::where('menu_location', 'ministry')->count();
        $offeringsCount = Page::where('menu_location', 'offerings')->count();
        $documentsCount = Page::where('menu_location', 'documents')->count();
        $connectCount = Page::where('menu_location', 'connect')->count();
        $mediaCount = Page::where('menu_location', 'media')->count();

        $perPage = (int) $request->input('per_page', 100);
        $pages = $query->paginate($perPage)->withQueryString();

        return view('admin.pages.index', compact(
            'pages',
            'totalCount',
            'publishedCount',
            'draftCount',
            'ministryCount',
            'offeringsCount',
            'documentsCount',
            'connectCount',
            'mediaCount'
        ));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_hi' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:100|unique:pages,slug',
            'content_en' => 'nullable|string',
            'content_hi' => 'nullable|string',
            'menu_location' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'template_type' => 'nullable|string|max:50',
            'meta_description' => 'nullable|string',
        ]);

        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title_en']);
        if (!$slug) {
            $slug = 'page-' . time();
        }

        $page = Page::create([
            'slug' => $slug,
            'title_en' => $validated['title_en'],
            'title_hi' => $validated['title_hi'] ?? $validated['title_en'],
            'content_en' => $validated['content_en'] ?? null,
            'content_hi' => $validated['content_hi'] ?? null,
            'menu_location' => $validated['menu_location'] ?? 'none',
            'sort_order' => $validated['sort_order'] ?? 0,
            'template_type' => $validated['template_type'] ?? 'standard',
            'meta_description' => $validated['meta_description'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('create', 'pages', $page->id, "Created CMS page: {$page->title_en}");

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_hi' => 'nullable|string|max:255',
            'slug' => 'required|string|max:100|unique:pages,slug,' . $page->id,
            'content_en' => 'nullable|string',
            'content_hi' => 'nullable|string',
            'menu_location' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'template_type' => 'nullable|string|max:50',
            'meta_description' => 'nullable|string',
        ]);

        $page->update([
            'slug' => Str::slug($validated['slug']),
            'title_en' => $validated['title_en'],
            'title_hi' => $validated['title_hi'] ?? $validated['title_en'],
            'content_en' => $validated['content_en'] ?? null,
            'content_hi' => $validated['content_hi'] ?? null,
            'menu_location' => $validated['menu_location'] ?? 'none',
            'sort_order' => $validated['sort_order'] ?? 0,
            'template_type' => $validated['template_type'] ?? 'standard',
            'meta_description' => $validated['meta_description'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('update', 'pages', $page->id, "Updated CMS page: {$page->title_en}");

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function visualEditor(Page $page)
    {
        $assetImages = [];
        $assetPath = public_path('assets/images');
        if (file_exists($assetPath)) {
            $files = scandir($assetPath);
            foreach ($files as $f) {
                if (preg_match('/\.(jpg|jpeg|png|svg|webp)$/i', $f)) {
                    $assetImages[] = [
                        'name' => $f,
                        'url' => asset('assets/images/' . $f),
                    ];
                }
            }
        }

        $uploadedImages = [];
        $uploadPath = public_path('uploads/pages');
        if (file_exists($uploadPath)) {
            $files = scandir($uploadPath);
            foreach ($files as $f) {
                if (preg_match('/\.(jpg|jpeg|png|svg|webp)$/i', $f)) {
                    $uploadedImages[] = [
                        'name' => $f,
                        'url' => asset('uploads/pages/' . $f),
                    ];
                }
            }
        }

        $allPages = Page::where('is_active', 1)->orderBy('title_en')->get(['id', 'title_en', 'slug']);

        return view('admin.pages.visual-editor', compact('page', 'assetImages', 'uploadedImages', 'allPages'));
    }

    public function saveVisualEditor(Request $request, Page $page)
    {
        $validated = $request->validate([
            'content_en' => 'nullable|string',
            'content_hi' => 'nullable|string',
        ]);

        $contentEn = $validated['content_en'] ?? $page->content_en;
        $contentHi = $validated['content_hi'] ?? $page->content_hi;

        if ($contentEn) {
            $contentEn = \App\Services\PortalDocumentService::normalizeDocumentRowsHtml($contentEn);
        }
        if ($contentHi) {
            $contentHi = \App\Services\PortalDocumentService::normalizeDocumentRowsHtml($contentHi);
        }

        $page->update([
            'content_en' => $contentEn,
            'content_hi' => $contentHi,
        ]);

        \App\Services\PortalDocumentService::clearCache();

        ActivityLog::record('update', 'pages', $page->id, "Visual Editor updated content for: {$page->title_en}");

        return response()->json([
            'success' => true,
            'message' => 'Page content saved successfully!',
        ]);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $file = $request->file('image');
        $fileName = 'page_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $targetDir = public_path('uploads/pages');
        $this->saveUploadedFile($file, $targetDir, $fileName);

        $url = asset('uploads/pages/' . $fileName);
        $relativeUrl = '/uploads/pages/' . $fileName;

        return response()->json([
            'success' => true,
            'url' => $url,
            'relative_url' => $relativeUrl,
            'fileName' => $fileName,
        ]);
    }

    public function uploadPdf(Request $request)
    {
        try {
            \App\Services\PortalDocumentService::clearCache();
        } catch (\Throwable $e) {
            // Ignore cache clearing failure so it never blocks file uploads
        }

        // 1. Locate file from common field names or any attached file
        $file = $request->file('document') ?? $request->file('pdf') ?? $request->file('file');
        if (!$file) {
            $allFiles = $request->allFiles();
            if (!empty($allFiles)) {
                $first = reset($allFiles);
                $file = is_array($first) ? reset($first) : $first;
            }
        }

        // 2. Check for missing file or server POST limit overflow
        if (!$file) {
            $contentLength = isset($_SERVER['CONTENT_LENGTH']) ? (int)$_SERVER['CONTENT_LENGTH'] : 0;
            $postMaxSize = ini_get('post_max_size');
            return response()->json([
                'success' => false,
                'message' => 'No file received. ' . ($contentLength > 0 ? "Upload may have exceeded post_max_size ({$postMaxSize})." : 'Please select a valid document.')
            ], 422);
        }

        // 3. Check upload errors from PHP
        if (!$file->isValid()) {
            $error = $file->getError();
            $msg = match ($error) {
                UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds server upload_max_filesize (' . ini_get('upload_max_filesize') . ').',
                UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form.',
                UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary upload folder on server.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
                default => 'Upload error: ' . $file->getErrorMessage(),
            };
            return response()->json(['success' => false, 'message' => $msg], 422);
        }

        // 4. Validate allowed document extensions
        $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'zip', 'rar', 'csv'];
        $ext = strtolower($file->getClientOriginalExtension() ?: pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION) ?: 'pdf');
        if (!in_array($ext, $allowedExtensions)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file format (.' . $ext . '). Supported formats: ' . implode(', ', $allowedExtensions) . '.'
            ], 422);
        }

        // 5. Validate file size (max 200MB)
        $sizeBytes = $file->getSize();
        if ($sizeBytes > 209715200) {
            return response()->json([
                'success' => false,
                'message' => 'File size (' . round($sizeBytes / 1048576, 2) . ' MB) exceeds the maximum allowed limit of 200 MB.'
            ], 422);
        }

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $sizeFormatted = $sizeBytes >= 1048576 
            ? round($sizeBytes / 1048576, 2) . ' MB' 
            : round($sizeBytes / 1024, 2) . ' KB';

        $fileName = 'doc_' . time() . '_' . uniqid() . '.' . $ext;
        $targetDir = public_path('uploads/documents');
        if (!file_exists($targetDir)) {
            @mkdir($targetDir, 0777, true);
        }
        
        $saved = $this->saveUploadedFile($file, $targetDir, $fileName);
        if (!$saved) {
            return response()->json(['success' => false, 'message' => 'Failed to save document to server directory.'], 500);
        }

        $relativeUrl = '/uploads/documents/' . $fileName;
        $url = asset('uploads/documents/' . $fileName);
        $fileDate = date('d.m.Y');
        $fileExt = strtoupper($ext);

        return response()->json([
            'success' => true,
            'url' => $url,
            'relative_url' => $relativeUrl,
            'fileName' => $file->getClientOriginalName(),
            'title' => ucwords(str_replace(['_', '-'], ' ', $originalName)),
            'fileSize' => $sizeFormatted,
            'fileExt' => $fileExt,
            'fileDate' => $fileDate,
        ]);
    }

    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4,webm,ogg,mov,m4v|max:102400',
        ]);

        $file = $request->file('video');
        $fileName = 'video_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $targetDir = public_path('uploads/videos');
        $this->saveUploadedFile($file, $targetDir, $fileName);

        $url = asset('uploads/videos/' . $fileName);
        $relativeUrl = '/uploads/videos/' . $fileName;

        return response()->json([
            'success' => true,
            'url' => $url,
            'relative_url' => $relativeUrl,
            'fileName' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * Safely store uploaded file on disk, bypassing Windows ACL is_writable check issues in Symfony HttpFoundation
     */
    protected function saveUploadedFile($file, string $targetDir, string $fileName): bool
    {
        if (!file_exists($targetDir)) {
            @mkdir($targetDir, 0777, true);
        }
        $targetPath = rtrim($targetDir, '/\\') . DIRECTORY_SEPARATOR . $fileName;

        try {
            $file->move($targetDir, $fileName);
            return true;
        } catch (\Throwable $e) {
            $sourcePath = $file->getPathname();
            if ($sourcePath && file_exists($sourcePath)) {
                if (is_uploaded_file($sourcePath) && @move_uploaded_file($sourcePath, $targetPath)) {
                    return true;
                }
                if (@copy($sourcePath, $targetPath)) {
                    @unlink($sourcePath);
                    return true;
                }
                if (@file_put_contents($targetPath, file_get_contents($sourcePath)) !== false) {
                    @unlink($sourcePath);
                    return true;
                }
            }
            return file_exists($targetPath);
        }
    }

    public function destroy(Page $page)
    {
        $title = $page->title_hi;
        $id = $page->id;
        $page->delete();

        ActivityLog::record('delete', 'pages', $id, "Deleted CMS page: {$title}");

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }
}
