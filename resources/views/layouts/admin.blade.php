<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Textiles Committee CMS</title>
    
    <!-- Official Textiles Committee Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/Textiles_Committee_Logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/Textiles_Committee_Logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/Textiles_Committee_Logo.png') }}">

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --cms-sidebar-bg: #1e1b24;
            --cms-sidebar-hover: #2d2836;
            --cms-sidebar-active: #721835;
            --cms-primary: #721835;
            --cms-primary-dark: #551025;
            --cms-gold: #c59b27;
        }

        body {
            font-family: 'Noto Sans', sans-serif;
            background-color: #f4f6f9;
            color: #334155;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        /* Sidebar */
        .cms-sidebar {
            width: 260px;
            min-height: 100vh;
            background-color: var(--cms-sidebar-bg);
            color: #e2e8f0;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1000;
            overflow-y: auto;
            transition: all 0.3s;
        }
        .cms-sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .cms-sidebar::-webkit-scrollbar-thumb {
            background: #3a3447;
            border-radius: 4px;
        }
        .sidebar-brand {
            padding: 18px 20px;
            background: #141219;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-brand-title {
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
        }
        .sidebar-nav {
            list-style: none;
            padding: 12px 0;
            margin: 0;
        }
        .sidebar-section-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #8b8599;
            padding: 12px 20px 4px;
            font-weight: 700;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .sidebar-link:hover {
            background-color: var(--cms-sidebar-hover);
            color: #ffffff;
            border-left-color: var(--cms-gold);
        }
        .sidebar-link.active {
            background-color: var(--cms-sidebar-active);
            color: #ffffff;
            border-left-color: var(--cms-gold);
            font-weight: 600;
        }
        .sidebar-link .material-symbols-outlined {
            font-size: 20px;
            opacity: 0.85;
        }

        /* Main Content */
        .cms-main {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Header */
        .cms-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 24px;
            position: sticky;
            top: 0;
            z-index: 900;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cms-content {
            padding: 24px;
            flex-grow: 1;
        }

        /* Card Styles */
        .cms-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            margin-bottom: 24px;
        }
        .cms-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            background: #fafbfc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px 8px 0 0;
        }
        .cms-card-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .cms-card-body {
            padding: 20px;
        }

        /* Table styles */
        .table th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 14px;
        }
        .table td {
            padding: 12px 14px;
            vertical-align: middle;
            font-size: 13.5px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Buttons */
        .btn-cms-primary {
            background-color: var(--cms-primary);
            border-color: var(--cms-primary);
            color: #fff;
            font-weight: 600;
        }
        .btn-cms-primary:hover {
            background-color: var(--cms-primary-dark);
            border-color: var(--cms-primary-dark);
            color: #fff;
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="cms-sidebar">
        <div class="sidebar-brand">
            @php
                $adminLogo = \App\Models\Setting::get('site_logo') ?: (\App\Models\Setting::get('site_emblem') ?: 'assets/images/Textiles_Committee_Logo.png');
            @endphp
            <img src="{{ asset($adminLogo) }}" alt="Textiles Committee Logo" style="height: 38px; width: auto; object-fit: contain;" onerror="this.src='{{ asset('assets/images/header_emblem_logo.png') }}'">
            <div>
                <div class="sidebar-brand-title">{{ \App\Models\Setting::get('site_title_en', 'Textiles Committee') }}</div>
                <small style="color: #94a3b8; font-size: 11px;">{{ \App\Models\Setting::get('site_tagline_en', 'Min. of Textiles, Govt. of India') }}</small>
            </div>
        </div>

        <ul class="sidebar-nav">
            <li class="sidebar-section-title">Main</li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.analytics.index') }}" class="sidebar-link {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">analytics</span>
                    <span>Visitor & Language Insights</span>
                </a>
            </li>

            <li class="sidebar-section-title">CMS Modules</li>
            <li>
                <a href="{{ route('admin.banners.index') }}" class="sidebar-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">view_carousel</span>
                    <span>Hero Banners</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.announcements.index') }}" class="sidebar-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">campaign</span>
                    <span>Announcements</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dignitaries.index') }}" class="sidebar-link {{ request()->routeIs('admin.dignitaries.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">badge</span>
                    <span>Dignitaries</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.schemes.index') }}" class="sidebar-link {{ request()->routeIs('admin.schemes.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">verified</span>
                    <span>Schemes & Services</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tenders.index') }}" class="sidebar-link {{ request()->routeIs('admin.tenders.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">gavel</span>
                    <span>Tenders & Vacancies</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.whats-new.index') }}" class="sidebar-link {{ request()->routeIs('admin.whats-new.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">bolt</span>
                    <span>What's New</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.documents.index') }}" class="sidebar-link {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">description</span>
                    <span>Documents & Reports</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.personas.index') }}" class="sidebar-link {{ request()->routeIs('admin.personas.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">account_circle</span>
                    <span>User Personas</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.important-links.index') }}" class="sidebar-link {{ request()->routeIs('admin.important-links.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">link</span>
                    <span>Important Links</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.campaigns.index') }}" class="sidebar-link {{ request()->routeIs('admin.campaigns.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">ad</span>
                    <span>Campaign Banners</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.social-posts.index') }}" class="sidebar-link {{ request()->routeIs('admin.social-posts.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">share</span>
                    <span>Social Media Feeds</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.menus.index') }}" class="sidebar-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">menu_open</span>
                    <span>Header Menus</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pages.index') }}" class="sidebar-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">article</span>
                    <span>CMS Pages</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.media.index') }}" class="sidebar-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">perm_media</span>
                    <span>Media Manager</span>
                </a>
            </li>

            <li class="sidebar-section-title">Communication & Audit</li>
            <li>
                <a href="{{ route('admin.industry-tech-issues.index') }}" class="sidebar-link {{ request()->routeIs('admin.industry-tech-issues.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">build_circle</span>
                    <span>Industry Tech Issues</span>
                    @php $openTech = \App\Models\IndustryTechIssue::where('status', 'open')->count(); @endphp
                    @if($openTech > 0)
                        <span class="badge bg-warning text-dark ms-auto">{{ $openTech }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.contact-us.index') }}" class="sidebar-link {{ request()->routeIs('admin.contact-us.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">contact_support</span>
                    <span>Contact Us Details</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.footer.index') }}" class="sidebar-link {{ request()->routeIs('admin.footer.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">bottom_panel_open</span>
                    <span>Footer Management</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.inquiries.index') }}" class="sidebar-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">mail</span>
                    <span>Citizen Inquiries</span>
                    @php $newInq = \App\Models\Inquiry::where('status', 'new')->count(); @endphp
                    @if($newInq > 0)
                        <span class="badge bg-danger ms-auto">{{ $newInq }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.logs.index') }}" class="sidebar-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">history</span>
                    <span>Audit Logs</span>
                </a>
            </li>

            @if(auth()->user()->isSuperAdmin())
                <li>
                    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">manage_accounts</span>
                        <span>User Management (RBAC)</span>
                    </a>
                </li>
            @endif

            <li>
                <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span>Site Settings</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content Area -->
    <div class="cms-main">
        <!-- Header -->
        <header class="cms-header">
            <div class="d-flex align-items-center gap-3">
                <span class="fw-bold fs-5 text-secondary">
                    @yield('title', 'Dashboard')
                </span>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined" style="font-size: 16px;">open_in_new</span> View Live Website
                </a>

                <div class="dropdown">
                    <button class="btn btn-light btn-sm border dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="material-symbols-outlined text-primary" style="font-size: 20px;">account_circle</span>
                        <div class="text-start">
                            <span class="fw-bold">{{ auth()->user()->name }}</span>
                            <span class="badge bg-dark ms-1" style="font-size: 10px;">{{ strtoupper(auth()->user()->role) }}</span>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">logout</span> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-4 pt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                    <i class="fa fa-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="m-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <!-- Body Content -->
        <div class="cms-content">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
