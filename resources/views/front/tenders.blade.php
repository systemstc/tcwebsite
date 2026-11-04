@extends('layouts.front')

@section('title', session('locale') == 'hi' ? 'निविदाएं एवं प्रस्ताव | वस्त्र समिति' : 'Tenders & Notices | Textiles Committee')

@section('content')
<!-- Official Maroon Curved Hero Banner -->
<section class="inner-hero-banner">
    <div class="inner-hero-graphic" aria-hidden="true">
        <svg viewBox="0 0 1600 240" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <defs>
                <linearGradient id="glowWave" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#ba2369" stop-opacity="0.38"/>
                    <stop offset="50%" stop-color="#801244" stop-opacity="0.18"/>
                    <stop offset="100%" stop-color="#4a0628" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="waveFill" x1="50%" y1="0%" x2="50%" y2="100%">
                    <stop offset="0%" stop-color="#9e1857" stop-opacity="0.22"/>
                    <stop offset="100%" stop-color="#3d0520" stop-opacity="0.5"/>
                </linearGradient>
            </defs>
            <path d="M 450,0 C 700,60 920,180 1250,110 C 1420,70 1520,130 1600,160 L 1600,240 L 450,240 Z" fill="url(#waveFill)"/>
            <path d="M 520,0 C 760,70 980,190 1300,120 C 1450,85 1540,140 1600,170" stroke="url(#glowWave)" stroke-width="4" fill="none"/>
            <path d="M 380,240 C 580,210 760,160 980,130 C 1200,100 1420,110 1600,150" stroke="rgba(255, 80, 150, 0.45)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
        </svg>
    </div>

    <div class="page-container inner-hero-container">
        <div class="inner-hero-content">
            <div class="inner-breadcrumb-text">
                <a href="{{ route('home') }}">{{ session('locale') == 'hi' ? 'मुख्य पृष्ठ' : 'Home' }}</a>
                <span class="mx-1">/</span>
                <span>{{ session('locale') == 'hi' ? 'सेवाएं एवं योजनाएं' : 'Offerings' }}</span>
                <span class="mx-1">/</span>
                <span>{{ session('locale') == 'hi' ? 'निविदाएं' : 'Tenders' }}</span>
            </div>
            <h1 class="inner-hero-title">
                {{ session('locale') == 'hi' ? 'निविदाएं एवं प्रस्ताव' : 'Tenders & Notices' }}
            </h1>
        </div>
    </div>
</section>

<!-- Main Tenders Content Section -->
<main class="maincontent inner-page-main py-4 py-md-5">
    <div class="page-container">

        <!-- Top Controls / Filter Bar matching Image 3 -->
        <div class="tenders-filter-bar mb-4">
            <div class="tenders-search-wrap">
                <span class="material-symbols-outlined search-icon">search</span>
                <input type="text" id="tendersSearchInput" class="tenders-search-input" placeholder="Search..." onkeyup="filterAndSortTenders()">
            </div>

            <div class="tenders-controls-right">
                <div class="tenders-dropdown-wrap">
                    <span class="material-symbols-outlined dropdown-icon">sort</span>
                    <select id="tendersSortSelect" class="tenders-select" onchange="filterAndSortTenders()">
                        <option value="latest">Sort by</option>
                        <option value="latest">Latest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="due_asc">Due Date (Closing Soon)</option>
                    </select>
                </div>

                <div class="tenders-dropdown-wrap">
                    <span class="material-symbols-outlined dropdown-icon">filter_list</span>
                    <select id="tendersCategoryFilter" class="tenders-select" onchange="filterAndSortTenders()">
                        <option value="all">Category</option>
                        <option value="all">All Categories</option>
                        <option value="gem">GeM Portal Bids</option>
                        <option value="rfp">RFPs & Proposals</option>
                        <option value="corrigendum">Corrigendums</option>
                        <option value="general">General Tenders</option>
                    </select>
                </div>

                <div class="tenders-dropdown-wrap">
                    <span class="material-symbols-outlined dropdown-icon">view_list</span>
                    <select id="tendersPageSize" class="tenders-select">
                        <option value="10">10 per page</option>
                        <option value="20">20 per page</option>
                        <option value="all">All</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table Header (Matching Image 3 Pink Banner) -->
        <div class="tenders-table-header">
            <div class="th-col col-tender-id">TENDER ID</div>
            <div class="th-col col-title">TITLE</div>
            <div class="th-col col-pub-date">PUBLISHED DATE</div>
            <div class="th-col col-due-date">DUE DATE</div>
            <div class="th-col col-type-size">TYPE/SIZE</div>
            <div class="th-col col-action text-end"></div>
        </div>

        <!-- Tenders List Rows Container (100% Dynamic from Admin Tenders) -->
        <div class="tenders-list-container" id="tendersList">
            @forelse($tenders as $ten)
                @php
                    $title = session('locale') == 'hi' ? ($ten->title_hi ?: $ten->title_en) : ($ten->title_en ?: $ten->title_hi);
                    $ref = $ten->reference_no ?: 'TC/TND/2026';
                    $pubDateFormatted = $ten->published_date ? \Carbon\Carbon::parse($ten->published_date)->format('d.m.Y') : '-';
                    $dueDateFormatted = $ten->closing_date ? \Carbon\Carbon::parse($ten->closing_date)->format('d.m.Y') : 'Open';
                    $docUrl = $ten->document_url ? asset($ten->document_url) : asset('assets/documents/sample_doc.pdf');
                    
                    // Auto-categorize based on title
                    $tLower = strtolower($title);
                    $cat = 'general';
                    if (str_contains($tLower, 'corrigendum')) $cat = 'corrigendum';
                    elseif (str_contains($tLower, 'gem')) $cat = 'gem';
                    elseif (str_contains($tLower, 'rfp') || str_contains($tLower, 'proposal')) $cat = 'rfp';
                @endphp
                <div class="tender-row-card" data-category="{{ $cat }}" data-pub="{{ $ten->published_date ? \Carbon\Carbon::parse($ten->published_date)->format('Y-m-d') : '' }}" data-due="{{ $ten->closing_date ? \Carbon\Carbon::parse($ten->closing_date)->format('Y-m-d') : '' }}" data-keywords="{{ strtolower($ref . ' ' . $title) }}">
                    <div class="td-col col-tender-id fw-bold text-dark">
                        {{ $ref }}
                    </div>
                    <div class="td-col col-title">
                        {{ $title }}
                    </div>
                    <div class="td-col col-pub-date">
                        {{ $pubDateFormatted }}
                    </div>
                    <div class="td-col col-due-date">
                        {{ $dueDateFormatted }}
                    </div>
                    <div class="td-col col-type-size">
                        <span class="pdf-badge-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#6c1340" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <text x="7" y="18" fill="#6c1340" font-size="7" font-weight="bold">PDF</text>
                            </svg>
                        </span>
                        <span class="file-size-txt">PDF</span>
                    </div>
                    <div class="td-col col-action text-end">
                        <a href="{{ $docUrl }}" target="_blank" class="btn-tender-view">
                            <span class="material-symbols-outlined btn-view-icon">visibility</span>
                            VIEW
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <span class="material-symbols-outlined" style="font-size: 54px; color: #ba4073;">info</span>
                    <h3 class="h4 mt-3 text-dark fw-bold">No active tenders found.</h3>
                    <p class="text-muted" style="font-size: 1.5rem;">New tenders will appear here once published in the administrative portal.</p>
                </div>
            @endforelse
        </div>

        <!-- No Results Fallback -->
        <div id="noTendersFound" class="text-center py-5 d-none">
            <span class="material-symbols-outlined" style="font-size: 48px; color: #ba4073;">search_off</span>
            <h3 class="h4 mt-3 text-dark fw-bold">No tenders found matching your search.</h3>
            <p class="text-muted" style="font-size: 1.5rem;">Try modifying your keyword search or category filter.</p>
        </div>

        <!-- Bottom Right VIEW ARCHIVE Outline Button matching Image 3 -->
        <div class="tenders-footer-action mt-4">
            <a href="{{ route('whats-new.index') }}#archives" class="btn-view-archive">
                <span class="material-symbols-outlined archive-icon">folder_zip</span>
                <span>VIEW ARCHIVE</span>
            </a>
        </div>

    </div>
</main>

<style>
/* Controls / Filter Bar Styles (Matching Image 3) */
.tenders-filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}
.tenders-search-wrap {
    position: relative;
    flex: 1;
    max-width: 320px;
    min-width: 220px;
}
.tenders-search-wrap .search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #c0517f;
    font-size: 2.1rem;
    pointer-events: none;
}
.tenders-search-input {
    width: 100%;
    padding: 10px 14px 10px 42px;
    border: 1.5px solid #dca7bc;
    border-radius: 6px;
    background: #ffffff;
    font-size: 1.5rem;
    color: #333333;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.tenders-search-input:focus {
    border-color: #6c1340;
    box-shadow: 0 0 0 3px rgba(108, 19, 64, 0.12);
}
.tenders-controls-right {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.tenders-dropdown-wrap {
    position: relative;
    display: inline-flex;
    align-items: center;
}
.tenders-dropdown-wrap .dropdown-icon {
    position: absolute;
    left: 12px;
    color: #c0517f;
    font-size: 2rem;
    pointer-events: none;
}
.tenders-select {
    padding: 10px 34px 10px 40px;
    border: 1.5px solid #dca7bc;
    border-radius: 6px;
    background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236c1340' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") no-repeat right 12px center;
    font-size: 1.45rem;
    font-weight: 500;
    color: #333333;
    appearance: none;
    -webkit-appearance: none;
    cursor: pointer;
    outline: none;
    transition: border-color 0.2s;
}
.tenders-select:focus {
    border-color: #6c1340;
}

/* Table Header (Matching Image 3 Soft Mauve Pink) */
.tenders-table-header {
    background: #e6a9b9;
    color: #580d2f;
    font-weight: 700;
    font-size: 1.3rem;
    letter-spacing: 0.5px;
    padding: 14px 22px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 16px;
}

/* Card-Row Container */
.tenders-list-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 12px;
}
.tender-row-card {
    background: #ffffff;
    border: 1px solid #ebd0de;
    border-radius: 8px;
    padding: 16px 22px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}
.tender-row-card:hover {
    border-color: #ba4073;
    box-shadow: 0 4px 14px rgba(108, 19, 64, 0.08);
}

/* Column Dimensions */
.col-tender-id {
    width: 170px;
    flex-shrink: 0;
    font-size: 1.4rem;
}
.col-title {
    flex: 1;
    min-width: 260px;
    font-size: 1.42rem;
    font-weight: 500;
    color: #1a1a2e;
    line-height: 1.45;
}
.col-pub-date {
    width: 140px;
    flex-shrink: 0;
    text-align: center;
    font-size: 1.4rem;
    color: #333333;
}
.col-due-date {
    width: 140px;
    flex-shrink: 0;
    text-align: center;
    font-size: 1.4rem;
    color: #333333;
}
.col-type-size {
    width: 140px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 1.35rem;
    font-weight: 600;
    color: #444444;
}
.col-action {
    width: 100px;
    flex-shrink: 0;
}

.pdf-badge-icon {
    display: inline-flex;
    align-items: center;
}
.file-size-txt {
    font-weight: 600;
    color: #333333;
}

/* View Button (Pink Pill Matching Image 3) */
.btn-tender-view {
    background: #fae4ed;
    color: #6c1340;
    border-radius: 6px;
    font-weight: 700;
    font-size: 1.3rem;
    padding: 7px 18px;
    border: none;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: background 0.2s, color 0.2s;
}
.btn-tender-view:hover {
    background: #6c1340;
    color: #ffffff;
}
.btn-view-icon {
    font-size: 1.7rem;
}

/* Bottom Archive Button (Outline Pill) */
.tenders-footer-action {
    display: flex;
    justify-content: flex-end;
}
.btn-view-archive {
    border: 1.5px solid #6c1340;
    color: #6c1340;
    background: #ffffff;
    font-weight: 700;
    font-size: 1.35rem;
    padding: 9px 22px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background 0.2s, color 0.2s;
}
.btn-view-archive:hover {
    background: #6c1340;
    color: #ffffff;
}
.btn-view-archive .archive-icon {
    font-size: 1.9rem;
}

/* Responsive Table */
@media (max-width: 991px) {
    .tenders-table-header {
        display: none;
    }
    .tender-row-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    .col-tender-id, .col-title, .col-pub-date, .col-due-date, .col-type-size, .col-action {
        width: 100%;
        text-align: left;
    }
    .col-type-size {
        justify-content: flex-start;
    }
    .col-action {
        text-align: left !important;
    }
}
</style>

<script>
function filterAndSortTenders() {
    var search = (document.getElementById('tendersSearchInput').value || '').toLowerCase().trim();
    var category = (document.getElementById('tendersCategoryFilter').value || 'all').toLowerCase();
    var sortBy = (document.getElementById('tendersSortSelect').value || 'latest');
    var container = document.getElementById('tendersList');
    var cards = Array.from(document.querySelectorAll('.tender-row-card'));
    var visibleCount = 0;

    cards.forEach(function(card) {
        var cardCat = (card.getAttribute('data-category') || '').toLowerCase();
        var keywords = (card.getAttribute('data-keywords') || '').toLowerCase();
        var title = (card.querySelector('.col-title') ? card.querySelector('.col-title').innerText : '').toLowerCase();
        var tenderId = (card.querySelector('.col-tender-id') ? card.querySelector('.col-tender-id').innerText : '').toLowerCase();
        var combinedText = title + ' ' + tenderId + ' ' + keywords;

        var matchesSearch = !search || combinedText.indexOf(search) !== -1;
        var matchesCat = (category === 'all') || (cardCat === category);

        if (matchesSearch && matchesCat) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Sorting
    cards.sort(function(a, b) {
        var pubA = a.getAttribute('data-pub') || '';
        var pubB = b.getAttribute('data-pub') || '';
        var dueA = a.getAttribute('data-due') || '';
        var dueB = b.getAttribute('data-due') || '';

        if (sortBy === 'oldest') {
            return pubA.localeCompare(pubB);
        } else if (sortBy === 'due_asc') {
            return dueA.localeCompare(dueB);
        } else { // latest
            return pubB.localeCompare(pubA);
        }
    });

    cards.forEach(function(card) {
        container.appendChild(card);
    });

    var noResult = document.getElementById('noTendersFound');
    if (noResult) {
        if (visibleCount === 0) {
            noResult.classList.remove('d-none');
        } else {
            noResult.classList.add('d-none');
        }
    }
}
</script>
@endsection
