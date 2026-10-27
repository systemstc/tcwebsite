@extends('layouts.front')

@section('title', session('locale') == 'hi' ? ($page->title_hi ?: $page->title_en) : ($page->title_en ?: $page->title_hi))

@section('content')
<!-- 1. OFFICIAL MAROON CURVED HERO BANNER (Matching texmin.gov.in) -->
<section class="inner-hero-banner">
    <!-- SVG Fluid Wavy Glow & Dot-Matrix Contour Lines -->
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
            
            <!-- Fluid luminous wave fill -->
            <path d="M 450,0 C 700,60 920,180 1250,110 C 1420,70 1520,130 1600,160 L 1600,240 L 450,240 Z" fill="url(#waveFill)"/>
            <path d="M 520,0 C 760,70 980,190 1300,120 C 1450,85 1540,140 1600,170" stroke="url(#glowWave)" stroke-width="4" fill="none"/>
            
            <!-- Sweeping concentric dot-matrix arcs (exact to texmin reference) -->
            <path d="M 380,240 C 580,210 760,160 980,130 C 1200,100 1420,110 1600,150" stroke="rgba(255, 80, 150, 0.45)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            <path d="M 400,240 C 610,200 800,145 1020,115 C 1240,85 1450,95 1600,135" stroke="rgba(255, 100, 170, 0.4)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            <path d="M 430,240 C 640,190 840,130 1060,100 C 1280,70 1480,80 1600,120" stroke="rgba(255, 120, 180, 0.35)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            <path d="M 470,240 C 670,180 880,115 1100,85 C 1310,55 1510,65 1600,105" stroke="rgba(255, 140, 190, 0.3)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            <path d="M 510,240 C 710,170 920,100 1140,70 C 1340,40 1530,50 1600,90" stroke="rgba(255, 160, 200, 0.25)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            <path d="M 560,240 C 750,160 960,85 1180,55 C 1380,28 1560,38 1600,75" stroke="rgba(255, 180, 210, 0.2)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            <path d="M 620,240 C 800,150 1010,72 1230,42 C 1420,16 1580,26 1600,60" stroke="rgba(255, 200, 220, 0.16)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            <path d="M 690,240 C 860,140 1070,60 1280,30 C 1460,5 1590,14 1600,45" stroke="rgba(255, 220, 230, 0.12)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            
            <!-- Secondary gentle counter-wave dots -->
            <path d="M 500,0 C 750,50 1000,130 1250,150 C 1450,165 1550,185 1600,205" stroke="rgba(255, 100, 160, 0.3)" stroke-width="2" stroke-dasharray="2 14" fill="none"/>
            <path d="M 550,0 C 800,40 1040,115 1290,135 C 1480,150 1570,170 1600,190" stroke="rgba(255, 120, 170, 0.25)" stroke-width="2" stroke-dasharray="2 14" fill="none"/>
            <path d="M 600,0 C 850,30 1080,100 1330,120 C 1510,135 1585,155 1600,175" stroke="rgba(255, 140, 180, 0.2)" stroke-width="2" stroke-dasharray="2 14" fill="none"/>
        </svg>
    </div>

    <div class="page-container inner-hero-container">
        <div class="inner-hero-content">
            <div class="inner-breadcrumb-text">
                <a href="{{ route('home') }}">{{ session('locale') == 'hi' ? 'मुख्य पृष्ठ' : 'Home' }}</a>
                <span class="mx-1">/</span>
                @if(isset($breadcrumbParent))
                    @php
                        $parentTitle = session('locale') == 'hi' 
                            ? ($breadcrumbParent->title_hi ?: $breadcrumbParent->title_en) 
                            : ($breadcrumbParent->title_en ?: $breadcrumbParent->title_hi);
                    @endphp
                    <span class="text-capitalize">{{ $parentTitle }}</span>
                @elseif($page->menu_location && $page->menu_location !== 'none')
                    @php
                        $locMap = [
                            'ministry' => (session('locale') == 'hi' ? 'मंत्रालय' : 'Ministry'),
                            'offerings' => (session('locale') == 'hi' ? 'सेवाएं एवं योजनाएं' : 'Offerings'),
                            'documents' => (session('locale') == 'hi' ? 'दस्तावेज़ एवं प्रकाशन' : 'Documents'),
                            'media' => (session('locale') == 'hi' ? 'मीडिया' : 'Media'),
                        ];
                        $locTitle = $locMap[$page->menu_location] ?? ucfirst($page->menu_location);
                    @endphp
                    <span class="text-capitalize">{{ $locTitle }}</span>
                @else
                    <span>{{ session('locale') == 'hi' ? 'पृष्ठ' : 'Page' }}</span>
                @endif
            </div>
            <h1 class="inner-hero-title">
                {{ session('locale') == 'hi' ? ($page->title_hi ?: $page->title_en) : ($page->title_en ?: $page->title_hi) }}
            </h1>
        </div>

        <!-- 2. IN-BANNER SUB-NAVIGATION PILL BAR (Exact match to texmin reference screenshot) -->
        @php
            $pillsToRender = isset($navPills) && $navPills->count() ? $navPills : (isset($siblingPages) ? $siblingPages : collect());
        @endphp
        @if($pillsToRender->count() > 1)
        <div class="inner-pill-bar-wrap">
            <nav class="inner-pill-bar" aria-label="Sub Navigation">
                @foreach($pillsToRender as $sib)
                    @php
                        $sibTitle = session('locale') == 'hi' ? ($sib->title_hi ?: $sib->title_en) : ($sib->title_en ?: $sib->title_hi);
                        $sibUrl = !empty($sib->url) ? $sib->url : (isset($sib->slug) && $sib->slug ? route('page.show', $sib->slug) : '#');
                        $isActive = !empty($sib->is_active);
                    @endphp
                    <a href="{{ $sibUrl }}" class="inner-pill-link {{ $isActive ? 'active' : '' }}" {!! $isActive ? 'aria-current="page"' : '' !!}>
                        @if($isActive)
                            <span class="material-symbols-outlined inner-pill-icon" aria-hidden="true">drag_indicator</span>
                        @endif
                        <span>{{ $sibTitle }}</span>
                    </a>
                @endforeach
            </nav>
        </div>
        @endif
    </div>
</section>

<!-- 3. MAIN PAGE CONTENT CONTAINER -->
<main class="maincontent inner-page-main">
    <div class="container mt-4">
        @php
            $contentHtml = session('locale') == 'hi' 
                ? ($page->content_hi ?: $page->content_en) 
                : ($page->content_en ?: $page->content_hi);

            // Auto-resolve relative asset and upload URLs for subfolder installations (e.g. /tcwebsite/public)
            if (!empty($contentHtml)) {
                $contentHtml = preg_replace('/src="\/assets\//i', 'src="' . asset('assets') . '/', $contentHtml);
                $contentHtml = preg_replace('/src="\/uploads\//i', 'src="' . asset('uploads') . '/', $contentHtml);
                
                // Auto-resolve form actions like action="/inquiry" to proper route and inject CSRF token
                if (str_contains($contentHtml, '<form')) {
                    $contentHtml = preg_replace('/action="(\/tcwebsite\/public)?\/inquiry"/i', 'action="' . route('inquiry.submit') . '"', $contentHtml);
                    if (!str_contains($contentHtml, 'name="_token"')) {
                        $contentHtml = preg_replace('/(<form\b[^>]*>)/i', '$1' . "\n" . '<input type="hidden" name="_token" value="' . csrf_token() . '">', $contentHtml);
                    }
                }
            }
        @endphp

        @if(!empty(trim($contentHtml)))
            {!! $contentHtml !!}
        @else
            <div class="alert alert-info py-4 my-4">
                <i class="fa fa-info-circle me-2"></i> This page content is currently being updated. Please check back shortly.
            </div>
        @endif
    </div>
</main>

<style>
    /* Strictly Read-Only Frontend Protection */
    [contenteditable], [contenteditable="true"], [contenteditable="false"] {
        -webkit-user-modify: read-only !important;
        user-modify: read-only !important;
        user-select: text !important;
        cursor: default !important;
        outline: none !important;
    }
    .editor-pro-table-ctrl, .editor-img-ctrl, .editor-img-ctrl.d-flex, .editor-table-ctrl,
    .editor-table-btn, .editor-img-btn, .editor-doc-btn, .editor-avatar-btn, .editor-faq-btn,
    .section-action-overlay, .editor-floating-toolbar, .component-resize-handle, .drop-indicator-line {
        display: none !important;
    }
    .dbim-image-with-text-wrapper {
        border-color: #ebd0de !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 14px rgba(114, 24, 53, 0.04) !important;
        transition: all 0.25s ease;
    }
    .dbim-image-with-text-wrapper:hover {
        border-color: #d19bb8 !important;
        box-shadow: 0 6px 20px rgba(114, 24, 53, 0.08) !important;
    }

    /* ============================================================
       OFFICIAL TEXMIN INNER HERO BANNER & SUB-NAV STYLING
       ============================================================ */
    .inner-hero-banner {
        background: radial-gradient(circle at 65% 35%, #7a154a 0%, #520b31 45%, #38051e 100%), #38051e;
        position: relative;
        padding: 44px 0 0;
        overflow: hidden;
    }
    .inner-hero-graphic {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
        overflow: hidden;
    }
    .inner-hero-graphic svg {
        width: 100%;
        height: 100%;
        display: block;
    }
    .inner-hero-container {
        position: relative;
        z-index: 2;
    }
    .inner-hero-content {
        margin-bottom: 24px;
    }
    .inner-hero-banner .inner-breadcrumb-text,
    .inner-hero-banner .inner-breadcrumb-text * {
        font-size: 1.45rem;
        font-family: 'Noto Sans', sans-serif;
        color: rgba(255, 255, 255, 0.88) !important;
        margin-bottom: 8px;
    }
    .inner-hero-banner .inner-breadcrumb-text a {
        color: rgba(255, 255, 255, 0.95) !important;
        text-decoration: none !important;
        transition: color 0.15s;
    }
    .inner-hero-banner .inner-breadcrumb-text a:hover {
        color: #ffffff !important;
        text-decoration: underline !important;
    }
    .inner-hero-banner .inner-hero-title,
    h1.inner-hero-title,
    .inner-hero-title {
        color: #ffffff !important;
        font-size: 3.4rem !important;
        font-weight: 700 !important;
        font-family: 'Noto Sans', sans-serif !important;
        margin: 0 !important;
        letter-spacing: -0.3px;
        line-height: 1.25;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.25);
    }

    /* Sub-nav Pill Bar (Exact match to texmin reference screenshot) */
    .inner-pill-bar-wrap {
        display: block;
        margin-top: 24px;
        margin-bottom: -1px;
        position: relative;
        z-index: 10;
    }
    .inner-pill-bar {
        background: #500a2f;
        border-radius: 12px 12px 0 0;
        padding: 6px 10px 0;
        display: inline-flex;
        align-items: center;
        gap: 2px;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.12);
        max-width: 100%;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
    }
    .inner-pill-bar::-webkit-scrollbar {
        display: none;
    }
    .inner-hero-banner .inner-pill-link,
    a.inner-pill-link,
    .inner-pill-link {
        color: #f1e1ea !important;
        text-decoration: none !important;
        font-size: 1.55rem !important;
        font-family: 'Noto Sans', sans-serif !important;
        font-weight: 500 !important;
        padding: 10px 18px !important;
        border-radius: 8px 8px 0 0 !important;
        transition: all 0.15s;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
    }
    .inner-hero-banner .inner-pill-link:hover,
    a.inner-pill-link:hover,
    .inner-pill-link:hover {
        color: #ffffff !important;
        background: rgba(255, 255, 255, 0.12) !important;
    }
    .inner-hero-banner .inner-pill-link.active,
    a.inner-pill-link.active,
    .inner-pill-link.active {
        color: #ffffff !important;
        background: rgba(255, 255, 255, 0.18) !important;
        font-weight: 700 !important;
    }
    .inner-hero-banner .inner-pill-icon,
    .inner-pill-icon {
        font-size: 1.9rem !important;
        line-height: 1 !important;
        color: #ffffff !important;
        opacity: 0.95;
    }

    /* Main Content Wrapper */
    .inner-page-main {
        background-color: #ffffff;
        padding: 44px 0 70px;
    }

    /* ============================================================
       DBIM MINISTRY TEMPLATE STYLES (.visionbox, .objectivebox, .box, tables)
       ============================================================ */
    @media (min-width: 992px) {
        .stickyBox {
            position: -webkit-sticky !important;
            position: sticky !important;
            top: 2rem !important;
            height: -moz-fit-content !important;
            height: fit-content !important;
            z-index: 10;
        }
    }
    @media (max-width: 991.5px) {
        .stickyBox {
            position: relative !important;
            top: 0 !important;
            margin-bottom: 2rem;
        }
    }

    .visionbox {
        background: #ebeaea !important;
        border-radius: 12px !important;
        padding: 32px 28px !important;
        border: 1px solid rgba(80, 10, 47, 0.08) !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03) !important;
    }
    .visionbox h2,
    .visionbox .h2 {
        color: #500a2f !important;
        font-size: 2.2rem !important;
        font-style: normal !important;
        font-weight: 600 !important;
        line-height: 1.55 !important;
        margin-bottom: 24px !important;
        text-align: justify !important;
        font-family: 'Noto Sans', sans-serif !important;
    }
    .visionbox p,
    .visionbox .h4 {
        color: #500a2f !important;
        font-size: 1.35rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.8px !important;
        text-transform: uppercase !important;
        margin: 0 !important;
        font-family: 'Noto Sans', sans-serif !important;
    }

    .aboutcontent {
        font-family: 'Noto Sans', sans-serif !important;
        color: #150202 !important;
    }
    .aboutcontent p {
        font-size: 1.65rem !important;
        line-height: 1.85 !important;
        color: #150202 !important;
        margin-bottom: 1.4rem !important;
        text-align: justify !important;
    }
    .aboutcontent h2,
    .aboutcontent .h2 {
        color: #500a2f !important;
        font-size: 2.5rem !important;
        font-weight: 700 !important;
        line-height: 1.3 !important;
        letter-spacing: -0.2px !important;
        margin-top: 2rem !important;
        margin-bottom: 1rem !important;
        font-family: 'Noto Sans', sans-serif !important;
    }
    .aboutcontent h3,
    .aboutcontent .h3 {
        color: #500a2f !important;
        font-size: 2.0rem !important;
        font-weight: 700 !important;
        margin-top: 1.5rem !important;
        margin-bottom: 0.8rem !important;
    }

    /* DBIM 3-Outcome Cards */
    .objectivebox {
        border-radius: 12px !important;
        background: #ebd0de !important;
        padding: 22px 20px !important;
        margin-bottom: 20px !important;
        height: 100% !important;
        border: 1px solid rgba(80, 10, 47, 0.12) !important;
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
    }
    .objectivebox:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(80, 10, 47, 0.1);
    }
    .objectivebox h3,
    .objectivebox .h3 {
        color: #500a2f !important;
        font-size: 3.6rem !important;
        font-weight: 700 !important;
        line-height: 1 !important;
        margin-bottom: 12px !important;
        font-family: 'Noto Sans', sans-serif !important;
    }
    .objectivebox p {
        color: #2b1320 !important;
        font-size: 1.55rem !important;
        line-height: 1.65 !important;
        margin-bottom: 0 !important;
        text-align: left !important;
    }

    /* DBIM Document Download Rows (.box) */
    .box {
        border-radius: 8px !important;
        border: 1px solid #ebd0de !important;
        background: #ffffff !important;
        padding: 16px 20px !important;
        margin-bottom: 14px !important;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.02) !important;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .box:hover {
        border-color: #500a2f !important;
        box-shadow: 0 4px 14px rgba(80, 10, 47, 0.08) !important;
    }
    .box p {
        margin-bottom: 0 !important;
        font-size: 1.6rem !important;
        color: #150202 !important;
        font-weight: 600 !important;
        line-height: 1.5 !important;
    }
    .box .material-symbols-outlined {
        color: #500a2f !important;
        font-size: 2.4rem !important;
    }
    .type-size small {
        color: #666666 !important;
        font-size: 1.3rem !important;
        font-weight: 600 !important;
        background: #f7eef3;
        padding: 4px 10px;
        border-radius: 4px;
        border: 1px solid #e8d0dd;
    }

    /* Official Ministry Action Buttons */
    .download-btn,
    .link-btn {
        padding: 8px 18px !important;
        gap: 8px !important;
        border: 1px solid #ebd0de !important;
        outline: none !important;
        background: #faebf2 !important;
        border-radius: 6px !important;
        color: #500a2f !important;
        font-size: 1.35rem !important;
        font-weight: 700 !important;
        line-height: 18px !important;
        letter-spacing: 0.3px !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.2s ease !important;
    }
    .download-btn .material-symbols-outlined,
    .link-btn .material-symbols-outlined {
        font-size: 1.8rem !important;
        color: #500a2f !important;
        transition: color 0.2s;
    }
    .download-btn:hover,
    .link-btn:hover {
        background: #500a2f !important;
        color: #ffffff !important;
        border-color: #500a2f !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(80, 10, 47, 0.2) !important;
    }
    .download-btn:hover .material-symbols-outlined,
    .link-btn:hover .material-symbols-outlined {
        color: #ffffff !important;
    }
    .w-ft {
        width: -moz-fit-content !important;
        width: fit-content !important;
    }

    /* Ministry Standard Table Styles */
    .table-responsive {
        border-radius: 10px;
        border: 1px solid #ebd0de;
        overflow: hidden;
        margin: 20px 0 28px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
    .texmin-table,
    .table {
        margin-bottom: 0 !important;
        border-collapse: collapse !important;
        font-family: 'Noto Sans', sans-serif !important;
    }
    .texmin-table thead th,
    .table thead th {
        background-color: #500a2f !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        font-size: 1.55rem !important;
        letter-spacing: 0.4px !important;
        text-transform: uppercase !important;
        padding: 16px 18px !important;
        border: none !important;
        vertical-align: middle !important;
    }
    .texmin-table tbody td,
    .table tbody td {
        font-size: 1.55rem !important;
        line-height: 1.6 !important;
        color: #2b1320 !important;
        padding: 16px 18px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f1e2eb !important;
        border-top: none !important;
    }
    .texmin-table tbody tr:nth-of-type(even),
    .table tbody tr:nth-of-type(even) {
        background-color: #fdf6f9 !important;
    }
    .texmin-table tbody tr:hover,
    .table tbody tr:hover {
        background-color: #f8e5ef !important;
    }

    /* ============================================================
       ABOUT US 2-COLUMN LAYOUT (Exact to user reference)
       ============================================================ */
    .about-page-layout {
        display: flex;
        gap: 40px;
        align-items: flex-start;
    }
    @media (max-width: 991px) {
        .about-page-layout {
            flex-direction: column;
            gap: 28px;
        }
    }

    /* Right Main Column */
    .about-main-col {
        flex: 1;
        min-width: 0;
        font-family: 'Noto Sans', sans-serif;
    }
    .about-lead-para {
        font-size: 1.65rem !important;
        line-height: 1.85;
        color: #150202;
        margin-bottom: 22px;
        text-align: justify;
    }
    .about-mission-heading {
        color: #1a1a1a;
        font-size: 2.4rem !important;
        font-weight: 700;
        margin-top: 28px;
        margin-bottom: 14px;
        font-family: 'Noto Sans', sans-serif;
    }
    .about-mission-list {
        padding-left: 20px;
        margin: 0;
    }
    .about-mission-list li {
        font-size: 1.65rem !important;
        line-height: 1.8;
        color: #150202;
        margin-bottom: 12px;
        text-align: justify;
    }

    /* ============================================================
       OUR TEAM HIERARCHY FLOWCHART & DIRECTORY TABLE STYLES
       ============================================================ */
    .team-org-container {
        background-color: #fbf5f8;
        border-radius: 16px;
        padding: 40px 24px 30px;
        box-shadow: 0 2px 12px rgba(108, 19, 64, 0.04);
        border: 1px solid rgba(108, 19, 64, 0.08);
    }
    .team-tree {
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 480px;
        margin: 0 auto;
    }
    .team-node-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 42px 28px 24px;
        position: relative;
        text-align: center;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.06);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .team-node-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(108, 19, 64, 0.12);
    }
    .team-avatar-wrap {
        position: absolute;
        top: -38px;
        left: 50%;
        transform: translateX(-50%);
        width: 76px;
        height: 76px;
        border-radius: 50%;
        background: #ffffff;
        padding: 3px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.14);
        overflow: hidden;
    }
    .team-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        display: block;
    }
    .team-node-role {
        font-size: 1.5rem !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #9c2759;
        margin-bottom: 6px;
        font-family: 'Noto Sans', sans-serif;
    }
    .team-node-name {
        font-size: 2.0rem !important;
        font-weight: 700;
        color: #1a1a1a;
        font-family: 'Noto Sans', sans-serif;
    }
    .team-tree-line {
        width: 2px;
        height: 48px;
        background-color: #d8c0cc;
        margin: 0 auto;
    }

    /* Download pill buttons inside card */
    .team-download-bar {
        margin-top: 36px;
        padding-top: 24px;
        border-top: 1px solid rgba(108, 19, 64, 0.12);
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }
    .team-dl-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        border: 1.5px solid #a3245f;
        color: #721835;
        font-size: 1.55rem !important;
        font-weight: 700;
        letter-spacing: 0.3px;
        padding: 10px 22px;
        border-radius: 8px;
        text-decoration: none !important;
        transition: all 0.2s;
        box-shadow: 0 2px 6px rgba(114, 24, 53, 0.08);
        font-family: 'Noto Sans', sans-serif;
    }
    .team-dl-btn:hover {
        background: #721835;
        color: #ffffff;
    }
    .team-dl-btn:hover .text-danger {
        color: #ffffff !important;
    }

    /* Contact Directory Table */
    .team-directory-container {
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    .team-dir-header {
        background: linear-gradient(90deg, #821546 0%, #630c33 100%);
        color: #ffffff;
        font-size: 1.85rem !important;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 16px 22px;
        display: flex;
        align-items: center;
        font-family: 'Noto Sans', sans-serif;
    }
    .team-dir-table {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }
    .team-dir-table thead th {
        background: #faf4f7;
        color: #7a1e4a;
        font-weight: 700;
        font-size: 1.55rem !important;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-bottom: 2px solid #ecd5e1;
        padding: 16px 20px;
        font-family: 'Noto Sans', sans-serif;
    }
    .team-dir-table tbody td {
        padding: 16px 20px;
        vertical-align: middle;
        font-size: 1.6rem !important;
        border-bottom: 1px solid #f1edf0;
        font-family: 'Noto Sans', sans-serif;
    }
    .team-dir-table tbody tr:last-child td {
        border-bottom: none;
    }
    .team-dir-table tbody tr:hover td {
        background-color: #fdfafd;
    }
    .dir-contact-item {
        font-size: 1.55rem !important;
        color: #2b2b2b;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
    }
    .dir-addr-item {
        font-size: 1.55rem !important;
        color: #333333;
        line-height: 1.55;
    }

    @media (max-width: 575px) {
        .inner-hero-banner {
            padding: 28px 0 38px;
        }
        .inner-hero-title {
            font-size: 2.6rem;
        }
        .inner-pill-bar {
            width: 100%;
        }
        .inner-pill-link {
            font-size: 1.45rem !important;
            padding: 8px 14px;
        }
        .team-org-container {
            padding: 30px 14px 20px;
        }
        .team-node-card {
            padding: 38px 16px 20px;
        }
        .team-node-name {
            font-size: 1.65rem;
        }
        .team-download-bar {
            flex-direction: column;
        }
    }

    /* ============================================================
       ACTS, REGULATIONS & ORGANISATIONS DIRECTORY STYLES
       ============================================================ */
    .acts-toolbar {
        background: #ffffff;
        padding: 14px 0 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }
    .acts-search-box {
        position: relative;
        flex: 1;
        min-width: 260px;
        max-width: 380px;
    }
    .acts-search-box i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        font-size: 14px;
    }
    .acts-search-input {
        width: 100%;
        padding: 10px 16px 10px 42px;
        border: 1px solid #d9d9d9;
        border-radius: 6px;
        font-size: 1.55rem !important;
        outline: none;
        transition: border-color 0.2s;
    }
    .acts-search-input:focus {
        border-color: #721835;
        box-shadow: 0 0 0 2px rgba(114, 24, 53, 0.1);
    }
    .acts-filter-group {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .acts-select {
        padding: 10px 18px;
        border: 1px solid #d9d9d9;
        border-radius: 6px;
        font-size: 1.55rem !important;
        color: #444;
        background-color: #fff;
    }

    /* Grid of Cards */
    .acts-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 22px;
        margin-top: 10px;
    }
    @media (max-width: 768px) {
        .acts-grid {
            grid-template-columns: 1fr;
        }
    }
    .acts-card {
        background: #ffffff;
        border: 1px solid #e8e8ed;
        border-radius: 12px;
        padding: 24px 26px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.2s ease;
        box-shadow: 0 1px 4px rgba(0,0,0,0.02);
        position: relative;
    }
    .acts-card:hover {
        border-color: #c499b3;
        box-shadow: 0 6px 18px rgba(114, 24, 53, 0.08);
        transform: translateY(-2px);
    }
    .acts-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 14px;
    }
    .acts-card-title {
        font-size: 1.85rem !important;
        font-weight: 700;
        color: #721835;
        margin: 0;
        line-height: 1.35;
        font-family: 'Noto Sans', sans-serif;
    }
    .acts-card-title a {
        color: #721835;
        text-decoration: none;
    }
    .acts-card-title a:hover {
        text-decoration: underline;
    }
    .acts-card-img-wrap {
        flex: 0 0 110px;
        height: 64px;
        background: #fafafa;
        border: 1px solid #eee;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 4px;
    }
    .acts-card-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .acts-card-desc {
        font-size: 1.6rem !important;
        line-height: 1.75;
        color: #444444;
        margin-bottom: 18px;
        text-align: justify;
        font-family: 'Noto Sans', sans-serif;
    }
    .acts-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 14px;
        border-top: 1px dashed #f0e6ed;
    }
    .acts-pdf-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #721835;
        font-size: 1.5rem !important;
        font-weight: 700;
        text-decoration: none !important;
        background: #fdf5f8;
        padding: 8px 16px;
        border-radius: 6px;
        border: 1px solid #ebd0de;
        transition: all 0.2s;
    }
    .acts-pdf-badge:hover {
        background: #721835;
        color: #ffffff;
    }
    .acts-pdf-badge:hover i {
        color: #ffffff !important;
    }
    .acts-arrow-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #f7dbe7;
        color: #721835;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none !important;
        transition: all 0.2s;
        font-size: 14px;
    }
    .acts-arrow-btn:hover {
        background: #721835;
        color: #ffffff;
        transform: translateX(3px);
    }

    /* ============================================================
       SERVICES / OFFERINGS SPECIFIC STYLING (texmin.gov.in style)
       ============================================================ */
    .services-overview-banner {
        background: #fdf6f9;
        border: 1px solid #ebdbe2;
        border-left: 5px solid #6c1340;
        border-radius: 8px;
        padding: 22px 28px;
        margin-bottom: 32px;
    }
    .services-overview-banner p {
        font-size: 1.65rem !important;
        line-height: 1.85;
        color: #150202;
        margin: 0;
        font-family: 'Noto Sans', sans-serif;
    }
    .svc-badge {
        display: inline-block;
        background: #6c1340;
        color: #ffffff;
        font-size: 1.45rem !important;
        font-weight: 700;
        padding: 5px 14px;
        border-radius: 4px;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .svc-feature-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-top: 24px;
    }
    @media (max-width: 991px) {
        .svc-feature-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 640px) {
        .svc-feature-grid {
            grid-template-columns: 1fr;
        }
    }
    .svc-feature-card {
        background: #ffffff;
        border: 1px solid #e7d8df;
        border-radius: 10px;
        padding: 26px 22px;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .svc-feature-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(108, 19, 64, 0.09);
        border-color: #6c1340;
    }
    .svc-card-icon {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        background: #f8eaf0;
        color: #6c1340;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
    }
    .svc-card-title {
        font-size: 1.95rem !important;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
        font-family: 'Noto Sans', sans-serif;
    }
    .svc-card-desc {
        font-size: 1.6rem !important;
        line-height: 1.8;
        color: #333333;
        font-family: 'Noto Sans', sans-serif;
        margin-bottom: 16px;
    }
    .svc-feature-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 20px;
    }
    .svc-feature-list li {
        font-size: 1.55rem !important;
        color: #222222;
        line-height: 1.7;
        padding: 4px 0 4px 22px;
        position: relative;
    }
    .svc-feature-list li::before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #6c1340;
        font-weight: bold;
    }

    /* Government Publications & Reports Table Styling */
    .pub-table-wrap {
        border-radius: 8px;
        border: 1px solid #e1d3da;
        overflow: hidden;
        margin-top: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .pub-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        font-family: 'Noto Sans', sans-serif;
    }
    .pub-table thead {
        background: #6c1340;
        color: #ffffff;
    }
    .pub-table thead th {
        padding: 16px 20px;
        font-size: 1.6rem !important;
        font-weight: 700;
        text-align: left;
        border: none;
        letter-spacing: 0.3px;
    }
    .pub-table tbody tr {
        border-bottom: 1px solid #f0e6ec;
        transition: background 0.15s;
    }
    .pub-table tbody tr:hover {
        background: #fbf5f8;
    }
    .pub-table tbody td {
        padding: 16px 20px;
        font-size: 1.6rem !important;
        color: #2b2b2b;
        vertical-align: middle;
    }
    .pub-title-bold {
        font-weight: 700;
        color: #6c1340;
        display: block;
        margin-bottom: 3px;
    }
    .pub-meta-sub {
        font-size: 1.45rem !important;
        color: #555555;
    }
    .pub-dl-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fdf5f8;
        border: 1px solid #ebd0de;
        color: #6c1340;
        font-size: 1.5rem !important;
        font-weight: 700;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none !important;
        transition: all 0.15s;
    }
    .pub-dl-btn:hover {
        background: #6c1340;
        color: #ffffff;
    }

    /* ============================================================
       ELEMENTOR PRO COMPONENT STYLES FOR PUBLIC FRONTEND
       ============================================================ */
    .pro-container-1col {
        padding: 24px;
        background: #fbfbfb;
        border: 1px solid #e8e8ed;
        border-radius: 10px;
        margin: 24px 0;
    }
    .pro-container-2col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin: 24px 0;
    }
    .pro-container-3col {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
        margin: 24px 0;
    }
    .pro-container-4col {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin: 24px 0;
    }
    .pro-container-sidebar {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 24px;
        margin: 24px 0;
    }
    @media (max-width: 768px) {
        .pro-container-2col,
        .pro-container-3col,
        .pro-container-4col,
        .pro-container-sidebar {
            grid-template-columns: 1fr;
        }
    }
    .pro-col-box {
        background: #ffffff;
        border: 1px dashed #d1d5db;
        border-radius: 8px;
        padding: 18px;
    }
    .pro-dual-heading {
        font-size: 2.4rem;
        font-weight: 800;
        color: #1a1a1a;
        margin: 24px 0 14px;
        line-height: 1.3;
        font-family: 'Noto Sans', sans-serif;
    }
    .pro-dual-heading .highlight-badge {
        background: linear-gradient(135deg, #721835 0%, #a3245f 100%);
        color: #ffffff;
        padding: 2px 12px;
        border-radius: 6px;
        display: inline-block;
        margin-right: 8px;
        font-size: 0.9em;
    }
    .pro-dual-heading .accent-text {
        color: #721835;
    }
    .pro-cta-box {
        background: linear-gradient(135deg, #4c082b 0%, #721835 60%, #8e1c56 100%);
        color: #ffffff;
        border-radius: 12px;
        padding: 34px 38px;
        margin: 28px 0;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(76, 8, 43, 0.15);
    }
    .pro-cta-title {
        font-size: 2.2rem;
        font-weight: 800;
        margin: 0 0 10px;
        color: #ffffff;
    }
    .pro-cta-desc {
        font-size: 1.55rem;
        line-height: 1.7;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 20px;
        max-width: 800px;
    }
    .pro-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ffffff;
        color: #721835 !important;
        font-weight: 700;
        font-size: 1.45rem;
        padding: 10px 24px;
        border-radius: 6px;
        text-decoration: none !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: all 0.2s;
    }
    .pro-cta-btn:hover {
        background: #f8fafc;
        transform: translateY(-2px);
    }
    .pro-pricing-card {
        background: #ffffff;
        border: 2px solid #ecd5e1;
        border-radius: 12px;
        padding: 30px 26px;
        text-align: center;
        margin: 20px auto;
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        transition: all 0.2s;
    }
    .pro-pricing-card:hover {
        border-color: #721835;
        box-shadow: 0 8px 24px rgba(114, 24, 53, 0.1);
    }
    .pro-pricing-badge {
        background: #fdf5f8;
        color: #721835;
        border: 1px solid #ebd0de;
        font-size: 1.2rem;
        font-weight: 700;
        padding: 4px 14px;
        border-radius: 20px;
        display: inline-block;
        margin-bottom: 12px;
        text-transform: uppercase;
    }
    .pro-pricing-title {
        font-size: 2.0rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 10px;
    }
    .pro-pricing-price {
        font-size: 2.8rem;
        font-weight: 800;
        color: #721835;
        margin: 12px 0 16px;
    }
    .pro-pricing-price span {
        font-size: 1.4rem;
        font-weight: 500;
        color: #64748b;
    }
    .pro-pricing-features {
        list-style: none;
        padding: 0;
        margin: 20px 0;
        text-align: left;
        font-size: 1.45rem;
    }
    .pro-pricing-features li {
        padding: 8px 0;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #334155;
    }
    .pro-pricing-features li i {
        color: #10b981;
        font-size: 16px;
    }
    .pro-counter-box {
        background: #ffffff;
        border: 1px solid #e8e8ed;
        border-radius: 12px;
        padding: 24px 20px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        transition: all 0.2s;
        margin: 16px 0;
    }
    .pro-counter-box:hover {
        transform: translateY(-3px);
        border-color: #c499b3;
        box-shadow: 0 6px 18px rgba(114, 24, 53, 0.08);
    }
    .pro-counter-icon {
        width: 56px;
        height: 56px;
        line-height: 56px;
        border-radius: 50%;
        background: #fdf5f8;
        color: #721835;
        font-size: 24px;
        margin: 0 auto 14px;
    }
    .pro-counter-number {
        font-size: 3.0rem;
        font-weight: 800;
        color: #721835;
        margin: 0 0 6px;
        line-height: 1;
    }
    .pro-counter-label {
        font-size: 1.45rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px;
    }
    .pro-counter-desc {
        font-size: 1.3rem;
        color: #64748b;
        margin: 0;
    }
    .pro-testimonial-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #721835;
        border-radius: 10px;
        padding: 24px 28px;
        margin: 20px 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .pro-testimonial-stars {
        color: #f59e0b;
        font-size: 16px;
        margin-bottom: 10px;
    }
    .pro-testimonial-quote {
        font-size: 1.55rem;
        line-height: 1.75;
        color: #334155;
        font-style: italic;
        margin-bottom: 16px;
    }
    .pro-testimonial-author {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .pro-testimonial-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #721835;
    }
    .pro-testimonial-name {
        font-size: 1.45rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .pro-testimonial-role {
        font-size: 1.3rem;
        color: #64748b;
        margin: 0;
    }
    .pro-tabs-wrapper {
        margin: 24px 0;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        background: #ffffff;
    }
    .pro-tabs-nav {
        display: flex;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }
    .pro-tab-item {
        padding: 14px 24px;
        font-size: 1.45rem;
        font-weight: 700;
        color: #64748b;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        transition: all 0.2s;
    }
    .pro-tab-item.active {
        color: #721835;
        background: #ffffff;
        border-bottom-color: #721835;
    }
    .pro-tabs-body {
        padding: 24px;
    }
    .pro-tab-pane {
        display: none;
        font-size: 1.45rem;
        line-height: 1.75;
        color: #334155;
    }
    .pro-tab-pane.active {
        display: block;
    }
    .pro-progress-box {
        margin: 20px 0;
    }
    .pro-progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    .pro-progress-title {
        font-size: 1.45rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .pro-progress-pct {
        font-size: 1.45rem;
        font-weight: 800;
        color: #721835;
    }
    .pro-progress-bar-wrap {
        height: 12px;
        background: #e2e8f0;
        border-radius: 6px;
        overflow: hidden;
    }
    .pro-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #721835 0%, #b8235a 100%);
        border-radius: 6px;
        transition: width 0.4s ease;
    }
    .pro-timeline-wrapper {
        position: relative;
        padding-left: 36px;
        margin: 28px 0;
    }
    .pro-timeline-wrapper::before {
        content: '';
        position: absolute;
        left: 12px;
        top: 6px;
        bottom: 6px;
        width: 3px;
        background: #ecd5e1;
    }
    .pro-timeline-node {
        position: relative;
        margin-bottom: 26px;
    }
    .pro-timeline-dot {
        position: absolute;
        left: -36px;
        top: 2px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #721835;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        box-shadow: 0 0 0 4px #ffffff, 0 0 0 6px #ecd5e1;
    }
    .pro-timeline-date {
        font-size: 1.3rem;
        font-weight: 700;
        color: #721835;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .pro-timeline-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 6px;
    }
    .pro-timeline-desc {
        font-size: 1.5rem;
        line-height: 1.7;
        color: #475569;
        margin: 0;
    }
    .pro-icon-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 26px 22px;
        margin: 16px 0;
        transition: all 0.2s;
    }
    .pro-icon-box:hover {
        border-color: #c499b3;
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(114, 24, 53, 0.08);
    }
    .pro-icon-circle {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: #fdf5f8;
        color: #721835;
        font-size: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    .pro-icon-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px;
    }
    .pro-icon-desc {
        font-size: 1.45rem;
        line-height: 1.7;
        color: #475569;
        margin: 0 0 12px;
    }
    .pro-icon-link {
        font-size: 1.35rem;
        font-weight: 700;
        color: #721835;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .pro-doc-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 16px 0;
        gap: 16px;
    }
    .pro-doc-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .pro-doc-icon {
        font-size: 32px;
        color: #dc2626;
    }
    .pro-doc-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px;
    }
    .pro-doc-meta {
        font-size: 1.3rem;
        color: #64748b;
        margin: 0;
    }
    .pro-flipbox {
        background: #fdf5f8;
        border: 1.5px solid #ebd0de;
        border-radius: 12px;
        padding: 24px;
        text-align: center;
        margin: 16px 0;
        transition: all 0.2s;
    }
    .pro-flipbox:hover {
        background: #721835;
        color: #ffffff;
        border-color: #721835;
    }
    .pro-flipbox:hover .pro-flipbox-title {
        color: #ffffff;
    }
    .pro-flipbox:hover .pro-flipbox-desc {
        color: rgba(255,255,255,0.9);
    }
    .pro-flipbox-icon {
        font-size: 36px;
        color: #721835;
        margin-bottom: 12px;
    }
    .pro-flipbox:hover .pro-flipbox-icon {
        color: #ffffff;
    }
    .pro-flipbox-title {
        font-size: 1.85rem;
        font-weight: 700;
        color: #721835;
        margin: 0 0 10px;
    }
    .pro-flipbox-desc {
        font-size: 1.45rem;
        color: #475569;
        margin: 0;
        line-height: 1.65;
    }
    .pro-alert-box {
        border-radius: 8px;
        padding: 18px 22px;
        margin: 20px 0;
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }
    .pro-alert-info {
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
        color: #1e40af;
    }
    .pro-alert-warning {
        background: #fffbeb;
        border-left: 4px solid #f59e0b;
        color: #92400e;
    }
    .pro-alert-success {
        background: #f0fdf4;
        border-left: 4px solid #10b981;
        color: #065f46;
    }
    .pro-alert-danger {
        background: #fef2f2;
        border-left: 4px solid #ef4444;
        color: #991b1b;
    }
    .pro-alert-icon {
        font-size: 24px;
        margin-top: 2px;
    }
    .pro-alert-content h5 {
        font-size: 1.65rem;
        font-weight: 700;
        margin: 0 0 4px;
    }
    .pro-alert-content p {
        font-size: 1.45rem;
        margin: 0;
        line-height: 1.6;
    }
    .pro-video-card {
        background: #111827;
        border-radius: 12px;
        overflow: hidden;
        margin: 24px 0;
        position: relative;
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    .pro-video-placeholder {
        height: 380px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/assets/images/banner1.jpg') center/cover;
        cursor: pointer;
    }
    .pro-video-play-btn {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: #721835;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin-bottom: 14px;
        box-shadow: 0 0 0 8px rgba(114, 24, 53, 0.4);
        transition: transform 0.2s;
    }
    .pro-video-play-btn:hover {
        transform: scale(1.1);
    }
    .pro-gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin: 24px 0;
    }
    .pro-gallery-item {
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #ffffff;
    }
    .pro-gallery-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
    }
    .pro-gallery-caption {
        padding: 10px 14px;
        font-size: 1.35rem;
        font-weight: 600;
        color: #334155;
        text-align: center;
        margin: 0;
    }

    /* Compact Adaptability for Acts Card in Sidebars & Narrow Columns */
    .about-vision-col .acts-card,
    .acts-card.compact-size {
        padding: 16px 18px !important;
        margin-top: 18px !important;
        margin-bottom: 18px !important;
        box-sizing: border-box !important;
    }
    .about-vision-col .acts-card .acts-card-top,
    .acts-card.compact-size .acts-card-top {
        flex-direction: column !important;
        gap: 10px !important;
        margin-bottom: 10px !important;
    }
    .about-vision-col .acts-card .acts-card-title,
    .acts-card.compact-size .acts-card-title {
        font-size: 1.35rem !important;
        line-height: 1.3 !important;
    }
    .about-vision-col .acts-card .acts-card-img-wrap,
    .acts-card.compact-size .acts-card-img-wrap {
        width: 100% !important;
        flex: 0 0 54px !important;
        height: 54px !important;
    }
    .about-vision-col .acts-card .acts-card-desc,
    .acts-card.compact-size .acts-card-desc {
        font-size: 1.25rem !important;
        line-height: 1.6 !important;
        margin-bottom: 12px !important;
    }
    .about-vision-col .acts-card .acts-card-footer,
    .acts-card.compact-size .acts-card-footer {
        padding-top: 10px !important;
        flex-wrap: wrap !important;
        gap: 8px !important;
    }
    .about-vision-col .acts-card .acts-pdf-badge,
    .acts-card.compact-size .acts-pdf-badge {
        font-size: 1.15rem !important;
        padding: 4px 10px !important;
    }

    /* ============================================================
       DBIM DIRECTORY / WHO'S WHO CONTACT TABLE & AVATARS
       ============================================================ */
    .dbim-directory-section {
        margin: 28px 0;
    }
    .dbim-dir-table-wrapper {
        border: 1px solid #ebd0de;
        border-radius: 8px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 14px rgba(114, 24, 53, 0.05);
        margin-bottom: 24px;
    }
    .dbim-dir-category-header {
        background: #9c2759;
        color: #ffffff;
        padding: 12px 20px;
        font-weight: 700;
        font-size: 1.45rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .dbim-dir-table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
        font-family: 'Noto Sans', sans-serif;
    }
    .dbim-dir-table thead th {
        background: #faebf3;
        color: #9c2759;
        font-weight: 700;
        font-size: 1.15rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 18px;
        border: none;
        font-family: 'Noto Sans', sans-serif;
    }
    .dbim-dir-table tbody tr {
        border-bottom: 1px solid #f1edf0;
        transition: background 0.15s;
    }
    .dbim-dir-table tbody tr:last-child {
        border-bottom: none;
    }
    .dbim-dir-table tbody tr:hover {
        background: #fdfafc;
    }
    .dbim-dir-table tbody td {
        padding: 16px 18px;
        vertical-align: top;
        border: none;
        font-family: 'Noto Sans', sans-serif;
    }
    .officer-name {
        font-weight: 700;
        color: #111827;
        font-size: 1.45rem;
        line-height: 1.35;
        margin-bottom: 3px;
    }
    .officer-desig {
        color: #4b5563;
        font-size: 1.25rem;
        line-height: 1.4;
    }
    .officer-phone, .officer-email, .officer-address {
        font-size: 1.25rem;
        color: #374151;
        line-height: 1.5;
    }

    /* Avatar Profile Components */
    .dbim-avatar-card-wrapper {
        max-width: 380px;
        margin: 24px auto;
    }
    .dbim-avatar-img-wrap {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        padding: 4px;
        background: linear-gradient(135deg, #721835 0%, #ba2369 100%);
        box-shadow: 0 4px 14px rgba(114, 24, 53, 0.22);
        margin: 0 auto;
        overflow: hidden;
        position: relative;
    }
    .dbim-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        background: #ffffff;
        display: block;
    }
    .dbim-avatar-inline-box {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        padding: 10px 16px;
        background: #ffffff;
        border: 1px solid #ebd0de;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .dbim-avatar-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin: 28px 0;
    }

    /* ============================================================
       OFFICIAL DBIM FAQ / ACCORDION COMPONENT
       ============================================================ */
    .dbim-faq-wrapper {
        margin: 32px 0;
    }
    .dbim-faq-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 22px;
    }
    .dbim-faq-title {
        color: #500a2f;
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0;
        font-family: 'Noto Sans', sans-serif;
    }
    .dbim-faq-controls {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .dbim-faq-search {
        position: relative;
        width: 240px;
    }
    .dbim-faq-search input {
        width: 100%;
        padding: 7px 12px 7px 32px;
        border-radius: 20px;
        border: 1px solid #ebd0de;
        font-size: 1.25rem;
        outline: none;
        transition: all 0.2s;
        background: #ffffff;
    }
    .dbim-faq-search input:focus {
        border-color: #721835;
        box-shadow: 0 0 0 3px rgba(114, 24, 53, 0.12);
    }
    .dbim-faq-search i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #721835;
        font-size: 13px;
    }
    .dbim-faq-item {
        border: 1.5px solid #ebd0de;
        border-radius: 10px;
        background: #ffffff;
        margin-bottom: 14px;
        overflow: hidden;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(114, 24, 53, 0.03);
    }
    .dbim-faq-item:hover {
        border-color: #ba2369;
        box-shadow: 0 4px 12px rgba(114, 24, 53, 0.08);
    }
    .dbim-faq-item.is-active {
        border-color: #721835;
        border-left: 5px solid #721835;
    }
    .dbim-faq-question {
        padding: 16px 20px;
        background: #ffffff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        user-select: none;
        transition: background 0.15s;
    }
    .dbim-faq-item.is-active .dbim-faq-question {
        background: #fdf5f8;
    }
    .dbim-faq-q-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }
    .dbim-faq-badge {
        background: #ebd0de;
        color: #721835;
        font-size: 1.15rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        letter-spacing: 0.5px;
        flex-shrink: 0;
    }
    .dbim-faq-q-text {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1.4;
        margin: 0;
        font-family: 'Noto Sans', sans-serif;
    }
    .dbim-faq-item.is-active .dbim-faq-q-text {
        color: #721835;
    }
    .dbim-faq-chevron {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #f7eef3;
        color: #721835;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        transition: transform 0.25s ease, background 0.2s;
        flex-shrink: 0;
    }
    .dbim-faq-item.is-active .dbim-faq-chevron {
        transform: rotate(180deg);
        background: #721835;
        color: #ffffff;
    }
    .dbim-faq-answer {
        padding: 0 22px 20px 58px;
        font-size: 1.35rem;
        line-height: 1.8;
        color: #2b2b2b;
        border-top: 1px dashed #f2e2ec;
        padding-top: 16px;
        display: none;
        font-family: 'Noto Sans', sans-serif;
    }
    .dbim-faq-item.is-active .dbim-faq-answer {
        display: block;
    }

    /* Universal Clean Data Table (Ministry of Textiles Theme) */
    .dbim-data-table-wrapper {
        border: 1px solid #ebd0de;
        border-radius: 8px;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 14px rgba(114, 24, 53, 0.05);
        margin-bottom: 24px;
        font-family: 'Noto Sans', sans-serif;
    }
    .dbim-data-table-wrapper .table {
        margin-bottom: 0;
    }
    .dbim-data-table-wrapper th,
    .dbim-data-table-wrapper td {
        border-top: none;
        border-left: none;
        border-right: none;
    }
    .dbim-data-table-wrapper tbody tr:hover {
        background-color: #faf5f8;
    }
    .dbim-data-table-wrapper .pagination .page-link {
        color: #721835;
        border-color: #ebd0de;
        font-size: 1.15rem;
        padding: 4px 10px;
    }
    .dbim-data-table-wrapper .pagination .page-item.active .page-link {
        background-color: #721835;
        border-color: #721835;
        color: #ffffff;
    }

    /* Hide visual editor control buttons on public front page */
    .inner-page-main button[onclick*="openPdfUploader"],
    .inner-page-main button[onclick*="openDocMediaModal"],
    .inner-page-main button[onclick*="openAvatarModal"],
    .inner-page-main button[onclick*="addDocCardToStack"],
    .inner-page-main button[onclick*="addDirRowToTable"],
    .inner-page-main button[onclick*="addDirSectionAfter"],
    .inner-page-main button[onclick*="removeDirRow"],
    .inner-page-main button[onclick*="addFaqItem"],
    .inner-page-main button[onclick*="removeFaqItem"],
    .inner-page-main button[onclick*="addDbimTable"],
    .inner-page-main button[onclick*="removeDbimTable"],
    .inner-page-main .editor-doc-btn,
    .inner-page-main .editor-avatar-btn,
    .inner-page-main .editor-row-ctrl,
    .inner-page-main .editor-faq-btn,
    .inner-page-main .editor-table-ctrl,
    .inner-page-main .editor-table-btn,
    .inner-page-main .editor-img-ctrl,
    .inner-page-main .editor-img-btn,
    .inner-page-main .editor-pro-table-ctrl,
    .inner-page-main .pro-table-selection-badge {
        display: none !important;
    }

    /* Reset interactive editor cursors on front page */
    .inner-page-main .dbim-avatar-img-wrap,
    .inner-page-main .dbim-table-img,
    .inner-page-main .dbim-custom-img,
    .inner-page-main img[onclick*="openAvatarModal"],
    .inner-page-main [onclick*="openAvatarModal"] {
        cursor: default !important;
    }
    .inner-page-main .dbim-pro-table .pro-cell-active {
        outline: none !important;
        box-shadow: none !important;
    }

    /* ============================================================
       DBIM COMPLIANT BOOK, PUBLICATION & MAGAZINE CARDS
       ============================================================ */
    .dbim-book-magazine-section {
        margin-top: 2.5rem;
        margin-bottom: 4rem;
    }
    .dbim-book-card {
        background: #fdf5f8 !important;
        border: 1px solid #ebd0de !important;
        border-radius: 6px !important;
        padding: 12px !important;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(114, 24, 53, 0.04);
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .dbim-book-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(114, 24, 53, 0.1);
        border-color: #d19bb8 !important;
    }
    .dbim-book-cover-wrap {
        background: #ffffff !important;
        border: 1px solid #f0dfe9 !important;
        border-radius: 4px !important;
        padding: 8px !important;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .dbim-book-figure {
        max-width: 100%;
        width: 100%;
        margin: 0 auto;
    }
    .dbim-book-cover-inner {
        position: relative;
        border-radius: 4px;
        overflow: hidden;
    }
    .dbim-book-cover-img {
        width: 100% !important;
        aspect-ratio: 1 / 1.35 !important;
        object-fit: contain !important;
        display: block;
        background-color: #ffffff;
    }
    .dbim-book-title {
        font-family: 'Merriweather', serif !important;
        color: #1e1b24 !important;
        font-size: 1.55rem !important;
        line-height: 1.35 !important;
        font-weight: 700 !important;
        text-align: center !important;
        margin: 0 !important;
    }
    .inner-page-main .editor-book-grid-ctrl,
    .inner-page-main .editor-book-btn-bar,
    .inner-page-main .editor-book-btn {
        display: none !important;
    }
    .inner-page-main .dbim-book-cover-img {
        cursor: default !important;
    }
    /* ============================================================
       DBIM MEDIA GALLERIES: PHOTO, VIDEO & PRESENTATION/EVENTS
       ============================================================ */
    .dbim-photo-card, .dbim-video-card, .dbim-pres-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .dbim-photo-card:hover .dbim-photo-img {
        transform: scale(1.03);
    }
    .dbim-photo-action-btn:hover {
        background: #721835 !important;
    }
    .dbim-photo-title, .dbim-video-title, .dbim-pres-title {
        font-family: 'Noto Sans', sans-serif !important;
        color: #1e1b24 !important;
    }
    .dbim-gallery-search:focus, .dbim-pres-search:focus {
        border-color: #721835 !important;
        box-shadow: 0 0 0 0.2rem rgba(114, 24, 53, 0.15) !important;
    }
    .dbim-pres-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(114, 24, 53, 0.08) !important;
    }
    .dbim-pres-view-btn:hover {
        background: #721835 !important;
        color: #ffffff !important;
    }
    .dbim-album-photo-card {
        border-radius: 6px !important;
        overflow: hidden;
        position: relative;
        aspect-ratio: 16 / 10;
        background: #f0e6ec;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        cursor: pointer;
    }
    .dbim-album-photo-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(114, 24, 53, 0.14) !important;
    }
    .dbim-album-photo-card:hover .dbim-album-photo-img {
        transform: scale(1.04);
    }
    .dbim-album-photo-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }
    .dbim-album-photo-expand-btn {
        width: 32px;
        height: 32px;
        background: rgba(30, 27, 36, 0.82) !important;
        border-radius: 4px;
        border: none;
        color: #ffffff !important;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .dbim-album-photo-card:hover .dbim-album-photo-expand-btn {
        background: #721835 !important;
        transform: scale(1.08);
    }
    .dbim-back-to-albums-btn {
        border-color: #721835 !important;
        color: #721835 !important;
        background: transparent !important;
        font-weight: 700 !important;
        padding: 7px 18px !important;
        border-radius: 6px !important;
        transition: all 0.2s ease;
        font-size: 1.3rem !important;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
    }
    .dbim-back-to-albums-btn:hover {
        background: #721835 !important;
        color: #ffffff !important;
    }
    /* Photo Gallery Albums Grid vs Detail View state management */
    .dbim-photo-gallery-section .dbim-albums-view {
        display: block !important;
    }
    .dbim-photo-gallery-section .dbim-album-detail-view {
        display: none !important;
    }
    .dbim-photo-gallery-section.viewing-album .dbim-albums-view {
        display: none !important;
    }
    .dbim-photo-gallery-section.viewing-album .dbim-album-detail-view {
        display: block !important;
    }
    .inner-page-main .editor-photo-grid-ctrl,
    .inner-page-main .editor-photo-btn-bar,
    .inner-page-main .editor-photo-btn,
    .inner-page-main .editor-album-ctrl,
    .inner-page-main .editor-album-photo-btn-bar,
    .inner-page-main .editor-album-photo-btn,
    .inner-page-main .editor-video-grid-ctrl,
    .inner-page-main .editor-video-source-bar,
    .inner-page-main .editor-video-btn-bar,
    .inner-page-main .editor-video-btn,
    .inner-page-main .editor-pres-grid-ctrl,
    .inner-page-main .editor-pres-btn-bar,
    .inner-page-main .editor-pres-btn,
    .inner-page-main .editor-btn-ctrl,
    .inner-page-main .editor-link-ctrl,
    .inner-page-main .editor-link-btn {
        display: none !important;
    }
    .dbim-custom-btn {
        transition: all 0.2s ease-in-out;
    }
    .dbim-custom-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(114, 24, 53, 0.25) !important;
    }
    .dbim-custom-btn.dbim-btn-outline:hover {
        background: #721835 !important;
        color: #ffffff !important;
    }
    .dbim-custom-link:hover {
        color: #ba2369 !important;
    }
</style>

<script>
function toggleFaqItem(headerEl) {
    var item = headerEl.closest('.dbim-faq-item');
    if (!item) return;
    item.classList.toggle('is-active');
}

function toggleAllFaqs(btn) {
    var wrapper = btn.closest('.dbim-faq-wrapper');
    if (!wrapper) return;
    var items = wrapper.querySelectorAll('.dbim-faq-item');
    var isAnyClosed = Array.from(items).some(function(it) { return !it.classList.contains('is-active'); });
    items.forEach(function(it) {
        if (isAnyClosed) {
            it.classList.add('is-active');
        } else {
            it.classList.remove('is-active');
        }
    });
    btn.innerHTML = isAnyClosed 
        ? '<i class="fa-solid fa-compress me-1"></i> Collapse All' 
        : '<i class="fa-solid fa-expand me-1"></i> Expand All';
}

function filterFaqItems(input) {
    var wrapper = input.closest('.dbim-faq-wrapper');
    if (!wrapper) return;
    var query = input.value.toLowerCase().trim();
    var items = wrapper.querySelectorAll('.dbim-faq-item');
    items.forEach(function(item) {
        var text = item.innerText.toLowerCase();
        if (!query || text.indexOf(query) !== -1) {
            item.style.display = '';
            if (query) item.classList.add('is-active');
        } else {
            item.style.display = 'none';
        }
    });
}

// Data Table Pagination & Live Search (Frontend)
function changeDbimTablePageSize(selectEl) {
    var tableWrap = selectEl.closest('.dbim-data-table-wrapper');
    if (!tableWrap) return;
    tableWrap.setAttribute('data-page-size', selectEl.value);
    tableWrap.setAttribute('data-current-page', '1');
    renderDbimTablePagination(tableWrap);
}

function gotoDbimTablePage(btn, pageNum) {
    var tableWrap = btn.closest('.dbim-data-table-wrapper');
    if (!tableWrap) return;
    tableWrap.setAttribute('data-current-page', pageNum);
    renderDbimTablePagination(tableWrap);
}

function filterDbimTable(inputEl) {
    var tableWrap = inputEl.closest('.dbim-data-table-wrapper');
    if (!tableWrap) return;
    var query = inputEl.value.toLowerCase().trim();
    var rows = tableWrap.querySelectorAll('tbody tr');

    rows.forEach(function(row) {
        var text = row.innerText.toLowerCase();
        if (!query || text.indexOf(query) !== -1) {
            row.removeAttribute('data-search-hidden');
        } else {
            row.setAttribute('data-search-hidden', 'true');
        }
    });

    tableWrap.setAttribute('data-current-page', '1');
    renderDbimTablePagination(tableWrap);
}

function renderDbimTablePagination(tableWrap) {
    if (!tableWrap) return;
    var allRows = Array.from(tableWrap.querySelectorAll('tbody tr'));
    var visibleRows = allRows.filter(function(r) { return r.getAttribute('data-search-hidden') !== 'true'; });
    var total = visibleRows.length;

    var rawSize = tableWrap.getAttribute('data-page-size') || '5';
    var pageSize = (rawSize === 'all') ? total : (parseInt(rawSize) || 5);
    var currentPage = parseInt(tableWrap.getAttribute('data-current-page')) || 1;

    var totalPages = Math.max(1, Math.ceil(total / pageSize));
    if (currentPage > totalPages) currentPage = totalPages;
    tableWrap.setAttribute('data-current-page', currentPage);

    var start = (currentPage - 1) * pageSize;
    var end = (rawSize === 'all') ? total : Math.min(start + pageSize, total);

    allRows.forEach(function(row) {
        if (row.getAttribute('data-search-hidden') === 'true') {
            row.style.display = 'none';
        } else {
            var rowIdx = visibleRows.indexOf(row);
            if (rowIdx >= start && rowIdx < end) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });

    var infoEl = tableWrap.querySelector('.dbim-table-info');
    if (infoEl) {
        if (total === 0) {
            infoEl.textContent = 'Showing 0 entries';
        } else {
            infoEl.textContent = 'Showing ' + (start + 1) + ' to ' + end + ' of ' + total + ' entries';
        }
    }

    var ul = tableWrap.querySelector('.dbim-table-pagination');
    if (!ul) return;

    var html = '';
    var prevDisabled = (currentPage <= 1);
    html += '<li class="page-item ' + (prevDisabled ? 'disabled' : '') + '">' +
        '<a class="page-link" href="javascript:void(0)" onclick="' + (prevDisabled ? '' : 'gotoDbimTablePage(this, ' + (currentPage - 1) + ')') + '" style="border-radius: 4px;">&laquo; Prev</a>' +
    '</li>';

    for (var p = 1; p <= totalPages; p++) {
        var isActive = (p === currentPage);
        html += '<li class="page-item ' + (isActive ? 'active' : '') + '">' +
            '<a class="page-link" href="javascript:void(0)" onclick="gotoDbimTablePage(this, ' + p + ')" style="' + (isActive ? 'background: #721835; border-color: #721835; color: #fff;' : '') + ' border-radius: 4px;">' + p + '</a>' +
        '</li>';
    }

    var nextDisabled = (currentPage >= totalPages);
    html += '<li class="page-item ' + (nextDisabled ? 'disabled' : '') + '">' +
        '<a class="page-link" href="javascript:void(0)" onclick="' + (nextDisabled ? '' : 'gotoDbimTablePage(this, ' + (currentPage + 1) + ')') + '" style="border-radius: 4px;">Next &raquo;</a>' +
    '</li>';

    ul.innerHTML = html;
}

function initAllDbimTables() {
    document.querySelectorAll('.dbim-data-table-wrapper').forEach(renderDbimTablePagination);
}

// ============================================================
// DBIM PHOTO, VIDEO & PRESENTATION GALLERY FRONTEND HANDLERS
// ============================================================
function filterPhotoGallery(input) {
    var section = input.closest('.dbim-photo-gallery-section');
    if (!section) return;
    var q = input.value.toLowerCase().trim();
    section.querySelectorAll('.dbim-photo-col').forEach(function(col) {
        var title = (col.querySelector('.dbim-photo-title')?.innerText || col.getAttribute('data-title') || '').toLowerCase();
        col.style.display = (!q || title.includes(q)) ? '' : 'none';
    });
}

function sortPhotoGallery(select) {
    var section = select.closest('.dbim-photo-gallery-section');
    if (!section) return;
    var grid = section.querySelector('.dbim-photo-grid');
    if (!grid) return;
    var cols = Array.from(grid.querySelectorAll('.dbim-photo-col'));
    var val = select.value;

    cols.sort(function(a, b) {
        var titleA = (a.querySelector('.dbim-photo-title')?.innerText || '').trim();
        var titleB = (b.querySelector('.dbim-photo-title')?.innerText || '').trim();
        var dateA = (a.querySelector('.dbim-photo-date')?.innerText || '').trim();
        var dateB = (b.querySelector('.dbim-photo-date')?.innerText || '').trim();

        if (val === 'title_asc') return titleA.localeCompare(titleB);
        if (val === 'title_desc') return titleB.localeCompare(titleA);
        if (val === 'oldest') return dateA.localeCompare(dateB);
        return dateB.localeCompare(dateA);
    });
    cols.forEach(function(c) { grid.appendChild(c); });
}

function filterPhotoCategory(select) {
    var section = select.closest('.dbim-photo-gallery-section');
    if (!section) return;
    var cat = select.value.toLowerCase();
    section.querySelectorAll('.dbim-photo-col').forEach(function(col) {
        var itemCat = (col.getAttribute('data-category') || '').toLowerCase();
        var title = (col.querySelector('.dbim-photo-title')?.innerText || '').toLowerCase();
        col.style.display = (cat === 'all' || itemCat.includes(cat) || title.includes(cat)) ? '' : 'none';
    });
}

function sortVideoGallery(select) {
    var section = select.closest('.dbim-video-gallery-section');
    if (!section) return;
    var grid = section.querySelector('.dbim-video-grid');
    if (!grid) return;
    var cols = Array.from(grid.querySelectorAll('.dbim-video-col'));
    var val = select.value;

    cols.sort(function(a, b) {
        var titleA = (a.querySelector('.dbim-video-title')?.innerText || '').trim();
        var titleB = (b.querySelector('.dbim-video-title')?.innerText || '').trim();
        var dateA = (a.querySelector('.dbim-video-date')?.innerText || '').trim();
        var dateB = (b.querySelector('.dbim-video-date')?.innerText || '').trim();

        if (val === 'title_asc') return titleA.localeCompare(titleB);
        if (val === 'oldest') return dateA.localeCompare(dateB);
        return dateB.localeCompare(dateA);
    });
    cols.forEach(function(c) { grid.appendChild(c); });
}

function filterVideoCategory(select) {
    var section = select.closest('.dbim-video-gallery-section');
    if (!section) return;
    var cat = select.value.toLowerCase();
    section.querySelectorAll('.dbim-video-col').forEach(function(col) {
        var itemCat = (col.getAttribute('data-category') || '').toLowerCase();
        var title = (col.querySelector('.dbim-video-title')?.innerText || '').toLowerCase();
        col.style.display = (cat === 'all' || itemCat.includes(cat) || title.includes(cat)) ? '' : 'none';
    });
}

function filterPresGallery(input) {
    var section = input.closest('.dbim-presentation-events-section');
    if (!section) return;
    var q = input.value.toLowerCase().trim();
    section.querySelectorAll('.dbim-pres-col').forEach(function(col) {
        var title = (col.querySelector('.dbim-pres-title')?.innerText || col.getAttribute('data-title') || '').toLowerCase();
        col.style.display = (!q || title.includes(q)) ? '' : 'none';
    });
}

function sortPresGallery(select) {
    var section = select.closest('.dbim-presentation-events-section');
    if (!section) return;
    var grid = section.querySelector('.dbim-pres-grid');
    if (!grid) return;
    var cols = Array.from(grid.querySelectorAll('.dbim-pres-col'));
    var val = select.value;

    cols.sort(function(a, b) {
        var titleA = (a.querySelector('.dbim-pres-title')?.innerText || '').trim();
        var titleB = (b.querySelector('.dbim-pres-title')?.innerText || '').trim();
        var dateA = (a.querySelector('.dbim-pres-date')?.innerText || '').trim();
        var dateB = (b.querySelector('.dbim-pres-date')?.innerText || '').trim();

        if (val === 'title_asc') return titleA.localeCompare(titleB);
        if (val === 'oldest') return dateA.localeCompare(dateB);
        return dateB.localeCompare(dateA);
    });
    cols.forEach(function(c) { grid.appendChild(c); });
}

function filterPresCategory(select) {
    var section = select.closest('.dbim-presentation-events-section');
    if (!section) return;
    var cat = select.value.toLowerCase();
    section.querySelectorAll('.dbim-pres-col').forEach(function(col) {
        var itemCat = (col.getAttribute('data-category') || '').toLowerCase();
        var title = (col.querySelector('.dbim-pres-title')?.innerText || '').toLowerCase();
        col.style.display = (cat === 'all' || itemCat.includes(cat) || title.includes(cat)) ? '' : 'none';
    });
}

// ============================================================
// DBIM PHOTO GALLERY ALBUM SWITCHING & LIGHTBOX
// ============================================================
var currentAlbumPhotos = [];
var currentPhotoIndex = 0;

function openPhotoAlbum(albumSlug, el) {
    var section = el ? el.closest('.dbim-photo-gallery-section') : document.querySelector('.dbim-photo-gallery-section');
    if (!section) return;

    var albumsView = section.querySelector('.dbim-albums-view');
    var detailView = section.querySelector('.dbim-album-detail-view');
    if (!albumsView || !detailView) return;

    var card = el ? el.closest('.dbim-photo-col') : section.querySelector('.dbim-photo-col[data-album-slug="' + albumSlug + '"]');
    var title = card ? (card.querySelector('.dbim-photo-title')?.innerText || card.getAttribute('data-title') || '').trim() : '';
    var date = card ? (card.querySelector('.dbim-photo-date')?.innerText || card.getAttribute('data-date') || '').trim() : '';

    if (!title && albumSlug === 'nift-convocation-2026') {
        title = 'NIFT CONVOCATION 2026';
        date = '31.08.2026';
    }

    var titleEl = detailView.querySelector('.dbim-album-title-text');
    var dateEl = detailView.querySelector('.dbim-album-date-text');
    if (titleEl && title) titleEl.innerText = title;
    if (dateEl && date) dateEl.innerText = date;

    // Show selected album subgrid
    detailView.querySelectorAll('.dbim-album-subgrid').forEach(function(sg) {
        sg.style.display = 'none';
    });
    var targetSubgrid = detailView.querySelector('.dbim-album-subgrid[data-album-slug="' + albumSlug + '"]');
    if (targetSubgrid) {
        targetSubgrid.style.display = '';
    } else {
        var firstGrid = detailView.querySelector('.dbim-album-subgrid');
        if (firstGrid) firstGrid.style.display = '';
    }

    section.classList.add('viewing-album');
    albumsView.style.setProperty('display', 'none', 'important');
    detailView.style.setProperty('display', 'block', 'important');

    try {
        var url = new URL(window.location.href);
        url.searchParams.set('album', albumSlug);
        window.history.pushState({ album: albumSlug }, '', url);
    } catch(e) {}

    section.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function closePhotoAlbum(btn) {
    var section = btn ? btn.closest('.dbim-photo-gallery-section') : document.querySelector('.dbim-photo-gallery-section');
    if (!section) return;

    var albumsView = section.querySelector('.dbim-albums-view');
    var detailView = section.querySelector('.dbim-album-detail-view');
    if (!albumsView || !detailView) return;

    section.classList.remove('viewing-album');
    detailView.style.setProperty('display', 'none', 'important');
    albumsView.style.setProperty('display', 'block', 'important');

    try {
        var url = new URL(window.location.href);
        url.searchParams.delete('album');
        window.history.pushState({}, '', url);
    } catch(e) {}

    section.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function openPhotoPreview(el) {
    var photoCard = el.closest('.dbim-album-photo-card');
    var subgrid = el.closest('.dbim-album-subgrid') || el.closest('.dbim-album-photos-grid');
    var img = el.tagName === 'IMG' ? el : (photoCard ? photoCard.querySelector('img') : el.closest('.dbim-photo-card')?.querySelector('.dbim-photo-img'));
    if (!img) return;

    var albumTitle = document.querySelector('.dbim-album-title-text')?.innerText || el.closest('.dbim-photo-card')?.querySelector('.dbim-photo-title')?.innerText || 'Photo Gallery';

    if (subgrid) {
        var imgs = Array.from(subgrid.querySelectorAll('.dbim-album-photo-card img'));
        currentAlbumPhotos = imgs.map(function(i) {
            return {
                src: i.src,
                alt: i.alt || albumTitle
            };
        });
        currentPhotoIndex = imgs.indexOf(img);
        if (currentPhotoIndex < 0) currentPhotoIndex = 0;
    } else {
        currentAlbumPhotos = [{ src: img.src, alt: img.alt || albumTitle }];
        currentPhotoIndex = 0;
    }

    var modal = document.getElementById('photoPreviewModal');
    if (!modal) {
        var modalHtml = '<div class="modal fade" id="photoPreviewModal" tabindex="-1" aria-hidden="true" style="z-index: 2500;">' +
            '<div class="modal-dialog modal-xl modal-dialog-centered">' +
                '<div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden; background: #110e14; color: #fff;">' +
                    '<div class="modal-header border-0 py-3 px-4 d-flex align-items-center justify-content-between" style="background: rgba(26, 21, 31, 0.95); border-bottom: 1px solid rgba(255,255,255,0.08) !important;">' +
                        '<div>' +
                            '<h5 class="modal-title fs-5 fw-bold text-white mb-0" id="photoPreviewModalTitle">Photo Preview</h5>' +
                            '<span class="text-white-50 small" id="photoPreviewModalCounter"></span>' +
                        '</div>' +
                        '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>' +
                    '</div>' +
                    '<div class="modal-body p-2 p-md-4 position-relative d-flex align-items-center justify-content-center" style="min-height: 480px; max-height: 82vh;">' +
                        '<button type="button" class="btn btn-dark position-absolute start-0 top-50 translate-middle-y ms-3 shadow-lg d-flex align-items-center justify-content-center" onclick="lightboxNav(-1)" id="lightboxPrevBtn" style="width: 44px; height: 44px; border-radius: 50%; z-index: 10; background: rgba(0,0,0,0.7); border: 1px solid rgba(255,255,255,0.25);">' +
                            '<i class="fa-solid fa-chevron-left" style="font-size: 16px;"></i>' +
                        '</button>' +
                        '<img id="photoPreviewModalImg" src="" alt="Photo" class="img-fluid rounded shadow-lg" style="max-height: 75vh; max-width: 95%; object-fit: contain; transition: opacity 0.2s ease;">' +
                        '<button type="button" class="btn btn-dark position-absolute end-0 top-50 translate-middle-y me-3 shadow-lg d-flex align-items-center justify-content-center" onclick="lightboxNav(1)" id="lightboxNextBtn" style="width: 44px; height: 44px; border-radius: 50%; z-index: 10; background: rgba(0,0,0,0.7); border: 1px solid rgba(255,255,255,0.25);">' +
                            '<i class="fa-solid fa-chevron-right" style="font-size: 16px;"></i>' +
                        '</button>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>';
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        modal = document.getElementById('photoPreviewModal');

        document.addEventListener('keydown', function(ev) {
            if (!modal.classList.contains('show')) return;
            if (ev.key === 'ArrowLeft') lightboxNav(-1);
            if (ev.key === 'ArrowRight') lightboxNav(1);
        });
    }

    updateLightboxContent();
    var bsModal = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);
    bsModal.show();
}

function updateLightboxContent() {
    var photo = currentAlbumPhotos[currentPhotoIndex];
    if (!photo) return;
    var albumTitle = document.querySelector('.dbim-album-title-text')?.innerText || 'Photo Gallery';
    var imgEl = document.getElementById('photoPreviewModalImg');
    var titleEl = document.getElementById('photoPreviewModalTitle');
    var counterEl = document.getElementById('photoPreviewModalCounter');
    var prevBtn = document.getElementById('lightboxPrevBtn');
    var nextBtn = document.getElementById('lightboxNextBtn');

    if (imgEl) {
        imgEl.style.opacity = '0.5';
        imgEl.src = photo.src;
        imgEl.onload = function() { imgEl.style.opacity = '1'; };
    }
    if (titleEl) titleEl.innerText = albumTitle;
    if (counterEl) {
        if (currentAlbumPhotos.length > 1) {
            counterEl.innerText = 'Photo ' + (currentPhotoIndex + 1) + ' of ' + currentAlbumPhotos.length;
            counterEl.style.display = 'inline-block';
        } else {
            counterEl.style.display = 'none';
        }
    }
    if (prevBtn) prevBtn.style.display = currentAlbumPhotos.length > 1 ? 'flex' : 'none';
    if (nextBtn) nextBtn.style.display = currentAlbumPhotos.length > 1 ? 'flex' : 'none';
}

function lightboxNav(dir) {
    if (!currentAlbumPhotos || currentAlbumPhotos.length <= 1) return;
    currentPhotoIndex = (currentPhotoIndex + dir + currentAlbumPhotos.length) % currentAlbumPhotos.length;
    updateLightboxContent();
}

function playGalleryVideo(el) {
    var card = el.closest('.dbim-video-card');
    var thumb = card ? card.querySelector('.dbim-video-thumbnail') : null;
    var title = card ? (card.querySelector('.dbim-video-title')?.innerText || 'Video Player') : 'Video Player';
    var videoUrl = thumb ? (thumb.getAttribute('data-video-url') || '') : '';

    var modal = document.getElementById('videoPlayerModal');
    if (!modal) {
        var modalHtml = '<div class="modal fade" id="videoPlayerModal" tabindex="-1" aria-hidden="true" style="z-index: 2500;">' +
            '<div class="modal-dialog modal-lg modal-dialog-centered">' +
                '<div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden; background: #000; color: #fff;">' +
                    '<div class="modal-header border-0 pb-0">' +
                        '<h5 class="modal-title fs-5 fw-bold" id="videoPlayerModalTitle">Video</h5>' +
                        '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>' +
                    '</div>' +
                    '<div class="modal-body p-3 text-center">' +
                        '<div id="videoPlayerModalContent" class="ratio ratio-16x9 rounded overflow-hidden bg-black">' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>';
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        modal = document.getElementById('videoPlayerModal');
        modal.addEventListener('hidden.bs.modal', function () {
            var container = document.getElementById('videoPlayerModalContent');
            if (container) container.innerHTML = '';
        });
    }

    document.getElementById('videoPlayerModalTitle').innerText = title;
    var container = document.getElementById('videoPlayerModalContent');

    var ytMatch = videoUrl ? videoUrl.match(/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/i) : null;
    if (ytMatch && ytMatch[1]) {
        container.innerHTML = '<iframe src="https://www.youtube-nocookie.com/embed/' + ytMatch[1] + '?autoplay=1&rel=0" class="w-100 h-100 border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    } else if (videoUrl) {
        var poster = thumb ? thumb.src : '';
        container.innerHTML = '<video controls autoplay class="w-100 h-100 rounded" poster="' + poster + '"><source src="' + videoUrl + '" type="video/mp4">Your browser does not support the video tag.</video>';
    } else {
        container.innerHTML = '<div class="d-flex flex-column align-items-center justify-content-center h-100 text-white-50 p-4"><i class="fa-solid fa-film fa-3x mb-3 text-secondary"></i><p class="mb-0">No video link has been configured for this item.</p></div>';
    }

    var bsModal = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);
    bsModal.show();
}

function openPresentationModal(el) {
    var card = el.closest('.dbim-pres-card');
    var img = card ? card.querySelector('.dbim-pres-img') : null;
    var title = card ? (card.querySelector('.dbim-pres-title')?.innerText || 'Presentation View') : 'Presentation View';
    
    var modal = document.getElementById('presPreviewModal');
    if (!modal) {
        var modalHtml = '<div class="modal fade" id="presPreviewModal" tabindex="-1" aria-hidden="true" style="z-index: 2500;">' +
            '<div class="modal-dialog modal-lg modal-dialog-centered">' +
                '<div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden; background: #fff;">' +
                    '<div class="modal-header" style="background: #500a2f; color: #fff;">' +
                        '<h5 class="modal-title fs-5 fw-bold" id="presPreviewModalTitle">Presentation Slide</h5>' +
                        '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>' +
                    '</div>' +
                    '<div class="modal-body p-3 text-center bg-light">' +
                        '<img id="presPreviewModalImg" src="" alt="Slide" class="img-fluid rounded border shadow-sm" style="max-height: 75vh; object-fit: contain;">' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>';
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        modal = document.getElementById('presPreviewModal');
    }
    document.getElementById('presPreviewModalTitle').innerText = title;
    if (img) document.getElementById('presPreviewModalImg').src = img.src;
    var bsModal = new bootstrap.Modal(modal);
    bsModal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Strictly strip all contenteditable attributes on public frontend
    document.querySelectorAll('[contenteditable]').forEach(function(el) {
        el.removeAttribute('contenteditable');
    });

    var activePill = document.querySelector('.inner-pill-bar .inner-pill-link.active');
    if (activePill) {
        activePill.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
    }
    initAllDbimTables();

    // Check if album query parameter is present in URL
    var params = new URLSearchParams(window.location.search);
    var albumSlug = params.get('album');
    if (albumSlug) {
        openPhotoAlbum(albumSlug);
    } else {
        // Guarantee Albums View is shown and Detail View is hidden by default
        document.querySelectorAll('.dbim-photo-gallery-section').forEach(function(sec) {
            sec.classList.remove('viewing-album');
            var albumsView = sec.querySelector('.dbim-albums-view');
            var detailView = sec.querySelector('.dbim-album-detail-view');
            if (albumsView) albumsView.style.setProperty('display', 'block', 'important');
            if (detailView) detailView.style.setProperty('display', 'none', 'important');
        });
    }
});

// Handle browser Back / Forward buttons for album navigation
window.addEventListener('popstate', function(e) {
    var params = new URLSearchParams(window.location.search);
    var album = params.get('album');
    if (album) {
        openPhotoAlbum(album);
    } else {
        closePhotoAlbum();
    }
});
</script>
@endsection
