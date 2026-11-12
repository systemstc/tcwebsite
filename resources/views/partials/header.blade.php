<!-- GIGW / WCAG 2.1 Accessible Skip Links (Natural focus order, no positive tabindex) -->
<a href="#mainContent" class="skip-to-main-link">{{ session('locale') == 'hi' ? 'मुख्य सामग्री पर जाएं' : 'Skip to main content' }}</a>
<a href="#govNavUl" class="skip-to-main-link skip-to-nav-link">{{ session('locale') == 'hi' ? 'नेविगेशन पर जाएं' : 'Skip to navigation' }}</a>

<!-- EXACT SAME HEADER WITH FULL RESPONSIVENESS & ACCESSIBILITY -->
<header class="exact-header-wrap" role="banner">
    <div class="exact-header-top">
        <!-- Left: Ashoka Emblem, Logo & Titles -->
        <a href="{{ route('home') }}" class="exact-brand" title="Textiles Committee, Ministry of Textiles, Government of India" aria-label="Textiles Committee Home">
            @php
                $siteEmblem = \App\Models\Setting::get('site_emblem');
                $siteLogo = \App\Models\Setting::get('site_logo');
            @endphp

            @if($siteEmblem && $siteLogo)
                <img src="{{ asset($siteEmblem) }}" alt="State Emblem of India" class="exact-emblem-img">
                <img src="{{ asset($siteLogo) }}" alt="Textiles Committee Logo" class="exact-emblem-img ms-1">
            @elseif($siteEmblem)
                <img src="{{ asset($siteEmblem) }}" alt="State Emblem of India" class="exact-emblem-img">
            @elseif($siteLogo)
                <img src="{{ asset($siteLogo) }}" alt="Textiles Committee Logo" class="exact-emblem-img">
            @else
                <img src="{{ asset('assets/images/Textiles_Committee_Logo.png') }}" alt="Government of India Emblem" class="exact-emblem-img" onerror="this.onerror=null;this.src='{{ asset('assets/images/Textiles_Committee_Logo.png') }}'">
            @endif

            <div class="exact-brand-text">
                <span class="exact-brand-title">{{ \App\Models\Setting::get('site_title_en', 'Textiles Committee') }}</span>
                <span class="exact-brand-sub">{{ \App\Models\Setting::get('site_tagline_en', 'Ministry of Textiles') }}</span>
            </div>
        </a>

        <!-- Center: Search Box with Maroon Bottom Accent & Mobile Hamburger -->
        <div class="exact-search-menu-bar">
            <div class="exact-search-wrap">
                <form action="{{ route('site.search') }}" method="GET" class="exact-search-box" role="search" aria-label="{{ session('locale') == 'hi' ? 'वस्त्र समिति वेबसाइट खोज' : 'Search Textiles Committee Website' }}">
                    <input type="search" name="q" 
                           placeholder="{{ session('locale') == 'hi' ? 'सेवाएं, योजनाएं, परिपत्र एवं दस्तावेज खोजें...' : 'Search services, schemes, circulars and documents...' }}" 
                           value="{{ request('q') }}" 
                           aria-label="{{ session('locale') == 'hi' ? 'वेबसाइट खोज इनपुट' : 'Search services, schemes, circulars and documents' }}"
                           title="{{ session('locale') == 'hi' ? 'वेबसाइट पर खोजें' : 'Search this website' }}">
                    <div class="exact-search-divider"></div>
                    <button type="submit" class="exact-search-btn" title="{{ session('locale') == 'hi' ? 'खोजें' : 'Search' }}" aria-label="{{ session('locale') == 'hi' ? 'खोजें' : 'Search' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#6c1340" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Hamburger Button (Visible only on Responsive, on the right side of Search) -->
            <button class="exact-hamburger-btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavDrawer" aria-controls="mobileNavDrawer" aria-label="{{ session('locale') == 'hi' ? 'नेविगेशन मेनू खोलें' : 'Open Navigation Menu' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false" style="margin-right: 4px;">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
                <span class="hamburger-label">{{ session('locale') == 'hi' ? 'मेनू' : 'Menu' }}</span>
            </button>
        </div>

        <!-- Center-Right: Digital India Logo -->
        <div class="exact-di-wrap">
            <a href="https://digitalindia.gov.in/" target="_blank" rel="noopener noreferrer" title="Digital India - Power To Empower (External link)" aria-label="Digital India Portal">
                <img src="{{ asset('assets/images/digital india.png') }}" alt="Digital India - Power To Empower" class="exact-di-img" onerror="this.onerror=null;this.src='{{ asset('assets/images/digital india.png') }}'">
            </a>
        </div>

        <!-- Far Right: Accessibility Utilities -->
        <div class="exact-utilities" role="region" aria-label="Accessibility and utilities">
            <!-- 1. Skip to Main Content Utility Button -->
            <a href="#mainContent" class="exact-util-link" title="Skip to Main Content" aria-label="Skip to Main Content">
                <img src="{{ asset('assets/images/Skip_to_Content.png') }}" alt="Skip to Content" class="exact-util-img">
            </a>

            <span class="exact-util-divider" aria-hidden="true">|</span>

            <!-- 2. Language Translation (Bhashini) -->
            <div class="bhashini-plugin-container" aria-label="Language translation"></div>

            <span class="exact-util-divider" aria-hidden="true">|</span>

            <!-- 3. Accessibility Controls Flyout Trigger -->
            <button type="button" class="exact-util-link" data-bs-toggle="offcanvas" data-bs-target="#accessibilityDrawer" aria-controls="accessibilityDrawer" title="Accessibility Controls" aria-label="Open Accessibility Controls">
                <img src="{{ asset('assets/images/accessibilit.png') }}" alt="Accessibility Controls" class="exact-util-img">
            </button>
        </div>
    </div>

    <!-- 2. NAVIGATION BAR ROW -->
    <nav class="gov-nav-bar-exact" role="navigation" aria-label="Main Navigation">
        <div class="gov-nav-container-exact">
            <button class="gov-mobile-toggle" onclick="document.getElementById('govNavUl').classList.toggle('show')" aria-label="Toggle Navigation Menu" aria-controls="govNavUl" aria-expanded="false">
                <span><i class="fa fa-bars me-2"></i> {{ session('locale') == 'hi' ? 'मेनू' : 'Menu' }}</span>
                <i class="fa-solid fa-chevron-down ms-1" style="font-size: 14px;" aria-hidden="true"></i>
            </button>

            <ul class="gov-nav-ul" id="govNavUl">
                <li class="gov-nav-li">
                    <a href="{{ route('home') }}" class="gov-nav-a {{ request()->routeIs('home') ? 'active' : '' }}">
                        {{ session('locale') == 'hi' ? 'मुख्य पृष्ठ' : 'Home' }}
                    </a>
                </li>

                @if(isset($headerMenuItems) && $headerMenuItems->count())
                    @foreach($headerMenuItems as $menu)
                        @php
                            $children = $menu->activeChildren;
                            $hasKids = $children->count() > 0;
                            $menuTitle = session('locale') == 'hi' ? ($menu->title_hi ?: $menu->title_en) : ($menu->title_en ?: $menu->title_hi);
                            $isActive = false;
                            if ($menu->type === 'page' && $menu->page && request()->is('page/' . $menu->page->slug)) {
                                $isActive = true;
                            } elseif ($hasKids) {
                                foreach ($children as $ck) {
                                    if ($ck->type === 'page' && $ck->page && request()->is('page/' . $ck->page->slug)) {
                                        $isActive = true;
                                        break;
                                    }
                                    if (($ck->page && $ck->page->slug === 'industry-tech-issues') || str_contains($ck->url ?? '', 'industry-tech-issues')) {
                                        if (request()->is('industry-tech-issues*')) {
                                            $isActive = true;
                                            break;
                                        }
                                    }
                                }
                            }
                        @endphp

                        <li class="gov-nav-li">
                            <a href="{{ $hasKids ? '#' : $menu->resolved_url }}" 
                               target="{{ $menu->target ?: '_self' }}" 
                               class="gov-nav-a {{ $isActive ? 'active' : '' }}">
                                {{ $menuTitle }}
                                @if($hasKids)
                                    <span class="gov-nav-caret">⌵</span>
                                @endif
                            </a>

                            @if($hasKids)
                                <ul class="gov-nav-drop">
                                    @foreach($children as $sub)
                                        @php
                                            $subKids = $sub->activeChildren;
                                            $hasSubKids = $subKids->count() > 0;
                                            $subTitle = session('locale') == 'hi' ? ($sub->title_hi ?: $sub->title_en) : ($sub->title_en ?: $sub->title_hi);
                                            $isSubActive = false;
                                            if ($sub->type === 'page' && $sub->page && request()->is('page/' . $sub->page->slug)) {
                                                $isSubActive = true;
                                            } elseif (($sub->page && $sub->page->slug === 'industry-tech-issues') || str_contains($sub->url ?? '', 'industry-tech-issues')) {
                                                if (request()->is('industry-tech-issues*')) {
                                                    $isSubActive = true;
                                                }
                                            }
                                        @endphp
                                        <li class="gov-nav-sub-li {{ $hasSubKids ? 'has-flyout' : '' }}">
                                            <a href="{{ $hasSubKids ? '#' : $sub->resolved_url }}" target="{{ $sub->target ?: '_self' }}" class="gov-nav-drop-a {{ $isSubActive ? 'active' : '' }}">
                                                <span>{{ $subTitle }}</span>
                                                @if($hasSubKids)
                                                    <span class="gov-sub-arrow">›</span>
                                                @endif
                                            </a>

                                            @if($hasSubKids)
                                                <ul class="gov-nav-flyout">
                                                    @foreach($subKids as $grandChild)
                                                        @php
                                                            $gcKids = $grandChild->activeChildren;
                                                            $hasGcKids = $gcKids->count() > 0;
                                                            $gcTitle = session('locale') == 'hi' ? ($grandChild->title_hi ?: $grandChild->title_en) : ($grandChild->title_en ?: $grandChild->title_hi);
                                                            $isGcActive = ($grandChild->type === 'page' && $grandChild->page && request()->is('page/' . $grandChild->page->slug));
                                                        @endphp
                                                        <li class="gov-nav-gc-li {{ $hasGcKids ? 'has-flyout-3' : '' }}">
                                                            <a href="{{ $hasGcKids ? '#' : $grandChild->resolved_url }}" target="{{ $grandChild->target ?: '_self' }}" class="gov-nav-drop-a {{ $isGcActive ? 'active' : '' }}">
                                                                <span>{{ $gcTitle }}</span>
                                                                @if($hasGcKids)
                                                                    <span class="gov-sub-arrow">›</span>
                                                                @endif
                                                            </a>

                                                            @if($hasGcKids)
                                                                <ul class="gov-nav-flyout-3">
                                                                    @foreach($gcKids as $deepChild)
                                                                        @php
                                                                            $dcTitle = session('locale') == 'hi' ? ($deepChild->title_hi ?: $deepChild->title_en) : ($deepChild->title_en ?: $deepChild->title_hi);
                                                                            $isDcActive = ($deepChild->type === 'page' && $deepChild->page && request()->is('page/' . $deepChild->page->slug));
                                                                        @endphp
                                                                        <li>
                                                                            <a href="{{ $deepChild->resolved_url }}" target="{{ $deepChild->target ?: '_self' }}" class="gov-nav-drop-a {{ $isDcActive ? 'active' : '' }}">
                                                                                {{ $dcTitle }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                @else
                    <!-- Fallback static menu if table is empty -->
                    <li class="gov-nav-li">
                        <a href="#" class="gov-nav-a">
                            {{ session('locale') == 'hi' ? 'मंत्रालय' : 'Ministry' }} <span class="gov-nav-caret">⌵</span>
                        </a>
                        <ul class="gov-nav-drop">
                            <li><a href="{{ route('page.show', 'about-us') }}" class="gov-nav-drop-a">About Ministry</a></li>
                            <li><a href="{{ route('page.show', 'our-team') }}" class="gov-nav-drop-a">Leadership & Team</a></li>
                            <li><a href="{{ route('page.show', 'organization') }}" class="gov-nav-drop-a">Organization Structure</a></li>
                            <li><a href="{{ route('page.show', 'dashboard') }}" class="gov-nav-drop-a">Our Dashboard</a></li>
                            <li><a href="{{ route('page.show', 'our-division') }}" class="gov-nav-drop-a">Our Division</a></li>
                        </ul>
                    </li>
                    <li class="gov-nav-li">
                        <a href="#keyOfferings" class="gov-nav-a">
                            {{ session('locale') == 'hi' ? 'योजनाएं व सेवाएं' : 'Offerings' }} <span class="gov-nav-caret">⌵</span>
                        </a>
                    </li>
                    <li class="gov-nav-li">
                        <a href="#recentDocs" class="gov-nav-a">
                            {{ session('locale') == 'hi' ? 'दस्तावेज़' : 'Documents' }} <span class="gov-nav-caret">⌵</span>
                        </a>
                    </li>
                    <li class="gov-nav-li">
                        <a href="#socialSection" class="gov-nav-a">
                            {{ session('locale') == 'hi' ? 'मीडिया' : 'Media' }} <span class="gov-nav-caret">⌵</span>
                        </a>
                    </li>
                    <li class="gov-nav-li">
                        <a href="#footerContact" class="gov-nav-a">
                            {{ session('locale') == 'hi' ? 'संपर्क' : 'Connect' }} <span class="gov-nav-caret">⌵</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>

<!-- Mobile Navigation Right-Side Offcanvas Drawer -->
<div class="offcanvas offcanvas-end mobile-nav-drawer" tabindex="-1" id="mobileNavDrawer" aria-labelledby="mobileNavDrawerLabel">
    <div class="offcanvas-header mobile-nav-header">
        <div class="d-flex align-items-center gap-2">
            <span class="material-symbols-outlined mobile-nav-hdr-icon">menu_open</span>
            <h5 class="offcanvas-title mobile-nav-title" id="mobileNavDrawerLabel">
                {{ session('locale') == 'hi' ? 'नेविगेशन मेनू' : 'Navigation Menu' }}
            </h5>
        </div>
        <button type="button" class="btn-close mobile-nav-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close menu">
            <span class="material-symbols-outlined" style="font-size: 24px;">close</span>
        </button>
    </div>

    <div class="offcanvas-body mobile-nav-body p-0">
        <!-- Brand banner inside drawer -->
        <div class="mobile-nav-brand-strip">
            <span class="mobile-nav-brand-name">{{ \App\Models\Setting::get('site_title_en', 'Textiles Committee') }}</span>
            <span class="mobile-nav-brand-sub">{{ \App\Models\Setting::get('site_tagline_en', 'Ministry of Textiles, Govt. of India') }}</span>
        </div>

        <!-- Navigation items list with collapsible accordions -->
        <nav class="mobile-nav-list" role="navigation" aria-label="Mobile Navigation">
            <ul class="mobile-nav-ul">
                <!-- Home Link -->
                <li class="mobile-nav-item">
                    <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <span class="material-symbols-outlined mobile-nav-icon">home</span>
                        <span>{{ session('locale') == 'hi' ? 'मुख्य पृष्ठ' : 'Home' }}</span>
                    </a>
                </li>

                @if(isset($headerMenuItems) && $headerMenuItems->count())
                    @foreach($headerMenuItems as $menu)
                        @php
                            $children = $menu->activeChildren;
                            $hasKids = $children->count() > 0;
                            $menuTitle = session('locale') == 'hi' ? ($menu->title_hi ?: $menu->title_en) : ($menu->title_en ?: $menu->title_hi);
                            $collapseId = 'mobCollapse_' . $menu->id;
                            
                            $isActive = false;
                            if ($menu->type === 'page' && $menu->page && request()->is('page/' . $menu->page->slug)) {
                                $isActive = true;
                            } elseif ($hasKids) {
                                foreach ($children as $ck) {
                                    if ($ck->type === 'page' && $ck->page && request()->is('page/' . $ck->page->slug)) {
                                        $isActive = true;
                                        break;
                                    }
                                    if (($ck->page && $ck->page->slug === 'industry-tech-issues') || str_contains($ck->url ?? '', 'industry-tech-issues')) {
                                        if (request()->is('industry-tech-issues*')) {
                                            $isActive = true;
                                            break;
                                        }
                                    }
                                }
                            }
                        @endphp

                        <li class="mobile-nav-item {{ $hasKids ? 'has-children' : '' }}">
                            @if($hasKids)
                                <div class="mobile-nav-accordion-header {{ $isActive ? 'active' : '' }}">
                                    <a href="{{ $menu->resolved_url !== '#' && $menu->resolved_url !== '' ? $menu->resolved_url : 'javascript:void(0)' }}" 
                                       class="mobile-nav-link-text {{ $isActive ? 'active' : '' }}">
                                        {{ $menuTitle }}
                                    </a>
                                    <button class="mobile-nav-caret-btn {{ $isActive ? '' : 'collapsed' }}" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#{{ $collapseId }}" 
                                            aria-expanded="{{ $isActive ? 'true' : 'false' }}" 
                                            aria-controls="{{ $collapseId }}"
                                            aria-label="Toggle {{ $menuTitle }} submenu">
                                        <span class="material-symbols-outlined">expand_more</span>
                                    </button>
                                </div>

                                <div class="collapse mobile-sub-collapse {{ $isActive ? 'show' : '' }}" id="{{ $collapseId }}">
                                    <ul class="mobile-sub-ul">
                                        @foreach($children as $sub)
                                            @php
                                                $subKids = $sub->activeChildren;
                                                $hasSubKids = $subKids->count() > 0;
                                                $subTitle = session('locale') == 'hi' ? ($sub->title_hi ?: $sub->title_en) : ($sub->title_en ?: $sub->title_hi);
                                                $subCollapseId = 'mobSubCollapse_' . $sub->id;
                                                $isSubActive = false;
                                                if ($sub->type === 'page' && $sub->page && request()->is('page/' . $sub->page->slug)) {
                                                    $isSubActive = true;
                                                } elseif (($sub->page && $sub->page->slug === 'industry-tech-issues') || str_contains($sub->url ?? '', 'industry-tech-issues')) {
                                                    if (request()->is('industry-tech-issues*')) {
                                                        $isSubActive = true;
                                                    }
                                                }
                                            @endphp

                                            <li class="mobile-sub-item">
                                                @if($hasSubKids)
                                                    <div class="mobile-sub-accordion-header {{ $isSubActive ? 'active' : '' }}">
                                                        <a href="{{ $sub->resolved_url !== '#' && $sub->resolved_url !== '' ? $sub->resolved_url : 'javascript:void(0)' }}" 
                                                           class="mobile-sub-link {{ $isSubActive ? 'active' : '' }}">
                                                            {{ $subTitle }}
                                                        </a>
                                                        <button class="mobile-sub-caret-btn {{ $isSubActive ? '' : 'collapsed' }}" 
                                                                type="button" 
                                                                data-bs-toggle="collapse" 
                                                                data-bs-target="#{{ $subCollapseId }}" 
                                                                aria-expanded="{{ $isSubActive ? 'true' : 'false' }}" 
                                                                aria-controls="{{ $subCollapseId }}"
                                                                aria-label="Toggle {{ $subTitle }} submenu">
                                                            <span class="material-symbols-outlined">expand_more</span>
                                                        </button>
                                                    </div>

                                                    <div class="collapse mobile-gc-collapse {{ $isSubActive ? 'show' : '' }}" id="{{ $subCollapseId }}">
                                                        <ul class="mobile-gc-ul">
                                                            @foreach($subKids as $gc)
                                                                @php
                                                                    $gcKids = $gc->activeChildren;
                                                                    $hasGcKids = $gcKids->count() > 0;
                                                                    $gcTitle = session('locale') == 'hi' ? ($gc->title_hi ?: $gc->title_en) : ($gc->title_en ?: $gc->title_hi);
                                                                    $gcCollapseId = 'mobGcCollapse_' . $gc->id;
                                                                    $isGcActive = ($gc->type === 'page' && $gc->page && request()->is('page/' . $gc->page->slug));
                                                                @endphp
                                                                <li class="mobile-gc-item">
                                                                    @if($hasGcKids)
                                                                        <div class="mobile-gc-accordion-header {{ $isGcActive ? 'active' : '' }}">
                                                                            <a href="{{ $gc->resolved_url }}" class="mobile-gc-link {{ $isGcActive ? 'active' : '' }}">
                                                                                {{ $gcTitle }}
                                                                            </a>
                                                                            <button class="mobile-gc-caret-btn collapsed" 
                                                                                    type="button" 
                                                                                    data-bs-toggle="collapse" 
                                                                                    data-bs-target="#{{ $gcCollapseId }}" 
                                                                                    aria-expanded="false" 
                                                                                    aria-controls="{{ $gcCollapseId }}">
                                                                                <span class="material-symbols-outlined">expand_more</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="collapse mobile-dc-collapse" id="{{ $gcCollapseId }}">
                                                                            <ul class="mobile-dc-ul">
                                                                                @foreach($gcKids as $dc)
                                                                                    @php
                                                                                        $dcTitle = session('locale') == 'hi' ? ($dc->title_hi ?: $dc->title_en) : ($dc->title_en ?: $dc->title_hi);
                                                                                        $isDcActive = ($dc->type === 'page' && $dc->page && request()->is('page/' . $dc->page->slug));
                                                                                    @endphp
                                                                                    <li class="mobile-dc-item">
                                                                                        <a href="{{ $dc->resolved_url }}" class="mobile-dc-link {{ $isDcActive ? 'active' : '' }}">
                                                                                            {{ $dcTitle }}
                                                                                        </a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    @else
                                                                        <a href="{{ $gc->resolved_url }}" target="{{ $gc->target ?: '_self' }}" class="mobile-gc-link {{ $isGcActive ? 'active' : '' }}">
                                                                            {{ $gcTitle }}
                                                                        </a>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <a href="{{ $sub->resolved_url }}" target="{{ $sub->target ?: '_self' }}" class="mobile-sub-link {{ $isSubActive ? 'active' : '' }}">
                                                        {{ $subTitle }}
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <a href="{{ $menu->resolved_url }}" target="{{ $menu->target ?: '_self' }}" class="mobile-nav-link {{ $isActive ? 'active' : '' }}">
                                    <span>{{ $menuTitle }}</span>
                                </a>
                            @endif
                        </li>
                    @endforeach
                @endif
            </ul>
        </nav>
    </div>

    <!-- Drawer Footer -->
    <div class="mobile-nav-footer">
        <a href="https://digitalindia.gov.in/" target="_blank" rel="noopener noreferrer" class="mobile-nav-footer-di">
            <img src="{{ asset('assets/images/digital india.png') }}" alt="Digital India" height="34">
        </a>
        <div class="mobile-nav-footer-text">
            Textiles Committee &bull; Govt. of India
        </div>
    </div>
</div>


