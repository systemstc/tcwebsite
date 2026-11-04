@extends('layouts.front')

@section('title', session('locale') == 'hi' ? 'संबंधित लिंक / पोर्टल | वस्त्र समिति' : 'Related Links & Portals | Textiles Committee')

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
                <span>{{ session('locale') == 'hi' ? 'संबंधित लिंक' : 'Related Links' }}</span>
            </div>
            <h1 class="inner-hero-title">
                {{ session('locale') == 'hi' ? 'संबंधित लिंक / पोर्टल' : 'Related Links' }}
            </h1>
        </div>
    </div>
</section>

<!-- Main Related Links Section -->
<main class="maincontent inner-page-main py-4 py-md-5">
    <div class="page-container">

        <!-- Search Bar matching User's Reference Screenshot -->
        <div class="related-links-search-wrap mb-4">
            <div class="search-input-box">
                <span class="search-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#500a2f" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
                <input type="text" id="relatedLinksSearchInput" class="search-field" placeholder="{{ session('locale') == 'hi' ? 'संबंधित लिंक खोजें...' : 'Search Related Links' }}" onkeyup="filterRelatedLinks()" autocomplete="off">
                <button type="button" id="clearSearchBtn" class="clear-btn d-none" onclick="clearRelatedSearch()" title="Clear">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div id="resultsCountNotice" class="search-count-text text-muted small mt-2">
                {{ session('locale') == 'hi' ? 'कुल ' . count($links) . ' पोर्टल लिंक उपलब्ध हैं' : 'Showing ' . count($links) . ' related portal links' }}
            </div>
        </div>

        <!-- Links Container -->
        <div class="related-links-list" id="relatedLinksContainer">
            @forelse($links as $link)
                @php
                    $title = session('locale') == 'hi' 
                        ? ($link->title_hi ?: $link->title_en) 
                        : ($link->title_en ?: $link->title_hi);
                    $target = $link->target ?: '_blank';
                @endphp
                <div class="related-link-card" data-title="{{ strtolower($link->title_en . ' ' . $link->title_hi . ' ' . $link->category) }}">
                    <div class="link-title-col">
                        <span class="link-title-text">{{ $title }}</span>
                    </div>
                    <div class="link-action-col">
                        <a href="{{ $link->url }}" target="{{ $target }}" rel="noopener noreferrer" class="visit-website-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="me-1">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                            <span>{{ session('locale') == 'hi' ? 'वेबसाइट देखें' : 'VISIT WEBSITE' }}</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 bg-white rounded border">
                    <p class="text-muted mb-0">{{ session('locale') == 'hi' ? 'कोई संबंधित लिंक उपलब्ध नहीं है।' : 'No related links recorded at this time.' }}</p>
                </div>
            @endforelse

            <!-- No Results Message for Search -->
            <div id="noLinksFoundAlert" class="text-center py-5 bg-white rounded border d-none">
                <i class="fa-solid fa-magnifying-glass fa-2x text-muted mb-2 d-block"></i>
                <p class="text-muted mb-1 fw-bold">{{ session('locale') == 'hi' ? 'कोई परिणाम नहीं मिला।' : 'No related links match your search.' }}</p>
                <small class="text-muted">{{ session('locale') == 'hi' ? 'कृपया अन्य कीवर्ड खोज कर देखें।' : 'Try searching with a different portal name.' }}</small>
            </div>
        </div>

    </div>
</main>

<style>
/* Related Links Styling - Pixel-accurate to reference screenshot */
.related-links-search-wrap {
    max-width: 380px;
}

.search-input-box {
    position: relative;
    display: flex;
    align-items: center;
    background: #ffffff;
    border: 1.5px solid #d88fa7;
    border-radius: 6px;
    padding: 0 14px;
    height: 44px;
    transition: all 0.2s ease;
}

.search-input-box:focus-within {
    border-color: #500a2f;
    box-shadow: 0 0 0 3px rgba(80, 10, 47, 0.12);
}

.search-input-box .search-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #500a2f;
    margin-right: 10px;
}

.search-input-box .search-field {
    border: none;
    outline: none;
    background: transparent;
    width: 100%;
    font-size: 14.5px;
    color: #1f2937;
}

.search-input-box .search-field::placeholder {
    color: #6b7280;
    font-weight: 400;
}

.search-input-box .clear-btn {
    border: none;
    background: transparent;
    color: #9ca3af;
    cursor: pointer;
    padding: 4px;
    font-size: 13px;
}

.search-input-box .clear-btn:hover {
    color: #500a2f;
}

/* Related Links Cards */
.related-links-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.related-link-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 16px 24px;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
}

.related-link-card:hover {
    border-color: #d88fa7;
    box-shadow: 0 4px 14px rgba(80, 10, 47, 0.06);
    transform: translateY(-1px);
}

.link-title-col {
    flex: 1;
    padding-right: 20px;
}

.link-title-text {
    font-size: 15.5px;
    font-weight: 500;
    color: #1f2937;
    line-height: 1.45;
}

/* VISIT WEBSITE Button matching screenshot */
.visit-website-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #fdf2f7;
    border: 1px solid #f6d5e3;
    border-radius: 6px;
    padding: 8px 18px;
    font-size: 12.5px;
    font-weight: 700;
    color: #500a2f;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    text-decoration: none !important;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.visit-website-btn:hover {
    background: #f7dbe9;
    border-color: #d88fa7;
    color: #3b0522;
    box-shadow: 0 2px 6px rgba(80, 10, 47, 0.12);
}

@media (max-width: 640px) {
    .related-links-search-wrap {
        max-width: 100%;
    }
    
    .related-link-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 18px;
    }
    
    .link-action-col {
        width: 100%;
    }
    
    .visit-website-btn {
        width: 100%;
    }
}
</style>

<script>
function filterRelatedLinks() {
    const input = document.getElementById('relatedLinksSearchInput');
    const clearBtn = document.getElementById('clearSearchBtn');
    const filter = (input ? input.value : '').toLowerCase().trim();
    
    if (clearBtn) {
        if (filter.length > 0) {
            clearBtn.classList.remove('d-none');
        } else {
            clearBtn.classList.add('d-none');
        }
    }

    const cards = document.querySelectorAll('.related-link-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const text = card.getAttribute('data-title') || '';
        if (filter === '' || text.includes(filter)) {
            card.classList.remove('d-none');
            visibleCount++;
        } else {
            card.classList.add('d-none');
        }
    });

    const noResultsAlert = document.getElementById('noLinksFoundAlert');
    const notice = document.getElementById('resultsCountNotice');

    if (noResultsAlert) {
        if (visibleCount === 0) {
            noResultsAlert.classList.remove('d-none');
        } else {
            noResultsAlert.classList.add('d-none');
        }
    }

    if (notice) {
        if (filter === '') {
            notice.innerText = `Showing ${visibleCount} related portal links`;
        } else {
            notice.innerText = `Found ${visibleCount} link${visibleCount === 1 ? '' : 's'} matching "${filter}"`;
        }
    }
}

function clearRelatedSearch() {
    const input = document.getElementById('relatedLinksSearchInput');
    if (input) {
        input.value = '';
        filterRelatedLinks();
        input.focus();
    }
}
</script>
@endsection
