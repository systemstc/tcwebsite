<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Visual Editor: {{ $page->title_en }} - Textiles Committee CMS</title>

    <!-- Official Textiles Committee Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Textiles_Committee_Logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/Textiles_Committee_Logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/Textiles_Committee_Logo.png') }}">

    <!-- Google Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,700&family=Open+Sans:wght@400;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Noto Sans', sans-serif;
            margin: 0;
            padding: 0;
            background: #eef2f6;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Top Bar */
        .editor-topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: #1e1b24;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            z-index: 1050;
            box-shadow: 0 2px 10px rgba(0,0,0,0.25);
        }
        .editor-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            font-weight: 700;
        }
        .editor-topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Sidebar Elements Panel (Elementor style) */
        .editor-sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            bottom: 0;
            width: 330px;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            overflow-y: auto;
            z-index: 1040;
            box-shadow: 2px 0 8px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
        }
        .editor-sidebar-tabs {
            display: flex;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }
        .editor-sidebar-tab {
            flex: 1;
            padding: 12px 0;
            text-align: center;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }
        .editor-sidebar-tab.active {
            color: #721835;
            background: #ffffff;
            border-bottom-color: #721835;
        }

        .editor-widgets-container {
            padding: 14px;
            flex-grow: 1;
        }
        .widget-search-wrap {
            position: relative;
            margin-bottom: 14px;
        }
        .widget-search-wrap i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 13px;
        }
        .widget-search-input {
            width: 100%;
            padding: 8px 12px 8px 34px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 12.5px;
            outline: none;
            background: #f8fafc;
            transition: all 0.2s;
        }
        .widget-search-input:focus {
            background: #ffffff;
            border-color: #721835;
            box-shadow: 0 0 0 2px rgba(114, 24, 53, 0.1);
        }

        .widget-section-title {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #721835;
            margin: 16px 0 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .widget-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .widget-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 10px;
            text-align: center;
            cursor: grab;
            transition: all 0.2s;
            user-select: none;
            position: relative;
        }
        .widget-card:hover {
            background: #fdf2f6;
            border-color: #c499b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(114, 24, 53, 0.08);
        }
        .widget-card:active {
            cursor: grabbing;
        }
        .widget-card.is-dragging {
            opacity: 0.4;
            border: 2px dashed #721835;
        }
        .widget-card i {
            font-size: 20px;
            color: #721835;
            margin-bottom: 6px;
            display: block;
        }
        .widget-card span {
            font-size: 11.5px;
            font-weight: 600;
            color: #334155;
            display: block;
            line-height: 1.3;
        }
        .widget-card .badge-pro {
            position: absolute;
            top: 4px;
            right: 4px;
            font-size: 8.5px;
            font-weight: 800;
            background: linear-gradient(135deg, #721835, #b8235a);
            color: #ffffff;
            padding: 2px 4px;
            border-radius: 4px;
            letter-spacing: 0.5px;
        }

        /* Canvas Area */
        .editor-canvas-wrapper {
            margin-left: 330px;
            margin-top: 56px;
            min-height: calc(100vh - 56px);
            padding: 20px 30px 100px;
            background: #eef2f6;
            display: flex;
            justify-content: center;
            cursor: default;
        }
        .editor-device-frame {
            width: 100%;
            max-width: 1140px;
            background: #ffffff;
            min-height: 80vh;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: relative;
            transition: max-width 0.3s;
            display: flex;
            flex-direction: column;
        }

        /* Floating Format Toolbar */
        .editor-floating-toolbar {
            position: sticky;
            top: 66px;
            z-index: 1020;
            background: #ffffff;
            border-radius: 8px;
            padding: 6px 12px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.12);
            border: 1px solid #cbd5e1;
            margin: 12px 20px 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        .toolbar-btn {
            background: transparent;
            border: 1px solid transparent;
            border-radius: 4px;
            padding: 5px 8px;
            font-size: 12.5px;
            color: #334155;
            cursor: pointer;
            transition: all 0.15s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            font-weight: 500;
        }
        .toolbar-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #cbd5e1;
        }
        .toolbar-btn.active {
            background: #721835 !important;
            color: #ffffff !important;
            border-color: #721835 !important;
            box-shadow: 0 0 0 2px rgba(114, 24, 53, 0.25);
        }
        .toolbar-select {
            padding: 4px 8px;
            font-size: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            background: #ffffff;
            color: #334155;
            outline: none;
            cursor: pointer;
            font-weight: 500;
        }
        .toolbar-select:focus {
            border-color: #721835;
        }
        .toolbar-color-wrap {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 6px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            background: #f8fafc;
        }
        .toolbar-color-wrap input[type="color"] {
            border: none;
            width: 20px;
            height: 20px;
            padding: 0;
            background: none;
            cursor: pointer;
            border-radius: 3px;
        }
        .toolbar-divider {
            width: 1px;
            height: 20px;
            background: #cbd5e1;
            margin: 0 4px;
        }

        /* Format Painter Banner */
        .format-painter-banner {
            display: none;
            background: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 6px 14px;
            margin: 0 20px 8px;
            border-radius: 6px;
            font-size: 12px;
            align-items: center;
            justify-content: space-between;
        }
        .format-painter-banner.show {
            display: flex;
        }

        /* Editable Live Area */
        .live-page-canvas {
            padding: 30px 40px;
            min-height: 650px;
            outline: none;
            flex-grow: 1;
            cursor: text;
        }
        .live-page-canvas:focus {
            box-shadow: inset 0 0 0 2px rgba(114, 24, 53, 0.2);
        }
        .live-page-canvas.is-dragover {
            background-color: #fcf6f9;
            box-shadow: inset 0 0 0 2px #721835;
        }
        .live-page-canvas.painter-active,
        .live-page-canvas.painter-active * {
            cursor: crosshair !important;
        }

        /* Drop Indicator Line */
        .drop-indicator-line {
            height: 4px;
            background: #721835;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(114, 24, 53, 0.7);
            margin: 10px 0;
            pointer-events: none;
            animation: pulseDrop 1s infinite alternate;
        }
        @keyframes pulseDrop {
            from { opacity: 0.7; }
            to { opacity: 1; box-shadow: 0 0 14px rgba(114, 24, 53, 0.9); }
        }

        /* Canvas Block Hover State */
        .live-page-canvas > *:not(.drop-indicator-line) {
            position: relative;
            transition: outline 0.15s ease;
        }
        .live-page-canvas > *:not(.drop-indicator-line):hover {
            outline: 1.5px dashed rgba(114, 24, 53, 0.4);
            outline-offset: 4px;
        }
        .live-page-canvas > *.section-hover-active {
            outline: 2px solid #721835 !important;
            outline-offset: 4px !important;
            box-shadow: 0 0 12px rgba(114, 24, 53, 0.15);
        }

        /* Floating Section Action Overlay (Delete, Duplicate, Move) */
        .section-action-overlay {
            position: absolute;
            display: none;
            z-index: 1030;
            pointer-events: auto;
            transition: top 0.1s ease, right 0.1s ease;
        }
        .section-ctrl-bar {
            display: inline-flex;
            align-items: center;
            background: #1e1b24;
            color: #ffffff;
            border-radius: 6px;
            padding: 4px 8px;
            gap: 5px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.15);
        }
        .section-ctrl-label {
            background: #721835;
            color: #ffffff;
            font-size: 10px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .section-ctrl-btn {
            background: rgba(255, 255, 255, 0.12);
            border: none;
            color: #ffffff;
            padding: 4px 9px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 11.5px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.15s;
        }
        .section-ctrl-btn:hover {
            background: rgba(255, 255, 255, 0.28);
            color: #ffffff;
        }
        .section-ctrl-btn.btn-delete {
            background: #dc2626;
            color: #ffffff;
            font-weight: 700;
        }
        .section-ctrl-btn.btn-delete:hover {
            background: #b91c1c;
            box-shadow: 0 0 8px rgba(220, 38, 38, 0.6);
        }

        /* Drag-to-Resize Handle & Sizing Tooltip */
        .component-resize-handle {
            position: absolute;
            display: none;
            width: 14px;
            height: 100%;
            cursor: ew-resize;
            background: rgba(114, 24, 53, 0.3);
            border-radius: 4px;
            z-index: 1025;
            transition: background 0.15s;
        }
        .component-resize-handle:hover,
        .component-resize-handle.is-resizing {
            background: #721835 !important;
            box-shadow: 0 0 10px rgba(114, 24, 53, 0.7);
        }
        .component-resize-handle::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 4px;
            height: 28px;
            background: #ffffff;
            border-radius: 2px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        .component-resize-tooltip {
            position: absolute;
            display: none;
            background: #1e1b24;
            color: #ffffff;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            pointer-events: none;
            z-index: 2000;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
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

        /* Notice banner */
        .canvas-banner-preview {
            background: #4c082b;
            color: #ffffff;
            padding: 24px 36px;
            border-radius: 8px 8px 0 0;
        }
        .canvas-banner-preview small {
            color: rgba(255,255,255,0.7);
            font-size: 12px;
        }
        .canvas-banner-preview h2 {
            font-size: 26px;
            font-weight: 700;
            margin: 4px 0 0;
        }

        /* Toast notifications */
        .save-indicator {
            display: none;
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #10b981;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
            z-index: 2000;
            align-items: center;
            gap: 8px;
        }

        /* ============================================================
           ELEMENTOR PRO & GOVERNMENT COMPONENT STYLES
           ============================================================ */
        /* 1. Layout Containers */
        .pro-container-1col {
            padding: 24px;
            background: #fbfbfb;
            border: 1px solid #e8e8ed;
            border-radius: 10px;
            margin: 20px 0;
        }
        .pro-container-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin: 20px 0;
        }
        .pro-container-3col {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }
        .pro-container-4col {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin: 20px 0;
        }
        .pro-container-sidebar {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 24px;
            margin: 20px 0;
        }
        .pro-col-box {
            background: #ffffff;
            border: 1px dashed #d1d5db;
            border-radius: 8px;
            padding: 16px;
            min-height: 80px;
        }

        /* 2. Dual-Color / Animated Heading */
        .pro-dual-heading {
            font-size: 2.2rem;
            font-weight: 800;
            color: #1a1a1a;
            margin: 24px 0 14px;
            line-height: 1.3;
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

        /* 3. Call to Action (CTA) Banner */
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
        .pro-cta-box::after {
            content: '';
            position: absolute;
            right: -20px;
            top: -20px;
            width: 140px;
            height: 140px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }
        .pro-cta-title {
            font-size: 2rem;
            font-weight: 800;
            margin: 0 0 10px;
            color: #ffffff;
        }
        .pro-cta-desc {
            font-size: 1.35rem;
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
            font-size: 1.35rem;
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

        /* 4. Pricing / Charges Table Card */
        .pro-pricing-card {
            background: #ffffff;
            border: 2px solid #ecd5e1;
            border-radius: 12px;
            padding: 30px 26px;
            text-align: center;
            margin: 20px 0;
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
            position: relative;
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
            font-size: 1.1rem;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 12px;
            text-transform: uppercase;
        }
        .pro-pricing-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 10px;
        }
        .pro-pricing-price {
            font-size: 2.6rem;
            font-weight: 800;
            color: #721835;
            margin: 12px 0 16px;
        }
        .pro-pricing-price span {
            font-size: 1.25rem;
            font-weight: 500;
            color: #64748b;
        }
        .pro-pricing-features {
            list-style: none;
            padding: 0;
            margin: 20px 0;
            text-align: left;
            font-size: 1.35rem;
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
            font-size: 14px;
        }

        /* 5. Animated Counter / Stats Box */
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
            font-size: 2.8rem;
            font-weight: 800;
            color: #721835;
            margin: 0 0 6px;
            line-height: 1;
        }
        .pro-counter-label {
            font-size: 1.35rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 4px;
        }
        .pro-counter-desc {
            font-size: 1.15rem;
            color: #64748b;
            margin: 0;
        }

        /* 6. Testimonial / Dignitary Quote Card */
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
            font-size: 14px;
            margin-bottom: 10px;
        }
        .pro-testimonial-quote {
            font-size: 1.4rem;
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
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #721835;
        }
        .pro-testimonial-name {
            font-size: 1.35rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        .pro-testimonial-role {
            font-size: 1.15rem;
            color: #64748b;
            margin: 0;
        }

        /* 7. Interactive Responsive Tabs */
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
            font-size: 1.35rem;
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
            font-size: 1.35rem;
            line-height: 1.75;
            color: #334155;
        }
        .pro-tab-pane.active {
            display: block;
        }

        /* 8. Progress / Target Indicator */
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
            font-size: 1.35rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        .pro-progress-pct {
            font-size: 1.35rem;
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

        /* 9. Timeline Roadmap */
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
            font-size: 1.15rem;
            font-weight: 700;
            color: #721835;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .pro-timeline-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 6px;
        }
        .pro-timeline-desc {
            font-size: 1.35rem;
            line-height: 1.7;
            color: #475569;
            margin: 0;
        }

        /* 10. Feature / Service Icon Box */
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
            font-size: 1.6rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 8px;
        }
        .pro-icon-desc {
            font-size: 1.35rem;
            line-height: 1.7;
            color: #475569;
            margin: 0 0 12px;
        }
        .pro-icon-link {
            font-size: 1.25rem;
            font-weight: 700;
            color: #721835;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* 11. Document Download Card */
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
            font-size: 1.45rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 4px;
        }
        .pro-doc-meta {
            font-size: 1.2rem;
            color: #64748b;
            margin: 0;
        }

        /* 12. Flip Box */
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
            font-size: 1.7rem;
            font-weight: 700;
            color: #721835;
            margin: 0 0 10px;
        }
        .pro-flipbox-desc {
            font-size: 1.35rem;
            color: #475569;
            margin: 0;
            line-height: 1.65;
        }

        /* 13. Notice / Alert Callout Banner */
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
            font-size: 22px;
            margin-top: 2px;
        }
        .pro-alert-content h5 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 4px;
        }
        .pro-alert-content p {
            font-size: 1.35rem;
            margin: 0;
            line-height: 1.6;
        }

        /* 14. Video Player Card */
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

        /* 15. Gallery Grid */
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
            font-size: 1.25rem;
            font-weight: 600;
            color: #334155;
            text-align: center;
            margin: 0;
        }

        /* Government Layout Styles */
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
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .team-avatar-wrap:hover {
            transform: translateX(-50%) scale(1.08);
            box-shadow: 0 6px 16px rgba(114, 24, 53, 0.35);
        }
        .team-avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            display: block;
            cursor: pointer;
        }
        .team-node-role {
            font-size: 1.15rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #9c2759;
            margin-bottom: 6px;
        }
        .team-node-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1a1a1a;
        }
        .team-tree-line {
            width: 2px;
            height: 48px;
            background-color: #d8c0cc;
            margin: 0 auto;
        }
        .team-dl-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            border: 1.5px solid #a3245f;
            color: #721835;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            padding: 9px 20px;
            border-radius: 8px;
            text-decoration: none !important;
            transition: all 0.2s;
            box-shadow: 0 2px 6px rgba(114, 24, 53, 0.08);
        }
        .team-dl-btn:hover {
            background: #721835;
            color: #ffffff;
        }

        .about-page-layout {
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }
        .about-vision-col {
            flex: 0 0 330px;
            max-width: 330px;
        }
        .about-vision-card {
            background: #eff0f3;
            border-radius: 10px;
            padding: 28px 24px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.02);
        }
        .about-vision-text {
            font-size: 1.4rem;
            line-height: 1.8;
            color: #222222;
            margin: 0;
            text-align: justify;
        }
        .about-vision-title {
            color: #6c1340;
            font-size: 2.1rem;
            font-weight: 700;
            margin-top: 26px;
            margin-bottom: 0;
        }
        .about-main-col {
            flex: 1;
            min-width: 0;
        }
        .about-lead-para {
            font-size: 1.45rem;
            line-height: 1.8;
            color: #222222;
            margin-bottom: 22px;
            text-align: justify;
        }
        .about-mission-heading {
            color: #1a1a1a;
            font-size: 1.95rem;
            font-weight: 700;
            margin-top: 28px;
            margin-bottom: 14px;
        }
        .about-mission-list {
            padding-left: 20px;
            margin: 0;
        }
        .about-mission-list li {
            font-size: 1.4rem;
            line-height: 1.75;
            color: #222222;
            margin-bottom: 10px;
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
            font-size: 1.65rem;
            font-weight: 700;
            color: #721835;
            margin: 0;
            line-height: 1.35;
        }
        .acts-card-title a {
            color: #721835;
            text-decoration: none;
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
            cursor: pointer;
        }
        .acts-card-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .acts-card-desc {
            font-size: 1.35rem;
            line-height: 1.7;
            color: #444444;
            margin-bottom: 18px;
            text-align: justify;
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
            font-size: 1.25rem;
            font-weight: 700;
            text-decoration: none !important;
            background: #fdf5f8;
            padding: 6px 14px;
            border-radius: 6px;
            border: 1px solid #ebd0de;
            transition: all 0.2s;
        }
        .acts-pdf-badge:hover {
            background: #721835;
            color: #ffffff;
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
        .editor-row-ctrl {
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .editor-table-ctrl, .editor-table-btn {
            user-select: none;
        }

        /* Universal Clean Data Table (No icons in cells) */
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
        .dbim-data-table-wrapper .col-title:focus,
        .dbim-data-table-wrapper .dbim-cell-text:focus {
            outline: 2px solid #721835;
            background: #fff;
            border-radius: 2px;
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

        /* ============================================================
           ADVANCED PRO GRID TABLE (SPANS, THEAD & COMPLETE LAYOUT)
           ============================================================ */
        .dbim-advanced-table-wrapper {
            margin: 24px 0;
            position: relative;
            font-family: 'Noto Sans', sans-serif;
        }
        .editor-pro-table-ctrl {
            background: #ffffff;
            border: 1px solid #ebd0de;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(114, 24, 53, 0.06);
            user-select: none;
            position: relative;
            z-index: 10;
        }
        .dbim-pro-table {
            border-collapse: collapse;
            font-size: 1.35rem;
            width: 100%;
        }
        .dbim-pro-table th,
        .dbim-pro-table td {
            position: relative;
            padding: 10px 14px;
            transition: outline 0.15s ease, background-color 0.15s ease;
            vertical-align: middle;
        }
        .dbim-pro-table th:focus,
        .dbim-pro-table td:focus {
            outline: 2px solid #721835 !important;
            background-color: #fcf5f8 !important;
        }
        .dbim-pro-table .pro-cell-active {
            outline: 2.5px solid #721835 !important;
            box-shadow: inset 0 0 0 1px #ffffff, 0 0 8px rgba(114, 24, 53, 0.4) !important;
            position: relative;
            z-index: 2;
        }
        .pro-thead-primary th {
            background-color: #721835 !important;
            color: #ffffff !important;
            font-weight: 700;
            border-color: #9c2759 !important;
        }
        .pro-thead-secondary th {
            background-color: #8b1f42 !important;
            color: #ffffff !important;
            font-weight: 600;
            border-color: #9c2759 !important;
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
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
        }
        .dbim-avatar-img-wrap:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgba(114, 24, 53, 0.35);
        }
        .dbim-avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            background: #ffffff;
            display: block;
        }
        .editor-avatar-btn {
            border-radius: 20px;
            font-size: 10.5px;
            padding: 3px 12px;
            white-space: nowrap;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            z-index: 5;
            background: #1e1b24;
            color: #ffffff;
            border: 1px solid #ffffff;
            cursor: pointer;
            transition: all 0.2s;
        }
        .editor-avatar-btn:hover {
            background: #721835;
            color: #ffffff;
            transform: scale(1.05);
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
        .editor-faq-btn {
            font-size: 11px;
            cursor: pointer;
        }

        /* ============================================================
           DYNAMIC IMAGE & IMAGE-WITH-TEXT COMPONENTS
           ============================================================ */
        .dbim-custom-image-wrapper {
            margin: 24px auto;
            position: relative;
            transition: all 0.25s ease;
        }
        .dbim-custom-image-wrapper:hover .editor-img-ctrl,
        .dbim-image-with-text-wrapper:hover .editor-img-ctrl {
            opacity: 1;
            pointer-events: auto;
        }
        .dbim-custom-img {
            max-width: 100%;
            height: auto;
            display: inline-block;
            transition: all 0.25s ease;
        }
        .editor-img-ctrl {
            z-index: 20;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(4px);
        }
        .editor-img-btn {
            font-size: 11px;
            cursor: pointer;
            border-radius: 4px;
        }
        .dbim-image-with-text-wrapper {
            transition: all 0.25s ease;
        }

        /* ============================================================
           DBIM COMPLIANT BOOK, PUBLICATION & MAGAZINE CARDS
           ============================================================ */
        .dbim-book-magazine-section {
            margin: 28px auto;
            position: relative;
        }
        .dbim-book-card {
            background: #fdf5f8 !important;
            border: 1px solid #ebd0de !important;
            border-radius: 6px !important;
            padding: 12px !important;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(114, 24, 53, 0.04);
            transition: all 0.25s ease;
        }
        .dbim-book-card:hover {
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
            background: #ffffff;
            cursor: pointer;
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
        .editor-book-btn {
            font-size: 11px;
            cursor: pointer;
            border-radius: 4px;
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
        .editor-photo-btn, .editor-video-btn, .editor-pres-btn {
            font-size: 11px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <!-- 1. TOP HEADER BAR -->
    <header class="editor-topbar">
        <div class="editor-brand">
            <span class="badge" style="background: #721835; font-size: 11px;">LIVE VISUAL EDITOR</span>
            <span>{{ $page->title_en }}</span>
            <span class="text-muted" style="font-size: 12px; font-weight: normal;">(/page/{{ $page->slug }})</span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- View Mode Switcher -->
            <button class="btn btn-sm btn-dark text-white border-0" onclick="setCanvasMode('desktop')" title="Desktop View">
                <i class="fa fa-desktop"></i>
            </button>
            <button class="btn btn-sm btn-dark text-white border-0" onclick="setCanvasMode('tablet')" title="Tablet View">
                <i class="fa fa-tablet-screen-button"></i>
            </button>
            <button class="btn btn-sm btn-dark text-white border-0" onclick="setCanvasMode('mobile')" title="Mobile View">
                <i class="fa fa-mobile-screen"></i>
            </button>
        </div>

        <div class="editor-topbar-actions">
            <a href="{{ route('page.show', $page->slug) }}" target="_blank" class="btn btn-outline-light btn-sm">
                <i class="fa fa-eye me-1"></i> View Live Site
            </a>
            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-outline-secondary btn-sm text-light">
                <i class="fa fa-cog me-1"></i> Page Settings
            </a>
            <button type="button" class="btn btn-outline-warning btn-sm text-white" onclick="openMediaManagerModal()" title="Media Library: Upload any file & copy link">
                <i class="fa-solid fa-photo-film me-1 text-warning"></i> Media Library
            </button>
            <button type="button" class="btn btn-success btn-sm fw-bold px-3" id="savePageBtn" onclick="saveVisualPage()">
                <i class="fa fa-floppy-disk me-1"></i> Save Changes
            </button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-danger btn-sm">
                <i class="fa fa-xmark"></i>
            </a>
        </div>
    </header>

    <!-- 2. ELEMENTOR-STYLE WIDGETS SIDEBAR (WITH DRAG & DROP) -->
    <aside class="editor-sidebar">
        <div class="editor-sidebar-tabs">
            <div class="editor-sidebar-tab active">
                <i class="fa-solid fa-shapes me-1"></i> Elements & Widgets
            </div>
            <div class="editor-sidebar-tab" onclick="alert('Switching between English and Hindi content is available via page settings or editor controls.')">
                <i class="fa-solid fa-language me-1"></i> Locale
            </div>
        </div>

        <div class="editor-widgets-container">
            <!-- Widget Search -->
            <div class="widget-search-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" class="widget-search-input" placeholder="Search widgets & components..." onkeyup="filterWidgets(this.value)">
            </div>

            <!-- DBIM THEME COMPONENTS (texmin.gov.in) -->
            <div class="widget-section-title">
                <span>DBIM Theme Sections (texmin.gov.in)</span>
                <span class="badge" style="background: #721835; font-size: 9px; color: #fff;">OFFICIAL</span>
            </div>
            <div class="widget-grid">
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_objectives_3col')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_objectives_3col')" title="Drag into canvas or click to add: Objectives heading with 3 numbered cards in #ebd0de">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">3-CARD</span>
                    <i class="fa-solid fa-bullseye text-danger"></i>
                    <span>Objectives (3 Outcome Cards)</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_section_doc_box')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_section_doc_box')" title="Drag into canvas or click to add: Section heading with intro text and single document View card">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">DOC</span>
                    <i class="fa-solid fa-file-lines text-danger"></i>
                    <span>Section + Doc Download Box</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_doc_list_section')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_doc_list_section')" title="Drag into canvas or click to add: Section heading with stacked document download cards & Add button">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">STACK</span>
                    <i class="fa-solid fa-folder-tree text-danger"></i>
                    <span>Document List (Stacked Cards)</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_single_doc_card')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_single_doc_card')" title="Drag into canvas or click to add: Single document download row with View button">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">VIEW</span>
                    <i class="fa-regular fa-file-pdf text-danger"></i>
                    <span>Document Card (Single)</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_vision_box')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_vision_box')" title="Drag into canvas or click to add: Sticky vision/mandate box in #ebeaea with maroon text">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">VISION</span>
                    <i class="fa-solid fa-lightbulb text-danger"></i>
                    <span>Vision / Mandate Box</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_full_layout')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_full_layout')" title="Drag into canvas or click to add: Full 2-column DBIM page (Vision left + Objectives & Docs right)">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">2-COL</span>
                    <i class="fa-solid fa-table-columns text-danger"></i>
                    <span>Full 2-Col DBIM Page</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_directory_table')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_directory_table')" title="Drag into canvas or click to add: Official Ministry & Officer Contact Directory Table (Hon'ble Minister, Secretary, etc.)">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">TABLE</span>
                    <i class="fa-solid fa-table-list text-danger"></i>
                    <span>Official Directory Table</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_data_table')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_data_table')" title="Drag into canvas or click to add: Universal Clean Data Table (No icons in cells, Add/Remove Rows & Columns, Cell Images, Pagination, Action Buttons)">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #0f766e; color: #fff;">DATA TABLE</span>
                    <i class="fa-solid fa-table text-success"></i>
                    <span>Universal Data Table</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_advanced_table')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_advanced_table')" title="Drag into canvas or section: Advanced Grid Table with Header Rows, Rowspan, Colspan, Cell Alignment, Spans & Colors">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">PRO TABLE</span>
                    <i class="fa-solid fa-table-cells text-danger"></i>
                    <span>Pro Grid Table (Spans & Layout)</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_avatar_profile_card')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_avatar_profile_card')" title="Drag into canvas or click to add: Officer Profile Card with circular photo avatar, dynamic image uploader, role & contact">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">AVATAR</span>
                    <i class="fa-solid fa-circle-user text-danger"></i>
                    <span>Officer Avatar Card</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_avatar_leadership_grid')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_avatar_leadership_grid')" title="Drag into canvas or click to add: Leadership 3-column avatar grid (Hon'ble Minister, MoS, Secretary)">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">LEADERS</span>
                    <i class="fa-solid fa-users-gear text-danger"></i>
                    <span>Leadership Avatar Grid</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_avatar_inline')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_avatar_inline')" title="Drag into canvas or click to add: Standalone circular profile avatar with instant photo uploader">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">PHOTO</span>
                    <i class="fa-regular fa-user text-danger"></i>
                    <span>Avatar Circle (Inline)</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_faq_component')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_faq_component')" title="Drag into canvas or click to add: Official Government FAQ Component with search, expand/collapse, and Add Question controls">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">FAQ</span>
                    <i class="fa-solid fa-circle-question text-danger"></i>
                    <span>Govt FAQ Component</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_custom_image')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_custom_image')" title="Drag into canvas or section: Standalone Image with Shape (Circle, Rounded, Square, Frame) & Size Controls">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #0f766e; color: #fff;">IMAGE</span>
                    <i class="fa-regular fa-image text-danger"></i>
                    <span>Dynamic Image (Custom Shape/Size)</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_image_with_text')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_image_with_text')" title="Drag into canvas or section: Image with Text with Shape, Size, and Left/Right Flip Controls">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">MEDIA</span>
                    <i class="fa-solid fa-newspaper text-danger"></i>
                    <span>Image with Text (Media Feature)</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_book_magazine_grid')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_book_magazine_grid')" title="Drag into canvas or click to add: DBIM Book / Publication / Magazine Cards Grid with cover upload, PDF download, and responsive columns">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">BOOKS / PUBS</span>
                    <i class="fa-solid fa-book-open text-danger"></i>
                    <span>Books & Magazines Grid</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_photo_gallery')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_photo_gallery')" title="Drag into canvas or click to add: Photo Gallery Grid with search, sort, category filtering, photo count, and image lightbox">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">PHOTOS</span>
                    <i class="fa-solid fa-camera-retro text-danger"></i>
                    <span>Photo Gallery Grid</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_video_gallery')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_video_gallery')" title="Drag into canvas or click to add: Video Gallery Grid with video player, duration, category filter, and sort">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">VIDEOS</span>
                    <i class="fa-solid fa-circle-play text-danger"></i>
                    <span>Video Gallery Grid</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'dbim_presentation_events')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('dbim_presentation_events')" title="Drag into canvas or click to add: Presentation & Events Grid with slide banner, date, View button, and search/sort">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">EVENTS</span>
                    <i class="fa-solid fa-person-chalkboard text-danger"></i>
                    <span>Presentations / Events</span>
                </div>
            </div>

            <!-- FEATURED FULL-PAGE TEMPLATES (1-Click Complete Layouts) -->
            <div class="widget-section-title">
                <span>Featured Complete Layouts</span>
                <span class="badge bg-success" style="font-size: 9px;">1-CLICK</span>
            </div>
            <div class="widget-grid" style="grid-template-columns: 1fr;">
                <div class="widget-card text-start p-3" draggable="true" ondragstart="handleWidgetDragStart(event, 'template_act_history')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('template_act_history')" title="Drag into canvas or click to insert this complete layout" style="background: #fdf5f8; border: 1.5px solid #ebd0de;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge" style="background: #721835; font-size: 10px;">OFFICIAL TEXMIN LAYOUT</span>
                        <i class="fa-solid fa-wand-magic-sparkles text-danger mb-0" style="font-size: 16px;"></i>
                    </div>
                    <strong class="d-block text-dark mb-1" style="font-size: 12.5px;">Act, History & Decades Evolution Layout</strong>
                    <small class="text-muted d-block" style="font-size: 11px; line-height: 1.4;">
                        Complete 2-column statutory layout with overview grey box, downloadable Act PDF card, historical timeline bullets, and Core Mission callout box.
                    </small>
                </div>
                <div class="widget-card text-start p-3 mt-2" draggable="true" ondragstart="handleWidgetDragStart(event, 'template_dbim_contact_us')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('template_dbim_contact_us')" title="Drag into canvas or click to insert official DBIM Contact Us & Citizen Inquiry layout" style="background: #fdf5f8; border: 1.5px solid #ebd0de;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge" style="background: #721835; font-size: 10px;">DBIM CONNECT LAYOUT</span>
                        <i class="fa-solid fa-address-card text-danger mb-0" style="font-size: 16px;"></i>
                    </div>
                    <strong class="d-block text-dark mb-1" style="font-size: 12.5px;">Contact Us & Citizen Inquiry Layout</strong>
                    <small class="text-muted d-block" style="font-size: 11px; line-height: 1.4;">
                        Headquarters address card, office hours notice, citizen inquiry form, Google Maps embed, transit directions, and key division officers directory.
                    </small>
                </div>
            </div>

            <!-- SECTION A: CONTAINERS & LAYOUTS (Elementor Pro Flexbox) -->
            <div class="widget-section-title">
                <span>Layout & Grid Containers</span>
                <span class="badge bg-secondary" style="font-size: 9px;">5 GRIDS</span>
            </div>
            <div class="widget-grid">
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'container_1col')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('container_1col')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-square"></i>
                    <span>1-Col Container</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'container_2col')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('container_2col')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-table-columns"></i>
                    <span>2-Col Grid (50/50)</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'container_3col')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('container_3col')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-table-cells-large"></i>
                    <span>3-Col Grid (33%)</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'container_4col')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('container_4col')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-table-cells"></i>
                    <span>4-Col Grid (25%)</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'container_sidebar')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('container_sidebar')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-columns"></i>
                    <span>1/3 + 2/3 Sidebar</span>
                </div>
            </div>

            <!-- SECTION B: ELEMENTOR PRO COMPONENTS -->
            <div class="widget-section-title">
                <span>Elementor Pro Widgets</span>
                <span class="badge bg-danger" style="font-size: 9px;">PRO</span>
            </div>
            <div class="widget-grid">
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'pro_dual_heading')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('pro_dual_heading')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-heading text-danger"></i>
                    <span>Dual / Animated Heading</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'pro_cta')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('pro_cta')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-bullhorn text-danger"></i>
                    <span>Call To Action (CTA)</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'pro_pricing')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('pro_pricing')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-indian-rupee-sign text-danger"></i>
                    <span>Charges / Pricing Box</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'pro_counter')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('pro_counter')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-arrow-up-right-dots text-danger"></i>
                    <span>Stats / Counter Box</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'pro_testimonial')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('pro_testimonial')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-comment-dots text-danger"></i>
                    <span>Testimonial / Quote</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'pro_tabs')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('pro_tabs')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-folder-open text-danger"></i>
                    <span>Interactive Tabs</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'pro_progressbar')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('pro_progressbar')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-bars-progress text-danger"></i>
                    <span>Progress / Skill Bar</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'pro_timeline')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('pro_timeline')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-timeline text-danger"></i>
                    <span>Milestone Timeline</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'pro_iconbox')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('pro_iconbox')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-icons text-danger"></i>
                    <span>Feature Icon Box</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'pro_flipbox')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('pro_flipbox')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-repeat text-danger"></i>
                    <span>Interactive Flip Box</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'pro_alert')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('pro_alert')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-bell text-danger"></i>
                    <span>Notice / Alert Callout</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'pro_video')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('pro_video')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-circle-play text-danger"></i>
                    <span>Video Player Card</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'pro_doc_card')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('pro_doc_card')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-file-shield text-danger"></i>
                    <span>Doc Download Card</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'pro_gallery')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('pro_gallery')" title="Drag into canvas or click to add">
                    <span class="badge-pro">PRO</span>
                    <i class="fa-solid fa-images text-danger"></i>
                    <span>Image Gallery (3-Col)</span>
                </div>
            </div>

            <!-- SECTION C: GOVERNMENT LAYOUTS (texmin.gov.in) -->
            <div class="widget-section-title">
                <span>Government Layouts (texmin.gov.in)</span>
            </div>
            <div class="widget-grid">
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'about_layout')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('about_layout')" title="Drag into canvas or click to add">
                    <i class="fa-solid fa-landmark"></i>
                    <span>Vision + Mission (2-Col)</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'officer_card')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('officer_card')" title="Drag into canvas or click to add">
                    <i class="fa-solid fa-id-card"></i>
                    <span>Officer Profile Badge</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'gov_table')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('gov_table')" title="Drag into canvas or click to add">
                    <i class="fa-solid fa-table"></i>
                    <span>Govt Data Table</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'download_btn')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('download_btn')" title="Drag into canvas or click to add">
                    <i class="fa-regular fa-file-pdf"></i>
                    <span>PDF Download Badge</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'acts_card')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('acts_card')" title="Drag into canvas or click to add">
                    <i class="fa-solid fa-scale-balanced"></i>
                    <span>Act / Org Card</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'flowchart_node')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('flowchart_node')" title="Drag into canvas or click to add">
                    <i class="fa-solid fa-diagram-project"></i>
                    <span>Org Flowchart</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'accordion')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('accordion')" title="Drag into canvas or click to add">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>FAQ Accordion</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'office_network_map')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('office_network_map')" title="Interactive Regional Offices Map & RO Cards (#ebd0de)">
                    <i class="fa-solid fa-map-location-dot text-primary"></i>
                    <span>RO Network & Map</span>
                </div>
                <div class="widget-card" onclick="openPdfUploader()" title="Upload a PDF file from your device">
                    <i class="fa-solid fa-file-arrow-up text-danger"></i>
                    <span>Upload PDF Doc</span>
                </div>
            </div>

            <!-- SECTION D: BASIC ELEMENTS -->
            <div class="widget-section-title">
                <span>Basic Typography & Media</span>
            </div>
            <div class="widget-grid">
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'heading')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('heading')" title="Drag into canvas or click to add">
                    <i class="fa-solid fa-heading"></i>
                    <span>Standard Heading</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'paragraph')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('paragraph')" title="Drag into canvas or click to add">
                    <i class="fa-solid fa-paragraph"></i>
                    <span>Paragraph Text</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'bullet_list')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('bullet_list')" title="Drag into canvas or click to add">
                    <i class="fa-solid fa-list-ul"></i>
                    <span>Bullet List</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'callout_box')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('callout_box')" title="Drag into canvas or click to add">
                    <i class="fa-solid fa-quote-left"></i>
                    <span>Callout Box</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'image')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('image')" title="Drag into canvas or click to add">
                    <i class="fa-regular fa-image"></i>
                    <span>Image / Photo</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'divider')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('divider')" title="Drag into canvas or click to add">
                    <i class="fa-solid fa-minus"></i>
                    <span>Divider Line</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'redirection_button')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('redirection_button')" title="Redirection Button with link, icon, custom styles & target">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">LINK</span>
                    <i class="fa-solid fa-arrow-pointer text-danger"></i>
                    <span>Redirection Button</span>
                </div>
                <div class="widget-card" draggable="true" ondragstart="handleWidgetDragStart(event, 'anchor_tag')" ondragend="handleWidgetDragEnd(event)" onclick="insertWidget('anchor_tag')" title="Hyperlink / A-Tag Component with URL redirection">
                    <span class="badge" style="position: absolute; top: 4px; right: 4px; font-size: 8px; background: #721835; color: #fff;">LINK</span>
                    <i class="fa-solid fa-link text-primary"></i>
                    <span>Link / Anchor Tag (A-Tag)</span>
                </div>
            </div>

            <div class="mt-4 p-3 bg-light rounded text-center border">
                <small class="text-dark d-block mb-1 fw-bold">
                    <i class="fa-solid fa-hand-pointer text-primary me-1"></i> Drag & Drop or Click:
                </small>
                <small class="text-muted" style="font-size: 11.5px; line-height: 1.5; display: block;">
                    Drag any widget card directly into the canvas. You can also click it to append to cursor. Select any text to use the Format Painter.
                </small>
            </div>
        </div>
    </aside>

    <!-- 3. CANVAS WORKING AREA -->
    <main class="editor-canvas-wrapper" onclick="handleCanvasWrapperClick(event)">
        <div class="editor-device-frame" id="deviceFrame">
            <!-- Simulated Hero Banner -->
            <div class="canvas-banner-preview">
                <small>Home / Ministry / {{ $page->slug }}</small>
                <h2>{{ $page->title_en }}</h2>
            </div>

            <!-- Floating Formatting Toolbar (with Format Painter & Typography Controls) -->
            <div class="editor-floating-toolbar" id="editorToolbar">
                <!-- FORMAT PAINTER BUTTON -->
                <button type="button" class="toolbar-btn text-primary fw-bold" id="formatPainterBtn" onclick="toggleFormatPainter()" title="Format Painter: Select text to copy style, click here, then click or highlight target text to apply style!">
                    <i class="fa-solid fa-paintbrush"></i>
                    <span>Format Painter</span>
                </button>
                <div class="toolbar-divider"></div>

                <!-- FONT FAMILY PICKER -->
                <select class="toolbar-select" onchange="applyFontFamily(this.value)" title="Change Font Family">
                    <option value="">Font Family</option>
                    <option value="'Noto Sans', sans-serif">Noto Sans</option>
                    <option value="'Roboto', sans-serif">Roboto</option>
                    <option value="'Open Sans', sans-serif">Open Sans</option>
                    <option value="Georgia, serif">Georgia</option>
                    <option value="'Times New Roman', serif">Times New Roman</option>
                    <option value="Arial, sans-serif">Arial</option>
                    <option value="'Trebuchet MS', sans-serif">Trebuchet MS</option>
                </select>

                <!-- FONT SIZE PICKER -->
                <select class="toolbar-select" onchange="applyFontSize(this.value)" title="Change Font Size">
                    <option value="">Font Size</option>
                    <option value="12px">12px (Small)</option>
                    <option value="14px">14px (Standard)</option>
                    <option value="16px">16px (Normal)</option>
                    <option value="18px">18px (Medium)</option>
                    <option value="20px">20px (Lead)</option>
                    <option value="24px">24px (H3 Heading)</option>
                    <option value="28px">28px (H2 Heading)</option>
                    <option value="34px">34px (H1 Title)</option>
                    <option value="42px">42px (Display)</option>
                </select>

                <!-- TEXT COLOR PICKER -->
                <div class="toolbar-color-wrap" title="Change Font / Text Color">
                    <i class="fa-solid fa-font"></i>
                    <input type="color" id="textColorPicker" value="#1e293b" onchange="execCmd('foreColor', this.value)">
                </div>

                <!-- HIGHLIGHT COLOR PICKER -->
                <div class="toolbar-color-wrap" title="Text Background Highlight">
                    <i class="fa-solid fa-highlighter text-warning"></i>
                    <input type="color" id="bgColorPicker" value="#ffff00" onchange="execCmd('hiliteColor', this.value)">
                </div>

                <div class="toolbar-divider"></div>

                <!-- TEXT FORMATTING -->
                <button type="button" class="toolbar-btn" onclick="execCmd('bold')" title="Bold (Ctrl+B)"><i class="fa-solid fa-bold"></i></button>
                <button type="button" class="toolbar-btn" onclick="execCmd('italic')" title="Italic (Ctrl+I)"><i class="fa-solid fa-italic"></i></button>
                <button type="button" class="toolbar-btn" onclick="execCmd('underline')" title="Underline (Ctrl+U)"><i class="fa-solid fa-underline"></i></button>
                <button type="button" class="toolbar-btn" onclick="execCmd('strikeThrough')" title="Strikethrough"><i class="fa-solid fa-strikethrough"></i></button>

                <div class="toolbar-divider"></div>

                <!-- HEADINGS -->
                <button type="button" class="toolbar-btn" onclick="execCmd('formatBlock', '<h2>')" title="H2 Heading">H2</button>
                <button type="button" class="toolbar-btn" onclick="execCmd('formatBlock', '<h3>')" title="H3 Heading">H3</button>
                <button type="button" class="toolbar-btn" onclick="execCmd('formatBlock', '<p>')" title="Normal Paragraph">¶</button>

                <div class="toolbar-divider"></div>

                <!-- LISTS -->
                <button type="button" class="toolbar-btn" onclick="execCmd('insertUnorderedList')" title="Bullet List"><i class="fa-solid fa-list-ul"></i></button>
                <button type="button" class="toolbar-btn" onclick="execCmd('insertOrderedList')" title="Numbered List"><i class="fa-solid fa-list-ol"></i></button>

                <div class="toolbar-divider"></div>

                <!-- ALIGNMENT -->
                <button type="button" class="toolbar-btn" onclick="execCmd('justifyLeft')" title="Align Left"><i class="fa-solid fa-align-left"></i></button>
                <button type="button" class="toolbar-btn" onclick="execCmd('justifyCenter')" title="Align Center"><i class="fa-solid fa-align-center"></i></button>
                <button type="button" class="toolbar-btn" onclick="execCmd('justifyRight')" title="Align Right"><i class="fa-solid fa-align-right"></i></button>
                <button type="button" class="toolbar-btn" onclick="execCmd('justifyFull')" title="Justify"><i class="fa-solid fa-align-justify"></i></button>

                <div class="toolbar-divider"></div>

                <!-- MEDIA & LINKS -->
                <button type="button" class="toolbar-btn text-primary fw-bold" onclick="openImagePicker('insert')" title="Insert Image from Library or Computer">
                    <i class="fa-regular fa-image me-1"></i> Image
                </button>
                <button type="button" class="toolbar-btn text-danger fw-bold" onclick="openPdfUploader()" title="Upload & Insert PDF Document">
                    <i class="fa-regular fa-file-pdf me-1"></i> PDF
                </button>
                <button type="button" class="toolbar-btn text-purple fw-bold" onclick="openMediaManagerModal()" title="Media Manager: Upload files & copy public links" style="color: #6366f1 !important;">
                    <i class="fa-solid fa-photo-film me-1"></i> Media Library
                </button>
                <button type="button" class="toolbar-btn text-primary fw-bold" onclick="openLinkSettingsModal(null)" title="Insert / Edit Link & Redirection"><i class="fa-solid fa-link me-1"></i> Link</button>
                <button type="button" class="toolbar-btn" onclick="execCmd('unlink')" title="Remove Link"><i class="fa-solid fa-link-slash"></i></button>
                <button type="button" class="toolbar-btn text-danger" onclick="execCmd('removeFormat')" title="Clear Formatting"><i class="fa-solid fa-eraser"></i></button>
                <button type="button" class="toolbar-btn text-warning fw-bold" onclick="cleanActiveFormatting()" title="Remove Word White Background & Font Override: Cleans pasted text so it seamlessly blends with your site theme">
                    <i class="fa-solid fa-broom me-1"></i> Clean Style
                </button>
                <div class="toolbar-divider"></div>
                <button type="button" class="toolbar-btn text-primary fw-bold" onclick="openSizeModal()" title="Adjust Size / Width of Active Section">
                    <i class="fa-solid fa-arrows-left-right-to-line me-1"></i> Width / Size
                </button>
                <button type="button" class="toolbar-btn text-danger fw-bold" onclick="deleteActiveSection()" title="Delete Section / Block (Select section and click to remove)">
                    <i class="fa-solid fa-trash-can me-1"></i> Delete Section
                </button>
            </div>

            <!-- Active Format Painter Notification Banner -->
            <div class="format-painter-banner" id="formatPainterBanner">
                <div>
                    <i class="fa-solid fa-paintbrush me-2"></i>
                    <strong>Format Painter Active:</strong> Click or highlight any text or element on the canvas to apply copied typography!
                </div>
                <button type="button" class="btn btn-sm btn-outline-dark py-0" onclick="cancelFormatPainter()">Cancel (Esc)</button>
            </div>

            <!-- Floating Section Action Controls (Elementor-Style: Delete, Duplicate, Move, Resize) -->
            <div id="sectionActionOverlay" class="section-action-overlay">
                <div class="section-ctrl-bar">
                    <span class="section-ctrl-label" id="sectionCtrlLabel">Section</span>
                    <button type="button" class="section-ctrl-btn text-warning fw-bold" onclick="openSizeModal()" title="Adjust Size / Width (Enter value or choose preset)">
                        <i class="fa-solid fa-arrows-left-right-to-line"></i> Size
                    </button>
                    <button type="button" class="section-ctrl-btn" onclick="moveActiveSection('up')" title="Move Section Up">
                        <i class="fa-solid fa-arrow-up"></i>
                    </button>
                    <button type="button" class="section-ctrl-btn" onclick="moveActiveSection('down')" title="Move Section Down">
                        <i class="fa-solid fa-arrow-down"></i>
                    </button>
                    <button type="button" class="section-ctrl-btn" onclick="duplicateActiveSection()" title="Duplicate Section">
                        <i class="fa-solid fa-copy"></i>
                    </button>
                    <button type="button" class="section-ctrl-btn btn-delete" onclick="deleteActiveSection()" title="Delete Section">
                        <i class="fa-solid fa-trash-can"></i> Delete
                    </button>
                </div>
            </div>

            <!-- Drag-to-Resize Handle & Tooltip -->
            <div id="componentResizeHandle" class="component-resize-handle" title="Click & drag to resize width"></div>
            <div id="componentResizeTooltip" class="component-resize-tooltip">320px</div>

            <!-- Drop indicator bar -->
            <div id="dropIndicatorLine" class="drop-indicator-line" style="display: none;"></div>

            <!-- LIVE EDITABLE CANVAS CONTAINER -->
            <div class="live-page-canvas" 
                 id="liveCanvas" 
                 contenteditable="true" 
                 spellcheck="false"
                 ondragover="handleCanvasDragOver(event)"
                 ondragenter="handleCanvasDragEnter(event)"
                 ondragleave="handleCanvasDragLeave(event)"
                 ondrop="handleCanvasDrop(event)"
                 onclick="handleCanvasClick(event)"
                 onmouseup="handleCanvasMouseUp(event)">
                @if(!empty(trim($page->content_en)))
                    {!! $page->content_en !!}
                @else
                    <div class="alert alert-info py-4 my-3 text-center" id="emptyCanvasNotice">
                        <i class="fa-solid fa-hand-pointer me-2"></i> <strong>Start building your page:</strong> Click here to begin typing, or drag any widget from the left sidebar into this area!
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Save Notification Toast -->
    <div class="save-indicator" id="saveIndicator">
        <i class="fa-solid fa-circle-check"></i>
        <span>Changes saved successfully!</span>
    </div>

    <!-- Quick Toast Notification -->
    <div class="save-indicator" id="quickToast" style="background: #1e1b24;">
        <i class="fa-solid fa-info-circle text-warning"></i>
        <span id="quickToastText">Action performed</span>
    </div>

    <script>
        // Global State
        let draggedWidgetType = null;
        let dropTargetBlock = null;
        let dropPosition = 'after'; // 'before' or 'after'
        let isFormatPainterActive = false;
        let copiedStyle = null;

        // Formatting helper
        function execCmd(command, value = null) {
            const canvas = document.getElementById('liveCanvas');
            canvas.focus();
            document.execCommand(command, false, value);
        }

        function createLinkPrompt() {
            openLinkSettingsModal(null);
        }

        // Apply Font Family
        function applyFontFamily(font) {
            if (!font) return;
            const canvas = document.getElementById('liveCanvas');
            canvas.focus();
            const selection = window.getSelection();
            if (selection && selection.rangeCount > 0 && selection.toString().length > 0) {
                const span = document.createElement('span');
                span.style.fontFamily = font;
                const range = selection.getRangeAt(0);
                span.appendChild(range.extractContents());
                range.insertNode(span);
            } else {
                document.execCommand('fontName', false, font);
            }
        }

        // Apply Font Size
        function applyFontSize(size) {
            if (!size) return;
            const canvas = document.getElementById('liveCanvas');
            canvas.focus();
            const selection = window.getSelection();
            if (selection && selection.rangeCount > 0 && selection.toString().length > 0) {
                const span = document.createElement('span');
                span.style.fontSize = size;
                const range = selection.getRangeAt(0);
                span.appendChild(range.extractContents());
                range.insertNode(span);
            } else {
                // If cursor is inside a node without text selected, style the parent node
                const node = selection.anchorNode;
                if (node) {
                    const el = node.nodeType === 3 ? node.parentElement : node;
                    if (el && el !== canvas) {
                        el.style.fontSize = size;
                    }
                }
            }
        }

        // View Mode Toggle (Desktop / Tablet / Mobile)
        function setCanvasMode(mode) {
            const frame = document.getElementById('deviceFrame');
            if (mode === 'desktop') {
                frame.style.maxWidth = '1140px';
            } else if (mode === 'tablet') {
                frame.style.maxWidth = '768px';
            } else if (mode === 'mobile') {
                frame.style.maxWidth = '390px';
            }
        }

        // Filter Sidebar Widgets
        function filterWidgets(term) {
            term = term.toLowerCase().trim();
            const cards = document.querySelectorAll('.widget-card');
            cards.forEach(card => {
                const text = card.innerText.toLowerCase();
                if (text.includes(term)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Show Quick Toast
        function showToast(text, duration = 3000) {
            const toast = document.getElementById('quickToast');
            const toastText = document.getElementById('quickToastText');
            toastText.innerText = text;
            toast.style.display = 'flex';
            setTimeout(() => {
                toast.style.display = 'none';
            }, duration);
        }

        // ============================================================
        // FORMAT PAINTER (COPY & APPLY TYPOGRAPHY / STYLING)
        // ============================================================
        function toggleFormatPainter() {
            if (isFormatPainterActive) {
                cancelFormatPainter();
                return;
            }

            const selection = window.getSelection();
            let targetNode = null;

            if (selection && selection.rangeCount > 0) {
                targetNode = selection.anchorNode;
                if (targetNode && targetNode.nodeType === 3) {
                    targetNode = targetNode.parentElement;
                }
            }

            const canvas = document.getElementById('liveCanvas');
            if (!targetNode || !canvas.contains(targetNode) || targetNode === canvas) {
                alert('Please highlight or click inside the text whose font style you want to copy first!');
                return;
            }

            // Capture computed styles
            const cs = window.getComputedStyle(targetNode);
            copiedStyle = {
                fontFamily: cs.fontFamily,
                fontSize: cs.fontSize,
                fontWeight: cs.fontWeight,
                fontStyle: cs.fontStyle,
                color: cs.color,
                backgroundColor: (cs.backgroundColor && cs.backgroundColor !== 'rgba(0, 0, 0, 0)' && cs.backgroundColor !== 'transparent') ? cs.backgroundColor : '',
                textDecoration: cs.textDecoration,
                lineHeight: cs.lineHeight,
                letterSpacing: cs.letterSpacing,
                textAlign: cs.textAlign
            };

            isFormatPainterActive = true;
            document.getElementById('formatPainterBtn').classList.add('active');
            document.getElementById('formatPainterBanner').classList.add('show');
            canvas.classList.add('painter-active');

            const fontDesc = (cs.fontSize ? cs.fontSize + ' ' : '') + (cs.fontFamily ? cs.fontFamily.split(',')[0].replace(/['"]/g, '') : '');
            showToast('Format copied (' + fontDesc + ')! Click or highlight text to apply.');
        }

        function cancelFormatPainter() {
            isFormatPainterActive = false;
            copiedStyle = null;
            document.getElementById('formatPainterBtn').classList.remove('active');
            document.getElementById('formatPainterBanner').classList.remove('show');
            document.getElementById('liveCanvas').classList.remove('painter-active');
        }

        function applyCopiedFormat(targetEl) {
            if (!isFormatPainterActive || !copiedStyle) return;

            const selection = window.getSelection();
            if (selection && selection.rangeCount > 0 && selection.toString().length > 0) {
                // Apply to highlighted text range
                const range = selection.getRangeAt(0);
                const span = document.createElement('span');
                if (copiedStyle.fontFamily) span.style.fontFamily = copiedStyle.fontFamily;
                if (copiedStyle.fontSize) span.style.fontSize = copiedStyle.fontSize;
                if (copiedStyle.fontWeight) span.style.fontWeight = copiedStyle.fontWeight;
                if (copiedStyle.fontStyle) span.style.fontStyle = copiedStyle.fontStyle;
                if (copiedStyle.color) span.style.color = copiedStyle.color;
                if (copiedStyle.backgroundColor) span.style.backgroundColor = copiedStyle.backgroundColor;
                if (copiedStyle.textDecoration) span.style.textDecoration = copiedStyle.textDecoration;
                if (copiedStyle.lineHeight) span.style.lineHeight = copiedStyle.lineHeight;

                span.appendChild(range.extractContents());
                range.insertNode(span);
            } else if (targetEl && targetEl !== document.getElementById('liveCanvas')) {
                // Apply to clicked element directly
                if (copiedStyle.fontFamily) targetEl.style.fontFamily = copiedStyle.fontFamily;
                if (copiedStyle.fontSize) targetEl.style.fontSize = copiedStyle.fontSize;
                if (copiedStyle.fontWeight) targetEl.style.fontWeight = copiedStyle.fontWeight;
                if (copiedStyle.fontStyle) targetEl.style.fontStyle = copiedStyle.fontStyle;
                if (copiedStyle.color) targetEl.style.color = copiedStyle.color;
                if (copiedStyle.backgroundColor) targetEl.style.backgroundColor = copiedStyle.backgroundColor;
                if (copiedStyle.textDecoration) targetEl.style.textDecoration = copiedStyle.textDecoration;
                if (copiedStyle.lineHeight) targetEl.style.lineHeight = copiedStyle.lineHeight;
                if (copiedStyle.textAlign) targetEl.style.textAlign = copiedStyle.textAlign;
            }

            showToast('Format applied successfully!');
            cancelFormatPainter();
        }

        // ============================================================
        // CANVAS CLICKABILITY & FOCUS MANAGEMENT
        // ============================================================
        function handleCanvasWrapperClick(e) {
            const canvas = document.getElementById('liveCanvas');
            if (e.target.closest('.editor-floating-toolbar') || e.target.closest('.modal')) {
                return;
            }
            // If user clicked in empty margin, focus canvas
            if (!canvas.contains(e.target)) {
                canvas.focus();
            }
        }

        function handleCanvasClick(e) {
            // Check empty notice
            const notice = document.getElementById('emptyCanvasNotice');
            if (notice && notice.contains(e.target)) {
                notice.remove();
                const p = document.createElement('p');
                p.innerHTML = 'Start typing your content here...';
                document.getElementById('liveCanvas').appendChild(p);
                const range = document.createRange();
                const sel = window.getSelection();
                range.selectNodeContents(p);
                sel.removeAllRanges();
                sel.addRange(range);
                return;
            }

            // Format Painter trigger
            if (isFormatPainterActive) {
                applyCopiedFormat(e.target);
            }
        }

        function handleCanvasMouseUp(e) {
            if (isFormatPainterActive) {
                const sel = window.getSelection();
                if (sel && sel.toString().length > 0) {
                    applyCopiedFormat(e.target);
                }
            }
        }

        // Escape cancels format painter
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isFormatPainterActive) {
                cancelFormatPainter();
            }
        });

        // ============================================================
        // MS WORD & RICH TEXT CLEAN PASTE ENGINE
        // ============================================================
        function cleanWordPasteHtml(html) {
            if (!html) return '';

            // 1. Remove Word XML tags & conditional comments
            let clean = html.replace(/<!--[\s\S]*?-->/gi, '');
            clean = clean.replace(/<\/?\w+:[^>]*>/gi, '');

            // 2. Parse into container
            const doc = new DOMParser().parseFromString(clean, 'text/html');
            const body = doc.body;

            // Remove unwanted script, style, meta, link, title tags
            const unwanted = body.querySelectorAll('script, style, meta, link, title, xml');
            unwanted.forEach(el => el.remove());

            // Clean every element
            const all = body.querySelectorAll('*');
            all.forEach(el => {
                // Strip Word classes (e.g. MsoNormal, MsoListParagraph, etc.)
                if (el.className) {
                    const validClasses = el.className.split(/\s+/)
                        .filter(c => !c.toLowerCase().startsWith('mso') && !c.toLowerCase().startsWith('wordsection'));
                    if (validClasses.length > 0) {
                        el.className = validClasses.join(' ');
                    } else {
                        el.removeAttribute('class');
                    }
                }

                // Clean inline styles
                if (el.hasAttribute('style')) {
                    el.style.backgroundColor = '';
                    el.style.background = '';
                    el.style.fontFamily = '';

                    let rawStyle = el.getAttribute('style') || '';
                    rawStyle = rawStyle
                        .replace(/mso-[^;]+;?/gi, '')
                        .replace(/background(-color)?\s*:\s*[^;]+;?/gi, '')
                        .replace(/font-family\s*:\s*[^;]+;?/gi, '')
                        .replace(/line-height\s*:\s*normal;?/gi, '')
                        .replace(/color\s*:\s*(windowtext|#000000);?/gi, '')
                        .trim();

                    if (rawStyle && rawStyle.replace(/[;\s]/g, '').length > 0) {
                        el.setAttribute('style', rawStyle);
                    } else {
                        el.removeAttribute('style');
                    }
                }
            });

            // Unwrap redundant spans
            const spans = body.querySelectorAll('span');
            spans.forEach(span => {
                if (!span.getAttribute('style') && !span.getAttribute('class')) {
                    while (span.firstChild) {
                        span.parentNode.insertBefore(span.firstChild, span);
                    }
                    span.remove();
                }
            });

            return body.innerHTML.trim();
        }

        function initCleanPasteEngine() {
            const canvas = document.getElementById('liveCanvas');
            if (!canvas) return;

            canvas.addEventListener('paste', function(e) {
                const html = e.clipboardData ? e.clipboardData.getData('text/html') : null;
                const text = e.clipboardData ? e.clipboardData.getData('text/plain') : null;

                // Detect if paste comes from MS Word, rich webpage, or has inline background/font overrides
                if (html && (html.includes('mso-') || html.includes('MsoNormal') || html.includes('background') || html.includes('font-family'))) {
                    e.preventDefault();
                    const cleanHtml = cleanWordPasteHtml(html);
                    if (cleanHtml) {
                        document.execCommand('insertHTML', false, cleanHtml);
                        showToast('Pasted cleanly: Removed Word white backgrounds & font overrides!');
                    } else if (text) {
                        document.execCommand('insertText', false, text);
                        showToast('Pasted as plain text!');
                    }
                }
            });
        }

        // TOOLBAR "CLEAN STYLE" ACTION: Cleans selected text or active box
        function cleanActiveFormatting() {
            const canvas = document.getElementById('liveCanvas');
            const sel = window.getSelection();

            if (sel && sel.rangeCount > 0 && sel.toString().trim().length > 0) {
                // User has text highlighted
                const range = sel.getRangeAt(0);
                const fragment = range.cloneContents();
                const temp = document.createElement('div');
                temp.appendChild(fragment);

                temp.querySelectorAll('*').forEach(el => {
                    el.style.backgroundColor = '';
                    el.style.background = '';
                    el.style.fontFamily = '';
                    if (el.hasAttribute('style')) {
                        let s = el.getAttribute('style')
                            .replace(/background(-color)?\s*:\s*[^;]+;?/gi, '')
                            .replace(/font-family\s*:\s*[^;]+;?/gi, '')
                            .replace(/mso-[^;]+;?/gi, '')
                            .trim();
                        if (s) el.setAttribute('style', s);
                        else el.removeAttribute('style');
                    }
                });

                temp.querySelectorAll('span:not([style]):not([class])').forEach(span => {
                    while (span.firstChild) span.parentNode.insertBefore(span.firstChild, span);
                    span.remove();
                });

                range.deleteContents();
                const nodeToInsert = temp.firstChild || document.createTextNode(sel.toString());
                range.insertNode(nodeToInsert);
                showToast('Cleaned selected text formatting & removed white background!');
            } else {
                // Clean current active or clicked container
                let target = sel ? sel.anchorNode : null;
                if (target && target.nodeType === 3) target = target.parentElement;
                if (!target || target === canvas) {
                    target = currentHoveredSection || canvas;
                }

                if (target) {
                    target.querySelectorAll('*').forEach(el => {
                        if (!el.classList.contains('acts-card') && !el.classList.contains('about-vision-card')) {
                            el.style.backgroundColor = '';
                            el.style.background = '';
                            el.style.fontFamily = '';
                            if (el.hasAttribute('style')) {
                                let s = el.getAttribute('style')
                                    .replace(/background(-color)?\s*:\s*[^;]+;?/gi, '')
                                    .replace(/font-family\s*:\s*[^;]+;?/gi, '')
                                    .replace(/mso-[^;]+;?/gi, '')
                                    .trim();
                                if (s) el.setAttribute('style', s);
                                else el.removeAttribute('style');
                            }
                        }
                    });
                    showToast('Cleaned container formatting: white backgrounds removed!');
                }
            }
        }

        // ============================================================
        // HTML5 DRAG AND DROP ENGINE FOR CANVAS
        // ============================================================
        function handleWidgetDragStart(e, widgetType) {
            draggedWidgetType = widgetType;
            e.dataTransfer.setData('text/plain', widgetType);
            e.dataTransfer.effectAllowed = 'copy';
            e.currentTarget.classList.add('is-dragging');
        }

        function handleWidgetDragEnd(e) {
            e.currentTarget.classList.remove('is-dragging');
            draggedWidgetType = null;
            hideDropIndicator();
        }

        function handleCanvasDragEnter(e) {
            e.preventDefault();
            document.getElementById('liveCanvas').classList.add('is-dragover');
        }

        let dropTargetContainer = null;

        function handleCanvasDragOver(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'copy';

            const canvas = document.getElementById('liveCanvas');
            const indicator = document.getElementById('dropIndicatorLine');

            // Temporarily hide indicator to get real element underneath cursor
            indicator.style.display = 'none';
            const hoveredEl = document.elementFromPoint(e.clientX, e.clientY);

            if (!hoveredEl || !canvas.contains(hoveredEl)) {
                return;
            }

            // Check if dragging inside an inner container or column:
            // e.g. .about-vision-col, .pro-col-box, grid columns, card bodies, or any section column
            const innerCol = hoveredEl.closest('.about-vision-col, .about-main-col, .pro-col-box, .pro-container-1col, .pro-container-2col, .pro-container-3col, .pro-container-4col, .pro-container-sidebar, .card-body, [class*="col-"], .dbim-iwt-text-col, .accordion-body, .acts-content-side');

            if (innerCol && canvas.contains(innerCol) && innerCol !== canvas) {
                dropTargetContainer = innerCol;
                const children = Array.from(innerCol.children).filter(el => el !== indicator && el.id !== 'emptyCanvasNotice');

                if (children.length === 0) {
                    indicator.style.display = 'block';
                    innerCol.appendChild(indicator);
                    dropTargetBlock = null;
                    dropPosition = 'append';
                    return;
                }

                let closestChild = null;
                let minDist = Number.POSITIVE_INFINITY;
                let isAfter = true;

                children.forEach(child => {
                    const rect = child.getBoundingClientRect();
                    const midY = rect.top + rect.height / 2;
                    const dist = Math.abs(e.clientY - midY);
                    if (dist < minDist) {
                        minDist = dist;
                        closestChild = child;
                        isAfter = e.clientY > midY;
                    }
                });

                if (closestChild) {
                    dropTargetBlock = closestChild;
                    dropPosition = isAfter ? 'after' : 'before';

                    indicator.style.display = 'block';
                    if (isAfter) {
                        closestChild.after(indicator);
                    } else {
                        closestChild.before(indicator);
                    }
                }
                return;
            }

            // Top-level children of canvas
            dropTargetContainer = canvas;
            const blocks = Array.from(canvas.children).filter(el => el !== indicator && el.id !== 'emptyCanvasNotice');

            if (blocks.length === 0) {
                indicator.style.display = 'block';
                canvas.appendChild(indicator);
                dropTargetBlock = null;
                dropPosition = 'append';
                return;
            }

            let closestBlock = null;
            let closestDistance = Number.POSITIVE_INFINITY;
            let isAfter = true;

            blocks.forEach(block => {
                const rect = block.getBoundingClientRect();
                const midY = rect.top + rect.height / 2;
                const distance = Math.abs(e.clientY - midY);

                if (distance < closestDistance) {
                    closestDistance = distance;
                    closestBlock = block;
                    isAfter = e.clientY > midY;
                }
            });

            if (closestBlock) {
                dropTargetBlock = closestBlock;
                dropPosition = isAfter ? 'after' : 'before';

                indicator.style.display = 'block';
                if (isAfter) {
                    closestBlock.after(indicator);
                } else {
                    closestBlock.before(indicator);
                }
            }
        }

        function handleCanvasDragLeave(e) {
            const canvas = document.getElementById('liveCanvas');
            if (!canvas.contains(e.relatedTarget)) {
                canvas.classList.remove('is-dragover');
                hideDropIndicator();
            }
        }

        function hideDropIndicator() {
            const indicator = document.getElementById('dropIndicatorLine');
            if (indicator) {
                indicator.style.display = 'none';
            }
            document.getElementById('liveCanvas').classList.remove('is-dragover');
        }

        function handleCanvasDrop(e) {
            e.preventDefault();
            const canvas = document.getElementById('liveCanvas');
            canvas.classList.remove('is-dragover');

            const widgetType = e.dataTransfer.getData('text/plain') || draggedWidgetType;
            hideDropIndicator();

            if (!widgetType) return;

            // Remove placeholder notice if present
            const notice = document.getElementById('emptyCanvasNotice');
            if (notice) notice.remove();

            const html = getWidgetHtml(widgetType);
            if (!html) return;

            // Create temporary container to parse HTML
            const temp = document.createElement('div');
            temp.innerHTML = html.trim();
            const newElement = temp.firstElementChild || temp;

            // If user dropped inside .about-vision-col (below grey box) and it is acts_card, automatically style compact
            if (widgetType === 'acts_card' && dropTargetContainer && (dropTargetContainer.classList.contains('about-vision-col') || dropTargetContainer.classList.contains('pro-col-box'))) {
                newElement.classList.add('compact-size');
                newElement.style.width = '100%';
            }

            if (dropTargetBlock && dropTargetBlock.parentNode) {
                if (dropPosition === 'after') {
                    dropTargetBlock.after(newElement);
                } else {
                    dropTargetBlock.before(newElement);
                }
            } else if (dropTargetContainer && canvas.contains(dropTargetContainer)) {
                dropTargetContainer.appendChild(newElement);
            } else {
                canvas.appendChild(newElement);
            }

            // Scroll new element into view & focus
            newElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            canvas.focus();
            showToast('Element placed on canvas!');
            setTimeout(initAllDbimTables, 150);
        }

        // ============================================================
        // CLICK TO INSERT WIDGET (FALLBACK & SHORTCUT)
        // ============================================================
        function insertWidget(type) {
            const canvas = document.getElementById('liveCanvas');

            const notice = document.getElementById('emptyCanvasNotice');
            if (notice) notice.remove();

            const html = getWidgetHtml(type);
            if (!html) return;

            canvas.focus();
            const selection = window.getSelection();

            // Try inserting at cursor position via execCommand
            if (selection && selection.rangeCount > 0 && canvas.contains(selection.anchorNode)) {
                document.execCommand('insertHTML', false, html);
            } else {
                // Otherwise append directly to the end of canvas
                const temp = document.createElement('div');
                temp.innerHTML = html.trim();
                const newEl = temp.firstElementChild || temp;
                canvas.appendChild(newEl);
                newEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            showToast('Component added to page!');
            setTimeout(initAllDbimTables, 150);
        }

        // ============================================================
        // DBIM BOOK, PUBLICATION & MAGAZINE CARD GENERATOR
        // ============================================================
        function renderBookCardItemHtml(opts) {
            opts = Object.assign({
                title: 'Understanding WTO',
                coverImg: '/assets/images/book_understanding_wto.png',
                linkUrl: '#'
            }, opts || {});

            return `
            <div class="col-lg-3 col-md-6 dbim-book-col">
                <div class="dbim-book-card h-100 position-relative d-flex flex-column" style="background: #fdf5f8; border: 1px solid #ebd0de; border-radius: 6px; padding: 12px; transition: all 0.25s ease;">
                    <!-- Card Admin Controls -->
                    <div class="editor-book-btn-bar position-absolute top-0 end-0 m-2 d-flex gap-1" style="z-index: 10;">
                        <button type="button" class="btn btn-sm btn-light border shadow-sm editor-book-btn p-1 px-2" onclick="moveBookCard(this, -1)" title="Move Left"><i class="fa-solid fa-arrow-left"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm editor-book-btn p-1 px-2" onclick="moveBookCard(this, 1)" title="Move Right"><i class="fa-solid fa-arrow-right"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm text-primary editor-book-btn p-1 px-2" onclick="duplicateBookCard(this)" title="Duplicate Card"><i class="fa-solid fa-clone"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm text-danger editor-book-btn p-1 px-2" onclick="deleteBookCard(this)" title="Delete Card"><i class="fa-solid fa-trash"></i></button>
                    </div>

                    <!-- Book Cover Visual Wrap -->
                    <div class="dbim-book-cover-wrap position-relative text-center p-2" style="background: #ffffff; border: 1px solid #f0dfe9; border-radius: 4px; overflow: hidden;">
                        <img src="${opts.coverImg}" alt="${opts.title}" class="dbim-book-cover-img img-fluid w-100" style="aspect-ratio: 1 / 1.35; object-fit: contain; display: block; background: #ffffff;" onclick="openAvatarModal(this)" title="Click to upload/change book cover image">
                        
                        <!-- Quick Admin Change Cover Button -->
                        <button type="button" class="btn btn-sm btn-dark position-absolute bottom-0 start-50 translate-middle-x mb-2 editor-book-btn opacity-90 shadow-sm" style="font-size: 1.15rem; white-space: nowrap; z-index: 6;" onclick="openAvatarModal(this)" title="Upload cover image"><i class="fa-solid fa-camera me-1"></i> Upload Cover</button>
                    </div>

                    <!-- Book Title Only (Centered beneath image, exactly as in user reference) -->
                    <div class="dbim-book-title-wrap text-center pt-3 pb-1 flex-grow-1 d-flex align-items-center justify-content-center">
                        <h3 class="dbim-book-title fw-bold m-0" contenteditable="true" style="font-family: 'Merriweather', serif; color: #1e1b24; font-size: 1.55rem; line-height: 1.4; text-align: center;">${opts.title}</h3>
                    </div>
                </div>
            </div>`;
        }

        // ============================================================
        // DBIM PHOTO GALLERY CARD GENERATOR
        // ============================================================
        function renderPhotoCardItemHtml(opts) {
            opts = Object.assign({
                title: 'NIFT CONVOCATION 2026',
                date: '31.08.2026',
                itemsCount: '14',
                category: 'Convocations',
                slug: 'nift-convocation-2026',
                imgUrl: '/assets/images/gallery_nift_convocation.png'
            }, opts || {});

            if (!opts.slug) {
                opts.slug = (opts.title || 'album').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            }

            return `
            <div class="col-lg-4 col-md-6 dbim-photo-col" data-album-slug="${opts.slug}" data-date="${opts.date}" data-title="${(opts.title || '').toLowerCase()}" data-category="${opts.category}">
                <div class="dbim-photo-card h-100 position-relative d-flex flex-column" onclick="openPhotoAlbum('${opts.slug}', this)" style="background: transparent; transition: all 0.25s ease; cursor: pointer;">
                    <!-- Card Admin Controls -->
                    <div class="editor-photo-btn-bar position-absolute top-0 end-0 m-2 d-flex gap-1" style="z-index: 10;">
                        <button type="button" class="btn btn-sm btn-light border shadow-sm editor-photo-btn p-1 px-2" onclick="event.stopPropagation(); movePhotoCard(this, -1)" title="Move Left"><i class="fa-solid fa-arrow-left"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm editor-photo-btn p-1 px-2" onclick="event.stopPropagation(); movePhotoCard(this, 1)" title="Move Right"><i class="fa-solid fa-arrow-right"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm text-primary editor-photo-btn p-1 px-2" onclick="event.stopPropagation(); duplicatePhotoCard(this)" title="Duplicate Card"><i class="fa-solid fa-clone"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm text-danger editor-photo-btn p-1 px-2" onclick="event.stopPropagation(); deletePhotoCard(this)" title="Delete Card"><i class="fa-solid fa-trash"></i></button>
                    </div>

                    <!-- Image Container -->
                    <div class="dbim-photo-img-wrap position-relative overflow-hidden" style="border-radius: 8px; background: #f0e6ec; aspect-ratio: 16 / 10;">
                        <img src="${opts.imgUrl}" alt="${opts.title}" class="dbim-photo-img w-100 h-100" style="object-fit: cover; display: block; transition: transform 0.3s ease;">
                        
                        <!-- Bottom-right action icon button -->
                        <button type="button" class="dbim-photo-action-btn position-absolute bottom-0 end-0 m-2 border-0 text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: rgba(30, 27, 36, 0.78); border-radius: 4px; z-index: 5;" title="View Album">
                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                        </button>

                        <!-- Admin Image Upload Button -->
                        <button type="button" class="btn btn-sm btn-dark position-absolute top-0 start-0 m-2 editor-photo-btn opacity-90 shadow-sm" style="font-size: 1.15rem; z-index: 6; white-space: nowrap;" onclick="event.stopPropagation(); openAvatarModal(this)" title="Change Album Cover"><i class="fa-solid fa-camera me-1"></i> Change Cover</button>
                    </div>

                    <!-- Card Details -->
                    <div class="dbim-photo-details pt-2 pb-1 d-flex flex-column flex-grow-1">
                        <h3 class="dbim-photo-title fw-bold m-0" contenteditable="true" style="font-family: 'Noto Sans', sans-serif; color: #1e1b24; font-size: 1.55rem; line-height: 1.35; margin-top: 10px; margin-bottom: 6px !important;">${opts.title}</h3>
                        <div class="d-flex align-items-center justify-content-between mt-auto pt-1" style="color: #6c757d; font-size: 1.25rem;">
                            <span class="dbim-photo-date" contenteditable="true"><i class="fa-regular fa-calendar me-1" style="font-size: 1.15rem;"></i>${opts.date}</span>
                            <span class="dbim-photo-items text-uppercase fw-semibold" contenteditable="true">${opts.itemsCount} ITEMS</span>
                        </div>
                    </div>
                </div>
            </div>`;
        }

        function renderAlbumPhotoItemHtml(opts) {
            opts = Object.assign({
                imgUrl: '/assets/images/nift_img_1.jpg',
                title: 'Album Photo'
            }, opts || {});

            return `
            <div class="col-lg-4 col-md-6 dbim-album-photo-col">
                <div class="dbim-album-photo-card position-relative overflow-hidden shadow-sm" style="border-radius: 6px; aspect-ratio: 16 / 10; background: #f0e6ec; cursor: pointer;" onclick="openPhotoPreview(this)">
                    <!-- Photo Admin Controls -->
                    <div class="editor-album-photo-btn-bar position-absolute top-0 end-0 m-2 d-flex gap-1" style="z-index: 10;">
                        <button type="button" class="btn btn-sm btn-light border shadow-sm editor-album-photo-btn p-1 px-2" onclick="event.stopPropagation(); moveAlbumPhoto(this, -1)" title="Move Left"><i class="fa-solid fa-arrow-left"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm editor-album-photo-btn p-1 px-2" onclick="event.stopPropagation(); moveAlbumPhoto(this, 1)" title="Move Right"><i class="fa-solid fa-arrow-right"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm text-primary editor-album-photo-btn p-1 px-2" onclick="event.stopPropagation(); duplicateAlbumPhoto(this)" title="Duplicate Photo"><i class="fa-solid fa-clone"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm text-danger editor-album-photo-btn p-1 px-2" onclick="event.stopPropagation(); deleteAlbumPhoto(this)" title="Delete Photo"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <button type="button" class="btn btn-sm btn-dark position-absolute top-0 start-0 m-2 editor-album-photo-btn opacity-90 shadow-sm" style="font-size: 1.15rem; z-index: 6; white-space: nowrap;" onclick="event.stopPropagation(); openAvatarModal(this)" title="Change Photo"><i class="fa-solid fa-camera me-1"></i> Change</button>

                    <!-- Photo Image -->
                    <img src="${opts.imgUrl}" alt="${opts.title}" class="dbim-album-photo-img w-100 h-100" style="object-fit: cover; display: block; transition: transform 0.3s ease;">
                    
                    <!-- Bottom-right expand icon button matching Image 2 -->
                    <button type="button" class="dbim-album-photo-expand-btn position-absolute bottom-0 end-0 m-2 border-0 text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px; background: rgba(30, 27, 36, 0.82); border-radius: 4px; z-index: 5;" onclick="event.stopPropagation(); openPhotoPreview(this);" title="Expand Photo">
                        <i class="fa-solid fa-expand" style="font-size: 13px;"></i>
                    </button>
                </div>
            </div>`;
        }

        // ============================================================
        // DBIM VIDEO GALLERY CARD GENERATOR
        // ============================================================
        function renderVideoCardItemHtml(opts) {
            opts = Object.assign({
                title: '12 th National Handloom Day',
                date: '07.08.2026',
                duration: '2:14',
                category: 'Handloom',
                thumbnailUrl: '/assets/images/video_handloom_day.png',
                videoUrl: ''
            }, opts || {});

            return `
            <div class="col-lg-4 col-md-6 dbim-video-col" data-date="${opts.date}" data-title="${(opts.title || '').toLowerCase()}" data-category="${opts.category}">
                <div class="dbim-video-card h-100 position-relative d-flex flex-column" style="background: transparent; transition: all 0.25s ease;">
                    <!-- Card Admin Controls -->
                    <div class="editor-video-btn-bar position-absolute top-0 end-0 m-2 d-flex gap-1" style="z-index: 10;">
                        <button type="button" class="btn btn-sm btn-light border shadow-sm editor-video-btn p-1 px-2" onclick="moveVideoCard(this, -1)" title="Move Left"><i class="fa-solid fa-arrow-left"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm editor-video-btn p-1 px-2" onclick="moveVideoCard(this, 1)" title="Move Right"><i class="fa-solid fa-arrow-right"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm text-primary editor-video-btn p-1 px-2" onclick="duplicateVideoCard(this)" title="Duplicate Card"><i class="fa-solid fa-clone"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm text-danger editor-video-btn p-1 px-2" onclick="deleteVideoCard(this)" title="Delete Card"><i class="fa-solid fa-trash"></i></button>
                    </div>

                    <!-- Video Frame -->
                    <div class="dbim-video-player-wrap position-relative overflow-hidden shadow-sm" style="border-radius: 8px; background: #000000; aspect-ratio: 16 / 10;">
                        <img src="${opts.thumbnailUrl}" alt="${opts.title}" class="dbim-video-thumbnail w-100 h-100" style="object-fit: cover; display: block; opacity: 0.95; cursor: pointer;" onclick="playGalleryVideo(this)" data-video-url="${opts.videoUrl || ''}">
                        
                        <!-- Video Controls Overlay Matching Image 2 -->
                        <div class="dbim-video-overlay-ctrl position-absolute bottom-0 start-0 end-0 p-2 d-flex align-items-center justify-content-between text-white" style="background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%); font-size: 1.15rem;">
                            <div class="d-flex align-items-center gap-2" style="cursor: pointer;" onclick="playGalleryVideo(this)">
                                <i class="fa-solid fa-play" style="font-size: 13px;"></i>
                                <span>0:00 / ${opts.duration}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-volume-high" style="font-size: 13px;"></i>
                                <i class="fa-solid fa-expand" style="font-size: 13px; cursor: pointer;" onclick="playGalleryVideo(this)"></i>
                            </div>
                        </div>

                        <!-- Top-right share icon as in Image 2 -->
                        <div class="position-absolute top-0 end-0 m-2 text-white" style="z-index: 4; text-shadow: 0 1px 3px rgba(0,0,0,0.8);">
                            <i class="fa-solid fa-share-nodes" style="font-size: 15px; cursor: pointer;" title="Share Video"></i>
                        </div>

                        <!-- Top-left Admin Video & Cover Source Buttons -->
                        <div class="editor-video-source-bar position-absolute top-0 start-0 m-2 d-flex gap-1" style="z-index: 12;">
                            <button type="button" class="btn btn-sm btn-danger editor-video-btn px-2 py-1 shadow-sm fw-bold" onclick="event.stopPropagation(); openVideoSettingsModal(this)" title="Configure Video URL / MP4 File"><i class="fa-solid fa-video me-1"></i> Video</button>
                            <button type="button" class="btn btn-sm btn-dark editor-video-btn px-2 py-1 shadow-sm fw-bold" onclick="event.stopPropagation(); openAvatarModal(this)" title="Change Cover Photo"><i class="fa-solid fa-camera me-1"></i> Cover</button>
                        </div>
                    </div>

                    <!-- Video Details -->
                    <div class="dbim-video-details pt-2 pb-1 d-flex flex-column flex-grow-1">
                        <h3 class="dbim-video-title fw-bold m-0" contenteditable="true" style="font-family: 'Noto Sans', sans-serif; color: #1e1b24; font-size: 1.55rem; line-height: 1.35; margin-top: 10px; margin-bottom: 6px !important;">${opts.title}</h3>
                        <div class="d-flex align-items-center justify-content-between mt-auto pt-1" style="color: #6c757d; font-size: 1.25rem;">
                            <span class="dbim-video-date" contenteditable="true"><i class="fa-regular fa-calendar me-1" style="font-size: 1.15rem;"></i>${opts.date}</span>
                            <span class="dbim-video-duration fw-semibold" contenteditable="true">${opts.duration}</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger w-100 mt-2 editor-video-btn fw-bold" onclick="event.stopPropagation(); openVideoSettingsModal(this)" style="font-size: 1.15rem;"><i class="fa-solid fa-film me-1"></i> Configure Video (YouTube / MP4)</button>
                    </div>
                </div>
            </div>`;
        }

        // ============================================================
        // DBIM PRESENTATION / EVENTS CARD GENERATOR
        // ============================================================
        function renderPresentationCardItemHtml(opts) {
            opts = Object.assign({
                title: 'Inagural Session',
                date: '12.08.2026',
                category: 'Plenary',
                btnText: 'VIEW',
                imgUrl: '/assets/images/pres_inaugural_session.png',
                pdfUrl: '#'
            }, opts || {});

            return `
            <div class="col-lg-4 col-md-6 dbim-pres-col" data-date="${opts.date}" data-title="${(opts.title || '').toLowerCase()}" data-category="${opts.category}">
                <div class="dbim-pres-card h-100 position-relative d-flex flex-column bg-white" style="border: 1px solid #ebd0de; border-radius: 12px; overflow: hidden; box-shadow: 0 3px 12px rgba(114, 24, 53, 0.04); transition: all 0.25s ease;">
                    <!-- Card Admin Controls -->
                    <div class="editor-pres-btn-bar position-absolute top-0 end-0 m-2 d-flex gap-1" style="z-index: 10;">
                        <button type="button" class="btn btn-sm btn-light border shadow-sm editor-pres-btn p-1 px-2" onclick="movePresCard(this, -1)" title="Move Left"><i class="fa-solid fa-arrow-left"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm editor-pres-btn p-1 px-2" onclick="movePresCard(this, 1)" title="Move Right"><i class="fa-solid fa-arrow-right"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm text-primary editor-pres-btn p-1 px-2" onclick="duplicatePresCard(this)" title="Duplicate Card"><i class="fa-solid fa-clone"></i></button>
                        <button type="button" class="btn btn-sm btn-light border shadow-sm text-danger editor-pres-btn p-1 px-2" onclick="deletePresCard(this)" title="Delete Card"><i class="fa-solid fa-trash"></i></button>
                    </div>

                    <!-- Slide / Event Banner -->
                    <div class="dbim-pres-img-wrap position-relative overflow-hidden" style="background: #fdf5f8; aspect-ratio: 16 / 10; border-bottom: 1px solid #f0dfe9;">
                        <img src="${opts.imgUrl}" alt="${opts.title}" class="dbim-pres-img w-100 h-100" style="object-fit: cover; display: block; cursor: pointer;" onclick="openPresentationModal(this)" data-pdf-url="${opts.pdfUrl || '#'}" title="Click to view presentation">
                        
                        <!-- Admin Change Slide Button -->
                        <button type="button" class="btn btn-sm btn-dark position-absolute bottom-0 start-50 translate-middle-x mb-2 editor-pres-btn opacity-90 shadow-sm" style="font-size: 1.15rem; z-index: 6; white-space: nowrap;" onclick="openAvatarModal(this)" title="Change Slide Image"><i class="fa-solid fa-camera me-1"></i> Change Slide</button>
                    </div>

                    <!-- Card Body -->
                    <div class="dbim-pres-body p-3 d-flex flex-column flex-grow-1">
                        <h3 class="dbim-pres-title fw-bold m-0" contenteditable="true" style="font-family: 'Noto Sans', sans-serif; color: #1e1b24; font-size: 1.6rem; line-height: 1.35; margin-bottom: 14px !important;">${opts.title}</h3>
                        
                        <div class="d-flex align-items-center justify-content-between mt-auto pt-2">
                            <span class="dbim-pres-date text-muted" contenteditable="true" style="font-size: 1.25rem;"><i class="fa-regular fa-calendar me-1"></i>${opts.date}</span>
                            
                            <a href="${opts.pdfUrl || '#'}" class="btn btn-sm dbim-pres-view-btn d-inline-flex align-items-center gap-1 fw-bold" onclick="openPresentationModal(this); return false;" style="background: #fdf2f7; color: #721835; border: 1px solid #ebd0de; border-radius: 4px; padding: 4px 14px; font-size: 1.15rem; text-decoration: none;">
                                <i class="fa-regular fa-eye" style="font-size: 13px;"></i>
                                <span contenteditable="true">${opts.btnText || 'VIEW'}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>`;
        }

        // ============================================================
        // ELEMENTOR PRO & GOVERNMENT WIDGET HTML TEMPLATES
        // ============================================================
        function getWidgetHtml(type) {
            const uid = 'el_' + Date.now() + '_' + Math.floor(Math.random() * 1000);

            switch(type) {
                // ==========================================
                // DBIM THEME COMPONENTS (texmin.gov.in)
                // ==========================================
                case 'dbim_objectives_3col':
                    return `<div class="dbim-objectives-section my-4" data-component="dbim_objectives_3col">
                        <h2 class="dbim-section-title" contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.4rem; margin-bottom: 8px;">Objectives</h2>
                        <p class="dbim-section-sub" contenteditable="true" style="color: #150202; font-size: 1.55rem; margin-bottom: 22px;">The three key outcomes to be achieved through this vision are:</p>
                        <div class="row g-4">
                            <div class="col-lg-4 col-md-6">
                                <div class="objectivebox" style="background: #ebd0de; border-radius: 12px; padding: 22px 20px; height: 100%; border: 1px solid rgba(80, 10, 47, 0.12);">
                                    <h3 contenteditable="true" style="color: #500a2f; font-size: 3.4rem; font-weight: 700; margin-bottom: 12px; line-height: 1;">1</h3>
                                    <p contenteditable="true" style="color: #2b1320; font-size: 1.55rem; line-height: 1.65; margin-bottom: 0;">Ensure rigorous quality inspection, testing standards, and compliance for domestic and export textiles.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="objectivebox" style="background: #ebd0de; border-radius: 12px; padding: 22px 20px; height: 100%; border: 1px solid rgba(80, 10, 47, 0.12);">
                                    <h3 contenteditable="true" style="color: #500a2f; font-size: 3.4rem; font-weight: 700; margin-bottom: 12px; line-height: 1;">2</h3>
                                    <p contenteditable="true" style="color: #2b1320; font-size: 1.55rem; line-height: 1.65; margin-bottom: 0;">Create market confidence through certified origin (Non-Preferential COO), Handloom Mark, and GI initiatives.</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="objectivebox" style="background: #ebd0de; border-radius: 12px; padding: 22px 20px; height: 100%; border: 1px solid rgba(80, 10, 47, 0.12);">
                                    <h3 contenteditable="true" style="color: #500a2f; font-size: 3.4rem; font-weight: 700; margin-bottom: 12px; line-height: 1;">3</h3>
                                    <p contenteditable="true" style="color: #2b1320; font-size: 1.55rem; line-height: 1.65; margin-bottom: 0;">Empower workforce and industry through Samarth skill training, technical consultancy, and market research.</p>
                                </div>
                            </div>
                        </div>
                    </div>`;

                case 'dbim_section_doc_box':
                    return `<div class="dbim-doc-section my-4" data-component="dbim_section_doc_box">
                        <h2 class="dbim-section-title" contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.4rem; margin-bottom: 8px;">Citizen’s Charter</h2>
                        <p class="dbim-section-desc" contenteditable="true" style="color: #150202; font-size: 1.55rem; line-height: 1.7; margin-bottom: 18px;">The Citizen’s Charter of the Textiles Committee outlines our commitment to transparency, timely testing services, grievance redressal, and service standards for all stakeholders.</p>
                        <div class="box row row-gap-2 align-items-center ms-0 me-0" data-doc-box="true" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 8px; padding: 14px 20px; margin-bottom: 14px;">
                            <div class="col-lg-8 col-md-12 col-sm-12">
                                <p class="mb-0 d-flex align-items-center gap-2" style="font-weight: 600; font-size: 1.6rem; color: #150202;">
                                    <span class="material-symbols-outlined" style="color: #500a2f; font-size: 2.2rem;">draft</span>
                                    <span class="doc-title-text" contenteditable="true">Citizen’s Charter - Textiles Committee</span>
                                </p>
                            </div>
                            <div class="col-lg-2 col-md-12 col-sm-12">
                                <div class="d-flex gap-4 align-items-center type-size">
                                    <small class="text-uppercase mb-0 doc-size-badge" contenteditable="true" style="color: #666; font-size: 1.3rem; font-weight: 600; background: #f7eef3; padding: 4px 10px; border-radius: 4px; border: 1px solid #e8d0dd;">1.45 MB</small>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-12 col-sm-12">
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <a class="download-btn d-flex align-items-center text-uppercase w-ft" target="_blank" rel="noopener noreferrer" title="View PDF" href="/uploads/documents/sample.pdf" style="background: #faebf2; color: #500a2f; border: 1px solid #ebd0de; border-radius: 6px; padding: 8px 18px; font-size: 1.35rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                        <span class="material-symbols-outlined" style="font-size: 1.8rem;">visibility</span>
                                        VIEW
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger editor-doc-btn" onclick="openDocMediaModal(this)" title="Upload or link PDF/Media for this VIEW button">
                                        <i class="fa-solid fa-file-arrow-up"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>`;

                case 'dbim_doc_list_section':
                    return `<div class="dbim-doc-list-section my-4" data-component="dbim_doc_list_section">
                        <h2 class="dbim-section-title" contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.4rem; margin-bottom: 16px;">List of Secretary's of the Textiles Committee</h2>
                        <div class="dbim-doc-items-stack">
                            <div class="box row row-gap-2 align-items-center ms-0 me-0" data-doc-box="true" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 8px; padding: 14px 20px; margin-bottom: 14px;">
                                <div class="col-lg-8 col-md-12 col-sm-12">
                                    <p class="mb-0 d-flex align-items-center gap-2" style="font-weight: 600; font-size: 1.6rem; color: #150202;">
                                        <span class="material-symbols-outlined" style="color: #500a2f; font-size: 2.2rem;">draft</span>
                                        <span class="doc-title-text" contenteditable="true">Textiles Committee Act, 1963 (Act No. 41 of 1963)</span>
                                    </p>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    <div class="d-flex gap-4 align-items-center type-size">
                                        <small class="text-uppercase mb-0 doc-size-badge" contenteditable="true" style="color: #666; font-size: 1.3rem; font-weight: 600; background: #f7eef3; padding: 4px 10px; border-radius: 4px; border: 1px solid #e8d0dd;">2.10 MB</small>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <a class="download-btn d-flex align-items-center text-uppercase w-ft" target="_blank" rel="noopener noreferrer" title="View PDF" href="/uploads/documents/sample.pdf" style="background: #faebf2; color: #500a2f; border: 1px solid #ebd0de; border-radius: 6px; padding: 8px 18px; font-size: 1.35rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                            <span class="material-symbols-outlined" style="font-size: 1.8rem;">visibility</span>
                                            VIEW
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger editor-doc-btn" onclick="openDocMediaModal(this)" title="Upload or link PDF/Media for this VIEW button">
                                            <i class="fa-solid fa-file-arrow-up"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="box row row-gap-2 align-items-center ms-0 me-0" data-doc-box="true" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 8px; padding: 14px 20px; margin-bottom: 14px;">
                                <div class="col-lg-8 col-md-12 col-sm-12">
                                    <p class="mb-0 d-flex align-items-center gap-2" style="font-weight: 600; font-size: 1.6rem; color: #150202;">
                                        <span class="material-symbols-outlined" style="color: #500a2f; font-size: 2.2rem;">draft</span>
                                        <span class="doc-title-text" contenteditable="true">List of Secretaries of the Textiles Committee</span>
                                    </p>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    <div class="d-flex gap-4 align-items-center type-size">
                                        <small class="text-uppercase mb-0 doc-size-badge" contenteditable="true" style="color: #666; font-size: 1.3rem; font-weight: 600; background: #f7eef3; padding: 4px 10px; border-radius: 4px; border: 1px solid #e8d0dd;">320 KB</small>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <a class="download-btn d-flex align-items-center text-uppercase w-ft" target="_blank" rel="noopener noreferrer" title="View PDF" href="/uploads/documents/sample.pdf" style="background: #faebf2; color: #500a2f; border: 1px solid #ebd0de; border-radius: 6px; padding: 8px 18px; font-size: 1.35rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                            <span class="material-symbols-outlined" style="font-size: 1.8rem;">visibility</span>
                                            VIEW
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger editor-doc-btn" onclick="openDocMediaModal(this)" title="Upload or link PDF/Media for this VIEW button">
                                            <i class="fa-solid fa-file-arrow-up"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="box row row-gap-2 align-items-center ms-0 me-0" data-doc-box="true" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 8px; padding: 14px 20px; margin-bottom: 14px;">
                                <div class="col-lg-8 col-md-12 col-sm-12">
                                    <p class="mb-0 d-flex align-items-center gap-2" style="font-weight: 600; font-size: 1.6rem; color: #150202;">
                                        <span class="material-symbols-outlined" style="color: #500a2f; font-size: 2.2rem;">draft</span>
                                        <span class="doc-title-text" contenteditable="true">Annual Report & Audited Accounts</span>
                                    </p>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    <div class="d-flex gap-4 align-items-center type-size">
                                        <small class="text-uppercase mb-0 doc-size-badge" contenteditable="true" style="color: #666; font-size: 1.3rem; font-weight: 600; background: #f7eef3; padding: 4px 10px; border-radius: 4px; border: 1px solid #e8d0dd;">4.80 MB</small>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <a class="download-btn d-flex align-items-center text-uppercase w-ft" target="_blank" rel="noopener noreferrer" title="View PDF" href="/uploads/documents/sample.pdf" style="background: #faebf2; color: #500a2f; border: 1px solid #ebd0de; border-radius: 6px; padding: 8px 18px; font-size: 1.35rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                            <span class="material-symbols-outlined" style="font-size: 1.8rem;">visibility</span>
                                            VIEW
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger editor-doc-btn" onclick="openDocMediaModal(this)" title="Upload or link PDF/Media for this VIEW button">
                                            <i class="fa-solid fa-file-arrow-up"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-start mt-2">
                            <button type="button" class="btn btn-sm btn-outline-primary editor-doc-btn" onclick="addDocCardToStack(this)" title="Add another document item to this stack">
                                <i class="fa-solid fa-plus me-1"></i> Add Document Card
                            </button>
                        </div>
                    </div>`;

                case 'dbim_single_doc_card':
                    return `<div class="box row row-gap-2 align-items-center ms-0 me-0 my-3" data-component="dbim_single_doc_card" data-doc-box="true" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 8px; padding: 14px 20px; margin-bottom: 14px;">
                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <p class="mb-0 d-flex align-items-center gap-2" style="font-weight: 600; font-size: 1.6rem; color: #150202;">
                                <span class="material-symbols-outlined" style="color: #500a2f; font-size: 2.2rem;">draft</span>
                                <span class="doc-title-text" contenteditable="true">Official Notification / Document Title</span>
                            </p>
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <div class="d-flex gap-4 align-items-center type-size">
                                <small class="text-uppercase mb-0 doc-size-badge" contenteditable="true" style="color: #666; font-size: 1.3rem; font-weight: 600; background: #f7eef3; padding: 4px 10px; border-radius: 4px; border: 1px solid #e8d0dd;">1.20 MB</small>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12">
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                <a class="download-btn d-flex align-items-center text-uppercase w-ft" target="_blank" rel="noopener noreferrer" title="View PDF" href="/uploads/documents/sample.pdf" style="background: #faebf2; color: #500a2f; border: 1px solid #ebd0de; border-radius: 6px; padding: 8px 18px; font-size: 1.35rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                    <span class="material-symbols-outlined" style="font-size: 1.8rem;">visibility</span>
                                    VIEW
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger editor-doc-btn" onclick="openDocMediaModal(this)" title="Upload or link PDF/Media for this VIEW button">
                                    <i class="fa-solid fa-file-arrow-up"></i>
                                </button>
                            </div>
                        </div>
                    </div>`;

                case 'dbim_vision_box':
                    return `<div class="visionbox my-3" data-component="dbim_vision_box" style="background: #ebeaea; border-radius: 12px; padding: 32px 28px; border: 1px solid rgba(80, 10, 47, 0.08);">
                        <div>
                            <h2 contenteditable="true" style="color: #500a2f; font-size: 2.2rem; font-weight: 600; line-height: 1.55; margin-bottom: 24px; text-align: justify;">Unlock human capital to trigger a productivity dividend and bring aspirational employment and entrepreneurship pathways to all.</h2>
                            <p contenteditable="true" style="color: #500a2f; font-size: 1.35rem; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; margin: 0;">VISION STATEMENT</p>
                        </div>
                    </div>`;

                case 'dbim_full_layout':
                    return `<div class="row g-5 my-3" data-component="dbim_full_layout">
                        <div class="col-md-12 col-lg-4 stickyBox">
                            <div class="visionbox" style="background: #ebeaea; border-radius: 12px; padding: 32px 28px; border: 1px solid rgba(80, 10, 47, 0.08);">
                                <div>
                                    <h2 contenteditable="true" style="color: #500a2f; font-size: 2.2rem; font-weight: 600; line-height: 1.55; margin-bottom: 24px; text-align: justify;">To transform India into a premier global textile hub through world-class quality inspection, standardization, advanced laboratory testing, and skill empowerment across the entire textile value chain.</h2>
                                    <p contenteditable="true" style="color: #500a2f; font-size: 1.35rem; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; margin: 0;">VISION STATEMENT</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-8">
                            <div class="aboutcontent text-justify">
                                <div>
                                    <p contenteditable="true">The Textiles Committee is a statutory body established in 1963 by an Act of Parliament (Textiles Committee Act, 1963 - No. 41 of 1963) under the administrative control of the Ministry of Textiles, Government of India. The primary objective is to ensure the quality of textiles and textile machinery produced either for internal consumption or for export.</p>
                                    <h2 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.4rem; margin-top: 1.8rem; margin-bottom: 8px;">Objectives</h2>
                                    <p contenteditable="true">The three key outcomes to be achieved through this vision are:</p>
                                    <div class="row g-4">
                                        <div class="col-lg-4 col-md-6">
                                            <div class="objectivebox" style="background: #ebd0de; border-radius: 12px; padding: 22px 20px; height: 100%; border: 1px solid rgba(80, 10, 47, 0.12);">
                                                <h3 contenteditable="true" style="color: #500a2f; font-size: 3.4rem; font-weight: 700; margin-bottom: 12px; line-height: 1;">1</h3>
                                                <p contenteditable="true" style="color: #2b1320; font-size: 1.55rem; line-height: 1.65; margin-bottom: 0;">Ensure rigorous quality inspection, testing standards, and compliance for domestic and export textiles.</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="objectivebox" style="background: #ebd0de; border-radius: 12px; padding: 22px 20px; height: 100%; border: 1px solid rgba(80, 10, 47, 0.12);">
                                                <h3 contenteditable="true" style="color: #500a2f; font-size: 3.4rem; font-weight: 700; margin-bottom: 12px; line-height: 1;">2</h3>
                                                <p contenteditable="true" style="color: #2b1320; font-size: 1.55rem; line-height: 1.65; margin-bottom: 0;">Create market confidence through certified origin (Non-Preferential COO), Handloom Mark, and GI initiatives.</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="objectivebox" style="background: #ebd0de; border-radius: 12px; padding: 22px 20px; height: 100%; border: 1px solid rgba(80, 10, 47, 0.12);">
                                                <h3 contenteditable="true" style="color: #500a2f; font-size: 3.4rem; font-weight: 700; margin-bottom: 12px; line-height: 1;">3</h3>
                                                <p contenteditable="true" style="color: #2b1320; font-size: 1.55rem; line-height: 1.65; margin-bottom: 0;">Empower workforce and industry through Samarth skill training, technical consultancy, and market research.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h2 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.4rem; margin-top: 2rem; margin-bottom: 16px;">Citizen’s Charter</h2>
                                    <div class="box row row-gap-2 align-items-center ms-0 me-0" data-doc-box="true" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 8px; padding: 14px 20px; margin-bottom: 14px;">
                                        <div class="col-lg-8 col-md-12 col-sm-12">
                                            <p class="mb-0 d-flex align-items-center gap-2" style="font-weight: 600; font-size: 1.6rem; color: #150202;">
                                                <span class="material-symbols-outlined" style="color: #500a2f; font-size: 2.2rem;">draft</span>
                                                <span class="doc-title-text" contenteditable="true">Citizen’s Charter - Textiles Committee</span>
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-12 col-sm-12">
                                            <div class="d-flex gap-4 align-items-center type-size">
                                                <small class="text-uppercase mb-0 doc-size-badge" contenteditable="true" style="color: #666; font-size: 1.3rem; font-weight: 600; background: #f7eef3; padding: 4px 10px; border-radius: 4px; border: 1px solid #e8d0dd;">1.45 MB</small>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-12 col-sm-12">
                                            <div class="d-flex justify-content-end align-items-center gap-2">
                                                <a class="download-btn d-flex align-items-center text-uppercase w-ft" target="_blank" rel="noopener noreferrer" title="View PDF" href="/uploads/documents/sample.pdf" style="background: #faebf2; color: #500a2f; border: 1px solid #ebd0de; border-radius: 6px; padding: 8px 18px; font-size: 1.35rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                                    <span class="material-symbols-outlined" style="font-size: 1.8rem;">visibility</span>
                                                    VIEW
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger editor-doc-btn" onclick="openDocMediaModal(this)" title="Upload or link PDF/Media for this VIEW button">
                                                    <i class="fa-solid fa-file-arrow-up"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                case 'dbim_directory_table':
                    return `<div class="dbim-directory-section my-4" data-component="dbim_directory_table">
                        <!-- 1. HON'BLE MINISTER (TEXTILE) -->
                        <div class="dbim-dir-table-wrapper" style="border: 1px solid #ebd0de; border-radius: 8px; overflow: hidden; background: #ffffff; box-shadow: 0 4px 14px rgba(114, 24, 53, 0.05); margin-bottom: 24px;">
                            <div class="dbim-dir-category-header" style="background: #9c2759; color: #ffffff; padding: 12px 20px; font-weight: 700; font-size: 1.45rem; text-transform: uppercase; letter-spacing: 0.6px; display: flex; align-items: center; justify-content: space-between;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-building" style="font-size: 16px;"></i>
                                    <span class="dbim-dir-category-title" contenteditable="true">HON'BLE MINISTER (TEXTILE)</span>
                                </div>
                                <div class="editor-row-ctrl d-inline-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 11px;" onclick="addDirRowToTable(this)" title="Add another official row to this table">
                                        <i class="fa-solid fa-plus me-1"></i> Add Row
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 11px;" onclick="addDirSectionAfter(this)" title="Add new department section below">
                                        <i class="fa-solid fa-folder-plus me-1"></i> Add Section
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive m-0">
                                <table class="table mb-0 dbim-dir-table" style="width: 100%; border-collapse: collapse; font-family: 'Noto Sans', sans-serif;">
                                    <thead>
                                        <tr style="background: #faebf3; border-bottom: 2px solid #ecd5e1;">
                                            <th style="width: 32%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">NAME AND DESIGNATION</th>
                                            <th style="width: 38%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">CONTACT</th>
                                            <th style="width: 30%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">ADDRESS</th>
                                            <th class="editor-row-ctrl" style="width: 40px; padding: 12px 6px; border: none;"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="dbim-dir-tbody">
                                        <tr style="border-bottom: 1px solid #f1edf0; transition: background 0.15s;">
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-name fw-bold" contenteditable="true" style="color: #111827; font-size: 1.45rem; line-height: 1.35; margin-bottom: 3px;">Shri Giriraj Singh</div>
                                                <div class="officer-desig" contenteditable="true" style="color: #4b5563; font-size: 1.25rem; line-height: 1.4;">Hon'ble Minister</div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="d-flex align-items-center gap-2 mb-1" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-solid fa-phone" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-phone" contenteditable="true">011-20903582, 26113121, 20903177 /Ext.- 387</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-regular fa-envelope" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-email" contenteditable="true">minister[dot]textiles[at]gov[dot]in</span>
                                                </div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-address" contenteditable="true" style="color: #374151; font-size: 1.25rem; line-height: 1.5;">Room No. 5605, 5th Floor, GPOA-3, Netaji Nagar, New Delhi–110023</div>
                                            </td>
                                            <td class="editor-row-ctrl text-center" style="vertical-align: top; padding: 16px 6px; border: none;">
                                                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeDirRow(this)" title="Delete Row" style="font-size: 15px; text-decoration: none;">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #f1edf0; transition: background 0.15s;">
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-name fw-bold" contenteditable="true" style="color: #111827; font-size: 1.45rem; line-height: 1.35; margin-bottom: 3px;">Shri Yogendra Singh, IAS</div>
                                                <div class="officer-desig" contenteditable="true" style="color: #4b5563; font-size: 1.25rem; line-height: 1.4;">Private Secretary</div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="d-flex align-items-center gap-2 mb-1" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-solid fa-phone" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-phone" contenteditable="true">011-20903582, 26113121, 20903177 /Ext.- 387</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-regular fa-envelope" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-email" contenteditable="true">ps[dot]mot-textiles[at]gov[dot]in</span>
                                                </div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-address" contenteditable="true" style="color: #374151; font-size: 1.25rem; line-height: 1.5;">Room No. 5601, 5th Floor, GPOA-3, Netaji Nagar, New Delhi–110023</div>
                                            </td>
                                            <td class="editor-row-ctrl text-center" style="vertical-align: top; padding: 16px 6px; border: none;">
                                                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeDirRow(this)" title="Delete Row" style="font-size: 15px; text-decoration: none;">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #f1edf0; transition: background 0.15s;">
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-name fw-bold" contenteditable="true" style="color: #111827; font-size: 1.45rem; line-height: 1.35; margin-bottom: 3px;">Shri Diwakar Dubey</div>
                                                <div class="officer-desig" contenteditable="true" style="color: #4b5563; font-size: 1.25rem; line-height: 1.4;">Additional Private Secretary to the Hon'ble Minister for Textiles</div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="d-flex align-items-center gap-2 mb-1" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-solid fa-phone" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-phone" contenteditable="true">011-20903582, 26113121, 20903177 /Ext.- 387</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-regular fa-envelope" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-email" contenteditable="true">minister[dot]textiles[at]gov[dot]in</span>
                                                </div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-address" contenteditable="true" style="color: #374151; font-size: 1.25rem; line-height: 1.5;">Room No. 5607, 5th Floor, GPOA-3, Netaji Nagar, New Delhi–110023</div>
                                            </td>
                                            <td class="editor-row-ctrl text-center" style="vertical-align: top; padding: 16px 6px; border: none;">
                                                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeDirRow(this)" title="Delete Row" style="font-size: 15px; text-decoration: none;">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 2. HON'BLE MINISTER OF STATES (TEXTILES) -->
                        <div class="dbim-dir-table-wrapper" style="border: 1px solid #ebd0de; border-radius: 8px; overflow: hidden; background: #ffffff; box-shadow: 0 4px 14px rgba(114, 24, 53, 0.05); margin-bottom: 24px;">
                            <div class="dbim-dir-category-header" style="background: #9c2759; color: #ffffff; padding: 12px 20px; font-weight: 700; font-size: 1.45rem; text-transform: uppercase; letter-spacing: 0.6px; display: flex; align-items: center; justify-content: space-between;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-building" style="font-size: 16px;"></i>
                                    <span class="dbim-dir-category-title" contenteditable="true">HON'BLE MINISTER OF STATES (TEXTILES)</span>
                                </div>
                                <div class="editor-row-ctrl d-inline-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 11px;" onclick="addDirRowToTable(this)" title="Add another official row to this table">
                                        <i class="fa-solid fa-plus me-1"></i> Add Row
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 11px;" onclick="addDirSectionAfter(this)" title="Add new department section below">
                                        <i class="fa-solid fa-folder-plus me-1"></i> Add Section
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive m-0">
                                <table class="table mb-0 dbim-dir-table" style="width: 100%; border-collapse: collapse; font-family: 'Noto Sans', sans-serif;">
                                    <thead>
                                        <tr style="background: #faebf3; border-bottom: 2px solid #ecd5e1;">
                                            <th style="width: 32%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">NAME AND DESIGNATION</th>
                                            <th style="width: 38%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">CONTACT</th>
                                            <th style="width: 30%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">ADDRESS</th>
                                            <th class="editor-row-ctrl" style="width: 40px; padding: 12px 6px; border: none;"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="dbim-dir-tbody">
                                        <tr style="border-bottom: 1px solid #f1edf0; transition: background 0.15s;">
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-name fw-bold" contenteditable="true" style="color: #111827; font-size: 1.45rem; line-height: 1.35; margin-bottom: 3px;">Shri Pabitra Margherita</div>
                                                <div class="officer-desig" contenteditable="true" style="color: #4b5563; font-size: 1.25rem; line-height: 1.4;">Hon'ble Minister of State</div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="d-flex align-items-center gap-2 mb-1" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-solid fa-phone" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-phone" contenteditable="true">011-20903779, 26871575, 20903704 / Ext.-270</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-regular fa-envelope" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-email" contenteditable="true">mos-textiles[at]gov[dot]in</span>
                                                </div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-address" contenteditable="true" style="color: #374151; font-size: 1.25rem; line-height: 1.5;">Room No. 5501, 5th Floor, GPOA-3, Netaji Nagar, New Delhi–110023</div>
                                            </td>
                                            <td class="editor-row-ctrl text-center" style="vertical-align: top; padding: 16px 6px; border: none;">
                                                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeDirRow(this)" title="Delete Row" style="font-size: 15px; text-decoration: none;">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #f1edf0; transition: background 0.15s;">
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-name fw-bold" contenteditable="true" style="color: #111827; font-size: 1.45rem; line-height: 1.35; margin-bottom: 3px;">Shri Tatung Padi</div>
                                                <div class="officer-desig" contenteditable="true" style="color: #4b5563; font-size: 1.25rem; line-height: 1.4;">Private Secretary to the Hon'ble Minister of State for Textiles</div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="d-flex align-items-center gap-2 mb-1" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-solid fa-phone" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-phone" contenteditable="true">011-20903779, 26871575, 20903704 /Ext.- 210</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-regular fa-envelope" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-email" contenteditable="true">mos-textiles[at]gov[dot]in</span>
                                                </div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-address" contenteditable="true" style="color: #374151; font-size: 1.25rem; line-height: 1.5;">Room No. 5503, 5th Floor, GPOA-3, Netaji Nagar, New Delhi–110023</div>
                                            </td>
                                            <td class="editor-row-ctrl text-center" style="vertical-align: top; padding: 16px 6px; border: none;">
                                                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeDirRow(this)" title="Delete Row" style="font-size: 15px; text-decoration: none;">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 3. SECRETARY -->
                        <div class="dbim-dir-table-wrapper" style="border: 1px solid #ebd0de; border-radius: 8px; overflow: hidden; background: #ffffff; box-shadow: 0 4px 14px rgba(114, 24, 53, 0.05); margin-bottom: 24px;">
                            <div class="dbim-dir-category-header" style="background: #9c2759; color: #ffffff; padding: 12px 20px; font-weight: 700; font-size: 1.45rem; text-transform: uppercase; letter-spacing: 0.6px; display: flex; align-items: center; justify-content: space-between;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-building" style="font-size: 16px;"></i>
                                    <span class="dbim-dir-category-title" contenteditable="true">SECRETARY</span>
                                </div>
                                <div class="editor-row-ctrl d-inline-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 11px;" onclick="addDirRowToTable(this)" title="Add another official row to this table">
                                        <i class="fa-solid fa-plus me-1"></i> Add Row
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 11px;" onclick="addDirSectionAfter(this)" title="Add new department section below">
                                        <i class="fa-solid fa-folder-plus me-1"></i> Add Section
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive m-0">
                                <table class="table mb-0 dbim-dir-table" style="width: 100%; border-collapse: collapse; font-family: 'Noto Sans', sans-serif;">
                                    <thead>
                                        <tr style="background: #faebf3; border-bottom: 2px solid #ecd5e1;">
                                            <th style="width: 32%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">NAME AND DESIGNATION</th>
                                            <th style="width: 38%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">CONTACT</th>
                                            <th style="width: 30%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">ADDRESS</th>
                                            <th class="editor-row-ctrl" style="width: 40px; padding: 12px 6px; border: none;"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="dbim-dir-tbody">
                                        <tr style="border-bottom: 1px solid #f1edf0; transition: background 0.15s;">
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-name fw-bold" contenteditable="true" style="color: #111827; font-size: 1.45rem; line-height: 1.35; margin-bottom: 3px;">Smt. Neelam Shami Rao</div>
                                                <div class="officer-desig" contenteditable="true" style="color: #4b5563; font-size: 1.25rem; line-height: 1.4;">Secretary</div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="d-flex align-items-center gap-2 mb-1" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-solid fa-phone" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-phone" contenteditable="true">011-20903644, 26111769 /Ext.- 203</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-regular fa-envelope" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-email" contenteditable="true">secy-textiles[at]nic[dot]in</span>
                                                </div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-address" contenteditable="true" style="color: #374151; font-size: 1.25rem; line-height: 1.5;">Room No. 5201, 5th Floor, GPOA-3, Netaji Nagar, New Delhi–110023</div>
                                            </td>
                                            <td class="editor-row-ctrl text-center" style="vertical-align: top; padding: 16px 6px; border: none;">
                                                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeDirRow(this)" title="Delete Row" style="font-size: 15px; text-decoration: none;">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 4. ADDITIONAL SECRETARY AND FINANCIAL ADVISOR -->
                        <div class="dbim-dir-table-wrapper" style="border: 1px solid #ebd0de; border-radius: 8px; overflow: hidden; background: #ffffff; box-shadow: 0 4px 14px rgba(114, 24, 53, 0.05); margin-bottom: 24px;">
                            <div class="dbim-dir-category-header" style="background: #9c2759; color: #ffffff; padding: 12px 20px; font-weight: 700; font-size: 1.45rem; text-transform: uppercase; letter-spacing: 0.6px; display: flex; align-items: center; justify-content: space-between;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-building" style="font-size: 16px;"></i>
                                    <span class="dbim-dir-category-title" contenteditable="true">ADDITIONAL SECRETARY AND FINANCIAL ADVISOR</span>
                                </div>
                                <div class="editor-row-ctrl d-inline-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 11px;" onclick="addDirRowToTable(this)" title="Add another official row to this table">
                                        <i class="fa-solid fa-plus me-1"></i> Add Row
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 11px;" onclick="addDirSectionAfter(this)" title="Add new department section below">
                                        <i class="fa-solid fa-folder-plus me-1"></i> Add Section
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive m-0">
                                <table class="table mb-0 dbim-dir-table" style="width: 100%; border-collapse: collapse; font-family: 'Noto Sans', sans-serif;">
                                    <thead>
                                        <tr style="background: #faebf3; border-bottom: 2px solid #ecd5e1;">
                                            <th style="width: 32%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">NAME AND DESIGNATION</th>
                                            <th style="width: 38%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">CONTACT</th>
                                            <th style="width: 30%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">ADDRESS</th>
                                            <th class="editor-row-ctrl" style="width: 40px; padding: 12px 6px; border: none;"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="dbim-dir-tbody">
                                        <tr style="border-bottom: 1px solid #f1edf0; transition: background 0.15s;">
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-name fw-bold" contenteditable="true" style="color: #111827; font-size: 1.45rem; line-height: 1.35; margin-bottom: 3px;">Ms. Sarita Chauhan Chand</div>
                                                <div class="officer-desig" contenteditable="true" style="color: #4b5563; font-size: 1.25rem; line-height: 1.4;">Additional Secretary and Financial Advisor</div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="d-flex align-items-center gap-2 mb-1" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-solid fa-phone" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-phone" contenteditable="true">011-20903043, 20903105</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-regular fa-envelope" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-email" contenteditable="true">sarita[dot]chauhanias[at]nic[dot]in</span>
                                                </div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-address" contenteditable="true" style="color: #374151; font-size: 1.25rem; line-height: 1.5;">Room No. 3204, 3rd Floor, Zone-2, GPOA-3, Netaji Nagar, New Delhi–110023</div>
                                            </td>
                                            <td class="editor-row-ctrl text-center" style="vertical-align: top; padding: 16px 6px; border: none;">
                                                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeDirRow(this)" title="Delete Row" style="font-size: 15px; text-decoration: none;">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 5. ADDITIONAL SECRETARY -->
                        <div class="dbim-dir-table-wrapper" style="border: 1px solid #ebd0de; border-radius: 8px; overflow: hidden; background: #ffffff; box-shadow: 0 4px 14px rgba(114, 24, 53, 0.05); margin-bottom: 24px;">
                            <div class="dbim-dir-category-header" style="background: #9c2759; color: #ffffff; padding: 12px 20px; font-weight: 700; font-size: 1.45rem; text-transform: uppercase; letter-spacing: 0.6px; display: flex; align-items: center; justify-content: space-between;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-building" style="font-size: 16px;"></i>
                                    <span class="dbim-dir-category-title" contenteditable="true">ADDITIONAL SECRETARY</span>
                                </div>
                                <div class="editor-row-ctrl d-inline-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 11px;" onclick="addDirRowToTable(this)" title="Add another official row to this table">
                                        <i class="fa-solid fa-plus me-1"></i> Add Row
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 11px;" onclick="addDirSectionAfter(this)" title="Add new department section below">
                                        <i class="fa-solid fa-folder-plus me-1"></i> Add Section
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive m-0">
                                <table class="table mb-0 dbim-dir-table" style="width: 100%; border-collapse: collapse; font-family: 'Noto Sans', sans-serif;">
                                    <thead>
                                        <tr style="background: #faebf3; border-bottom: 2px solid #ecd5e1;">
                                            <th style="width: 32%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">NAME AND DESIGNATION</th>
                                            <th style="width: 38%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">CONTACT</th>
                                            <th style="width: 30%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">ADDRESS</th>
                                            <th class="editor-row-ctrl" style="width: 40px; padding: 12px 6px; border: none;"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="dbim-dir-tbody">
                                        <tr style="border-bottom: 1px solid #f1edf0; transition: background 0.15s;">
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-name fw-bold" contenteditable="true" style="color: #111827; font-size: 1.45rem; line-height: 1.35; margin-bottom: 3px;">Smt. Arti Kanwar</div>
                                                <div class="officer-desig" contenteditable="true" style="color: #4b5563; font-size: 1.25rem; line-height: 1.4;">Additional Secretary</div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="d-flex align-items-center gap-2 mb-1" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-solid fa-phone" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-phone" contenteditable="true">011-26110494 /Ext.- 259</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2" style="font-size: 1.25rem; color: #1f2937;">
                                                    <i class="fa-regular fa-envelope" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                                    <span class="officer-email" contenteditable="true">arti[dot]kanwar[at]ias[dot]gov[dot]in</span>
                                                </div>
                                            </td>
                                            <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                                <div class="officer-address" contenteditable="true" style="color: #374151; font-size: 1.25rem; line-height: 1.5;">Room No. 5204, 5th Floor, GPOA-3, Netaji Nagar, New Delhi–110023</div>
                                            </td>
                                            <td class="editor-row-ctrl text-center" style="vertical-align: top; padding: 16px 6px; border: none;">
                                                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeDirRow(this)" title="Delete Row" style="font-size: 15px; text-decoration: none;">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>`;

                case 'dbim_data_table':
                    return `<div class="dbim-data-table-wrapper my-4" data-component="dbim_data_table" data-current-page="1" data-page-size="5" style="border: 1px solid #ebd0de; border-radius: 8px; overflow: hidden; background: #ffffff; box-shadow: 0 4px 14px rgba(114, 24, 53, 0.05);">
                        <!-- 1. Table Top Header Bar (Maroon Government Theme) -->
                        <div class="dbim-table-header-bar" style="background: #721835; color: #ffffff; padding: 12px 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <i class="fa-solid fa-table-list" style="font-size: 16px;"></i>
                                <h3 class="dbim-table-title mb-0" contenteditable="true" style="font-size: 1.45rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #ffffff;">Research & Development Projects handled by Laboratories of Textiles Committee</h3>
                            </div>
                            <div class="editor-table-ctrl d-inline-flex flex-wrap align-items-center gap-1">
                                <button type="button" class="btn btn-sm btn-outline-light py-1 px-2 editor-table-btn" onclick="addDbimTableRow(this)" title="Add a new clean row to this table" style="font-size: 11.5px; font-weight: 600;">
                                    <i class="fa-solid fa-plus me-1"></i> Add Row
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-light py-1 px-2 editor-table-btn" onclick="addDbimTableColumn(this)" title="Add a new custom column" style="font-size: 11.5px; font-weight: 600;">
                                    <i class="fa-solid fa-table-columns me-1"></i> Add Column
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-light py-1 px-2 editor-table-btn" onclick="addDbimTableImageColumn(this)" title="Add an image/logo column" style="font-size: 11.5px; font-weight: 600;">
                                    <i class="fa-regular fa-image me-1"></i> Add Image Col
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-light py-1 px-2 editor-table-btn" onclick="addDbimTableActionColumn(this)" title="Add an action button column" style="font-size: 11.5px; font-weight: 600;">
                                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Add Action Col
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger text-white py-1 px-2 editor-table-btn" onclick="if(confirm('Delete this entire table?')) this.closest('.dbim-data-table-wrapper').remove()" title="Delete entire table" style="font-size: 11.5px; background: rgba(220, 53, 69, 0.4);">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </div>

                        <!-- 2. Controls Toolbar (Page Size Selector & Live Search Filter) -->
                        <div class="dbim-table-toolbar p-3 bg-light border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-secondary small fw-semibold" style="font-size: 1.2rem;">Show</span>
                                <select class="form-select form-select-sm dbim-page-size-select" style="width: auto; font-size: 1.2rem;" onchange="changeDbimTablePageSize(this)">
                                    <option value="5" selected>5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="all">All</option>
                                </select>
                                <span class="text-secondary small fw-semibold" style="font-size: 1.2rem;">entries</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0 dbim-table-search-input" placeholder="Search table..." onkeyup="filterDbimTable(this)" style="font-size: 1.2rem;">
                                </div>
                            </div>
                        </div>

                        <!-- 3. Responsive Clean Table (Without hardcoded phone/email icons) -->
                        <div class="table-responsive m-0">
                            <table class="table mb-0 dbim-data-table" style="width: 100%; border-collapse: collapse; font-family: 'Noto Sans', sans-serif;">
                                <thead>
                                    <tr class="dbim-table-head-row" style="background: #faebf3; border-bottom: 2px solid #ecd5e1;">
                                        <th style="width: 8%; padding: 12px 16px; color: #721835; font-weight: 700; font-size: 1.2rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">
                                            <span class="col-title" contenteditable="true">SR.NO</span>
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-1 editor-table-btn" onclick="removeDbimTableColumn(this)" title="Delete Column"><i class="fa-solid fa-xmark"></i></button>
                                        </th>
                                        <th style="width: 32%; padding: 12px 16px; color: #721835; font-weight: 700; font-size: 1.2rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">
                                            <span class="col-title" contenteditable="true">TITLE OF PROJECT</span>
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-1 editor-table-btn" onclick="removeDbimTableColumn(this)" title="Delete Column"><i class="fa-solid fa-xmark"></i></button>
                                        </th>
                                        <th style="width: 28%; padding: 12px 16px; color: #721835; font-weight: 700; font-size: 1.2rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">
                                            <span class="col-title" contenteditable="true">SPONSORED BY</span>
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-1 editor-table-btn" onclick="removeDbimTableColumn(this)" title="Delete Column"><i class="fa-solid fa-xmark"></i></button>
                                        </th>
                                        <th class="col-image-head" style="width: 14%; padding: 12px 16px; color: #721835; font-weight: 700; font-size: 1.2rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">
                                            <span class="col-title" contenteditable="true">IMAGE / LOGO</span>
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-1 editor-table-btn" onclick="removeDbimTableColumn(this)" title="Delete Column"><i class="fa-solid fa-xmark"></i></button>
                                        </th>
                                        <th class="col-action-head" style="width: 14%; padding: 12px 16px; color: #721835; font-weight: 700; font-size: 1.2rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">
                                            <span class="col-title" contenteditable="true">ACTION</span>
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-1 editor-table-btn" onclick="removeDbimTableColumn(this)" title="Delete Column"><i class="fa-solid fa-xmark"></i></button>
                                        </th>
                                        <th class="editor-table-ctrl text-center" style="width: 40px; padding: 12px 6px; border: none;"></th>
                                    </tr>
                                </thead>
                                <tbody class="dbim-table-body">
                                    <!-- Row 1 -->
                                    <tr class="dbim-table-row" data-table-row="true" style="border-bottom: 1px solid #f1edf0; transition: background 0.15s;">
                                        <td style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="dbim-cell-text fw-bold text-muted sr-no-cell" contenteditable="true" style="font-size: 1.3rem;">1</div>
                                        </td>
                                        <td style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="dbim-cell-text fw-bold" contenteditable="true" style="color: #111827; font-size: 1.35rem; line-height: 1.4;">Development of Eri Silk & Polyester Blended Yarn & Fabrics</div>
                                        </td>
                                        <td style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="dbim-cell-text" contenteditable="true" style="color: #374151; font-size: 1.3rem; line-height: 1.4;">KVIC, Mumbai, Project handled with BIT, Davanagere, Karnataka</div>
                                        </td>
                                        <td class="col-image-cell" style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="dbim-table-img-wrap position-relative d-inline-block">
                                                <img src="/assets/images/Textiles_Committee_Logo.png" class="dbim-table-img rounded border" style="max-height: 42px; max-width: 80px; object-fit: contain; cursor: pointer;" onclick="openAvatarModal(this)" title="Click to change image">
                                                <button type="button" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 p-0 rounded-circle editor-table-btn" style="width: 16px; height: 16px; font-size: 8px; line-height: 16px;" onclick="openAvatarModal(this)" title="Change Image"><i class="fa-solid fa-camera"></i></button>
                                            </div>
                                        </td>
                                        <td class="col-action-cell" style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="d-flex align-items-center gap-1">
                                                <a href="#" class="btn btn-sm text-white px-3 py-1 dbim-action-btn" style="background: #721835; font-size: 1.15rem; font-weight: 600; text-decoration: none; border-radius: 4px;" contenteditable="true">
                                                    <i class="fa-solid fa-eye me-1"></i> View Project
                                                </a>
                                            </div>
                                        </td>
                                        <td class="editor-table-ctrl text-center" style="vertical-align: middle; padding: 14px 6px; border: none;">
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 editor-table-btn" onclick="removeDbimTableRow(this)" title="Delete Row" style="font-size: 15px; text-decoration: none;">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Row 2 -->
                                    <tr class="dbim-table-row" data-table-row="true" style="border-bottom: 1px solid #f1edf0; transition: background 0.15s;">
                                        <td style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="dbim-cell-text fw-bold text-muted sr-no-cell" contenteditable="true" style="font-size: 1.3rem;">2</div>
                                        </td>
                                        <td style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="dbim-cell-text fw-bold" contenteditable="true" style="color: #111827; font-size: 1.35rem; line-height: 1.4;">Standardization and Quality Profiling of Natural Dyes for Eco-Textiles</div>
                                        </td>
                                        <td style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="dbim-cell-text" contenteditable="true" style="color: #374151; font-size: 1.3rem; line-height: 1.4;">Ministry of Textiles, Government of India / Laboratories Division</div>
                                        </td>
                                        <td class="col-image-cell" style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="dbim-table-img-wrap position-relative d-inline-block">
                                                <img src="/assets/images/Textiles_Committee_Logo.png" class="dbim-table-img rounded border" style="max-height: 42px; max-width: 80px; object-fit: contain; cursor: pointer;" onclick="openAvatarModal(this)" title="Click to change image">
                                                <button type="button" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 p-0 rounded-circle editor-table-btn" style="width: 16px; height: 16px; font-size: 8px; line-height: 16px;" onclick="openAvatarModal(this)" title="Change Image"><i class="fa-solid fa-camera"></i></button>
                                            </div>
                                        </td>
                                        <td class="col-action-cell" style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="d-flex align-items-center gap-1">
                                                <a href="#" class="btn btn-sm text-white px-3 py-1 dbim-action-btn" style="background: #721835; font-size: 1.15rem; font-weight: 600; text-decoration: none; border-radius: 4px;" contenteditable="true">
                                                    <i class="fa-solid fa-eye me-1"></i> View Project
                                                </a>
                                            </div>
                                        </td>
                                        <td class="editor-table-ctrl text-center" style="vertical-align: middle; padding: 14px 6px; border: none;">
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 editor-table-btn" onclick="removeDbimTableRow(this)" title="Delete Row" style="font-size: 15px; text-decoration: none;">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Row 3 -->
                                    <tr class="dbim-table-row" data-table-row="true" style="border-bottom: 1px solid #f1edf0; transition: background 0.15s;">
                                        <td style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="dbim-cell-text fw-bold text-muted sr-no-cell" contenteditable="true" style="font-size: 1.3rem;">3</div>
                                        </td>
                                        <td style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="dbim-cell-text fw-bold" contenteditable="true" style="color: #111827; font-size: 1.35rem; line-height: 1.4;">Development of High-Performance Protective Textiles for Medical & Defence Applications</div>
                                        </td>
                                        <td style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="dbim-cell-text" contenteditable="true" style="color: #374151; font-size: 1.3rem; line-height: 1.4;">Defence Research & Development Organisation (DRDO) & EPQA Division</div>
                                        </td>
                                        <td class="col-image-cell" style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="dbim-table-img-wrap position-relative d-inline-block">
                                                <img src="/assets/images/Textiles_Committee_Logo.png" class="dbim-table-img rounded border" style="max-height: 42px; max-width: 80px; object-fit: contain; cursor: pointer;" onclick="openAvatarModal(this)" title="Click to change image">
                                                <button type="button" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 p-0 rounded-circle editor-table-btn" style="width: 16px; height: 16px; font-size: 8px; line-height: 16px;" onclick="openAvatarModal(this)" title="Change Image"><i class="fa-solid fa-camera"></i></button>
                                            </div>
                                        </td>
                                        <td class="col-action-cell" style="padding: 14px 16px; vertical-align: middle; border: none;">
                                            <div class="d-flex align-items-center gap-1">
                                                <a href="#" class="btn btn-sm text-white px-3 py-1 dbim-action-btn" style="background: #721835; font-size: 1.15rem; font-weight: 600; text-decoration: none; border-radius: 4px;" contenteditable="true">
                                                    <i class="fa-solid fa-eye me-1"></i> View Project
                                                </a>
                                            </div>
                                        </td>
                                        <td class="editor-table-ctrl text-center" style="vertical-align: middle; padding: 14px 6px; border: none;">
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 editor-table-btn" onclick="removeDbimTableRow(this)" title="Delete Row" style="font-size: 15px; text-decoration: none;">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- 4. Table Pagination & Info Footer Bar -->
                        <div class="dbim-table-pagination-bar d-flex flex-wrap align-items-center justify-content-between p-3 border-top bg-light" style="font-size: 1.2rem;">
                            <div class="dbim-table-info text-muted small">
                                Showing 1 to 3 of 3 entries
                            </div>
                            <nav aria-label="Table pagination">
                                <ul class="pagination pagination-sm mb-0 dbim-table-pagination gap-1">
                                    <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" style="border-radius: 4px;">&laquo; Prev</a></li>
                                    <li class="page-item active"><a class="page-link" href="javascript:void(0)" style="background: #721835; border-color: #721835; color: #fff; border-radius: 4px;">1</a></li>
                                    <li class="page-item disabled"><a class="page-link" href="javascript:void(0)" style="border-radius: 4px;">Next &raquo;</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>`;

                case 'dbim_advanced_table':
                case 'advanced_table':
                case 'pro_table':
                    return `<div class="dbim-advanced-table-wrapper my-4 position-relative" data-component="dbim_advanced_table" style="font-family: 'Noto Sans', sans-serif;">
                        <!-- Floating Attached Pro Table Control Toolbar -->
                        <div class="editor-pro-table-ctrl p-2 mb-2 bg-white border rounded shadow-sm d-flex flex-wrap align-items-center justify-content-between gap-2" style="border-color: #ebd0de !important; font-size: 11.5px;">
                            <!-- Left: Branding & Quick Context Info -->
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge text-white px-2 py-1" style="background: #721835; font-size: 10px;">PRO GRID TABLE</span>
                                <span class="pro-table-selection-badge text-muted small" style="font-size: 11px;">
                                    <i class="fa-regular fa-hand-pointer me-1"></i> <span class="selected-cell-info">Click any cell to edit spans</span>
                                </span>
                            </div>

                            <!-- Right: Control Toolbars -->
                            <div class="d-inline-flex flex-wrap align-items-center gap-1">
                                <!-- DIRECT ROW CONTROLS (+ ROW / DUP ROW / DEL ROW) -->
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-success py-1 px-2 editor-table-btn" onclick="addProTableRow(this, 'below')" title="Insert new blank Row below (+ Row)">
                                        <i class="fa-solid fa-plus me-1"></i> Row
                                    </button>
                                    <button type="button" class="btn btn-outline-primary py-1 px-2 editor-table-btn" onclick="duplicateProTableRow(this)" title="Duplicate Selected Row (clones row data & styles)">
                                        <i class="fa-regular fa-copy me-1"></i> Dup Row
                                    </button>
                                    <button type="button" class="btn btn-outline-danger py-1 px-2 editor-table-btn" onclick="deleteProTableRow(this)" title="Delete Selected Row (along with connected rowspans)">
                                        <i class="fa-regular fa-trash-can me-1"></i> Del Row
                                    </button>
                                    <button class="btn btn-outline-secondary py-1 px-1 dropdown-toggle dropdown-toggle-split editor-table-btn" type="button" data-bs-toggle="dropdown" title="More Row Options"></button>
                                    <ul class="dropdown-menu shadow-sm" style="font-size: 12px; z-index: 2200;">
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="addProTableRow(this, 'above')"><i class="fa-solid fa-plus text-success me-2"></i> Insert Row Above</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="addProTableRow(this, 'below')"><i class="fa-solid fa-plus text-success me-2"></i> Insert Row Below</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="duplicateProTableRow(this)"><i class="fa-regular fa-copy text-primary me-2"></i> Duplicate This Row</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="moveProTableRow(this, 'up')"><i class="fa-solid fa-arrow-up text-primary me-2"></i> Move Row Up</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="moveProTableRow(this, 'down')"><i class="fa-solid fa-arrow-down text-primary me-2"></i> Move Row Down</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteProTableRow(this)"><i class="fa-regular fa-trash-can me-2"></i> Delete Selected Row</a></li>
                                    </ul>
                                </div>

                                <!-- DIRECT COLUMN CONTROLS (+ COL / DUP COL / DEL COL) -->
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-success py-1 px-2 editor-table-btn" onclick="addProTableColumn(this, 'right')" title="Insert new blank Column to the right (+ Col)">
                                        <i class="fa-solid fa-plus me-1"></i> Col
                                    </button>
                                    <button type="button" class="btn btn-outline-primary py-1 px-2 editor-table-btn" onclick="duplicateProTableColumn(this)" title="Duplicate Selected Column (clones column across all rows)">
                                        <i class="fa-regular fa-copy me-1"></i> Dup Col
                                    </button>
                                    <button type="button" class="btn btn-outline-danger py-1 px-2 editor-table-btn" onclick="deleteProTableColumn(this)" title="Delete Selected Column (along with connected colspans)">
                                        <i class="fa-regular fa-trash-can me-1"></i> Del Col
                                    </button>
                                    <button class="btn btn-outline-secondary py-1 px-1 dropdown-toggle dropdown-toggle-split editor-table-btn" type="button" data-bs-toggle="dropdown" title="More Column Options"></button>
                                    <ul class="dropdown-menu shadow-sm" style="font-size: 12px; z-index: 2200;">
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="addProTableColumn(this, 'left')"><i class="fa-solid fa-plus text-success me-2"></i> Insert Column Left</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="addProTableColumn(this, 'right')"><i class="fa-solid fa-plus text-success me-2"></i> Insert Column Right</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="duplicateProTableColumn(this)"><i class="fa-regular fa-copy text-primary me-2"></i> Duplicate This Column</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteProTableColumn(this)"><i class="fa-regular fa-trash-can me-2"></i> Delete Selected Column</a></li>
                                    </ul>
                                </div>

                                <!-- TABLE HEAD (THEAD) CONTROLS -->
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-sm btn-outline-secondary py-1 px-2 dropdown-toggle editor-table-btn" type="button" data-bs-toggle="dropdown" style="font-size: 11px;">
                                        <i class="fa-solid fa-heading me-1"></i> Header (thead)
                                    </button>
                                    <ul class="dropdown-menu shadow-sm" style="font-size: 12px; z-index: 2200;">
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="addProTableHeaderRow(this, 'above')"><i class="fa-solid fa-plus text-success me-2"></i> Add Header Row (Top Tier)</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="addProTableHeaderRow(this, 'below')"><i class="fa-solid fa-plus text-success me-2"></i> Add Header Row (Sub Tier)</a></li>
                                        <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteProTableHeaderRow(this)"><i class="fa-regular fa-trash-can me-2"></i> Remove Header Row</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProTableHeaderTheme(this, 'maroon')"><i class="fa-solid fa-circle me-2" style="color: #721835;"></i> Theme: Official Maroon</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProTableHeaderTheme(this, 'soft')"><i class="fa-solid fa-circle me-2" style="color: #ecd5e1;"></i> Theme: Soft Tint</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProTableHeaderTheme(this, 'grey')"><i class="fa-solid fa-circle me-2" style="color: #e9ecef;"></i> Theme: Classic Grey</a></li>
                                    </ul>
                                </div>

                                <!-- QUICK SPANS BUTTONS (COLSPAN & ROWSPAN) -->
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary py-1 px-2 editor-table-btn" onclick="quickAdjustProCellSpan(this, 'colspan', 1)" title="Increase Colspan (+1)">
                                        <i class="fa-solid fa-arrows-left-right-to-line"></i> +Colspan
                                    </button>
                                    <button type="button" class="btn btn-outline-primary py-1 px-2 editor-table-btn" onclick="quickAdjustProCellSpan(this, 'colspan', -1)" title="Decrease Colspan (-1)">
                                        -Colspan
                                    </button>
                                    <button type="button" class="btn btn-outline-info py-1 px-2 editor-table-btn" onclick="quickAdjustProCellSpan(this, 'rowspan', 1)" title="Increase Rowspan (+1)">
                                        <i class="fa-solid fa-arrows-up-down-left-right"></i> +Rowspan
                                    </button>
                                    <button type="button" class="btn btn-outline-info py-1 px-2 editor-table-btn" onclick="quickAdjustProCellSpan(this, 'rowspan', -1)" title="Decrease Rowspan (-1)">
                                        -Rowspan
                                    </button>
                                </div>

                                <!-- UNMERGE & DELETE UNWANTED CELL -->
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-warning py-1 px-2 editor-table-btn text-dark fw-semibold" onclick="clearProCellSpans(this)" title="Reset Rowspan & Colspan to 1 (Unmerge cell)">
                                        <i class="fa-solid fa-arrows-split-up-and-left me-1"></i> Unmerge
                                    </button>
                                    <button type="button" class="btn btn-outline-danger py-1 px-2 editor-table-btn" onclick="deleteProCell(this)" title="Delete this individual unwanted cell (removes extra/unwanted cell)">
                                        <i class="fa-solid fa-xmark me-1"></i> Del Cell
                                    </button>
                                </div>

                                <!-- CELL PROPERTIES MODAL LAUNCHER -->
                                <button type="button" class="btn btn-sm text-white py-1 px-2 editor-table-btn" style="background: #721835; font-size: 11px;" onclick="openProCellSettingsModal(this)" title="Advanced Cell Settings (Rowspan, Colspan, Alignment, Colors, Tag)">
                                    <i class="fa-solid fa-sliders me-1"></i> Cell Properties...
                                </button>

                                <!-- CELL FORMATTING & INSERT DROPDOWN -->
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-sm btn-outline-secondary py-1 px-2 dropdown-toggle editor-table-btn" type="button" data-bs-toggle="dropdown" style="font-size: 11px;">
                                        <i class="fa-solid fa-palette me-1"></i> Cell Style
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="font-size: 12px; z-index: 2200;">
                                        <li class="dropdown-header">Text Alignment</li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProCellAlign(this, 'left')"><i class="fa-solid fa-align-left me-2"></i> Align Left</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProCellAlign(this, 'center')"><i class="fa-solid fa-align-center me-2"></i> Align Center</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProCellAlign(this, 'right')"><i class="fa-solid fa-align-right me-2"></i> Align Right</a></li>
                                        <li class="dropdown-header">Vertical Alignment</li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProCellValign(this, 'top')"><i class="fa-solid fa-arrow-up-to-line me-2"></i> Top</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProCellValign(this, 'middle')"><i class="fa-solid fa-arrows-to-dot me-2"></i> Middle</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProCellValign(this, 'bottom')"><i class="fa-solid fa-arrow-down-to-line me-2"></i> Bottom</a></li>
                                        <li class="dropdown-header">Background Color</li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProCellBg(this, '#ffffff', '#212529')"><i class="fa-regular fa-square me-2"></i> White (Default)</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProCellBg(this, '#721835', '#ffffff')"><i class="fa-solid fa-square me-2" style="color: #721835;"></i> Maroon Accent</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProCellBg(this, '#faebf3', '#721835')"><i class="fa-solid fa-square me-2" style="color: #faebf3;"></i> Soft Pink Tint</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProCellBg(this, '#f8f9fa', '#212529')"><i class="fa-solid fa-square me-2" style="color: #e9ecef;"></i> Light Gray</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProCellBg(this, '#fff3cd', '#856404')"><i class="fa-solid fa-square me-2" style="color: #ffeeba;"></i> Yellow Alert</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setProCellBg(this, '#d1e7dd', '#0f5132')"><i class="fa-solid fa-square me-2" style="color: #badbcc;"></i> Green Highlight</a></li>
                                        <li class="dropdown-header">Insert Elements</li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="insertImageInProCell(this)"><i class="fa-regular fa-image text-danger me-2"></i> Insert Photo / Logo</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="insertBadgeInProCell(this, 'active')"><i class="fa-solid fa-tag text-success me-2"></i> Insert 'Completed' Badge</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="insertBadgeInProCell(this, 'pending')"><i class="fa-solid fa-tag text-warning me-2"></i> Insert 'In Progress' Badge</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="insertPdfButtonInProCell(this)"><i class="fa-solid fa-file-pdf text-danger me-2"></i> Insert PDF Download Link</a></li>
                                    </ul>
                                </div>

                                <!-- TABLE BORDER & STYLE TOGGLE -->
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-sm btn-outline-secondary py-1 px-2 dropdown-toggle editor-table-btn" type="button" data-bs-toggle="dropdown" style="font-size: 11px;">
                                        <i class="fa-solid fa-border-all me-1"></i> Style
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="font-size: 12px; z-index: 2200;">
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="toggleProTableClass(this, 'table-bordered')"><i class="fa-solid fa-border-all me-2"></i> Toggle Full Grid Borders</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="toggleProTableClass(this, 'table-striped')"><i class="fa-solid fa-bars me-2"></i> Toggle Striped Rows</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="toggleProTableClass(this, 'table-sm')"><i class="fa-solid fa-compress me-2"></i> Toggle Compact Padding</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="toggleProTableClass(this, 'table-hover')"><i class="fa-regular fa-hand-pointer me-2"></i> Toggle Hover Highlight</a></li>
                                    </ul>
                                </div>

                                <!-- DELETE TABLE -->
                                <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 editor-table-btn" onclick="if(confirm('Delete this entire Pro Table?')) this.closest('.dbim-advanced-table-wrapper').remove()" title="Delete Table">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </div>

                        <!-- 2. TABLE TITLE / CAPTION (Editable) -->
                        <div class="dbim-table-title-bar mb-2 d-flex align-items-center justify-content-between" style="border-left: 4px solid #721835; padding-left: 10px;">
                            <h4 class="m-0 fw-bold" contenteditable="true" style="color: #721835; font-size: 1.6rem; letter-spacing: -0.2px;">Performance & Physical Targets Matrix (Official Schedule)</h4>
                        </div>

                        <!-- 3. RESPONSIVE TABLE WRAPPER -->
                        <div class="table-responsive m-0 pro-table-scroll-wrap" style="border-radius: 8px; border: 1px solid #ebd0de;">
                            <table class="table table-bordered mb-0 dbim-pro-table" style="width: 100%; border-collapse: collapse; font-family: 'Noto Sans', sans-serif;">
                                <thead>
                                    <!-- TIER 1 HEADER ROW -->
                                    <tr class="pro-thead-row pro-thead-primary" style="background: #721835; color: #ffffff;">
                                        <th rowspan="2" class="align-middle text-center" style="width: 60px; min-width: 50px; background: #721835; color: #ffffff; border: 1px solid #9c2759;">S.No.</th>
                                        <th rowspan="2" class="align-middle" style="min-width: 220px; background: #721835; color: #ffffff; border: 1px solid #9c2759;">Component / Scheme Focus</th>
                                        <th colspan="2" class="text-center align-middle" style="background: #5a1129; color: #ffffff; border: 1px solid #9c2759;">Financial Outlay (₹ in Crore)</th>
                                        <th colspan="2" class="text-center align-middle" style="background: #5a1129; color: #ffffff; border: 1px solid #9c2759;">Physical Targets (Units / Labs)</th>
                                        <th rowspan="2" class="align-middle text-center" style="min-width: 130px; background: #721835; color: #ffffff; border: 1px solid #9c2759;">Status / Reference</th>
                                    </tr>
                                    <!-- TIER 2 HEADER ROW (Sub-headers) -->
                                    <tr class="pro-thead-row pro-thead-secondary" style="background: #8b1f42; color: #ffffff;">
                                        <th class="text-center align-middle" style="background: #8b1f42; color: #ffffff; border: 1px solid #9c2759;">Allocation</th>
                                        <th class="text-center align-middle" style="background: #8b1f42; color: #ffffff; border: 1px solid #9c2759;">Expenditure</th>
                                        <th class="text-center align-middle" style="background: #8b1f42; color: #ffffff; border: 1px solid #9c2759;">Annual Target</th>
                                        <th class="text-center align-middle" style="background: #8b1f42; color: #ffffff; border: 1px solid #9c2759;">Achievement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- ROW 1 (Group Row: Category with rowspan=2) -->
                                    <tr>
                                        <td rowspan="2" class="text-center align-middle fw-bold" style="background: #fdf5f8;">1</td>
                                        <td class="align-middle fw-semibold">Quality Testing & Laboratory Modernization</td>
                                        <td class="text-center align-middle">45.00</td>
                                        <td class="text-center align-middle">38.40</td>
                                        <td class="text-center align-middle">12 Centers</td>
                                        <td class="text-center align-middle">11 Centers</td>
                                        <td class="text-center align-middle">
                                            <span class="badge" style="background: #e6f4ea; color: #137333; font-size: 11px; padding: 4px 8px; border-radius: 4px;">Completed</span>
                                        </td>
                                    </tr>
                                    <!-- ROW 2 (Sub-row grouped under S.No 1) -->
                                    <tr>
                                        <td class="align-middle text-muted" style="padding-left: 20px;">└ NABL ISO/IEC 17025 Surveillance Audits</td>
                                        <td class="text-center align-middle">12.50</td>
                                        <td class="text-center align-middle">11.80</td>
                                        <td class="text-center align-middle">8 Audits</td>
                                        <td class="text-center align-middle">8 Audits</td>
                                        <td class="text-center align-middle">
                                            <span class="badge" style="background: #e8f0fe; color: #1a73e8; font-size: 11px; padding: 4px 8px; border-radius: 4px;">Verified</span>
                                        </td>
                                    </tr>
                                    <!-- ROW 3 (Normal Row) -->
                                    <tr>
                                        <td class="text-center align-middle fw-bold">2</td>
                                        <td class="align-middle fw-semibold">Star Rating & Handloom Quality Certification</td>
                                        <td class="text-center align-middle">28.00</td>
                                        <td class="text-center align-middle">26.15</td>
                                        <td class="text-center align-middle">150 Units</td>
                                        <td class="text-center align-middle">142 Units</td>
                                        <td class="text-center align-middle">
                                            <span class="badge" style="background: #fef7e0; color: #b06000; font-size: 11px; padding: 4px 8px; border-radius: 4px;">In Progress</span>
                                        </td>
                                    </tr>
                                    <!-- ROW 4 (Spanning Colspan for summary / total) -->
                                    <tr style="background: #faebf3; font-weight: 700;">
                                        <td colspan="2" class="text-end align-middle" style="color: #721835;">Cumulative National Total:</td>
                                        <td class="text-center align-middle" style="color: #721835;">85.50</td>
                                        <td class="text-center align-middle" style="color: #721835;">76.35</td>
                                        <td class="text-center align-middle" style="color: #721835;">170</td>
                                        <td class="text-center align-middle" style="color: #721835;">161</td>
                                        <td class="text-center align-middle">
                                            <span class="badge" style="background: #721835; color: #fff; font-size: 11px;">94.7% Met</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- 4. FOOTER NOTE (Editable) -->
                        <p class="text-muted small mt-2 mb-0" contenteditable="true" style="font-size: 1.15rem;">
                            * Source: Ministry of Textiles Statistical Division & Textiles Committee Annual Report. All figures subject to statutory reconciliation.
                        </p>
                    </div>`;

                case 'dbim_avatar_profile_card':
                    return `<div class="dbim-avatar-card-wrapper my-4 text-center" data-component="dbim_avatar_profile_card">
                        <div class="card p-4 border shadow-sm text-center position-relative" style="border-radius: 14px; background: #ffffff; border-color: #ebd0de !important;">
                            <!-- Avatar Photo Wrap -->
                            <div class="position-relative d-inline-block mx-auto mb-3">
                                <div class="dbim-avatar-img-wrap" onclick="openAvatarModal(this)" title="Click to change profile photo">
                                    <img src="/assets/images/giriraj_singh.png" class="dbim-avatar-img" alt="Official Profile Photo" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\\'http://www.w3.org/2000/svg\\' viewBox=\\'0 0 24 24\\' fill=\\'%239c2759\\'><path d=\\'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z\\'/></svg>'">
                                </div>
                                <button type="button" class="btn btn-sm editor-avatar-btn position-absolute bottom-0 start-50 translate-middle-x" onclick="openAvatarModal(this)" title="Upload or change profile photo">
                                    <i class="fa-solid fa-camera me-1"></i> Change Photo
                                </button>
                            </div>

                            <!-- Role Badge -->
                            <div class="mb-2">
                                <span class="badge" contenteditable="true" style="background: #ebd0de; color: #721835; font-size: 1.15rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; padding: 4px 12px; border-radius: 20px;">HON'BLE MINISTER</span>
                            </div>

                            <!-- Officer Name -->
                            <h4 class="fw-bold mb-1" contenteditable="true" style="color: #1a1a1a; font-size: 1.85rem;">Shri Giriraj Singh</h4>

                            <!-- Designation & Ministry -->
                            <p class="text-muted mb-3" contenteditable="true" style="font-size: 1.3rem;">Ministry of Textiles, Government of India</p>

                            <!-- Contact Meta -->
                            <div class="d-flex flex-column gap-2 text-start pt-3 border-top" style="border-color: #f1edf0 !important; font-size: 1.25rem;">
                                <div class="d-flex align-items-center gap-2 text-dark">
                                    <i class="fa-solid fa-phone text-muted" style="width: 16px;"></i>
                                    <span contenteditable="true">011-20903582, 26113121</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 text-dark">
                                    <i class="fa-regular fa-envelope text-muted" style="width: 16px;"></i>
                                    <span contenteditable="true">minister[dot]textiles[at]gov[dot]in</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 text-dark">
                                    <i class="fa-solid fa-location-dot text-muted" style="width: 16px;"></i>
                                    <span contenteditable="true">Room No. 5605, 5th Floor, GPOA-3, Netaji Nagar, New Delhi</span>
                                </div>
                            </div>
                        </div>
                    </div>`;

                case 'dbim_avatar_leadership_grid':
                    return `<div class="dbim-avatar-leadership-section my-4" data-component="dbim_avatar_leadership_grid">
                        <div class="text-center mb-4">
                            <h2 contenteditable="true" style="color: #500a2f; font-weight: 700; font-size: 2.3rem; margin-bottom: 6px;">Executive Leadership</h2>
                            <p contenteditable="true" class="text-muted" style="font-size: 1.35rem;">Ministry of Textiles & Textiles Committee</p>
                        </div>
                        <div class="dbim-avatar-grid">
                            <!-- Leader 1 -->
                            <div class="card p-4 border shadow-sm text-center position-relative" style="border-radius: 14px; background: #ffffff; border-color: #ebd0de !important;">
                                <div class="position-relative d-inline-block mx-auto mb-3">
                                    <div class="dbim-avatar-img-wrap" onclick="openAvatarModal(this)" title="Click to change profile photo">
                                        <img src="/assets/images/giriraj_singh.png" class="dbim-avatar-img" alt="Hon'ble Minister" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\\'http://www.w3.org/2000/svg\\' viewBox=\\'0 0 24 24\\' fill=\\'%239c2759\\'><path d=\\'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z\\'/></svg>'">
                                    </div>
                                    <button type="button" class="btn btn-sm editor-avatar-btn position-absolute bottom-0 start-50 translate-middle-x" onclick="openAvatarModal(this)">
                                        <i class="fa-solid fa-camera me-1"></i> Change Photo
                                    </button>
                                </div>
                                <div class="mb-2">
                                    <span class="badge" contenteditable="true" style="background: #ebd0de; color: #721835; font-size: 1.1rem; font-weight: 700; text-transform: uppercase; padding: 4px 10px; border-radius: 20px;">HON'BLE MINISTER</span>
                                </div>
                                <h4 class="fw-bold mb-1" contenteditable="true" style="color: #1a1a1a; font-size: 1.75rem;">Shri Giriraj Singh</h4>
                                <p class="text-muted mb-2 small" contenteditable="true" style="font-size: 1.25rem;">Minister for Textiles, GoI</p>
                                <div class="pt-2 border-top small text-muted text-center" style="font-size: 1.15rem;">
                                    <span contenteditable="true"><i class="fa-regular fa-envelope me-1"></i> minister[dot]textiles[at]gov[dot]in</span>
                                </div>
                            </div>

                            <!-- Leader 2 -->
                            <div class="card p-4 border shadow-sm text-center position-relative" style="border-radius: 14px; background: #ffffff; border-color: #ebd0de !important;">
                                <div class="position-relative d-inline-block mx-auto mb-3">
                                    <div class="dbim-avatar-img-wrap" onclick="openAvatarModal(this)" title="Click to change profile photo">
                                        <img src="/assets/images/user-placeholder.png" class="dbim-avatar-img" alt="Hon'ble Minister of State" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\\'http://www.w3.org/2000/svg\\' viewBox=\\'0 0 24 24\\' fill=\\'%239c2759\\'><path d=\\'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z\\'/></svg>'">
                                    </div>
                                    <button type="button" class="btn btn-sm editor-avatar-btn position-absolute bottom-0 start-50 translate-middle-x" onclick="openAvatarModal(this)">
                                        <i class="fa-solid fa-camera me-1"></i> Change Photo
                                    </button>
                                </div>
                                <div class="mb-2">
                                    <span class="badge" contenteditable="true" style="background: #ebd0de; color: #721835; font-size: 1.1rem; font-weight: 700; text-transform: uppercase; padding: 4px 10px; border-radius: 20px;">HON'BLE MOS</span>
                                </div>
                                <h4 class="fw-bold mb-1" contenteditable="true" style="color: #1a1a1a; font-size: 1.75rem;">Shri Pabitra Margherita</h4>
                                <p class="text-muted mb-2 small" contenteditable="true" style="font-size: 1.25rem;">Minister of State for Textiles, GoI</p>
                                <div class="pt-2 border-top small text-muted text-center" style="font-size: 1.15rem;">
                                    <span contenteditable="true"><i class="fa-regular fa-envelope me-1"></i> mos-textiles[at]gov[dot]in</span>
                                </div>
                            </div>

                            <!-- Leader 3 -->
                            <div class="card p-4 border shadow-sm text-center position-relative" style="border-radius: 14px; background: #ffffff; border-color: #ebd0de !important;">
                                <div class="position-relative d-inline-block mx-auto mb-3">
                                    <div class="dbim-avatar-img-wrap" onclick="openAvatarModal(this)" title="Click to change profile photo">
                                        <img src="/assets/images/user-placeholder.png" class="dbim-avatar-img" alt="Secretary" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\\'http://www.w3.org/2000/svg\\' viewBox=\\'0 0 24 24\\' fill=\\'%239c2759\\'><path d=\\'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z\\'/></svg>'">
                                    </div>
                                    <button type="button" class="btn btn-sm editor-avatar-btn position-absolute bottom-0 start-50 translate-middle-x" onclick="openAvatarModal(this)">
                                        <i class="fa-solid fa-camera me-1"></i> Change Photo
                                    </button>
                                </div>
                                <div class="mb-2">
                                    <span class="badge" contenteditable="true" style="background: #ebd0de; color: #721835; font-size: 1.1rem; font-weight: 700; text-transform: uppercase; padding: 4px 10px; border-radius: 20px;">SECRETARY</span>
                                </div>
                                <h4 class="fw-bold mb-1" contenteditable="true" style="color: #1a1a1a; font-size: 1.75rem;">Smt. Neelam Shami Rao</h4>
                                <p class="text-muted mb-2 small" contenteditable="true" style="font-size: 1.25rem;">Secretary, Ministry of Textiles, GoI</p>
                                <div class="pt-2 border-top small text-muted text-center" style="font-size: 1.15rem;">
                                    <span contenteditable="true"><i class="fa-regular fa-envelope me-1"></i> secy-textiles[at]nic[dot]in</span>
                                </div>
                            </div>
                        </div>
                    </div>`;

                case 'dbim_avatar_inline':
                    return `<div class="dbim-avatar-inline-box my-2" data-component="dbim_avatar_inline">
                        <div class="position-relative">
                            <div class="dbim-avatar-img-wrap" style="width: 60px; height: 60px; padding: 2px;" onclick="openAvatarModal(this)" title="Click to change profile photo">
                                <img src="/assets/images/giriraj_singh.png" class="dbim-avatar-img" alt="Official Photo" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\\'http://www.w3.org/2000/svg\\' viewBox=\\'0 0 24 24\\' fill=\\'%239c2759\\'><path d=\\'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z\\'/></svg>'">
                            </div>
                            <button type="button" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 p-0 rounded-circle editor-avatar-btn" style="width: 20px; height: 20px; font-size: 10px; line-height: 20px;" onclick="openAvatarModal(this)" title="Change Photo">
                                <i class="fa-solid fa-camera"></i>
                            </button>
                        </div>
                        <div>
                            <div class="officer-name fw-bold" contenteditable="true" style="font-size: 1.45rem; margin-bottom: 2px;">Official Full Name</div>
                            <div class="officer-desig" contenteditable="true" style="font-size: 1.2rem;">Designation / Official Title</div>
                        </div>
                    </div>`;

                case 'dbim_faq_component':
                    return `<div class="dbim-faq-wrapper my-4" data-component="dbim_faq_component">
                        <div class="dbim-faq-header-bar">
                            <div>
                                <span class="badge mb-2" contenteditable="true" style="background: #ebd0de; color: #721835; font-size: 1.15rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; padding: 4px 12px; border-radius: 20px;">HELP & KNOWLEDGE BASE</span>
                                <h2 class="dbim-faq-title" contenteditable="true">Frequently Asked Questions (FAQs)</h2>
                                <p class="text-muted mb-0" contenteditable="true" style="font-size: 1.3rem;">Find quick answers regarding Textiles Committee testing services, certification, Handloom Mark, and regulatory procedures.</p>
                            </div>
                            <div class="dbim-faq-controls">
                                <div class="dbim-faq-search">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <input type="text" placeholder="Search questions..." onkeyup="filterFaqItems(this)">
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-dark fw-bold px-3 py-2 dbim-faq-toggle-all" onclick="toggleAllFaqs(this)" style="font-size: 1.2rem; border-radius: 20px;">
                                    <i class="fa-solid fa-expand me-1"></i> Expand All
                                </button>
                                <button type="button" class="btn btn-sm text-white fw-bold px-3 py-2 editor-faq-btn" onclick="addFaqItem(this)" style="background: #721835; font-size: 1.2rem; border-radius: 20px;" title="Add new FAQ Question">
                                    <i class="fa-solid fa-plus me-1"></i> Add Question
                                </button>
                            </div>
                        </div>
                        <div class="dbim-faq-list">
                            <!-- Q1 -->
                            <div class="dbim-faq-item is-active" data-faq-item="true">
                                <div class="dbim-faq-question" onclick="toggleFaqItem(this)">
                                    <div class="dbim-faq-q-left">
                                        <span class="dbim-faq-badge">Q1</span>
                                        <h4 class="dbim-faq-q-text" contenteditable="true">What is the primary statutory mandate of the Textiles Committee?</h4>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0 editor-faq-btn" onclick="removeFaqItem(this)" title="Delete Question" style="font-size: 15px; text-decoration: none;">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                        <span class="dbim-faq-chevron"><i class="fa-solid fa-chevron-down"></i></span>
                                    </div>
                                </div>
                                <div class="dbim-faq-answer" contenteditable="true">
                                    <p>The Textiles Committee is a statutory body established under <strong>The Textiles Committee Act, 1963 (No. 41 of 1963)</strong> under the administrative control of the Ministry of Textiles, Government of India. Its primary mandate is to ensure the quality of textiles and textile machinery manufactured in India, for both domestic consumption and international export markets.</p>
                                </div>
                            </div>
                            <!-- Q2 -->
                            <div class="dbim-faq-item" data-faq-item="true">
                                <div class="dbim-faq-question" onclick="toggleFaqItem(this)">
                                    <div class="dbim-faq-q-left">
                                        <span class="dbim-faq-badge">Q2</span>
                                        <h4 class="dbim-faq-q-text" contenteditable="true">What types of testing services are provided by Textiles Committee laboratories?</h4>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0 editor-faq-btn" onclick="removeFaqItem(this)" title="Delete Question" style="font-size: 15px; text-decoration: none;">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                        <span class="dbim-faq-chevron"><i class="fa-solid fa-chevron-down"></i></span>
                                    </div>
                                </div>
                                <div class="dbim-faq-answer" contenteditable="true">
                                    <p>The Committee operates 19 state-of-the-art testing laboratories across India accredited under <strong>NABL (ISO/IEC 17025:2017)</strong>. Laboratory services include:</p>
                                    <ul>
                                        <li><strong>Chemical Eco-Testing:</strong> Formaldehyde, banned azo dyes, pentachlorophenol (PCP), heavy metals, phthalates, and pH determination.</li>
                                        <li><strong>Mechanical & Physical Testing:</strong> Tensile strength, tearing strength, seam slippage, pilling resistance, dimensional stability, and colour fastness.</li>
                                        <li><strong>Fiber Composition:</strong> Blend ratio analysis and microscopic identification of natural, synthetic, and specialized fibres.</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Q3 -->
                            <div class="dbim-faq-item" data-faq-item="true">
                                <div class="dbim-faq-question" onclick="toggleFaqItem(this)">
                                    <div class="dbim-faq-q-left">
                                        <span class="dbim-faq-badge">Q3</span>
                                        <h4 class="dbim-faq-q-text" contenteditable="true">How can exporters obtain a Certificate of Origin (COO)?</h4>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0 editor-faq-btn" onclick="removeFaqItem(this)" title="Delete Question" style="font-size: 15px; text-decoration: none;">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                        <span class="dbim-faq-chevron"><i class="fa-solid fa-chevron-down"></i></span>
                                    </div>
                                </div>
                                <div class="dbim-faq-answer" contenteditable="true">
                                    <p>The Textiles Committee is an authorized agency of the Directorate General of Foreign Trade (DGFT) for issuing <strong>Non-Preferential Certificates of Origin (COO)</strong>. Exporters can apply through the DGFT Common Digital Platform (<a href="https://coo.dgft.gov.in" target="_blank">coo.dgft.gov.in</a>) selecting the nearest Regional Office of the Textiles Committee for endorsement and verification.</p>
                                </div>
                            </div>
                            <!-- Q4 -->
                            <div class="dbim-faq-item" data-faq-item="true">
                                <div class="dbim-faq-question" onclick="toggleFaqItem(this)">
                                    <div class="dbim-faq-q-left">
                                        <span class="dbim-faq-badge">Q4</span>
                                        <h4 class="dbim-faq-q-text" contenteditable="true">What is the Handloom Mark scheme and how does the Committee facilitate it?</h4>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0 editor-faq-btn" onclick="removeFaqItem(this)" title="Delete Question" style="font-size: 15px; text-decoration: none;">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                        <span class="dbim-faq-chevron"><i class="fa-solid fa-chevron-down"></i></span>
                                    </div>
                                </div>
                                <div class="dbim-faq-answer" contenteditable="true">
                                    <p>The Handloom Mark is a collective identity for genuine Indian handloom products introduced by the Ministry of Textiles. The Textiles Committee acts as the <strong>Implementing Agency</strong> responsible for verification, registration of weavers and cooperatives, and issuing secure holographic labels to prevent spurious powerloom counterfeits.</p>
                                </div>
                            </div>
                            <!-- Q5 -->
                            <div class="dbim-faq-item" data-faq-item="true">
                                <div class="dbim-faq-question" onclick="toggleFaqItem(this)">
                                    <div class="dbim-faq-q-left">
                                        <span class="dbim-faq-badge">Q5</span>
                                        <h4 class="dbim-faq-q-text" contenteditable="true">Where are the Regional Offices located and how can I contact them?</h4>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0 editor-faq-btn" onclick="removeFaqItem(this)" title="Delete Question" style="font-size: 15px; text-decoration: none;">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                        <span class="dbim-faq-chevron"><i class="fa-solid fa-chevron-down"></i></span>
                                    </div>
                                </div>
                                <div class="dbim-faq-answer" contenteditable="true">
                                    <p>The Textiles Committee is headquartered in Prabhadevi, Mumbai, with an extensive network of 28 Regional and Sub-Offices located in key textile clusters across India. You can explore the interactive contact map and address directory on the <a href="/page/office-network">Office Network</a> page.</p>
                                </div>
                            </div>
                        </div>
                    </div>`;

                // 0. FEATURED FULL-PAGE TEMPLATES
                case 'template_act_history':
                    return `<div class="about-page-layout my-4" data-template="act-history">
                        <!-- LEFT SIDEBAR COLUMN (330px) -->
                        <div class="about-vision-col">
                            <!-- 1. Top Overview Box -->
                            <div class="about-vision-card text-center mb-4">
                                <div class="acts-logo-wrap mb-3" onclick="openImagePicker('replace', this.querySelector('img'))" title="Click to change logo / photo" style="cursor: pointer;">
                                    <img src="/assets/images/Textiles_Committee_Logo.png" class="img-fluid" style="max-height: 52px; object-fit: contain;" alt="Textiles Committee">
                                </div>
                                <p class="about-vision-text" style="font-size: 1.35rem; line-height: 1.7; color: #2b2b2b; font-style: italic; margin-bottom: 18px; text-align: justify;">
                                    "The Textiles Committee is a statutory body established by an Act of Parliament (The Textiles Committee Act, 1963) to ensure the quality of textiles and textile machinery produced in India for domestic consumption and export."
                                </p>
                                <h3 class="fw-bold mb-3" style="color: #1a1a1a; font-size: 1.85rem; letter-spacing: 0.5px;">ESTABLISHED 1963</h3>
                                <div class="text-start pt-2 border-top" style="font-size: 1.25rem; color: #333; line-height: 1.8;">
                                    <div><i class="fa-solid fa-file-signature text-secondary me-2"></i> <strong>Assent of President:</strong> Dec 3, 1963</div>
                                    <div><i class="fa-solid fa-flag text-secondary me-2"></i> <strong>Commencement:</strong> Aug 22, 1964</div>
                                </div>
                            </div>

                            <!-- 2. Bottom Document Download Card -->
                            <div class="acts-card compact-size shadow-sm" style="border: 1.5px solid #ebd0de; border-radius: 10px; background: #ffffff; padding: 18px 20px;">
                                <div class="d-flex align-items-center gap-2 mb-1 text-muted small fw-bold text-uppercase" style="font-size: 1.1rem; color: #721835 !important;">
                                    <i class="fa-regular fa-file-pdf text-danger"></i> Official Act Document
                                </div>
                                <h4 class="fw-bold mb-3" style="font-size: 1.4rem; color: #1e293b; line-height: 1.35;">
                                    The Textiles Committee Act, 1963 (Act No. 41 of 1963)
                                </h4>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <a href="/assets/images/sample_doc.pdf" target="_blank" class="team-dl-btn w-100 justify-content-center py-2" style="font-size: 1.25rem;">
                                        <i class="fa-solid fa-download text-danger me-2"></i> Download Act PDF
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-secondary w-100 mt-2 py-1" onclick="openPdfUploader(this.previousElementSibling)" title="Upload a new PDF to change this link" style="font-size: 11px;">
                                        <i class="fa-solid fa-arrow-up-from-bracket me-1"></i> Change / Upload PDF File
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT MAIN CONTENT COLUMN -->
                        <div class="about-main-col">
                            <!-- Lead intro paragraph -->
                            <p class="about-lead-para" style="font-size: 1.5rem; line-height: 1.85; color: #1e293b; text-align: justify; margin-bottom: 24px;">
                                The Textiles Committee is an autonomous statutory organization under the administrative control of the <strong>Ministry of Textiles, Government of India</strong>. It succeeded the erstwhile <em>Cotton Textiles Fund Committee</em> which was constituted in 1944. Recognizing the necessity of an institutional framework capable of establishing quality consciousness, testing facilities, and standard specifications across all textile categories (cotton, silk, wool, man-made fibres, and garments), the Parliament of India enacted <strong>The Textiles Committee Act, 1963 (No. 41 of 1963)</strong>.
                            </p>

                            <!-- Evolution Heading -->
                            <h3 class="about-mission-heading" style="font-size: 2.1rem; font-weight: 800; color: #1a1a1a; margin-top: 28px; margin-bottom: 18px;">
                                Evolution Through the Decades
                            </h3>

                            <!-- Decades Bullet List -->
                            <ul class="about-mission-list" style="font-size: 1.42rem; line-height: 1.85; color: #2b2b2b; padding-left: 20px;">
                                <li class="mb-3">
                                    <strong>1963 – 1970s (The Formative & Regulatory Era):</strong> Focused primarily on pre-shipment inspection of cotton textiles and fabrics during the quota era under the Multi-Fibre Arrangement (MFA), creating international buyer confidence in Indian exports.
                                </li>
                                <li class="mb-3">
                                    <strong>1980s – 1990s (Technological Upgradation & Laboratories):</strong> Modernized by establishing state-of-the-art testing laboratories and eco-parameter testing facilities across major industrial clusters in Mumbai, Ahmedabad, Bengaluru, Chennai, and New Delhi.
                                </li>
                                <li class="mb-3">
                                    <strong>2000s – Post-Quota Transition:</strong> Transitioned from a purely regulatory inspection authority to a dynamic service organization and trade facilitator, supporting MSMEs, handloom weavers, and exporters with Total Quality Management (TQM) consultancy, ISO 9000/14000 certifications, and Market Research.
                                </li>
                                <li class="mb-4">
                                    <strong>Present Era (Sustainable Textiles, GI & Skill Development):</strong> Pioneering intellectual property protection (Post-GI initiatives for handloom and handicraft clusters), sustainability benchmarking, chemical eco-testing, and nationwide skill development under Government of India programs.
                                </li>
                            </ul>

                            <!-- Core Mission Callout Box -->
                            <div style="background: #fdf5f8; border-left: 4px solid #721835; padding: 22px 26px; border-radius: 8px; margin-top: 28px;">
                                <h4 style="color: #721835; font-weight: 800; font-size: 1.6rem; margin: 0 0 8px; display: flex; align-items: center; gap: 8px;">
                                    <i class="fa-solid fa-quote-left"></i> Our Core Mission
                                </h4>
                                <p style="margin: 0; font-size: 1.38rem; line-height: 1.75; color: #334155; text-align: justify;">
                                    To promote quality and excellence in the Indian textile industry through research, testing laboratories, standard specification formulation, and continuous quality appraisal, making Indian textiles globally recognized for quality and integrity.
                                </p>
                            </div>
                        </div>
                    </div>`;

                case 'template_dbim_contact_us':
                    return `<div class="row g-5 my-3" data-component="dbim_contact_us_section">
                        <!-- LEFT SIDEBAR: Sticky Vision Box -->
                        <div class="col-md-12 col-lg-4 stickyBox">
                            <div class="visionbox">
                                <div>
                                    <h2 contenteditable="true">Textiles Committee is a statutory body established under the Ministry of Textiles, Government of India, ensuring quality assurance, testing laboratories, and export readiness.</h2>
                                    <p contenteditable="true">CENTRAL HEADQUARTERS &bull; MUMBAI</p>
                                </div>
                            </div>

                            <!-- Quick Contact Directory Card -->
                            <div class="box mt-4 p-4" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 12px;">
                                <h4 style="color: #500a2f; font-size: 1.85rem; font-weight: 700; margin-bottom: 14px;" contenteditable="true">
                                    <i class="fa fa-phone me-2 text-danger"></i> Central Helpline
                                </h4>
                                <div style="font-size: 1.55rem; line-height: 1.85; color: #2b2b2b;" contenteditable="true">
                                    <div><strong>EPABX:</strong> +91-22-66527500 / 04</div>
                                    <div><strong>Secretary:</strong> +91-22-66527501</div>
                                    <div><strong>Email:</strong> secy.tc@nic.in</div>
                                    <div><strong>Office Hours:</strong> Mon &ndash; Fri, 9:30 AM &ndash; 6:00 PM</div>
                                </div>

                                <div class="mt-4 pt-3 border-top" style="border-color: #ebd0de !important;">
                                    <a href="/tcwebsite/public/industry-tech-issues" class="btn w-100 text-white fw-bold py-2 d-flex align-items-center justify-content-center gap-2" style="background: #6c1340; border-radius: 8px; font-size: 1.55rem;">
                                        <i class="fa fa-wrench"></i>
                                        <span>Industry Tech Issues &rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT MAIN CONTENT: Aboutcontent text-justify -->
                        <div class="col-md-12 col-lg-8">
                            <div class="aboutcontent text-justify">
                                <h2 contenteditable="true">Ministry of Textiles, Government of India</h2>
                                <p contenteditable="true">The Textiles Committee functions under the administrative control of the Ministry of Textiles, Government of India. The Committee operates a comprehensive nationwide network of 28+ regional offices and 16+ NABL-accredited eco-testing and physical testing laboratories to assist textile manufacturers, exporters, and government procurement bodies.</p>

                                <!-- Central Headquarters Address -->
                                <h2 contenteditable="true">Central Headquarters Address</h2>
                                <div class="box p-4 mb-4" style="background: #fdf7fa; border: 1px solid #ebd0de; border-radius: 10px;">
                                    <div class="d-flex align-items-start gap-3">
                                        <div style="color: #6c1340; font-size: 2.6rem; line-height: 1; margin-top: 2px;">
                                            <i class="fa-solid fa-location-dot"></i>
                                        </div>
                                        <div style="font-size: 1.65rem; line-height: 1.8; color: #150202;" contenteditable="true">
                                            <strong style="color: #500a2f; font-size: 1.8rem;">Textiles Committee</strong><br>
                                            Government of India, Ministry of Textiles<br>
                                            P. Balu Road, Prabhadevi Chowk, Prabhadevi,<br>
                                            Mumbai &ndash; 400 025, Maharashtra, India.
                                        </div>
                                    </div>
                                </div>

                                <!-- Nodal Officers / WIM / CISO -->
                                <h2 contenteditable="true">Web Information &amp; Nodal Officers</h2>
                                <div class="row g-4 mb-4">
                                    <div class="col-md-6">
                                        <div class="box h-100 p-4" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 10px;">
                                            <h3 style="color: #500a2f; font-size: 1.8rem; font-weight: 700; margin-bottom: 10px; line-height: 1.35;" contenteditable="true">
                                                Content &amp; Web Information Manager (WIM)
                                            </h3>
                                            <div style="font-size: 1.55rem; line-height: 1.75; color: #2b2b2b;" contenteditable="true">
                                                <strong>Shri Akhilesh Kumar</strong><br>
                                                Deputy Director General, Ministry of Textiles<br>
                                                GPOA 3, 5th Floor, Africa Avenue, Sector 55, Netaji Nagar, New Delhi-110023<br>
                                                <strong>Phone:</strong> +91-11-23062109<br>
                                                <strong>Email:</strong> akhilesh[dot]kumar99[at]gov[dot]in
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="box h-100 p-4" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 10px;">
                                            <h3 style="color: #500a2f; font-size: 1.8rem; font-weight: 700; margin-bottom: 10px; line-height: 1.35;" contenteditable="true">
                                                Chief Information Security Officer (CISO)
                                            </h3>
                                            <div style="font-size: 1.55rem; line-height: 1.75; color: #2b2b2b;" contenteditable="true">
                                                <strong>Shri Akhilesh Kumar</strong><br>
                                                Deputy Director General, Ministry of Textiles<br>
                                                GPOA 3, 5th Floor, Africa Avenue, Sector 55, Netaji Nagar, New Delhi-110023<br>
                                                <strong>Phone:</strong> +91-11-23062109<br>
                                                <strong>Email:</strong> akhilesh[dot]kumar99[at]gov[dot]in
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Citizen Inquiry & Feedback Form -->
                                <h2 contenteditable="true">Citizen Inquiry &amp; Feedback Form</h2>
                                <p contenteditable="true">Citizens, exporters, and industry partners can submit inquiries or grievances directly. Inquiries are logged into the central citizen tracking system and addressed by designated divisional officers.</p>

                                <div class="box p-4 p-md-5 mb-5" style="background: #ffffff; border: 1.5px solid #ebd0de; border-radius: 12px;">
                                    <form action="/tcwebsite/public/inquiry" method="POST">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Your Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" required placeholder="Enter your full name" style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Your Email <span class="text-danger">*</span></label>
                                                <input type="email" name="email" class="form-control" required placeholder="name@domain.com" style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Contact Number</label>
                                                <input type="tel" name="phone" class="form-control" placeholder="+91 9876543210" style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Subject / Sector <span class="text-danger">*</span></label>
                                                <input type="text" name="subject" class="form-control" required placeholder="e.g. Testing Services, Handloom, Star Rating" style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Your Message <span class="text-danger">*</span></label>
                                                <textarea name="message" class="form-control" rows="5" required placeholder="Provide details regarding your query, requirements, or feedback..." style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;"></textarea>
                                            </div>

                                            <div class="col-12 mt-3">
                                                <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background: #6c1340; border-radius: 6px; font-size: 1.65rem;">
                                                    Submit Inquiry
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Location Map -->
                                <h2 contenteditable="true">Headquarters Location &amp; Directions</h2>
                                <div class="box p-0 overflow-hidden mb-4" style="border: 1.5px solid #ebd0de; border-radius: 12px;">
                                    <iframe 
                                        title="Textiles Committee of India Map"
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3772.3394747217596!2d72.8258380757529!3d19.004732682187654!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7ce95c1a84f33%3A0xe53be0ef6c41d187!2sTextiles%20Committee%2C%20Govt%20of%20India!5e0!3m2!1sen!2sin!4v1710000000000!5m2!1sen!2sin" 
                                        width="100%" 
                                        height="380" 
                                        style="border:0; display: block;" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                    <div class="p-3 bg-light" style="font-size: 1.45rem; color: #500a2f; border-top: 1px solid #ebd0de;">
                                        <strong>Transit Landmarks:</strong> Prabhadevi Railway Station (Western Line &ndash; 1.1 km) &bull; Dadar Railway Junction (2.2 km) &bull; Mumbai Chhatrapati Shivaji Maharaj Airport (14 km).
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                // 1. CONTAINERS & GRIDS
                case 'container_1col':
                    return `<div class="pro-container-1col my-4">
                        <div class="pro-col-box">
                            <h3 class="fw-bold text-dark mb-2">Section Container (1-Column Boxed)</h3>
                            <p class="text-muted mb-0" style="font-size: 1.35rem;">Add your custom content or drag widgets into this container box.</p>
                        </div>
                    </div>`;

                case 'container_2col':
                    return `<div class="pro-container-2col my-4">
                        <div class="pro-col-box">
                            <h4 class="fw-bold text-dark mb-2">Column 1 (50%)</h4>
                            <p style="font-size: 1.35rem; color: #333;">Enter details, descriptions or specifications for the first column.</p>
                        </div>
                        <div class="pro-col-box">
                            <h4 class="fw-bold text-dark mb-2">Column 2 (50%)</h4>
                            <p style="font-size: 1.35rem; color: #333;">Enter details, descriptions or upload photos for the second column.</p>
                        </div>
                    </div>`;

                case 'container_3col':
                    return `<div class="pro-container-3col my-4">
                        <div class="pro-col-box">
                            <h5 class="fw-bold text-dark">Feature 1</h5>
                            <p style="font-size: 1.25rem; color: #444;">Short description of first key service or initiative.</p>
                        </div>
                        <div class="pro-col-box">
                            <h5 class="fw-bold text-dark">Feature 2</h5>
                            <p style="font-size: 1.25rem; color: #444;">Short description of second key service or initiative.</p>
                        </div>
                        <div class="pro-col-box">
                            <h5 class="fw-bold text-dark">Feature 3</h5>
                            <p style="font-size: 1.25rem; color: #444;">Short description of third key service or initiative.</p>
                        </div>
                    </div>`;

                case 'container_4col':
                    return `<div class="pro-container-4col my-4">
                        <div class="pro-col-box text-center">
                            <h5 class="fw-bold mb-1">Step 1</h5>
                            <p class="small text-muted mb-0">Application Submission</p>
                        </div>
                        <div class="pro-col-box text-center">
                            <h5 class="fw-bold mb-1">Step 2</h5>
                            <p class="small text-muted mb-0">Document Verification</p>
                        </div>
                        <div class="pro-col-box text-center">
                            <h5 class="fw-bold mb-1">Step 3</h5>
                            <p class="small text-muted mb-0">Laboratory Testing</p>
                        </div>
                        <div class="pro-col-box text-center">
                            <h5 class="fw-bold mb-1">Step 4</h5>
                            <p class="small text-muted mb-0">Certificate Issuance</p>
                        </div>
                    </div>`;

                case 'container_sidebar':
                    return `<div class="pro-container-sidebar my-4">
                        <div class="pro-col-box bg-light">
                            <h4 class="fw-bold text-danger mb-3"><i class="fa-solid fa-list-check me-2"></i> Quick Index</h4>
                            <ul class="list-unstyled mb-0" style="font-size: 1.3rem; line-height: 2;">
                                <li><a href="#" class="text-decoration-none text-dark fw-semibold">• Statutory Mandate</a></li>
                                <li><a href="#" class="text-decoration-none text-dark fw-semibold">• Key Responsibilities</a></li>
                                <li><a href="#" class="text-decoration-none text-dark fw-semibold">• Regulatory Powers</a></li>
                                <li><a href="#" class="text-decoration-none text-dark fw-semibold">• Contact Directory</a></li>
                            </ul>
                        </div>
                        <div class="pro-col-box">
                            <h3 class="fw-bold text-dark mb-3">Main Content Section (2/3)</h3>
                            <p class="lead" style="font-size: 1.45rem; line-height: 1.8; color: #222;">Textiles Committee functions as an autonomous statutory organization under the Ministry of Textiles, Government of India. It strives to establish premier testing and quality infrastructure across major textile clusters in the nation.</p>
                        </div>
                    </div>`;

                // 2. ELEMENTOR PRO WIDGETS
                case 'pro_dual_heading':
                    return `<h2 class="pro-dual-heading my-4">
                        <span class="highlight-badge">NATIONAL INITIATIVE</span>
                        Empowering <span class="accent-text">Textile Innovation & Quality Standards</span>
                    </h2>`;

                case 'pro_cta':
                    return `<div class="pro-cta-box my-4">
                        <h3 class="pro-cta-title">Apply for National Textile Certification & Testing Services</h3>
                        <p class="pro-cta-desc">Avail NABL-accredited laboratory testing, eco-testing parameters, and official conformity verification with subsidized rates for MSMEs and artisans.</p>
                        <a href="#" class="pro-cta-btn">
                            <span>Register Online Today</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>`;

                case 'pro_pricing':
                    return `<div class="pro-pricing-card my-4 mx-auto" style="max-width: 420px;">
                        <span class="pro-pricing-badge">Official User Charges</span>
                        <h3 class="pro-pricing-title">Physical & Chemical Testing</h3>
                        <div class="pro-pricing-price">₹ 2,500 <span>/ sample</span></div>
                        <ul class="pro-pricing-features">
                            <li><i class="fa-solid fa-circle-check"></i> Complete Fiber Composition Analysis</li>
                            <li><i class="fa-solid fa-circle-check"></i> Color Fastness to Washing & Light</li>
                            <li><i class="fa-solid fa-circle-check"></i> Tensile & Tear Strength Assessment</li>
                            <li><i class="fa-solid fa-circle-check"></i> Official NABL Stamped Certificate</li>
                            <li><i class="fa-solid fa-circle-check"></i> Fast-track delivery within 3-5 days</li>
                        </ul>
                        <a href="/assets/images/sample_doc.pdf" target="_blank" class="team-dl-btn w-100 justify-content-center">
                            <i class="fa-solid fa-download me-2"></i> Download Full Tariff Schedule [PDF]
                        </a>
                    </div>`;

                case 'pro_counter':
                    return `<div class="row g-3 my-4">
                        <div class="col-md-4">
                            <div class="pro-counter-box">
                                <div class="pro-counter-icon"><i class="fa-solid fa-users"></i></div>
                                <div class="pro-counter-number">9,68,018+</div>
                                <h4 class="pro-counter-label">Artisans & Weavers</h4>
                                <p class="pro-counter-desc">Enrolled across 28 States & UTs</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pro-counter-box">
                                <div class="pro-counter-icon"><i class="fa-solid fa-flask-vial"></i></div>
                                <div class="pro-counter-number">19</div>
                                <h4 class="pro-counter-label">NABL Laboratories</h4>
                                <p class="pro-counter-desc">Advanced quality testing centers</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pro-counter-box">
                                <div class="pro-counter-icon"><i class="fa-solid fa-certificate"></i></div>
                                <div class="pro-counter-number">100%</div>
                                <h4 class="pro-counter-label">Quality Compliance</h4>
                                <p class="pro-counter-desc">Compliant with global export norms</p>
                            </div>
                        </div>
                    </div>`;

                case 'pro_testimonial':
                    return `<div class="pro-testimonial-card my-4">
                        <div class="pro-testimonial-stars">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p class="pro-testimonial-quote">"The Textiles Committee testing protocols and certification have elevated our handloom cluster's export credibility, allowing our weavers to access premium European and American textile markets."</p>
                        <div class="pro-testimonial-author">
                            <img src="/assets/images/giriraj_singh.png" class="pro-testimonial-avatar" alt="Dignitary">
                            <div>
                                <h5 class="pro-testimonial-name">Cluster Stakeholder Feedback</h5>
                                <p class="pro-testimonial-role">President, Regional Handloom Export Guild</p>
                            </div>
                        </div>
                    </div>`;

                case 'pro_tabs':
                    return `<div class="pro-tabs-wrapper my-4" id="${uid}">
                        <div class="pro-tabs-nav">
                            <div class="pro-tab-item active" onclick="switchProTab('${uid}', 0)">1. Overview & Mandate</div>
                            <div class="pro-tab-item" onclick="switchProTab('${uid}', 1)">2. Operational Guidelines</div>
                            <div class="pro-tab-item" onclick="switchProTab('${uid}', 2)">3. Documents & Gazette</div>
                        </div>
                        <div class="pro-tabs-body">
                            <div class="pro-tab-pane active">
                                <h4 class="fw-bold mb-2">Overview of the Statutory Mandate</h4>
                                <p>Established under the Textiles Committee Act, 1963, the committee ensures the quality of textiles and textile machinery produced throughout India, both for internal marketing and export.</p>
                            </div>
                            <div class="pro-tab-pane">
                                <h4 class="fw-bold mb-2">Standard Operating Procedures</h4>
                                <p>Inspection and testing protocols are conducted in alignment with ISO/IEC 17025 accreditation standards across all 19 modern testing laboratories located nationwide.</p>
                            </div>
                            <div class="pro-tab-pane">
                                <h4 class="fw-bold mb-2">Official Documents</h4>
                                <p>Download the relevant statutory notification, application formats, and procedural guidelines via the official gazette links below.</p>
                                <a href="/assets/images/sample_doc.pdf" target="_blank" class="team-dl-btn">
                                    <i class="fa-regular fa-file-pdf text-danger me-2"></i> DOWNLOAD GUIDELINES [PDF]
                                </a>
                            </div>
                        </div>
                    </div>`;

                case 'pro_progressbar':
                    return `<div class="pro-progress-box my-4">
                        <div class="pro-progress-header">
                            <span class="pro-progress-title">Scheme Implementation Target (FY 2025-26)</span>
                            <span class="pro-progress-pct">85% Completed</span>
                        </div>
                        <div class="pro-progress-bar-wrap">
                            <div class="pro-progress-fill" style="width: 85%;"></div>
                        </div>
                    </div>`;

                case 'pro_timeline':
                    return `<div class="pro-timeline-wrapper my-4">
                        <div class="pro-timeline-node">
                            <div class="pro-timeline-dot"><i class="fa-solid fa-flag"></i></div>
                            <div class="pro-timeline-date">1963</div>
                            <h4 class="pro-timeline-title">Enactment of Textiles Committee Act</h4>
                            <p class="pro-timeline-desc">Parliament enacted Act No. 41 of 1963 to establish the Textiles Committee as a statutory body ensuring textile quality across India.</p>
                        </div>
                        <div class="pro-timeline-node">
                            <div class="pro-timeline-dot"><i class="fa-solid fa-building"></i></div>
                            <div class="pro-timeline-date">1970 - 1990</div>
                            <h4 class="pro-timeline-title">Establishment of Regional Testing Laboratories</h4>
                            <p class="pro-timeline-desc">Network of specialized chemical and physical laboratories set up in key textile centers including Mumbai, Ahmedabad, Coimbatore, and Kanpur.</p>
                        </div>
                        <div class="pro-timeline-node">
                            <div class="pro-timeline-dot"><i class="fa-solid fa-certificate"></i></div>
                            <div class="pro-timeline-date">Present Day</div>
                            <h4 class="pro-timeline-title">NABL Accreditation & Modern Digitization</h4>
                            <p class="pro-timeline-desc">Transformation into a world-class inspection and trade facilitation authority supporting Samarth, Handloom Mark, and Jute Mark India.</p>
                        </div>
                    </div>`;

                case 'pro_iconbox':
                    return `<div class="pro-icon-box my-4">
                        <div class="pro-icon-circle"><i class="fa-solid fa-microscope"></i></div>
                        <h4 class="pro-icon-title">State-of-the-Art Laboratory Testing</h4>
                        <p class="pro-icon-desc">Comprehensive chemical, physical, and eco-parameter testing of yarns, fabrics, garments, and technical textiles with NABL accreditation.</p>
                        <a href="#" class="pro-icon-link">Explore Testing Services <i class="fa-solid fa-arrow-right"></i></a>
                    </div>`;

                case 'pro_flipbox':
                    return `<div class="pro-flipbox my-4">
                        <div class="pro-flipbox-icon"><i class="fa-solid fa-award"></i></div>
                        <h4 class="pro-flipbox-title">Handloom Mark Scheme</h4>
                        <p class="pro-flipbox-desc">Guarantees genuine handloom products and protects artisans from powerloom imitation through unique encrypted holographic labelling.</p>
                    </div>`;

                case 'pro_alert':
                    return `<div class="pro-alert-box pro-alert-info my-4">
                        <i class="fa-solid fa-circle-info pro-alert-icon"></i>
                        <div class="pro-alert-content">
                            <h5>Official Ministry Advisory / Public Notice</h5>
                            <p>All registered stakeholders are requested to submit annual testing schedules and accreditation renewal applications before the designated deadline.</p>
                        </div>
                    </div>`;

                case 'pro_video':
                    return `<div class="pro-video-card my-4">
                        <div class="pro-video-placeholder" onclick="alert('Video URL can be configured in Page Settings or HTML view.')">
                            <div class="pro-video-play-btn"><i class="fa-solid fa-play"></i></div>
                            <h4 class="fw-bold mb-1">Watch Official Documentary: Ministry of Textiles</h4>
                            <p class="small text-white-50 mb-0">Click to preview multimedia presentation (1080p Full HD)</p>
                        </div>
                    </div>`;

                case 'pro_doc_card':
                    return `<div class="pro-doc-card my-3">
                        <div class="pro-doc-left">
                            <i class="fa-regular fa-file-pdf pro-doc-icon"></i>
                            <div>
                                <h4 class="pro-doc-title">Official Gazette Notification & Regulations 2025</h4>
                                <p class="pro-doc-meta">File Size: 1.45 MB | Published by Ministry of Textiles, Govt of India</p>
                            </div>
                        </div>
                        <a href="/assets/images/sample_doc.pdf" target="_blank" class="team-dl-btn text-nowrap">
                            <i class="fa-solid fa-download me-1"></i> Download PDF
                        </a>
                    </div>`;

                case 'pro_gallery':
                    return `<div class="pro-gallery-grid my-4">
                        <div class="pro-gallery-item">
                            <img src="/assets/images/banner1.jpg" class="pro-gallery-img" alt="Gallery Photo 1">
                            <p class="pro-gallery-caption">Advanced Testing Facility</p>
                        </div>
                        <div class="pro-gallery-item">
                            <img src="/assets/images/banner2.jpg" class="pro-gallery-img" alt="Gallery Photo 2">
                            <p class="pro-gallery-caption">Handloom Exhibition Hall</p>
                        </div>
                        <div class="pro-gallery-item">
                            <img src="/assets/images/banner3.jpg" class="pro-gallery-img" alt="Gallery Photo 3">
                            <p class="pro-gallery-caption">Skill Development Workshop</p>
                        </div>
                    </div>`;

                // 3. GOVERNMENT / TEXMIN COMPONENTS
                case 'about_layout':
                    return `<div class="about-page-layout my-4">
                        <div class="about-vision-col">
                            <div class="about-vision-card">
                                <p class="about-vision-text">To build state of the art manufacturing capabilities, foster innovation, design, and promote sustainable growth in textiles.</p>
                                <h3 class="about-vision-title">VISION</h3>
                            </div>
                        </div>
                        <div class="about-main-col">
                            <p class="about-lead-para">The Ministry of Textiles is responsible for policy formulation, planning, development, export promotion and facilitating the growth of the textile industry in India.</p>
                            <h3 class="about-mission-heading">MISSION OBJECTIVES</h3>
                            <ul class="about-mission-list">
                                <li>Foster research, technological upgradation, and quality standards.</li>
                                <li>Expand export competitiveness and market access globally.</li>
                                <li>Provide livelihood support to handloom weavers and handicraft artisans.</li>
                            </ul>
                        </div>
                    </div>`;

                case 'officer_card':
                    return `<div class="team-node-card my-4 mx-auto" style="max-width: 420px;">
                        <div class="team-avatar-wrap">
                            <img src="/assets/images/giriraj_singh.png" class="team-avatar-img" alt="Official">
                        </div>
                        <div class="team-node-role">DESIGNATION / PORTFOLIO</div>
                        <div class="team-node-name">Official Full Name</div>
                    </div>`;

                case 'gov_table':
                    return getWidgetHtml('dbim_data_table');

                case 'download_btn':
                    return `<div class="my-3">
                        <a href="/assets/images/sample_doc.pdf" target="_blank" class="team-dl-btn">
                            <i class="fa-regular fa-file-pdf me-2 text-danger"></i> OFFICIAL GAZETTE ORDER | 420.50 KB [PDF]
                        </a>
                    </div>`;

                case 'flowchart_node':
                    return `<div class="team-org-container my-4">
                        <div class="team-tree">
                            <div class="team-node-card">
                                <div class="team-avatar-wrap">
                                    <img src="/assets/images/giriraj_singh.png" class="team-avatar-img" alt="Minister">
                                </div>
                                <div class="team-node-role">HON'BLE MINISTER OF TEXTILES</div>
                                <div class="team-node-name">Shri Giriraj Singh</div>
                            </div>
                            <div class="team-tree-line"></div>
                            <div class="team-node-card">
                                <div class="team-avatar-wrap">
                                    <img src="/assets/images/Secretary-textiles-Png-Image.jpg" class="team-avatar-img" alt="Secretary">
                                </div>
                                <div class="team-node-role">SECRETARY, MINISTRY OF TEXTILES</div>
                                <div class="team-node-name">Smt. Neelam Shami Rao</div>
                            </div>
                        </div>
                    </div>`;

                case 'accordion':
                    return getWidgetHtml('dbim_faq_component');

                case 'acts_card':
                    return `<div class="acts-card my-3">
                        <div class="acts-card-top">
                            <h3 class="acts-card-title"><a href="#">Name of Organisation / Statutory Body / Act</a></h3>
                            <div class="acts-card-img-wrap" onclick="openImagePicker('replace', this.querySelector('img'))" title="Click to upload/change logo">
                                <img src="/assets/images/Textiles_Committee_Logo.png" class="acts-card-img" alt="Logo">
                            </div>
                        </div>
                        <p class="acts-card-desc">Detailed information, statutory description, functions, and key objectives of this department or regulation.</p>
                        <div class="acts-card-footer">
                            <a href="/assets/images/sample_doc.pdf" target="_blank" class="acts-pdf-badge">
                                <i class="fa-regular fa-file-pdf text-danger"></i> Official Gazette / Act PDF [Download]
                            </a>
                            <a href="#" class="acts-arrow-btn" title="View details"><i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>`;

                // 4. BASIC ELEMENTS
                case 'redirection_button':
                case 'dbim_button':
                case 'button':
                case 'cta_button':
                    return `<div class="dbim-button-wrapper my-3 position-relative" data-component="dbim_button" style="text-align: left;">
                        <!-- Floating Editor Control Toolbar -->
                        <div class="editor-btn-ctrl position-relative d-inline-flex flex-wrap align-items-center gap-1 p-1 mb-2 bg-white border rounded shadow-sm" style="font-size: 11px;">
                            <button type="button" class="btn btn-sm btn-danger py-0 px-2 editor-link-btn fw-bold" onclick="event.stopPropagation(); openLinkSettingsModal(this)" title="Edit Button Link & Settings">
                                <i class="fa-solid fa-link me-1"></i> Edit Link
                            </button>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-outline-secondary py-0 px-2 dropdown-toggle editor-link-btn" type="button" data-bs-toggle="dropdown" style="font-size: 11px;">
                                    <i class="fa-solid fa-palette me-1"></i> Style
                                </button>
                                <ul class="dropdown-menu shadow-sm" style="font-size: 12px; z-index: 2100;">
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimBtnStyle(this, 'primary')"><span class="badge me-2" style="background: #721835;">&nbsp;</span> Primary Burgundy</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimBtnStyle(this, 'outline')"><span class="badge border border-danger text-danger me-2">Outline</span> Burgundy Outline</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimBtnStyle(this, 'gold')"><span class="badge me-2" style="background: #d4af37; color:#000;">&nbsp;</span> Gold / Accent</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimBtnStyle(this, 'success')"><span class="badge bg-success me-2">&nbsp;</span> Green Success</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimBtnStyle(this, 'danger')"><span class="badge bg-danger me-2">&nbsp;</span> Red Alert</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimBtnStyle(this, 'dark')"><span class="badge bg-dark me-2">&nbsp;</span> Dark Charcoal</a></li>
                                </ul>
                            </div>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-outline-secondary py-0 px-2 dropdown-toggle editor-link-btn" type="button" data-bs-toggle="dropdown" style="font-size: 11px;">
                                    <i class="fa-solid fa-align-left me-1"></i> Align
                                </button>
                                <ul class="dropdown-menu shadow-sm" style="font-size: 12px; z-index: 2100;">
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimBtnAlign(this, 'left')"><i class="fa-solid fa-align-left me-2"></i> Left</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimBtnAlign(this, 'center')"><i class="fa-solid fa-align-center me-2"></i> Center</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimBtnAlign(this, 'right')"><i class="fa-solid fa-align-right me-2"></i> Right</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimBtnAlign(this, 'block')"><i class="fa-solid fa-arrows-left-right me-2"></i> Full Width</a></li>
                                </ul>
                            </div>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-outline-secondary py-0 px-2 dropdown-toggle editor-link-btn" type="button" data-bs-toggle="dropdown" style="font-size: 11px;">
                                    <i class="fa-solid fa-text-height me-1"></i> Size
                                </button>
                                <ul class="dropdown-menu shadow-sm" style="font-size: 12px; z-index: 2100;">
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimBtnSize(this, 'sm')">Small</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimBtnSize(this, 'md')">Medium (Regular)</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimBtnSize(this, 'lg')">Large</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 editor-link-btn" onclick="if(confirm('Delete this button?')) this.closest('.dbim-button-wrapper').remove()" title="Delete Button">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                        <div class="dbim-btn-container">
                            <a href="https://texmin.nic.in" target="_blank" rel="noopener noreferrer" class="btn dbim-custom-btn dbim-btn-primary rounded-pill px-4 py-2 fw-bold d-inline-flex align-items-center gap-2 shadow-sm" style="background: #721835; color: #ffffff; border: 2px solid #721835; font-size: 1.35rem; text-decoration: none; transition: all 0.2s ease;">
                                <span class="dbim-btn-text" contenteditable="true">Click Here to Apply / Learn More</span>
                                <i class="fa-solid fa-arrow-right dbim-btn-icon" style="font-size: 0.9em;"></i>
                            </a>
                        </div>
                    </div>`;

                case 'anchor_tag':
                case 'dbim_link':
                case 'link':
                    return `<div class="dbim-link-wrapper my-2 position-relative d-inline-block" data-component="dbim_link">
                        <!-- Floating Editor Control Toolbar -->
                        <div class="editor-link-ctrl position-relative d-inline-flex align-items-center gap-1 p-1 mb-1 bg-white border rounded shadow-sm" style="font-size: 11px;">
                            <button type="button" class="btn btn-sm btn-danger py-0 px-2 editor-link-btn fw-bold" onclick="event.stopPropagation(); openLinkSettingsModal(this)" title="Edit Link & Redirection">
                                <i class="fa-solid fa-link me-1"></i> Edit Link
                            </button>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-outline-secondary py-0 px-2 dropdown-toggle editor-link-btn" type="button" data-bs-toggle="dropdown" style="font-size: 11px;">
                                    <i class="fa-solid fa-palette me-1"></i> Style
                                </button>
                                <ul class="dropdown-menu shadow-sm" style="font-size: 12px; z-index: 2100;">
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimLinkStyle(this, 'classic')"><i class="fa-solid fa-underline me-2"></i> Classic Underline</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimLinkStyle(this, 'arrow')"><i class="fa-solid fa-arrow-right me-2"></i> Arrow Link (Read More &rarr;)</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimLinkStyle(this, 'badge')"><i class="fa-solid fa-tag me-2"></i> Pill Badge Link</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimLinkStyle(this, 'highlight')"><i class="fa-solid fa-highlighter me-2"></i> Highlight Box Link</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 editor-link-btn" onclick="if(confirm('Delete this link?')) this.closest('.dbim-link-wrapper').remove()" title="Delete Link">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                        <div class="dbim-link-container">
                            <a href="https://texmin.nic.in" target="_blank" rel="noopener noreferrer" class="dbim-custom-link fw-semibold d-inline-flex align-items-center gap-1" style="color: #721835; text-decoration: underline; text-underline-offset: 4px; font-size: 1.4rem; transition: color 0.15s ease;">
                                <span class="dbim-link-text" contenteditable="true">Official Portal & Guidelines</span>
                                <i class="fa-solid fa-arrow-up-right-from-square dbim-link-icon ms-1" style="font-size: 0.8em;"></i>
                            </a>
                        </div>
                    </div>`;

                case 'heading':
                    return '<h2 class="my-3 text-dark fw-bold">New Section Heading</h2>';
                case 'paragraph':
                    return '<p class="lead" style="font-size: 1.45rem; line-height: 1.8; color: #222;">Type your description paragraph here. You can highlight text to make it bold, link to documents, or copy typography styles using Format Painter.</p>';
                case 'bullet_list':
                    return `<ul style="font-size: 1.4rem; line-height: 1.8;">
                        <li>First key milestone or objective of the initiative.</li>
                        <li>Second policy item with essential information.</li>
                        <li>Third action item for citizens or stakeholders.</li>
                    </ul>`;
                case 'callout_box':
                    return `<div style="background: #fdf7fa; border-left: 4px solid #721835; padding: 20px 24px; border-radius: 6px; margin: 24px 0;">
                        <h4 style="color: #721835; font-weight: 700; margin-top: 0;">Official Note / Important Announcement</h4>
                        <p style="margin-bottom: 0; font-size: 1.35rem; color: #333;">Enter highlighted policy announcement or advisory note here.</p>
                    </div>`;
                case 'dbim_custom_image':
                case 'image':
                    return `<div class="dbim-custom-image-wrapper my-4 position-relative" data-component="dbim_custom_image" style="max-width: 480px; margin-left: auto; margin-right: auto; text-align: center;">
                        <!-- Floating Editor Control Toolbar -->
                        <div class="editor-img-ctrl position-relative d-inline-flex flex-wrap align-items-center justify-content-center gap-1 p-1 mb-2 bg-white border rounded shadow-sm" style="font-size: 11px;">
                            <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 editor-img-btn" onclick="openAvatarModal(this)" title="Change / Upload Photo">
                                <i class="fa-solid fa-camera me-1"></i> Change Image
                            </button>
                            <!-- Shape dropdown -->
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-outline-secondary py-0 px-2 dropdown-toggle editor-img-btn" type="button" data-bs-toggle="dropdown" style="font-size: 11px;">
                                    <i class="fa-solid fa-shapes me-1"></i> Shape
                                </button>
                                <ul class="dropdown-menu shadow-sm" style="font-size: 12px; z-index: 2100;">
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageShape(this, 'rounded')"><i class="fa-regular fa-square me-2"></i> Rounded (12px)</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageShape(this, 'circle')"><i class="fa-regular fa-circle me-2"></i> Circle (50%)</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageShape(this, 'square')"><i class="fa-solid fa-square me-2"></i> Square (0px)</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageShape(this, 'thumbnail')"><i class="fa-solid fa-border-top-left me-2"></i> Photo Frame</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageShape(this, 'pill')"><i class="fa-solid fa-capsules me-2"></i> Pill / Oval</a></li>
                                </ul>
                            </div>
                            <!-- Size dropdown -->
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-outline-secondary py-0 px-2 dropdown-toggle editor-img-btn" type="button" data-bs-toggle="dropdown" style="font-size: 11px;">
                                    <i class="fa-solid fa-up-right-and-down-left-from-center me-1"></i> Size
                                </button>
                                <ul class="dropdown-menu shadow-sm" style="font-size: 12px; z-index: 2100;">
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageSize(this, 'small')">Small (180px)</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageSize(this, 'medium')">Medium (340px)</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageSize(this, 'large')">Large (550px)</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageSize(this, 'full')">Full Width (100%)</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="openDbimImageSizeModal(this)">Custom Slider...</a></li>
                                </ul>
                            </div>
                            <!-- Alignment dropdown -->
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-outline-secondary py-0 px-2 dropdown-toggle editor-img-btn" type="button" data-bs-toggle="dropdown" style="font-size: 11px;">
                                    <i class="fa-solid fa-align-center me-1"></i> Align
                                </button>
                                <ul class="dropdown-menu shadow-sm" style="font-size: 12px; z-index: 2100;">
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageAlign(this, 'left')"><i class="fa-solid fa-align-left me-2"></i> Left</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageAlign(this, 'center')"><i class="fa-solid fa-align-center me-2"></i> Center</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageAlign(this, 'right')"><i class="fa-solid fa-align-right me-2"></i> Right</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 editor-img-btn" onclick="toggleDbimImageCaption(this)" title="Toggle Caption">
                                <i class="fa-regular fa-comment-dots"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 editor-img-btn" onclick="if(confirm('Remove this image?')) this.closest('.dbim-custom-image-wrapper').remove()" title="Delete Image">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>

                        <!-- Image Container -->
                        <div class="dbim-img-inner d-inline-block position-relative w-100">
                            <img src="/assets/images/Textiles_Committee_Logo.png" class="dbim-custom-img img-fluid" alt="Image" style="border-radius: 12px; box-shadow: 0 4px 14px rgba(0,0,0,0.08); max-height: 480px; object-fit: contain; cursor: pointer; transition: all 0.25s ease;" onclick="openAvatarModal(this)" title="Click to change photo">
                        </div>

                        <!-- Editable Caption (Optional) -->
                        <figcaption class="dbim-img-caption text-muted small mt-2" contenteditable="true" style="font-size: 1.25rem; line-height: 1.4;">Textiles Committee Official Facility & Research Infrastructure</figcaption>
                    </div>`;

                case 'dbim_image_with_text':
                case 'image_with_text':
                    return `<div class="dbim-image-with-text-wrapper my-4 p-4 border rounded shadow-sm bg-white position-relative" data-component="dbim_image_with_text" style="border-color: #ebd0de !important; border-radius: 12px;">
                        <!-- Editor Control Toolbar -->
                        <div class="editor-img-ctrl d-flex flex-wrap align-items-center justify-content-between gap-2 pb-3 mb-3 border-bottom" style="font-size: 11.5px;">
                            <span class="badge text-white" style="background: #721835; font-size: 11px;">Image with Text Section</span>
                            <div class="d-inline-flex flex-wrap align-items-center gap-1">
                                <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 editor-img-btn" onclick="openAvatarModal(this)" title="Change / Upload Photo">
                                    <i class="fa-solid fa-camera me-1"></i> Change Image
                                </button>
                                <!-- Flip Layout -->
                                <button type="button" class="btn btn-sm btn-outline-dark py-0 px-2 editor-img-btn" onclick="flipDbimImageTextLayout(this)" title="Toggle Image on Left vs Right">
                                    <i class="fa-solid fa-arrow-right-arrow-left me-1"></i> Flip Layout
                                </button>
                                <!-- Shape dropdown -->
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-sm btn-outline-secondary py-0 px-2 dropdown-toggle editor-img-btn" type="button" data-bs-toggle="dropdown" style="font-size: 11px;">
                                        <i class="fa-solid fa-shapes me-1"></i> Image Shape
                                    </button>
                                    <ul class="dropdown-menu shadow-sm" style="font-size: 12px; z-index: 2100;">
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageShape(this, 'rounded')"><i class="fa-regular fa-square me-2"></i> Rounded (12px)</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageShape(this, 'circle')"><i class="fa-regular fa-circle me-2"></i> Circle Avatar (50%)</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageShape(this, 'square')"><i class="fa-solid fa-square me-2"></i> Sharp Square</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageShape(this, 'thumbnail')"><i class="fa-solid fa-border-top-left me-2"></i> Photo Frame</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageShape(this, 'pill')"><i class="fa-solid fa-capsules me-2"></i> Pill / Oval</a></li>
                                    </ul>
                                </div>
                                <!-- Size Proportion dropdown -->
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-sm btn-outline-secondary py-0 px-2 dropdown-toggle editor-img-btn" type="button" data-bs-toggle="dropdown" style="font-size: 11px;">
                                        <i class="fa-solid fa-up-right-and-down-left-from-center me-1"></i> Proportions
                                    </button>
                                    <ul class="dropdown-menu shadow-sm" style="font-size: 12px; z-index: 2100;">
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageTextProportion(this, '35')">35% Image / 65% Text (Standard)</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageTextProportion(this, '50')">50% Image / 50% Text (Equal)</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="setDbimImageTextProportion(this, '25')">25% Image / 75% Text (Compact)</a></li>
                                    </ul>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 editor-img-btn" onclick="if(confirm('Delete this section?')) this.closest('.dbim-image-with-text-wrapper').remove()" title="Delete Section">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Row Container with Left Image & Right Text -->
                        <div class="row align-items-center g-4 dbim-iwt-row">
                            <!-- Image Column -->
                            <div class="col-lg-4 col-md-5 dbim-iwt-img-col text-center">
                                <div class="dbim-img-inner d-inline-block position-relative w-100">
                                    <img src="/assets/images/Textiles_Committee_Logo.png" class="dbim-custom-img img-fluid w-100" alt="Featured Media" style="border-radius: 12px; max-height: 380px; object-fit: contain; cursor: pointer; box-shadow: 0 4px 14px rgba(114, 24, 53, 0.08); transition: all 0.25s ease;" onclick="openAvatarModal(this)" title="Click to replace photo">
                                    <button type="button" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 m-2 p-0 rounded-circle editor-img-btn" style="width: 26px; height: 26px; font-size: 11px; line-height: 26px;" onclick="openAvatarModal(this)" title="Change Photo">
                                        <i class="fa-solid fa-camera"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Text Column -->
                            <div class="col-lg-8 col-md-7 dbim-iwt-text-col">
                                <span class="badge mb-2" contenteditable="true" style="background: #ebd0de; color: #721835; font-size: 1.15rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; padding: 4px 12px; border-radius: 20px;">STATUTORY MISSION</span>
                                <h3 class="fw-bold mb-2" contenteditable="true" style="color: #1e1b24; font-size: 2.1rem; line-height: 1.3;">Ensuring Quality Excellence across Indian Textiles & Machinery</h3>
                                <p class="lead text-secondary mb-3" contenteditable="true" style="font-size: 1.35rem; line-height: 1.65; color: #4b5563;">
                                    The Textiles Committee operates 19 state-of-the-art testing laboratories accredited under NABL (ISO/IEC 17025) providing comprehensive physical, chemical, eco-parameters and specialized technical textile testing services across India.
                                </p>
                                <div class="d-flex align-items-center gap-2 mt-3">
                                    <a href="#" class="btn btn-sm text-white px-3 py-2 fw-semibold" style="background: #721835; border-radius: 4px; font-size: 1.25rem; text-decoration: none;" contenteditable="true">
                                        <i class="fa-solid fa-arrow-right me-1"></i> Explore Services
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-dark px-3 py-2 fw-semibold" style="border-radius: 4px; font-size: 1.25rem; text-decoration: none;" contenteditable="true">
                                        <i class="fa-regular fa-file-pdf me-1 text-danger"></i> Download Brochure
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>`;

                case 'dbim_book_magazine_grid':
                    return `
<div class="dbim-book-magazine-section my-5 position-relative" data-component="dbim_book_magazine_grid" style="font-family: 'Noto Sans', sans-serif;">
    <!-- Visual Editor Component Toolbar -->
    <div class="editor-book-grid-ctrl mb-4 p-3 bg-white border rounded shadow-sm d-flex flex-wrap align-items-center justify-content-between gap-3" style="border-color: #ebd0de !important; background: #fffcfd !important;">
        <div class="d-flex align-items-center gap-2">
            <span class="badge" style="background: #721835; font-size: 1.15rem; padding: 6px 12px;"><i class="fa-solid fa-book-open me-1"></i> PUBLICATIONS & MAGAZINES</span>
            <span class="text-muted small fw-semibold">DBIM Compliant Book Cards Grid</span>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-success fw-bold editor-book-btn" onclick="addBookCard(this)" title="Add a new Book / Magazine Card"><i class="fa-solid fa-plus me-1"></i> Add Book Card</button>
            <div class="btn-group btn-group-sm editor-book-btn" role="group">
                <button type="button" class="btn btn-outline-secondary" onclick="setBookGridCols(this, 2)" title="2 Columns per row"><i class="fa-solid fa-table-columns"></i> 2 Cols</button>
                <button type="button" class="btn btn-outline-secondary" onclick="setBookGridCols(this, 3)" title="3 Columns per row"><i class="fa-solid fa-table-cells"></i> 3 Cols</button>
                <button type="button" class="btn btn-outline-secondary active" onclick="setBookGridCols(this, 4)" title="4 Columns per row"><i class="fa-solid fa-grip"></i> 4 Cols</button>
            </div>
        </div>
    </div>

    <!-- Cards Grid Container (English only, no download button, matching reference Image 2) -->
    <div class="row g-4 dbim-book-grid" data-cols="4">
` + renderBookCardItemHtml({
    title: 'Understanding WTO',
    coverImg: '/assets/images/book_understanding_wto.png'
}) + renderBookCardItemHtml({
    title: 'TRIPS',
    coverImg: '/assets/images/book_trips.png'
}) + renderBookCardItemHtml({
    title: 'Procedure for IPR protection through GI Act',
    coverImg: '/assets/images/book_ipr_gi_act.png'
}) + renderBookCardItemHtml({
    title: 'Market for Textiles & Clothing 2015',
    coverImg: '/assets/images/book_market_textiles_2015.png'
}) + renderBookCardItemHtml({
    title: 'Demystifying Tariffs & Non-Tariff Barriers (NTBs)',
    coverImg: '/assets/images/book_demystifying_tariffs.png'
}) + `
    </div>
</div>`;

                case 'dbim_photo_gallery':
                    return `
<div class="dbim-photo-gallery-section my-5 position-relative" data-component="dbim_photo_gallery" style="font-family: 'Noto Sans', sans-serif;">
    <!-- Visual Editor Component Toolbar -->
    <div class="editor-photo-grid-ctrl mb-4 p-3 bg-white border rounded shadow-sm d-flex flex-wrap align-items-center justify-content-between gap-3" style="border-color: #ebd0de !important; background: #fffcfd !important;">
        <div class="d-flex align-items-center gap-2">
            <span class="badge" style="background: #721835; font-size: 1.15rem; padding: 6px 12px;"><i class="fa-solid fa-camera-retro me-1"></i> PHOTO GALLERY</span>
            <span class="text-muted small fw-semibold">Interactive Image Gallery with Album Detail Views</span>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-success fw-bold editor-photo-btn" onclick="addPhotoCard(this)" title="Add a new Album"><i class="fa-solid fa-plus me-1"></i> Add Album</button>
            <button type="button" class="btn btn-sm btn-outline-dark fw-bold editor-photo-btn" onclick="toggleEditorAlbumView(this)" title="Toggle Albums List / Album Photos"><i class="fa-solid fa-repeat me-1"></i> Toggle Albums / Photos</button>
            <div class="btn-group btn-group-sm editor-photo-btn" role="group">
                <button type="button" class="btn btn-outline-secondary" onclick="setPhotoGridCols(this, 2)" title="2 Columns per row"><i class="fa-solid fa-table-columns"></i> 2 Cols</button>
                <button type="button" class="btn btn-outline-secondary active" onclick="setPhotoGridCols(this, 3)" title="3 Columns per row"><i class="fa-solid fa-table-cells"></i> 3 Cols</button>
                <button type="button" class="btn btn-outline-secondary" onclick="setPhotoGridCols(this, 4)" title="4 Columns per row"><i class="fa-solid fa-grip"></i> 4 Cols</button>
            </div>
        </div>
    </div>

    <!-- 1. ALBUMS GRID VIEW (Overview of all Albums) -->
    <div class="dbim-albums-view">
        <!-- Filter & Search Toolbar (Image 1 reference) -->
        <div class="dbim-gallery-filter-bar mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="dbim-search-box position-relative" style="min-width: 260px; max-width: 380px; width: 100%;">
                <i class="fa-solid fa-magnifying-glass position-absolute start-0 top-50 translate-middle-y ms-3" style="color: #c4387a; font-size: 1.25rem;"></i>
                <input type="text" class="form-control dbim-gallery-search" placeholder="Search..." oninput="filterPhotoGallery(this)" style="padding-left: 40px; border: 1.5px solid #c4387a; border-radius: 4px; font-size: 1.25rem; height: 38px;">
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2 ms-auto">
                <div class="dbim-filter-dropdown-wrap">
                    <div class="input-group" style="border: 1.5px solid #c4387a; border-radius: 4px; overflow: hidden; background: #fff;">
                        <span class="input-group-text bg-transparent border-0 pe-1" style="color: #c4387a;"><i class="fa-solid fa-arrow-down-wide-short"></i></span>
                        <select class="form-select border-0 shadow-none dbim-gallery-sort" onchange="sortPhotoGallery(this)" style="color: #1e1b24; font-weight: 500; font-size: 1.25rem; height: 38px; padding-left: 4px; cursor: pointer;">
                            <option value="newest">Sort by</option>
                            <option value="newest">Sort by: Newest</option>
                            <option value="oldest">Sort by: Oldest</option>
                            <option value="title_asc">Sort by: Title (A-Z)</option>
                            <option value="title_desc">Sort by: Title (Z-A)</option>
                        </select>
                    </div>
                </div>
                <div class="dbim-filter-dropdown-wrap">
                    <div class="input-group" style="border: 1.5px solid #c4387a; border-radius: 4px; overflow: hidden; background: #fff;">
                        <span class="input-group-text bg-transparent border-0 pe-1" style="color: #c4387a;"><i class="fa-solid fa-sliders"></i></span>
                        <select class="form-select border-0 shadow-none dbim-gallery-cat" onchange="filterPhotoCategory(this)" style="color: #1e1b24; font-weight: 500; font-size: 1.25rem; height: 38px; padding-left: 4px; cursor: pointer;">
                            <option value="all">Category</option>
                            <option value="all">All Categories</option>
                            <option value="Convocations">Convocations</option>
                            <option value="Conclaves">Conclaves</option>
                            <option value="Summits">Summits & Seminars</option>
                            <option value="Ceremonies">Ceremonies</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards Grid Container -->
        <div class="row g-4 dbim-photo-grid" data-cols="3">
` + renderPhotoCardItemHtml({
    title: 'NIFT CONVOCATION 2026',
    date: '31.08.2026',
    itemsCount: '14',
    category: 'Convocations',
    slug: 'nift-convocation-2026',
    imgUrl: '/assets/images/gallery_nift_convocation.png'
}) + renderPhotoCardItemHtml({
    title: '1st Annual Conclave of IIHT',
    date: '12.08.2026',
    itemsCount: '19',
    category: 'Conclaves',
    slug: '1st-annual-conclave-of-iiht',
    imgUrl: '/assets/images/gallery_iiht_conclave.png'
}) + renderPhotoCardItemHtml({
    title: 'National Handloom Designers Conclave',
    date: '10.08.2026',
    itemsCount: '20',
    category: 'Conclaves',
    slug: 'national-handloom-designers-conclave',
    imgUrl: '/uploads/pages/page_1792396127_6ad5cb5fbebc2.jpeg'
}) + renderPhotoCardItemHtml({
    title: 'Textiles Summit',
    date: '24.06.2026',
    itemsCount: '12',
    category: 'Summits',
    slug: 'textiles-summit',
    imgUrl: '/assets/images/gallery_bharat_tex_ceremony.png'
}) + renderPhotoCardItemHtml({
    title: 'New Age Fibres - National Seminar',
    date: '19.05.2026',
    itemsCount: '15',
    category: 'Summits',
    slug: 'new-age-fibres-national-seminar',
    imgUrl: '/assets/images/gallery_summit_awards.png'
}) + renderPhotoCardItemHtml({
    title: 'Vice President Inaugurates IIHT in Salem',
    date: '27.02.2026',
    itemsCount: '18',
    category: 'Ceremonies',
    slug: 'vice-president-inaugurates-iiht-in-salem',
    imgUrl: '/assets/images/gallery_delegates_group.png'
}) + `
        </div>
    </div>

    <!-- 2. ALBUM DETAIL VIEW (Image 2 reference) -->
    <div class="dbim-album-detail-view" style="display: none;">
        <!-- Top Back Button -->
        <div class="mb-3">
            <button type="button" class="btn btn-outline-dark btn-sm fw-bold dbim-back-to-albums-btn" onclick="closePhotoAlbum(this)">
                <i class="fa-solid fa-arrow-left me-2"></i>Back to All Photo Albums
            </button>
        </div>

        <!-- Event Date Header -->
        <div class="dbim-album-detail-date text-muted fw-semibold mb-1" style="font-size: 1.35rem;">
            <i class="fa-regular fa-calendar-days me-2" style="color: #721835;"></i>
            <span class="dbim-album-date-text" contenteditable="true">31.08.2026</span>
        </div>

        <!-- Event Title Header -->
        <h2 class="dbim-album-detail-title fw-bold text-dark text-uppercase mb-4" style="font-size: 2.2rem; letter-spacing: 0.5px; border-bottom: 2px solid #f0e6ec; padding-bottom: 12px;">
            <span class="dbim-album-title-text" contenteditable="true">NIFT CONVOCATION 2026</span>
        </h2>

        <!-- Admin Album Controls -->
        <div class="editor-album-ctrl mb-4 p-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between" style="border-color: #ebd0de !important;">
            <span class="text-muted small fw-semibold"><i class="fa-solid fa-images me-1 text-primary"></i> Album Photos Manager</span>
            <button type="button" class="btn btn-sm btn-success fw-bold editor-album-photo-btn" onclick="addPhotoToAlbum(this)"><i class="fa-solid fa-plus me-1"></i> Add Photo to Album</button>
        </div>

        <!-- Subgrid for NIFT CONVOCATION 2026 (11 authentic photos from Image 2) -->
        <div class="row g-4 dbim-album-subgrid dbim-album-photos-grid" data-album-slug="nift-convocation-2026">
` + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/nift_img_1.jpg', title: 'NIFT Convocation 2026 - Photo 1' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/nift_img_2.jpg', title: 'NIFT Convocation 2026 - Photo 2' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/nift_img_3.jpg', title: 'NIFT Convocation 2026 - Photo 3' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/nift_img_4.jpg', title: 'NIFT Convocation 2026 - Photo 4' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/nift_img_5.jpg', title: 'NIFT Convocation 2026 - Photo 5' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/nift_img_6.jpg', title: 'NIFT Convocation 2026 - Photo 6' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/nift_img_7.jpg', title: 'NIFT Convocation 2026 - Photo 7' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/nift_img_8.jpg', title: 'NIFT Convocation 2026 - Photo 8' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/nift_img_9.jpg', title: 'NIFT Convocation 2026 - Photo 9' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/nift_img_10.jpg', title: 'NIFT Convocation 2026 - Photo 10' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/nift_img_11.jpg', title: 'NIFT Convocation 2026 - Photo 11' })
+ `
        </div>

        <!-- Subgrid for 1st Annual Conclave of IIHT -->
        <div class="row g-4 dbim-album-subgrid dbim-album-photos-grid" data-album-slug="1st-annual-conclave-of-iiht" style="display: none;">
` + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/gallery_iiht_conclave.png', title: '1st Annual Conclave of IIHT - Photo 1' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/banner3_nift.png', title: '1st Annual Conclave of IIHT - Photo 2' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/banner4_nift2.png', title: '1st Annual Conclave of IIHT - Photo 3' })
+ `
        </div>

        <!-- Subgrid for National Handloom Designers Conclave -->
        <div class="row g-4 dbim-album-subgrid dbim-album-photos-grid" data-album-slug="national-handloom-designers-conclave" style="display: none;">
` + renderAlbumPhotoItemHtml({ imgUrl: '/uploads/pages/page_1792396127_6ad5cb5fbebc2.jpeg', title: 'Designers Conclave - Photo 1' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/gallery_designers_conclave.png', title: 'Designers Conclave - Photo 2' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/gallery_bharat_tex_ceremony.png', title: 'Designers Conclave - Photo 3' })
+ `
        </div>

        <!-- Subgrid for Textiles Summit -->
        <div class="row g-4 dbim-album-subgrid dbim-album-photos-grid" data-album-slug="textiles-summit" style="display: none;">
` + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/gallery_bharat_tex_ceremony.png', title: 'Textiles Summit - Photo 1' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/gallery_summit_awards.png', title: 'Textiles Summit - Photo 2' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/gallery_delegates_group.png', title: 'Textiles Summit - Photo 3' })
+ `
        </div>

        <!-- Subgrid for New Age Fibres - National Seminar -->
        <div class="row g-4 dbim-album-subgrid dbim-album-photos-grid" data-album-slug="new-age-fibres-national-seminar" style="display: none;">
` + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/gallery_summit_awards.png', title: 'New Age Fibres - Photo 1' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/gallery_bharat_tex_ceremony.png', title: 'New Age Fibres - Photo 2' })
+ `
        </div>

        <!-- Subgrid for Vice President Inaugurates IIHT in Salem -->
        <div class="row g-4 dbim-album-subgrid dbim-album-photos-grid" data-album-slug="vice-president-inaugurates-iiht-in-salem" style="display: none;">
` + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/gallery_delegates_group.png', title: 'Salem IIHT Inauguration - Photo 1' })
  + renderAlbumPhotoItemHtml({ imgUrl: '/assets/images/gallery_iiht_conclave.png', title: 'Salem IIHT Inauguration - Photo 2' })
+ `
        </div>
    </div>
</div>`;

                case 'dbim_video_gallery':
                    return `
<div class="dbim-video-gallery-section my-5 position-relative" data-component="dbim_video_gallery" style="font-family: 'Noto Sans', sans-serif;">
    <!-- Visual Editor Component Toolbar -->
    <div class="editor-video-grid-ctrl mb-4 p-3 bg-white border rounded shadow-sm d-flex flex-wrap align-items-center justify-content-between gap-3" style="border-color: #ebd0de !important; background: #fffcfd !important;">
        <div class="d-flex align-items-center gap-2">
            <span class="badge" style="background: #721835; font-size: 1.15rem; padding: 6px 12px;"><i class="fa-solid fa-circle-play me-1"></i> VIDEO GALLERY</span>
            <span class="text-muted small fw-semibold">Interactive Video Showcase with Player Controls</span>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-success fw-bold editor-video-btn" onclick="addVideoCard(this)" title="Add a new Video Item"><i class="fa-solid fa-plus me-1"></i> Add Video Item</button>
            <div class="btn-group btn-group-sm editor-video-btn" role="group">
                <button type="button" class="btn btn-outline-secondary" onclick="setVideoGridCols(this, 2)" title="2 Columns per row"><i class="fa-solid fa-table-columns"></i> 2 Cols</button>
                <button type="button" class="btn btn-outline-secondary active" onclick="setVideoGridCols(this, 3)" title="3 Columns per row"><i class="fa-solid fa-table-cells"></i> 3 Cols</button>
                <button type="button" class="btn btn-outline-secondary" onclick="setVideoGridCols(this, 4)" title="4 Columns per row"><i class="fa-solid fa-grip"></i> 4 Cols</button>
            </div>
        </div>
    </div>

    <!-- Filter & Sort Toolbar (Image 2 reference) -->
    <div class="dbim-gallery-filter-bar mb-4 d-flex flex-wrap align-items-center justify-content-end gap-2">
        <div class="dbim-filter-dropdown-wrap">
            <div class="input-group" style="border: 1.5px solid #c4387a; border-radius: 4px; overflow: hidden; background: #fff;">
                <span class="input-group-text bg-transparent border-0 pe-1" style="color: #c4387a;"><i class="fa-solid fa-arrow-down-wide-short"></i></span>
                <select class="form-select border-0 shadow-none dbim-video-sort" onchange="sortVideoGallery(this)" style="color: #1e1b24; font-weight: 500; font-size: 1.25rem; height: 38px; padding-left: 4px; cursor: pointer;">
                    <option value="newest">Sort by</option>
                    <option value="newest">Sort by: Newest</option>
                    <option value="oldest">Sort by: Oldest</option>
                    <option value="title_asc">Sort by: Title (A-Z)</option>
                </select>
            </div>
        </div>
        <div class="dbim-filter-dropdown-wrap">
            <div class="input-group" style="border: 1.5px solid #c4387a; border-radius: 4px; overflow: hidden; background: #fff;">
                <span class="input-group-text bg-transparent border-0 pe-1" style="color: #c4387a;"><i class="fa-solid fa-sliders"></i></span>
                <select class="form-select border-0 shadow-none dbim-video-cat" onchange="filterVideoCategory(this)" style="color: #1e1b24; font-weight: 500; font-size: 1.25rem; height: 38px; padding-left: 4px; cursor: pointer;">
                    <option value="all">Category</option>
                    <option value="all">All Categories</option>
                    <option value="Handloom">Handloom & Heritage</option>
                    <option value="Schemes">Schemes & Initiatives</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Cards Grid Container -->
    <div class="row g-4 dbim-video-grid" data-cols="3">
` + renderVideoCardItemHtml({
    title: '12 th National Handloom Day',
    date: '07.08.2026',
    duration: '2:14',
    category: 'Handloom',
    thumbnailUrl: '/assets/images/video_handloom_day.png'
}) + renderVideoCardItemHtml({
    title: 'Samarth Yojna',
    date: '01.02.2026',
    duration: '3:00',
    category: 'Schemes',
    thumbnailUrl: '/assets/images/video_samarth_yojna.png'
}) + `
    </div>
</div>`;

                case 'dbim_presentation_events':
                    return `
<div class="dbim-presentation-events-section my-5 position-relative" data-component="dbim_presentation_events" style="font-family: 'Noto Sans', sans-serif;">
    <!-- Visual Editor Component Toolbar -->
    <div class="editor-pres-grid-ctrl mb-4 p-3 bg-white border rounded shadow-sm d-flex flex-wrap align-items-center justify-content-between gap-3" style="border-color: #ebd0de !important; background: #fffcfd !important;">
        <div class="d-flex align-items-center gap-2">
            <span class="badge" style="background: #721835; font-size: 1.15rem; padding: 6px 12px;"><i class="fa-solid fa-person-chalkboard me-1"></i> PRESENTATIONS & EVENTS</span>
            <span class="text-muted small fw-semibold">Seminar Sessions, Slide Shows & Technical Events</span>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-success fw-bold editor-pres-btn" onclick="addPresCard(this)" title="Add a new Presentation Card"><i class="fa-solid fa-plus me-1"></i> Add Presentation Card</button>
            <div class="btn-group btn-group-sm editor-pres-btn" role="group">
                <button type="button" class="btn btn-outline-secondary" onclick="setPresGridCols(this, 2)" title="2 Columns per row"><i class="fa-solid fa-table-columns"></i> 2 Cols</button>
                <button type="button" class="btn btn-outline-secondary active" onclick="setPresGridCols(this, 3)" title="3 Columns per row"><i class="fa-solid fa-table-cells"></i> 3 Cols</button>
                <button type="button" class="btn btn-outline-secondary" onclick="setPresGridCols(this, 4)" title="4 Columns per row"><i class="fa-solid fa-grip"></i> 4 Cols</button>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar (Image 3 reference) -->
    <div class="dbim-gallery-filter-bar mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="dbim-search-box position-relative" style="min-width: 260px; max-width: 380px; width: 100%;">
            <i class="fa-solid fa-magnifying-glass position-absolute start-0 top-50 translate-middle-y ms-3" style="color: #c4387a; font-size: 1.25rem;"></i>
            <input type="text" class="form-control dbim-pres-search" placeholder="Search..." oninput="filterPresGallery(this)" style="padding-left: 40px; border: 1.5px solid #c4387a; border-radius: 4px; font-size: 1.25rem; height: 38px;">
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2 ms-auto">
            <div class="dbim-filter-dropdown-wrap">
                <div class="input-group" style="border: 1.5px solid #c4387a; border-radius: 4px; overflow: hidden; background: #fff;">
                    <span class="input-group-text bg-transparent border-0 pe-1" style="color: #c4387a;"><i class="fa-solid fa-arrow-down-wide-short"></i></span>
                    <select class="form-select border-0 shadow-none dbim-pres-sort" onchange="sortPresGallery(this)" style="color: #1e1b24; font-weight: 500; font-size: 1.25rem; height: 38px; padding-left: 4px; cursor: pointer;">
                        <option value="newest">Sort by</option>
                        <option value="newest">Sort by: Newest</option>
                        <option value="oldest">Sort by: Oldest</option>
                        <option value="title_asc">Sort by: Title (A-Z)</option>
                    </select>
                </div>
            </div>
            <div class="dbim-filter-dropdown-wrap">
                <div class="input-group" style="border: 1.5px solid #c4387a; border-radius: 4px; overflow: hidden; background: #fff;">
                    <span class="input-group-text bg-transparent border-0 pe-1" style="color: #c4387a;"><i class="fa-solid fa-sliders"></i></span>
                    <select class="form-select border-0 shadow-none dbim-pres-cat" onchange="filterPresCategory(this)" style="color: #1e1b24; font-weight: 500; font-size: 1.25rem; height: 38px; padding-left: 4px; cursor: pointer;">
                        <option value="all">Category</option>
                        <option value="all">All Categories</option>
                        <option value="Plenary">Plenary Sessions</option>
                        <option value="Technical">Technical Sessions</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards Grid Container -->
    <div class="row g-4 dbim-pres-grid" data-cols="3">
` + renderPresentationCardItemHtml({
    title: 'Inagural Session',
    date: '12.08.2026',
    category: 'Plenary',
    btnText: 'VIEW',
    imgUrl: '/assets/images/pres_inaugural_session.png'
}) + renderPresentationCardItemHtml({
    title: 'Session 01',
    date: '12.08.2026',
    category: 'Technical',
    btnText: 'VIEW ALL',
    imgUrl: '/assets/images/pres_session_01.png'
}) + renderPresentationCardItemHtml({
    title: 'Session 02',
    date: '12.08.2026',
    category: 'Technical',
    btnText: 'VIEW ALL',
    imgUrl: '/assets/images/pres_session_02.png'
}) + `
    </div>
</div>`;

                case 'divider':
                    return '<hr style="border-top: 2px dashed #c499b3; margin: 30px 0;">';

                default:
                    return '';
            }
        }

        // Switch Pro Tab Functionality
        function switchProTab(wrapperId, index) {
            const wrapper = document.getElementById(wrapperId);
            if (!wrapper) return;
            const tabs = wrapper.querySelectorAll('.pro-tab-item');
            const panes = wrapper.querySelectorAll('.pro-tab-pane');

            tabs.forEach((tab, i) => {
                if (i === index) {
                    tab.classList.add('active');
                } else {
                    tab.classList.remove('active');
                }
            });

            panes.forEach((pane, i) => {
                if (i === index) {
                    pane.classList.add('active');
                } else {
                    pane.classList.remove('active');
                }
            });
        }

        // ============================================================
        // SAVE PAGE AJAX
        // ============================================================
        function saveVisualPage() {
            // Clean up any temporary editor classes before saving
            document.querySelectorAll('#liveCanvas .section-hover-active').forEach(el => el.classList.remove('section-hover-active'));

            // Ensure Photo Gallery default state is always the Albums Overview before saving
            document.querySelectorAll('#liveCanvas .dbim-photo-gallery-section').forEach(sec => {
                sec.classList.remove('viewing-album');
                const albumsView = sec.querySelector('.dbim-albums-view');
                const detailView = sec.querySelector('.dbim-album-detail-view');
                if (albumsView) albumsView.style.display = 'block';
                if (detailView) detailView.style.display = 'none';
            });

            const btn = document.getElementById('savePageBtn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Saving...';
            btn.disabled = true;

            const contentHtml = document.getElementById('liveCanvas').innerHTML;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('admin.pages.visual-editor.save', $page->id) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    content_en: contentHtml,
                    content_hi: contentHtml
                })
            })
            .then(res => res.json())
            .then(data => {
                btn.innerHTML = originalText;
                btn.disabled = false;

                const indicator = document.getElementById('saveIndicator');
                indicator.style.display = 'flex';
                setTimeout(() => {
                    indicator.style.display = 'none';
                }, 3000);
            })
            .catch(err => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert('Error saving changes: ' + err.message);
            });
        }

        // Ctrl+S Keyboard Shortcut to Save
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                saveVisualPage();
            }
        });

        // ============================================================
        // IMAGE PICKER & MEDIA LIBRARY MODAL
        // ============================================================
        let imagePickerMode = 'insert';
        let targetImageElement = null;

        function openImagePicker(mode = 'insert', targetImg = null) {
            imagePickerMode = mode;
            targetImageElement = targetImg;

            const modalTitle = document.getElementById('imagePickerModalLabel');
            if (mode === 'replace') {
                modalTitle.innerText = 'Change / Replace Photo';
            } else {
                modalTitle.innerText = 'Insert Photo / Image';
            }

            const modalEl = document.getElementById('imagePickerModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }

        document.getElementById('liveCanvas').addEventListener('click', function(e) {
            if (isFormatPainterActive) return; // painter takes priority
            const imgTarget = e.target.closest('img') || (e.target.closest('.team-avatar-wrap') ? e.target.closest('.team-avatar-wrap').querySelector('img') : null);
            if (imgTarget) {
                e.preventDefault();
                e.stopPropagation();
                openImagePicker('replace', imgTarget);
            }
        });

        function selectImage(url) {
            if (imagePickerMode === 'replace' && targetImageElement) {
                targetImageElement.src = url;
            } else {
                const canvas = document.getElementById('liveCanvas');
                canvas.focus();
                const imgHtml = `<div class="text-center my-4"><img src="${url}" class="img-fluid rounded shadow-sm" style="max-height: 420px; object-fit: cover;" alt="Image"></div>`;
                document.execCommand('insertHTML', false, imgHtml);
            }

            const modalEl = document.getElementById('imagePickerModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        }

        function insertCustomUrl() {
            const input = document.getElementById('customImageUrlInput');
            const url = input.value.trim();
            if (url) {
                selectImage(url);
                input.value = '';
            } else {
                alert('Please enter a valid image URL');
            }
        }

        function uploadNewImage(file) {
            if (!file) return;

            const uploadStatus = document.getElementById('uploadProgressStatus');
            uploadStatus.classList.remove('d-none');
            uploadStatus.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i> Uploading image...';

            const formData = new FormData();
            formData.append('image', file);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('admin.pages.upload-image') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                uploadStatus.classList.add('d-none');
                if (data.success && data.url) {
                    selectImage(data.url);
                } else {
                    alert('Upload failed: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(err => {
                uploadStatus.classList.add('d-none');
                alert('Error uploading file: ' + err.message);
            });
        }

        function filterMediaGallery(term) {
            term = term.toLowerCase();
            document.querySelectorAll('.media-gallery-item').forEach(item => {
                const name = item.getAttribute('data-name').toLowerCase();
                if (name.includes(term)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // ============================================================
        // PDF UPLOADER MANAGEMENT
        // ============================================================
        let targetPdfLinkElement = null;

        function openPdfUploader(targetLink = null) {
            targetPdfLinkElement = targetLink;
            const modalEl = document.getElementById('pdfUploaderModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }

        function uploadNewPdf(file) {
            if (!file) return;

            const uploadStatus = document.getElementById('pdfUploadProgressStatus');
            uploadStatus.classList.remove('d-none');
            uploadStatus.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i> Uploading PDF document...';

            const formData = new FormData();
            formData.append('pdf', file);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('admin.pages.upload-pdf') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                uploadStatus.classList.add('d-none');
                if (data.success && data.url) {
                    if (targetPdfLinkElement) {
                        targetPdfLinkElement.href = data.url;
                        targetPdfLinkElement.innerHTML = `<i class="fa-solid fa-download text-danger me-2"></i> ${data.title.toUpperCase()} | ${data.fileSize} [PDF]`;
                        targetPdfLinkElement = null;
                        showToast('PDF file uploaded & linked to component!');
                    } else {
                        insertPdfBadge(data.title, data.url, data.fileSize);
                    }
                    const modalEl = document.getElementById('pdfUploaderModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                } else {
                    alert('PDF upload failed: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(err => {
                uploadStatus.classList.add('d-none');
                alert('Error uploading PDF: ' + err.message);
            });
        }

        function insertPdfBadge(title, url, size) {
            const canvas = document.getElementById('liveCanvas');
            canvas.focus();
            const badgeHtml = `<div class="my-3">
                <a href="${url}" target="_blank" class="team-dl-btn">
                    <i class="fa-regular fa-file-pdf me-2 text-danger"></i> ${title.toUpperCase()} | ${size} [PDF]
                </a>
            </div>`;
            document.execCommand('insertHTML', false, badgeHtml);
        }

        // ============================================================
        // SECTION MANAGEMENT SYSTEM (DELETE, DUPLICATE, MOVE OVERLAY)
        // ============================================================
        let currentHoveredSection = null;
        let overlayHideTimeout = null;

        function initSectionHoverOverlay() {
            const canvas = document.getElementById('liveCanvas');
            const overlay = document.getElementById('sectionActionOverlay');
            const frame = document.getElementById('deviceFrame');

            if (!canvas || !overlay || !frame) return;

            // Track hovering over direct child sections of canvas
            canvas.addEventListener('mousemove', function(e) {
                if (isFormatPainterActive || draggedWidgetType) {
                    hideSectionOverlay();
                    return;
                }

                clearTimeout(overlayHideTimeout);

                // Find top-level section under cursor
                let target = e.target;
                while (target && target.parentNode !== canvas) {
                    target = target.parentNode;
                }

                if (!target || target === canvas || target.id === 'dropIndicatorLine' || target.id === 'emptyCanvasNotice') {
                    return;
                }

                if (currentHoveredSection !== target) {
                    if (currentHoveredSection) {
                        currentHoveredSection.classList.remove('section-hover-active');
                    }
                    currentHoveredSection = target;
                    currentHoveredSection.classList.add('section-hover-active');
                }

                positionSectionOverlay(target);
            });

            canvas.addEventListener('mouseleave', function(e) {
                overlayHideTimeout = setTimeout(() => {
                    hideSectionOverlay();
                }, 350);
            });

            overlay.addEventListener('mouseenter', function() {
                clearTimeout(overlayHideTimeout);
            });

            overlay.addEventListener('mouseleave', function() {
                overlayHideTimeout = setTimeout(() => {
                    hideSectionOverlay();
                }, 200);
            });

            // Click sets active section
            canvas.addEventListener('click', function(e) {
                let target = e.target;
                while (target && target.parentNode !== canvas) {
                    target = target.parentNode;
                }
                if (target && target.parentNode === canvas && target.id !== 'dropIndicatorLine' && target.id !== 'emptyCanvasNotice') {
                    if (currentHoveredSection && currentHoveredSection !== target) {
                        currentHoveredSection.classList.remove('section-hover-active');
                    }
                    currentHoveredSection = target;
                    currentHoveredSection.classList.add('section-hover-active');
                    positionSectionOverlay(target);
                }
            });
        }

        function positionSectionOverlay(target) {
            const overlay = document.getElementById('sectionActionOverlay');
            const frame = document.getElementById('deviceFrame');
            if (!target || !overlay || !frame) return;

            const frameRect = frame.getBoundingClientRect();
            const targetRect = target.getBoundingClientRect();

            const top = (targetRect.top - frameRect.top) - 18;
            const right = 20;

            overlay.style.top = Math.max(10, top) + 'px';
            overlay.style.right = right + 'px';
            overlay.style.display = 'block';

            // Detect widget type label
            const label = document.getElementById('sectionCtrlLabel');
            if (label) {
                if (target.classList.contains('pro-container-1col') || target.classList.contains('pro-container-2col') || target.classList.contains('pro-container-3col') || target.classList.contains('pro-container-4col') || target.classList.contains('pro-container-sidebar')) {
                    label.innerText = 'Grid Container';
                } else if (target.classList.contains('pro-cta-box')) {
                    label.innerText = 'CTA Banner';
                } else if (target.classList.contains('pro-pricing-card')) {
                    label.innerText = 'Pricing Table';
                } else if (target.classList.contains('pro-counter-box') || target.querySelector('.pro-counter-box')) {
                    label.innerText = 'Stats Box';
                } else if (target.classList.contains('pro-testimonial-card')) {
                    label.innerText = 'Testimonial';
                } else if (target.classList.contains('pro-tabs-wrapper')) {
                    label.innerText = 'Tabs';
                } else if (target.classList.contains('pro-timeline-wrapper')) {
                    label.innerText = 'Timeline';
                } else if (target.classList.contains('pro-icon-box')) {
                    label.innerText = 'Icon Box';
                } else if (target.classList.contains('about-page-layout')) {
                    label.innerText = 'Vision & Mission';
                } else if (target.classList.contains('team-org-container')) {
                    label.innerText = 'Org Hierarchy';
                } else if (target.classList.contains('acts-card')) {
                    label.innerText = 'Act / Org Card';
                } else if (target.tagName === 'H2' || target.tagName === 'H3') {
                    label.innerText = 'Heading';
                } else if (target.tagName === 'TABLE' || target.querySelector('table')) {
                    label.innerText = 'Data Table';
                } else {
                    label.innerText = 'Section';
                }
            }

            // Position resize handle on right edge of target
            const resizeHandle = document.getElementById('componentResizeHandle');
            if (resizeHandle && !isResizingComponent) {
                resizeHandle.style.top = (targetRect.top - frameRect.top) + 'px';
                resizeHandle.style.left = (targetRect.right - frameRect.left - 7) + 'px';
                resizeHandle.style.height = Math.max(30, targetRect.height) + 'px';
                resizeHandle.style.display = 'block';
            }
        }

        function hideSectionOverlay() {
            if (isResizingComponent) return;
            const overlay = document.getElementById('sectionActionOverlay');
            if (overlay) overlay.style.display = 'none';
            const resizeHandle = document.getElementById('componentResizeHandle');
            if (resizeHandle) resizeHandle.style.display = 'none';
            if (currentHoveredSection) {
                currentHoveredSection.classList.remove('section-hover-active');
            }
        }

        // DELETE SECTION
        function deleteActiveSection() {
            let target = currentHoveredSection;
            const canvas = document.getElementById('liveCanvas');

            // If no hovered section, find from current cursor selection
            if (!target || !canvas.contains(target)) {
                const sel = window.getSelection();
                if (sel && sel.rangeCount > 0) {
                    let node = sel.anchorNode;
                    while (node && node.parentNode !== canvas) {
                        node = node.parentNode;
                    }
                    if (node && node.parentNode === canvas) {
                        target = node;
                    }
                }
            }

            if (!target || target === canvas || target.id === 'emptyCanvasNotice' || target.id === 'dropIndicatorLine') {
                alert('Please click on or hover over the section you want to delete.');
                return;
            }

            if (confirm('Are you sure you want to delete this section?')) {
                target.remove();
                hideSectionOverlay();
                currentHoveredSection = null;
                showToast('Section deleted successfully!');

                // Check if canvas is empty
                const remaining = Array.from(canvas.children).filter(el => el.id !== 'dropIndicatorLine' && el.id !== 'emptyCanvasNotice');
                if (remaining.length === 0 || canvas.innerHTML.trim() === '') {
                    canvas.innerHTML = `<div class="alert alert-info py-4 my-3 text-center" id="emptyCanvasNotice">
                        <i class="fa-solid fa-hand-pointer me-2"></i> <strong>Start building your page:</strong> Click here to begin typing, or drag any widget from the left sidebar into this area!
                    </div>`;
                }
            }
        }

        // DUPLICATE SECTION
        function duplicateActiveSection() {
            if (!currentHoveredSection || !currentHoveredSection.parentNode) return;
            const clone = currentHoveredSection.cloneNode(true);
            clone.classList.remove('section-hover-active');
            currentHoveredSection.after(clone);
            currentHoveredSection.classList.remove('section-hover-active');
            currentHoveredSection = clone;
            currentHoveredSection.classList.add('section-hover-active');
            positionSectionOverlay(clone);
            showToast('Section duplicated successfully!');
        }

        // MOVE SECTION (UP / DOWN)
        function moveActiveSection(direction) {
            if (!currentHoveredSection || !currentHoveredSection.parentNode) return;
            const indicator = document.getElementById('dropIndicatorLine');

            if (direction === 'up') {
                let prev = currentHoveredSection.previousElementSibling;
                while (prev && prev === indicator) {
                    prev = prev.previousElementSibling;
                }
                if (prev) {
                    prev.before(currentHoveredSection);
                    positionSectionOverlay(currentHoveredSection);
                    showToast('Moved section up');
                }
            } else if (direction === 'down') {
                let next = currentHoveredSection.nextElementSibling;
                while (next && next === indicator) {
                    next = next.nextElementSibling;
                }
                if (next) {
                    next.after(currentHoveredSection);
                    positionSectionOverlay(currentHoveredSection);
                    showToast('Moved section down');
                }
            }
        }

        // ============================================================
        // DRAG TO RESIZE & SIZE ADJUSTMENT MODAL
        // ============================================================
        let isResizingComponent = false;
        let resizeStartX = 0;
        let resizeStartWidth = 0;

        function initDragToResize() {
            const handle = document.getElementById('componentResizeHandle');
            const tooltip = document.getElementById('componentResizeTooltip');
            const frame = document.getElementById('deviceFrame');
            if (!handle || !tooltip || !frame) return;

            handle.addEventListener('mousedown', function(e) {
                if (!currentHoveredSection) return;
                e.preventDefault();
                e.stopPropagation();
                isResizingComponent = true;
                resizeStartX = e.clientX;
                resizeStartWidth = currentHoveredSection.offsetWidth;
                handle.classList.add('is-resizing');

                tooltip.style.display = 'block';
                tooltip.innerText = resizeStartWidth + 'px';
                tooltip.style.top = (parseInt(handle.style.top) + 20) + 'px';
                tooltip.style.left = (parseInt(handle.style.left) + 16) + 'px';

                document.body.style.cursor = 'ew-resize';
                document.body.style.userSelect = 'none';
            });

            window.addEventListener('mousemove', function(e) {
                if (!isResizingComponent || !currentHoveredSection) return;
                const deltaX = e.clientX - resizeStartX;
                const parentWidth = currentHoveredSection.parentElement ? currentHoveredSection.parentElement.offsetWidth : 1140;
                let newWidth = Math.max(120, Math.min(parentWidth, resizeStartWidth + deltaX));

                currentHoveredSection.style.width = newWidth + 'px';
                currentHoveredSection.style.maxWidth = '100%';
                currentHoveredSection.style.boxSizing = 'border-box';

                // Automatically adapt acts-card styling when size is reduced
                const actCard = currentHoveredSection.classList.contains('acts-card') ? currentHoveredSection : currentHoveredSection.querySelector('.acts-card');
                if (actCard) {
                    if (newWidth <= 380) {
                        actCard.classList.add('compact-size');
                    } else {
                        actCard.classList.remove('compact-size');
                    }
                }

                const frameRect = frame.getBoundingClientRect();
                const rect = currentHoveredSection.getBoundingClientRect();
                handle.style.left = (rect.right - frameRect.left - 7) + 'px';
                tooltip.style.left = (parseInt(handle.style.left) + 16) + 'px';
                tooltip.innerText = Math.round(newWidth) + 'px';

                positionSectionOverlay(currentHoveredSection);
            });

            window.addEventListener('mouseup', function(e) {
                if (!isResizingComponent) return;
                isResizingComponent = false;
                handle.classList.remove('is-resizing');
                tooltip.style.display = 'none';
                document.body.style.cursor = '';
                document.body.style.userSelect = '';
                if (currentHoveredSection) {
                    showToast('Width adjusted: ' + currentHoveredSection.style.width);
                }
            });
        }

        // Open Size Adjustment Modal
        function openSizeModal() {
            let target = currentHoveredSection;
            const canvas = document.getElementById('liveCanvas');

            if (!target || !canvas.contains(target)) {
                const sel = window.getSelection();
                if (sel && sel.rangeCount > 0) {
                    let node = sel.anchorNode;
                    while (node && node.parentNode !== canvas) {
                        node = node.parentNode;
                    }
                    if (node && node.parentNode === canvas) {
                        target = node;
                    }
                }
            }

            if (!target || target === canvas || target.id === 'emptyCanvasNotice' || target.id === 'dropIndicatorLine') {
                alert('Please hover over or click the component whose size you want to adjust.');
                return;
            }

            currentHoveredSection = target;
            const currentW = target.style.width || (target.offsetWidth + 'px');
            const widthInput = document.getElementById('sizeWidthInput');
            const slider = document.getElementById('sizeWidthSlider');
            const sliderVal = document.getElementById('sizeSliderValue');
            const maxWidthInput = document.getElementById('sizeMaxWidthInput');

            widthInput.value = currentW;
            maxWidthInput.value = target.style.maxWidth || '';

            const numPx = parseInt(currentW);
            if (!isNaN(numPx)) {
                slider.value = Math.min(1140, Math.max(150, numPx));
                sliderVal.innerText = numPx + 'px';
            } else {
                sliderVal.innerText = currentW;
            }

            const modalEl = document.getElementById('sizeAdjustModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }

        function setSizePreset(preset) {
            const input = document.getElementById('sizeWidthInput');
            input.value = preset;
            liveUpdateTargetSize();
        }

        function onSizeSliderChange(val) {
            document.getElementById('sizeSliderValue').innerText = val + 'px';
            document.getElementById('sizeWidthInput').value = val + 'px';
            liveUpdateTargetSize();
        }

        function setComponentAlign(align) {
            if (!currentHoveredSection) return;
            if (align === 'center') {
                currentHoveredSection.style.marginLeft = 'auto';
                currentHoveredSection.style.marginRight = 'auto';
            } else if (align === 'right') {
                currentHoveredSection.style.marginLeft = 'auto';
                currentHoveredSection.style.marginRight = '0';
            } else {
                currentHoveredSection.style.marginLeft = '0';
                currentHoveredSection.style.marginRight = 'auto';
            }
            positionSectionOverlay(currentHoveredSection);
        }

        function liveUpdateTargetSize() {
            if (!currentHoveredSection) return;
            const w = document.getElementById('sizeWidthInput').value.trim();
            const maxW = document.getElementById('sizeMaxWidthInput').value.trim();

            if (w) {
                currentHoveredSection.style.width = w;
                currentHoveredSection.style.boxSizing = 'border-box';
            }
            if (maxW) {
                currentHoveredSection.style.maxWidth = maxW;
            }

            // Compact styling if narrow
            const numPx = parseInt(w);
            const isNarrow = (w.includes('%') && parseInt(w) <= 40) || (!isNaN(numPx) && numPx <= 380);
            const actCard = currentHoveredSection.classList.contains('acts-card') ? currentHoveredSection : currentHoveredSection.querySelector('.acts-card');
            if (actCard) {
                if (isNarrow) {
                    actCard.classList.add('compact-size');
                } else {
                    actCard.classList.remove('compact-size');
                }
            }

            positionSectionOverlay(currentHoveredSection);
        }

        function applyAndCloseSizeModal() {
            liveUpdateTargetSize();
            const modalEl = document.getElementById('sizeAdjustModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
            showToast('Size applied successfully!');
        }

        // Initialize Section Hover Overlay, Resize & Clean Paste
        document.addEventListener('DOMContentLoaded', function() {
            initSectionHoverOverlay();
            initDragToResize();
            initCleanPasteEngine();
            if (typeof initAllDbimTables === 'function') initAllDbimTables();
        });
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            initSectionHoverOverlay();
            initDragToResize();
            initCleanPasteEngine();
            if (typeof initAllDbimTables === 'function') initAllDbimTables();
        }
    </script>

    <!-- IMAGE PICKER & MEDIA LIBRARY MODAL -->
    <div class="modal fade" id="imagePickerModal" tabindex="-1" aria-labelledby="imagePickerModalLabel" aria-hidden="true" style="z-index: 2100;">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: #721835; color: #ffffff;">
                    <h5 class="modal-title fs-6 fw-bold" id="imagePickerModalLabel">
                        <i class="fa-regular fa-image me-2"></i> Select or Upload Photo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-0">
                    <ul class="nav nav-tabs px-3 pt-3 bg-light" id="imagePickerTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-semibold" id="upload-tab" data-bs-toggle="tab" data-bs-target="#tabUpload" type="button" role="tab">
                                <i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload from Computer
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold" id="library-tab" data-bs-toggle="tab" data-bs-target="#tabLibrary" type="button" role="tab">
                                <i class="fa-solid fa-photo-film me-1"></i> Media Library (Website Assets)
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold" id="url-tab" data-bs-toggle="tab" data-bs-target="#tabUrl" type="button" role="tab">
                                <i class="fa-solid fa-link me-1"></i> Web URL
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content p-4">
                        <!-- TAB 1: UPLOAD FROM COMPUTER -->
                        <div class="tab-pane fade show active" id="tabUpload" role="tabpanel">
                            <div class="p-4 border rounded text-center bg-light" style="border: 2px dashed #721835 !important; cursor: pointer;" onclick="document.getElementById('fileUploadInput').click()">
                                <i class="fa-solid fa-cloud-arrow-up text-primary mb-2" style="font-size: 42px; color: #721835 !important;"></i>
                                <h6 class="fw-bold mb-1">Click to browse or drag & drop image here</h6>
                                <p class="text-muted small mb-0">Supports JPG, PNG, WEBP, SVG up to 5MB</p>
                                <input type="file" id="fileUploadInput" class="d-none" accept="image/*" onchange="uploadNewImage(this.files[0])">
                            </div>
                            <div id="uploadProgressStatus" class="alert alert-info mt-3 d-none text-center"></div>
                        </div>

                        <!-- TAB 2: MEDIA LIBRARY -->
                        <div class="tab-pane fade" id="tabLibrary" role="tabpanel">
                            <div class="mb-3">
                                <input type="text" class="form-control form-control-sm" placeholder="Search photos (e.g. giriraj, neelam, banner, logo)..." onkeyup="filterMediaGallery(this.value)">
                            </div>
                            
                            <div class="row g-3" style="max-height: 400px; overflow-y: auto;">
                                @if(isset($uploadedImages) && count($uploadedImages))
                                    <div class="col-12"><strong class="small text-muted text-uppercase">Uploaded Images</strong></div>
                                    @foreach($uploadedImages as $upImg)
                                        <div class="col-4 col-md-3 media-gallery-item" data-name="{{ $upImg['name'] }}">
                                            <div class="card h-100 p-1 border text-center" style="cursor: pointer;" onclick="selectImage('{{ $upImg['url'] }}')">
                                                <img src="{{ $upImg['url'] }}" class="card-img-top" style="height: 90px; object-fit: cover; border-radius: 4px;">
                                                <div class="card-body p-1">
                                                    <small class="text-truncate d-block" style="font-size: 11px;">{{ $upImg['name'] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if(isset($assetImages) && count($assetImages))
                                    <div class="col-12 mt-2"><strong class="small text-muted text-uppercase">Official Site Assets</strong></div>
                                    @foreach($assetImages as $asImg)
                                        <div class="col-4 col-md-3 media-gallery-item" data-name="{{ $asImg['name'] }}">
                                            <div class="card h-100 p-1 border text-center" style="cursor: pointer;" onclick="selectImage('{{ $asImg['url'] }}')">
                                                <img src="{{ $asImg['url'] }}" class="card-img-top" style="height: 90px; object-fit: contain; background: #f8fafc; border-radius: 4px;">
                                                <div class="card-body p-1">
                                                    <small class="text-truncate d-block" style="font-size: 11px;">{{ $asImg['name'] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- TAB 3: WEB URL -->
                        <div class="tab-pane fade" id="tabUrl" role="tabpanel">
                            <label class="form-label fw-semibold">Direct Image Web Address (URL):</label>
                            <div class="input-group">
                                <input type="text" id="customImageUrlInput" class="form-control" placeholder="https://example.com/photo.jpg">
                                <button type="button" class="btn text-white fw-semibold" style="background: #721835;" onclick="insertCustomUrl()">Use This Image</button>
                            </div>
                            <small class="text-muted d-block mt-2">Paste a public image link (e.g. from an official website or government portal).</small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF UPLOADER MODAL -->
    <div class="modal fade" id="pdfUploaderModal" tabindex="-1" aria-labelledby="pdfUploaderModalLabel" aria-hidden="true" style="z-index: 2100;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: #721835; color: #ffffff;">
                    <h5 class="modal-title fs-6 fw-bold" id="pdfUploaderModalLabel">
                        <i class="fa-regular fa-file-pdf me-2"></i> Upload PDF Document
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="p-4 border rounded text-center bg-light" style="border: 2px dashed #721835 !important; cursor: pointer;" onclick="document.getElementById('pdfFileInput').click()">
                        <i class="fa-solid fa-file-arrow-up text-danger mb-2" style="font-size: 42px;"></i>
                        <h6 class="fw-bold mb-1">Click to select PDF from your device</h6>
                        <p class="text-muted small mb-0">PDF files up to 20MB are supported</p>
                        <input type="file" id="pdfFileInput" class="d-none" accept=".pdf" onchange="uploadNewPdf(this.files[0])">
                    </div>
                    <div id="pdfUploadProgressStatus" class="alert alert-info mt-3 d-none text-center"></div>

                    <div class="mt-4 pt-3 border-top">
                        <label class="form-label fw-semibold small text-muted text-uppercase">Or Insert Existing Document Link:</label>
                        <div class="input-group">
                            <input type="text" id="manualPdfUrl" class="form-control form-control-sm" placeholder="https:// or /assets/images/sample_doc.pdf">
                            <button type="button" class="btn btn-sm text-white" style="background: #721835;" onclick="const u = document.getElementById('manualPdfUrl').value.trim(); if(u) { if (targetPdfLinkElement) { targetPdfLinkElement.href = u; targetPdfLinkElement = null; showToast('Document link linked to component!'); } else { insertPdfBadge('OFFICIAL DOCUMENT', u, 'PDF'); } bootstrap.Modal.getInstance(document.getElementById('pdfUploaderModal')).hide(); }">Insert Link</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- SIZE & WIDTH ADJUSTMENT MODAL -->
    <div class="modal fade" id="sizeAdjustModal" tabindex="-1" aria-labelledby="sizeAdjustModalLabel" aria-hidden="true" style="z-index: 2150;">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background: #721835; padding: 14px 20px;">
                    <h6 class="modal-title fw-bold" id="sizeAdjustModalLabel">
                        <i class="fa-solid fa-arrows-left-right-to-line me-2"></i> Adjust Component Size & Width
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Enter Exact Width:</label>
                        <div class="input-group">
                            <input type="text" id="sizeWidthInput" class="form-control fw-bold" placeholder="e.g. 330px or 100%" oninput="liveUpdateTargetSize()">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">Presets</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="setSizePreset('100%')">Full Width (100%)</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="setSizePreset('50%')">Half Width (50%)</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="setSizePreset('330px')">Sidebar Column (330px)</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="setSizePreset('280px')">Small / Compact (280px)</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="setSizePreset('420px')">Medium Card (420px)</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="setSizePreset('auto')">Auto (Reset Default)</a></li>
                            </ul>
                        </div>
                        <small class="text-muted d-block mt-1">Accepts <code>px</code> (e.g. <code>300px</code>), <code>%</code> (e.g. <code>50%</code>), or <code>auto</code>.</small>
                    </div>

                    <!-- Quick Slider -->
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase d-flex justify-content-between">
                            <span>Width Slider:</span>
                            <span id="sizeSliderValue" class="text-primary fw-bold">320px</span>
                        </label>
                        <input type="range" class="form-range" id="sizeWidthSlider" min="150" max="1140" step="10" value="320" oninput="onSizeSliderChange(this.value)">
                    </div>

                    <!-- Alignment -->
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Horizontal Alignment:</label>
                        <div class="btn-group w-100" role="group">
                            <button type="button" class="btn btn-outline-dark btn-sm" onclick="setComponentAlign('left')"><i class="fa-solid fa-align-left me-1"></i> Left</button>
                            <button type="button" class="btn btn-outline-dark btn-sm" onclick="setComponentAlign('center')"><i class="fa-solid fa-align-center me-1"></i> Center</button>
                            <button type="button" class="btn btn-outline-dark btn-sm" onclick="setComponentAlign('right')"><i class="fa-solid fa-align-right me-1"></i> Right</button>
                        </div>
                    </div>

                    <!-- Max Width -->
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Max Width Constraint (Optional):</label>
                        <input type="text" id="sizeMaxWidthInput" class="form-control form-control-sm" placeholder="e.g. 100% or 400px" oninput="liveUpdateTargetSize()">
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn text-white btn-sm fw-bold" style="background: #721835;" onclick="applyAndCloseSizeModal()">Apply Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. MEDIA MANAGER & COPY LINK MODAL -->
    <div class="modal fade" id="mediaManagerModal" tabindex="-1" aria-labelledby="mediaManagerModalLabel" aria-hidden="true" style="z-index: 2200;">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background: #721835; padding: 14px 24px;">
                    <h5 class="modal-title fs-6 fw-bold" id="mediaManagerModalLabel">
                        <i class="fa-solid fa-photo-film me-2"></i> Media Library & Uploader (Upload & Copy Links)
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 bg-light">
                    <!-- Dropzone / Upload Bar -->
                    <div class="p-4 border rounded text-center bg-white shadow-sm mb-4" 
                         style="border: 2px dashed #721835 !important; cursor: pointer;" 
                         onclick="document.getElementById('modalMediaFileInput').click()">
                        <i class="fa-solid fa-cloud-arrow-up text-danger mb-2" style="font-size: 42px;"></i>
                        <h6 class="fw-bold mb-1">Click to browse or drag & drop files from your computer</h6>
                        <p class="text-muted small mb-0">Supports Images (PNG, JPG, SVG, WEBP), Documents (PDF, DOCX, XLSX, TXT) up to 50MB</p>
                        <input type="file" id="modalMediaFileInput" class="d-none" multiple onchange="uploadModalMedia(this.files)">
                    </div>
                    <div id="modalMediaUploadStatus" class="alert alert-info d-none text-center py-2 mb-3"></div>

                    <!-- Filter & Search Controls -->
                    <div class="row g-2 align-items-center mb-3">
                        <div class="col-md-6">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                <input type="text" id="modalMediaSearch" class="form-control" placeholder="Search files by name..." onkeyup="filterModalMediaGrid()">
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-secondary active" onclick="setModalMediaTypeFilter('all', this)">All Files</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="setModalMediaTypeFilter('image', this)">Images</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="setModalMediaTypeFilter('document', this)">PDFs & Docs</button>
                            </div>
                        </div>
                    </div>

                    <!-- Grid of Media Items -->
                    <div id="modalMediaGrid" class="row g-3" style="max-height: 460px; overflow-y: auto;">
                        <div class="col-12 text-center py-4 text-muted">
                            <div class="spinner-border spinner-border-sm text-secondary me-2"></div> Loading media files...
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-white py-2 justify-content-between">
                    <small class="text-muted">Click <strong>Copy Link</strong> on any file to paste the URL directly into your text, link, button, or HTML code.</small>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let modalMediaItems = [];
        let currentMediaTypeFilter = 'all';

        function openMediaManagerModal() {
            const modalEl = document.getElementById('mediaManagerModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
            loadModalMediaList();
        }

        function loadModalMediaList() {
            fetch('{{ route('admin.media.list-api') }}')
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.data) {
                        modalMediaItems = data.data;
                        renderModalMediaGrid();
                    }
                })
                .catch(err => {
                    console.error('Failed to load media list', err);
                });
        }

        function setModalMediaTypeFilter(type, btn) {
            currentMediaTypeFilter = type;
            btn.parentElement.querySelectorAll('button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            renderModalMediaGrid();
        }

        function filterModalMediaGrid() {
            renderModalMediaGrid();
        }

        function renderModalMediaGrid() {
            const container = document.getElementById('modalMediaGrid');
            const search = document.getElementById('modalMediaSearch').value.toLowerCase().trim();

            let filtered = modalMediaItems.filter(item => {
                if (currentMediaTypeFilter !== 'all' && item.file_type !== currentMediaTypeFilter) {
                    return false;
                }
                if (search && !item.name.toLowerCase().includes(search) && !item.file_name.toLowerCase().includes(search)) {
                    return false;
                }
                return true;
            });

            if (filtered.length === 0) {
                container.innerHTML = `<div class="col-12 text-center py-5 text-muted">
                    <i class="fa-regular fa-folder-open mb-2" style="font-size: 36px;"></i>
                    <p class="mb-0">No media files found matching your search.</p>
                </div>`;
                return;
            }

            container.innerHTML = filtered.map(item => {
                const isImg = item.file_type === 'image';
                const previewHtml = isImg 
                    ? `<img src="${item.url}" class="card-img-top" style="height: 120px; object-fit: cover; background: #fff;" onerror="this.src='/assets/images/placeholder.png'">`
                    : `<div class="d-flex align-items-center justify-content-center bg-white text-danger" style="height: 120px;">
                        <div class="text-center">
                            <i class="fa-regular fa-file-pdf fs-1 mb-1"></i>
                            <div class="small fw-bold text-uppercase" style="font-size: 10px;">${item.extension || 'DOC'}</div>
                        </div>
                       </div>`;

                return `<div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 border shadow-sm rounded-3 overflow-hidden">
                        <div class="position-relative">
                            ${previewHtml}
                            <span class="badge bg-dark bg-opacity-75 position-absolute top-0 end-0 m-1" style="font-size: 9px;">${item.size || ''}</span>
                        </div>
                        <div class="card-body p-2 d-flex flex-column justify-content-between">
                            <div>
                                <strong class="d-block text-truncate small mb-0" title="${item.name}">${item.name}</strong>
                                <small class="text-muted d-block text-truncate" style="font-size: 10px;" title="${item.file_name}">${item.file_name}</small>
                            </div>
                            <div class="mt-2 pt-2 border-top d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-dark flex-grow-1 py-1" style="font-size: 11px;" onclick="copyEditorLink('${item.url}', this)" title="Copy direct public link">
                                    <i class="fa-regular fa-copy me-1"></i> Copy Link
                                </button>
                                ${isImg ? `
                                    <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2" style="font-size: 11px;" onclick="insertEditorImage('${item.url}')" title="Insert into canvas">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                ` : `
                                    <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2" style="font-size: 11px;" onclick="insertPdfBadge('${item.name}', '${item.url}', '${item.size}')" title="Insert PDF download badge">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                `}
                            </div>
                        </div>
                    </div>
                </div>`;
            }).join('');
        }

        function copyEditorLink(url, btn = null) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(() => {
                    showToast('Link copied to clipboard: ' + url);
                    if (btn) {
                        const orig = btn.innerHTML;
                        btn.innerHTML = '<i class="fa-solid fa-check text-success"></i> Copied!';
                        setTimeout(() => { btn.innerHTML = orig; }, 1800);
                    }
                });
            } else {
                prompt('Copy media link:', url);
            }
        }

        function insertEditorImage(url) {
            const canvas = document.getElementById('liveCanvas');
            canvas.focus();
            const html = `<div class="text-center my-3"><img src="${url}" class="img-fluid rounded shadow-sm" style="max-height: 400px; object-fit: contain;" alt="Image"></div>`;
            document.execCommand('insertHTML', false, html);
            const modalEl = document.getElementById('mediaManagerModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
            showToast('Image inserted into canvas!');
        }

        function uploadModalMedia(files) {
            if (!files || files.length === 0) return;
            const status = document.getElementById('modalMediaUploadStatus');
            status.classList.remove('d-none');
            status.innerHTML = `<div class="spinner-border spinner-border-sm me-2"></div> Uploading ${files.length} file(s)...`;

            const formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                formData.append('files[]', files[i]);
            }

            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

            fetch('{{ route('admin.media.upload') }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                status.classList.add('d-none');
                if (data.success) {
                    showToast(data.message || 'Media uploaded successfully!');
                    loadModalMediaList();
                } else {
                    alert(data.message || 'Upload failed');
                }
            })
            .catch(err => {
                status.classList.add('d-none');
                alert('Upload error. Please try again.');
            });
        }
        // ============================================================
        // DYNAMIC DOCUMENT LINKING MODAL & FUNCTIONS FOR VIEW BUTTONS
        // ============================================================
        let activeDocBox = null;
        let activeViewLink = null;
        let docModalMediaList = [];

        function openDocMediaModal(triggerEl) {
            // Find parent document box card and view button
            activeDocBox = triggerEl.closest('[data-doc-box="true"]') || triggerEl.closest('.box') || triggerEl.closest('.row');
            if (activeDocBox) {
                activeViewLink = activeDocBox.querySelector('a.download-btn');
            } else if (triggerEl.tagName.toLowerCase() === 'a') {
                activeViewLink = triggerEl;
                activeDocBox = triggerEl.closest('.box') || triggerEl.parentElement;
            }

            // Show current document title in modal
            const currentTitleEl = activeDocBox ? activeDocBox.querySelector('.doc-title-text') : null;
            const currentTitle = currentTitleEl ? currentTitleEl.innerText.trim() : 'Document';
            const modalTitleSpan = document.getElementById('docModalTargetName');
            if (modalTitleSpan) modalTitleSpan.innerText = currentTitle;

            const modalEl = document.getElementById('docMediaModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();

            loadDocModalMedia();
        }

        function uploadDocModalFile(file) {
            if (!file) return;

            const status = document.getElementById('docModalUploadStatus');
            status.classList.remove('d-none');
            status.innerHTML = '<div class="spinner-border spinner-border-sm text-danger me-2"></div> Uploading document to server...';

            const formData = new FormData();
            formData.append('pdf', file);

            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

            fetch("{{ route('admin.pages.upload-pdf') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                status.classList.add('d-none');
                if (data.success) {
                    // Use relative URL so it works seamlessly in both local and production environments
                    const docUrl = data.relative_url || data.url;

                    if (activeViewLink) {
                        activeViewLink.href = docUrl;
                    }
                    if (activeDocBox) {
                        const sizeEl = activeDocBox.querySelector('.doc-size-badge');
                        if (sizeEl && data.fileSize) {
                            sizeEl.innerText = data.fileSize;
                        }
                        const titleEl = activeDocBox.querySelector('.doc-title-text');
                        if (titleEl && data.title && (titleEl.innerText.includes('Official Notification') || titleEl.innerText.includes('Document Title'))) {
                            titleEl.innerText = data.title;
                        }
                    }

                    const modalEl = document.getElementById('docMediaModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();

                    showToast('Document uploaded & linked to VIEW button successfully!');
                } else {
                    alert(data.message || 'Upload failed. Please check the file.');
                }
            })
            .catch(err => {
                status.classList.add('d-none');
                alert('Upload failed: ' + err.message);
            });
        }

        function loadDocModalMedia() {
            const grid = document.getElementById('docModalMediaListGrid');
            if (!grid) return;

            fetch('{{ route('admin.media.list-api') }}')
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.data) {
                        // Filter to document types primarily, but allow all
                        docModalMediaList = data.data;
                        renderDocModalMediaGrid();
                    }
                })
                .catch(err => {
                    grid.innerHTML = '<div class="col-12 text-center text-muted py-3">Could not load media library.</div>';
                });
        }

        function filterDocModalMedia() {
            renderDocModalMediaGrid();
        }

        function renderDocModalMediaGrid() {
            const grid = document.getElementById('docModalMediaListGrid');
            if (!grid) return;

            const q = (document.getElementById('docModalMediaSearch')?.value || '').toLowerCase().trim();
            const filtered = docModalMediaList.filter(item => {
                if (q && !item.name.toLowerCase().includes(q) && !item.file_name.toLowerCase().includes(q)) return false;
                return true;
            });

            if (filtered.length === 0) {
                grid.innerHTML = '<div class="col-12 text-center text-muted py-4"><i class="fa-regular fa-folder-open fs-3 d-block mb-2"></i>No matching files found. Upload a new file above.</div>';
                return;
            }

            grid.innerHTML = filtered.map(item => {
                const isDoc = item.file_type === 'document' || item.extension === 'pdf';
                const fileUrl = item.disk_path ? '/' + item.disk_path : item.url;
                return `<div class="col-md-6">
                    <div class="card p-2 border shadow-sm h-100 d-flex flex-row align-items-center justify-content-between gap-2" style="border-radius: 8px;">
                        <div class="d-flex align-items-center gap-2 overflow-hidden">
                            <i class="${isDoc ? 'fa-regular fa-file-pdf text-danger fs-3' : 'fa-regular fa-file text-primary fs-3'}"></i>
                            <div class="text-truncate">
                                <strong class="d-block text-truncate small" title="${item.name}">${item.name}</strong>
                                <small class="text-muted d-block" style="font-size: 11px;">${item.size || ''} &bull; ${item.file_name}</small>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm text-white fw-bold flex-shrink-0" style="background: #500a2f; font-size: 11px;" onclick="selectDocFromLibrary('${fileUrl}', '${item.size || ''}', '${escapeHtml(item.name)}')">
                            <i class="fa-solid fa-link me-1"></i> Attach
                        </button>
                    </div>
                </div>`;
            }).join('');
        }

        function selectDocFromLibrary(fileUrl, fileSize, fileName) {
            if (activeViewLink) {
                activeViewLink.href = fileUrl;
            }
            if (activeDocBox) {
                const sizeEl = activeDocBox.querySelector('.doc-size-badge');
                if (sizeEl && fileSize) {
                    sizeEl.innerText = fileSize;
                }
                const titleEl = activeDocBox.querySelector('.doc-title-text');
                if (titleEl && fileName && (titleEl.innerText.includes('Official Notification') || titleEl.innerText.includes('Document Title'))) {
                    titleEl.innerText = fileName;
                }
            }

            const modalEl = document.getElementById('docMediaModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();

            showToast('Document attached to VIEW button successfully!');
        }

        function setManualDocUrl() {
            const urlInput = document.getElementById('docModalManualUrl');
            const url = urlInput ? urlInput.value.trim() : '';
            if (!url) return;

            if (activeViewLink) {
                activeViewLink.href = url;
            }

            const modalEl = document.getElementById('docMediaModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();

            showToast('Custom link saved to VIEW button!');
        }

        function addDocCardToStack(btn) {
            const stack = btn.closest('.dbim-doc-list-section')?.querySelector('.dbim-doc-items-stack');
            if (!stack) return;

            const temp = document.createElement('div');
            temp.innerHTML = `<div class="box row row-gap-2 align-items-center ms-0 me-0" data-doc-box="true" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 8px; padding: 14px 20px; margin-bottom: 14px;">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <p class="mb-0 d-flex align-items-center gap-2" style="font-weight: 600; font-size: 1.6rem; color: #150202;">
                        <span class="material-symbols-outlined" style="color: #500a2f; font-size: 2.2rem;">draft</span>
                        <span class="doc-title-text" contenteditable="true">New Official Document / Notification</span>
                    </p>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12">
                    <div class="d-flex gap-4 align-items-center type-size">
                        <small class="text-uppercase mb-0 doc-size-badge" contenteditable="true" style="color: #666; font-size: 1.3rem; font-weight: 600; background: #f7eef3; padding: 4px 10px; border-radius: 4px; border: 1px solid #e8d0dd;">PDF</small>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12">
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <a class="download-btn d-flex align-items-center text-uppercase w-ft" target="_blank" rel="noopener noreferrer" title="View PDF" href="/uploads/documents/sample.pdf" style="background: #faebf2; color: #500a2f; border: 1px solid #ebd0de; border-radius: 6px; padding: 8px 18px; font-size: 1.35rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                            <span class="material-symbols-outlined" style="font-size: 1.8rem;">visibility</span>
                            VIEW
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger editor-doc-btn" onclick="openDocMediaModal(this)" title="Upload or link PDF/Media for this VIEW button">
                            <i class="fa-solid fa-file-arrow-up"></i>
                        </button>
                    </div>
                </div>
            </div>`;
            const newRow = temp.firstElementChild;
            stack.appendChild(newRow);
            showToast('New document card added to stack!');
        }

        function escapeHtml(str) {
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }

        // ============================================================
        // DBIM DIRECTORY TABLE ROW & SECTION OPERATIONS
        // ============================================================
        function addDirRowToTable(triggerBtn) {
            const tableWrap = triggerBtn.closest('.dbim-dir-table-wrapper') || triggerBtn.closest('.dbim-directory-section');
            if (!tableWrap) return;
            const tbody = tableWrap.querySelector('.dbim-dir-tbody') || tableWrap.querySelector('tbody');
            if (!tbody) return;

            const tr = document.createElement('tr');
            tr.style.cssText = 'border-bottom: 1px solid #f1edf0; transition: background 0.15s;';
            tr.innerHTML = `
                <td style="padding: 16px 18px; vertical-align: top; border: none;">
                    <div class="officer-name fw-bold" contenteditable="true" style="color: #111827; font-size: 1.45rem; line-height: 1.35; margin-bottom: 3px;">Official Full Name</div>
                    <div class="officer-desig" contenteditable="true" style="color: #4b5563; font-size: 1.25rem; line-height: 1.4;">Official Designation</div>
                </td>
                <td style="padding: 16px 18px; vertical-align: top; border: none;">
                    <div class="d-flex align-items-center gap-2 mb-1" style="font-size: 1.25rem; color: #1f2937;">
                        <i class="fa-solid fa-phone" style="font-size: 13px; color: #374151; width: 14px;"></i>
                        <span class="officer-phone" contenteditable="true">011-XXXXXXXX /Ext.- XXX</span>
                    </div>
                    <div class="d-flex align-items-center gap-2" style="font-size: 1.25rem; color: #1f2937;">
                        <i class="fa-regular fa-envelope" style="font-size: 13px; color: #374151; width: 14px;"></i>
                        <span class="officer-email" contenteditable="true">officer[dot]mot[at]gov[dot]in</span>
                    </div>
                </td>
                <td style="padding: 16px 18px; vertical-align: top; border: none;">
                    <div class="officer-address" contenteditable="true" style="color: #374151; font-size: 1.25rem; line-height: 1.5;">Room No. XXX, Xth Floor, GPOA-3, Netaji Nagar, New Delhi–110023</div>
                </td>
                <td class="editor-row-ctrl text-center" style="vertical-align: top; padding: 16px 6px; border: none;">
                    <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeDirRow(this)" title="Delete Row" style="font-size: 15px; text-decoration: none;">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
            showToast('New official contact row added to directory table!');
        }

        function removeDirRow(btn) {
            const tr = btn.closest('tr');
            const tbody = tr ? tr.closest('tbody') : null;
            if (tbody && tbody.querySelectorAll('tr').length <= 1) {
                if (!confirm('This is the only row in this section. Remove it?')) return;
            }
            if (tr) {
                tr.remove();
                showToast('Row removed from directory table.');
            }
        }

        function addDirSectionAfter(triggerBtn) {
            const currentWrap = triggerBtn.closest('.dbim-dir-table-wrapper');
            const parentSection = triggerBtn.closest('.dbim-directory-section') || (currentWrap ? currentWrap.parentElement : null);
            if (!currentWrap || !parentSection) return;

            const temp = document.createElement('div');
            temp.innerHTML = `
                <div class="dbim-dir-table-wrapper" style="border: 1px solid #ebd0de; border-radius: 8px; overflow: hidden; background: #ffffff; box-shadow: 0 4px 14px rgba(114, 24, 53, 0.05); margin-bottom: 24px;">
                    <div class="dbim-dir-category-header" style="background: #9c2759; color: #ffffff; padding: 12px 20px; font-weight: 700; font-size: 1.45rem; text-transform: uppercase; letter-spacing: 0.6px; display: flex; align-items: center; justify-content: space-between;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-building" style="font-size: 16px;"></i>
                            <span class="dbim-dir-category-title" contenteditable="true">NEW DEPARTMENT / DIVISION NAME</span>
                        </div>
                        <div class="editor-row-ctrl d-inline-flex gap-1">
                            <button type="button" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 11px;" onclick="addDirRowToTable(this)" title="Add another official row to this table">
                                <i class="fa-solid fa-plus me-1"></i> Add Row
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-light py-0 px-2" style="font-size: 11px;" onclick="addDirSectionAfter(this)" title="Add new department section below">
                                <i class="fa-solid fa-folder-plus me-1"></i> Add Section
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive m-0">
                        <table class="table mb-0 dbim-dir-table" style="width: 100%; border-collapse: collapse; font-family: 'Noto Sans', sans-serif;">
                            <thead>
                                <tr style="background: #faebf3; border-bottom: 2px solid #ecd5e1;">
                                    <th style="width: 32%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">NAME AND DESIGNATION</th>
                                    <th style="width: 38%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">CONTACT</th>
                                    <th style="width: 30%; padding: 12px 18px; color: #9c2759; font-weight: 700; font-size: 1.15rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;">ADDRESS</th>
                                    <th class="editor-row-ctrl" style="width: 40px; padding: 12px 6px; border: none;"></th>
                                </tr>
                            </thead>
                            <tbody class="dbim-dir-tbody">
                                <tr style="border-bottom: 1px solid #f1edf0; transition: background 0.15s;">
                                    <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                        <div class="officer-name fw-bold" contenteditable="true" style="color: #111827; font-size: 1.45rem; line-height: 1.35; margin-bottom: 3px;">Official Full Name</div>
                                        <div class="officer-desig" contenteditable="true" style="color: #4b5563; font-size: 1.25rem; line-height: 1.4;">Designation</div>
                                    </td>
                                    <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                        <div class="d-flex align-items-center gap-2 mb-1" style="font-size: 1.25rem; color: #1f2937;">
                                            <i class="fa-solid fa-phone" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                            <span class="officer-phone" contenteditable="true">011-XXXXXXXX /Ext.- XXX</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2" style="font-size: 1.25rem; color: #1f2937;">
                                            <i class="fa-regular fa-envelope" style="font-size: 13px; color: #374151; width: 14px;"></i>
                                            <span class="officer-email" contenteditable="true">officer[dot]mot[at]gov[dot]in</span>
                                        </div>
                                    </td>
                                    <td style="padding: 16px 18px; vertical-align: top; border: none;">
                                        <div class="officer-address" contenteditable="true" style="color: #374151; font-size: 1.25rem; line-height: 1.5;">Room No. XXX, Xth Floor, GPOA-3, Netaji Nagar, New Delhi–110023</div>
                                    </td>
                                    <td class="editor-row-ctrl text-center" style="vertical-align: top; padding: 16px 6px; border: none;">
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeDirRow(this)" title="Delete Row" style="font-size: 15px; text-decoration: none;">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
            const newSection = temp.firstElementChild;
            currentWrap.parentNode.insertBefore(newSection, currentWrap.nextSibling);
            showToast('New department section added below!');
        }

        // ============================================================
        // UNIVERSAL CLEAN DATA TABLE OPERATIONS (ADD/REMOVE ROWS & COLUMNS, CELL IMAGES, PAGINATION)
        // ============================================================
        function addDbimTableRow(triggerBtn) {
            const tableWrap = triggerBtn.closest('.dbim-data-table-wrapper');
            if (!tableWrap) return;
            const table = tableWrap.querySelector('table');
            if (!table) return;
            const thead = table.querySelector('thead');
            const tbody = table.querySelector('tbody');
            if (!tbody) return;

            const headerCols = thead ? Array.from(thead.querySelectorAll('tr:first-child th')) : [];
            const tr = document.createElement('tr');
            tr.className = 'dbim-table-row';
            tr.setAttribute('data-table-row', 'true');
            tr.style.cssText = 'border-bottom: 1px solid #f1edf0; transition: background 0.15s;';

            const newRowNum = tbody.querySelectorAll('tr').length + 1;

            headerCols.forEach((th, idx) => {
                if (th.classList.contains('editor-table-ctrl')) {
                    const td = document.createElement('td');
                    td.className = 'editor-table-ctrl text-center';
                    td.style.cssText = 'vertical-align: middle; padding: 14px 6px; border: none;';
                    td.innerHTML = `
                        <button type="button" class="btn btn-sm btn-link text-danger p-0 editor-table-btn" onclick="removeDbimTableRow(this)" title="Delete Row" style="font-size: 15px; text-decoration: none;">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    `;
                    tr.appendChild(td);
                } else if (th.classList.contains('col-image-head')) {
                    const td = document.createElement('td');
                    td.className = 'col-image-cell';
                    td.style.cssText = 'padding: 14px 16px; vertical-align: middle; border: none;';
                    td.innerHTML = `
                        <div class="dbim-table-img-wrap position-relative d-inline-block">
                            <img src="/assets/images/Textiles_Committee_Logo.png" class="dbim-table-img rounded border" style="max-height: 42px; max-width: 80px; object-fit: contain; cursor: pointer;" onclick="openAvatarModal(this)" title="Click to change image">
                            <button type="button" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 p-0 rounded-circle editor-table-btn" style="width: 16px; height: 16px; font-size: 8px; line-height: 16px;" onclick="openAvatarModal(this)" title="Change Image"><i class="fa-solid fa-camera"></i></button>
                        </div>
                    `;
                    tr.appendChild(td);
                } else if (th.classList.contains('col-action-head')) {
                    const td = document.createElement('td');
                    td.className = 'col-action-cell';
                    td.style.cssText = 'padding: 14px 16px; vertical-align: middle; border: none;';
                    td.innerHTML = `
                        <div class="d-flex align-items-center gap-1">
                            <a href="#" class="btn btn-sm text-white px-3 py-1 dbim-action-btn" style="background: #721835; font-size: 1.15rem; font-weight: 600; text-decoration: none; border-radius: 4px;" contenteditable="true">
                                <i class="fa-solid fa-eye me-1"></i> View Project
                            </a>
                        </div>
                    `;
                    tr.appendChild(td);
                } else {
                    const td = document.createElement('td');
                    td.style.cssText = 'padding: 14px 16px; vertical-align: middle; border: none;';
                    const isSrNo = (idx === 0);
                    td.innerHTML = `
                        <div class="dbim-cell-text ${isSrNo ? 'fw-bold text-muted sr-no-cell' : ''}" contenteditable="true" style="color: ${isSrNo ? '#6b7280' : '#111827'}; font-size: 1.35rem; line-height: 1.4;">
                            ${isSrNo ? newRowNum : 'New Entry Details'}
                        </div>
                    `;
                    tr.appendChild(td);
                }
            });

            tbody.appendChild(tr);
            renderDbimTablePagination(tableWrap);
            showToast('New row added to table!');
        }

        function removeDbimTableRow(btn) {
            const tr = btn.closest('tr');
            if (!tr) return;
            const tableWrap = tr.closest('.dbim-data-table-wrapper');
            const tbody = tr.closest('tbody');
            if (tbody && tbody.querySelectorAll('tr').length <= 1) {
                if (!confirm('This is the only row in the table. Remove it?')) return;
            }
            tr.remove();
            if (tbody) {
                tbody.querySelectorAll('tr').forEach((row, i) => {
                    const srCell = row.querySelector('.sr-no-cell');
                    if (srCell) srCell.textContent = (i + 1);
                });
            }
            if (tableWrap) renderDbimTablePagination(tableWrap);
            showToast('Row removed from table.');
        }

        function addDbimTableColumn(triggerBtn) {
            const tableWrap = triggerBtn.closest('.dbim-data-table-wrapper');
            if (!tableWrap) return;
            const table = tableWrap.querySelector('table');
            if (!table) return;
            const theadTr = table.querySelector('thead tr');
            const tbody = table.querySelector('tbody');
            if (!theadTr || !tbody) return;

            const colName = prompt('Enter Column Title:', 'NEW COLUMN');
            if (!colName) return;

            const ctrlTh = theadTr.querySelector('th.editor-table-ctrl');
            const newTh = document.createElement('th');
            newTh.style.cssText = 'padding: 12px 16px; color: #721835; font-weight: 700; font-size: 1.2rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;';
            newTh.innerHTML = `
                <span class="col-title" contenteditable="true">${colName}</span>
                <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-1 editor-table-btn" onclick="removeDbimTableColumn(this)" title="Delete Column"><i class="fa-solid fa-xmark"></i></button>
            `;
            if (ctrlTh) {
                theadTr.insertBefore(newTh, ctrlTh);
            } else {
                theadTr.appendChild(newTh);
            }

            tbody.querySelectorAll('tr').forEach(row => {
                const ctrlTd = row.querySelector('td.editor-table-ctrl');
                const newTd = document.createElement('td');
                newTd.style.cssText = 'padding: 14px 16px; vertical-align: middle; border: none;';
                newTd.innerHTML = `<div class="dbim-cell-text" contenteditable="true" style="color: #111827; font-size: 1.35rem; line-height: 1.4;">Cell content</div>`;
                if (ctrlTd) {
                    row.insertBefore(newTd, ctrlTd);
                } else {
                    row.appendChild(newTd);
                }
            });

            showToast(`Column '${colName}' added to table!`);
        }

        function addDbimTableImageColumn(triggerBtn) {
            const tableWrap = triggerBtn.closest('.dbim-data-table-wrapper');
            if (!tableWrap) return;
            const table = tableWrap.querySelector('table');
            if (!table) return;
            const theadTr = table.querySelector('thead tr');
            const tbody = table.querySelector('tbody');
            if (!theadTr || !tbody) return;

            const ctrlTh = theadTr.querySelector('th.editor-table-ctrl');
            const newTh = document.createElement('th');
            newTh.className = 'col-image-head';
            newTh.style.cssText = 'width: 14%; padding: 12px 16px; color: #721835; font-weight: 700; font-size: 1.2rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;';
            newTh.innerHTML = `
                <span class="col-title" contenteditable="true">IMAGE / LOGO</span>
                <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-1 editor-table-btn" onclick="removeDbimTableColumn(this)" title="Delete Column"><i class="fa-solid fa-xmark"></i></button>
            `;
            if (ctrlTh) theadTr.insertBefore(newTh, ctrlTh);
            else theadTr.appendChild(newTh);

            tbody.querySelectorAll('tr').forEach(row => {
                const ctrlTd = row.querySelector('td.editor-table-ctrl');
                const newTd = document.createElement('td');
                newTd.className = 'col-image-cell';
                newTd.style.cssText = 'padding: 14px 16px; vertical-align: middle; border: none;';
                newTd.innerHTML = `
                    <div class="dbim-table-img-wrap position-relative d-inline-block">
                        <img src="/assets/images/Textiles_Committee_Logo.png" class="dbim-table-img rounded border" style="max-height: 42px; max-width: 80px; object-fit: contain; cursor: pointer;" onclick="openAvatarModal(this)" title="Click to change image">
                        <button type="button" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 p-0 rounded-circle editor-table-btn" style="width: 16px; height: 16px; font-size: 8px; line-height: 16px;" onclick="openAvatarModal(this)" title="Change Image"><i class="fa-solid fa-camera"></i></button>
                    </div>
                `;
                if (ctrlTd) row.insertBefore(newTd, ctrlTd);
                else row.appendChild(newTd);
            });

            showToast('Image column added to table!');
        }

        function addDbimTableActionColumn(triggerBtn) {
            const tableWrap = triggerBtn.closest('.dbim-data-table-wrapper');
            if (!tableWrap) return;
            const table = tableWrap.querySelector('table');
            if (!table) return;
            const theadTr = table.querySelector('thead tr');
            const tbody = table.querySelector('tbody');
            if (!theadTr || !tbody) return;

            const ctrlTh = theadTr.querySelector('th.editor-table-ctrl');
            const newTh = document.createElement('th');
            newTh.className = 'col-action-head';
            newTh.style.cssText = 'width: 16%; padding: 12px 16px; color: #721835; font-weight: 700; font-size: 1.2rem; text-transform: uppercase; letter-spacing: 0.5px; border: none;';
            newTh.innerHTML = `
                <span class="col-title" contenteditable="true">ACTION</span>
                <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-1 editor-table-btn" onclick="removeDbimTableColumn(this)" title="Delete Column"><i class="fa-solid fa-xmark"></i></button>
            `;
            if (ctrlTh) theadTr.insertBefore(newTh, ctrlTh);
            else theadTr.appendChild(newTh);

            tbody.querySelectorAll('tr').forEach(row => {
                const ctrlTd = row.querySelector('td.editor-table-ctrl');
                const newTd = document.createElement('td');
                newTd.className = 'col-action-cell';
                newTd.style.cssText = 'padding: 14px 16px; vertical-align: middle; border: none;';
                newTd.innerHTML = `
                    <div class="d-flex align-items-center gap-1">
                        <a href="#" class="btn btn-sm text-white px-3 py-1 dbim-action-btn" style="background: #721835; font-size: 1.15rem; font-weight: 600; text-decoration: none; border-radius: 4px;" contenteditable="true">
                            <i class="fa-solid fa-eye me-1"></i> View Project
                        </a>
                    </div>
                `;
                if (ctrlTd) row.insertBefore(newTd, ctrlTd);
                else row.appendChild(newTd);
            });

            showToast('Action button column added to table!');
        }

        function removeDbimTableColumn(btn) {
            const th = btn.closest('th');
            if (!th) return;
            const titleSpan = th.querySelector('.col-title');
            const colTitle = titleSpan ? titleSpan.textContent.trim() : 'this column';
            if (!confirm(`Delete column "${colTitle}" and all its row data?`)) return;

            const theadTr = th.parentElement;
            const colIndex = Array.from(theadTr.children).indexOf(th);
            const table = th.closest('table');
            if (!table || colIndex === -1) return;

            th.remove();

            table.querySelectorAll('tbody tr').forEach(row => {
                if (row.children[colIndex]) {
                    row.children[colIndex].remove();
                }
            });

            showToast(`Column "${colTitle}" removed.`);
        }

        function addDbimTableCellImage(btn) {
            const td = btn.closest('td');
            if (!td) return;
            let wrap = td.querySelector('.dbim-table-img-wrap');
            if (!wrap) {
                wrap = document.createElement('div');
                wrap.className = 'dbim-table-img-wrap position-relative d-inline-block my-1';
                wrap.innerHTML = `
                    <img src="/assets/images/Textiles_Committee_Logo.png" class="dbim-table-img rounded border" style="max-height: 42px; max-width: 80px; object-fit: contain; cursor: pointer;" onclick="openAvatarModal(this)" title="Click to change image">
                    <button type="button" class="btn btn-sm btn-dark position-absolute bottom-0 end-0 p-0 rounded-circle editor-table-btn" style="width: 16px; height: 16px; font-size: 8px; line-height: 16px;" onclick="openAvatarModal(this)" title="Change Image"><i class="fa-solid fa-camera"></i></button>
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 p-0 rounded-circle editor-table-btn" style="width: 16px; height: 16px; font-size: 8px; line-height: 16px;" onclick="removeDbimTableCellImage(this)" title="Remove Image"><i class="fa-solid fa-xmark"></i></button>
                `;
                td.appendChild(wrap);
            }
            openAvatarModal(wrap.querySelector('img'));
        }

        function removeDbimTableCellImage(btn) {
            const wrap = btn.closest('.dbim-table-img-wrap');
            if (wrap) wrap.remove();
        }

        // ============================================================
        // PAGINATION & LIVE SEARCH FOR DATA TABLE
        // ============================================================
        function changeDbimTablePageSize(selectEl) {
            const tableWrap = selectEl.closest('.dbim-data-table-wrapper');
            if (!tableWrap) return;
            tableWrap.setAttribute('data-page-size', selectEl.value);
            tableWrap.setAttribute('data-current-page', '1');
            renderDbimTablePagination(tableWrap);
        }

        function gotoDbimTablePage(btn, pageNum) {
            const tableWrap = btn.closest('.dbim-data-table-wrapper');
            if (!tableWrap) return;
            tableWrap.setAttribute('data-current-page', pageNum);
            renderDbimTablePagination(tableWrap);
        }

        function filterDbimTable(inputEl) {
            const tableWrap = inputEl.closest('.dbim-data-table-wrapper');
            if (!tableWrap) return;
            const query = inputEl.value.toLowerCase().trim();
            const rows = tableWrap.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
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
            const allRows = Array.from(tableWrap.querySelectorAll('tbody tr'));
            const visibleRows = allRows.filter(r => r.getAttribute('data-search-hidden') !== 'true');
            const total = visibleRows.length;

            const rawSize = tableWrap.getAttribute('data-page-size') || '5';
            const pageSize = (rawSize === 'all') ? total : (parseInt(rawSize) || 5);
            let currentPage = parseInt(tableWrap.getAttribute('data-current-page')) || 1;

            const totalPages = Math.max(1, Math.ceil(total / pageSize));
            if (currentPage > totalPages) currentPage = totalPages;
            tableWrap.setAttribute('data-current-page', currentPage);

            const start = (currentPage - 1) * pageSize;
            const end = (rawSize === 'all') ? total : Math.min(start + pageSize, total);

            allRows.forEach(row => {
                if (row.getAttribute('data-search-hidden') === 'true') {
                    row.style.display = 'none';
                } else {
                    const rowIdx = visibleRows.indexOf(row);
                    if (rowIdx >= start && rowIdx < end) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });

            const infoEl = tableWrap.querySelector('.dbim-table-info');
            if (infoEl) {
                if (total === 0) {
                    infoEl.textContent = 'Showing 0 entries';
                } else {
                    infoEl.textContent = `Showing ${start + 1} to ${end} of ${total} entries`;
                }
            }

            const ul = tableWrap.querySelector('.dbim-table-pagination');
            if (!ul) return;

            let html = '';
            const prevDisabled = (currentPage <= 1);
            html += `<li class="page-item ${prevDisabled ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0)" onclick="${prevDisabled ? '' : 'gotoDbimTablePage(this, ' + (currentPage - 1) + ')'}" style="border-radius: 4px;">&laquo; Prev</a>
            </li>`;

            for (let p = 1; p <= totalPages; p++) {
                const isActive = (p === currentPage);
                html += `<li class="page-item ${isActive ? 'active' : ''}">
                    <a class="page-link" href="javascript:void(0)" onclick="gotoDbimTablePage(this, ${p})" style="${isActive ? 'background: #721835; border-color: #721835; color: #fff;' : ''} border-radius: 4px;">${p}</a>
                </li>`;
            }

            const nextDisabled = (currentPage >= totalPages);
            html += `<li class="page-item ${nextDisabled ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0)" onclick="${nextDisabled ? '' : 'gotoDbimTablePage(this, ' + (currentPage + 1) + ')'}" style="border-radius: 4px;">Next &raquo;</a>
            </li>`;

            ul.innerHTML = html;
        }

        function initAllDbimTables() {
            document.querySelectorAll('.dbim-data-table-wrapper').forEach(renderDbimTablePagination);
        }

        // ============================================================
        // ADVANCED PRO GRID TABLE (SPANS, THEAD, ROW & COLUMN BUILDER)
        // ============================================================
        let activeProCell = null;
        let activeProTableWrap = null;

        document.addEventListener('click', function(e) {
            const cell = e.target.closest('.dbim-pro-table th, .dbim-pro-table td');
            if (cell) {
                selectProTableCell(cell);
            }
        });

        function selectProTableCell(cell) {
            if (!cell) return;
            document.querySelectorAll('.pro-cell-active').forEach(el => el.classList.remove('pro-cell-active'));
            activeProCell = cell;
            activeProTableWrap = cell.closest('.dbim-advanced-table-wrapper');
            cell.classList.add('pro-cell-active');

            if (activeProTableWrap) {
                const infoEl = activeProTableWrap.querySelector('.selected-cell-info');
                if (infoEl) {
                    const row = cell.closest('tr');
                    const rowIndex = row ? row.rowIndex + 1 : '?';
                    const colIndex = cell.cellIndex + 1;
                    const rspan = cell.getAttribute('rowspan') || 1;
                    const cspan = cell.getAttribute('colspan') || 1;
                    const tag = cell.tagName.toLowerCase();
                    infoEl.innerHTML = `<b style="color: #721835;">${tag.toUpperCase()}</b> [Row ${rowIndex}, Col ${colIndex}] &bull; Colspan: <b>${cspan}</b> &bull; Rowspan: <b>${rspan}</b>`;
                }
            }
        }

        function getActiveProCell(triggerEl) {
            if (activeProCell && document.contains(activeProCell)) {
                if (triggerEl) {
                    const wrap = triggerEl.closest('.dbim-advanced-table-wrapper');
                    if (wrap && wrap.contains(activeProCell)) {
                        return activeProCell;
                    }
                } else {
                    return activeProCell;
                }
            }
            if (triggerEl) {
                const wrap = triggerEl.closest('.dbim-advanced-table-wrapper');
                if (wrap) {
                    const firstCell = wrap.querySelector('.dbim-pro-table th, .dbim-pro-table td');
                    if (firstCell) {
                        selectProTableCell(firstCell);
                        return firstCell;
                    }
                }
            }
            return null;
        }

        function quickAdjustProCellSpan(triggerBtn, type, delta) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) {
                alert('Please click on a table cell first to adjust its span.');
                return;
            }

            const attr = type === 'colspan' ? 'colspan' : 'rowspan';
            let current = parseInt(cell.getAttribute(attr)) || 1;
            let next = current + delta;
            if (next < 1) next = 1;
            if (next > 30) next = 30;

            if (next === 1) {
                cell.removeAttribute(attr);
            } else {
                cell.setAttribute(attr, next);
            }

            selectProTableCell(cell);
            showToast(`${attr.toUpperCase()} updated to ${next}`);
        }

        function openProCellSettingsModal(triggerBtn) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) {
                alert('Please click on a table cell first to inspect its properties.');
                return;
            }

            const tagSelect = document.getElementById('proCellTagSelect');
            const colspanInput = document.getElementById('proCellColspanInput');
            const rowspanInput = document.getElementById('proCellRowspanInput');
            const alignSelect = document.getElementById('proCellAlignSelect');
            const valignSelect = document.getElementById('proCellValignSelect');
            const bgInput = document.getElementById('proCellBgInput');
            const textColorInput = document.getElementById('proCellTextColorInput');
            const widthInput = document.getElementById('proCellWidthInput');

            if (tagSelect) tagSelect.value = cell.tagName.toLowerCase();
            if (colspanInput) colspanInput.value = cell.getAttribute('colspan') || 1;
            if (rowspanInput) rowspanInput.value = cell.getAttribute('rowspan') || 1;
            if (alignSelect) {
                if (cell.classList.contains('text-center') || cell.style.textAlign === 'center') alignSelect.value = 'center';
                else if (cell.classList.contains('text-end') || cell.style.textAlign === 'right') alignSelect.value = 'right';
                else alignSelect.value = 'left';
            }
            if (valignSelect) {
                if (cell.classList.contains('align-top') || cell.style.verticalAlign === 'top') valignSelect.value = 'top';
                else if (cell.classList.contains('align-bottom') || cell.style.verticalAlign === 'bottom') valignSelect.value = 'bottom';
                else valignSelect.value = 'middle';
            }
            if (bgInput) bgInput.value = cell.style.backgroundColor || '';
            if (textColorInput) textColorInput.value = cell.style.color || '';
            if (widthInput) widthInput.value = cell.style.width || '';

            const modalEl = document.getElementById('proTableCellModal');
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        }

        function applyProCellSettings() {
            let cell = activeProCell;
            if (!cell || !document.contains(cell)) return;

            const tagSelect = document.getElementById('proCellTagSelect').value;
            const colspanVal = parseInt(document.getElementById('proCellColspanInput').value) || 1;
            const rowspanVal = parseInt(document.getElementById('proCellRowspanInput').value) || 1;
            const alignVal = document.getElementById('proCellAlignSelect').value;
            const valignVal = document.getElementById('proCellValignSelect').value;
            const bgVal = document.getElementById('proCellBgInput').value.trim();
            const textColorVal = document.getElementById('proCellTextColorInput').value.trim();
            const widthVal = document.getElementById('proCellWidthInput').value.trim();

            if (cell.tagName.toLowerCase() !== tagSelect) {
                const newEl = document.createElement(tagSelect);
                Array.from(cell.attributes).forEach(attr => newEl.setAttribute(attr.name, attr.value));
                newEl.innerHTML = cell.innerHTML;
                cell.parentNode.replaceChild(newEl, cell);
                cell = newEl;
                activeProCell = newEl;
            }

            if (colspanVal > 1) cell.setAttribute('colspan', colspanVal);
            else cell.removeAttribute('colspan');

            if (rowspanVal > 1) cell.setAttribute('rowspan', rowspanVal);
            else cell.removeAttribute('rowspan');

            cell.classList.remove('text-start', 'text-center', 'text-end');
            if (alignVal === 'center') cell.classList.add('text-center');
            else if (alignVal === 'right') cell.classList.add('text-end');
            else cell.classList.add('text-start');

            cell.classList.remove('align-top', 'align-middle', 'align-bottom');
            if (valignVal === 'top') cell.classList.add('align-top');
            else if (valignVal === 'bottom') cell.classList.add('align-bottom');
            else cell.classList.add('align-middle');

            if (bgVal) cell.style.backgroundColor = bgVal;
            else cell.style.backgroundColor = '';

            if (textColorVal) cell.style.color = textColorVal;
            else cell.style.color = '';

            if (widthVal) cell.style.width = widthVal;
            else cell.style.width = '';

            selectProTableCell(cell);

            const modalEl = document.getElementById('proTableCellModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();

            showToast('Cell properties applied!');
        }

        function resetProCellSpans() {
            const cell = activeProCell;
            if (!cell) return;
            cell.removeAttribute('colspan');
            cell.removeAttribute('rowspan');
            document.getElementById('proCellColspanInput').value = 1;
            document.getElementById('proCellRowspanInput').value = 1;
            selectProTableCell(cell);
            showToast('Cell spans reset to 1x1');
        }

        function addProTableRow(triggerBtn, position = 'below') {
            const cell = getActiveProCell(triggerBtn);
            const tableWrap = triggerBtn.closest('.dbim-advanced-table-wrapper');
            if (!tableWrap) return;
            const table = tableWrap.querySelector('.dbim-pro-table');
            if (!table) return;

            let targetTr = cell ? cell.closest('tr') : table.querySelector('tbody tr:last-child');
            let tbody = table.querySelector('tbody');
            if (!tbody) {
                tbody = document.createElement('tbody');
                table.appendChild(tbody);
            }

            let colCount = 6;
            const firstRow = table.querySelector('tr');
            if (firstRow) {
                let count = 0;
                firstRow.querySelectorAll('th, td').forEach(c => {
                    count += (parseInt(c.getAttribute('colspan')) || 1);
                });
                if (count > 0) colCount = count;
            }

            const newTr = document.createElement('tr');
            for (let i = 0; i < colCount; i++) {
                const newTd = document.createElement('td');
                newTd.className = (i === 0 || i >= colCount - 1) ? 'text-center align-middle' : 'align-middle';
                newTd.contentEditable = 'true';
                newTd.innerText = (i === 0) ? (tbody.querySelectorAll('tr').length + 1) : 'New Data';
                newTr.appendChild(newTd);
            }

            if (targetTr && targetTr.parentElement === tbody) {
                if (position === 'above') {
                    targetTr.before(newTr);
                } else {
                    targetTr.after(newTr);
                }
            } else {
                tbody.appendChild(newTr);
            }

            selectProTableCell(newTr.querySelector('td'));
            showToast('New row inserted ' + position);
        }

        function duplicateProTableRow(triggerBtn) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) {
                alert('Please click on a table cell to select the row to duplicate.');
                return;
            }
            const tr = cell.closest('tr');
            if (!tr) return;
            const table = tr.closest('.dbim-pro-table');
            if (!table) return;

            // Deep clone the row
            const clonedTr = tr.cloneNode(true);

            // Clean up temporary editor active states on cloned cells
            clonedTr.querySelectorAll('.pro-cell-active').forEach(c => c.classList.remove('pro-cell-active'));

            // In cloned row, reset any rowspan to 1 so it doesn't double-extend downwards
            clonedTr.querySelectorAll('th, td').forEach(c => {
                c.removeAttribute('rowspan');
                c.contentEditable = 'true';
            });

            // Auto-increment numeric sequence (e.g. S.No) in first column if applicable
            const firstCell = clonedTr.querySelector('td, th');
            if (firstCell) {
                const num = parseInt(firstCell.innerText.trim());
                if (!isNaN(num)) {
                    const tbody = tr.closest('tbody');
                    if (tbody) {
                        firstCell.innerText = tbody.querySelectorAll('tr').length + 1;
                    } else {
                        firstCell.innerText = num + 1;
                    }
                }
            }

            // Insert immediately after current row
            tr.after(clonedTr);

            const newActive = clonedTr.querySelector('td, th');
            if (newActive) selectProTableCell(newActive);

            showToast('Row duplicated successfully!');
        }

        function getTableGridMap(table) {
            const grid = [];
            const rows = table.querySelectorAll('tr');
            rows.forEach((tr, rIdx) => {
                if (!grid[rIdx]) grid[rIdx] = [];
                let cIdx = 0;
                Array.from(tr.children).forEach(cell => {
                    while (grid[rIdx][cIdx] !== undefined) {
                        cIdx++;
                    }
                    const rSpan = parseInt(cell.getAttribute('rowspan')) || 1;
                    const cSpan = parseInt(cell.getAttribute('colspan')) || 1;
                    for (let r = 0; r < rSpan; r++) {
                        if (!grid[rIdx + r]) grid[rIdx + r] = [];
                        for (let c = 0; c < cSpan; c++) {
                            grid[rIdx + r][cIdx + c] = cell;
                        }
                    }
                    cIdx += cSpan;
                });
            });
            return grid;
        }

        function getCellVisualColIndex(cell, table) {
            const grid = getTableGridMap(table);
            const row = cell.closest('tr');
            if (!row) return cell.cellIndex;
            const rIdx = Array.from(table.querySelectorAll('tr')).indexOf(row);
            if (rIdx >= 0 && grid[rIdx]) {
                for (let c = 0; c < grid[rIdx].length; c++) {
                    if (grid[rIdx][c] === cell) {
                        return c;
                    }
                }
            }
            return cell.cellIndex;
        }

        function deleteProTableRow(triggerBtn) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) {
                alert('Please click on a table cell to select the row to delete.');
                return;
            }
            const tr = cell.closest('tr');
            if (!tr) return;
            const table = tr.closest('.dbim-pro-table');
            if (!table) return;

            const allRows = Array.from(table.querySelectorAll('tr'));
            if (allRows.length <= 1) {
                alert('Cannot delete the only row in this table.');
                return;
            }

            if (!confirm('Delete this row and cleanly adjust connected rowspans?')) return;

            const rIdx = allRows.indexOf(tr);
            const grid = getTableGridMap(table);
            const processedCells = new Set();
            const nextRow = tr.nextElementSibling && tr.nextElementSibling.tagName === 'TR' ? tr.nextElementSibling : null;

            // Adjust cells from earlier rows that span down across this row
            for (let prevIdx = 0; prevIdx < rIdx; prevIdx++) {
                const prevRowCells = grid[prevIdx] || [];
                prevRowCells.forEach(c => {
                    if (c && !processedCells.has(c)) {
                        processedCells.add(c);
                        const rSpan = parseInt(c.getAttribute('rowspan')) || 1;
                        if (prevIdx + rSpan > rIdx) {
                            const newSpan = rSpan - 1;
                            if (newSpan <= 1) {
                                c.removeAttribute('rowspan');
                            } else {
                                c.setAttribute('rowspan', newSpan);
                            }
                        }
                    }
                });
            }

            // Adjust cells in the row being deleted that span downwards
            Array.from(tr.children).forEach(c => {
                const rSpan = parseInt(c.getAttribute('rowspan')) || 1;
                if (rSpan > 1 && nextRow) {
                    const newSpan = rSpan - 1;
                    if (newSpan <= 1) {
                        c.removeAttribute('rowspan');
                    } else {
                        c.setAttribute('rowspan', newSpan);
                    }
                    nextRow.prepend(c);
                }
            });

            const nextActive = nextRow ? nextRow.querySelector('th, td') : (tr.previousElementSibling ? tr.previousElementSibling.querySelector('th, td') : null);
            tr.remove();
            if (nextActive) selectProTableCell(nextActive);
            else activeProCell = null;

            showToast('Row deleted and rowspans adjusted');
        }

        function moveProTableRow(triggerBtn, direction) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) return;
            const tr = cell.closest('tr');
            if (!tr) return;

            if (direction === 'up') {
                const prev = tr.previousElementSibling;
                if (prev && prev.tagName === 'TR') {
                    prev.before(tr);
                    showToast('Row moved up');
                }
            } else {
                const next = tr.nextElementSibling;
                if (next && next.tagName === 'TR') {
                    next.after(tr);
                    showToast('Row moved down');
                }
            }
            selectProTableCell(cell);
        }

        function addProTableColumn(triggerBtn, position = 'right') {
            const cell = getActiveProCell(triggerBtn);
            const tableWrap = triggerBtn.closest('.dbim-advanced-table-wrapper');
            if (!tableWrap) return;
            const table = tableWrap.querySelector('.dbim-pro-table');
            if (!table) return;

            const colIndex = cell ? cell.cellIndex : -1;
            const allRows = table.querySelectorAll('tr');

            allRows.forEach(tr => {
                const isHeader = tr.closest('thead') !== null;
                const newCell = document.createElement(isHeader ? 'th' : 'td');
                newCell.className = 'text-center align-middle';
                newCell.contentEditable = 'true';
                newCell.innerText = isHeader ? 'New Header' : 'New Val';
                if (isHeader) {
                    newCell.style.background = '#721835';
                    newCell.style.color = '#ffffff';
                    newCell.style.border = '1px solid #9c2759';
                }

                const cells = tr.children;
                if (colIndex >= 0 && colIndex < cells.length) {
                    const targetCell = cells[colIndex];
                    if (position === 'left') {
                        targetCell.before(newCell);
                    } else {
                        targetCell.after(newCell);
                    }
                } else {
                    tr.appendChild(newCell);
                }
            });

            showToast('New column inserted ' + position);
        }

        function duplicateProTableColumn(triggerBtn) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) {
                alert('Please click on a table cell to select the column to duplicate.');
                return;
            }
            const tableWrap = triggerBtn ? triggerBtn.closest('.dbim-advanced-table-wrapper') : cell.closest('.dbim-advanced-table-wrapper');
            if (!tableWrap) return;
            const table = tableWrap.querySelector('.dbim-pro-table');
            if (!table) return;

            const targetColIdx = getCellVisualColIndex(cell, table);
            const grid = getTableGridMap(table);
            const processedCells = new Set();

            grid.forEach(rowCells => {
                const cellAtCol = rowCells[targetColIdx];
                if (cellAtCol && !processedCells.has(cellAtCol)) {
                    processedCells.add(cellAtCol);
                    const cSpan = parseInt(cellAtCol.getAttribute('colspan')) || 1;
                    if (cSpan > 1) {
                        // Expand the covering header/merged cell span by +1
                        cellAtCol.setAttribute('colspan', cSpan + 1);
                    } else {
                        // Clone the cell and insert right after cellAtCol
                        const clonedCell = cellAtCol.cloneNode(true);
                        clonedCell.classList.remove('pro-cell-active');
                        clonedCell.contentEditable = 'true';
                        cellAtCol.after(clonedCell);
                    }
                }
            });

            selectProTableCell(cell);
            showToast('Column duplicated successfully!');
        }

        function deleteProTableColumn(triggerBtn) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) {
                alert('Please click on a table cell to select the column to delete.');
                return;
            }
            const tableWrap = triggerBtn ? triggerBtn.closest('.dbim-advanced-table-wrapper') : cell.closest('.dbim-advanced-table-wrapper');
            if (!tableWrap) return;
            const table = tableWrap.querySelector('.dbim-pro-table');
            if (!table) return;

            if (!confirm('Delete this column and cleanly adjust connected colspans?')) return;

            const targetColIdx = getCellVisualColIndex(cell, table);
            const grid = getTableGridMap(table);
            const processedCells = new Set();

            grid.forEach(rowCells => {
                const cellAtCol = rowCells[targetColIdx];
                if (cellAtCol && !processedCells.has(cellAtCol)) {
                    processedCells.add(cellAtCol);
                    const cSpan = parseInt(cellAtCol.getAttribute('colspan')) || 1;
                    if (cSpan > 1) {
                        const newSpan = cSpan - 1;
                        if (newSpan <= 1) {
                            cellAtCol.removeAttribute('colspan');
                        } else {
                            cellAtCol.setAttribute('colspan', newSpan);
                        }
                    } else {
                        cellAtCol.remove();
                    }
                }
            });

            activeProCell = null;
            showToast('Column deleted and colspans adjusted');
        }

        function deleteProCell(triggerBtn) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) {
                alert('Please click on the unwanted cell you wish to delete.');
                return;
            }
            const tr = cell.closest('tr');
            if (!tr) return;

            if (confirm('Delete this individual unwanted cell?')) {
                const nextCell = cell.nextElementSibling || cell.previousElementSibling || tr.querySelector('th, td');
                cell.remove();
                if (nextCell && nextCell !== cell && document.contains(nextCell)) {
                    selectProTableCell(nextCell);
                } else {
                    activeProCell = null;
                }
                showToast('Unwanted cell deleted');
            }
        }

        function clearProCellSpans(triggerBtn) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) {
                alert('Please click on a merged cell to unmerge.');
                return;
            }
            cell.removeAttribute('colspan');
            cell.removeAttribute('rowspan');
            selectProTableCell(cell);
            showToast('Cell unmerged (rowspan & colspan reset to 1x1)');
        }

        function addProTableHeaderRow(triggerBtn, position = 'below') {
            const tableWrap = triggerBtn.closest('.dbim-advanced-table-wrapper');
            if (!tableWrap) return;
            const table = tableWrap.querySelector('.dbim-pro-table');
            if (!table) return;

            let thead = table.querySelector('thead');
            if (!thead) {
                thead = document.createElement('thead');
                table.prepend(thead);
            }

            let colCount = 6;
            const refRow = thead.querySelector('tr') || table.querySelector('tr');
            if (refRow) {
                let count = 0;
                refRow.querySelectorAll('th, td').forEach(c => {
                    count += (parseInt(c.getAttribute('colspan')) || 1);
                });
                if (count > 0) colCount = count;
            }

            const newTr = document.createElement('tr');
            newTr.className = 'pro-thead-row pro-thead-secondary';
            newTr.style.background = '#8b1f42';
            newTr.style.color = '#ffffff';

            for (let i = 0; i < colCount; i++) {
                const newTh = document.createElement('th');
                newTh.className = 'text-center align-middle';
                newTh.contentEditable = 'true';
                newTh.innerText = 'Sub Header ' + (i + 1);
                newTh.style.background = '#8b1f42';
                newTh.style.color = '#ffffff';
                newTh.style.border = '1px solid #9c2759';
                newTr.appendChild(newTh);
            }

            if (position === 'above') {
                thead.prepend(newTr);
            } else {
                thead.appendChild(newTr);
            }

            selectProTableCell(newTr.querySelector('th'));
            showToast('Header row added ' + position);
        }

        function deleteProTableHeaderRow(triggerBtn) {
            const tableWrap = triggerBtn.closest('.dbim-advanced-table-wrapper');
            if (!tableWrap) return;
            const thead = tableWrap.querySelector('.dbim-pro-table thead');
            if (!thead) return;

            const rows = thead.querySelectorAll('tr');
            if (rows.length <= 1) {
                alert('Cannot delete the primary header row.');
                return;
            }

            const cell = getActiveProCell(triggerBtn);
            const targetRow = (cell && cell.closest('thead') === thead) ? cell.closest('tr') : rows[rows.length - 1];

            if (confirm('Delete this header row?')) {
                targetRow.remove();
                showToast('Header row removed');
            }
        }

        function setProTableHeaderTheme(triggerBtn, theme) {
            const tableWrap = triggerBtn.closest('.dbim-advanced-table-wrapper');
            if (!tableWrap) return;
            const thead = tableWrap.querySelector('.dbim-pro-table thead');
            if (!thead) return;

            let bg = '#721835', text = '#ffffff', border = '#9c2759';
            if (theme === 'soft') {
                bg = '#faebf3';
                text = '#721835';
                border = '#ebd0de';
            } else if (theme === 'grey') {
                bg = '#f1f3f5';
                text = '#333333';
                border = '#dee2e6';
            }

            thead.querySelectorAll('tr').forEach(tr => {
                tr.style.background = bg;
                tr.style.color = text;
                tr.querySelectorAll('th').forEach(th => {
                    th.style.background = bg;
                    th.style.color = text;
                    th.style.borderColor = border;
                });
            });

            showToast('Header theme set to: ' + theme);
        }

        function setProCellAlign(triggerBtn, align) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) return;
            cell.classList.remove('text-start', 'text-center', 'text-end');
            if (align === 'center') cell.classList.add('text-center');
            else if (align === 'right') cell.classList.add('text-end');
            else cell.classList.add('text-start');
            showToast('Alignment set: ' + align);
        }

        function setProCellValign(triggerBtn, valign) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) return;
            cell.classList.remove('align-top', 'align-middle', 'align-bottom');
            if (valign === 'top') cell.classList.add('align-top');
            else if (valign === 'bottom') cell.classList.add('align-bottom');
            else cell.classList.add('align-middle');
            showToast('Vertical alignment set: ' + valign);
        }

        function setProCellBg(triggerBtn, bg, text) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) return;
            cell.style.backgroundColor = bg;
            if (text) cell.style.color = text;
            showToast('Cell background updated');
        }

        function toggleProTableClass(triggerBtn, className) {
            const tableWrap = triggerBtn.closest('.dbim-advanced-table-wrapper');
            if (!tableWrap) return;
            const table = tableWrap.querySelector('.dbim-pro-table');
            if (!table) return;
            table.classList.toggle(className);
            showToast('Toggled table style: ' + className);
        }

        function insertImageInProCell(triggerBtn) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) return;
            const imgWrap = document.createElement('div');
            imgWrap.className = 'd-inline-block position-relative m-1';
            imgWrap.innerHTML = `<img src="/assets/images/Textiles_Committee_Logo.png" class="dbim-custom-img img-thumbnail" style="max-height: 48px; max-width: 80px; object-fit: contain; cursor: pointer;" onclick="openAvatarModal(this)" title="Click to replace photo">`;
            cell.appendChild(imgWrap);
            openAvatarModal(imgWrap.querySelector('img'));
        }

        function insertBadgeInProCell(triggerBtn, type) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) return;
            const badge = document.createElement('span');
            badge.className = 'badge m-1';
            badge.contentEditable = 'true';
            if (type === 'active') {
                badge.style.background = '#e6f4ea';
                badge.style.color = '#137333';
                badge.innerText = 'Completed';
            } else {
                badge.style.background = '#fef7e0';
                badge.style.color = '#b06000';
                badge.innerText = 'In Progress';
            }
            badge.style.fontSize = '11px';
            badge.style.padding = '4px 8px';
            badge.style.borderRadius = '4px';
            cell.appendChild(badge);
            showToast('Badge inserted');
        }

        function insertPdfButtonInProCell(triggerBtn) {
            const cell = getActiveProCell(triggerBtn);
            if (!cell) return;
            const btn = document.createElement('a');
            btn.href = '#';
            btn.className = 'btn btn-sm text-white py-0 px-2 m-1';
            btn.style.background = '#721835';
            btn.style.fontSize = '11px';
            btn.style.borderRadius = '4px';
            btn.setAttribute('onclick', 'openDocMediaModal(this)');
            btn.innerHTML = `<i class="fa-solid fa-file-pdf me-1"></i> View (PDF)`;
            cell.appendChild(btn);
            showToast('PDF button inserted');
        }

        // ============================================================
        // DYNAMIC IMAGE & IMAGE-WITH-TEXT COMPONENT HELPERS
        // ============================================================
        function setDbimImageShape(triggerBtn, shape) {
            const wrap = triggerBtn.closest('.dbim-custom-image-wrapper, .dbim-image-with-text-wrapper');
            if (!wrap) return;
            const img = wrap.querySelector('.dbim-custom-img') || wrap.querySelector('img');
            if (!img) return;

            // Reset shape styles
            img.style.borderRadius = '';
            img.style.border = '';
            img.style.padding = '';
            img.style.aspectRatio = '';

            if (shape === 'circle') {
                img.style.borderRadius = '50%';
                img.style.aspectRatio = '1 / 1';
                img.style.objectFit = 'cover';
            } else if (shape === 'rounded') {
                img.style.borderRadius = '14px';
                img.style.aspectRatio = '';
                img.style.objectFit = 'contain';
            } else if (shape === 'square') {
                img.style.borderRadius = '0px';
                img.style.aspectRatio = '';
            } else if (shape === 'thumbnail') {
                img.style.borderRadius = '8px';
                img.style.border = '1px solid #dee2e6';
                img.style.padding = '6px';
                img.style.backgroundColor = '#fff';
                img.style.boxShadow = '0 6px 16px rgba(0,0,0,0.06)';
            } else if (shape === 'pill') {
                img.style.borderRadius = '999px';
                img.style.aspectRatio = '16 / 9';
                img.style.objectFit = 'cover';
            }
            showToast('Image shape changed to: ' + shape);
        }

        function setDbimImageSize(triggerBtn, size) {
            const wrap = triggerBtn.closest('.dbim-custom-image-wrapper');
            if (!wrap) return;

            if (size === 'small') {
                wrap.style.maxWidth = '200px';
                wrap.style.width = '100%';
            } else if (size === 'medium') {
                wrap.style.maxWidth = '360px';
                wrap.style.width = '100%';
            } else if (size === 'large') {
                wrap.style.maxWidth = '580px';
                wrap.style.width = '100%';
            } else if (size === 'full') {
                wrap.style.maxWidth = '100%';
                wrap.style.width = '100%';
            }
            showToast('Image size updated: ' + size);
        }

        function setDbimImageAlign(triggerBtn, align) {
            const wrap = triggerBtn.closest('.dbim-custom-image-wrapper');
            if (!wrap) return;

            if (align === 'left') {
                wrap.style.marginLeft = '0';
                wrap.style.marginRight = 'auto';
                wrap.style.textAlign = 'left';
            } else if (align === 'right') {
                wrap.style.marginLeft = 'auto';
                wrap.style.marginRight = '0';
                wrap.style.textAlign = 'right';
            } else {
                wrap.style.marginLeft = 'auto';
                wrap.style.marginRight = 'auto';
                wrap.style.textAlign = 'center';
            }
            showToast('Image alignment updated: ' + align);
        }

        function toggleDbimImageCaption(triggerBtn) {
            const wrap = triggerBtn.closest('.dbim-custom-image-wrapper');
            if (!wrap) return;
            let caption = wrap.querySelector('.dbim-img-caption');
            if (caption) {
                if (caption.style.display === 'none') {
                    caption.style.display = 'block';
                } else {
                    caption.style.display = 'none';
                }
            } else {
                caption = document.createElement('figcaption');
                caption.className = 'dbim-img-caption text-muted small mt-2';
                caption.contentEditable = 'true';
                caption.style.fontSize = '1.25rem';
                caption.style.lineHeight = '1.4';
                caption.innerText = 'Add photo caption here...';
                wrap.appendChild(caption);
            }
        }

        function openDbimImageSizeModal(triggerBtn) {
            const wrap = triggerBtn.closest('.dbim-custom-image-wrapper');
            if (!wrap) return;
            openSizeAdjustModal(wrap);
        }

        function flipDbimImageTextLayout(triggerBtn) {
            const wrap = triggerBtn.closest('.dbim-image-with-text-wrapper');
            if (!wrap) return;
            const row = wrap.querySelector('.dbim-iwt-row');
            if (!row) return;

            // Toggle flex-row-reverse
            if (row.classList.contains('flex-row-reverse')) {
                row.classList.remove('flex-row-reverse');
                showToast('Image moved to Left');
            } else {
                row.classList.add('flex-row-reverse');
                showToast('Image moved to Right');
            }
        }

        function setDbimImageTextProportion(triggerBtn, percent) {
            const wrap = triggerBtn.closest('.dbim-image-with-text-wrapper');
            if (!wrap) return;
            const imgCol = wrap.querySelector('.dbim-iwt-img-col');
            const textCol = wrap.querySelector('.dbim-iwt-text-col');
            if (!imgCol || !textCol) return;

            // Remove existing col-lg-* and col-md-* classes
            imgCol.className = imgCol.className.replace(/\bcol-(lg|md)-\d+\b/g, '').trim();
            textCol.className = textCol.className.replace(/\bcol-(lg|md)-\d+\b/g, '').trim();

            if (percent === '50') {
                imgCol.classList.add('col-lg-6', 'col-md-6');
                textCol.classList.add('col-lg-6', 'col-md-6');
            } else if (percent === '25') {
                imgCol.classList.add('col-lg-3', 'col-md-4');
                textCol.classList.add('col-lg-9', 'col-md-8');
            } else { // 35 / default
                imgCol.classList.add('col-lg-4', 'col-md-5');
                textCol.classList.add('col-lg-8', 'col-md-7');
            }
            showToast('Proportion updated: ' + percent + '% image');
        }

        // ============================================================
        // AVATAR & PROFILE IMAGE UPLOADER & PICKER MODAL
        // ============================================================
        let activeAvatarImg = null;
        let avatarModalMediaList = [];

        function openAvatarModal(triggerEl) {
            if (!triggerEl) return;
            if (triggerEl.tagName && triggerEl.tagName.toLowerCase() === 'img') {
                activeAvatarImg = triggerEl;
            } else {
                const parent = triggerEl.closest('.dbim-book-cover-inner, .dbim-book-card, .position-relative, .dbim-avatar-card-wrapper, .team-node-card, .dbim-avatar-inline-box, .acts-logo-wrap, .dbim-custom-image-wrapper, .dbim-image-with-text-wrapper, [data-component]') || triggerEl.parentElement;
                activeAvatarImg = parent ? parent.querySelector('img') : null;
            }

            // Show current image preview in modal
            const currentPreview = document.getElementById('avatarModalCurrentPreview');
            if (currentPreview && activeAvatarImg) {
                currentPreview.src = activeAvatarImg.src;
            }

            const modalEl = document.getElementById('avatarPhotoModal');
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
                loadAvatarModalMedia();
            }
        }

        function uploadAvatarFile(file) {
            if (!file) return;

            const status = document.getElementById('avatarModalUploadStatus');
            if (status) {
                status.classList.remove('d-none');
                status.innerHTML = '<div class="spinner-border spinner-border-sm text-danger me-2"></div> Uploading photo...';
            }

            const formData = new FormData();
            formData.append('image', file);

            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

            fetch("{{ route('admin.pages.upload-image') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (status) status.classList.add('d-none');
                if (data.success) {
                    const imgUrl = data.relative_url || data.url;
                    if (activeAvatarImg) {
                        activeAvatarImg.src = imgUrl;
                    }
                    const modalEl = document.getElementById('avatarPhotoModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    showToast('Profile photo updated successfully!');
                } else {
                    alert(data.message || 'Image upload failed.');
                }
            })
            .catch(err => {
                if (status) status.classList.add('d-none');
                alert('Upload failed: ' + err.message);
            });
        }

        function loadAvatarModalMedia() {
            const grid = document.getElementById('avatarModalMediaGrid');
            if (!grid) return;

            fetch('{{ route('admin.media.list-api') }}')
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.data) {
                        // Filter image types
                        avatarModalMediaList = data.data.filter(item => {
                            const ext = (item.extension || '').toLowerCase();
                            return item.file_type === 'image' || ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'].includes(ext);
                        });
                        renderAvatarModalMediaGrid();
                    }
                })
                .catch(err => {
                    grid.innerHTML = '<div class="col-12 text-center text-muted py-3">Could not load media library.</div>';
                });
        }

        function filterAvatarModalMedia() {
            renderAvatarModalMediaGrid();
        }

        function renderAvatarModalMediaGrid() {
            const grid = document.getElementById('avatarModalMediaGrid');
            if (!grid) return;

            const q = (document.getElementById('avatarModalMediaSearch')?.value || '').toLowerCase().trim();
            const filtered = avatarModalMediaList.filter(item => {
                if (q && !item.name.toLowerCase().includes(q) && !item.file_name.toLowerCase().includes(q)) return false;
                return true;
            });

            if (filtered.length === 0) {
                grid.innerHTML = '<div class="col-12 text-center text-muted py-4"><i class="fa-regular fa-images fs-3 d-block mb-2"></i>No photos found. Upload a photo in Tab 1.</div>';
                return;
            }

            grid.innerHTML = filtered.map(item => {
                const fileUrl = item.disk_path ? '/' + item.disk_path : item.url;
                return `<div class="col-6 col-md-4 col-lg-3">
                    <div class="card p-1 border shadow-sm h-100 text-center" style="border-radius: 8px; cursor: pointer;" onclick="selectAvatarFromLibrary('${fileUrl}')">
                        <div style="height: 90px; overflow: hidden; border-radius: 6px; background: #f8fafc;" class="d-flex align-items-center justify-content-center mb-1">
                            <img src="${fileUrl}" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                        </div>
                        <small class="d-block text-truncate fw-bold px-1" style="font-size: 11px;" title="${item.name}">${item.name}</small>
                        <button type="button" class="btn btn-sm btn-outline-danger py-0 mt-1" style="font-size: 10px;">
                            <i class="fa-solid fa-check me-1"></i> Select
                        </button>
                    </div>
                </div>`;
            }).join('');
        }

        function selectAvatarFromLibrary(url) {
            if (activeAvatarImg) {
                activeAvatarImg.src = url;
            }
            const modalEl = document.getElementById('avatarPhotoModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
            showToast('Profile photo selected successfully!');
        }

        function setCustomAvatarUrl() {
            const input = document.getElementById('avatarManualUrlInput');
            const url = input ? input.value.trim() : '';
            if (!url) return;

            if (activeAvatarImg) {
                activeAvatarImg.src = url;
            }
            const modalEl = document.getElementById('avatarPhotoModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
            showToast('Custom photo link applied!');
        }

        function setPresetAvatar(url) {
            if (activeAvatarImg) {
                activeAvatarImg.src = url;
            }
            const modalEl = document.getElementById('avatarPhotoModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
            showToast('Preset avatar silhouette applied!');
        }

        // ============================================================
        // DBIM FAQ / ACCORDION COMPONENT HANDLERS
        // ============================================================
        function toggleFaqItem(headerEl) {
            const item = headerEl.closest('.dbim-faq-item');
            if (!item) return;
            item.classList.toggle('is-active');
        }

        function toggleAllFaqs(btn) {
            const wrapper = btn.closest('.dbim-faq-wrapper');
            if (!wrapper) return;
            const items = wrapper.querySelectorAll('.dbim-faq-item');
            const isAnyClosed = Array.from(items).some(it => !it.classList.contains('is-active'));
            items.forEach(it => {
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
            const wrapper = input.closest('.dbim-faq-wrapper');
            if (!wrapper) return;
            const query = input.value.toLowerCase().trim();
            const items = wrapper.querySelectorAll('.dbim-faq-item');
            items.forEach(item => {
                const text = item.innerText.toLowerCase();
                if (!query || text.includes(query)) {
                    item.style.display = '';
                    if (query) item.classList.add('is-active');
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function addFaqItem(btn) {
            const wrapper = btn.closest('.dbim-faq-wrapper');
            if (!wrapper) return;
            const list = wrapper.querySelector('.dbim-faq-list');
            if (!list) return;

            const count = list.querySelectorAll('.dbim-faq-item').length + 1;
            const temp = document.createElement('div');
            temp.innerHTML = `
                <div class="dbim-faq-item is-active" data-faq-item="true">
                    <div class="dbim-faq-question" onclick="toggleFaqItem(this)">
                        <div class="dbim-faq-q-left">
                            <span class="dbim-faq-badge">Q${count}</span>
                            <h4 class="dbim-faq-q-text" contenteditable="true">Enter the question here?</h4>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-link text-danger p-0 editor-faq-btn" onclick="removeFaqItem(this)" title="Delete Question" style="font-size: 15px; text-decoration: none;">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                            <span class="dbim-faq-chevron"><i class="fa-solid fa-chevron-down"></i></span>
                        </div>
                    </div>
                    <div class="dbim-faq-answer" contenteditable="true">
                        <p>Provide the detailed answer, instructions, or regulatory clarification here.</p>
                    </div>
                </div>
            `;
            const newItem = temp.firstElementChild;
            list.appendChild(newItem);
            showToast('New FAQ question added!');
        }

        function removeFaqItem(btn) {
            const item = btn.closest('.dbim-faq-item');
            if (item) {
                item.remove();
                showToast('FAQ question deleted.');
            }
        }

        // Intercept clicks on View buttons and Avatar profile photos in editor canvas to open modals directly
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('liveCanvas');
            if (canvas) {
                canvas.addEventListener('click', function(e) {
                    const viewBtn = e.target.closest('a.download-btn');
                    if (viewBtn) {
                        e.preventDefault();
                        e.stopPropagation();
                        openDocMediaModal(viewBtn);
                        return;
                    }

                    const avatarTrigger = e.target.closest('.dbim-avatar-img-wrap, .team-avatar-wrap, .editor-avatar-btn, .dbim-book-cover-img, .dbim-book-cover-inner button, .dbim-book-figure img');
                    if (avatarTrigger) {
                        e.preventDefault();
                        e.stopPropagation();
                        openAvatarModal(avatarTrigger);
                        return;
                    }
                });
            }
        });

        // ============================================================
        // DBIM BOOK, PUBLICATION & MAGAZINE CARDS HANDLERS
        // ============================================================
        function addBookCard(btn) {
            const section = btn.closest('.dbim-book-magazine-section') || document.querySelector('.dbim-book-magazine-section');
            if (!section) return;
            const grid = section.querySelector('.dbim-book-grid');
            if (!grid) return;

            const currentCols = grid.getAttribute('data-cols') || '4';
            let colClass = 'col-lg-3 col-md-6';
            if (currentCols === '2') colClass = 'col-lg-6 col-md-6';
            else if (currentCols === '3') colClass = 'col-lg-4 col-md-6';

            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = renderBookCardItemHtml({
                title: 'New Publication / Magazine Title',
                coverImg: '/assets/images/book_understanding_wto.png'
            }).trim();

            const newCol = tempDiv.firstElementChild;
            newCol.className = colClass + ' dbim-book-col';
            grid.appendChild(newCol);
            showToast('New book / publication card added!');
            newCol.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function duplicateBookCard(btn) {
            const col = btn.closest('.dbim-book-col');
            if (!col) return;
            const clone = col.cloneNode(true);
            col.parentNode.insertBefore(clone, col.nextSibling);
            showToast('Book card duplicated!');
        }

        function deleteBookCard(btn) {
            const col = btn.closest('.dbim-book-col');
            if (!col) return;
            const grid = col.closest('.dbim-book-grid');
            if (grid && grid.querySelectorAll('.dbim-book-col').length <= 1) {
                alert('At least one publication card must remain in the grid.');
                return;
            }
            if (confirm('Are you sure you want to delete this publication card?')) {
                col.remove();
                showToast('Book card deleted.');
            }
        }

        function moveBookCard(btn, direction) {
            const col = btn.closest('.dbim-book-col');
            if (!col) return;
            if (direction === -1) {
                const prev = col.previousElementSibling;
                if (prev && prev.classList.contains('dbim-book-col')) {
                    col.parentNode.insertBefore(col, prev);
                    showToast('Moved card left');
                }
            } else if (direction === 1) {
                const next = col.nextElementSibling;
                if (next && next.classList.contains('dbim-book-col')) {
                    col.parentNode.insertBefore(next, col);
                    showToast('Moved card right');
                }
            }
        }

        function setBookGridCols(btn, cols) {
            const section = btn.closest('.dbim-book-magazine-section');
            if (!section) return;
            const grid = section.querySelector('.dbim-book-grid');
            if (!grid) return;

            grid.setAttribute('data-cols', cols);

            // Update button active states in the toolbar
            const btnGroup = btn.closest('.btn-group');
            if (btnGroup) {
                btnGroup.querySelectorAll('button').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            }

            let newColClass = 'col-lg-4 col-md-6';
            if (cols === 2) newColClass = 'col-lg-6 col-md-6';
            else if (cols === 4) newColClass = 'col-lg-3 col-md-6';

            grid.querySelectorAll('.dbim-book-col').forEach(col => {
                col.className = newColClass + ' dbim-book-col';
            });
            showToast(`Switched layout to ${cols} columns`);
        }

        // ============================================================
        // PHOTO GALLERY HANDLERS
        // ============================================================
        function addPhotoCard(btn) {
            const section = btn.closest('.dbim-photo-gallery-section') || document.querySelector('.dbim-photo-gallery-section');
            if (!section) return;
            const grid = section.querySelector('.dbim-photo-grid');
            if (!grid) return;

            const currentCols = grid.getAttribute('data-cols') || '3';
            let colClass = 'col-lg-4 col-md-6';
            if (currentCols === '2') colClass = 'col-lg-6 col-md-6';
            else if (currentCols === '4') colClass = 'col-lg-3 col-md-6';

            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = renderPhotoCardItemHtml({
                title: 'New Event Photo Gallery',
                date: new Date().toLocaleDateString('en-GB'),
                itemsCount: '10',
                category: 'Convocations',
                imgUrl: '/assets/images/gallery_nift_convocation.png'
            }).trim();

            const newCol = tempDiv.firstElementChild;
            newCol.className = colClass + ' dbim-photo-col';
            grid.appendChild(newCol);
            showToast('New photo gallery item added!');
            newCol.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function duplicatePhotoCard(btn) {
            const col = btn.closest('.dbim-photo-col');
            if (!col) return;
            const clone = col.cloneNode(true);
            col.parentNode.insertBefore(clone, col.nextSibling);
            showToast('Photo item duplicated!');
        }

        function deletePhotoCard(btn) {
            const col = btn.closest('.dbim-photo-col');
            if (!col) return;
            const grid = col.closest('.dbim-photo-grid');
            if (grid && grid.querySelectorAll('.dbim-photo-col').length <= 1) {
                alert('At least one photo item must remain in the gallery.');
                return;
            }
            if (confirm('Are you sure you want to delete this photo item?')) {
                col.remove();
                showToast('Photo item deleted.');
            }
        }

        function movePhotoCard(btn, direction) {
            const col = btn.closest('.dbim-photo-col');
            if (!col) return;
            if (direction === -1) {
                const prev = col.previousElementSibling;
                if (prev && prev.classList.contains('dbim-photo-col')) {
                    col.parentNode.insertBefore(col, prev);
                    showToast('Moved photo left');
                }
            } else if (direction === 1) {
                const next = col.nextElementSibling;
                if (next && next.classList.contains('dbim-photo-col')) {
                    col.parentNode.insertBefore(next, col);
                    showToast('Moved photo right');
                }
            }
        }

        function setPhotoGridCols(btn, cols) {
            const section = btn.closest('.dbim-photo-gallery-section');
            if (!section) return;
            const grid = section.querySelector('.dbim-photo-grid');
            if (!grid) return;

            grid.setAttribute('data-cols', cols);
            const btnGroup = btn.closest('.btn-group');
            if (btnGroup) {
                btnGroup.querySelectorAll('button').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            }

            let newColClass = 'col-lg-4 col-md-6';
            if (cols === 2) newColClass = 'col-lg-6 col-md-6';
            else if (cols === 4) newColClass = 'col-lg-3 col-md-6';

            grid.querySelectorAll('.dbim-photo-col').forEach(col => {
                col.className = newColClass + ' dbim-photo-col';
            });
            showToast(`Switched layout to ${cols} columns`);
        }

        function filterPhotoGallery(input) {
            const section = input.closest('.dbim-photo-gallery-section');
            if (!section) return;
            const q = input.value.toLowerCase().trim();
            section.querySelectorAll('.dbim-photo-col').forEach(col => {
                const title = (col.querySelector('.dbim-photo-title')?.innerText || col.getAttribute('data-title') || '').toLowerCase();
                col.style.display = (!q || title.includes(q)) ? '' : 'none';
            });
        }

        function sortPhotoGallery(select) {
            const section = select.closest('.dbim-photo-gallery-section');
            if (!section) return;
            const grid = section.querySelector('.dbim-photo-grid');
            if (!grid) return;
            const cols = Array.from(grid.querySelectorAll('.dbim-photo-col'));
            const val = select.value;

            cols.sort((a, b) => {
                const titleA = (a.querySelector('.dbim-photo-title')?.innerText || '').trim();
                const titleB = (b.querySelector('.dbim-photo-title')?.innerText || '').trim();
                const dateA = (a.querySelector('.dbim-photo-date')?.innerText || '').trim();
                const dateB = (b.querySelector('.dbim-photo-date')?.innerText || '').trim();

                if (val === 'title_asc') return titleA.localeCompare(titleB);
                if (val === 'title_desc') return titleB.localeCompare(titleA);
                if (val === 'oldest') return dateA.localeCompare(dateB);
                return dateB.localeCompare(dateA);
            });
            cols.forEach(c => grid.appendChild(c));
        }

        function filterPhotoCategory(select) {
            const section = select.closest('.dbim-photo-gallery-section');
            if (!section) return;
            const cat = select.value.toLowerCase();
            section.querySelectorAll('.dbim-photo-col').forEach(col => {
                const itemCat = (col.getAttribute('data-category') || '').toLowerCase();
                const title = (col.querySelector('.dbim-photo-title')?.innerText || '').toLowerCase();
                col.style.display = (cat === 'all' || itemCat.includes(cat) || title.includes(cat)) ? '' : 'none';
            });
        }

        // ============================================================
        // VISUAL EDITOR ALBUM DETAIL & PHOTOS HANDLERS
        // ============================================================
        function openPhotoAlbum(albumSlug, el) {
            const section = el ? el.closest('.dbim-photo-gallery-section') : document.querySelector('.dbim-photo-gallery-section');
            if (!section) return;

            const albumsView = section.querySelector('.dbim-albums-view');
            const detailView = section.querySelector('.dbim-album-detail-view');
            if (!albumsView || !detailView) return;

            const card = el ? el.closest('.dbim-photo-col') : section.querySelector(`.dbim-photo-col[data-album-slug="${albumSlug}"]`);
            const title = card ? (card.querySelector('.dbim-photo-title')?.innerText || card.getAttribute('data-title') || '').trim() : '';
            const date = card ? (card.querySelector('.dbim-photo-date')?.innerText || card.getAttribute('data-date') || '').trim() : '';

            const titleEl = detailView.querySelector('.dbim-album-title-text');
            const dateEl = detailView.querySelector('.dbim-album-date-text');
            if (titleEl && title) titleEl.innerText = title;
            if (dateEl && date) dateEl.innerText = date;

            // Show selected album subgrid
            detailView.querySelectorAll('.dbim-album-subgrid').forEach(sg => sg.style.display = 'none');
            const targetSubgrid = detailView.querySelector(`.dbim-album-subgrid[data-album-slug="${albumSlug}"]`);
            if (targetSubgrid) {
                targetSubgrid.style.display = '';
            } else {
                let firstGrid = detailView.querySelector('.dbim-album-subgrid');
                if (firstGrid) firstGrid.style.display = '';
            }

            albumsView.style.display = 'none';
            detailView.style.display = 'block';
            showToast(`Opened album: ${title || albumSlug}`);
        }

        function closePhotoAlbum(btn) {
            const section = btn ? btn.closest('.dbim-photo-gallery-section') : document.querySelector('.dbim-photo-gallery-section');
            if (!section) return;

            const albumsView = section.querySelector('.dbim-albums-view');
            const detailView = section.querySelector('.dbim-album-detail-view');
            if (!albumsView || !detailView) return;

            detailView.style.display = 'none';
            albumsView.style.display = 'block';
            showToast('Returned to Photo Albums overview');
        }

        function toggleEditorAlbumView(btn) {
            const section = btn.closest('.dbim-photo-gallery-section');
            if (!section) return;
            const albumsView = section.querySelector('.dbim-albums-view');
            const detailView = section.querySelector('.dbim-album-detail-view');
            if (!albumsView || !detailView) return;

            if (albumsView.style.display === 'none') {
                closePhotoAlbum(btn);
            } else {
                openPhotoAlbum('nift-convocation-2026', btn);
            }
        }

        function addPhotoToAlbum(btn) {
            const detailView = btn.closest('.dbim-album-detail-view');
            if (!detailView) return;
            const activeSubgrid = Array.from(detailView.querySelectorAll('.dbim-album-subgrid')).find(g => g.style.display !== 'none') || detailView.querySelector('.dbim-album-subgrid');
            if (!activeSubgrid) return;

            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = renderAlbumPhotoItemHtml({
                imgUrl: '/assets/images/nift_img_1.jpg',
                title: 'New Album Photo'
            }).trim();

            const newCol = tempDiv.firstElementChild;
            activeSubgrid.appendChild(newCol);
            showToast('New photo added to album!');
            newCol.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function duplicateAlbumPhoto(btn) {
            const col = btn.closest('.dbim-album-photo-col');
            if (!col) return;
            const clone = col.cloneNode(true);
            col.parentNode.insertBefore(clone, col.nextSibling);
            showToast('Album photo duplicated!');
        }

        function deleteAlbumPhoto(btn) {
            const col = btn.closest('.dbim-album-photo-col');
            if (!col) return;
            const grid = col.closest('.dbim-album-subgrid');
            if (grid && grid.querySelectorAll('.dbim-album-photo-col').length <= 1) {
                alert('At least one photo must remain in the album.');
                return;
            }
            if (confirm('Are you sure you want to delete this photo from the album?')) {
                col.remove();
                showToast('Photo deleted from album.');
            }
        }

        function moveAlbumPhoto(btn, direction) {
            const col = btn.closest('.dbim-album-photo-col');
            if (!col) return;
            if (direction === -1) {
                const prev = col.previousElementSibling;
                if (prev && prev.classList.contains('dbim-album-photo-col')) {
                    col.parentNode.insertBefore(col, prev);
                    showToast('Moved photo left');
                }
            } else if (direction === 1) {
                const next = col.nextElementSibling;
                if (next && next.classList.contains('dbim-album-photo-col')) {
                    col.parentNode.insertBefore(next, col);
                    showToast('Moved photo right');
                }
            }
        }

        // ============================================================
        // VIDEO GALLERY HANDLERS
        // ============================================================
        function addVideoCard(btn) {
            const section = btn.closest('.dbim-video-gallery-section') || document.querySelector('.dbim-video-gallery-section');
            if (!section) return;
            const grid = section.querySelector('.dbim-video-grid');
            if (!grid) return;

            const currentCols = grid.getAttribute('data-cols') || '3';
            let colClass = 'col-lg-4 col-md-6';
            if (currentCols === '2') colClass = 'col-lg-6 col-md-6';
            else if (currentCols === '4') colClass = 'col-lg-3 col-md-6';

            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = renderVideoCardItemHtml({
                title: 'New Video Documentary',
                date: new Date().toLocaleDateString('en-GB'),
                duration: '2:30',
                category: 'Handloom',
                thumbnailUrl: '/assets/images/video_handloom_day.png'
            }).trim();

            const newCol = tempDiv.firstElementChild;
            newCol.className = colClass + ' dbim-video-col';
            grid.appendChild(newCol);
            showToast('New video item added!');
            newCol.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function duplicateVideoCard(btn) {
            const col = btn.closest('.dbim-video-col');
            if (!col) return;
            const clone = col.cloneNode(true);
            col.parentNode.insertBefore(clone, col.nextSibling);
            showToast('Video item duplicated!');
        }

        function deleteVideoCard(btn) {
            const col = btn.closest('.dbim-video-col');
            if (!col) return;
            const grid = col.closest('.dbim-video-grid');
            if (grid && grid.querySelectorAll('.dbim-video-col').length <= 1) {
                alert('At least one video item must remain in the gallery.');
                return;
            }
            if (confirm('Are you sure you want to delete this video item?')) {
                col.remove();
                showToast('Video item deleted.');
            }
        }

        function moveVideoCard(btn, direction) {
            const col = btn.closest('.dbim-video-col');
            if (!col) return;
            if (direction === -1) {
                const prev = col.previousElementSibling;
                if (prev && prev.classList.contains('dbim-video-col')) {
                    col.parentNode.insertBefore(col, prev);
                    showToast('Moved video left');
                }
            } else if (direction === 1) {
                const next = col.nextElementSibling;
                if (next && next.classList.contains('dbim-video-col')) {
                    col.parentNode.insertBefore(next, col);
                    showToast('Moved video right');
                }
            }
        }

        function setVideoGridCols(btn, cols) {
            const section = btn.closest('.dbim-video-gallery-section');
            if (!section) return;
            const grid = section.querySelector('.dbim-video-grid');
            if (!grid) return;

            grid.setAttribute('data-cols', cols);
            const btnGroup = btn.closest('.btn-group');
            if (btnGroup) {
                btnGroup.querySelectorAll('button').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            }

            let newColClass = 'col-lg-4 col-md-6';
            if (cols === 2) newColClass = 'col-lg-6 col-md-6';
            else if (cols === 4) newColClass = 'col-lg-3 col-md-6';

            grid.querySelectorAll('.dbim-video-col').forEach(col => {
                col.className = newColClass + ' dbim-video-col';
            });
            showToast(`Switched layout to ${cols} columns`);
        }

        function sortVideoGallery(select) {
            const section = select.closest('.dbim-video-gallery-section');
            if (!section) return;
            const grid = section.querySelector('.dbim-video-grid');
            if (!grid) return;
            const cols = Array.from(grid.querySelectorAll('.dbim-video-col'));
            const val = select.value;

            cols.sort((a, b) => {
                const titleA = (a.querySelector('.dbim-video-title')?.innerText || '').trim();
                const titleB = (b.querySelector('.dbim-video-title')?.innerText || '').trim();
                const dateA = (a.querySelector('.dbim-video-date')?.innerText || '').trim();
                const dateB = (b.querySelector('.dbim-video-date')?.innerText || '').trim();

                if (val === 'title_asc') return titleA.localeCompare(titleB);
                if (val === 'oldest') return dateA.localeCompare(dateB);
                return dateB.localeCompare(dateA);
            });
            cols.forEach(c => grid.appendChild(c));
        }

        function filterVideoCategory(select) {
            const section = select.closest('.dbim-video-gallery-section');
            if (!section) return;
            const cat = select.value.toLowerCase();
            section.querySelectorAll('.dbim-video-col').forEach(col => {
                const itemCat = (col.getAttribute('data-category') || '').toLowerCase();
                const title = (col.querySelector('.dbim-video-title')?.innerText || '').toLowerCase();
                col.style.display = (cat === 'all' || itemCat.includes(cat) || title.includes(cat)) ? '' : 'none';
            });
        }

        // ============================================================
        // PRESENTATION / EVENTS HANDLERS
        // ============================================================
        function addPresCard(btn) {
            const section = btn.closest('.dbim-presentation-events-section') || document.querySelector('.dbim-presentation-events-section');
            if (!section) return;
            const grid = section.querySelector('.dbim-pres-grid');
            if (!grid) return;

            const currentCols = grid.getAttribute('data-cols') || '3';
            let colClass = 'col-lg-4 col-md-6';
            if (currentCols === '2') colClass = 'col-lg-6 col-md-6';
            else if (currentCols === '4') colClass = 'col-lg-3 col-md-6';

            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = renderPresentationCardItemHtml({
                title: 'New Session / Presentation',
                date: new Date().toLocaleDateString('en-GB'),
                category: 'Technical',
                btnText: 'VIEW',
                imgUrl: '/assets/images/pres_inaugural_session.png'
            }).trim();

            const newCol = tempDiv.firstElementChild;
            newCol.className = colClass + ' dbim-pres-col';
            grid.appendChild(newCol);
            showToast('New presentation card added!');
            newCol.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function duplicatePresCard(btn) {
            const col = btn.closest('.dbim-pres-col');
            if (!col) return;
            const clone = col.cloneNode(true);
            col.parentNode.insertBefore(clone, col.nextSibling);
            showToast('Presentation card duplicated!');
        }

        function deletePresCard(btn) {
            const col = btn.closest('.dbim-pres-col');
            if (!col) return;
            const grid = col.closest('.dbim-pres-grid');
            if (grid && grid.querySelectorAll('.dbim-pres-col').length <= 1) {
                alert('At least one presentation card must remain in the section.');
                return;
            }
            if (confirm('Are you sure you want to delete this presentation card?')) {
                col.remove();
                showToast('Presentation card deleted.');
            }
        }

        function movePresCard(btn, direction) {
            const col = btn.closest('.dbim-pres-col');
            if (!col) return;
            if (direction === -1) {
                const prev = col.previousElementSibling;
                if (prev && prev.classList.contains('dbim-pres-col')) {
                    col.parentNode.insertBefore(col, prev);
                    showToast('Moved card left');
                }
            } else if (direction === 1) {
                const next = col.nextElementSibling;
                if (next && next.classList.contains('dbim-pres-col')) {
                    col.parentNode.insertBefore(next, col);
                    showToast('Moved card right');
                }
            }
        }

        function setPresGridCols(btn, cols) {
            const section = btn.closest('.dbim-presentation-events-section');
            if (!section) return;
            const grid = section.querySelector('.dbim-pres-grid');
            if (!grid) return;

            grid.setAttribute('data-cols', cols);
            const btnGroup = btn.closest('.btn-group');
            if (btnGroup) {
                btnGroup.querySelectorAll('button').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            }

            let newColClass = 'col-lg-4 col-md-6';
            if (cols === 2) newColClass = 'col-lg-6 col-md-6';
            else if (cols === 4) newColClass = 'col-lg-3 col-md-6';

            grid.querySelectorAll('.dbim-pres-col').forEach(col => {
                col.className = newColClass + ' dbim-pres-col';
            });
            showToast(`Switched layout to ${cols} columns`);
        }

        function filterPresGallery(input) {
            const section = input.closest('.dbim-presentation-events-section');
            if (!section) return;
            const q = input.value.toLowerCase().trim();
            section.querySelectorAll('.dbim-pres-col').forEach(col => {
                const title = (col.querySelector('.dbim-pres-title')?.innerText || col.getAttribute('data-title') || '').toLowerCase();
                col.style.display = (!q || title.includes(q)) ? '' : 'none';
            });
        }

        function sortPresGallery(select) {
            const section = select.closest('.dbim-presentation-events-section');
            if (!section) return;
            const grid = section.querySelector('.dbim-pres-grid');
            if (!grid) return;
            const cols = Array.from(grid.querySelectorAll('.dbim-pres-col'));
            const val = select.value;

            cols.sort((a, b) => {
                const titleA = (a.querySelector('.dbim-pres-title')?.innerText || '').trim();
                const titleB = (b.querySelector('.dbim-pres-title')?.innerText || '').trim();
                const dateA = (a.querySelector('.dbim-pres-date')?.innerText || '').trim();
                const dateB = (b.querySelector('.dbim-pres-date')?.innerText || '').trim();

                if (val === 'title_asc') return titleA.localeCompare(titleB);
                if (val === 'oldest') return dateA.localeCompare(dateB);
                return dateB.localeCompare(dateA);
            });
            cols.forEach(c => grid.appendChild(c));
        }

        function filterPresCategory(select) {
            const section = select.closest('.dbim-presentation-events-section');
            if (!section) return;
            const cat = select.value.toLowerCase();
            section.querySelectorAll('.dbim-pres-col').forEach(col => {
                const itemCat = (col.getAttribute('data-category') || '').toLowerCase();
                const title = (col.querySelector('.dbim-pres-title')?.innerText || '').toLowerCase();
                col.style.display = (cat === 'all' || itemCat.includes(cat) || title.includes(cat)) ? '' : 'none';
            });
        }

        // ============================================================
        // MODAL PREVIEW & PLAYBACK FUNCTIONS
        // ============================================================
        let currentAlbumPhotos = [];
        let currentPhotoIndex = 0;

        function openPhotoPreview(el) {
            const photoCard = el.closest('.dbim-album-photo-card');
            const subgrid = el.closest('.dbim-album-subgrid') || el.closest('.dbim-album-photos-grid');
            const img = el.tagName === 'IMG' ? el : (photoCard ? photoCard.querySelector('img') : el.closest('.dbim-photo-card')?.querySelector('.dbim-photo-img'));
            if (!img) return;

            const albumTitle = document.querySelector('.dbim-album-title-text')?.innerText || el.closest('.dbim-photo-card')?.querySelector('.dbim-photo-title')?.innerText || 'Photo Preview';

            if (subgrid) {
                const imgs = Array.from(subgrid.querySelectorAll('.dbim-album-photo-card img'));
                currentAlbumPhotos = imgs.map(i => ({ src: i.src, alt: i.alt || albumTitle }));
                currentPhotoIndex = imgs.indexOf(img);
                if (currentPhotoIndex < 0) currentPhotoIndex = 0;
            } else {
                currentAlbumPhotos = [{ src: img.src, alt: img.alt || albumTitle }];
                currentPhotoIndex = 0;
            }

            let modal = document.getElementById('photoPreviewModal');
            if (!modal) {
                const modalHtml = `
                <div class="modal fade" id="photoPreviewModal" tabindex="-1" aria-hidden="true" style="z-index: 2500;">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden; background: #110e14; color: #fff;">
                            <div class="modal-header border-0 py-3 px-4 d-flex align-items-center justify-content-between" style="background: rgba(26, 21, 31, 0.95); border-bottom: 1px solid rgba(255,255,255,0.08) !important;">
                                <div>
                                    <h5 class="modal-title fs-5 fw-bold text-white mb-0" id="photoPreviewModalTitle">Photo Preview</h5>
                                    <span class="text-white-50 small" id="photoPreviewModalCounter"></span>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-2 p-md-4 position-relative d-flex align-items-center justify-content-center" style="min-height: 480px; max-height: 82vh;">
                                <button type="button" class="btn btn-dark position-absolute start-0 top-50 translate-middle-y ms-3 shadow-lg d-flex align-items-center justify-content-center" onclick="lightboxNav(-1)" id="lightboxPrevBtn" style="width: 44px; height: 44px; border-radius: 50%; z-index: 10; background: rgba(0,0,0,0.7); border: 1px solid rgba(255,255,255,0.25);">
                                    <i class="fa-solid fa-chevron-left" style="font-size: 16px;"></i>
                                </button>
                                <img id="photoPreviewModalImg" src="" alt="Photo" class="img-fluid rounded shadow-lg" style="max-height: 75vh; max-width: 95%; object-fit: contain; transition: opacity 0.2s ease;">
                                <button type="button" class="btn btn-dark position-absolute end-0 top-50 translate-middle-y me-3 shadow-lg d-flex align-items-center justify-content-center" onclick="lightboxNav(1)" id="lightboxNextBtn" style="width: 44px; height: 44px; border-radius: 50%; z-index: 10; background: rgba(0,0,0,0.7); border: 1px solid rgba(255,255,255,0.25);">
                                    <i class="fa-solid fa-chevron-right" style="font-size: 16px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                modal = document.getElementById('photoPreviewModal');

                document.addEventListener('keydown', function(ev) {
                    if (!modal.classList.contains('show')) return;
                    if (ev.key === 'ArrowLeft') lightboxNav(-1);
                    if (ev.key === 'ArrowRight') lightboxNav(1);
                });
            }

            updateLightboxContent();
            const bsModal = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);
            bsModal.show();
        }

        function updateLightboxContent() {
            const photo = currentAlbumPhotos[currentPhotoIndex];
            if (!photo) return;
            const albumTitle = document.querySelector('.dbim-album-title-text')?.innerText || 'Photo Gallery';
            const imgEl = document.getElementById('photoPreviewModalImg');
            const titleEl = document.getElementById('photoPreviewModalTitle');
            const counterEl = document.getElementById('photoPreviewModalCounter');
            const prevBtn = document.getElementById('lightboxPrevBtn');
            const nextBtn = document.getElementById('lightboxNextBtn');

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

        // VIDEO GALLERY MODAL & SETTINGS CONTROLLER
        let activeVideoCard = null;
        let activeVideoThumbnailUrl = null;

        function openVideoSettingsModal(triggerBtn) {
            const card = triggerBtn.closest('.dbim-video-card');
            if (!card) return;
            activeVideoCard = card;
            activeVideoThumbnailUrl = null;

            const thumb = card.querySelector('.dbim-video-thumbnail');
            const currentVideoUrl = thumb ? (thumb.getAttribute('data-video-url') || '') : '';
            const currentTitle = card.querySelector('.dbim-video-title')?.innerText.trim() || '';
            const currentDate = card.querySelector('.dbim-video-date')?.innerText.replace(/[^\d.]/g, '').trim() || '';
            const currentDuration = card.querySelector('.dbim-video-duration')?.innerText.trim() || '2:30';
            const currentCategory = card.closest('.dbim-video-col')?.getAttribute('data-category') || 'Handloom';
            const currentThumbSrc = thumb ? thumb.src : '';

            // Populate modal fields
            document.getElementById('videoModalUrlInput').value = currentVideoUrl;
            document.getElementById('videoModalTitleInput').value = currentTitle;
            document.getElementById('videoModalDurationInput').value = currentDuration;
            document.getElementById('videoModalDateInput').value = currentDate;
            document.getElementById('videoModalCategoryInput').value = currentCategory;
            document.getElementById('videoModalThumbPreview').src = currentThumbSrc;
            document.getElementById('videoModalUploadStatus').classList.add('d-none');
            document.getElementById('videoModalFileInput').value = '';

            updateVideoModalPreview();

            const modalEl = document.getElementById('videoSettingsModal');
            const bsModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            bsModal.show();
        }

        function extractYouTubeId(url) {
            if (!url) return null;
            const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/i);
            return match ? match[1] : null;
        }

        function updateVideoModalPreview() {
            const url = (document.getElementById('videoModalUrlInput')?.value || '').trim();
            const previewContainer = document.getElementById('videoModalLivePreview');
            const fetchBtn = document.getElementById('videoModalFetchYtBtn');
            if (!previewContainer) return;

            const ytId = extractYouTubeId(url);
            if (ytId) {
                previewContainer.innerHTML = `<iframe src="https://www.youtube-nocookie.com/embed/${ytId}?rel=0" class="w-100 h-100 border-0" allowfullscreen></iframe>`;
                if (fetchBtn) fetchBtn.classList.remove('d-none');
            } else if (url && (url.endsWith('.mp4') || url.endsWith('.webm') || url.includes('/uploads/videos/'))) {
                previewContainer.innerHTML = `<video controls class="w-100 h-100"><source src="${url}" type="video/mp4"></video>`;
                if (fetchBtn) fetchBtn.classList.add('d-none');
            } else if (url) {
                previewContainer.innerHTML = `<video controls class="w-100 h-100"><source src="${url}">Direct Video: ${url}</video>`;
                if (fetchBtn) fetchBtn.classList.add('d-none');
            } else {
                previewContainer.innerHTML = `<div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted p-4"><i class="fa-solid fa-film fa-3x mb-2 text-secondary"></i><span>Enter a YouTube URL or upload an MP4 file above</span></div>`;
                if (fetchBtn) fetchBtn.classList.add('d-none');
            }
        }

        function fetchYouTubeThumbnailFromModal() {
            const url = (document.getElementById('videoModalUrlInput')?.value || '').trim();
            const ytId = extractYouTubeId(url);
            if (!ytId) {
                alert('Please enter a valid YouTube link first.');
                return;
            }
            const thumbUrl = `https://img.youtube.com/vi/${ytId}/hqdefault.jpg`;
            activeVideoThumbnailUrl = thumbUrl;
            document.getElementById('videoModalThumbPreview').src = thumbUrl;
            showToast('YouTube cover thumbnail fetched! Click "Save Video Settings" to apply.');
        }

        function uploadVideoFile(file) {
            if (!file) return;
            const status = document.getElementById('videoModalUploadStatus');
            if (status) {
                status.classList.remove('d-none');
                status.className = 'alert alert-info text-center py-2 mt-3 mb-0';
                status.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Uploading video file (' + (file.size / (1024 * 1024)).toFixed(1) + ' MB)... Please wait.';
            }

            const formData = new FormData();
            formData.append('video', file);
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

            fetch("{{ route('admin.pages.upload-video') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (status) {
                        status.className = 'alert alert-success text-center py-2 mt-3 mb-0';
                        status.innerHTML = '<i class="fa-solid fa-check-circle me-1"></i> Video uploaded successfully!';
                    }
                    const videoUrl = data.url || data.relative_url;
                    document.getElementById('videoModalUrlInput').value = videoUrl;
                    updateVideoModalPreview();
                    showToast('Video uploaded and configured!');
                } else {
                    if (status) {
                        status.className = 'alert alert-danger text-center py-2 mt-3 mb-0';
                        status.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> ' + (data.message || 'Upload failed.');
                    }
                }
            })
            .catch(err => {
                if (status) {
                    status.className = 'alert alert-danger text-center py-2 mt-3 mb-0';
                    status.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> Upload failed: ' + err.message;
                }
            });
        }

        function saveVideoSettingsModal() {
            if (!activeVideoCard) return;

            const videoUrl = (document.getElementById('videoModalUrlInput')?.value || '').trim();
            const title = (document.getElementById('videoModalTitleInput')?.value || '').trim();
            const duration = (document.getElementById('videoModalDurationInput')?.value || '').trim();
            const date = (document.getElementById('videoModalDateInput')?.value || '').trim();
            const category = (document.getElementById('videoModalCategoryInput')?.value || '').trim();

            const thumb = activeVideoCard.querySelector('.dbim-video-thumbnail');
            if (thumb) {
                thumb.setAttribute('data-video-url', videoUrl);
                if (activeVideoThumbnailUrl) {
                    thumb.src = activeVideoThumbnailUrl;
                }
            }

            if (title) {
                const titleEl = activeVideoCard.querySelector('.dbim-video-title');
                if (titleEl) titleEl.innerText = title;
            }

            if (duration) {
                const durationEl = activeVideoCard.querySelector('.dbim-video-duration');
                if (durationEl) durationEl.innerText = duration;

                const overlaySpan = activeVideoCard.querySelector('.dbim-video-overlay-ctrl span');
                if (overlaySpan) overlaySpan.innerText = '0:00 / ' + duration;
            }

            if (date) {
                const dateEl = activeVideoCard.querySelector('.dbim-video-date');
                if (dateEl) dateEl.innerHTML = '<i class="fa-regular fa-calendar me-1" style="font-size: 1.15rem;"></i>' + date;
            }

            const col = activeVideoCard.closest('.dbim-video-col');
            if (col) {
                if (title) col.setAttribute('data-title', title.toLowerCase());
                if (date) col.setAttribute('data-date', date);
                if (category) col.setAttribute('data-category', category);
            }

            const modalEl = document.getElementById('videoSettingsModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();

            showToast('Video card updated successfully!');
        }

        function ensureVideoCardsHaveAdminButtons() {
            document.querySelectorAll('.dbim-video-card').forEach(card => {
                const wrap = card.querySelector('.dbim-video-player-wrap');
                if (!wrap) return;

                // 1. Remove old loose buttons sitting directly in wrap
                wrap.querySelectorAll(':scope > button.editor-video-btn').forEach(b => b.remove());

                // 2. Remove any video buttons incorrectly inserted into the top-right move/delete bar
                const topEndBar = card.querySelector('.editor-video-btn-bar');
                if (topEndBar) {
                    topEndBar.querySelectorAll('button[onclick*="openVideoSettingsModal"]').forEach(b => b.remove());
                }

                // 3. Remove legacy top-0 start-0 editor-video-btn-bar if exists
                wrap.querySelectorAll('.editor-video-btn-bar').forEach(b => b.remove());

                // 4. Ensure clean top-left source bar inside wrap
                let sourceBar = wrap.querySelector('.editor-video-source-bar');
                if (!sourceBar) {
                    sourceBar = document.createElement('div');
                    sourceBar.className = 'editor-video-source-bar position-absolute top-0 start-0 m-2 d-flex gap-1';
                    sourceBar.style.zIndex = '12';
                    sourceBar.innerHTML = `
                        <button type="button" class="btn btn-sm btn-danger editor-video-btn px-2 py-1 shadow-sm fw-bold" onclick="event.stopPropagation(); openVideoSettingsModal(this)" title="Configure Video URL / MP4 File"><i class="fa-solid fa-video me-1"></i> Video</button>
                        <button type="button" class="btn btn-sm btn-dark editor-video-btn px-2 py-1 shadow-sm fw-bold" onclick="event.stopPropagation(); openAvatarModal(this)" title="Change Cover Photo"><i class="fa-solid fa-camera me-1"></i> Cover</button>
                    `;
                    wrap.appendChild(sourceBar);
                }

                // 5. Ensure a dedicated bottom helper button in dbim-video-details
                const details = card.querySelector('.dbim-video-details');
                if (details && !details.querySelector('[onclick*="openVideoSettingsModal"]')) {
                    const editBtn = document.createElement('button');
                    editBtn.type = 'button';
                    editBtn.className = 'btn btn-sm btn-outline-danger w-100 mt-2 editor-video-btn fw-bold';
                    editBtn.style.fontSize = '1.15rem';
                    editBtn.onclick = function(e) { e.stopPropagation(); openVideoSettingsModal(this); };
                    editBtn.innerHTML = '<i class="fa-solid fa-film me-1"></i> Configure Video (YouTube / MP4)';
                    details.appendChild(editBtn);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            ensureVideoCardsHaveAdminButtons();
        });

        function playGalleryVideo(el) {
            const card = el.closest('.dbim-video-card');
            const thumb = card ? card.querySelector('.dbim-video-thumbnail') : null;
            const title = card ? (card.querySelector('.dbim-video-title')?.innerText || 'Video Player') : 'Video Player';
            const videoUrl = thumb ? (thumb.getAttribute('data-video-url') || '') : '';

            let modal = document.getElementById('videoPlayerModal');
            if (!modal) {
                const modalHtml = `
                <div class="modal fade" id="videoPlayerModal" tabindex="-1" aria-hidden="true" style="z-index: 2500;">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden; background: #000; color: #fff;">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fs-5 fw-bold" id="videoPlayerModalTitle">Video</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-3 text-center">
                                <div id="videoPlayerModalContent" class="ratio ratio-16x9 rounded overflow-hidden bg-black">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                modal = document.getElementById('videoPlayerModal');
                modal.addEventListener('hidden.bs.modal', function () {
                    const container = document.getElementById('videoPlayerModalContent');
                    if (container) container.innerHTML = '';
                });
            }

            document.getElementById('videoPlayerModalTitle').innerText = title;
            const container = document.getElementById('videoPlayerModalContent');

            const ytMatch = videoUrl ? videoUrl.match(/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/i) : null;
            if (ytMatch && ytMatch[1]) {
                container.innerHTML = `<iframe src="https://www.youtube-nocookie.com/embed/${ytMatch[1]}?autoplay=1&rel=0" class="w-100 h-100 border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
            } else if (videoUrl) {
                const poster = thumb ? thumb.src : '';
                container.innerHTML = `<video controls autoplay class="w-100 h-100 rounded" poster="${poster}"><source src="${videoUrl}" type="video/mp4">Your browser does not support the video tag.</video>`;
            } else {
                container.innerHTML = `<div class="d-flex flex-column align-items-center justify-content-center h-100 text-white-50 p-4"><i class="fa-solid fa-film fa-3x mb-3 text-secondary"></i><p class="mb-0">No video link has been configured for this item. Click 'Video URL' on the card to configure.</p></div>`;
            }

            const bsModal = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);
            bsModal.show();
        }

        // ============================================================
        // DBIM LINK & REDIRECTION BUTTON CONTROLLER
        // ============================================================
        let activeLinkTargetEl = null;
        let savedSelectionRange = null;

        function openLinkSettingsModal(triggerBtn) {
            activeLinkTargetEl = null;
            savedSelectionRange = null;

            let initialUrl = '';
            let initialText = '';
            let initialTarget = '_blank';
            let initialIcon = 'fa-arrow-right';
            let isButton = false;
            let styleVariant = 'primary';
            let shapeVariant = 'rounded-pill';

            if (triggerBtn) {
                const btnWrapper = triggerBtn.closest('.dbim-button-wrapper');
                const linkWrapper = triggerBtn.closest('.dbim-link-wrapper');

                if (btnWrapper) {
                    isButton = true;
                    const a = btnWrapper.querySelector('a.dbim-custom-btn');
                    activeLinkTargetEl = a || btnWrapper;
                    if (a) {
                        initialUrl = a.getAttribute('href') || '';
                        initialTarget = a.getAttribute('target') || '_blank';
                        const textSpan = a.querySelector('.dbim-btn-text');
                        initialText = textSpan ? textSpan.innerText.trim() : a.innerText.trim();
                        const icon = a.querySelector('.dbim-btn-icon');
                        if (icon) {
                            const match = icon.className.match(/fa-[a-z0-9-]+/g);
                            if (match && match.length > 0) initialIcon = match[match.length - 1];
                        }
                    }
                } else if (linkWrapper) {
                    isButton = false;
                    const a = linkWrapper.querySelector('a.dbim-custom-link');
                    activeLinkTargetEl = a || linkWrapper;
                    if (a) {
                        initialUrl = a.getAttribute('href') || '';
                        initialTarget = a.getAttribute('target') || '_blank';
                        const textSpan = a.querySelector('.dbim-link-text');
                        initialText = textSpan ? textSpan.innerText.trim() : a.innerText.trim();
                        const icon = a.querySelector('.dbim-link-icon');
                        if (icon) {
                            const match = icon.className.match(/fa-[a-z0-9-]+/g);
                            if (match && match.length > 0) initialIcon = match[match.length - 1];
                        }
                    }
                } else if (triggerBtn.tagName && triggerBtn.tagName.toLowerCase() === 'a') {
                    activeLinkTargetEl = triggerBtn;
                    initialUrl = triggerBtn.getAttribute('href') || '';
                    initialTarget = triggerBtn.getAttribute('target') || '_blank';
                    initialText = triggerBtn.innerText.trim();
                }
            } else {
                // Triggered from toolbar on text selection
                const sel = window.getSelection();
                if (sel && sel.rangeCount > 0) {
                    savedSelectionRange = sel.getRangeAt(0).cloneRange();
                    initialText = sel.toString().trim();
                    let parent = sel.anchorNode;
                    while (parent && parent !== document.body) {
                        if (parent.tagName && parent.tagName.toLowerCase() === 'a') {
                            activeLinkTargetEl = parent;
                            initialUrl = parent.getAttribute('href') || '';
                            initialTarget = parent.getAttribute('target') || '_blank';
                            if (!initialText) initialText = parent.innerText.trim();
                            break;
                        }
                        parent = parent.parentNode;
                    }
                }
            }

            document.getElementById('linkModalUrlInput').value = initialUrl;
            document.getElementById('linkModalTextInput').value = initialText || 'Learn More';
            document.getElementById('linkModalTargetSelect').value = initialTarget;
            document.getElementById('linkModalIconSelect').value = initialIcon;
            document.getElementById('linkModalInternalPageSelect').value = '';

            const btnOpts = document.getElementById('linkModalButtonOptions');
            if (btnOpts) {
                btnOpts.style.display = isButton ? 'block' : 'none';
            }

            const modalEl = document.getElementById('linkSettingsModal');
            const bsModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            bsModal.show();
        }

        function saveLinkSettingsModal() {
            const url = (document.getElementById('linkModalUrlInput')?.value || '').trim() || '#';
            const text = (document.getElementById('linkModalTextInput')?.value || '').trim() || 'Learn More';
            const target = document.getElementById('linkModalTargetSelect')?.value || '_blank';
            const iconClass = document.getElementById('linkModalIconSelect')?.value || 'none';
            const styleVariant = document.getElementById('linkModalStyleSelect')?.value || 'primary';
            const shapeVariant = document.getElementById('linkModalShapeSelect')?.value || 'rounded-pill';

            if (activeLinkTargetEl) {
                if (activeLinkTargetEl.classList?.contains('dbim-custom-btn') || activeLinkTargetEl.closest('.dbim-button-wrapper')) {
                    const a = activeLinkTargetEl.tagName?.toLowerCase() === 'a' ? activeLinkTargetEl : activeLinkTargetEl.querySelector('a.dbim-custom-btn');
                    if (a) {
                        a.setAttribute('href', url);
                        a.setAttribute('target', target);
                        if (target === '_blank') a.setAttribute('rel', 'noopener noreferrer');
                        else a.removeAttribute('rel');

                        let textSpan = a.querySelector('.dbim-btn-text');
                        if (!textSpan) {
                            textSpan = document.createElement('span');
                            textSpan.className = 'dbim-btn-text';
                            textSpan.contentEditable = 'true';
                            a.appendChild(textSpan);
                        }
                        textSpan.innerText = text;

                        let iconEl = a.querySelector('.dbim-btn-icon');
                        if (iconClass === 'none') {
                            if (iconEl) iconEl.remove();
                        } else {
                            if (!iconEl) {
                                iconEl = document.createElement('i');
                                iconEl.className = 'dbim-btn-icon ms-2';
                                iconEl.style.fontSize = '0.9em';
                                a.appendChild(iconEl);
                            }
                            iconEl.className = 'fa-solid ' + iconClass + ' dbim-btn-icon ms-2';
                        }

                        setDbimBtnStyle(a, styleVariant);
                        a.className = a.className.replace(/rounded-(pill|3|0)/g, '').trim() + ' ' + shapeVariant;
                    }
                } else if (activeLinkTargetEl.classList?.contains('dbim-custom-link') || activeLinkTargetEl.closest('.dbim-link-wrapper')) {
                    const a = activeLinkTargetEl.tagName?.toLowerCase() === 'a' ? activeLinkTargetEl : activeLinkTargetEl.querySelector('a.dbim-custom-link');
                    if (a) {
                        a.setAttribute('href', url);
                        a.setAttribute('target', target);
                        if (target === '_blank') a.setAttribute('rel', 'noopener noreferrer');
                        else a.removeAttribute('rel');

                        let textSpan = a.querySelector('.dbim-link-text');
                        if (!textSpan) {
                            textSpan = document.createElement('span');
                            textSpan.className = 'dbim-link-text';
                            textSpan.contentEditable = 'true';
                            a.appendChild(textSpan);
                        }
                        textSpan.innerText = text;

                        let iconEl = a.querySelector('.dbim-link-icon');
                        if (iconClass === 'none') {
                            if (iconEl) iconEl.remove();
                        } else {
                            if (!iconEl) {
                                iconEl = document.createElement('i');
                                iconEl.className = 'dbim-link-icon ms-1';
                                iconEl.style.fontSize = '0.8em';
                                a.appendChild(iconEl);
                            }
                            iconEl.className = 'fa-solid ' + iconClass + ' dbim-link-icon ms-1';
                        }
                    }
                } else if (activeLinkTargetEl.tagName?.toLowerCase() === 'a') {
                    activeLinkTargetEl.setAttribute('href', url);
                    activeLinkTargetEl.setAttribute('target', target);
                    if (target === '_blank') activeLinkTargetEl.setAttribute('rel', 'noopener noreferrer');
                    else activeLinkTargetEl.removeAttribute('rel');
                    activeLinkTargetEl.innerText = text;
                }
            } else if (savedSelectionRange) {
                const sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(savedSelectionRange);

                const a = document.createElement('a');
                a.href = url;
                a.target = target;
                if (target === '_blank') a.rel = 'noopener noreferrer';
                a.className = 'dbim-custom-link fw-semibold';
                a.style.color = '#721835';
                a.style.textDecoration = 'underline';
                a.style.textUnderlineOffset = '4px';
                a.innerText = text;

                savedSelectionRange.deleteContents();
                savedSelectionRange.insertNode(a);
            } else {
                const canvas = document.getElementById('liveCanvas');
                if (canvas) {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = `<div class="my-2"><a href="${url}" target="${target}" ${target === '_blank' ? 'rel="noopener noreferrer"' : ''} class="dbim-custom-link fw-semibold" style="color: #721835; text-decoration: underline; text-underline-offset: 4px; font-size: 1.35rem;">${text}</a></div>`;
                    canvas.appendChild(tempDiv.firstElementChild);
                }
            }

            const modalEl = document.getElementById('linkSettingsModal');
            const bsModal = bootstrap.Modal.getInstance(modalEl);
            if (bsModal) bsModal.hide();

            showToast('Link & Redirection updated successfully!');
        }

        function setDbimBtnStyle(el, styleName) {
            const wrap = el.closest ? el.closest('.dbim-button-wrapper') : null;
            const a = wrap ? wrap.querySelector('a.dbim-custom-btn') : el;
            if (!a) return;

            a.classList.remove('dbim-btn-primary', 'dbim-btn-outline', 'dbim-btn-gold', 'dbim-btn-success', 'dbim-btn-danger', 'dbim-btn-dark');

            if (styleName === 'outline') {
                a.classList.add('dbim-btn-outline');
                a.style.background = 'transparent';
                a.style.color = '#721835';
                a.style.border = '2px solid #721835';
            } else if (styleName === 'gold') {
                a.classList.add('dbim-btn-gold');
                a.style.background = 'linear-gradient(135deg, #d4af37 0%, #aa820a 100%)';
                a.style.color = '#000000';
                a.style.border = '2px solid #aa820a';
            } else if (styleName === 'success') {
                a.classList.add('dbim-btn-success');
                a.style.background = '#198754';
                a.style.color = '#ffffff';
                a.style.border = '2px solid #198754';
            } else if (styleName === 'danger') {
                a.classList.add('dbim-btn-danger');
                a.style.background = '#dc3545';
                a.style.color = '#ffffff';
                a.style.border = '2px solid #dc3545';
            } else if (styleName === 'dark') {
                a.classList.add('dbim-btn-dark');
                a.style.background = '#212529';
                a.style.color = '#ffffff';
                a.style.border = '2px solid #212529';
            } else {
                a.classList.add('dbim-btn-primary');
                a.style.background = '#721835';
                a.style.color = '#ffffff';
                a.style.border = '2px solid #721835';
            }
        }

        function setDbimBtnAlign(el, align) {
            const wrap = el.closest ? el.closest('.dbim-button-wrapper') : null;
            if (!wrap) return;
            const a = wrap.querySelector('a.dbim-custom-btn');

            if (align === 'center') {
                wrap.style.textAlign = 'center';
                if (a) { a.style.display = 'inline-flex'; a.style.width = 'auto'; }
            } else if (align === 'right') {
                wrap.style.textAlign = 'right';
                if (a) { a.style.display = 'inline-flex'; a.style.width = 'auto'; }
            } else if (align === 'block') {
                wrap.style.textAlign = 'center';
                if (a) { a.style.display = 'flex'; a.style.width = '100%'; a.style.justifyContent = 'center'; }
            } else {
                wrap.style.textAlign = 'left';
                if (a) { a.style.display = 'inline-flex'; a.style.width = 'auto'; }
            }
        }

        function setDbimBtnSize(el, size) {
            const wrap = el.closest ? el.closest('.dbim-button-wrapper') : null;
            const a = wrap ? wrap.querySelector('a.dbim-custom-btn') : el;
            if (!a) return;

            if (size === 'sm') {
                a.style.padding = '6px 16px';
                a.style.fontSize = '1.15rem';
            } else if (size === 'lg') {
                a.style.padding = '14px 34px';
                a.style.fontSize = '1.6rem';
            } else {
                a.style.padding = '10px 24px';
                a.style.fontSize = '1.35rem';
            }
        }

        function setDbimLinkStyle(el, styleName) {
            const wrap = el.closest ? el.closest('.dbim-link-wrapper') : null;
            const a = wrap ? wrap.querySelector('a.dbim-custom-link') : el;
            if (!a) return;

            if (styleName === 'arrow') {
                a.style.color = '#721835';
                a.style.textDecoration = 'none';
                a.style.fontWeight = '700';
                a.style.background = 'transparent';
                a.style.padding = '0';
                a.style.border = 'none';
                let icon = a.querySelector('.dbim-link-icon');
                if (!icon) {
                    icon = document.createElement('i');
                    icon.className = 'fa-solid fa-arrow-right dbim-link-icon ms-1';
                    a.appendChild(icon);
                } else {
                    icon.className = 'fa-solid fa-arrow-right dbim-link-icon ms-1';
                }
            } else if (styleName === 'badge') {
                a.style.color = '#721835';
                a.style.background = '#fdf2f6';
                a.style.padding = '5px 14px';
                a.style.borderRadius = '50px';
                a.style.border = '1px solid #ebd0de';
                a.style.textDecoration = 'none';
                a.style.fontWeight = '600';
            } else if (styleName === 'highlight') {
                a.style.color = '#721835';
                a.style.background = '#fdf7fa';
                a.style.padding = '6px 16px';
                a.style.borderLeft = '3px solid #721835';
                a.style.borderRadius = '0 6px 6px 0';
                a.style.textDecoration = 'none';
                a.style.fontWeight = '600';
            } else {
                a.style.color = '#721835';
                a.style.textDecoration = 'underline';
                a.style.textUnderlineOffset = '4px';
                a.style.background = 'transparent';
                a.style.padding = '0';
                a.style.border = 'none';
            }
        }

        function openPresentationModal(el) {
            const card = el.closest('.dbim-pres-card');
            const img = card ? card.querySelector('.dbim-pres-img') : null;
            const title = card ? (card.querySelector('.dbim-pres-title')?.innerText || 'Presentation View') : 'Presentation View';
            
            let modal = document.getElementById('presPreviewModal');
            if (!modal) {
                const modalHtml = `
                <div class="modal fade" id="presPreviewModal" tabindex="-1" aria-hidden="true" style="z-index: 2500;">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden; background: #fff;">
                            <div class="modal-header" style="background: #500a2f; color: #fff;">
                                <h5 class="modal-title fs-5 fw-bold" id="presPreviewModalTitle">Presentation Slide</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-3 text-center bg-light">
                                <img id="presPreviewModalImg" src="" alt="Slide" class="img-fluid rounded border shadow-sm" style="max-height: 75vh; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                </div>`;
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                modal = document.getElementById('presPreviewModal');
            }
            document.getElementById('presPreviewModalTitle').innerText = title;
            if (img) document.getElementById('presPreviewModalImg').src = img.src;
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        }
    </script>

    <!-- DYNAMIC DOCUMENT / MEDIA LINKING MODAL FOR VIEW BUTTONS -->
    <div class="modal fade" id="docMediaModal" tabindex="-1" aria-labelledby="docMediaModalLabel" aria-hidden="true" style="z-index: 2300;">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background: #500a2f; padding: 16px 24px;">
                    <div>
                        <h5 class="modal-title fs-6 fw-bold mb-0" id="docMediaModalLabel">
                            <i class="fa-regular fa-file-pdf me-2"></i> Attach Document to VIEW Button
                        </h5>
                        <small class="text-white-50" style="font-size: 12px;">Target: <span id="docModalTargetName" class="text-white fw-bold">Document</span></small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 bg-light">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-pills nav-fill mb-3 bg-white p-1 rounded border" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active fw-bold small py-2" data-bs-toggle="pill" data-bs-target="#tabUploadDoc" type="button">
                                <i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload File from Device
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold small py-2" data-bs-toggle="pill" data-bs-target="#tabLibraryDoc" type="button">
                                <i class="fa-solid fa-photo-film me-1"></i> Select from Media Library
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold small py-2" data-bs-toggle="pill" data-bs-target="#tabCustomUrlDoc" type="button">
                                <i class="fa-solid fa-link me-1"></i> External / Custom Link
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- TAB 1: UPLOAD FROM DEVICE -->
                        <div class="tab-pane fade show active" id="tabUploadDoc">
                            <div class="p-4 border rounded text-center bg-white shadow-sm" 
                                 style="border: 2px dashed #500a2f !important; cursor: pointer;" 
                                 onclick="document.getElementById('docModalFileInput').click()">
                                <i class="fa-solid fa-file-arrow-up text-danger mb-2" style="font-size: 46px;"></i>
                                <h6 class="fw-bold mb-1" style="color: #500a2f;">Click to select PDF or Document from your computer</h6>
                                <p class="text-muted small mb-0">PDF, DOC, DOCX, XLS, XLSX up to 20MB are supported</p>
                                <input type="file" id="docModalFileInput" class="d-none" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt" onchange="uploadDocModalFile(this.files[0])">
                            </div>
                            <div id="docModalUploadStatus" class="alert alert-info d-none text-center py-2 mt-3 mb-0"></div>
                            <small class="text-muted d-block mt-2 text-center">
                                <i class="fa-solid fa-shield-halved text-success me-1"></i> File will automatically take relative link compatible with both local and production servers.
                            </small>
                        </div>

                        <!-- TAB 2: SELECT FROM MEDIA LIBRARY -->
                        <div class="tab-pane fade" id="tabLibraryDoc">
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text bg-white"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                <input type="text" id="docModalMediaSearch" class="form-control" placeholder="Search files in Media Library..." onkeyup="filterDocModalMedia()">
                            </div>
                            <div id="docModalMediaListGrid" class="row g-2" style="max-height: 340px; overflow-y: auto;">
                                <div class="col-12 text-center text-muted py-3">
                                    <div class="spinner-border spinner-border-sm text-secondary me-2"></div> Loading files...
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: CUSTOM URL -->
                        <div class="tab-pane fade" id="tabCustomUrlDoc">
                            <div class="bg-white p-3 rounded border">
                                <label class="form-label fw-bold small text-muted text-uppercase">Enter Full or Relative Document URL:</label>
                                <div class="input-group">
                                    <input type="text" id="docModalManualUrl" class="form-control" placeholder="https://textilescommittee.gov.in/uploads/... or /uploads/documents/...">
                                    <button type="button" class="btn text-white fw-bold" style="background: #500a2f;" onclick="setManualDocUrl()">Apply Link</button>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    Paste a link to any document hosted on the portal or external government site.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-white py-2 justify-content-between">
                    <small class="text-muted"><i class="fa-solid fa-circle-info text-primary me-1"></i> The VIEW button will automatically open the document in a secure new tab.</small>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- DYNAMIC AVATAR & PROFILE IMAGE MODAL -->
    <div class="modal fade" id="avatarPhotoModal" tabindex="-1" aria-labelledby="avatarPhotoModalLabel" aria-hidden="true" style="z-index: 2310;">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background: #500a2f; padding: 16px 24px;">
                    <div class="d-flex align-items-center gap-3">
                        <img id="avatarModalCurrentPreview" src="/assets/images/user-placeholder.png" alt="Preview" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid #ffffff; background: #ffffff;">
                        <div>
                            <h5 class="modal-title fs-6 fw-bold mb-0" id="avatarPhotoModalLabel">
                                <i class="fa-solid fa-camera me-1"></i> Update Officer / Profile Photo
                            </h5>
                            <small class="text-white-50" style="font-size: 11.5px;">Upload a new portrait photo or select from the portal media gallery</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 bg-light">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-pills nav-fill mb-3 bg-white p-1 rounded border" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active fw-bold small py-2" data-bs-toggle="pill" data-bs-target="#tabUploadAvatar" type="button">
                                <i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload Photo
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold small py-2" data-bs-toggle="pill" data-bs-target="#tabLibraryAvatar" type="button">
                                <i class="fa-solid fa-images me-1"></i> Media Gallery
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold small py-2" data-bs-toggle="pill" data-bs-target="#tabCustomUrlAvatar" type="button">
                                <i class="fa-solid fa-link me-1"></i> Custom URL
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold small py-2" data-bs-toggle="pill" data-bs-target="#tabPresetAvatar" type="button">
                                <i class="fa-solid fa-shield me-1"></i> Default Silhouettes
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- TAB 1: UPLOAD FROM DEVICE -->
                        <div class="tab-pane fade show active" id="tabUploadAvatar">
                            <div class="p-4 border rounded text-center bg-white shadow-sm" 
                                 style="border: 2px dashed #500a2f !important; cursor: pointer;" 
                                 onclick="document.getElementById('avatarModalFileInput').click()">
                                <i class="fa-regular fa-image text-danger mb-2" style="font-size: 46px;"></i>
                                <h6 class="fw-bold mb-1" style="color: #500a2f;">Click to browse photo from your device</h6>
                                <p class="text-muted small mb-0">JPG, PNG, WEBP, or SVG up to 5MB (Square or portrait recommended)</p>
                                <input type="file" id="avatarModalFileInput" class="d-none" accept="image/*" onchange="uploadAvatarFile(this.files[0])">
                            </div>
                            <div id="avatarModalUploadStatus" class="alert alert-info d-none text-center py-2 mt-3 mb-0"></div>
                            <small class="text-muted d-block mt-2 text-center">
                                <i class="fa-solid fa-check-circle text-success me-1"></i> Uploaded photos are stored on your server and work across local and production automatically.
                            </small>
                        </div>

                        <!-- TAB 2: SELECT FROM MEDIA LIBRARY -->
                        <div class="tab-pane fade" id="tabLibraryAvatar">
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text bg-white"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                <input type="text" id="avatarModalMediaSearch" class="form-control" placeholder="Search images in media library..." onkeyup="filterAvatarModalMedia()">
                            </div>
                            <div id="avatarModalMediaGrid" class="row g-2" style="max-height: 320px; overflow-y: auto;">
                                <div class="col-12 text-center text-muted py-3">
                                    <div class="spinner-border spinner-border-sm text-secondary me-2"></div> Loading images...
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: CUSTOM URL -->
                        <div class="tab-pane fade" id="tabCustomUrlAvatar">
                            <div class="bg-white p-3 rounded border">
                                <label class="form-label fw-bold small text-muted text-uppercase">Enter Photo Image URL:</label>
                                <div class="input-group">
                                    <input type="text" id="avatarManualUrlInput" class="form-control" placeholder="https://... or /assets/images/...">
                                    <button type="button" class="btn text-white fw-bold" style="background: #500a2f;" onclick="setCustomAvatarUrl()">Apply Photo</button>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    Provide an absolute or relative image link.
                                </small>
                            </div>
                        </div>

                        <!-- TAB 4: DEFAULT GOVT SILHOUETTES -->
                        <div class="tab-pane fade" id="tabPresetAvatar">
                            <div class="bg-white p-3 rounded border">
                                <p class="small text-muted mb-3">Select a default government silhouette or official placeholder:</p>
                                <div class="row g-3 text-center">
                                    <div class="col-6 col-md-3">
                                        <div class="p-2 border rounded hover-shadow cursor-pointer" onclick="setPresetAvatar('/assets/images/giriraj_singh.png')" style="cursor: pointer;">
                                            <img src="/assets/images/giriraj_singh.png" class="rounded-circle mb-2" style="width: 60px; height: 60px; object-fit: cover;">
                                            <div class="small fw-bold">Hon'ble Minister</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="p-2 border rounded hover-shadow cursor-pointer" onclick="setPresetAvatar('data:image/svg+xml;utf8,<svg xmlns=\\'http://www.w3.org/2000/svg\\' viewBox=\\'0 0 24 24\\' fill=\\'%239c2759\\'><path d=\\'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z\\'/></svg>')" style="cursor: pointer;">
                                            <div class="rounded-circle mb-2 d-inline-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
                                                <i class="fa-solid fa-user-tie text-danger fs-3"></i>
                                            </div>
                                            <div class="small fw-bold">Male Official</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="p-2 border rounded hover-shadow cursor-pointer" onclick="setPresetAvatar('data:image/svg+xml;utf8,<svg xmlns=\\'http://www.w3.org/2000/svg\\' viewBox=\\'0 0 24 24\\' fill=\\'%23ba2369\\'><circle cx=\\'12\\' cy=\\'8\\' r=\\'4\\'/><path d=\\'M12 14c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5z\\'/></svg>')" style="cursor: pointer;">
                                            <div class="rounded-circle mb-2 d-inline-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
                                                <i class="fa-solid fa-user fs-3" style="color: #ba2369;"></i>
                                            </div>
                                            <div class="small fw-bold">Female Official</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="p-2 border rounded hover-shadow cursor-pointer" onclick="setPresetAvatar('/assets/images/Textiles_Committee_Logo.png')" style="cursor: pointer;">
                                            <div class="rounded-circle mb-2 d-inline-flex align-items-center justify-content-center bg-light p-1" style="width: 60px; height: 60px;">
                                                <img src="/assets/images/Textiles_Committee_Logo.png" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                            </div>
                                            <div class="small fw-bold">Committee Logo</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-white py-2 justify-content-between">
                    <small class="text-muted"><i class="fa-solid fa-circle-info text-primary me-1"></i> Avatar photos are displayed with circular cropping and official styling.</small>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ADVANCED PRO TABLE CELL PROPERTIES MODAL -->
    <div class="modal fade" id="proTableCellModal" tabindex="-1" aria-labelledby="proTableCellModalLabel" aria-hidden="true" style="z-index: 2320;">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background: #721835; padding: 14px 20px;">
                    <h6 class="modal-title fw-bold" id="proTableCellModalLabel">
                        <i class="fa-solid fa-table-cells me-2"></i> Cell Properties & Spans Inspector
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <!-- 1. SPANS (ROWSPAN & COLSPAN) -->
                    <div class="bg-white p-3 rounded border mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase d-flex align-items-center justify-content-between mb-2">
                            <span><i class="fa-solid fa-arrows-up-down-left-right text-primary me-1"></i> Row & Column Spanning</span>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0 text-decoration-none small" onclick="resetProCellSpans()">
                                <i class="fa-solid fa-rotate-left me-1"></i> Reset to 1x1
                            </button>
                        </label>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="small text-muted mb-1">Colspan (Columns Spanned):</label>
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary" type="button" onclick="const input = document.getElementById('proCellColspanInput'); if(parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;">-</button>
                                    <input type="number" id="proCellColspanInput" class="form-control text-center fw-bold" min="1" max="25" value="1">
                                    <button class="btn btn-outline-secondary" type="button" onclick="const input = document.getElementById('proCellColspanInput'); input.value = parseInt(input.value) + 1;">+</button>
                                </div>
                                <small class="text-muted" style="font-size: 10px;">Merged horizontally</small>
                            </div>
                            <div class="col-6">
                                <label class="small text-muted mb-1">Rowspan (Rows Spanned):</label>
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary" type="button" onclick="const input = document.getElementById('proCellRowspanInput'); if(parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;">-</button>
                                    <input type="number" id="proCellRowspanInput" class="form-control text-center fw-bold" min="1" max="25" value="1">
                                    <button class="btn btn-outline-secondary" type="button" onclick="const input = document.getElementById('proCellRowspanInput'); input.value = parseInt(input.value) + 1;">+</button>
                                </div>
                                <small class="text-muted" style="font-size: 10px;">Merged vertically</small>
                            </div>
                        </div>
                    </div>

                    <!-- 2. CELL TYPE & ALIGNMENT -->
                    <div class="bg-white p-3 rounded border mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase mb-2">
                            <i class="fa-solid fa-align-left text-primary me-1"></i> Cell Tag & Alignment
                        </label>
                        <div class="row g-2 mb-2">
                            <div class="col-4">
                                <label class="small text-muted mb-1">Tag Type:</label>
                                <select id="proCellTagSelect" class="form-select form-select-sm">
                                    <option value="td">td (Data Cell)</option>
                                    <option value="th">th (Header Cell)</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="small text-muted mb-1">Horizontal:</label>
                                <select id="proCellAlignSelect" class="form-select form-select-sm">
                                    <option value="left">Left</option>
                                    <option value="center">Center</option>
                                    <option value="right">Right</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="small text-muted mb-1">Vertical:</label>
                                <select id="proCellValignSelect" class="form-select form-select-sm">
                                    <option value="top">Top</option>
                                    <option value="middle">Middle</option>
                                    <option value="bottom">Bottom</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="small text-muted mb-1">Explicit Width (optional):</label>
                                <input type="text" id="proCellWidthInput" class="form-control form-control-sm" placeholder="e.g. 140px, 20%, or empty for auto">
                            </div>
                        </div>
                    </div>

                    <!-- 3. COLORS & APPEARANCE -->
                    <div class="bg-white p-3 rounded border mb-2">
                        <label class="form-label fw-bold small text-muted text-uppercase mb-2">
                            <i class="fa-solid fa-paint-roller text-primary me-1"></i> Cell Colors
                        </label>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="small text-muted mb-1">Background Color:</label>
                                <input type="text" id="proCellBgInput" class="form-control form-control-sm" placeholder="#ffffff or transparent">
                            </div>
                            <div class="col-6">
                                <label class="small text-muted mb-1">Text Color:</label>
                                <input type="text" id="proCellTextColorInput" class="form-control form-control-sm" placeholder="#212529 or #ffffff">
                            </div>
                        </div>
                        <!-- Quick Color Swatches -->
                        <div class="d-flex align-items-center gap-1 flex-wrap pt-1">
                            <span class="small text-muted me-1" style="font-size: 11px;">Quick presets:</span>
                            <button type="button" class="btn btn-sm p-0 rounded border" style="width: 22px; height: 22px; background: #ffffff;" onclick="document.getElementById('proCellBgInput').value='#ffffff'; document.getElementById('proCellTextColorInput').value='#212529';" title="White / Default"></button>
                            <button type="button" class="btn btn-sm p-0 rounded border" style="width: 22px; height: 22px; background: #721835;" onclick="document.getElementById('proCellBgInput').value='#721835'; document.getElementById('proCellTextColorInput').value='#ffffff';" title="Theme Maroon"></button>
                            <button type="button" class="btn btn-sm p-0 rounded border" style="width: 22px; height: 22px; background: #faebf3;" onclick="document.getElementById('proCellBgInput').value='#faebf3'; document.getElementById('proCellTextColorInput').value='#721835';" title="Soft Pink"></button>
                            <button type="button" class="btn btn-sm p-0 rounded border" style="width: 22px; height: 22px; background: #f8f9fa;" onclick="document.getElementById('proCellBgInput').value='#f8f9fa'; document.getElementById('proCellTextColorInput').value='#212529';" title="Light Gray"></button>
                            <button type="button" class="btn btn-sm p-0 rounded border" style="width: 22px; height: 22px; background: #fff3cd;" onclick="document.getElementById('proCellBgInput').value='#fff3cd'; document.getElementById('proCellTextColorInput').value='#856404';" title="Yellow Alert"></button>
                            <button type="button" class="btn btn-sm p-0 rounded border" style="width: 22px; height: 22px; background: #d1e7dd;" onclick="document.getElementById('proCellBgInput').value='#d1e7dd'; document.getElementById('proCellTextColorInput').value='#0f5132';" title="Green Highlight"></button>
                        </div>
                    </div>

                    <!-- 4. ACTIONS: DUPLICATE, UNMERGE & DELETE -->
                    <div class="bg-white p-3 rounded border border-danger-subtle">
                        <label class="form-label fw-bold small text-danger text-uppercase mb-2">
                            <i class="fa-solid fa-layer-group me-1"></i> Row / Column Operations
                        </label>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="const m = bootstrap.Modal.getInstance(document.getElementById('proTableCellModal')); if(m) m.hide(); duplicateProTableRow();" title="Duplicate the row containing this cell">
                                <i class="fa-regular fa-copy me-1"></i> Duplicate Row
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="const m = bootstrap.Modal.getInstance(document.getElementById('proTableCellModal')); if(m) m.hide(); duplicateProTableColumn();" title="Duplicate the column containing this cell">
                                <i class="fa-regular fa-copy me-1"></i> Duplicate Column
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning text-dark fw-semibold" onclick="resetProCellSpans();" title="Reset both Rowspan & Colspan to 1 (Unmerge)">
                                <i class="fa-solid fa-arrows-split-up-and-left me-1"></i> Unmerge (1x1)
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="const m = bootstrap.Modal.getInstance(document.getElementById('proTableCellModal')); if(m) m.hide(); deleteProTableRow();" title="Delete the row containing this cell">
                                <i class="fa-regular fa-trash-can me-1"></i> Delete Row
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="const m = bootstrap.Modal.getInstance(document.getElementById('proTableCellModal')); if(m) m.hide(); deleteProTableColumn();" title="Delete the column containing this cell">
                                <i class="fa-regular fa-trash-can me-1"></i> Delete Column
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="const m = bootstrap.Modal.getInstance(document.getElementById('proTableCellModal')); if(m) m.hide(); deleteProCell();" title="Delete this individual unwanted cell">
                                <i class="fa-solid fa-xmark me-1"></i> Delete Cell
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white py-2 justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm text-white px-3" style="background: #721835;" onclick="applyProCellSettings()">
                        <i class="fa-solid fa-check me-1"></i> Apply to Cell
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- VIDEO SETTINGS & UPLOAD MODAL -->
    <div class="modal fade" id="videoSettingsModal" tabindex="-1" aria-labelledby="videoSettingsModalLabel" aria-hidden="true" style="z-index: 2550;">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background: #721835; padding: 16px 24px;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-film fs-5"></i>
                        <h5 class="modal-title fs-6 fw-bold mb-0" id="videoSettingsModalLabel">Configure Video Item & Source</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <!-- Nav Tabs -->
                    <ul class="nav nav-pills nav-fill mb-3 bg-white p-1 rounded border" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active fw-bold small py-2" data-bs-toggle="pill" data-bs-target="#tabVideoUrl" type="button">
                                <i class="fa-brands fa-youtube me-1 text-danger"></i> YouTube or External URL
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link fw-bold small py-2" data-bs-toggle="pill" data-bs-target="#tabVideoUpload" type="button">
                                <i class="fa-solid fa-cloud-arrow-up me-1 text-primary"></i> Upload MP4 Video File
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- TAB 1: YOUTUBE / VIDEO URL -->
                        <div class="tab-pane fade show active" id="tabVideoUrl">
                            <div class="bg-white p-3 rounded border mb-3">
                                <label class="form-label fw-bold small text-muted text-uppercase">Video URL (YouTube or Direct Video Link):</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-link text-muted"></i></span>
                                    <input type="text" id="videoModalUrlInput" class="form-control" placeholder="https://www.youtube.com/watch?v=... or https://youtu.be/... or .mp4 URL" oninput="updateVideoModalPreview()">
                                    <button type="button" id="videoModalFetchYtBtn" class="btn btn-outline-danger fw-semibold d-none" onclick="fetchYouTubeThumbnailFromModal()" title="Auto-fetch high-res YouTube cover thumbnail">
                                        <i class="fa-brands fa-youtube me-1"></i> Fetch Cover Thumbnail
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    <i class="fa-solid fa-circle-info text-primary me-1"></i> Supports any YouTube video URL or direct MP4/WebM video stream.
                                </small>
                            </div>
                        </div>

                        <!-- TAB 2: UPLOAD VIDEO FILE -->
                        <div class="tab-pane fade" id="tabVideoUpload">
                            <div class="bg-white p-4 rounded border text-center cursor-pointer" onclick="document.getElementById('videoModalFileInput').click()" style="border: 2px dashed #9c2759 !important; background: #fffcfd !important; cursor: pointer;">
                                <i class="fa-solid fa-file-video text-danger mb-2" style="font-size: 40px;"></i>
                                <h6 class="fw-bold mb-1" style="color: #721835;">Click to browse video from your computer</h6>
                                <p class="text-muted small mb-0">Supported formats: MP4, WebM, OGG, MOV (Max 100MB)</p>
                                <input type="file" id="videoModalFileInput" class="d-none" accept="video/mp4,video/webm,video/ogg,video/quicktime" onchange="uploadVideoFile(this.files[0])">
                            </div>
                            <div id="videoModalUploadStatus" class="alert alert-info d-none text-center py-2 mt-3 mb-0"></div>
                        </div>
                    </div>

                    <!-- Live Video Preview & Thumbnail Preview -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold small text-muted text-uppercase mb-1">Live Video Preview:</label>
                            <div class="ratio ratio-16x9 rounded overflow-hidden bg-black border" id="videoModalLivePreview">
                                <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted p-3">
                                    <i class="fa-solid fa-film fa-2x mb-2 text-secondary"></i>
                                    <span class="small">Video preview will appear here</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold small text-muted text-uppercase mb-1">Cover Thumbnail:</label>
                            <div class="ratio ratio-16x9 rounded overflow-hidden bg-light border mb-2">
                                <img id="videoModalThumbPreview" src="/assets/images/video_handloom_day.png" alt="Cover" class="w-100 h-100" style="object-fit: cover;">
                            </div>
                            <small class="text-muted d-block small">To change the thumbnail to a custom image, you can also use the <strong>Thumbnail</strong> button on the card.</small>
                        </div>
                    </div>

                    <!-- Metadata Settings -->
                    <div class="bg-white p-3 rounded border">
                        <h6 class="fw-bold small text-muted text-uppercase mb-2"><i class="fa-solid fa-sliders text-danger me-1"></i> Video Card Details</h6>
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="small text-muted mb-1">Video Title:</label>
                                <input type="text" id="videoModalTitleInput" class="form-control form-control-sm" placeholder="e.g. 12th National Handloom Day Celebrations">
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted mb-1">Duration (MM:SS):</label>
                                <input type="text" id="videoModalDurationInput" class="form-control form-control-sm" placeholder="e.g. 2:14">
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted mb-1">Date:</label>
                                <input type="text" id="videoModalDateInput" class="form-control form-control-sm" placeholder="e.g. 07.08.2026">
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted mb-1">Category:</label>
                                <input type="text" id="videoModalCategoryInput" class="form-control form-control-sm" placeholder="e.g. Handloom">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-white py-2 justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm text-white px-4 fw-semibold" style="background: #721835;" onclick="saveVideoSettingsModal()">
                        <i class="fa-solid fa-check me-1"></i> Save Video Settings
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- LINK & REDIRECTION BUTTON SETTINGS MODAL -->
    <div class="modal fade" id="linkSettingsModal" tabindex="-1" aria-labelledby="linkSettingsModalLabel" aria-hidden="true" style="z-index: 2560;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header text-white" style="background: #721835; padding: 16px 24px;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-link fs-5"></i>
                        <h5 class="modal-title fs-6 fw-bold mb-0" id="linkSettingsModalLabel">Configure Link & Redirection</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <!-- 1. Destination URL / Redirection -->
                    <div class="bg-white p-3 rounded border mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase mb-1">
                            <i class="fa-solid fa-route text-danger me-1"></i> Redirection URL (Destination Link):
                        </label>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-globe text-muted"></i></span>
                            <input type="text" id="linkModalUrlInput" class="form-control" placeholder="https://example.gov.in or /page/slug">
                        </div>

                        <!-- Internal Page Quick Selector -->
                        <label class="form-label small text-muted mb-1">Or select an internal website page:</label>
                        <select class="form-select form-select-sm" id="linkModalInternalPageSelect" onchange="if(this.value) document.getElementById('linkModalUrlInput').value = this.value;">
                            <option value="">-- Choose an existing page --</option>
                            @if(isset($allPages) && count($allPages) > 0)
                                @foreach($allPages as $ap)
                                    <option value="{{ url('page/' . $ap->slug) }}">{{ $ap->title_en }} ({{ $ap->slug }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- 2. Display Text -->
                    <div class="bg-white p-3 rounded border mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase mb-1">
                            <i class="fa-solid fa-font text-primary me-1"></i> Display Text:
                        </label>
                        <input type="text" id="linkModalTextInput" class="form-control" placeholder="e.g. Apply Online / Read Guidelines">
                    </div>

                    <!-- 3. Target (Window) & Icon -->
                    <div class="bg-white p-3 rounded border mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase mb-1">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-secondary me-1"></i> Open In:
                                </label>
                                <select class="form-select form-select-sm" id="linkModalTargetSelect">
                                    <option value="_blank">New Tab / Window (_blank) [Recommended]</option>
                                    <option value="_self">Same Tab (_self)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase mb-1">
                                    <i class="fa-solid fa-icons text-secondary me-1"></i> Icon:
                                </label>
                                <select class="form-select form-select-sm" id="linkModalIconSelect">
                                    <option value="fa-arrow-right">Arrow Right (&rarr;)</option>
                                    <option value="fa-arrow-up-right-from-square">External Link (&nearr;)</option>
                                    <option value="fa-file-pdf">PDF Document</option>
                                    <option value="fa-download">Download</option>
                                    <option value="fa-circle-info">Information</option>
                                    <option value="fa-globe">Globe / Web</option>
                                    <option value="none">No Icon</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Button-Specific Appearance (Only visible when modifying a Button) -->
                    <div id="linkModalButtonOptions" class="bg-white p-3 rounded border">
                        <h6 class="fw-bold small text-muted text-uppercase mb-2">
                            <i class="fa-solid fa-palette text-danger me-1"></i> Button Appearance & Style
                        </h6>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="small text-muted mb-1">Color Theme:</label>
                                <select class="form-select form-select-sm" id="linkModalStyleSelect">
                                    <option value="primary">Primary Burgundy (#721835)</option>
                                    <option value="outline">Burgundy Outline</option>
                                    <option value="gold">Gold / Amber Accent</option>
                                    <option value="success">Green (Success)</option>
                                    <option value="danger">Red (Alert)</option>
                                    <option value="dark">Dark Charcoal</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted mb-1">Button Shape:</label>
                                <select class="form-select form-select-sm" id="linkModalShapeSelect">
                                    <option value="rounded-pill">Pill Shape (Fully Rounded)</option>
                                    <option value="rounded-3">Rounded Rectangle (8px)</option>
                                    <option value="rounded-0">Square Corners</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-white py-2 justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm text-white px-4 fw-semibold" style="background: #721835;" onclick="saveLinkSettingsModal()">
                        <i class="fa-solid fa-check me-1"></i> Apply Link & Redirection
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
