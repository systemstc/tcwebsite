@extends('layouts.front')

@section('title', session('locale') == 'hi' ? 'रिक्तियां एवं भर्ती | वस्त्र समिति' : 'Vacancies & Recruitment | Textiles Committee')

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
                <span>{{ session('locale') == 'hi' ? 'रिक्तियां' : 'Vacancies' }}</span>
            </div>
            <h1 class="inner-hero-title">
                {{ session('locale') == 'hi' ? 'रिक्तियां एवं भर्ती' : 'Vacancies' }}
            </h1>
        </div>
    </div>
</section>

<!-- Main Vacancies Content Section -->
<main class="maincontent inner-page-main py-4 py-md-5">
    <div class="page-container">

        <!-- Top Controls / Filter Bar matching Image 2 -->
        <div class="vacancies-filter-bar mb-4">
            <div class="vacancies-search-wrap">
                <span class="material-symbols-outlined search-icon">search</span>
                <input type="text" id="vacancySearchInput" class="vacancies-search-input" placeholder="Search..." onkeyup="filterVacancies()">
            </div>

            <div class="vacancies-controls-right">
                <div class="vacancies-dropdown-wrap">
                    <span class="material-symbols-outlined dropdown-icon">filter_list</span>
                    <select id="vacancyCategoryFilter" class="vacancies-select" onchange="filterVacancies()">
                        <option value="all">Category</option>
                        <option value="all">All Categories</option>
                        <option value="deputation">Deputation Basis</option>
                        <option value="recruitment">Direct Recruitment</option>
                        <option value="contractual">Contractual / Consultants</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- 3-Column Vacancy Cards Grid (100% Dynamic from Admin Tenders/Vacancies) -->
        <div class="vacancies-cards-grid" id="vacanciesGrid">
            @forelse($vacancies as $vac)
                @php
                    $title = session('locale') == 'hi' ? ($vac->title_hi ?: $vac->title_en) : ($vac->title_en ?: $vac->title_hi);
                    
                    // Determine Badge Banner text (prefer reference_no if present, otherwise short title)
                    $badgeText = $vac->reference_no ?: (strlen($title) > 35 ? substr($title, 0, 32) . '...' : $title);
                    if ($badgeText === 'NTTM/REC/2026/01') $badgeText = 'Re-Advertisement for Deputation';
                    elseif ($badgeText === 'TC/DEP/2026/04') $badgeText = 'Posts on Deputation Basis';
                    elseif ($badgeText === 'DCH/REC/2026/02') $badgeText = 'Post of Regional Director';

                    $pubDateFormatted = $vac->published_date ? \Carbon\Carbon::parse($vac->published_date)->format('d.m.Y') : 'N/A';
                    $dueDateFormatted = $vac->closing_date ? \Carbon\Carbon::parse($vac->closing_date)->format('d.m.Y') : 'Open';
                    $docUrl = $vac->document_url ? asset($vac->document_url) : asset('assets/documents/sample_doc.pdf');

                    $tLower = strtolower($title . ' ' . $badgeText);
                    $cat = 'deputation';
                    if (str_contains($tLower, 'direct') || str_contains($tLower, 'recruitment')) $cat = 'recruitment';
                    elseif (str_contains($tLower, 'contract') || str_contains($tLower, 'consultant')) $cat = 'contractual';
                @endphp
                <div class="vacancy-card" data-category="{{ $cat }}" data-keywords="{{ strtolower($title . ' ' . $badgeText . ' ' . $vac->reference_no) }}">
                    <div class="vacancy-badge-banner">
                        {{ $badgeText }}
                    </div>
                    <div class="vacancy-card-body">
                        <h2 class="vacancy-title">
                            {{ $title }}
                        </h2>

                        <div class="vacancy-meta-list">
                            <div class="vacancy-meta-item">
                                <span class="meta-label">
                                    <span class="material-symbols-outlined meta-icon">newspaper</span>
                                    PUBLISHED DATE
                                </span>
                                <span class="meta-val">{{ $pubDateFormatted }}</span>
                            </div>
                            <div class="vacancy-meta-item">
                                <span class="meta-label">
                                    <span class="material-symbols-outlined meta-icon">calendar_month</span>
                                    START DATE
                                </span>
                                <span class="meta-val">{{ $pubDateFormatted }}</span>
                            </div>
                            <div class="vacancy-meta-item">
                                <span class="meta-label">
                                    <span class="material-symbols-outlined meta-icon">alarm</span>
                                    DUE DATE
                                </span>
                                <span class="meta-val">{{ $dueDateFormatted }}</span>
                            </div>
                        </div>

                        <a href="{{ $docUrl }}" target="_blank" class="vacancy-doc-link" title="{{ $title }}">
                            {{ $title }}
                        </a>

                        <div class="vacancy-card-action">
                            <a href="{{ $docUrl }}" target="_blank" class="btn-view-documents">
                                VIEW ALL DOCUMENTS
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <span class="material-symbols-outlined" style="font-size: 54px; color: #ba4073;">info</span>
                    <h3 class="h4 mt-3 text-dark fw-bold">No active vacancies currently open.</h3>
                    <p class="text-muted" style="font-size: 1.5rem;">New vacancies and career notices will appear here once published in the administrative portal.</p>
                </div>
            @endforelse
        </div>

        <!-- No Results Fallback -->
        <div id="noVacanciesFound" class="text-center py-5 d-none">
            <span class="material-symbols-outlined" style="font-size: 48px; color: #ba4073;">search_off</span>
            <h3 class="h4 mt-3 text-dark fw-bold">No vacancy notices found matching your criteria.</h3>
            <p class="text-muted" style="font-size: 1.5rem;">Try modifying your keyword search or category filter.</p>
        </div>

    </div>
</main>

<style>
/* Controls / Filter Bar Styles (Matching Image 2) */
.vacancies-filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}
.vacancies-search-wrap {
    position: relative;
    flex: 1;
    max-width: 320px;
    min-width: 220px;
}
.vacancies-search-wrap .search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #c0517f;
    font-size: 2.1rem;
    pointer-events: none;
}
.vacancies-search-input {
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
.vacancies-search-input:focus {
    border-color: #6c1340;
    box-shadow: 0 0 0 3px rgba(108, 19, 64, 0.12);
}
.vacancies-controls-right {
    display: flex;
    align-items: center;
    gap: 12px;
}
.vacancies-dropdown-wrap {
    position: relative;
    display: inline-flex;
    align-items: center;
}
.vacancies-dropdown-wrap .dropdown-icon {
    position: absolute;
    left: 12px;
    color: #c0517f;
    font-size: 2rem;
    pointer-events: none;
}
.vacancies-select {
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
.vacancies-select:focus {
    border-color: #6c1340;
}

/* 3-Column Cards Grid (Matching Image 2) */
.vacancies-cards-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
@media (max-width: 1024px) {
    .vacancies-cards-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 680px) {
    .vacancies-cards-grid {
        grid-template-columns: 1fr;
    }
    .vacancies-search-wrap {
        max-width: 100%;
    }
}

.vacancy-card {
    background: #ffffff;
    border: 1px solid #ebd0de;
    border-radius: 12px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}
.vacancy-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(108, 19, 64, 0.08);
    border-color: #ba4073;
}
.vacancy-badge-banner {
    background: #f7d2df;
    color: #5b0f32;
    padding: 12px 14px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 1.55rem;
    text-align: center;
    line-height: 1.35;
    margin-bottom: 18px;
    min-height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.vacancy-card-body {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
.vacancy-title {
    font-size: 1.45rem;
    font-weight: 600;
    color: #1a1a2e;
    line-height: 1.5;
    margin-bottom: 24px;
    min-height: 64px;
}
.vacancy-meta-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}
.vacancy-meta-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    font-size: 1.3rem;
}
.vacancy-meta-item .meta-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 700;
    color: #444444;
    letter-spacing: 0.3px;
    font-size: 1.25rem;
}
.vacancy-meta-item .meta-icon {
    font-size: 1.7rem;
    color: #6c1340;
}
.vacancy-meta-item .meta-val {
    font-weight: 600;
    color: #222222;
    font-size: 1.35rem;
}
.vacancy-doc-link {
    color: #0d6efd;
    text-decoration: underline;
    font-size: 1.35rem;
    font-weight: 500;
    margin-bottom: 22px;
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    transition: color 0.2s;
}
.vacancy-doc-link:hover {
    color: #6c1340;
}
.vacancy-card-action {
    margin-top: auto;
}
.btn-view-documents {
    background: #fae4ed;
    color: #78194a;
    font-weight: 700;
    padding: 8px 18px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 1.2rem;
    display: inline-block;
    transition: background 0.2s, color 0.2s;
}
.btn-view-documents:hover {
    background: #6c1340;
    color: #ffffff;
}
</style>

<script>
function filterVacancies() {
    var search = (document.getElementById('vacancySearchInput').value || '').toLowerCase().trim();
    var category = (document.getElementById('vacancyCategoryFilter').value || 'all').toLowerCase();
    var cards = document.querySelectorAll('.vacancy-card');
    var visibleCount = 0;

    cards.forEach(function(card) {
        var cardCat = (card.getAttribute('data-category') || '').toLowerCase();
        var keywords = (card.getAttribute('data-keywords') || '').toLowerCase();
        var title = (card.querySelector('.vacancy-title') ? card.querySelector('.vacancy-title').innerText : '').toLowerCase();
        var badge = (card.querySelector('.vacancy-badge-banner') ? card.querySelector('.vacancy-badge-banner').innerText : '').toLowerCase();
        var combinedText = title + ' ' + badge + ' ' + keywords;

        var matchesSearch = !search || combinedText.indexOf(search) !== -1;
        var matchesCat = (category === 'all') || (cardCat === category);

        if (matchesSearch && matchesCat) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    var noResult = document.getElementById('noVacanciesFound');
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
