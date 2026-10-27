@extends('layouts.front')

@section('title', session('locale') == 'hi' ? 'खोज परिणाम' : 'Search Results')

@section('content')
@php
    function highlightQuery($text, $query) {
        if (empty($query) || empty($text)) return e($text);
        $escaped = e($text);
        $tokens = array_filter(preg_split('/\s+/', trim($query)), fn($t) => mb_strlen($t) >= 2);
        if (empty($tokens)) return $escaped;

        $pattern = '/(' . implode('|', array_map(fn($t) => preg_quote($t, '/'), $tokens)) . ')/iu';
        return preg_replace($pattern, '<mark class="search-term-mark">$1</mark>', $escaped);
    }
@endphp

<div class="search-page-wrapper">
    <!-- 1. OFFICIAL MAROON HERO BANNER -->
    <div class="search-hero" style="background: linear-gradient(135deg, #6c1340 0%, #4a0628 100%); color: #ffffff; padding: 40px 0 34px; border-bottom: 3px solid #c59b27;">
        <div class="page-container">
            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0" style="font-size: 1.4rem;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #f1d5e3; text-decoration: none;"><i class="fa fa-home me-1"></i> {{ session('locale') == 'hi' ? 'मुख्य पृष्ठ' : 'Home' }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: #ffffff; font-weight: 600;">{{ session('locale') == 'hi' ? 'खोज परिणाम' : 'Search Results' }}</li>
                </ol>
            </nav>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="h2 fw-bold text-white mb-2" style="font-family: 'Noto Sans', sans-serif;">
                        <i class="fa-solid fa-magnifying-glass me-2" style="color: #facc15;"></i>
                        {{ session('locale') == 'hi' ? 'खोज परिणाम' : 'Search Results' }}
                    </h1>
                    <p class="mb-0 text-white-50" style="font-size: 1.5rem;">
                        {{ session('locale') == 'hi' ? 'वेबसाइट पृष्ठों, दस्तावेज़ों और पीडीएफ सामग्री में प्राप्त परिणाम:' : 'Showing verified results across website pages, documents, notices, and PDF text contents for:' }}
                        <strong class="text-white">"{{ $q }}"</strong>
                    </p>
                </div>
                <div class="badge bg-white text-dark px-3 py-2 fs-6 shadow-sm">
                    <i class="fa-solid fa-layer-group text-danger me-1"></i> {{ $total }} {{ session('locale') == 'hi' ? 'परिणाम मिले' : 'Results Found' }}
                </div>
            </div>
        </div>
    </div>

    <!-- 2. MAIN SEARCH BODY -->
    <div class="page-container py-5">
        <!-- Search Input Bar for Quick Query Refinement -->
        <div class="card border shadow-xs mb-4 rounded-3" style="border-color: #ebd0de !important;">
            <div class="card-body p-3">
                <form action="{{ route('site.search') }}" method="GET" class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-lg flex-grow-1">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="fa fa-magnifying-glass" style="color: #6c1340;"></i>
                        </span>
                        <input type="text" name="q" class="form-control border-start-0 ps-0" placeholder="Search pages, acts, circulars, laboratory testing, pdf content..." value="{{ $q }}" style="font-size: 1.55rem;" required>
                    </div>
                    <button class="btn btn-cms-primary px-4 py-2 fs-6 fw-bold shadow-xs" type="submit" style="background: #6c1340; color: #ffffff; border-radius: 8px;">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> {{ session('locale') == 'hi' ? 'खोजें' : 'Search' }}
                    </button>
                </form>
            </div>
        </div>

        @if($total > 0)
            <!-- Category Filter Pills -->
            <div class="d-flex align-items-center gap-2 flex-wrap mb-4" id="searchCategoryPills">
                <span class="fw-semibold text-muted small me-1"><i class="fa-solid fa-filter me-1"></i> Filter By:</span>
                <button type="button" class="btn btn-sm search-filter-btn active" data-category="all" onclick="filterResults('all', this)">
                    All Results ({{ $total }})
                </button>
                @if($pages->count() > 0)
                    <button type="button" class="btn btn-sm search-filter-btn" data-category="page" onclick="filterResults('page', this)">
                        <i class="fa-regular fa-file-lines me-1"></i> Pages ({{ $pages->count() }})
                    </button>
                @endif
                @if($documents->count() > 0)
                    <button type="button" class="btn btn-sm search-filter-btn" data-category="document" onclick="filterResults('document', this)">
                        <i class="fa-solid fa-file-pdf me-1"></i> Documents ({{ $documents->count() }})
                    </button>
                @endif
                @if($pdf_texts->count() > 0)
                    <button type="button" class="btn btn-sm search-filter-btn" data-category="pdf_text" onclick="filterResults('pdf_text', this)">
                        <i class="fa-solid fa-file-circle-check me-1"></i> Inside PDF Text ({{ $pdf_texts->count() }})
                    </button>
                @endif
                @if($whats_new->count() > 0)
                    <button type="button" class="btn btn-sm search-filter-btn" data-category="whats_new" onclick="filterResults('whats_new', this)">
                        <i class="fa-solid fa-bullhorn me-1"></i> What's New ({{ $whats_new->count() }})
                    </button>
                @endif
                @if($schemes->count() > 0)
                    <button type="button" class="btn btn-sm search-filter-btn" data-category="scheme" onclick="filterResults('scheme', this)">
                        <i class="fa-solid fa-award me-1"></i> Schemes ({{ $schemes->count() }})
                    </button>
                @endif
                @if($tenders->count() > 0)
                    <button type="button" class="btn btn-sm search-filter-btn" data-category="tender" onclick="filterResults('tender', this)">
                        <i class="fa-solid fa-gavel me-1"></i> Tenders ({{ $tenders->count() }})
                    </button>
                @endif
                @if($tech_issues->count() > 0)
                    <button type="button" class="btn btn-sm search-filter-btn" data-category="tech_issue" onclick="filterResults('tech_issue', this)">
                        <i class="fa-solid fa-wrench me-1"></i> Tech Issues ({{ $tech_issues->count() }})
                    </button>
                @endif
            </div>

            <!-- RESULTS LIST -->
            <div class="search-results-list" id="searchResultsList">
                @foreach($all as $index => $item)
                    <div class="card border rounded-3 p-3 p-md-4 mb-3 search-item-card" data-category="{{ $item['type'] }}" style="border-color: #ebd0de !important; background: #ffffff; transition: all 0.2s ease;">
                        <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-2">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <!-- Type Badge -->
                                @if($item['type'] === 'pdf_text')
                                    <span class="badge px-3 py-1 fw-bold" style="background: #fdf2f7; color: #6c1340; border: 1px solid #d4aabf; font-size: 1.2rem;">
                                        <i class="fa-solid fa-file-pdf me-1 text-danger"></i> MATCHED INSIDE PDF TEXT
                                    </span>
                                @elseif($item['type'] === 'page')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 fw-bold" style="font-size: 1.2rem;">
                                        <i class="fa-regular fa-file-lines me-1"></i> PORTAL PAGE
                                    </span>
                                @elseif($item['type'] === 'document')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 fw-bold" style="font-size: 1.2rem;">
                                        <i class="fa-solid fa-file-pdf me-1"></i> OFFICIAL DOCUMENT
                                    </span>
                                @elseif($item['type'] === 'whats_new')
                                    <span class="badge bg-warning-subtle text-dark border border-warning-subtle px-3 py-1 fw-bold" style="font-size: 1.2rem;">
                                        <i class="fa-solid fa-bullhorn me-1 text-danger"></i> WHAT'S NEW / CIRCULAR
                                    </span>
                                @elseif($item['type'] === 'scheme')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 fw-bold" style="font-size: 1.2rem;">
                                        <i class="fa-solid fa-certificate me-1"></i> SCHEME & SERVICE
                                    </span>
                                @elseif($item['type'] === 'tender')
                                    <span class="badge bg-secondary-subtle text-dark border border-secondary-subtle px-3 py-1 fw-bold" style="font-size: 1.2rem;">
                                        <i class="fa-solid fa-gavel me-1"></i> TENDER & VACANCY
                                    </span>
                                @else
                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-1 fw-bold" style="font-size: 1.2rem;">
                                        <i class="fa-solid fa-circle-info me-1"></i> {{ strtoupper($item['type_label']) }}
                                    </span>
                                @endif

                                @if(!empty($item['meta']))
                                    <span class="text-muted small">
                                        <i class="fa-regular fa-clock me-1"></i> {{ $item['meta'] }}
                                    </span>
                                @endif
                            </div>

                            <!-- Direct Action Button -->
                            <div>
                                @if(!empty($item['is_pdf']))
                                    <a href="{{ $item['url'] }}" target="_blank" class="btn btn-sm px-3 py-1 fw-bold d-inline-flex align-items-center gap-1 shadow-xs" style="background: #6c1340; color: #ffffff; border-radius: 6px; font-size: 1.3rem;">
                                        <i class="fa-solid fa-file-pdf me-1"></i> View / Download PDF &rarr;
                                    </a>
                                @else
                                    <a href="{{ $item['url'] }}" class="btn btn-sm btn-outline-secondary px-3 py-1 fw-bold d-inline-flex align-items-center gap-1 shadow-xs" style="border-radius: 6px; font-size: 1.3rem; color: #6c1340; border-color: #6c1340;">
                                        <span>Open Page &rarr;</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Title -->
                        <h3 class="h5 fw-bold mb-2">
                            <a href="{{ $item['url'] }}" target="{{ !empty($item['is_pdf']) ? '_blank' : '_self' }}" class="text-decoration-none hover-maroon" style="color: #500a2f; font-size: 1.85rem; line-height: 1.4;">
                                {!! highlightQuery($item['title'], $q) !!}
                            </a>
                        </h3>

                        <!-- Snippet with highlighted search term -->
                        @if(!empty($item['snippet']))
                            <p class="search-snippet mb-0 text-muted" style="font-size: 1.45rem; line-height: 1.65;">
                                {!! highlightQuery($item['snippet'], $q) !!}
                            </p>
                        @endif

                        <!-- URL / Breadcrumb indicator -->
                        <div class="mt-2 text-muted small d-flex align-items-center gap-1" style="font-size: 1.25rem;">
                            <i class="fa-solid fa-link text-muted"></i>
                            <span class="text-truncate" style="max-width: 600px;">{{ $item['url'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <!-- EMPTY STATE -->
            <div class="card border rounded-3 text-center p-5 shadow-xs" style="border-color: #ebd0de !important; background: #ffffff;">
                <div class="py-4">
                    <span class="material-symbols-outlined text-muted" style="font-size: 64px; color: #d4aabf !important;">search_off</span>
                    <h3 class="h4 fw-bold mt-3 mb-2" style="color: #500a2f;">
                        {{ session('locale') == 'hi' ? 'कोई परिणाम नहीं मिला' : 'No Results Found for "' . $q . '"' }}
                    </h3>
                    <p class="text-muted fs-5 mb-4" style="max-width: 620px; margin: 0 auto;">
                        {{ session('locale') == 'hi' 
                            ? 'कृपया अपनी वर्तनी जांचें या अन्य संबंधित शब्दों (जैसे वस्त्र, प्रयोगशाला, समिति, अधिनियम, समर्थ) से खोजें।' 
                            : 'We could not find any matches for your query. Try searching with broader keywords, checking for spelling errors, or browsing our key portal sections below.' }}
                    </p>

                    <!-- Popular Quick Links -->
                    <div class="d-flex align-items-center justify-content-center flex-wrap gap-2 mt-3">
                        <a href="{{ route('page.show', 'office-network') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 fw-semibold" style="border-radius: 20px;">
                            <i class="fa-solid fa-map-location-dot me-1"></i> Office Network
                        </a>
                        <a href="{{ route('whats-new.index') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 fw-semibold" style="border-radius: 20px;">
                            <i class="fa-solid fa-bullhorn me-1"></i> What's New
                        </a>
                        <a href="{{ route('page.show', 'tefcs') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 fw-semibold" style="border-radius: 20px;">
                            <i class="fa-solid fa-industry me-1"></i> TEFCs (Export Centers)
                        </a>
                        <a href="{{ route('page.show', 'samarth') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 fw-semibold" style="border-radius: 20px;">
                            <i class="fa-solid fa-award me-1"></i> SAMARTH Scheme
                        </a>
                        <a href="{{ route('page.show', 'reports-budget') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 fw-semibold" style="border-radius: 20px;">
                            <i class="fa-regular fa-file-pdf me-1"></i> Reports & Publications
                        </a>
                        <a href="{{ route('page.show', 'contact-us') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 fw-semibold" style="border-radius: 20px;">
                            <i class="fa-solid fa-envelope me-1"></i> Contact Us
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
/* Search Highlight Styling */
mark.search-term-mark {
    background-color: #fff176 !important;
    color: #1f2937 !important;
    font-weight: 700;
    padding: 1px 4px;
    border-radius: 3px;
    border-bottom: 2px solid #f59e0b;
}
.hover-maroon:hover {
    color: #6c1340 !important;
    text-decoration: underline !important;
}
.search-item-card:hover {
    border-color: #6c1340 !important;
    box-shadow: 0 4px 14px rgba(108, 19, 64, 0.08) !important;
    transform: translateY(-2px);
}
.search-filter-btn {
    background: #ffffff;
    color: #475569;
    border: 1px solid #d4aabf;
    border-radius: 20px;
    padding: 6px 16px;
    font-size: 1.3rem;
    font-weight: 600;
    transition: all 0.2s ease;
}
.search-filter-btn:hover {
    background: #fdf2f7;
    color: #6c1340;
    border-color: #6c1340;
}
.search-filter-btn.active {
    background: #6c1340 !important;
    color: #ffffff !important;
    border-color: #6c1340 !important;
}
</style>

<script>
function filterResults(category, btnEl) {
    document.querySelectorAll('.search-filter-btn').forEach(b => b.classList.remove('active'));
    if (btnEl) btnEl.classList.add('active');

    const cards = document.querySelectorAll('.search-item-card');
    cards.forEach(c => {
        if (category === 'all' || c.getAttribute('data-category') === category) {
            c.style.display = 'block';
        } else {
            c.style.display = 'none';
        }
    });
}
</script>
@endsection
