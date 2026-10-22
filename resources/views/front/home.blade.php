@extends('layouts.front')

@section('content')

    <!-- 1. HERO BANNER SLIDER -->
    <section class="hero-banner-wrap">
        <div class="hero-banner-track" id="heroTrack">
            @forelse($banners as $index => $banner)
                <div class="hero-banner-slide">
                    @if(!empty($banner->link_url) && $banner->link_url !== '#')
                        <a href="{{ $banner->link_url }}" target="_blank">
                            <img src="{{ asset($banner->image_url) }}" alt="{{ $banner->title_en ?: 'Ministry of Textiles Banner' }}" onerror="this.src='{{ asset('assets/images/hero_auditorium.png') }}'">
                        </a>
                    @else
                        <img src="{{ asset($banner->image_url) }}" alt="{{ $banner->title_en ?: 'Ministry of Textiles Banner' }}" onerror="this.src='{{ asset('assets/images/hero_auditorium.png') }}'">
                    @endif
                </div>
            @empty
                <div class="hero-banner-slide">
                    <img src="{{ asset('assets/images/hero_auditorium.png') }}" alt="Ministry of Textiles Summit">
                </div>
            @endforelse
        </div>

        <!-- Arrows -->
        <button class="hero-arrow-btn hero-arrow-prev" onclick="prevHeroSlide()" aria-label="Previous Slide">‹</button>
        <button class="hero-arrow-btn hero-arrow-next" onclick="nextHeroSlide()" aria-label="Next Slide">›</button>

        <!-- Dots & Pause Indicator -->
        <div class="hero-dots-badge">
            @foreach($banners as $index => $b)
                <button class="hero-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToHeroSlide({{ $index }})" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
            <button class="hero-pause-btn" id="heroPauseBtn" onclick="toggleHeroPlay()" aria-label="Pause Auto-slider">⏸</button>
        </div>
    </section>

    <!-- 2. ANNOUNCEMENTS TICKER -->
    <div class="announcements-bar">
        <div class="page-container d-flex align-items-center w-100">
            <div class="announcements-label">
                Announcements <img src="{{ asset('assets/images/Announcement.svg') }}" alt="Announcement" width="25" height="25">
            </div>
            <div class="announcements-ticker-wrap">
                <div class="announcements-track">
                    @forelse($announcements as $ann)
                        <a href="{{ $ann->link_url ?? '#' }}" class="ticker-link">
                            {{ $ann->title_en }}
                        </a>
                    @empty
                        <span class="ticker-link">Shri Giriraj Singh holds review meeting on PLI Scheme for Textiles and export competitiveness.</span>
                        <span class="ticker-link">Extension of Rebate of State and Central Taxes and Levies Scheme on Export of Apparel/Garment and Made-ups (RoSCTL).</span>
                    @endforelse
                </div>
            </div>
            <div class="ms-3 text-secondary" style="font-size: 1.6rem;">
                <i class="fa fa-pause-circle" style="cursor: pointer;"></i>
            </div>
        </div>
    </div>

    <!-- 3. HON'BLE PRIME MINISTER'S QUOTE CARD -->
    <section class="pm-quote-section">
        <!-- <div class="page-container"> -->
            <div class="pm-quote-box">
                <!-- PM Circular Avatar -->
                <div class="pm-quote-avatar-wrap">
                    <img src="{{ asset($pm->photo_url ?? 'assets/images/pm_quote_avatar.png') }}" alt="{{ $pm->name_en ?? 'Shri Narendra Modi' }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/pm_quote_avatar.png') }}'">
                </div>

                <!-- Quote Text & Attribution -->
                <div class="pm-quote-content">
                    <div>
                        <span class="pm-quote-mark">“</span>
                        <h3 class="pm-quote-text">
                            {{ $pm->quote_en ?? "India's technical textiles sector is witnessing rapid growth, driven by key initiatives like the National Technical Textiles Mission and the PLI scheme. These efforts are boosting manufacturing, innovation and exports, positioning India as a global leader." }}
                        </h3>
                        <span class="pm-quote-mark">”</span>
                    </div>

                    <div class="pm-quote-footer">
                        <div>
                            <div class="pm-quote-meta">{{ $pm->designation_en ?? 'PRESS INFORMATION BUREAU' }}</div>
                            <div class="pm-quote-date">{{ $pm->quote_date ?? '10.08.2025' }}</div>
                        </div>
                        <a href="{{ $pm->profile_link ?? 'https://pmindia.gov.in' }}" target="_blank" class="btn-read-more">
                            <span class="material-symbols-outlined" style="font-size: 14px;">open_in_new</span> READ MORE
                        </a>
                    </div>
                </div>
            </div>
        <!-- </div> -->
    </section>

    <!-- 4. ABOUT US & DIGNITARIES -->
    <section class="about-section">
        <div class="page-container">
            <div class="about-dignitaries-grid">
                <!-- Left: About Text & 3 Outline Pill Buttons -->
                <div>
                    <div class="section-heading-wrap">
                        <!-- <span class="material-symbols-outlined section-heading-icon">account_tree</span> -->
                        <img src="{{ asset('assets/images/Department.svg') }}" alt="About Us" width="45" height="45">
                        <h2 class="section-heading">About Us</h2>
                    </div>

                    <p class="about-text">
                        {{ $aboutExcerpt }}
                        <a href="{{ route('page.show', 'history') }}" class="about-readmore-btn">Read More <i class="fa fa-arrow-right ms-1"></i></a>
                    </p>

                    <div class="about-action-btns-group">
                        <a href="{{ route('page.show', 'team') }}" class="about-pill-btn">
                            <!-- <span class="material-symbols-outlined" style="font-size: 30px;">groups</span> -->
                            <img src="{{ asset('assets/images/Group.svg') }}" alt="our team" width="45" height="45">
                            <span class="about-pill-title">Our Team</span>
                        </a>
                        <a href="{{ route('page.show', 'organization-setup') }}" class="about-pill-btn">
                            <!-- <span class="material-symbols-outlined" style="font-size: 30px;">schema</span> -->
                            <img src="{{ asset('assets/images/Organisation.svg') }}" alt="Organisation" width="45" height="45">
                            <span class="about-pill-title">Our Organisation</span>
                        </a>
                        <a href="{{ route('page.show', 'dashboard') }}" class="about-pill-btn">
                            <!-- <span class="material-symbols-outlined" style="font-size: 30px;">leaderboard</span> -->
                            <img src="{{ asset('assets/images/Bar_Chart.svg') }}" alt="dashboard" width="45" height="45">
                            <span class="about-pill-title">Our Dashboard</span>
                        </a>
                    </div>
                </div>

                <!-- Right: Dignitaries Row (Fully Connected to CMS) -->
                <div>
                    <div class="dignitaries-row">
                        @forelse($ministers as $minister)
                            <div class="dignitary-card-exact">
                                <img src="{{ asset($minister->photo_url) }}" alt="{{ $minister->name_en }}" class="dignitary-photo" onerror="this.onerror=null;this.src='{{ asset('assets/images/dignitary_giriraj.png') }}'">
                                <h3 class="dignitary-name-exact">{{ $minister->name_en }}</h3>
                                <h4 class="dignitary-desig-exact">{{ $minister->designation_en }}</h4>
                            </div>
                        @empty
                            <!-- Fallback Dignitaries -->
                            <div class="dignitary-card-exact">
                                <img src="{{ asset('assets/images/dignitary_giriraj.png') }}" alt="Shri Giriraj Singh" class="dignitary-photo">
                                <div class="dignitary-name-exact">Shri Giriraj Singh</div>
                                <div class="dignitary-desig-exact">Hon'ble Minister of Textiles</div>
                            </div>
                            <div class="dignitary-card-exact">
                                <img src="{{ asset('assets/images/dignitary_pabitra.png') }}" alt="Shri Pabitra Margherita" class="dignitary-photo">
                                <div class="dignitary-name-exact">Shri Pabitra Margherita</div>
                                <div class="dignitary-desig-exact">Hon'ble Minister of State for Textiles</div>
                            </div>
                            <div class="dignitary-card-exact">
                                <img src="{{ asset('assets/images/dignitary_neelam.png') }}" alt="Smt. Neelam Shami Rao" class="dignitary-photo">
                                <div class="dignitary-name-exact">Smt. Neelam Shami Rao</div>
                                <div class="dignitary-desig-exact">Secretary, Ministry of Textiles</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. KEY OFFERINGS & WHAT'S NEW -->
    <section class="offerings-whatsnew-section" id="keyOfferings">
        <div class="page-container">
            <div class="offerings-grid">
                <!-- Left: Key Offerings -->
                <div>
                    <div class="section-heading-wrap">
                        <img src="{{ asset('assets/images/Offerings.svg') }}" alt="key_offering" width="45" height="45">
                        <!-- <span class="material-symbols-outlined section-heading-icon">eco</span> -->
                        <h2 class="section-heading">Key Offerings</h2>
                    </div>

                    <!-- 3 Tabs Header -->
                    <div class="offerings-tabs-header">
                        <button type="button" class="offerings-tab-btn active" onclick="switchOfferingTab('schemes', this)">Schemes and Services</button>
                        <button type="button" class="offerings-tab-btn" onclick="switchOfferingTab('vacancies', this)">Vacancies</button>
                        <button type="button" class="offerings-tab-btn" onclick="switchOfferingTab('tenders', this)">Tenders</button>
                    </div>

                    <!-- Offerings List Box -->
                    <div class="offerings-list-box" id="tabContentSchemes">
                        @forelse($schemes as $scheme)
                            <a href="{{ $scheme->link_url ?: ($scheme->guidelines_doc ? asset($scheme->guidelines_doc) : '#') }}" class="offerings-item">
                                <span>{{ $scheme->title_en }}</span>
                                <i class="fa fa-chevron-right"></i>
                            </a>
                        @empty
                            <div class="p-3 text-muted" style="font-size: 1.55rem;">No active schemes currently available.</div>
                        @endforelse
                    </div>

                    <div class="offerings-list-box d-none" id="tabContentVacancies">
                        @forelse($vacancies as $vac)
                            <a href="{{ asset($vac->document_url ?? 'assets/images/sample_doc.pdf') }}" target="_blank" class="offerings-item">
                                <span>{{ $vac->title_en }}</span>
                                <i class="fa fa-chevron-right"></i>
                            </a>
                        @empty
                            <div class="p-3 text-muted" style="font-size: 1.55rem;">No active vacancies currently open.</div>
                        @endforelse
                    </div>

                    <div class="offerings-list-box d-none" id="tabContentTenders">
                        @forelse($tenders as $ten)
                            <a href="{{ asset($ten->document_url ?? 'assets/images/sample_doc.pdf') }}" target="_blank" class="offerings-item">
                                <span>{{ $ten->title_en }}</span>
                                <i class="fa fa-chevron-right"></i>
                            </a>
                        @empty
                            <div class="p-3 text-muted" style="font-size: 1.55rem;">No active tenders found.</div>
                        @endforelse
                    </div>

                    <a href="{{ route('page.show', 'testing-services') }}" class="btn-view-more-outline">VIEW MORE &gt;</a>
                    <div style="clear: both;"></div>
                </div>

                <!-- Right: What's New Solid Card -->
                <div id="whatsNew">
                    <div class="section-heading-wrap d-flex justify-content-between align-items-center">
                        <a href="{{ route('whats-new.index') }}" class="d-flex align-items-center gap-2 text-decoration-none" style="color: inherit;">
                            <img src="{{ asset('assets/images/Whats_New.svg') }}" alt="key_offering" width="45" height="45">
                            <h2 class="section-heading m-0">What's New</h2>
                        </a>
                    </div>

                    <div class="whatsnew-card-solid">
                        @forelse($whatsNews as $item)
                            <a href="{{ $item->link_url ?: ($item->document_url ? asset($item->document_url) : route('whats-new.index')) }}" target="{{ $item->link_url || $item->document_url ? '_blank' : '_self' }}" class="whatsnew-item">
                                <span>{{ $item->title_en }}</span>
                                <i class="fa fa-chevron-right"></i>
                            </a>
                        @empty
                            <div class="p-3 text-white-50" style="font-size: 1.55rem;">No recent announcements.</div>
                        @endforelse

                        <a href="{{ route('whats-new.index') }}" class="btn-view-more-white">VIEW MORE &gt;</a>
                        <div style="clear: both;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. RECENT DOCUMENTS & GOVERNMENT SPONSORED SCHEMES (SIDE BY SIDE) -->
    <section class="docs-schemes-section" id="recentDocs">
        <div class="page-container">
            <div class="docs-schemes-grid">
                <!-- Left Column: Recent Documents (2x2 Grid) -->
                <div>
                    <div class="section-heading-wrap d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset('assets/images/Reports.svg') }}" alt="recent doc" width="45" height="45">
                            <h2 class="section-heading m-0">Recent Documents</h2>
                        </div>
                    </div>

                    <div class="docs-2x2-grid">
                        @forelse($documents->take(4) as $doc)
                            <a href="{{ asset($doc->file_url ?? 'assets/images/sample_doc.pdf') }}" target="_blank" class="doc-item-box">
                                <h3 class="doc-box-title" style="text-decoration: underline;">{{ $doc->title_en }}</h3>
                                <div class="doc-box-sub">{{ $doc->description_en }}</div>
                            </a>
                        @empty
                            <div class="p-3 text-muted" style="font-size: 1.55rem;">No documents published yet.</div>
                        @endforelse
                    </div>

                    <a href="{{ route('page.show', 'reports-budget') }}" class="btn-view-more-outline mt-3">VIEW MORE &gt;</a>
                    <div style="clear: both;"></div>
                </div>

                <!-- Right Column: Government Sponsored Schemes (Current Theme) -->
                <div class="govt-schemes-box">
                    <div class="section-heading-wrap d-flex align-items-center gap-2 mb-1">
                        <img src="{{ asset('assets/images/Public.svg') }}" alt="schemes" width="45" height="45">
                        <h2 class="section-heading m-0">{{ $settings['samarth_scheme_title'] ?? 'Government Sponsored Schemes' }}</h2>
                    </div>

                    <p class="govt-schemes-theme-desc">
                        {{ $settings['samarth_scheme_desc'] ?? 'The Ministry of Textiles, Government of India has designated the Textiles Committee as the Resource Support Agency (RSA) with the view to operate as technical arm for maintaining Quality in the process of implementation of the scheme SAMARTH.' }}
                    </p>

                    <div class="govt-stats-theme-grid">
                        <!-- Card 1 -->
                        <div class="govt-stat-theme-card">
                            <div class="govt-stat-theme-label">Registrations</div>
                            <div class="govt-stat-theme-value stat-ticker" data-target="{{ preg_replace('/[^0-9]/', '', $settings['stat_registrations'] ?? '29379') }}">{{ $settings['stat_registrations'] ?? '29,379' }}</div>
                        </div>

                        <!-- Card 2 -->
                        <div class="govt-stat-theme-card">
                            <div class="govt-stat-theme-label">Handlooms covered</div>
                            <div class="govt-stat-theme-value stat-ticker" data-target="{{ preg_replace('/[^0-9]/', '', $settings['stat_handlooms_covered'] ?? '968018') }}">{{ $settings['stat_handlooms_covered'] ?? '968,018' }}</div>
                        </div>

                        <!-- Card 3 -->
                        <div class="govt-stat-theme-card">
                            <div class="govt-stat-theme-label">Active Assessors</div>
                            <div class="govt-stat-theme-value stat-ticker" data-target="{{ preg_replace('/[^0-9]/', '', $settings['stat_active_assessors'] ?? '4301') }}">{{ $settings['stat_active_assessors'] ?? '4,301' }}</div>
                        </div>

                        <!-- Card 4 -->
                        <div class="govt-stat-theme-card">
                            <div class="govt-stat-theme-label">Entry-level Trainees</div>
                            <div class="govt-stat-theme-value stat-ticker" data-target="{{ preg_replace('/[^0-9]/', '', $settings['stat_entry_trainees_covered'] ?? '682414') }}">{{ $settings['stat_entry_trainees_covered'] ?? '682,414' }}</div>
                        </div>

                        <!-- Card 5 -->
                        <div class="govt-stat-theme-card">
                            <div class="govt-stat-theme-label">Total Weavers</div>
                            <div class="govt-stat-theme-value stat-ticker" data-target="{{ preg_replace('/[^0-9]/', '', $settings['stat_total_weavers'] ?? '21245') }}">{{ $settings['stat_total_weavers'] ?? '21,245' }}</div>
                        </div>

                        <!-- Card 6 -->
                        <div class="govt-stat-theme-card">
                            <div class="govt-stat-theme-label">Societies</div>
                            <div class="govt-stat-theme-value stat-ticker" data-target="{{ preg_replace('/[^0-9]/', '', $settings['stat_societies'] ?? '5867') }}">{{ $settings['stat_societies'] ?? '5,867' }}</div>
                        </div>

                        <!-- Card 7 -->
                        <div class="govt-stat-theme-card">
                            <div class="govt-stat-theme-label">Origin Cert. Issued</div>
                            <div class="govt-stat-theme-value stat-ticker" data-target="{{ preg_replace('/[^0-9]/', '', $settings['stat_origin_certificates'] ?? '67381') }}">{{ $settings['stat_origin_certificates'] ?? '67,381' }}</div>
                        </div>

                        <!-- Card 8 -->
                        <div class="govt-stat-theme-card">
                            <div class="govt-stat-theme-label">Lots Inspected</div>
                            <div class="govt-stat-theme-value stat-ticker" data-target="{{ preg_replace('/[^0-9]/', '', $settings['stat_lots_inspected'] ?? '112') }}">{{ $settings['stat_lots_inspected'] ?? '112' }}</div>
                        </div>

                        <!-- Card 9 -->
                        <div class="govt-stat-theme-card">
                            <div class="govt-stat-theme-label">Exporters under REX</div>
                            <div class="govt-stat-theme-value stat-ticker" data-target="{{ preg_replace('/[^0-9]/', '', $settings['stat_exporters_rex'] ?? '6786') }}">{{ $settings['stat_exporters_rex'] ?? '6,786' }}</div>
                        </div>

                        <!-- Card 10 -->
                        <div class="govt-stat-theme-card">
                            <div class="govt-stat-theme-label">Upskill Trainees</div>
                            <div class="govt-stat-theme-value stat-ticker" data-target="{{ preg_replace('/[^0-9]/', '', $settings['stat_upskill_trainees'] ?? '25220') }}">{{ $settings['stat_upskill_trainees'] ?? '25,220' }}</div>
                        </div>

                        <!-- Card 11 -->
                        <div class="govt-stat-theme-card">
                            <div class="govt-stat-theme-label">Labels issued PTL</div>
                            <div class="govt-stat-theme-value stat-ticker" data-target="{{ preg_replace('/[^0-9]/', '', $settings['stat_labels_ptl'] ?? '216850838') }}">{{ $settings['stat_labels_ptl'] ?? '216,850,838' }}</div>
                        </div>

                        <!-- Card 12 -->
                        <div class="govt-stat-theme-card">
                            <div class="govt-stat-theme-label">Trainees Assessed</div>
                            <div class="govt-stat-theme-value stat-ticker" data-target="{{ preg_replace('/[^0-9]/', '', $settings['stat_trainees_assessed'] ?? '635305') }}">{{ $settings['stat_trainees_assessed'] ?? '635,305' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. IN SOCIAL MEDIA (Connected to CMS Settings) -->
    <section class="social-full-section" id="socialSection">
        <div class="page-container">
            <div class="social-heading-white">
                <!-- <span class="material-symbols-outlined" style="font-size: 24px;">forum</span> -->
                <!-- <img src="{{ asset('assets/images/News_Feed.svg') }}" alt="socialmedia" width="45" height="45"> -->
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 46 46" fill="none" class="headingclr"><path opacity="0.946" fill-rule="evenodd" clip-rule="evenodd" d="M17.2871 0.5C18.6054 0.5 19.9238 0.5 21.2421 0.5C28.6123 1.58446 33.7833 5.53956 36.7549 12.3652C37.5 14.3187 37.9249 16.3401 38.0293 18.4296C40.0253 18.3904 42.0176 18.4343 44.0059 18.5616C44.7525 18.8434 45.2505 19.356 45.5 20.0996C45.5 28.039 45.5 35.9785 45.5 43.9179C45.1777 44.6503 44.6503 45.1777 43.9179 45.5C34.4844 45.5 25.0507 45.5 15.6172 45.5C14.7214 45.2043 14.1793 44.5891 13.9913 43.6543C13.9473 41.5159 13.9326 39.3772 13.9473 37.2383C7.47208 35.1722 3.20936 30.8948 1.15918 24.4062C0.871588 23.2938 0.65186 22.1805 0.5 21.0664C0.5 19.8359 0.5 18.6054 0.5 17.375C1.44811 10.3643 5.08093 5.28121 11.3984 2.12598C13.2952 1.30267 15.258 0.760685 17.2871 0.5ZM18.166 2.16993C18.2539 2.16993 18.3418 2.16993 18.4296 2.16993C18.4296 4.60157 18.4296 7.03318 18.4296 9.46482C16.4491 9.50173 14.4863 9.70678 12.541 10.0801C13.0328 7.56073 14.2046 5.34879 16.0567 3.44433C16.6981 2.90447 17.4013 2.47966 18.166 2.16993ZM20.0117 2.16993C20.5444 2.26014 21.0425 2.45057 21.5058 2.74121C22.8013 3.65541 23.812 4.81264 24.5382 6.2129C25.1832 7.44567 25.7253 8.72007 26.1641 10.0361C24.1285 9.72425 22.0778 9.53375 20.0117 9.46482C20.0117 7.03318 20.0117 4.60157 20.0117 2.16993ZM14.1231 2.78515C14.2155 2.77201 14.3035 2.78667 14.3867 2.8291C12.5445 5.06339 11.2701 7.59755 10.5635 10.4317C8.19778 11.1031 5.98585 12.114 3.92774 13.4638C3.56152 13.7715 3.19532 14.0791 2.8291 14.3867C4.37244 9.29705 7.58045 5.64963 12.4531 3.44433C13.029 3.24804 13.5856 3.02831 14.1231 2.78515ZM24.1425 2.78515C29.9335 4.67956 33.8007 8.51742 35.7441 14.2988C35.7001 14.3886 35.6415 14.4032 35.5684 14.3428C34.3918 13.2853 33.0734 12.4357 31.6133 11.7939C30.4345 11.3082 29.2332 10.8834 28.0098 10.5196C27.2751 7.64382 25.986 5.06571 24.1425 2.78515ZM17.4629 11.0469C17.7852 11.0469 18.1074 11.0469 18.4296 11.0469C18.4296 13.5078 18.4296 15.9688 18.4296 18.4296C15.9688 18.4296 13.5078 18.4296 11.0469 18.4296C11.1303 16.21 11.394 14.0127 11.8379 11.8379C13.7109 11.4739 15.586 11.2104 17.4629 11.0469ZM20.0117 11.0469C22.2452 11.088 24.4425 11.381 26.6035 11.9258C27.1017 14.037 27.3947 16.1758 27.4825 18.3418C24.9929 18.4297 22.5026 18.459 20.0117 18.4296C20.0117 15.9688 20.0117 13.5078 20.0117 11.0469ZM9.90432 12.3652C9.9998 12.3758 10.0584 12.4345 10.0801 12.541C9.70678 14.4863 9.50173 16.4491 9.46482 18.4296C7.03318 18.4296 4.60157 18.4296 2.16993 18.4296C2.30506 17.7493 2.58336 17.1341 3.00488 16.584C4.00296 15.4623 5.16019 14.5395 6.47656 13.8153C7.60288 13.2699 8.7455 12.7865 9.90432 12.3652ZM28.3613 12.4531C31.068 13.0677 33.397 14.386 35.3486 16.4082C35.8003 16.989 36.1371 17.6334 36.3594 18.3418C33.9284 18.4297 31.4968 18.459 29.0644 18.4296C29.0132 16.404 28.7789 14.4118 28.3613 12.4531ZM2.16993 20.0117C4.60157 20.0117 7.03318 20.0117 9.46482 20.0117C9.4796 20.8333 9.52355 21.6537 9.59667 22.4727C9.73565 23.7085 9.88212 24.9389 10.0361 26.1641C8.1275 25.5685 6.35505 24.7044 4.71874 23.5713C3.71625 22.833 2.93988 21.9102 2.38965 20.8027C2.28903 20.545 2.21578 20.2813 2.16993 20.0117ZM11.0469 20.0117C12.0429 20.0117 13.0391 20.0117 14.0352 20.0117C13.9796 22.354 13.9211 24.6978 13.8594 27.0429C13.1944 26.9129 12.5352 26.7663 11.8819 26.6035C11.38 24.4348 11.1017 22.2376 11.0469 20.0117ZM16.1446 20.0117C25.2265 19.9971 34.3087 20.0117 43.3906 20.0556C43.6153 20.1159 43.7766 20.2477 43.8741 20.4512C43.9179 25.7833 43.9326 31.1151 43.9179 36.4473C34.455 36.4473 24.9922 36.4473 15.5293 36.4473C15.5146 31.1737 15.5293 25.9003 15.5732 20.6269C15.6628 20.318 15.8532 20.1129 16.1446 20.0117ZM27.3066 23.791C27.5637 23.7875 27.7981 23.8607 28.0098 24.0107C30.0682 25.2816 32.1044 26.5852 34.1181 27.9219C34.2393 28.3083 34.1368 28.6161 33.8106 28.8447C31.8328 30.0532 29.8699 31.2838 27.9219 32.5361C27.4455 32.7871 27.0792 32.6845 26.8232 32.2285C26.7646 29.5918 26.7646 26.9551 26.8232 24.3184C26.9129 24.0679 27.0741 23.892 27.3066 23.791ZM2.78515 24.0546C5.06305 25.9263 7.6412 27.2445 10.5196 28.0098C11.1561 30.6012 12.2841 32.945 13.9033 35.041C13.9744 35.2237 13.9597 35.3995 13.8594 35.5684C8.25387 33.5665 4.56247 29.7285 2.78515 24.0546ZM12.3652 28.3613C12.8854 28.4871 13.4128 28.575 13.9473 28.625C13.9619 29.7971 13.9473 30.969 13.9033 32.1406C13.2444 30.9407 12.7318 29.6808 12.3652 28.3613ZM15.5293 38.0293C24.9922 38.0293 34.455 38.0293 43.9179 38.0293C43.9326 39.8753 43.9179 41.721 43.8741 43.5664C43.7714 43.669 43.669 43.7714 43.5664 43.8741C34.3671 43.9327 25.168 43.9327 15.9688 43.8741C15.7401 43.7918 15.6082 43.6309 15.5732 43.3906C15.5293 41.6037 15.5146 39.8167 15.5293 38.0293Z" fill="white"></path></svg>
                <h2>In Social Media</h2>
            </div>

            <div class="social-cards-grid">
                <!-- 1. X / Twitter Card (Connected to CMS Social Posts) -->
                <div class="social-feed-card">
                    <div class="social-card-head">
                        <span>X</span>
                    </div>
                    <div class="social-feed-body">
                        @forelse($socialPosts['twitter'] ?? [] as $post)
                            <div class="tweet-post-box">
                                @if($post->media_image)
                                    <a href="{{ $post->post_url }}" target="_blank" class="d-block mb-2">
                                        <img src="{{ $post->getDisplayImage() }}" alt="{{ $post->title ?? 'Tweet Image' }}" class="tweet-thumb-img" onerror="this.src='{{ asset('assets/images/hero_auditorium.png') }}'">
                                    </a>
                                @endif
                                <div class="tweet-user-bar">
                                    <div class="tweet-user-left">
                                        <img src="{{ asset('assets/images/header_emblem_logo.png') }}" alt="Textiles Committee" class="tweet-avatar-sm">
                                        <div class="tweet-name-wrap">
                                            <div class="tweet-user-name">
                                                {{ $post->author_name ?? 'Textiles Committee' }} <i class="fa-solid fa-circle-check text-primary"></i>
                                            </div>
                                            <div class="tweet-user-handle">
                                                {{ $post->author_handle ?? '@TexComIndia' }} · <a href="{{ $post->post_url }}" target="_blank" style="color: #1d9bf0; text-decoration: none;">Follow</a>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ $post->post_url }}" target="_blank" style="color: inherit;"><i class="fa-brands fa-x-twitter" style="font-size: 1.6rem;"></i></a>
                                </div>
                                @if($post->content)
                                    <div class="tweet-text-content">
                                        {{ $post->content }}
                                    </div>
                                @endif
                                <div class="tweet-meta-row">
                                    <span>{{ $post->post_date ?? 'Recent' }}</span>
                                    <a href="{{ $post->post_url }}" target="_blank" title="View Tweet" style="color: #536471;"><i class="fa-solid fa-circle-info"></i></a>
                                </div>
                                <div class="tweet-actions-row">
                                    <span><i class="fa-solid fa-heart text-danger"></i> {{ $post->likes_count ?? '142' }}</span>
                                    <a href="{{ $post->post_url }}" target="_blank"><i class="fa-solid fa-retweet text-success"></i> {{ $post->shares_count ?? '38' }}</a>
                                    <a href="{{ $post->post_url }}" target="_blank"><i class="fa-solid fa-comment text-primary"></i> {{ $post->comments_count ?? '16' }}</a>
                                </div>
                                <a href="{{ $post->post_url }}" target="_blank" class="tweet-replies-pill">Read {{ $post->comments_count ?? '2' }} replies</a>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted" style="font-size: 1.55rem;">No tweets available.</div>
                        @endforelse
                    </div>
                </div>

                <!-- 2. YouTube Card (Connected to CMS Social Posts) -->
                <div class="social-feed-card">
                    <div class="social-card-head">
                        <span>Youtube</span>
                    </div>
                    <div class="social-feed-body">
                        @forelse($socialPosts['youtube'] ?? [] as $post)
                            <div class="yt-video-card">
                                <div class="yt-thumb-container">
                                    <img src="{{ $post->getDisplayImage() }}" alt="{{ $post->title ?? 'YouTube Video' }}" onerror="this.src='{{ asset('assets/images/feed_yt_crop.png') }}'">
                                    <div class="yt-top-overlay">
                                        <img src="{{ asset('assets/images/header_emblem_logo.png') }}" alt="Emblem" class="yt-overlay-avatar">
                                        <div class="yt-overlay-text">{{ $post->title ?? 'Textiles in News' }}</div>
                                    </div>
                                    <a href="{{ $post->post_url }}" target="_blank" class="yt-play-center" style="pointer-events: auto;" title="Play on YouTube">
                                        <div class="yt-play-badge">
                                            <div class="yt-play-triangle"></div>
                                        </div>
                                    </a>
                                    <div class="yt-bottom-overlay">
                                        <div class="yt-icons-left">
                                            <i class="fa-solid fa-share-nodes"></i>
                                            <i class="fa-regular fa-clock"></i>
                                        </div>
                                        <a href="{{ $post->post_url }}" target="_blank" class="yt-watch-btn-pill">
                                            Watch on <strong style="color: #ffffff;">YouTube</strong>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted" style="font-size: 1.55rem;">No videos available.</div>
                        @endforelse
                    </div>
                </div>

                <!-- 3. Facebook Card (Connected to CMS Social Posts) -->
                <div class="social-feed-card">
                    <div class="social-card-head">
                        <span>Facebook</span>
                    </div>
                    <div class="social-feed-body">
                        @forelse($socialPosts['facebook'] ?? [] as $post)
                            <div class="fb-card-box">
                                <div class="fb-card-header">
                                    <div class="fb-user-part">
                                        <img src="{{ asset('assets/images/header_emblem_logo.png') }}" alt="Textiles Committee" class="fb-avatar-ring">
                                        <div>
                                            <div class="fb-user-title">
                                                {{ $post->author_name ?? 'Textiles Committee' }} <i class="fa-solid fa-circle-check text-primary"></i>
                                            </div>
                                            <div class="fb-time-ago">{{ $post->post_date ?? 'Recent' }}</div>
                                        </div>
                                    </div>
                                    <a href="{{ $post->post_url }}" target="_blank"><i class="fa-brands fa-facebook" style="color: #1877f2; font-size: 1.6rem;"></i></a>
                                </div>
                                @if($post->content)
                                    <div class="fb-post-caption-text">
                                        {{ $post->content }}
                                    </div>
                                @endif
                                @if($post->media_image)
                                    <a href="{{ $post->post_url }}" target="_blank" class="d-block">
                                        <img src="{{ $post->getDisplayImage() }}" alt="{{ $post->title ?? 'Facebook Post' }}" class="fb-card-image" onerror="this.src='{{ asset('assets/images/social_fb.png') }}'">
                                    </a>
                                @endif
                                <div class="fb-reactions-bar">
                                    <span><i class="fa-solid fa-thumbs-up text-primary"></i> <i class="fa-solid fa-heart text-danger"></i> {{ $post->likes_count ?? '142' }}</span>
                                    <span>{{ $post->comments_count ?? '18' }} comments · {{ $post->shares_count ?? '24' }} shares</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted" style="font-size: 1.55rem;">No Facebook posts available.</div>
                        @endforelse
                    </div>
                </div>

                <!-- 4. Instagram Card (Connected to CMS Social Posts) -->
                <div class="social-feed-card">
                    <div class="social-card-head">
                        <span>Instagram</span>
                    </div>
                    <div class="social-feed-body">
                        @forelse($socialPosts['instagram'] ?? [] as $post)
                            <div class="ig-card-box">
                                <div class="ig-card-header">
                                    <div class="ig-user-left">
                                        <div class="ig-avatar-ring-grad">
                                            <img src="{{ asset('assets/images/header_emblem_logo.png') }}" alt="Instagram">
                                        </div>
                                        <div>
                                            <div class="ig-handle-title">{{ $post->author_name ?? 'textilescommitteeindia' }}</div>
                                            <div class="ig-followers-sub">{{ $post->author_handle ?? '@textilescommitteeindia' }}</div>
                                        </div>
                                    </div>
                                    <a href="{{ $post->post_url }}" target="_blank" class="ig-view-profile-btn">View profile</a>
                                </div>
                                <div class="ig-media-card-wrap">
                                    <a href="{{ $post->post_url }}" target="_blank">
                                        <img src="{{ $post->getDisplayImage() }}" alt="{{ $post->title ?? 'Instagram Post' }}" onerror="this.src='{{ asset('assets/images/social_insta.png') }}'">
                                        <div class="ig-play-overlay-icon">
                                            <i class="fa-solid fa-play" style="font-size: 1rem; margin-left: 2px;"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="ig-icons-bar">
                                    <div class="ig-icons-left-group">
                                        <i class="fa-regular fa-heart"></i>
                                        <i class="fa-regular fa-comment"></i>
                                        <i class="fa-regular fa-paper-plane"></i>
                                    </div>
                                    <i class="fa-regular fa-bookmark"></i>
                                </div>
                                @if($post->content)
                                    <div class="ig-caption-text">
                                        <strong>{{ $post->author_name ?? 'texminindia' }}</strong> {{ $post->content }}
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted" style="font-size: 1.55rem;">No Instagram posts available.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. CAMPAIGN BANNERS (Integrated with CCPS & DBIM APIs) -->
    <section class="campaign-section" aria-label="Campaigns and Initiatives">
        <div class="page-container">
            <div class="campaign-banners-grid">
                @forelse($campaigns as $camp)
                    <a href="{{ $camp->link_url ?? '#' }}" target="_blank" class="campaign-item-card" title="{{ $camp->title_en }}">
                        <img src="{{ Str::startsWith($camp->image_url, ['http://', 'https://']) ? $camp->image_url : asset($camp->image_url) }}" alt="{{ $camp->title_en }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/camp_make_in_india_exact.png') }}'">
                    </a>
                @empty
                    <!-- Make in India -->
                    <a href="https://www.makeinindia.com" target="_blank" class="campaign-item-card" title="Make in India">
                        <img src="{{ asset('assets/images/camp_make_in_india_exact.png') }}" alt="Make in India - Driving India's Growth" onerror="this.src='{{ asset('assets/images/make_in_india.png') }}'">
                    </a>

                    <!-- BRICS 2026 -->
                    <a href="#" class="campaign-item-card" title="BRICS INDIA 2026">
                        <img src="{{ asset('assets/images/camp_brics_exact.png') }}" alt="BRICS INDIA 2026" onerror="this.src='{{ asset('assets/images/brics_2026.png') }}'">
                    </a>

                    <!-- National Dashboard -->
                    <a href="{{ route('page.show', 'dashboard') }}" class="campaign-item-card" title="National Textile Dashboard">
                        <img src="{{ asset('assets/images/camp_dashboard_exact.png') }}" alt="National Textile Dashboard" onerror="this.src='{{ asset('assets/images/dashboard_banner.png') }}'">
                    </a>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Interactive Scripts for Hero Slider, Personas & Tabs -->
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-banner-slide');
        const dots = document.querySelectorAll('.hero-dot');
        const track = document.getElementById('heroTrack');
        let autoSlideTimer = null;
        let isPlaying = true;

        function updateSlider() {
            if (!slides.length) return;
            track.style.transform = `translateX(-${currentSlide * 100}%)`;
            dots.forEach((dot, idx) => {
                dot.classList.toggle('active', idx === currentSlide);
            });
        }

        function nextHeroSlide() {
            if (!slides.length) return;
            currentSlide = (currentSlide + 1) % slides.length;
            updateSlider();
        }

        function prevHeroSlide() {
            if (!slides.length) return;
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            updateSlider();
        }

        function goToHeroSlide(index) {
            currentSlide = index;
            updateSlider();
        }

        function toggleHeroPlay() {
            const btn = document.getElementById('heroPauseBtn');
            if (isPlaying) {
                clearInterval(autoSlideTimer);
                btn.textContent = '▶';
                isPlaying = false;
            } else {
                startAutoSlide();
                btn.textContent = '⏸';
                isPlaying = true;
            }
        }

        function startAutoSlide() {
            autoSlideTimer = setInterval(nextHeroSlide, 5000);
        }

        if (slides.length > 1) {
            startAutoSlide();
        }

        function switchOfferingTab(tabName, btn) {
            document.querySelectorAll('.offerings-tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            document.getElementById('tabContentSchemes').classList.add('d-none');
            document.getElementById('tabContentVacancies').classList.add('d-none');
            document.getElementById('tabContentTenders').classList.add('d-none');

            if (tabName === 'schemes') {
                document.getElementById('tabContentSchemes').classList.remove('d-none');
            } else if (tabName === 'vacancies') {
                document.getElementById('tabContentVacancies').classList.remove('d-none');
            } else if (tabName === 'tenders') {
                document.getElementById('tabContentTenders').classList.remove('d-none');
            }
        }

        // Persona Carousel Logic
        let currentPersona = 0;
        const totalPersonas = {{ count($personas) > 0 ? count($personas) : 1 }};

        function showPersona(idx) {
            for (let i = 0; i < totalPersonas; i++) {
                const el = document.getElementById('personaSlide' + i);
                if (el) el.classList.toggle('d-none', i !== idx);
            }
            const pDots = document.querySelectorAll('.persona-dot-indicator');
            pDots.forEach((d, i) => d.classList.toggle('active', i === idx));
            currentPersona = idx;
        }

        function nextPersonaSlide() {
            let next = (currentPersona + 1) % totalPersonas;
            showPersona(next);
        }

        function prevPersonaSlide() {
            let prev = (currentPersona - 1 + totalPersonas) % totalPersonas;
            showPersona(prev);
        }

        function goToPersonaSlide(idx) {
            showPersona(idx);
        }

        // 12 Stats Count-Up Ticker Animation Effect
        function initStatTickers() {
            const tickers = document.querySelectorAll('.stat-ticker');
            if (!tickers.length) return;

            function runTicker(el) {
                if (el.dataset.animated) return;
                el.dataset.animated = "true";

                const rawTarget = el.getAttribute('data-target') || el.innerText.replace(/[^0-9]/g, '');
                const target = parseInt(rawTarget, 10);
                if (isNaN(target) || target <= 0) return;

                const duration = 1800; // 1.8 seconds smooth count
                const startTime = performance.now();

                function tick(now) {
                    const elapsed = now - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    // easeOutCubic curve
                    const ease = 1 - Math.pow(1 - progress, 3);
                    const current = Math.floor(target * ease);
                    el.textContent = current.toLocaleString('en-US');

                    if (progress < 1) {
                        requestAnimationFrame(tick);
                    } else {
                        el.textContent = target.toLocaleString('en-US');
                    }
                }
                requestAnimationFrame(tick);
            }

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            runTicker(entry.target);
                            obs.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.15 });

                tickers.forEach(el => observer.observe(el));
            } else {
                tickers.forEach(el => runTicker(el));
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initStatTickers);
        } else {
            initStatTickers();
        }
    </script>

@endsection
