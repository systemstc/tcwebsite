@extends('layouts.admin')

@section('title', 'Media Manager & File Library')

@section('content')
<div class="container-fluid px-0">

    <!-- 1. HEADER & SUMMARY METRICS -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--cms-primary-dark);">
                <span class="material-symbols-outlined align-middle me-1" style="font-size: 28px;">perm_media</span>
                Media Manager & Library
            </h4>
            <p class="text-muted small mb-0">Upload any media, images, or PDF documents and copy links directly into your code, pages, or visual editor.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('admin.media.sync') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1 shadow-sm" title="Scan disk for any existing files uploaded previously">
                    <span class="material-symbols-outlined" style="font-size: 18px;">sync</span>
                    <span>Sync Existing Files</span>
                </button>
            </form>
            <button type="button" class="btn btn-cms-primary btn-sm d-flex align-items-center gap-1 shadow-sm" onclick="document.getElementById('mediaFileInput').click()">
                <span class="material-symbols-outlined" style="font-size: 18px;">cloud_upload</span>
                <span>Upload New Media</span>
            </button>
        </div>
    </div>

    <!-- 2. STATS OVERVIEW CARDS -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-3" style="background: #f8fafc; border-left: 4px solid #721835 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 11px;">Total Files</small>
                        <h4 class="fw-bold mb-0 text-dark">{{ $totalFiles }}</h4>
                    </div>
                    <span class="material-symbols-outlined text-muted" style="font-size: 32px; opacity: 0.5;">folder_open</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-3" style="background: #f8fafc; border-left: 4px solid #0284c7 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 11px;">Photos & Images</small>
                        <h4 class="fw-bold mb-0 text-primary">{{ $totalImages }}</h4>
                    </div>
                    <span class="material-symbols-outlined text-primary" style="font-size: 32px; opacity: 0.5;">image</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-3" style="background: #f8fafc; border-left: 4px solid #dc2626 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 11px;">PDFs & Docs</small>
                        <h4 class="fw-bold mb-0 text-danger">{{ $totalDocs }}</h4>
                    </div>
                    <span class="material-symbols-outlined text-danger" style="font-size: 32px; opacity: 0.5;">picture_as_pdf</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 rounded-3" style="background: #f8fafc; border-left: 4px solid #16a34a !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 11px;">Storage Used</small>
                        <h4 class="fw-bold mb-0 text-success">{{ $totalSizeFormatted }}</h4>
                    </div>
                    <span class="material-symbols-outlined text-success" style="font-size: 32px; opacity: 0.5;">hard_drive</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. DRAG & DROP UPLOAD ZONE -->
    <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden">
        <div class="card-body p-4 text-center" 
             id="dropZoneArea" 
             style="border: 2px dashed #cbd5e1; border-radius: 8px; background: #fafbfc; cursor: pointer; transition: all 0.2s;"
             onclick="document.getElementById('mediaFileInput').click()"
             ondragover="handleUploadDragOver(event)"
             ondragleave="handleUploadDragLeave(event)"
             ondrop="handleUploadDrop(event)">
            
            <input type="file" id="mediaFileInput" class="d-none" multiple onchange="uploadSelectedFiles(this.files)">
            
            <div id="uploadIdlePrompt">
                <div class="mb-2">
                    <span class="material-symbols-outlined text-primary" style="font-size: 48px; color: #721835 !important;">cloud_upload</span>
                </div>
                <h6 class="fw-bold mb-1 text-dark">Drag & drop your files here, or click to browse</h6>
                <p class="text-muted small mb-0">Supports Images (PNG, JPG, SVG, WEBP), Documents (PDF, DOCX, XLSX, TXT), Audio & Video up to 50MB</p>
            </div>

            <!-- Uploading Progress State -->
            <div id="uploadProgressContainer" class="d-none py-2">
                <div class="spinner-border text-danger mb-2" role="status" style="width: 2.2rem; height: 2.2rem; color: #721835 !important;">
                    <span class="visually-hidden">Uploading...</span>
                </div>
                <div class="fw-semibold text-dark mb-2" id="uploadStatusText">Uploading file(s)...</div>
                <div class="progress mx-auto" style="max-width: 400px; height: 8px;">
                    <div id="uploadProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%; background: #721835;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. SEARCH, FILTER & VIEW CONTROLS -->
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body p-3">
            <form action="{{ route('admin.media.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-12 col-md-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0">
                            <span class="material-symbols-outlined text-muted" style="font-size: 18px;">search</span>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search by file name or extension..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="btn-group btn-group-sm w-100" role="group">
                        <a href="{{ route('admin.media.index', array_merge(request()->except('type'), ['type' => 'all'])) }}" class="btn btn-outline-secondary {{ !request('type') || request('type') == 'all' ? 'active' : '' }}">All</a>
                        <a href="{{ route('admin.media.index', array_merge(request()->except('type'), ['type' => 'image'])) }}" class="btn btn-outline-secondary {{ request('type') == 'image' ? 'active' : '' }}">Images</a>
                        <a href="{{ route('admin.media.index', array_merge(request()->except('type'), ['type' => 'document'])) }}" class="btn btn-outline-secondary {{ request('type') == 'document' ? 'active' : '' }}">PDF / Docs</a>
                        <a href="{{ route('admin.media.index', array_merge(request()->except('type'), ['type' => 'video'])) }}" class="btn btn-outline-secondary {{ request('type') == 'video' ? 'active' : '' }}">Video</a>
                    </div>
                </div>
                <div class="col-6 col-md-3 text-end d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-sm btn-dark px-3">Filter</button>
                    @if(request('search') || (request('type') && request('type') !== 'all'))
                        <a href="{{ route('admin.media.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- 5. MEDIA GRID (WITH 1-CLICK COPY LINK) -->
    @if($media->count() > 0)
        <div class="row g-3 mb-4">
            @foreach($media as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden media-card position-relative" style="transition: transform 0.2s, box-shadow 0.2s;">
                        <!-- File Preview Area -->
                        <div class="media-preview-box d-flex align-items-center justify-content-center position-relative" style="height: 170px; background: #f1f5f9; overflow: hidden;">
                            @if($item->isImage())
                                <img src="{{ $item->url }}" alt="{{ $item->name }}" class="w-100 h-100" style="object-fit: cover;" onerror="this.onerror=null; this.src='/assets/images/placeholder.png';">
                            @elseif($item->extension === 'pdf')
                                <div class="text-center p-3">
                                    <span class="material-symbols-outlined text-danger mb-1" style="font-size: 58px;">picture_as_pdf</span>
                                    <div class="small fw-bold text-danger text-uppercase">PDF Document</div>
                                </div>
                            @else
                                <div class="text-center p-3">
                                    <span class="material-symbols-outlined text-secondary mb-1" style="font-size: 54px;">{{ $item->icon }}</span>
                                    <div class="small fw-bold text-muted text-uppercase">{{ $item->extension ?: 'FILE' }}</div>
                                </div>
                            @endif

                            <!-- Quick Format Badge -->
                            <span class="badge position-absolute top-0 end-0 m-2 shadow-sm text-uppercase" style="background: rgba(30, 41, 59, 0.75); font-size: 10px; backdrop-filter: blur(4px);">
                                {{ $item->extension }}
                            </span>
                        </div>

                        <!-- Card Body & File Details -->
                        <div class="card-body p-3 d-flex flex-direction-column justify-content-between flex-grow-1">
                            <div>
                                <h6 class="fw-bold mb-1 text-truncate text-dark" title="{{ $item->name }}" style="font-size: 13.5px;">
                                    {{ $item->name }}
                                </h6>
                                <p class="text-muted small mb-2 text-truncate" style="font-size: 11px;" title="{{ $item->file_name }}">
                                    {{ $item->file_name }}
                                </p>
                                <div class="d-flex align-items-center justify-content-between text-muted small mb-3" style="font-size: 11.5px;">
                                    <span><i class="fa-regular fa-hard-drive me-1"></i> {{ $item->size_formatted }}</span>
                                    <span><i class="fa-regular fa-calendar me-1"></i> {{ $item->created_at->format('d M Y') }}</span>
                                </div>
                            </div>

                            <!-- ACTIONS: 1-CLICK COPY LINK & OPTIONS -->
                            <div class="pt-2 border-top">
                                <div class="btn-group w-100 mb-2">
                                    <button type="button" 
                                            class="btn btn-sm text-white fw-bold copy-link-btn flex-grow-1 d-flex align-items-center justify-content-center gap-1" 
                                            style="background: #721835; font-size: 12px;" 
                                            onclick="copyToClipboard('{{ $item->url }}', this)" 
                                            title="Click to copy public link">
                                        <i class="fa-regular fa-copy"></i>
                                        <span>Copy Link</span>
                                    </button>
                                    <button type="button" class="btn btn-sm text-white dropdown-toggle dropdown-toggle-split" style="background: #5c0d28;" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="font-size: 12px;">
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="copyToClipboard('{{ $item->url }}', this)">
                                                <i class="fa-solid fa-link me-2 text-primary"></i> Copy Full URL
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="copyToClipboard('/{{ $item->disk_path }}', this)">
                                                <i class="fa-solid fa-code me-2 text-secondary"></i> Copy Relative Path (/{{ $item->disk_path }})
                                            </a>
                                        </li>
                                        @if($item->isImage())
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="copyToClipboard('&lt;img src=&quot;{{ $item->url }}&quot; alt=&quot;{{ $item->name }}&quot; class=&quot;img-fluid&quot;&gt;', this)">
                                                    <i class="fa-regular fa-image me-2 text-success"></i> Copy &lt;img&gt; Tag
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="copyToClipboard('&lt;a href=&quot;{{ $item->url }}&quot; target=&quot;_blank&quot;&gt;Download {{ $item->name }}&lt;/a&gt;', this)">
                                                    <i class="fa-solid fa-file-arrow-down me-2 text-danger"></i> Copy &lt;a&gt; Download Tag
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="{{ $item->url }}" target="_blank" class="btn btn-outline-secondary btn-sm py-1 px-2" style="font-size: 11px;" title="View file in new tab">
                                        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View
                                    </a>
                                    
                                    <form action="{{ route('admin.media.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this media file?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm py-1 px-2" style="font-size: 11px;" title="Delete file">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $media->links() }}
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-3 text-center py-5">
            <div class="card-body">
                <span class="material-symbols-outlined text-muted mb-2" style="font-size: 56px;">folder_off</span>
                <h5 class="fw-bold text-dark">No Media Files Found</h5>
                <p class="text-muted small mb-3">You haven't uploaded any media files yet, or no files matched your search criteria.</p>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <button type="button" class="btn btn-cms-primary btn-sm" onclick="document.getElementById('mediaFileInput').click()">
                        <span class="material-symbols-outlined align-middle me-1" style="font-size: 18px;">cloud_upload</span> Upload First File
                    </button>
                    <form action="{{ route('admin.media.sync') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                            <span class="material-symbols-outlined align-middle me-1" style="font-size: 18px;">sync</span> Sync Existing Website Files
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

</div>

<!-- TOAST NOTIFICATION FOR COPY -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <div id="copyToast" class="toast align-items-center text-white bg-dark border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2" style="font-size: 13px;">
                <i class="fa-solid fa-circle-check text-success fs-6"></i>
                <span id="toastMessageText">Link copied to clipboard!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<style>
    .media-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }
    .copy-link-btn:active {
        transform: scale(0.97);
    }
</style>

<script>
    // Copy to Clipboard Helper
    function copyToClipboard(text, btnElement = null) {
        if (!navigator.clipboard) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            triggerToast('Link copied to clipboard!');
            animateBtn(btnElement);
            return;
        }

        navigator.clipboard.writeText(text).then(function() {
            triggerToast('Link copied to clipboard!');
            animateBtn(btnElement);
        }).catch(function(err) {
            prompt('Copy link manually:', text);
        });
    }

    function animateBtn(btn) {
        if (!btn) return;
        const origHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-check text-white"></i> <span>Copied!</span>';
        btn.style.backgroundColor = '#16a34a';
        setTimeout(() => {
            btn.innerHTML = origHtml;
            btn.style.backgroundColor = '#721835';
        }, 1800);
    }

    function triggerToast(msg) {
        document.getElementById('toastMessageText').innerText = msg;
        const toastEl = document.getElementById('copyToast');
        const toast = new bootstrap.Toast(toastEl, { delay: 2200 });
        toast.show();
    }

    // Drag and Drop Upload Handler
    function handleUploadDragOver(e) {
        e.preventDefault();
        document.getElementById('dropZoneArea').style.borderColor = '#721835';
        document.getElementById('dropZoneArea').style.backgroundColor = '#fdf4f7';
    }

    function handleUploadDragLeave(e) {
        e.preventDefault();
        document.getElementById('dropZoneArea').style.borderColor = '#cbd5e1';
        document.getElementById('dropZoneArea').style.backgroundColor = '#fafbfc';
    }

    function handleUploadDrop(e) {
        e.preventDefault();
        handleUploadDragLeave(e);
        if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
            uploadSelectedFiles(e.dataTransfer.files);
        }
    }

    // Ajax Upload
    function uploadSelectedFiles(files) {
        if (!files || files.length === 0) return;

        const formData = new FormData();
        for (let i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        // Show progress
        document.getElementById('uploadIdlePrompt').classList.add('d-none');
        document.getElementById('uploadProgressContainer').classList.remove('d-none');
        document.getElementById('uploadStatusText').innerText = `Uploading ${files.length} file(s)...`;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        fetch('{{ route('admin.media.upload') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                triggerToast(data.message);
                setTimeout(() => {
                    window.location.reload();
                }, 800);
            } else {
                alert(data.message || 'Error uploading file.');
                document.getElementById('uploadIdlePrompt').classList.remove('d-none');
                document.getElementById('uploadProgressContainer').classList.add('d-none');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Upload failed. Please try again.');
            document.getElementById('uploadIdlePrompt').classList.remove('d-none');
            document.getElementById('uploadProgressContainer').classList.add('d-none');
        });
    }
</script>
@endsection
