@extends('layouts.front')

@section('title', session('locale') == 'hi' ? 'नया क्या है' : "What's New")

@section('content')
<div class="whats-new-page-wrapper">

    <!-- Top Breadcrumbs & Hero Banner -->
    <div class="whats-new-hero" style="background: linear-gradient(135deg, #6c1340 0%, #500a2f 100%); color: #ffffff; padding: 36px 0 32px; border-bottom: 3px solid #c59b27;">
        <div class="page-container">
            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0" style="font-size: 1.4rem;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #f1d5e3; text-decoration: none;"><i class="fa fa-home me-1"></i> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: #ffffff; font-weight: 600;">What's New</li>
                </ol>
            </nav>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="h2 fw-bold text-white mb-1" style="font-family: 'Noto Sans', sans-serif;">
                        {{ session('locale') == 'hi' ? 'नया क्या है' : "What's New" }}
                    </h1>
                    <p class="mb-0 text-white-50" style="font-size: 1.4rem;">
                        Latest notifications, circulars, scheme updates, and official announcements from Textiles Committee
                    </p>
                </div>
                <div class="badge bg-white text-dark px-3 py-2 fs-6 shadow-sm">
                    <i class="fa fa-bell text-danger me-1"></i> {{ $whatsNews->count() }} Live Updates
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="page-container py-5">

        <!-- Search Bar -->
        <div class="card border shadow-xs mb-4 rounded-3" style="border-color: #ebd0de !important;">
            <div class="card-body p-3">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="fa fa-search" style="color: #6c1340;"></i>
                    </span>
                    <input type="text" id="whatsNewSearchInput" class="form-control border-start-0 ps-0" placeholder="Search notices, documents, schemes, circulars..." style="font-size: 1.5rem;" onkeyup="filterWhatsNew(this.value)">
                    <button class="btn btn-outline-secondary px-3" type="button" onclick="clearWhatsNewSearch()">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- SECTION 1: LATEST NOTIFICATIONS & WHAT'S NEW ITEMS -->
        <div class="card border shadow-xs mb-5 rounded-3 overflow-hidden" style="border-color: #ebd0de !important;">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h3 class="h5 fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-danger">campaign</span>
                    <span>Latest Announcements & Notifications</span>
                </h3>
                <span class="badge rounded-pill text-white px-3 py-2" style="background: #6c1340;" id="whatsNewCountBadge">
                    {{ $whatsNews->count() }}
                </span>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush" id="whatsNewListGroup">
                    @forelse($whatsNews as $item)
                        @php
                            $title = session('locale') == 'hi' ? ($item->title_hi ?: $item->title_en) : ($item->title_en ?: $item->title_hi);
                            $date = $item->date ?: $item->published_date;
                            $fileUrl = $item->document_url ? asset($item->document_url) : ($item->link_url !== '#' ? $item->link_url : '#');
                            $hasFile = !empty($item->document_url) || ($item->link_url && $item->link_url !== '#');
                            $sizeText = $item->file_size ?: ($item->document_url ? 'PDF' : '');
                        @endphp
                        <div class="list-group-item p-3 p-md-4 whats-new-row border-bottom" data-search-text="{{ strtolower($item->title_en . ' ' . $item->title_hi . ' ' . $item->category) }}">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <!-- Left: Title & Meta -->
                                <div class="flex-grow-1" style="max-width: 820px;">
                                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                        @if($item->is_new)
                                            <span class="badge bg-danger text-white px-2 py-1" style="font-size: 11px; animation: pulse 2s infinite;">NEW</span>
                                        @endif
                                        <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 11px;">
                                            {{ $item->category ?: 'Notification' }}
                                        </span>
                                        @if($date)
                                            <span class="text-muted small">
                                                <i class="fa fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                                            </span>
                                        @endif
                                    </div>
                                    <h4 class="h6 fw-bold mb-1" style="color: #1f1b2d; font-size: 1.55rem; line-height: 1.45;">
                                        @if($hasFile)
                                            <a href="{{ $fileUrl }}" target="_blank" class="text-decoration-none text-dark hover-maroon">
                                                {{ $title }}
                                            </a>
                                        @else
                                            {{ $title }}
                                        @endif
                                    </h4>
                                    @if($item->content_en)
                                        <p class="text-muted mb-0 small text-truncate" style="max-width: 750px;">{{ $item->content_en }}</p>
                                    @endif
                                </div>

                                <!-- Right: File Size & VIEW Button (Exact match to Image 3) -->
                                <div class="d-flex align-items-center gap-3">
                                    @if($sizeText)
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 d-inline-flex align-items-center gap-1" style="font-size: 12px;">
                                            <i class="fa fa-file-lines"></i> {{ $sizeText }}
                                        </span>
                                    @endif

                                    @if($hasFile)
                                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm px-3 py-2 fw-semibold d-inline-flex align-items-center gap-1 shadow-xs" style="color: #6c1340; border: 1.5px solid #d4aabf; background: #ffffff; border-radius: 6px; font-size: 1.3rem;">
                                            <i class="fa fa-eye"></i>
                                            <span>VIEW</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center text-muted">
                            <span class="material-symbols-outlined fs-1 text-muted">info</span>
                            <p class="mb-0 mt-2">No updates available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- SECTION 2: OFFERINGS (SCHEMES AND SERVICES) - Exact match to Image 3 -->
        <div class="mb-5">
            <h3 class="h4 fw-bold mb-3 d-flex align-items-center gap-2" style="color: #500a2f;">
                <span>Offerings</span>
            </h3>

            <div class="card border shadow-xs rounded-3 overflow-hidden" style="border-color: #ebd0de !important;">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-primary">verified</span>
                    <span class="fw-bold fs-5 text-dark">Schemes and Services</span>
                    <span class="badge text-white ms-1 px-2 py-1" style="background: #e56b9c; font-size: 12px;">{{ $schemes->count() }}</span>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-hover m-0">
                        <thead style="background: #f7d6e6; color: #500a2f;">
                            <tr>
                                <th style="width: 45%; padding: 12px 18px; font-size: 1.25rem;">TITLE</th>
                                <th style="width: 25%; font-size: 1.25rem;">PUBLISHED DATE</th>
                                <th style="width: 20%; font-size: 1.25rem;">TYPE/SIZE</th>
                                <th style="width: 10%; text-end font-size: 1.25rem;" class="text-end pe-4">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schemes as $scheme)
                                @php
                                    $sTitle = session('locale') == 'hi' ? ($scheme->title_hi ?: $scheme->title_en) : ($scheme->title_en ?: $scheme->title_hi);
                                    $sUrl = $scheme->link_url && $scheme->link_url !== '#' ? $scheme->link_url : route('page.show', 'samarth');
                                @endphp
                                <tr class="border-bottom scheme-doc-row">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa fa-file-lines text-muted"></i>
                                            <a href="{{ $sUrl }}" class="text-decoration-none fw-semibold text-dark hover-maroon" style="font-size: 1.4rem;">
                                                {{ $sTitle }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-muted" style="font-size: 1.35rem;">
                                        {{ $scheme->created_at ? $scheme->created_at->format('d/m/Y') : date('d/m/Y') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">Scheme / Service</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ $sUrl }}" class="btn btn-sm text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: #e56b9c;" title="View Scheme">
                                            <i class="fa fa-arrow-right" style="font-size: 11px;"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No schemes listed.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SECTION 3: DOCUMENTS - Exact match to Image 3 -->
        <div>
            <h3 class="h4 fw-bold mb-3 d-flex align-items-center gap-2" style="color: #500a2f;">
                <span>Documents</span>
                <span class="badge text-white px-2 py-1" style="background: #e56b9c; font-size: 12px;">{{ $documents->count() }}</span>
            </h3>

            <div class="card border shadow-xs rounded-3 overflow-hidden" style="border-color: #ebd0de !important;">
                <div class="table-responsive">
                    <table class="table align-middle table-hover m-0">
                        <thead style="background: #f7d6e6; color: #500a2f;">
                            <tr>
                                <th style="width: 45%; padding: 12px 18px; font-size: 1.25rem;">TITLE</th>
                                <th style="width: 25%; font-size: 1.25rem;">PUBLISHED DATE</th>
                                <th style="width: 20%; font-size: 1.25rem;">TYPE/SIZE</th>
                                <th style="width: 10%; font-size: 1.25rem;" class="text-end pe-4">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $doc)
                                @php
                                    $dTitle = session('locale') == 'hi' ? ($doc->title_hi ?: $doc->title_en) : ($doc->title_en ?: $doc->title_hi);
                                    if ($doc->description_en) {
                                        $dTitle .= ' - ' . $doc->description_en;
                                    }
                                    $dUrl = asset($doc->file_url ?? 'assets/images/sample_doc.pdf');
                                @endphp
                                <tr class="border-bottom scheme-doc-row">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa fa-file-pdf text-danger"></i>
                                            <a href="{{ $dUrl }}" target="_blank" class="text-decoration-none fw-semibold text-dark hover-maroon" style="font-size: 1.4rem;">
                                                {{ $dTitle }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-muted" style="font-size: 1.35rem;">
                                        {{ $doc->published_date ? \Carbon\Carbon::parse($doc->published_date)->format('d/m/Y') : date('d/m/Y') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle">
                                            {{ $doc->file_size ?: '1.59 MB' }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ $dUrl }}" target="_blank" class="btn btn-sm px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1 shadow-xs" style="color: #6c1340; border: 1.5px solid #d4aabf; background: #ffffff; border-radius: 6px;">
                                            <i class="fa fa-eye"></i>
                                            <span>VIEW</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No documents available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
.hover-maroon:hover {
    color: #6c1340 !important;
    text-decoration: underline !important;
}
@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.08); opacity: 0.85; }
    100% { transform: scale(1); opacity: 1; }
}
.whats-new-row:hover {
    background-color: #fdfafc !important;
}
</style>

<script>
function filterWhatsNew(keyword) {
    const query = keyword.toLowerCase().trim();
    const rows = document.querySelectorAll('.whats-new-row');
    let visible = 0;

    rows.forEach(r => {
        const text = r.getAttribute('data-search-text') || '';
        if (!query || text.includes(query)) {
            r.style.display = '';
            visible++;
        } else {
            r.style.display = 'none';
        }
    });

    const badge = document.getElementById('whatsNewCountBadge');
    if (badge) badge.innerText = visible;

    document.querySelectorAll('.scheme-doc-row').forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = (!query || text.includes(query)) ? '' : 'none';
    });
}

function clearWhatsNewSearch() {
    const input = document.getElementById('whatsNewSearchInput');
    if (input) {
        input.value = '';
        filterWhatsNew('');
    }
}
</script>
@endsection
