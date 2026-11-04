@extends('layouts.front')

@section('title', session('locale') == 'hi' ? 'सरकारी प्रायोजित योजनाएं | वस्त्र समिति' : 'Govt. Sponsored Schemes | Textiles Committee')

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
            <path d="M 430,240 C 640,190 840,130 1060,100 C 1280,70 1480,80 1600,120" stroke="rgba(255, 120, 180, 0.35)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
        </svg>
    </div>

    <div class="page-container inner-hero-container">
        <div class="inner-hero-content">
            <div class="inner-breadcrumb-text">
                <a href="{{ route('home') }}">{{ session('locale') == 'hi' ? 'मुख्य पृष्ठ' : 'Home' }}</a>
                <span class="mx-1">/</span>
                <span>{{ session('locale') == 'hi' ? 'सेवाएं एवं योजनाएं' : 'Offerings' }}</span>
                <span class="mx-1">/</span>
                <span>{{ session('locale') == 'hi' ? 'सरकारी प्रायोजित योजनाएं' : 'Govt. Sponsored Schemes' }}</span>
            </div>
            <h1 class="inner-hero-title">
                {{ session('locale') == 'hi' ? 'सरकारी प्रायोजित योजनाएं' : 'Govt. Sponsored Schemes' }}
            </h1>
        </div>

        <!-- In-Banner Sub-Navigation Pill Bar -->
        @if(isset($navPills) && $navPills->count() > 1)
        <div class="inner-pill-bar-wrap">
            <nav class="inner-pill-bar" aria-label="Sub Navigation">
                @foreach($navPills as $sib)
                    <a href="{{ $sib->url }}" class="inner-pill-link {{ !empty($sib->is_active) ? 'active' : '' }}">
                        @if(!empty($sib->is_active))
                            <span class="material-symbols-outlined inner-pill-icon" aria-hidden="true">drag_indicator</span>
                        @endif
                        <span>{{ session('locale') == 'hi' ? ($sib->title_hi ?? $sib->title_en) : $sib->title_en }}</span>
                    </a>
                @endforeach
            </nav>
        </div>
        @endif
    </div>
</section>

<!-- Main Schemes Content Section -->
<main class="maincontent inner-page-main py-4 py-md-5">
    <div class="page-container">

        <!-- Top Controls / Filter Bar matching Image 1 -->
        <div class="schemes-filter-bar mb-4">
            <div class="schemes-search-wrap">
                <span class="material-symbols-outlined search-icon">search</span>
                <input type="text" id="schemeSearchInput" class="schemes-search-input" placeholder="Search..." onkeyup="filterSchemes()">
            </div>

            <div class="schemes-controls-right">
                <div class="schemes-dropdown-wrap">
                    <span class="material-symbols-outlined dropdown-icon">filter_list</span>
                    <select id="schemeCategoryFilter" class="schemes-select" onchange="filterSchemes()">
                        <option value="all">Category</option>
                        <option value="all">All Categories</option>
                        @php
                            $uniqueCategories = $schemes->pluck('category')->filter()->unique();
                        @endphp
                        @foreach($uniqueCategories as $cat)
                            <option value="{{ strtolower($cat) }}">{{ ucwords(str_replace(['-', '_'], ' ', $cat)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="schemes-dropdown-wrap">
                    <span class="material-symbols-outlined dropdown-icon">view_list</span>
                    <select id="schemePageSize" class="schemes-select">
                        <option value="10">10 per page</option>
                        <option value="20">20 per page</option>
                        <option value="all">All</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- 2-Column Scheme Cards Grid (100% Dynamic from Admin Schemes) -->
        <div class="schemes-cards-grid" id="schemesGrid">
            @forelse($schemes as $scheme)
                @php
                    $title = session('locale') == 'hi' ? ($scheme->title_hi ?: $scheme->title_en) : ($scheme->title_en ?: $scheme->title_hi);
                    $desc = session('locale') == 'hi' ? ($scheme->description_hi ?: $scheme->description_en) : ($scheme->description_en ?: $scheme->description_hi);
                    
                    // Determine banner image
                    $bannerUrl = asset('assets/images/govt_schemes_bg.jpg');
                    if (!empty($scheme->guidelines_doc)) {
                        $bannerUrl = str_starts_with($scheme->guidelines_doc, 'http') ? $scheme->guidelines_doc : asset($scheme->guidelines_doc);
                    }
                    
                    // Target Link
                    $linkUrl = !empty($scheme->link_url) && $scheme->link_url !== '#' ? $scheme->link_url : url('page/govt-sponsored-scheme');
                    $categorySlug = strtolower(trim($scheme->category ?: 'general'));
                @endphp
                <div class="scheme-card" data-category="{{ $categorySlug }}" data-keywords="{{ strtolower($scheme->title_en . ' ' . $scheme->title_hi . ' ' . $scheme->category) }}">
                    <div class="scheme-banner-wrap">
                        <img src="{{ $bannerUrl }}" alt="{{ $title }}" class="scheme-banner-img" onerror="this.src='{{ asset('assets/images/govt_schemes_bg.jpg') }}'">
                    </div>
                    <div class="scheme-card-body">
                        <h2 class="scheme-card-title">{{ $title }}</h2>
                        <p class="scheme-card-desc">
                            {{ $desc }}
                        </p>
                        <div class="scheme-card-footer">
                            <a href="{{ $linkUrl }}" class="scheme-arrow-btn" title="View Details">
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <span class="material-symbols-outlined" style="font-size: 54px; color: #ba4073;">info</span>
                    <h3 class="h4 mt-3 text-dark fw-bold">No active schemes currently available.</h3>
                    <p class="text-muted" style="font-size: 1.5rem;">New schemes will appear here once added in the administrative portal.</p>
                </div>
            @endforelse
        </div>

        <!-- No Results Fallback -->
        <div id="noSchemesFound" class="text-center py-5 d-none">
            <span class="material-symbols-outlined" style="font-size: 48px; color: #ba4073;">search_off</span>
            <h3 class="h4 mt-3 text-dark fw-bold">No schemes found matching your search.</h3>
            <p class="text-muted" style="font-size: 1.5rem;">Try adjusting your keywords or category filter.</p>
        </div>

    </div>
</main>

<style>
/* Filter Bar Styles (Matching Image 1) */
.schemes-filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}
.schemes-search-wrap {
    position: relative;
    flex: 1;
    max-width: 320px;
    min-width: 220px;
}
.schemes-search-wrap .search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #c0517f;
    font-size: 2.1rem;
    pointer-events: none;
}
.schemes-search-input {
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
.schemes-search-input:focus {
    border-color: #6c1340;
    box-shadow: 0 0 0 3px rgba(108, 19, 64, 0.12);
}
.schemes-controls-right {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.schemes-dropdown-wrap {
    position: relative;
    display: inline-flex;
    align-items: center;
}
.schemes-dropdown-wrap .dropdown-icon {
    position: absolute;
    left: 12px;
    color: #c0517f;
    font-size: 2rem;
    pointer-events: none;
}
.schemes-select {
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
.schemes-select:focus {
    border-color: #6c1340;
}

/* 2-Column Cards Grid (Matching Image 1) */
.schemes-cards-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 28px;
}
@media (max-width: 860px) {
    .schemes-cards-grid {
        grid-template-columns: 1fr;
    }
    .schemes-search-wrap {
        max-width: 100%;
    }
}

.scheme-card {
    background: #ffffff;
    border: 1px solid #e7d5df;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
}
.scheme-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(108, 19, 64, 0.1);
    border-color: #c0517f;
}
.scheme-banner-wrap {
    width: 100%;
    height: 220px;
    overflow: hidden;
    background: #faf4f7;
    position: relative;
}
.scheme-banner-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}
.scheme-card:hover .scheme-banner-img {
    transform: scale(1.02);
}
.scheme-card-body {
    padding: 24px 26px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}
.scheme-card-title {
    font-size: 1.85rem;
    font-weight: 700;
    color: #1a1a2e;
    line-height: 1.35;
    margin-bottom: 14px;
}
.scheme-card-desc {
    font-size: 1.45rem;
    color: #555566;
    line-height: 1.6;
    margin-bottom: 22px;
    flex-grow: 1;
}
.scheme-card-footer {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-top: auto;
}
.scheme-arrow-btn {
    width: 44px;
    height: 38px;
    background: #f7d2df;
    color: #6c1340;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 2.1rem;
    font-weight: bold;
    text-decoration: none;
    transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
}
.scheme-arrow-btn:hover {
    background: #6c1340;
    color: #ffffff;
    transform: translateX(4px);
}
</style>

<script>
function filterSchemes() {
    var search = (document.getElementById('schemeSearchInput').value || '').toLowerCase().trim();
    var category = (document.getElementById('schemeCategoryFilter').value || 'all').toLowerCase();
    var cards = document.querySelectorAll('.scheme-card');
    var visibleCount = 0;

    cards.forEach(function(card) {
        var cardCat = (card.getAttribute('data-category') || '').toLowerCase();
        var keywords = (card.getAttribute('data-keywords') || '').toLowerCase();
        var title = (card.querySelector('.scheme-card-title') ? card.querySelector('.scheme-card-title').innerText : '').toLowerCase();
        var desc = (card.querySelector('.scheme-card-desc') ? card.querySelector('.scheme-card-desc').innerText : '').toLowerCase();
        var combinedText = title + ' ' + desc + ' ' + keywords;

        var matchesSearch = !search || combinedText.indexOf(search) !== -1;
        var matchesCat = (category === 'all') || (cardCat === category);

        if (matchesSearch && matchesCat) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    var noResult = document.getElementById('noSchemesFound');
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
