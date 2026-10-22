<!-- GIGW / WCAG 2.1 Accessible Skip Links -->
<a href="#mainContent" class="skip-to-main-link" tabindex="1">Skip to main content</a>
<a href="#govNavUl" class="skip-to-main-link skip-to-nav-link" tabindex="2">Skip to navigation</a>

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
                <img src="{{ asset($siteEmblem) }}" alt="State Emblem of India" class="exact-emblem-img" style="height: 85px; width: auto; object-fit: contain;">
                <img src="{{ asset($siteLogo) }}" alt="Textiles Committee Logo" class="exact-emblem-img ms-1" style="height: 82px; width: auto; object-fit: contain;">
            @elseif($siteEmblem)
                <img src="{{ asset($siteEmblem) }}" alt="State Emblem of India" class="exact-emblem-img" style="height: 62px; width: auto; object-fit: contain;">
            @elseif($siteLogo)
                <img src="{{ asset($siteLogo) }}" alt="Textiles Committee Logo" class="exact-emblem-img" style="height: 62px; width: auto; object-fit: contain;">
            @else
                <img src="{{ asset('assets/images/Textiles_Committee_Logo.png') }}" alt="Government of India Emblem" class="exact-emblem-img" onerror="this.onerror=null;this.src='{{ asset('assets/images/Textiles_Committee_Logo.png') }}'">
            @endif

            <div class="exact-brand-text">
                <span class="exact-brand-title">{{ \App\Models\Setting::get('site_title_en', 'Textiles Committee') }}</span>
                <span class="exact-brand-sub">{{ \App\Models\Setting::get('site_tagline_en', 'Ministry of Textiles') }}</span>
            </div>
        </a>

        <!-- Center: Search Box with Maroon Bottom Accent -->
        <div class="exact-search-wrap">
            <form action="{{ route('site.search') }}" method="GET" class="exact-search-box" role="search" aria-label="Site Search">
                <input type="search" name="q" placeholder="Search..." value="{{ request('q') }}" aria-label="Search keywords">
                <div class="exact-search-divider"></div>
                <button type="submit" class="exact-search-btn" title="Submit Search" aria-label="Submit Search">
                    <span class="material-symbols-outlined" style="font-size: 24px; color: #6c1340; font-weight: 600;">search</span>
                </button>
            </form>
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
                <span><i class="fa fa-bars me-2"></i> Menu</span>
                <span class="material-symbols-outlined" style="font-size: 20px;">expand_more</span>
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


