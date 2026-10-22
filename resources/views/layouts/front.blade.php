<!DOCTYPE html>
<html lang="{{ session('locale', 'en') }}" class="default-theme group1" id="htmlRoot">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @php
        $pageTitle = trim($__env->yieldContent('title'));
        $pageTitle = html_entity_decode($pageTitle, ENT_QUOTES, 'UTF-8');
        $siteNameSuffix = session('locale') == 'hi' ? 'वस्त्र समिति | भारत सरकार' : 'Textiles Committee | Government of India';
        $fullTitle = $pageTitle ? ($pageTitle . ' | ' . $siteNameSuffix) : (session('locale') == 'hi' ? 'वस्त्र समिति | वस्त्र मंत्रालय | भारत सरकार' : 'Textiles Committee | Ministry of Textiles | Government of India');
    @endphp

    <!-- Dynamic Title & Search Engine Visibility for Textiles Committee -->
    <title>{{ $fullTitle }}</title>
    
    <!-- Official Textiles Committee Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Textiles_Committee_Logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/Textiles_Committee_Logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/Textiles_Committee_Logo.png') }}">

    <!-- Search Engine Optimization (SEO) & Discoverability for Textiles Committee -->
    <meta name="description" content="{{ $settings['about_us_text_en'] ?? 'Official Portal of Textiles Committee, Ministry of Textiles, Government of India. Statutory body established under the Textiles Committee Act, 1963 for textile testing, quality assurance, SAMARTH, export certification, and handloom mark.' }}">
    <meta name="keywords" content="Textiles Committee, Ministry of Textiles, Government of India, Textiles Committee Act 1963, Textile Testing Laboratories, Handloom Mark, SAMARTH, Certificate of Origin, Quality Inspection, Mumbai Textiles Committee, Indian Textiles, texcom, textilescommittee.nic.in, textilescommittee.gov.in">
    <meta name="author" content="Textiles Committee, Ministry of Textiles, Government of India">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph (OG) Meta Tags for Social Sharing & Search Crawlers -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Textiles Committee | Ministry of Textiles">
    <meta property="og:title" content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ $settings['about_us_text_en'] ?? 'Official Portal of Textiles Committee, Ministry of Textiles, Government of India.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('assets/images/Textiles_Committee_Logo.png') }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ $settings['twitter_handle'] ?? '@TexComIndia' }}">
    <meta name="twitter:title" content="{{ $fullTitle }}">
    <meta name="twitter:description" content="{{ $settings['about_us_text_en'] ?? 'Official Portal of Textiles Committee, Ministry of Textiles, Government of India.' }}">
    <meta name="twitter:image" content="{{ asset('assets/images/Textiles_Committee_Logo.png') }}">

    <!-- Schema.org GovernmentOrganization Structured Data for Google Rich Snippets -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "GovernmentOrganization",
        "name": "Textiles Committee",
        "alternateName": ["वस्त्र समिति", "Textiles Committee India", "TexCom"],
        "url": "{{ url('/') }}",
        "logo": "{{ asset('assets/images/Textiles_Committee_Logo.png') }}",
        "description": "Statutory body established under the Textiles Committee Act, 1963 by the Ministry of Textiles, Government of India, to ensure quality assurance, testing laboratories, export promotion, and skill development.",
        "parentOrganization": {
            "@type": "GovernmentOrganization",
            "name": "Ministry of Textiles",
            "alternateName": "वस्त्र मंत्रालय",
            "url": "https://texmin.gov.in"
        },
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "P. Balu Road, Prabhadevi",
            "addressLocality": "Mumbai",
            "addressRegion": "Maharashtra",
            "postalCode": "400025",
            "addressCountry": "IN"
        },
        "contactPoint": [
            {
                "@type": "ContactPoint",
                "telephone": "+91-22-66527500",
                "contactType": "Customer Support",
                "areaServed": "IN",
                "availableLanguage": ["English", "Hindi"]
            }
        ],
        "sameAs": [
            "https://x.com/TexComIndia",
            "https://www.facebook.com/textilescommittee/",
            "https://www.youtube.com/@TexComIndia",
            "https://www.instagram.com/textilescommitteeindia/"
        ]
    }
    </script>
    
    <!-- Google Fonts: Official Noto Sans & Merriweather (Ministry of Textiles DBIM Typography) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,400&family=Noto+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- DBIM Toolkit & Live Texmin Styles -->
    <link rel="stylesheet" href="{{ asset('css/live_texmin_1.css') }}">
    <link rel="stylesheet" href="{{ asset('css/live_texmin_2.css') }}">
    <!-- Leaflet GIS Map Stylesheet (Local) -->
    <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}">

    <style>
        :root {
            --gov-maroon: #6c1340;
            --gov-maroon-dark: #500d2e;
            --gov-maroon-light: #8c1e55;
            --gov-maroon-soft: #fcf4f8;
            --gov-ticker-bg: #c6c6c6;
            --gov-quote-bg: #ebeaea;
            --gov-text-main: #150202;
            --gov-text-muted: #555555;
            --gov-border: #dee2e6;
            --gov-border-light: #ececec;
            --font-scale: 1;
        }

        * {
            box-sizing: border-box;
        }

        html {
            font-size: calc(62.5% * var(--font-scale)) !important;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Noto Sans', system-ui, -apple-system, sans-serif !important;
            color: var(--gov-text-main) !important;
            background-color: #ffffff !important;
            overflow-x: hidden;
            font-size: 1.65rem !important;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        /* Skip to Content Links (WCAG 2.1 / GIGW Accessible) */
        .skip-to-main-link {
            position: absolute;
            top: -120px;
            left: 16px;
            background: #6c1340;
            color: #ffffff !important;
            padding: 12px 22px;
            font-size: 1.6rem !important;
            font-weight: 700;
            font-family: 'Noto Sans', sans-serif;
            z-index: 999999;
            text-decoration: none !important;
            border-radius: 0 0 6px 6px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.35);
            transition: top 0.2s ease-in-out;
        }
        .skip-to-main-link:focus,
        .skip-to-main-link:active {
            top: 0;
            outline: 3px solid #ffcc00 !important;
        }
        .skip-to-nav-link {
            left: 190px;
        }

        /* ============================================================
           ACCESSIBILITY MODES & CONTROLS DRAWER
           ============================================================ */

        /* 1. DARK CONTRAST MODE */
        html.contrast-mode body {
            background-color: #000000 !important;
            color: #ffff00 !important;
        }
        html.contrast-mode .exact-header-wrap,
        html.contrast-mode .gov-nav-bar-exact,
        html.contrast-mode .portal-footer,
        html.contrast-mode .section-clean-card,
        html.contrast-mode .recent-docs-wrap,
        html.contrast-mode .social-unified-board,
        html.contrast-mode .pm-quote-box,
        html.contrast-mode .doc-item-box,
        html.contrast-mode .links-box,
        html.contrast-mode .offerings-list-box {
            background-color: #0d0d0d !important;
            color: #ffff00 !important;
            border-color: #ffff00 !important;
        }
        html.contrast-mode a,
        html.contrast-mode .section-heading,
        html.contrast-mode .gov-nav-a,
        html.contrast-mode .exact-brand-title,
        html.contrast-mode .exact-brand-sub {
            color: #00ffff !important;
            border-color: #00ffff !important;
        }
        html.contrast-mode .exact-search-box {
            background: #111111 !important;
            border-color: #ffff00 !important;
        }
        html.contrast-mode .exact-search-box input {
            color: #ffff00 !important;
        }

        /* 2. INVERT MODE */
        html.invert-mode {
            filter: invert(100%) hue-rotate(180deg);
        }
        html.invert-mode img,
        html.invert-mode video,
        html.invert-mode [style*="background-image"] {
            filter: invert(100%) hue-rotate(180deg);
        }

        /* 3. SATURATION / GRAYSCALE MODE */
        html.desaturate-mode {
            filter: grayscale(100%);
        }

        /* 6. HIGHLIGHT LINKS MODE */
        html.highlight-links-mode a {
            background-color: #ffff00 !important;
            color: #000000 !important;
            text-decoration: underline 2.5px solid #000000 !important;
            font-weight: 700 !important;
            outline: 2px solid #000000 !important;
        }

        /* 7. HIDE IMAGES MODE */
        html.hide-images-mode img,
        html.hide-images-mode .hero-banner-wrap,
        html.hide-images-mode [style*="background-image"] {
            opacity: 0 !important;
            visibility: hidden !important;
        }

        /* 8. LARGE CURSOR MODE */
        html.large-cursor-mode,
        html.large-cursor-mode * {
            cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='38' height='38' viewBox='0 0 24 24'%3E%3Cpath fill='%236c1340' stroke='%23ffffff' stroke-width='1.5' d='M4.5 3.5l11 11-4.5 1 3 5-2 1-3-5-3.5 3.5z'/%3E%3C/svg%3E"), auto !important;
        }

        /* ACCESSIBILITY OFFCANVAS DRAWER */
        .a11y-offcanvas {
            width: 360px !important;
            max-width: 92vw !important;
            background: #ffffff !important;
            box-shadow: -8px 0 32px rgba(0, 0, 0, 0.18) !important;
            border-left: 1px solid #e5d8df !important;
            z-index: 100060 !important;
        }
        .a11y-header {
            padding: 18px 22px;
            border-bottom: 1px solid #f0e6ec;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .a11y-title {
            margin: 0;
            font-size: 1.85rem;
            font-weight: 600;
            font-family: 'Noto Sans', sans-serif;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .a11y-human-icon {
            color: #6c1340;
            flex-shrink: 0;
        }
        .a11y-body {
            padding: 20px 18px;
        }
        .a11y-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }
        .a11y-card {
            border: 1.5px solid #6c1340;
            border-radius: 8px;
            background: #ffffff;
            color: #6c1340;
            min-height: 98px;
            padding: 14px 6px 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.16s ease-in-out;
            text-align: center;
            width: 100%;
        }
        .a11y-card:hover {
            background: #fbf2f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(108, 19, 64, 0.14);
        }
        .a11y-card.active {
            background: #6c1340 !important;
            color: #ffffff !important;
            border-color: #6c1340 !important;
            box-shadow: 0 4px 12px rgba(108, 19, 64, 0.28);
        }
        .a11y-card.active svg,
        .a11y-card.active .a11y-card-label,
        .a11y-card.active .a11y-text-icon {
            color: #ffffff !important;
            stroke: #ffffff;
        }
        .a11y-card.active svg[fill="currentColor"] {
            fill: #ffffff !important;
        }
        .a11y-card-icon-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 32px;
        }
        .a11y-card-label {
            font-size: 1.45rem !important;
            font-weight: 700;
            font-family: 'Noto Sans', sans-serif;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            line-height: 1.25;
            color: #6c1340;
            margin: 0;
            padding: 0 4px;
        }
        .a11y-text-icon {
            font-size: 2.6rem;
            font-weight: 700;
            line-height: 1;
            font-family: 'Noto Sans', sans-serif;
            color: #6c1340;
        }
        .a11y-reset-all-btn {
            background: transparent;
            border: 1.5px solid #6c1340;
            color: #6c1340;
            padding: 9px 20px;
            border-radius: 6px;
            font-size: 1.5rem !important;
            font-weight: 600;
            font-family: 'Noto Sans', sans-serif;
            cursor: pointer;
            transition: all 0.15s;
        }
        .a11y-reset-all-btn:hover {
            background: #6c1340;
            color: #ffffff;
        }

        /* Main Fluid Container */
        .page-container {
            width: 90%;
            /*max-width: 1400px;*/
            margin: 0 auto;
            padding: 0 24px;
        }
        @media (max-width: 991px) {
            .page-container {
                padding: 0 16px;
            }
        }

        /* 1. TOP BRANDING ROW */
        .exact-header-wrap {
            background: #ffffff;
            width: 100%;
            border-bottom: 1px solid #6c1340;
            position: relative;
            z-index: 20;
        }
        .exact-header-top {
            width: 90%;
            /*max-width: 1400px;*/
            margin: 0 auto;
            padding: 18px 24px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
            border-bottom: 1px solid #f2f2f2;
        }

        /* Left: Branding */
        .exact-brand {
            display: inline-flex;
            align-items: center;
            /*gap: 16px;*/
            text-decoration: none !important;
            color: inherit;
            flex-shrink: 0;
        }
        .exact-emblem-img {
            height: 106px;
            width: auto;
            display: block;
            object-fit: contain;
        }
        .exact-brand-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            line-height: 1.25;
        }
        .exact-brand-title {
            font-size: 2.85rem;
            font-weight: 800;
            color: #000000;
            font-family: 'Noto Sans', sans-serif;
            letter-spacing: -0.3px;
            margin: 0;
            padding: 0;
        }
        .exact-brand-sub {
            font-size: 1.95rem;
            font-weight: 600;
            color: #2b2b2b;
            font-family: 'Noto Sans', sans-serif;
            letter-spacing: -0.1px;
            margin: 3px 0 0 0;
            padding: 0;
        }

        /* Center: Search Box */
        .exact-search-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            max-width: 360px;
            margin: 0 20px;
        }
        .exact-search-box {
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 1.5px solid #ebeaea;
            border-bottom: 2.5px solid #6c1340;
            border-radius: 10px 10px 0 0;
            width: 100%;
            height: 48px;
            padding: 0 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            position: relative;
        }
        .exact-search-box input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 1.55rem;
            font-family: 'Noto Sans', sans-serif;
            color: #333333;
            width: 100%;
            padding: 0 6px;
        }
        .exact-search-box input::placeholder {
            color: #767676;
            font-size: 1.5rem;
        }
        .exact-search-divider {
            width: 1px;
            height: 30px;
            background: #e8e8e8;
            margin: 0 8px;
            flex-shrink: 0;
        }
        .exact-search-btn {
            background: transparent;
            border: none;
            padding: 0;
            cursor: pointer;
            color: #6c1340;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Center-Right: Digital India Logo */
        .exact-di-wrap {
            display: flex;
            align-items: center;
            flex-shrink: 0;
            margin: 0;
        }
        .exact-di-img {
            height: 64px;
            width: auto;
            display: block;
            object-fit: contain;
        }

        /* Far Right: Utilities */
        .exact-utilities {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }
        .exact-util-link {
            background: transparent;
            border: none;
            padding: 5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.15s ease-in-out;
        }
        .exact-util-link:hover,
        .exact-util-link:focus-visible {
            background: #f7eef2;
            outline: 2px solid #6c1340;
        }
        .exact-util-img {
            height: 32px;
            width: auto;
            display: block;
            object-fit: contain;
        }
        .exact-util-divider {
            color: #9c276a;
            font-size: 2.6rem;
            font-weight: 300;
            line-height: 1;
            user-select: none;
            opacity: 0.55;
            margin: 0 4px;
        }

        .bhashini-dropdown-btn-icon {
            color: #6c1340 !important;
        }

        /* 2. NAVIGATION BAR ROW */
        .gov-nav-bar-exact {
            background: #ffffff;
            position: sticky;
            z-index: 100;
            top: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-bottom: 1px solid #efe5eb;
        }
        .gov-nav-container-exact {
            width: 90%;
            /*max-width: 1400px;*/
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .gov-nav-ul {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0 !important;
            padding: 0;
            width: 100%;
            justify-content: space-between;
            gap: clamp(16px, 3.4vw, 56px);
        }

        .gov-nav-li {
            position: relative;
        }
        .gov-nav-a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 14px 6px 18px 6px;
            font-size: 2.15rem;
            font-weight: 700;
            font-family: 'Noto Sans', sans-serif;
            color: #1a1a1a;
            text-decoration: none !important;
            position: relative;
            transition: color 0.15s;
            white-space: nowrap;
        }
        .gov-nav-a:hover,
        .gov-nav-a:focus-visible {
            color: #6c1340;
            text-decoration: none;
            outline: none;
        }
        .gov-nav-a.active {
            color: #6c1340;
            font-weight: 700;
        }
        .gov-nav-a.active::after {
            content: '';
            position: absolute;
            bottom: 0px;
            left: 0;
            right: 0;
            height: 5px;
            background: #6c1340;
            border-radius: 3px 3px 0 0;
        }
        .gov-nav-caret {
            font-size: 1.4rem;
            color: #555555;
            transition: transform 0.2s;
            margin-left: 4px;
            font-weight: 700;
        }
        .gov-nav-li:hover .gov-nav-caret,
        .gov-nav-li:focus-within .gov-nav-caret {
            transform: rotate(180deg);
            color: #6c1340;
        }

        /* Dropdown */
        .gov-nav-drop {
            position: absolute;
            top: 100%;
            left: 0;
            background: #ffffff;
            min-width: 270px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
            border: 1px solid #ebeaea;
            border-top: 3.5px solid #6c1340;
            border-radius: 0 0 8px 8px;
            list-style: none;
            padding: 10px 0;
            margin: 0;
            display: none;
            z-index: 1100;
        }
        .gov-nav-li:hover .gov-nav-drop,
        .gov-nav-li:focus-within .gov-nav-drop {
            display: block;
        }
        .gov-nav-drop-a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 22px;
            color: #2b2b2b;
            text-decoration: none;
            font-size: 1.65rem !important;
            font-family: 'Noto Sans', sans-serif;
            font-weight: 600;
            transition: all 0.15s;
        }
        .gov-nav-drop-a:hover,
        .gov-nav-drop-a:focus-visible,
        .gov-nav-drop-a.active {
            background: #fbf4f7;
            color: #6c1340;
            padding-left: 26px;
            outline: none;
        }
        .gov-sub-arrow {
            font-size: 1.7rem;
            font-weight: 700;
            color: #888888;
            margin-left: auto;
        }
        .gov-nav-sub-li {
            position: relative;
        }
        .gov-nav-flyout {
            position: absolute;
            left: 100%;
            top: 0;
            background: #ffffff;
            min-width: 280px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
            border: 1px solid #ebeaea;
            border-top: 3.5px solid #6c1340;
            border-radius: 0 8px 8px 8px;
            list-style: none;
            padding: 8px 0;
            margin: 0;
            display: none;
            z-index: 1200;
        }
        .gov-nav-sub-li:hover > .gov-nav-flyout,
        .gov-nav-sub-li:focus-within > .gov-nav-flyout {
            display: block;
        }
        .gov-nav-gc-li {
            position: relative;
        }
        .gov-nav-flyout-3 {
            position: absolute;
            left: 100%;
            top: 0;
            background: #ffffff;
            min-width: 270px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
            border: 1px solid #ebeaea;
            border-top: 3.5px solid #6c1340;
            border-radius: 0 8px 8px 8px;
            list-style: none;
            padding: 8px 0;
            margin: 0;
            display: none;
            z-index: 1300;
        }
        .gov-nav-gc-li:hover > .gov-nav-flyout-3,
        .gov-nav-gc-li:focus-within > .gov-nav-flyout-3 {
            display: block;
        }

        /* Texmin / GIGW Official Content Components */
        .gov-page-content {
            font-size: 1.65rem !important;
            line-height: 1.8;
            color: #150202;
        }
        .gov-page-content p {
            margin-bottom: 1.4rem;
        }
        .gov-page-content h2 {
            font-size: 2.8rem !important;
            font-weight: 700;
            color: #6c1340;
            margin-top: 2rem;
            margin-bottom: 1.2rem;
            border-bottom: 2px solid #f2e2eb;
            padding-bottom: 8px;
        }
        .gov-page-content h3 {
            font-size: 2.2rem !important;
            font-weight: 600;
            color: #150202;
            margin-top: 1.6rem;
            margin-bottom: 1rem;
        }
        .gov-table-wrap {
            overflow-x: auto;
            margin: 24px 0;
            border-radius: 6px;
            border: 1px solid #e1d3dc;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
        }
        .gov-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1.5rem;
            margin-bottom: 0;
        }
        .gov-table thead th {
            background: #6c1340;
            color: #ffffff;
            font-weight: 700;
            padding: 13px 16px;
            border: 1px solid #570e33;
            text-align: left;
            vertical-align: middle;
        }
        .gov-table tbody td {
            padding: 12px 16px;
            border: 1px solid #ebdbe3;
            vertical-align: middle;
        }
        .gov-table tbody tr:nth-child(even) {
            background-color: #fdfafd;
        }
        .gov-table tbody tr:hover {
            background-color: #f7eef3;
        }
        .gov-callout {
            background: #faf4f7;
            border-left: 4px solid #6c1340;
            padding: 16px 20px;
            border-radius: 0 6px 6px 0;
            margin: 20px 0;
            font-size: 1.55rem;
        }
        .gov-officer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
            margin: 24px 0;
        }
        .gov-officer-card {
            background: #ffffff;
            border: 1px solid #e8e0e5;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: transform 0.2s;
        }
        .gov-officer-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(108, 19, 64, 0.12);
        }
        .gov-officer-img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #6c1340;
            margin: 0 auto 14px;
        }
        .gov-officer-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: #6c1340;
            margin-bottom: 4px;
        }
        .gov-officer-role {
            font-size: 1.55rem !important;
            color: #555555;
            font-weight: 600;
            margin-bottom: 8px;
        }

        /* Mobile Nav Toggle */
        .gov-mobile-toggle {
            display: none;
            background: transparent;
            border: none;
            font-size: 1.7rem;
            font-weight: 700;
            color: #6c1340;
            cursor: pointer;
            padding: 12px 0;
            width: 100%;
            text-align: left;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1200px) {
            .exact-header-top {
                padding: 18px 24px 16px;
                gap: 16px;
            }
            .gov-nav-container-exact {
                padding: 0 24px;
            }
            .exact-emblem-img {
                height: 88px;
            }
            .exact-brand-title {
                font-size: 2.3rem;
            }
            .exact-brand-sub {
                font-size: 1.65rem;
            }
            .gov-nav-a {
                font-size: 1.85rem;
                padding: 12px 4px 14px;
            }
        }

        @media (max-width: 991px) {
            .exact-header-top {
                padding: 12px 16px;
                flex-wrap: wrap;
                row-gap: 12px;
            }
            .exact-brand {
                order: 1;
            }
            .exact-di-wrap {
                order: 2;
                margin-left: auto;
            }
            .exact-di-img {
                height: 44px;
            }
            .exact-utilities {
                order: 3;
                width: 100%;
                justify-content: flex-end;
                padding-top: 8px;
                border-top: 1px dashed #eedde5;
                flex-wrap: wrap;
                gap: 8px;
            }
            .exact-search-wrap {
                order: 4;
                width: 100%;
                max-width: 100%;
                margin: 4px 0 0;
            }
            .exact-search-box {
                max-width: 100%;
            }

            .gov-mobile-toggle {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 12px 0;
                border-bottom: 2px solid #6c1340;
            }
            .gov-nav-ul {
                display: none;
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
                gap: 0;
                padding: 8px 0 16px;
            }
            .gov-nav-ul.show {
                display: flex;
            }
            .gov-nav-li {
                width: 100%;
                border-bottom: 1px solid #f2edf0;
            }
            .gov-nav-a {
                width: 100%;
                padding: 12px 8px;
                font-size: 1.65rem;
                justify-content: space-between;
            }
            .gov-nav-drop {
                position: static;
                box-shadow: none;
                border: none;
                border-left: 3px solid #6c1340;
                background: #fbf5f8;
                padding: 4px 0 8px 12px;
                display: none;
                width: 100%;
            }
            .gov-nav-li.active-mobile-sub .gov-nav-drop {
                display: block;
            }
        }

        @media (max-width: 575px) {
            .exact-header-top {
                padding: 10px 12px;
            }
            .exact-emblem-img {
                height: 56px;
            }
            .exact-brand-title {
                font-size: 1.85rem;
            }
            .exact-brand-sub {
                font-size: 1.45rem;
            }
            .exact-di-img {
                height: 38px;
            }
            .exact-util-divider {
                display: none;
            }
            .exact-utilities {
                justify-content: space-between;
                gap: 6px;
            }
            .font-resize-btn {
                font-size: 1.4rem;
                padding: 4px 6px;
            }
        }

        /* 3. HERO BANNER SLIDER */
        .hero-banner-wrap {
            position: relative;
            width: 100%;
            overflow: hidden;
            background: #111111;
        }
        .hero-banner-track {
            display: flex;
            transition: transform 0.6s ease-in-out;
            width: 100%;
        }
        .hero-banner-slide {
            min-width: 100%;
            position: relative;
        }
        .hero-banner-slide img {
            width: 100%;
            height: auto;
            max-height: 520px;
            object-fit: cover;
            display: block;
        }
        .hero-arrow-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.45);
            color: #ffffff;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            font-size: 2rem;
            transition: background 0.2s;
        }
        .hero-arrow-btn:hover {
            background: #6c1340;
        }
        .hero-arrow-prev { left: 20px; }
        .hero-arrow-next { right: 20px; }
        .hero-dots-badge {
            position: absolute;
            background: #faebf2;
            bottom: 16px;
            right: 28px;
            display: flex;
            align-items: center;
            gap: 6px;
            /*background: rgba(0, 0, 0, 0.4);*/
            padding: 1px 12px;
            border-radius: 20px;
            z-index: 10;
        }
        .hero-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #db70a6;
            border: none;
            cursor: pointer;
            padding: 0;
            transition: all 0.2s;
        }
        .hero-dot.active {
            background: #ff5b8e;
            width: 20px;
            border-radius: 4px;
        }
        .hero-pause-btn {
            background: transparent;
            border: none;
            color: #6c1340;
            cursor: pointer;
            font-size: 1.6rem;
            display: flex;
            align-items: center;
            padding: 0 0 0 6px;
        }

        /* 4. ANNOUNCEMENTS TICKER BAR */
        .announcements-bar {
            background: #c6c6c6;
            padding: 15px 0;
            display: flex;
            margin-top: 2px;
            align-items: center;
            border-top: 1px solid #d4c8cf;
            border-bottom: 1px solid #d4c8cf;
        }
        .announcements-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 1.9rem;
            font-weight: 700;
            font-family: 'Noto Sans', sans-serif;
            color: #6c1340;
            white-space: nowrap;
            padding-right: 18px;
        }
        .announcements-ticker-wrap {
            flex-grow: 1;
            overflow: hidden;
            white-space: nowrap;
            position: relative;
        }
        .announcements-track {
            display: inline-block;
            animation: marqueeTicker 30s linear infinite;
        }
        .announcements-track:hover {
            animation-play-state: paused;
        }
        .ticker-link {
            color: #222222;
            text-decoration: none;
            margin-right: 44px;
            font-size: 1.6rem !important;
            font-family: 'Noto Sans', sans-serif;
            font-weight: 500;
        }
        .ticker-link:hover {
            color: #6c1340;
            text-decoration: underline;
        }
        @keyframes marqueeTicker {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        /* 5. PM MODI QUOTE CARD */
        .pm-quote-section {
            background: #ffffff;
            padding: 0px 0 20px;
        }
        .pm-quote-box {
            background: #ebeaea;
            border-radius: 8px;
            /*padding: 32px 40px 48px;*/
            padding: 5rem 25rem 5rem;
            display: flex;
            align-items: center;
            gap: 36px;
            border: 1px solid #e0d5db;
        }
        @media (max-width: 768px) {
            .pm-quote-box {
                flex-direction: column;
                padding: 24px 20px;
                gap: 20px;
            }
        }
        .pm-quote-avatar-wrap {
            flex-shrink: 0;
            width: 21%;
            /*width: 140px;*/
            height: 23%;
            /*height: 140px;*/
            min-width: 140px;
            border-radius: 50%;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(35,35,47,.08);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #6c1340;
        }
        @media (max-width: 991px) {
            .pm-quote-avatar-wrap {
                width: 120px;
                height: 120px;
                min-width: 120px;
            }
        }
        .pm-quote-avatar-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        .pm-quote-content {
            flex-grow: 1;
        }
        .pm-quote-mark {
            font-size: 4.8rem !important;
            font-family: 'Material Symbols Outlined', sans-serif;
            color: #6c1340;
            line-height: 1;
            display: inline;
            vertical-align: middle;
        }
        .pm-quote-text {
            font-size: 2.4rem !important;
            font-family: 'Noto Sans', sans-serif;
            font-weight: 500;
            line-height: 36px !important;
            letter-spacing: -0.12px;
            color: #6c1340 !important;
            display: inline;
        }
        .pm-quote-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 18px;
        }
        .pm-quote-meta {
            font-size: 1.6rem !important;
            color: #555555;
            font-weight: 600;
            font-family: 'Noto Sans', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .pm-quote-date {
            font-size: 1.5rem !important;
            color: #777777;
            font-family: 'Noto Sans', sans-serif;
            margin-top: 3px;
        }
        .btn-read-more {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1.5px solid #6c1340;
            background: #ffffff;
            color: #6c1340;
            padding: 10px 18px;
            border-radius: 4px;
            font-size: 1.55rem !important;
            font-weight: 600;
            font-family: 'Noto Sans', sans-serif;
            text-decoration: none;
            text-transform: uppercase;
            transition: all 0.2s;
        }
        .btn-read-more:hover {
            background: #6c1340;
            color: #ffffff;
        }

        /* 6. SECTION HEADINGS (Exact Noto Sans Bold in Deep Maroon #6c1340) */
        .section-heading-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        .section-heading-icon {
            font-size: 2.8rem;
            color: #6c1340;
        }
        .section-heading {
            font-size: 2.8rem !important;
            font-weight: 700;
            font-family: 'Noto Sans', sans-serif;
            color: #6c1340 !important;
            margin: 0;
            letter-spacing: -0.2px;
        }

        /* 7. ABOUT US & DIGNITARIES */
        .about-section {
            background: #ffffff;
            padding: 34px 0;
        }
        .about-dignitaries-grid {
            display: grid;
            grid-template-columns: 52% 48%;
            gap: 36px;
            align-items: start;
        }
        @media (max-width: 991px) {
            .about-dignitaries-grid {
                grid-template-columns: 1fr;
            }
        }
        .about-text {
            font-size: 2.0rem !important;
            line-height: 34px !important;
            font-family: 'Noto Sans', sans-serif;
            color: #150202;
            text-align: justify;
            margin-bottom: 24px;
        }
        .about-readmore-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #6c1340;
            font-weight: 700;
            font-size: 1.7rem !important;
            text-decoration: underline;
            margin-left: 8px;
            white-space: nowrap;
            transition: color 0.2s ease, transform 0.2s ease;
        }
        .about-readmore-btn:hover {
            color: #9b205f;
            transform: translateX(2px);
        }
        .about-action-btns-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 12px;
        }
        .about-pill-btn {
            flex: 1;
            min-width: 130px;
            min-height: 72px;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1.5px solid #6c1340;
            background: #ffffff;
            color: #6c1340;
            padding: 14px 12px;
            border-radius: 4px;
            font-size: 1.65rem !important;
            font-weight: 600;
            font-family: 'Noto Sans', sans-serif;
            text-decoration: none;
            transition: all 0.2s;
        }
        .about-pill-title {
            font-size: 1.65rem !important;
            font-weight: 600;
            color: inherit;
            margin: 0;
            line-height: 1.2;
            text-align: center;
        }
        .about-pill-btn:hover {
            background: #6c1340;
            color: #ffffff;
        }

        /* Dignitaries 3-card Row matching .group1 .about-section .about-section-right */
        .dignitaries-row {
            margin-top: 4%;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        .dignitary-card-exact {
            background: transparent;
            border: none;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.2s;
        }
        .dignitary-card-exact:hover {
            transform: translateY(-2px);
        }
        .dignitary-photo {
            width: 172px !important;
            height: 172px !important;
            object-fit: contain;
            border: 2px solid #ebeaea;
            border-bottom: 6px solid #6c1340;
            border-radius: 4px;
            background: #fafafa;
            margin: 0 auto 10px;
            display: block;
        }
        .dignitary-name-exact {
            font-size: 1.8rem !important;
            font-weight: 700;
            font-family: 'Noto Sans', sans-serif;
            color: #150202;
            margin-bottom: 4px;
            line-height: 1.3;
        }
        .dignitary-desig-exact {
            font-size: 1.45rem !important;
            font-family: 'Noto Sans', sans-serif;
            font-weight: 500;
            color: #444444;
            line-height: 1.35;
        }

        /* 8. KEY OFFERINGS & WHAT'S NEW */
        .offerings-whatsnew-section {
            background: #ebeaea;
            padding: 24px 0 35px;
        }
        .offerings-grid {
            display: grid;
            grid-template-columns: 65% 35%;
            /*grid-template-columns: 58% 42%;*/
            gap: 32px;
        }
        @media (max-width: 991px) {
            .offerings-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Key Offerings Tabs */
        .offerings-tabs-header {
            margin-bottom: 12px;
            display: flex;
            border: 1.5px solid #6c1340;
            border-radius: 4px;
            overflow: hidden;
        }
        .offerings-tab-btn {
            flex: 1;
            background: #ffffff;
            color: #6c1340;
            border: none;
            padding: 13px 20px;
            font-size: 1.75rem !important;
            font-weight: 600;
            font-family: 'Noto Sans', sans-serif;
            cursor: pointer;
            text-align: center;
            border-right: 1px solid #6c1340;
            transition: all 0.2s;
        }
        .offerings-tab-btn:last-child {
            border-right: none;
        }
        .offerings-tab-btn.active {
            background: #6c1340;
            color: #ffffff;
        }
        .offerings-list-box {
            border-radius: 4px;
            background: #ffffff;
            padding: 12px;
        }
        .offerings-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 22px;
            border-bottom: 1px solid #f0f0f0;
            color: #150202;
            text-decoration: none;
            font-size: 1.65rem !important;
            font-family: 'Noto Sans', sans-serif;
            font-weight: 500;
            transition: background 0.15s;
        }
        .offerings-item:last-child {
            border-bottom: none;
        }
        .offerings-item:hover {
            background: #faf4f7;
            color: #6c1340;
        }
        .offerings-item i {
            color: #6c1340;
            font-size: 1.6rem;
        }
        .btn-view-more-outline {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1.5px solid #6c1340;
            color: #6c1340;
            background: #ffffff;
            font-size: 1.55rem !important;
            font-weight: 700;
            font-family: 'Noto Sans', sans-serif;
            padding: 8px 18px;
            border-radius: 4px;
            text-decoration: none;
            text-transform: uppercase;
            float: right;
            margin-top: 14px;
            transition: all 0.2s;
        }
        .btn-view-more-outline:hover {
            background: #6c1340;
            color: #ffffff;
        }

        /* What's New Solid Card matching .whatsnewlistview */
        .whatsnew-card-solid {
            background: #6c1340;
            border-radius: 4px;
            padding: 22px 26px;
            color: #ffffff;
            min-height: 330px;
            overflow-y: auto;
            position: relative;
        }
        .whatsnew-card-solid::-webkit-scrollbar {
            width: 6px;
        }
        .whatsnew-card-solid::-webkit-scrollbar-track {
            background: #ffffff;
            border-radius: 15px;
            border: .5px solid #ebadcc;
        }
        .whatsnew-card-solid::-webkit-scrollbar-thumb {
            background: #a32966;
            border-radius: 15px;
        }
        .whatsnew-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.22);
            color: #ffffff;
            text-decoration: none;
            font-size: 1.65rem !important;
            font-family: 'Noto Sans', sans-serif;
            font-weight: 500;
            line-height: 1.5;
            transition: opacity 0.2s;
        }
        .whatsnew-item:last-of-type {
            border-bottom: none;
        }
        .whatsnew-item:hover {
            opacity: 0.85;
            text-decoration: underline;
        }
        .whatsnew-item i {
            font-size: 1.6rem;
            margin-left: 10px;
            flex-shrink: 0;
        }
        .btn-view-more-white {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1.5px solid #ffffff;
            color: #ffffff;
            background: transparent;
            font-size: 1.55rem !important;
            font-weight: 700;
            font-family: 'Noto Sans', sans-serif;
            padding: 8px 18px;
            border-radius: 4px;
            text-decoration: none;
            text-transform: uppercase;
            float: right;
            margin-top: 14px;
            transition: all 0.2s;
        }
        .btn-view-more-white:hover {
            background: #ffffff;
            color: #6c1340;
        }

        /* 9. RECENT DOCUMENTS, PERSONAS & IMPORTANT LINKS */
        .tri-section {
            background: #ffffff;
            padding: 24px 0 35px;
        }
        .tri-grid {
            display: grid;
            grid-template-columns: 38% 28% 34%;
            gap: 28px;
        }
        @media (max-width: 991px) {
            .tri-grid {
                grid-template-columns: 1fr;
            }
        }

        /* 9. RECENT DOCUMENTS & GOVERNMENT SPONSORED SCHEMES (SIDE BY SIDE) */
        .docs-schemes-section {
            background: #ffffff;
            padding: 34px 0 44px;
            border-bottom: 1px solid #f0e6eb;
        }
        .docs-schemes-grid {
            display: grid;
            grid-template-columns: 36% 64%;
            gap: 32px;
            align-items: start;
        }
        @media (max-width: 991px) {
            .docs-schemes-grid {
                grid-template-columns: 1fr;
                gap: 35px;
            }
        }

        /* Left: Recent Docs 2x2 */
        .docs-2x2-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }
        .doc-item-box {
            border: 1px solid #e5d7dc;
            border-radius: 4px;
            padding: 16px 18px;
            background: #ffffff;
            min-height: 100px;
            text-decoration: none;
            display: block;
            transition: all 0.2s;
        }
        .doc-item-box:hover {
            border-color: #6c1340;
            box-shadow: 0 4px 12px rgba(108, 19, 64, 0.1);
        }
        .doc-box-title {
            font-size: 1.75rem !important;
            font-weight: 700;
            font-family: 'Noto Sans', sans-serif;
            color: #6c1340;
            margin-bottom: 6px;
            line-height: 1.35;
        }
        .doc-box-sub {
            font-size: 1.5rem !important;
            font-family: 'Noto Sans', sans-serif;
            color: #444444;
            line-height: 1.4;
        }

        /* Right: Government Sponsored Schemes (Current Theme) */
        .govt-schemes-box {
            background: #ffffff;
        }
        .govt-schemes-theme-desc {
            font-size: 1.65rem !important;
            font-family: 'Noto Sans', sans-serif;
            color: #333333;
            line-height: 1.65;
            margin: 8px 0 18px;
        }
        .govt-stats-theme-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px 10px;
        }
        @media (max-width: 680px) {
            .govt-stats-theme-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        .govt-stat-theme-card {
            background: #fdf5f8;
            border: 1px solid #ebdbe2;
            border-radius: 6px;
            padding: 14px 8px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 95px;
            transition: all 0.2s ease;
        }
        .govt-stat-theme-card:hover {
            background: #ffffff;
            border-color: #6c1340;
            box-shadow: 0 4px 12px rgba(108, 19, 64, 0.12);
            transform: translateY(-2px);
        }
        .govt-stat-theme-label {
            font-size: 1.45rem !important;
            font-family: 'Noto Sans', sans-serif;
            font-weight: 600;
            color: #333333;
            line-height: 1.3;
            min-height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 4px;
        }
        .govt-stat-theme-value {
            font-size: 2.8rem !important;
            font-family: 'Noto Sans', sans-serif;
            font-weight: 800;
            color: #6c1340;
            line-height: 1.1;
            margin-top: 4px;
            letter-spacing: -0.3px;
        }

        /* Explore User Personas */
        .persona-center-card {
            text-align: center;
            padding: 8px 12px;
        }
        .persona-circle-graphic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #ffdce5;
            margin: 0 auto 14px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .persona-circle-graphic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .persona-title-bold {
            font-size: 1.75rem !important;
            font-weight: 700;
            font-family: 'Noto Sans', sans-serif;
            color: #6c1340;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .persona-dots-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #777777;
            font-size: 1.4rem;
        }
        .persona-dot-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #777777;
            display: inline-block;
        }
        .persona-dot-indicator.active {
            background: #6c1340;
            width: 10px;
            height: 10px;
        }

        /* Important Links matching .importantlinklist */
        .links-box {
            border: 1px solid #e5d7dc;
            border-radius: 4px;
            background: #ffffff;
            overflow: hidden;
            max-height: 310px;
            overflow-y: auto;
        }
        .links-box::-webkit-scrollbar {
            width: 6px;
        }
        .links-box::-webkit-scrollbar-track {
            background: #fff;
            border-radius: 15px;
            border: .5px solid #ebadcc;
        }
        .links-box::-webkit-scrollbar-thumb {
            background: #a32966;
            border-radius: 15px;
        }
        .link-row-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 18px;
            border-bottom: 1px solid #f0f0f0;
            color: #333333;
            text-decoration: none;
            font-size: 1.65rem !important;
            font-family: 'Noto Sans', sans-serif;
            font-weight: 500;
            transition: background 0.15s;
        }
        .link-row-item:last-child {
            border-bottom: none;
        }
        .link-row-item:hover {
            background: #fbf4f7;
            color: #6c1340;
        }
        .link-row-item i {
            color: #6c1340;
            font-size: 1.5rem;
        }

        /* 10. IN SOCIAL MEDIA (.layout4-social) */
        .social-full-section {
            background: #6c1340;
            padding: 44px 0 50px;
            margin-top: 30px;
            color: #ffffff;
        }
        .social-heading-white {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
            margin-bottom: 24px;
        }
        .social-heading-white h2 {
            font-size: 2.8rem !important;
            font-weight: 700;
            font-family: 'Noto Sans', sans-serif;
            margin: 0;
            color: #ffffff;
        }
        .social-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        @media (max-width: 991px) {
            .social-cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 575px) {
            .social-cards-grid {
                grid-template-columns: 1fr;
            }
        }
        .social-feed-card {
            background: #ffffff;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            height: 420px;
            display: flex;
            flex-direction: column;
            border: 1px solid #ebdbe2;
        }
        .social-card-head {
            background: #ffffff;
            color: #6c1340;
            padding: 12px 16px;
            font-size: 1.8rem !important;
            font-weight: 700;
            font-family: 'Noto Sans', sans-serif;
            border-bottom: 1px solid #f2e9ee;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }
        .social-card-head span {
            color: #6c1340;
        }
        .social-feed-body {
            flex-grow: 1;
            overflow-y: scroll;
            overflow-x: hidden;
            padding: 12px 12px 16px;
            scrollbar-width: thin;
            scrollbar-color: #9b1a55 #f7eff3;
            background: #ffffff;
        }
        .social-feed-body::-webkit-scrollbar {
            width: 6px;
        }
        .social-feed-body::-webkit-scrollbar-track {
            background: #f7eff3;
            border-radius: 6px;
        }
        .social-feed-body::-webkit-scrollbar-thumb {
            background: #9b1a55;
            border-radius: 6px;
        }
        .social-feed-body::-webkit-scrollbar-thumb:hover {
            background: #6c1340;
        }

        /* Post Items - Common & Card Specific */
        .tweet-post-box {
            border: 1px solid #e1e8ed;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 14px;
            background: #ffffff;
        }
        .tweet-post-box:last-child {
            margin-bottom: 0;
        }
        .tweet-thumb-img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 8px;
            display: block;
        }
        .tweet-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 1.45rem !important;
            color: #536471;
            font-family: 'Noto Sans', sans-serif;
            margin-bottom: 6px;
        }
        .tweet-actions-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 1.45rem !important;
            color: #536471;
            border-top: 1px solid #eff3f4;
            border-bottom: 1px solid #eff3f4;
            padding: 8px 0;
            margin-bottom: 10px;
            font-family: 'Noto Sans', sans-serif;
        }
        .tweet-actions-row a {
            color: #536471;
            text-decoration: none;
        }
        .tweet-actions-row a:hover {
            color: #1d9bf0;
        }
        .tweet-replies-pill {
            display: block;
            text-align: center;
            border: 1px solid #cfd9de;
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 1.5rem !important;
            color: #1d9bf0;
            text-decoration: none;
            font-weight: 600;
            font-family: 'Noto Sans', sans-serif;
            transition: all 0.2s;
        }
        .tweet-replies-pill:hover {
            background: #f7f9fa;
            color: #1a8cd8;
        }
        .tweet-user-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .tweet-user-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .tweet-avatar-sm {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: contain;
            background: #ffffff;
            border: 1px solid #e1e8ed;
            padding: 2px;
        }
        .tweet-name-wrap {
            line-height: 1.2;
        }
        .tweet-user-name {
            font-size: 1.5rem !important;
            font-weight: 700;
            color: #0f1419;
            font-family: 'Noto Sans', sans-serif;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .tweet-user-handle {
            font-size: 1.45rem !important;
            color: #536471;
            font-family: 'Noto Sans', sans-serif;
        }
        .tweet-text-content {
            font-size: 1.55rem !important;
            color: #0f1419;
            line-height: 1.55;
            font-family: 'Noto Sans', sans-serif;
            margin-bottom: 8px;
        }

        /* YouTube feed styling */
        .yt-video-card {
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 14px;
            background: #000000;
            position: relative;
        }
        .yt-video-card:last-child {
            margin-bottom: 0;
        }
        .yt-thumb-container {
            position: relative;
            width: 100%;
            height: 145px;
            overflow: hidden;
        }
        .yt-thumb-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
            transition: transform 0.2s;
            display: block;
        }
        .yt-video-card:hover .yt-thumb-container img {
            transform: scale(1.02);
        }
        .yt-top-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            padding: 8px 10px;
            background: linear-gradient(180deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 100%);
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ffffff;
            z-index: 2;
        }
        .yt-overlay-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #ffffff;
            padding: 2px;
            object-fit: contain;
        }
        .yt-overlay-text {
            font-size: 1.45rem !important;
            font-weight: 600;
            color: #ffffff;
            line-height: 1.25;
            font-family: 'Noto Sans', sans-serif;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .yt-play-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            pointer-events: none;
        }
        .yt-play-badge {
            width: 48px;
            height: 32px;
            background: #ff0000;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.4);
            transition: transform 0.2s;
        }
        .yt-video-card:hover .yt-play-badge {
            transform: scale(1.1);
        }
        .yt-play-triangle {
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 7px 0 7px 12px;
            border-color: transparent transparent transparent #ffffff;
            margin-left: 2px;
        }
        .yt-bottom-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 6px 10px;
            background: linear-gradient(0deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 2;
        }
        .yt-icons-left {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ffffff;
            font-size: 1.4rem;
        }
        .yt-watch-btn-pill {
            background: rgba(0,0,0,0.7);
            border: 1px solid rgba(255,255,255,0.4);
            color: #ffffff;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 1.45rem !important;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-family: 'Noto Sans', sans-serif;
        }
        .yt-watch-btn-pill:hover {
            background: #ff0000;
            color: #ffffff;
            border-color: #ff0000;
        }

        /* Facebook feed styling */
        .fb-card-box {
            border: 1px solid #dadde1;
            border-radius: 6px;
            background: #ffffff;
            margin-bottom: 14px;
            overflow: hidden;
            font-family: 'Noto Sans', sans-serif;
        }
        .fb-card-box:last-child {
            margin-bottom: 0;
        }
        .fb-card-header {
            padding: 10px 12px 6px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .fb-user-part {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .fb-avatar-ring {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid #1877f2;
            padding: 1px;
            object-fit: contain;
            background: #ffffff;
        }
        .fb-user-title {
            font-size: 1.5rem !important;
            font-weight: 700;
            color: #050505;
            line-height: 1.25;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .fb-time-ago {
            font-size: 1.45rem !important;
            color: #65676b;
        }
        .fb-card-image {
            width: 100%;
            height: 145px;
            object-fit: cover;
            display: block;
        }
        .fb-post-caption-text {
            padding: 8px 12px;
            font-size: 1.5rem !important;
            color: #050505;
            line-height: 1.5;
        }
        .fb-reactions-bar {
            padding: 8px 12px;
            border-top: 1px solid #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 1.45rem !important;
            color: #65676b;
        }

        /* Instagram feed styling */
        .ig-card-box {
            border: 1px solid #dbdbdb;
            border-radius: 6px;
            background: #ffffff;
            margin-bottom: 14px;
            overflow: hidden;
            font-family: 'Noto Sans', sans-serif;
        }
        .ig-card-box:last-child {
            margin-bottom: 0;
        }
        .ig-card-header {
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #efefef;
        }
        .ig-user-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .ig-avatar-ring-grad {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            padding: 1.5px;
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ig-avatar-ring-grad img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #ffffff;
            border: 1.5px solid #ffffff;
            object-fit: contain;
        }
        .ig-handle-title {
            font-size: 1.5rem !important;
            font-weight: 700;
            color: #262626;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
        }
        .ig-followers-sub {
            font-size: 1.45rem !important;
            color: #8e8e8e;
        }
        .ig-view-profile-btn {
            background: #0095f6;
            color: #ffffff !important;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 1.45rem !important;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            display: inline-block;
        }
        .ig-view-profile-btn:hover {
            background: #1877f2;
        }
        .ig-media-card-wrap {
            position: relative;
            width: 100%;
            height: 145px;
            overflow: hidden;
            background: #fafafa;
        }
        .ig-media-card-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .ig-play-overlay-icon {
            position: absolute;
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%);
            width: 34px;
            height: 34px;
            background: rgba(255,255,255,0.85);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.25);
            color: #262626;
            font-size: 1.5rem;
        }
        .ig-icons-bar {
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 1.4rem;
            color: #262626;
        }
        .ig-icons-left-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .ig-icons-left-group i {
            cursor: pointer;
        }
        .ig-caption-text {
            padding: 0 12px 10px;
            font-size: 1.45rem !important;
            color: #262626;
            line-height: 1.45;
        }
        .ig-caption-text strong {
            font-weight: 700;
        }

        /* 11. CAMPAIGN BANNERS */
        .campaign-section {
            background: #ffffff;
            padding: 38px 0 28px;
        }
        .campaign-banners-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        @media (max-width: 991px) {
            .campaign-banners-grid {
                grid-template-columns: 1fr;
            }
        }
        .campaign-item-card {
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(35,35,47,0.08);
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
            height: 165px;
        }
        .campaign-item-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(35,35,47,0.14);
        }
        .campaign-item-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* 12. PARTNER LOGOS STRIP */
        .partner-strip-section {
            background: #ffffff;
            padding: 24px 0;
            border-top: 1px solid #efefef;
            border-bottom: 1px solid #efefef;
        }
        .partner-strip-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .partner-arrow-btn {
            background: transparent;
            border: none;
            color: #777777;
            font-size: 2.2rem;
            cursor: pointer;
            padding: 6px;
        }
        .partner-logos-inner {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 24px;
        }
        .partner-logos-inner img {
            max-height: 50px;
            max-width: 150px;
            object-fit: contain;
        }

        /* 13. OFFICIAL MINISTRY FOOTER (Deep Maroon #6c1340 - Exact Match to Design) */
        .portal-footer {
            background-color: #6c1340 !important;
            color: #ffffff !important;
            padding: 32px 0 20px !important;
            position: relative;
            font-family: 'Noto Sans', sans-serif !important;
        }
        .footer-main-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 48px;
            margin-bottom: 22px;
        }
        @media (max-width: 991px) {
            .footer-main-row {
                flex-direction: column;
                gap: 28px;
            }
        }
        .footer-links-section {
            flex: 1;
            max-width: 72%;
        }
        @media (max-width: 991px) {
            .footer-links-section {
                max-width: 100%;
                width: 100%;
            }
        }
        .footer-section-title {
            font-size: 1.6rem !important;
            font-weight: 700 !important;
            font-family: 'Noto Sans', sans-serif !important;
            color: #ffffff !important;
            margin-bottom: 14px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }
        .footer-links-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px 28px;
        }
        @media (max-width: 768px) {
            .footer-links-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px 18px;
            }
        }
        .footer-link-col {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .footer-link {
            color: #ffffff !important;
            text-decoration: none !important;
            font-size: 1.5rem !important;
            font-weight: 400 !important;
            font-family: 'Noto Sans', sans-serif !important;
            line-height: 1.5 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            transition: opacity 0.15s ease, transform 0.15s ease !important;
        }
        .footer-link .chevron {
            font-size: 1.45rem !important;
            font-weight: 600 !important;
            color: #ffffff !important;
            line-height: 1 !important;
            display: inline-block !important;
        }
        .footer-link:hover {
            color: #ffffff !important;
            opacity: 0.85 !important;
            text-decoration: underline !important;
        }
        
        .footer-subscribe-section {
            min-width: 250px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            position: relative;
        }
        @media (max-width: 991px) {
            .footer-subscribe-section {
                align-items: flex-start;
                width: 100%;
            }
        }
        .footer-subscribe-section .footer-section-title {
            text-align: right;
            width: 100%;
        }
        @media (max-width: 991px) {
            .footer-subscribe-section .footer-section-title {
                text-align: left;
            }
        }
        .footer-social-icons {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 18px;
            margin-bottom: 12px;
            width: 100%;
        }
        @media (max-width: 991px) {
            .footer-social-icons {
                justify-content: flex-start;
            }
        }
        .footer-social-btn {
            color: #ffffff !important;
            font-size: 2.1rem !important;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.2s, transform 0.2s;
            line-height: 1;
        }
        .footer-social-btn:hover {
            opacity: 0.8;
            transform: scale(1.1);
        }
        .footer-badges-wrap {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }
        @media (max-width: 991px) {
            .footer-badges-wrap {
                justify-content: flex-start;
            }
        }
        .footer-badge-link {
            display: inline-block;
            background: #ffffff;
            border-radius: 3px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            transition: transform 0.15s ease;
        }
        .footer-badge-link:hover {
            transform: translateY(-2px);
        }
        .footer-badge-link img {
            height: 27px;
            width: auto;
            display: block;
        }
        
        /* Floating / in-footer Back to Top */
        .footer-scroll-top-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 0;
            margin-left: 6px;
        }
        .footer-scroll-top-btn:hover {
            background: rgba(0, 0, 0, 0.65);
            transform: scale(1.08);
        }

        .footer-bottom-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 18px;
            margin-top: 8px;
            font-size: 1.45rem !important;
            font-family: 'Noto Sans', sans-serif !important;
            color: #ffffff !important;
        }
        @media (max-width: 768px) {
            .footer-bottom-bar {
                flex-direction: column;
                gap: 8px;
                text-align: center;
            }
        }
        .footer-copyright-text,
        .footer-updated-text {
            color: #ffffff !important;
            font-size: 1.45rem !important;
            font-weight: 400 !important;
        }

        /* ============================================================
           OFFICIAL TEXMIN INNER HERO BANNER & SUB-NAV STYLING
           ============================================================ */
        .inner-hero-banner {
            background: radial-gradient(circle at 65% 35%, #7a154a 0%, #520b31 45%, #38051e 100%), #38051e !important;
            position: relative !important;
            padding: 44px 0 0 !important;
            overflow: hidden !important;
        }
        .inner-hero-graphic {
            position: absolute !important;
            top: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100% !important;
            height: 100% !important;
            pointer-events: none !important;
            z-index: 1 !important;
            overflow: hidden !important;
        }
        .inner-hero-graphic svg {
            width: 100% !important;
            height: 100% !important;
            display: block !important;
        }
        .inner-hero-container {
            position: relative !important;
            z-index: 2 !important;
        }
        .inner-hero-content {
            margin-bottom: 24px !important;
        }
        .inner-hero-banner .inner-breadcrumb-text,
        .inner-hero-banner .inner-breadcrumb-text * {
            font-size: 1.45rem !important;
            font-family: 'Noto Sans', sans-serif !important;
            color: rgba(255, 255, 255, 0.88) !important;
            margin-bottom: 8px !important;
        }
        .inner-hero-banner .inner-breadcrumb-text a {
            color: rgba(255, 255, 255, 0.95) !important;
            text-decoration: none !important;
            transition: color 0.15s !important;
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
            letter-spacing: -0.3px !important;
            line-height: 1.25 !important;
            text-shadow: 0 1px 4px rgba(0, 0, 0, 0.25) !important;
        }

        /* Sub-nav Pill Bar (Exact match to texmin reference screenshot) */
        .inner-pill-bar-wrap {
            display: block !important;
            margin-top: 24px !important;
            margin-bottom: -1px !important;
            position: relative !important;
            z-index: 10 !important;
        }
        .inner-pill-bar {
            background: #500a2f !important;
            border-radius: 12px 12px 0 0 !important;
            padding: 6px 10px 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 2px !important;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.12) !important;
            max-width: 100% !important;
            overflow-x: auto !important;
            white-space: nowrap !important;
            scrollbar-width: none !important;
        }
        .inner-pill-bar::-webkit-scrollbar {
            display: none !important;
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
            transition: all 0.15s !important;
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
            opacity: 0.95 !important;
        }

        /* Main Content Wrapper */
        .inner-page-main {
            background-color: #ffffff !important;
            padding: 44px 0 70px !important;
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
                z-index: 10 !important;
            }
        }
        @media (max-width: 991.5px) {
            .stickyBox {
                position: relative !important;
                top: 0 !important;
                margin-bottom: 2rem !important;
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
            font-family: 'Noto Sans', sans-serif !important;
        }

        /* DBIM Document Download Rows (.box) */
        .box {
            border-radius: 8px !important;
            border: 1px solid #ebd0de !important;
            background: #ffffff !important;
            padding: 16px 20px !important;
            margin-bottom: 14px !important;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.02) !important;
            transition: border-color 0.2s, box-shadow 0.2s !important;
        }
        .box:hover {
            border-color: #500a2f !important;
            box-shadow: 0 4px 14px rgba(80, 10, 47, 0.08) !important;
        }
    </style>
</head>
<body class="default-theme group1">

    <!-- 1. TOP BRANDING ROW (Exact Texmin.gov.in Header) -->
    @include('partials.header')

    

    <!-- MAIN PAGE CONTENT (Target of Skip to Main Content) -->
    <main id="mainContent" tabindex="-1">
        @if(session('success'))
            <div class="page-container mt-3">
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert" style="font-size: 1.6rem !important; border-left: 5px solid #198754; background: #e8f5e9; color: #1b5e20;">
                    <i class="fa fa-circle-check fs-4 me-2"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="page-container mt-3">
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert" style="font-size: 1.6rem !important; border-left: 5px solid #dc3545; background: #ffebee; color: #b71c1c;">
                    <i class="fa fa-triangle-exclamation fs-4 me-2"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <!-- 11. PARTNER LOGOS STRIP -->
    <section class="partner-strip-section">
        <div class="page-container">
            <div class="partner-strip-wrap">
                <button class="partner-arrow-btn" aria-label="Previous Partner">‹</button>
                <div class="partner-logos-inner">
                    <img src="{{ asset('assets/images/partner_logos_exact.png') }}" alt="Government Initiatives & Partners" style="max-height: 48px; width: auto;" onerror="this.src='{{ asset('assets/images/partner_logos_strip.png') }}'">
                </div>
                <button class="partner-arrow-btn" aria-label="Next Partner">›</button>
            </div>
        </div>
    </section>

    <!-- 12. FOOTER (Deep Maroon #6c1340 - Dynamic Backend Controlled) -->
    @php
        $footerLinks = \App\Http\Controllers\Admin\FooterController::getLinks();
        $footerCopyright = session('locale') == 'hi' 
            ? \App\Models\Setting::get('footer_copyright_hi', 'यह वेबसाइट वस्त्र मंत्रालय, भारत सरकार की है')
            : \App\Models\Setting::get('footer_copyright_en', 'This Website belong to Ministry of Textiles, Government of India');
        
        $footerDateMode = \App\Models\Setting::get('footer_updated_mode', 'auto');
        $footerDate = $footerDateMode === 'custom' 
            ? \App\Models\Setting::get('footer_custom_date', date('d.m.Y')) 
            : date('d.m.Y');

        $twitterUrl = \App\Models\Setting::get('twitter_handle', 'https://x.com/TexMinIndia');
        $youtubeUrl = \App\Models\Setting::get('youtube_url', 'https://youtube.com/@ministryoftextiles');
        $facebookUrl = \App\Models\Setting::get('facebook_url', 'https://facebook.com/TexMinIndia');
        $instagramUrl = \App\Models\Setting::get('instagram_url', 'https://instagram.com/ministryoftextiles');

        $mygovUrl = \App\Models\Setting::get('mygov_url', 'https://www.mygov.in/');
        $mygovEnabled = \App\Models\Setting::get('mygov_enabled', '1');
        $indiagovUrl = \App\Models\Setting::get('indiagov_url', 'https://www.india.gov.in/');
        $indiagovEnabled = \App\Models\Setting::get('indiagov_enabled', '1');
        $scrollTopEnabled = \App\Models\Setting::get('footer_scroll_top_enabled', '1');

        $linksByCol = [1 => [], 2 => [], 3 => [], 4 => []];
        foreach ($footerLinks as $fl) {
            if (!empty($fl['is_active'])) {
                $c = (int)($fl['col'] ?? 1);
                if (!isset($linksByCol[$c])) $linksByCol[$c] = [];
                $linksByCol[$c][] = $fl;
            }
        }
    @endphp
    <footer class="portal-footer" id="footerContact">
        <div class="page-container" style="position: relative;">
            <div class="footer-main-row">
                <!-- Column 1: USEFUL LINKS -->
                <div class="footer-links-section">
                    <h3 class="footer-section-title">USEFUL LINKS</h3>
                    <div class="footer-links-grid">
                        @for($col = 1; $col <= 4; $col++)
                            <div class="footer-link-col">
                                @foreach($linksByCol[$col] ?? [] as $fl)
                                    @php
                                        $targetAttr = !empty($fl['target']) && $fl['target'] === '_blank' ? 'target="_blank" rel="noopener noreferrer"' : '';
                                        $rawUrl = $fl['url'] ?? '#';
                                        $isModal = ($rawUrl === '#feedbackModal');
                                        if (!$isModal && !str_starts_with($rawUrl, 'http://') && !str_starts_with($rawUrl, 'https://') && !str_starts_with($rawUrl, '#') && !str_starts_with($rawUrl, 'javascript:')) {
                                            $resolvedUrl = url(ltrim($rawUrl, '/'));
                                        } else {
                                            $resolvedUrl = $rawUrl;
                                        }
                                    @endphp
                                    @if($isModal)
                                        <a href="javascript:void(0)" class="footer-link" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                                            <span class="chevron">&gt;</span> <span>{{ $fl['title'] }}</span>
                                        </a>
                                    @else
                                        <a href="{{ $resolvedUrl }}" class="footer-link" {!! $targetAttr !!}>
                                            <span class="chevron">&gt;</span> <span>{{ $fl['title'] }}</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Column 2: SUBSCRIBE FOR UPDATES -->
                <div class="footer-subscribe-section">
                    <h3 class="footer-section-title">SUBSCRIBE FOR UPDATES</h3>
                    <div class="footer-social-icons">
                        @if($twitterUrl)
                            <a href="{{ $twitterUrl }}" target="_blank" class="footer-social-btn" title="X (Twitter)" aria-label="X (Twitter)" rel="noopener noreferrer">
                                <i class="fa-brands fa-x-twitter"></i>
                            </a>
                        @endif
                        @if($youtubeUrl)
                            <a href="{{ $youtubeUrl }}" target="_blank" class="footer-social-btn" title="YouTube" aria-label="YouTube" rel="noopener noreferrer">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        @endif
                        @if($facebookUrl)
                            <a href="{{ $facebookUrl }}" target="_blank" class="footer-social-btn" title="Facebook" aria-label="Facebook" rel="noopener noreferrer">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        @endif
                        @if($instagramUrl)
                            <a href="{{ $instagramUrl }}" target="_blank" class="footer-social-btn" title="Instagram" aria-label="Instagram" rel="noopener noreferrer">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        @endif
                    </div>
                    <div class="d-flex align-items-center justify-content-end gap-2 w-100">
                        <div class="footer-badges-wrap">
                            @if($mygovEnabled == '1')
                                <a href="{{ $mygovUrl }}" target="_blank" title="MyGov - Meri Sarkar" class="footer-badge-link" rel="noopener noreferrer">
                                    <img src="{{ asset('assets/images/mygov_badge_exact.png') }}" alt="MyGov Meri Sarkar" height="27">
                                </a>
                            @endif
                            @if($indiagovEnabled == '1')
                                <a href="{{ $indiagovUrl }}" target="_blank" title="National Portal of India" class="footer-badge-link" rel="noopener noreferrer">
                                    <img src="{{ asset('assets/images/indiagov_badge_exact.png') }}" alt="National Portal of India" height="27">
                                </a>
                            @endif
                        </div>
                        @if($scrollTopEnabled == '1')
                            <button type="button" class="footer-scroll-top-btn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" title="Back to top" aria-label="Back to top">
                                <i class="fa-solid fa-arrow-up"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bottom Line (Exact match to screenshot) -->
            <div class="footer-bottom-bar">
                <div class="footer-copyright-text">
                    {{ $footerCopyright }}
                </div>
                <div class="footer-updated-text">
                    Last Updated On: {{ $footerDate }}
                </div>
            </div>
        </div>
    </footer>

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 8px; overflow: hidden; border: none; font-size: 1.6rem !important;">
                <div class="modal-header" style="background: #6c1340; color: #fff; padding: 14px 20px;">
                    <h5 class="modal-title fs-5" id="feedbackModalLabel" style="font-weight: 700;">Citizen Feedback & Inquiry</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('inquiry.submit') }}" method="POST">
                    @csrf
                    <div class="modal-body" style="padding: 20px;">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Your Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="Enter full name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="name@example.gov.in">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" placeholder="Mobile / Telephone">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Subject / Sector</label>
                            <input type="text" name="subject" class="form-control" placeholder="e.g., Handloom Certification, Testing">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control" rows="4" required placeholder="Write your feedback or query here..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding: 12px 20px; background: #f8f8f8;">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm text-white" style="background: #6c1340; font-weight: 600;">Submit Inquiry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Accessibility Controls Offcanvas Drawer (Exact match to reference design) -->
    <div class="offcanvas offcanvas-end a11y-offcanvas" tabindex="-1" id="accessibilityDrawer" aria-labelledby="accessibilityDrawerLabel">
        <div class="offcanvas-header a11y-header">
            <h5 class="offcanvas-title a11y-title" id="accessibilityDrawerLabel">
                <svg class="a11y-human-icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <circle cx="12" cy="4" r="2.2"/>
                    <path d="M21 9h-6V7h4V5H5v2h4v2H3v2h6v12h2v-6h2v6h2V11h6z"/>
                </svg>
                Accessibility Controls
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body a11y-body">
            <div class="a11y-grid">
                <!-- 1. Dark Contrast -->
                <button type="button" class="a11y-card" id="btnA11yDarkContrast" onclick="toggleDarkContrast()" title="Toggle Dark Contrast Mode" aria-pressed="false">
                    <div class="a11y-card-icon-wrap">
                        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                            <path d="M12 7l1.5 3 3.5.5-2.5 2.5.5 3.5-3-1.5-3 1.5.5-3.5-2.5-2.5 3.5-.5z" fill="currentColor"/>
                        </svg>
                    </div>
                    <span class="a11y-card-label">DARK CONTRAST</span>
                </button>

                <!-- 2. Invert -->
                <button type="button" class="a11y-card" id="btnA11yInvert" onclick="toggleInvert()" title="Toggle Invert Mode" aria-pressed="false">
                    <div class="a11y-card-icon-wrap">
                        <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8v16z"/>
                        </svg>
                    </div>
                    <span class="a11y-card-label">INVERT</span>
                </button>

                <!-- 3. Saturation -->
                <button type="button" class="a11y-card" id="btnA11ySaturation" onclick="toggleSaturation()" title="Toggle Saturation Mode" aria-pressed="false">
                    <div class="a11y-card-icon-wrap">
                        <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
                            <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" fill="none" stroke="currentColor" stroke-width="2"/>
                            <path d="M12 3v17a8 8 0 0 0 5.66-13.66L12 3z"/>
                        </svg>
                    </div>
                    <span class="a11y-card-label">SATURATION</span>
                </button>

                <!-- 4. Text Size Increase -->
                <button type="button" class="a11y-card" id="btnA11ySizeInc" onclick="changeFontSize(0.1)" title="Increase Text Size">
                    <div class="a11y-card-icon-wrap a11y-text-icon">A+</div>
                    <span class="a11y-card-label">TEXT SIZE INCREASE</span>
                </button>

                <!-- 5. Text Size Decrease -->
                <button type="button" class="a11y-card" id="btnA11ySizeDec" onclick="changeFontSize(-0.1)" title="Decrease Text Size">
                    <div class="a11y-card-icon-wrap a11y-text-icon">A-</div>
                    <span class="a11y-card-label">TEXT SIZE DECREASE</span>
                </button>

                <!-- 6. Highlight Links -->
                <button type="button" class="a11y-card" id="btnA11yLinks" onclick="toggleHighlightLinks()" title="Toggle Highlight Links" aria-pressed="false">
                    <div class="a11y-card-icon-wrap">
                        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                        </svg>
                    </div>
                    <span class="a11y-card-label">HIGHLIGHT LINKS</span>
                </button>

                <!-- 7. Hide Images -->
                <button type="button" class="a11y-card" id="btnA11yImages" onclick="toggleHideImages()" title="Toggle Hide Images" aria-pressed="false">
                    <div class="a11y-card-icon-wrap">
                        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="2" y1="2" x2="22" y2="22"/>
                            <path d="M10.41 10.41a2 2 0 1 1-2.83-2.83"/>
                            <line x1="13.5" y1="6.5" x2="19" y2="6.5"/>
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                        </svg>
                    </div>
                    <span class="a11y-card-label">HIDE IMAGES</span>
                </button>

                <!-- 8. Default Cursor -->
                <button type="button" class="a11y-card" id="btnA11yCursor" onclick="toggleLargeCursor()" title="Toggle Accessible Cursor" aria-pressed="false">
                    <div class="a11y-card-icon-wrap">
                        <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
                            <path d="M13.64 12.36l5.36 5.36-2.83 2.83-5.36-5.36-3.81 3.81V3l16 10-6.36 2.36z"/>
                            <line x1="5" y1="1" x2="5" y2="3" stroke="currentColor" stroke-width="2"/>
                            <line x1="1" y1="5" x2="3" y2="5" stroke="currentColor" stroke-width="2"/>
                            <line x1="2" y1="2" x2="3.5" y2="3.5" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <span class="a11y-card-label">DEFAULT CURSOR</span>
                </button>
            </div>

            <div class="mt-4 text-center">
                <button type="button" class="a11y-reset-all-btn" onclick="resetAllAccessibility()">
                    <i class="fa-solid fa-rotate-left me-1"></i> Reset All Settings
                </button>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://translation-plugin.bhashini.co.in/v3/website_translation_utility.js" initial_preferred_language="hi" page-source-language="en"></script>

    <!-- Comprehensive Accessibility & Responsive Navigation JS -->
    <script>
        // Accessibility State & Controls
        var currentFontScale = 1.0;

        function setFontScale(scale) {
            currentFontScale = Math.min(Math.max(scale, 0.75), 1.35);
            document.documentElement.style.setProperty('--font-scale', currentFontScale);
            localStorage.setItem('siteFontScale', currentFontScale);
            updateA11yButtons();
        }

        function changeFontSize(delta) {
            var newScale = Math.round((currentFontScale + delta) * 100) / 100;
            setFontScale(newScale);
        }

        function toggleDarkContrast() {
            var isNow = document.documentElement.classList.toggle('contrast-mode');
            localStorage.setItem('a11y_dark_contrast', isNow ? 'yes' : 'no');
            updateA11yButtons();
        }

        function toggleInvert() {
            var isNow = document.documentElement.classList.toggle('invert-mode');
            localStorage.setItem('a11y_invert', isNow ? 'yes' : 'no');
            updateA11yButtons();
        }

        function toggleSaturation() {
            var isNow = document.documentElement.classList.toggle('desaturate-mode');
            localStorage.setItem('a11y_saturation', isNow ? 'yes' : 'no');
            updateA11yButtons();
        }

        function toggleHighlightLinks() {
            var isNow = document.documentElement.classList.toggle('highlight-links-mode');
            localStorage.setItem('a11y_links', isNow ? 'yes' : 'no');
            updateA11yButtons();
        }

        function toggleHideImages() {
            var isNow = document.documentElement.classList.toggle('hide-images-mode');
            localStorage.setItem('a11y_images', isNow ? 'yes' : 'no');
            updateA11yButtons();
        }

        function toggleLargeCursor() {
            var isNow = document.documentElement.classList.toggle('large-cursor-mode');
            localStorage.setItem('a11y_cursor', isNow ? 'yes' : 'no');
            updateA11yButtons();
        }

        function resetAllAccessibility() {
            currentFontScale = 1.0;
            document.documentElement.style.setProperty('--font-scale', 1.0);
            document.documentElement.classList.remove(
                'contrast-mode',
                'invert-mode',
                'desaturate-mode',
                'highlight-links-mode',
                'hide-images-mode',
                'large-cursor-mode'
            );
            localStorage.removeItem('siteFontScale');
            localStorage.removeItem('a11y_dark_contrast');
            localStorage.removeItem('a11y_invert');
            localStorage.removeItem('a11y_saturation');
            localStorage.removeItem('a11y_links');
            localStorage.removeItem('a11y_images');
            localStorage.removeItem('a11y_cursor');
            localStorage.removeItem('contrastMode');
            updateA11yButtons();
        }

        function updateA11yButtons() {
            var btnDark = document.getElementById('btnA11yDarkContrast');
            if (btnDark) {
                var active = document.documentElement.classList.contains('contrast-mode');
                btnDark.classList.toggle('active', active);
                btnDark.setAttribute('aria-pressed', active ? 'true' : 'false');
            }

            var btnInv = document.getElementById('btnA11yInvert');
            if (btnInv) {
                var active = document.documentElement.classList.contains('invert-mode');
                btnInv.classList.toggle('active', active);
                btnInv.setAttribute('aria-pressed', active ? 'true' : 'false');
            }

            var btnSat = document.getElementById('btnA11ySaturation');
            if (btnSat) {
                var active = document.documentElement.classList.contains('desaturate-mode');
                btnSat.classList.toggle('active', active);
                btnSat.setAttribute('aria-pressed', active ? 'true' : 'false');
            }

            var btnInc = document.getElementById('btnA11ySizeInc');
            if (btnInc) {
                btnInc.classList.toggle('active', currentFontScale > 1.0);
            }

            var btnDec = document.getElementById('btnA11ySizeDec');
            if (btnDec) {
                btnDec.classList.toggle('active', currentFontScale < 1.0);
            }

            var btnLnk = document.getElementById('btnA11yLinks');
            if (btnLnk) {
                var active = document.documentElement.classList.contains('highlight-links-mode');
                btnLnk.classList.toggle('active', active);
                btnLnk.setAttribute('aria-pressed', active ? 'true' : 'false');
            }

            var btnImg = document.getElementById('btnA11yImages');
            if (btnImg) {
                var active = document.documentElement.classList.contains('hide-images-mode');
                btnImg.classList.toggle('active', active);
                btnImg.setAttribute('aria-pressed', active ? 'true' : 'false');
            }

            var btnCur = document.getElementById('btnA11yCursor');
            if (btnCur) {
                var active = document.documentElement.classList.contains('large-cursor-mode');
                btnCur.classList.toggle('active', active);
                btnCur.setAttribute('aria-pressed', active ? 'true' : 'false');
            }
        }

        // Restore saved settings on initial page load
        (function() {
            var savedScale = localStorage.getItem('siteFontScale');
            if (savedScale) {
                currentFontScale = parseFloat(savedScale);
                document.documentElement.style.setProperty('--font-scale', currentFontScale);
            }
            if (localStorage.getItem('a11y_dark_contrast') === 'yes' || localStorage.getItem('contrastMode') === 'yes') {
                document.documentElement.classList.add('contrast-mode');
            }
            if (localStorage.getItem('a11y_invert') === 'yes') {
                document.documentElement.classList.add('invert-mode');
            }
            if (localStorage.getItem('a11y_saturation') === 'yes') {
                document.documentElement.classList.add('desaturate-mode');
            }
            if (localStorage.getItem('a11y_links') === 'yes') {
                document.documentElement.classList.add('highlight-links-mode');
            }
            if (localStorage.getItem('a11y_images') === 'yes') {
                document.documentElement.classList.add('hide-images-mode');
            }
            if (localStorage.getItem('a11y_cursor') === 'yes') {
                document.documentElement.classList.add('large-cursor-mode');
            }
            document.addEventListener('DOMContentLoaded', updateA11yButtons);
        })();

        // 5. Skip to Main Content Focus Helper
        document.addEventListener('DOMContentLoaded', function() {
            var skipLinks = document.querySelectorAll('a[href^="#"]');
            skipLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    var targetId = this.getAttribute('href');
                    if (targetId && targetId !== '#') {
                        var targetEl = document.querySelector(targetId);
                        if (targetEl) {
                            targetEl.setAttribute('tabindex', '-1');
                            targetEl.focus();
                        }
                    }
                });
            });

            // Mobile Nav Dropdown Accordion Toggle
            var mobileToggle = document.querySelector('.gov-mobile-toggle');
            var navUl = document.getElementById('govNavUl');
            if (mobileToggle && navUl) {
                mobileToggle.addEventListener('click', function() {
                    var isExpanded = navUl.classList.contains('show');
                    mobileToggle.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
                });
            }

            // In mobile view, clicking a parent nav link with dropdown toggles the sub-items
            document.querySelectorAll('.gov-nav-li').forEach(function(li) {
                var trigger = li.querySelector('.gov-nav-a');
                var drop = li.querySelector('.gov-nav-drop');
                if (trigger && drop) {
                    trigger.addEventListener('click', function(e) {
                        if (window.innerWidth <= 991) {
                            e.preventDefault();
                            li.classList.toggle('active-mobile-sub');
                        }
                    });
                }
            });
        });

        // 6. Bhashini Language Dropdown Toggle
        function toggleBhashiniDropdown(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            var dd = document.getElementById('bhashini-translation');
            if (dd) {
                var isOpen = dd.classList.toggle('show');
                var btn = dd.querySelector('.bhashini-dropdown-btn');
                if (btn) btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            }
        }
        document.addEventListener('click', function(e) {
            var dd = document.getElementById('bhashini-translation');
            if (dd && !dd.contains(e.target)) {
                dd.classList.remove('show');
                var btn = dd.querySelector('.bhashini-dropdown-btn');
                if (btn) btn.setAttribute('aria-expanded', 'false');
            }
        });

        // 7. Real-Time Bhashini Language Analytics Tracker
        function reportBhashiniLang(langCode) {
            if (!langCode) return;
            try {
                fetch('{{ url("/api/analytics/track-bhashini") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        lang: langCode,
                        path: window.location.pathname
                    })
                }).catch(function() {});
            } catch(e) {}
        }

        document.addEventListener('click', function(e) {
            var target = e.target.closest('[data-lang], .bhashini-lang-option, .bhashini-dropdown-menu a, [data-language]');
            if (target) {
                var lang = target.getAttribute('data-lang') || target.getAttribute('data-language');
                if (lang) reportBhashiniLang(lang);
            }
        });

        var lastTrackedLang = '{{ session("locale", "en") }}';
        var langObserver = new MutationObserver(function() {
            var currentLang = document.documentElement.getAttribute('lang') || '';
            if (currentLang && currentLang !== lastTrackedLang) {
                lastTrackedLang = currentLang;
                reportBhashiniLang(currentLang);
            }
        });
        langObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['lang'] });
    </script>
    <!-- Leaflet GIS Map Engine (Local) -->
    <script src="{{ asset('js/leaflet.js') }}"></script>
</body>
</html>
