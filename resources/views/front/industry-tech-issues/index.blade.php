@extends('layouts.front')

@section('title', 'Industry Tech Issues & Troubleshooting | Textiles Committee')

@section('content')
<!-- 1. OFFICIAL MAROON CURVED HERO BANNER (Matching Site Theme) -->
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
            <path d="M 450,0 C 700,60 920,180 1250,110 C 1420,70 1520,130 1600,160 L 1600,240 L 450,240 Z" fill="url(#waveFill)"/>
            <path d="M 520,0 C 760,70 980,190 1300,120 C 1450,85 1540,140 1600,170" stroke="url(#glowWave)" stroke-width="4" fill="none"/>
            <path d="M 380,240 C 580,210 760,160 980,130 C 1200,100 1420,110 1600,150" stroke="rgba(255, 80, 150, 0.45)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            <path d="M 400,240 C 610,200 800,145 1020,115 C 1240,85 1450,95 1600,135" stroke="rgba(255, 100, 170, 0.4)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            <path d="M 430,240 C 640,190 840,130 1060,100 C 1280,70 1480,80 1600,120" stroke="rgba(255, 120, 180, 0.35)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            <path d="M 470,240 C 670,180 880,115 1100,85 C 1310,55 1510,65 1600,105" stroke="rgba(255, 140, 190, 0.3)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            <path d="M 510,240 C 710,170 920,100 1140,70 C 1340,40 1530,50 1600,90" stroke="rgba(255, 160, 200, 0.25)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            <path d="M 560,240 C 750,160 960,85 1180,55 C 1380,28 1560,38 1600,75" stroke="rgba(255, 180, 210, 0.2)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            <path d="M 620,240 C 800,150 1010,72 1230,42 C 1420,16 1580,26 1600,60" stroke="rgba(255, 200, 220, 0.16)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
            <path d="M 690,240 C 860,140 1070,60 1280,30 C 1460,5 1590,14 1600,45" stroke="rgba(255, 220, 230, 0.12)" stroke-width="2.5" stroke-dasharray="2 12" fill="none"/>
        </svg>
    </div>

    <div class="page-container inner-hero-container">
        <div class="inner-hero-content">
            <div class="inner-breadcrumb-text">
                <a href="{{ route('home') }}">Home</a>
                <span class="mx-1">/</span>
                <a href="{{ route('page.show', 'contact-us') }}">Connect</a>
                <span class="mx-1">/</span>
                <span>Industry Tech Issues</span>
            </div>
            <h1 class="inner-hero-title">
                Industry Tech Issues
            </h1>
        </div>

        <!-- In-banner Sub-Nav Pill Bar -->
        <div class="inner-pill-bar-wrap">
            <nav class="inner-pill-bar" aria-label="Sub Navigation">
                <a href="{{ route('page.show', 'contact-us') }}" class="inner-pill-link">
                    <span>Contact Us</span>
                </a>
                <a href="{{ route('industry-tech-issues.index') }}" class="inner-pill-link active" aria-current="page">
                    <span class="material-symbols-outlined inner-pill-icon" aria-hidden="true">drag_indicator</span>
                    <span>Industry Tech Issues</span>
                </a>
                <a href="{{ route('page.show', 'grievance') }}" class="inner-pill-link">
                    <span>Grievance</span>
                </a>
                <a href="{{ route('page.show', 'contact-us') }}#footerContact" class="inner-pill-link">
                    <span>Contact Directory</span>
                </a>
                <a href="{{ route('page.show', 'contact-us') }}#feedbackModal" class="inner-pill-link">
                    <span>Citizen Feedback &amp; Query</span>
                </a>
            </nav>
        </div>
    </div>
</section>

<!-- 2. MAIN CONTENT (Exact Theme System) -->
<main class="maincontent inner-page-main">
    <div class="container mt-4">
        <div class="row g-5">
            <!-- LEFT COLUMN: Sticky Visionbox & Categories Sidebar -->
            <div class="col-md-12 col-lg-4 stickyBox">
                <div class="visionbox">
                    <div>
                        <h2>Crowdsourced technical troubleshooting exchange connecting textile mills, processing houses, and laboratory experts of Textiles Committee.</h2>
                        <p>TECHNICAL RESOLUTION &bull; SOLUTIONS</p>
                    </div>
                </div>

                <!-- Report Issue Button Card -->
                <div class="box mt-4 p-4 text-center" style="background: #ffffff; border: 1.5px solid #ebd0de; border-radius: 12px;">
                    <h4 style="color: #500a2f; font-size: 1.85rem; font-weight: 700; margin-bottom: 8px;">
                        Facing a Production Issue?
                    </h4>
                    <p class="text-muted" style="font-size: 1.45rem; line-height: 1.6; margin-bottom: 16px;">
                        Report fabric defects, dyeing inconsistencies, or weaving challenges to get verified technical solutions.
                    </p>
                    <button type="button" class="btn w-100 text-white fw-bold py-3 shadow-sm d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#reportIssueModal" style="background: #6c1340; border-radius: 8px; font-size: 1.6rem;">
                        <i class="fa fa-plus-circle"></i>
                        <span>Report Technical Issue</span>
                    </button>
                </div>

                <!-- Navigation & Status Filters Box -->
                <div class="box mt-4 p-4" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 12px;">
                    <h4 style="color: #500a2f; font-size: 1.85rem; font-weight: 700; margin-bottom: 14px; border-bottom: 2px solid #ebd0de; padding-bottom: 8px;">
                        Navigation
                    </h4>
                    <div class="d-flex flex-column gap-2" style="font-size: 1.55rem;">
                        <a href="{{ route('industry-tech-issues.index') }}" class="d-flex align-items-center justify-content-between p-2 rounded text-decoration-none {{ !request('category') && !request('status') ? 'fw-bold' : '' }}" style="{{ !request('category') && !request('status') ? 'background: #6c1340; color: #ffffff !important;' : 'color: #500a2f;' }}">
                            <span>Quality Issues</span>
                            <span class="badge {{ !request('category') && !request('status') ? 'bg-white text-dark' : 'bg-light text-dark' }}">{{ $totalIssuesCount }}</span>
                        </a>

                        <a href="{{ route('industry-tech-issues.index', ['status' => 'solved']) }}" class="d-flex align-items-center justify-content-between p-2 rounded text-decoration-none {{ request('status') === 'solved' ? 'fw-bold' : '' }}" style="{{ request('status') === 'solved' ? 'background: #6c1340; color: #ffffff !important;' : 'color: #500a2f;' }}">
                            <span>Knowledge Base (Solved)</span>
                            <span class="badge {{ request('status') === 'solved' ? 'bg-white text-dark' : 'bg-light text-dark' }}">{{ $solvedCount }}</span>
                        </a>

                        <a href="{{ route('industry-tech-issues.index', ['status' => 'open']) }}" class="d-flex align-items-center justify-content-between p-2 rounded text-decoration-none {{ request('status') === 'open' ? 'fw-bold' : '' }}" style="{{ request('status') === 'open' ? 'background: #6c1340; color: #ffffff !important;' : 'color: #500a2f;' }}">
                            <span>Open Issues</span>
                            <span class="badge {{ request('status') === 'open' ? 'bg-white text-dark' : 'bg-light text-dark' }}">{{ $openCount }}</span>
                        </a>
                    </div>
                </div>

                <!-- Categories Box -->
                <div class="box mt-4 p-4" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 12px;">
                    <h4 style="color: #500a2f; font-size: 1.85rem; font-weight: 700; margin-bottom: 14px; border-bottom: 2px solid #ebd0de; padding-bottom: 8px;">
                        Categories
                    </h4>
                    <div class="d-flex flex-column gap-1" style="font-size: 1.55rem;">
                        <a href="{{ route('industry-tech-issues.index', request()->except('category')) }}" class="d-flex align-items-center justify-content-between p-2 rounded text-decoration-none {{ !request('category') ? 'fw-bold' : '' }}" style="{{ !request('category') ? 'background: #6c1340; color: #ffffff !important;' : 'color: #2b2b2b;' }}">
                            <span>All Categories</span>
                            <span class="badge {{ !request('category') ? 'bg-white text-dark' : 'bg-light text-dark' }}">{{ $totalIssuesCount }}</span>
                        </a>

                        @foreach($categories as $catName => $catCount)
                            @php $isActive = request('category') === $catName; @endphp
                            <a href="{{ route('industry-tech-issues.index', array_merge(request()->except('category'), ['category' => $catName])) }}" class="d-flex align-items-center justify-content-between p-2 rounded text-decoration-none {{ $isActive ? 'fw-bold' : '' }}" style="{{ $isActive ? 'background: #6c1340; color: #ffffff !important;' : 'color: #2b2b2b;' }}">
                                <span>{{ $catName }}</span>
                                <span class="badge {{ $isActive ? 'bg-white text-dark' : 'bg-light text-dark' }}">{{ $catCount }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Popular Tags Box -->
                <div class="box mt-4 p-4" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 12px;">
                    <h4 style="color: #500a2f; font-size: 1.85rem; font-weight: 700; margin-bottom: 14px; border-bottom: 2px solid #ebd0de; padding-bottom: 8px;">
                        Popular Tags
                    </h4>
                    <div class="d-flex flex-wrap gap-2">
                        @php
                            $popularTags = ['Shrinkage', 'GARMENT REWORK', 'Yarn Dyeing', 'Denim', 'Zari', 'Floats', 'Bowing', 'Rapier', 'Fastness', 'Spinning'];
                        @endphp
                        @foreach($popularTags as $t)
                            <a href="{{ route('industry-tech-issues.index', ['tag' => $t]) }}" class="badge text-decoration-none py-2 px-3 {{ request('tag') === $t ? 'text-white' : 'text-dark border' }}" style="{{ request('tag') === $t ? 'background: #6c1340;' : 'background: #fdf7fa; border-color: #ebd0de !important;' }} font-size: 1.35rem; font-weight: 500;">
                                #{{ $t }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Aboutcontent & Issues List -->
            <div class="col-md-12 col-lg-8">
                <div class="aboutcontent text-justify">
                    <!-- Top Search Bar Box -->
                    <div class="box p-3 mb-4" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 10px;">
                        <form action="{{ route('industry-tech-issues.index') }}" method="GET" class="d-flex gap-2">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-color: #ebd0de; font-size: 1.6rem; color: #6c1340;">
                                    <i class="fa fa-magnifying-glass"></i>
                                </span>
                                <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0" placeholder="Search issues, solutions, or parameters..." style="border-color: #ebd0de; font-size: 1.55rem; padding: 12px 14px;">
                                @if(request('q'))
                                    <a href="{{ route('industry-tech-issues.index', request()->except('q')) }}" class="btn btn-outline-secondary d-flex align-items-center" style="border-color: #ebd0de; font-size: 1.5rem;">
                                        <i class="fa fa-times"></i>
                                    </a>
                                @endif
                                <button class="btn text-white fw-bold px-4" type="submit" style="background: #6c1340; font-size: 1.55rem;">Search</button>
                            </div>
                        </form>
                    </div>

                    <!-- Header Row -->
                    <div class="d-flex align-items-baseline justify-content-between mb-4 pb-2 border-bottom" style="border-color: #ebd0de !important;">
                        <h2 style="margin: 0; font-size: 2.5rem; color: #500a2f; font-weight: 700;">
                            @if(request('category'))
                                {{ request('category') }}
                            @elseif(request('status') === 'solved')
                                Knowledge Base (Solved Issues)
                            @elseif(request('status') === 'open')
                                Open Technical Issues
                            @elseif(request('tag'))
                                Tagged #{{ request('tag') }}
                            @else
                                Quality Issues
                            @endif
                        </h2>
                        <span style="font-size: 1.55rem; color: #500a2f; font-weight: 600;">{{ $issues->total() }} issues found</span>
                    </div>

                    <!-- Issues List -->
                    @forelse($issues as $issue)
                        @php
                            $isSolved = $issue->status === 'solved';
                            $urgencyColor = match(strtolower($issue->urgency)) {
                                'critical' => 'background: #fee2e2; color: #991b1b; border: 1px solid #fecaca;',
                                'high' => 'background: #ffedd5; color: #9a3412; border: 1px solid #fed7aa;',
                                'medium' => 'background: #fef9c3; color: #854d0e; border: 1px solid #fef08a;',
                                'low' => 'background: #dcfce7; color: #166534; border: 1px solid #bbf7d0;',
                                default => 'background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb;',
                            };
                        @endphp
                        <div class="box p-4 mb-4" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 12px; transition: all 0.2s ease;">
                            <!-- Header: Title & Solved Badge -->
                            <div class="d-flex align-items-start justify-content-between gap-3 mb-2">
                                <h3 style="margin: 0; font-size: 2.1rem; line-height: 1.35; font-weight: 700;">
                                    <a href="{{ route('industry-tech-issues.show', $issue->slug) }}" class="text-decoration-none" style="color: #500a2f;">
                                        {{ $issue->title }}
                                    </a>
                                </h3>
                                <span class="badge flex-shrink-0" style="{{ $isSolved ? 'background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;' : 'background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;' }} font-size: 1.25rem; font-weight: 700; padding: 6px 12px; border-radius: 6px;">
                                    {{ strtoupper($issue->status) }}
                                </span>
                            </div>

                            <!-- Meta Line: Industry, Contact, Urgency -->
                            <div class="mb-3" style="font-size: 1.5rem; color: #555; line-height: 1.7;">
                                <span>Industry: <strong class="text-dark">{{ $issue->industry_name }}</strong></span>
                                <span class="mx-2">&bull;</span>
                                <span>Contact: <strong class="text-dark">{{ $issue->contact_person }}</strong></span>
                                <span class="mx-2">&bull;</span>
                                <span>Urgency: <span class="badge py-1 px-2" style="{{ $urgencyColor }} font-size: 1.25rem; font-weight: 600;">{{ $issue->urgency }}</span></span>
                                @if($issue->category)
                                    <span class="mx-2">&bull;</span>
                                    <span class="badge bg-light text-dark border py-1 px-2" style="font-size: 1.25rem;">{{ $issue->category }}</span>
                                @endif
                            </div>

                            <!-- Excerpt -->
                            <p style="font-size: 1.65rem; line-height: 1.8; color: #150202; margin-bottom: 16px;">
                                {{ Str::limit($issue->description, 230) }}
                            </p>

                            <!-- Tags -->
                            @if($issue->tags)
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    @foreach(explode(',', $issue->tags) as $tag)
                                        @php $tag = trim($tag); @endphp
                                        @if(!empty($tag))
                                            <a href="{{ route('industry-tech-issues.index', ['tag' => $tag]) }}" class="badge text-decoration-none py-1 px-2" style="background: #fdf7fa; color: #6c1340; border: 1px solid #ebd0de; font-size: 1.3rem;">
                                                #{{ $tag }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <!-- Footer Row: Date, Upvotes, Replies -->
                            <div class="d-flex align-items-center justify-content-between pt-3 border-top" style="border-color: #ebd0de !important; font-size: 1.45rem; color: #666;">
                                <div class="d-flex align-items-center gap-2">
                                    <span style="width: 28px; height: 28px; border-radius: 50%; background: #6c1340; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; font-weight: bold;">
                                        {{ strtoupper(substr($issue->contact_person ?: $issue->industry_name, 0, 1)) }}
                                    </span>
                                    <span>{{ $issue->created_at->format('M d, Y') }}</span>
                                </div>

                                <div class="d-flex align-items-center gap-4">
                                    <!-- Upvote Button -->
                                    <button type="button" class="btn btn-sm btn-light border-0 py-1 px-2 d-flex align-items-center gap-1 vote-btn" data-issue-id="{{ $issue->id }}" style="font-size: 1.45rem; background: transparent;" title="Upvote this issue">
                                        <i class="fa fa-thumbs-up text-warning"></i>
                                        <span class="vote-count fw-bold text-dark">{{ $issue->upvotes_count }}</span>
                                    </button>

                                    <!-- Replies Count Link -->
                                    <a href="{{ route('industry-tech-issues.show', $issue->slug) }}#discussion" class="text-decoration-none d-flex align-items-center gap-1" style="color: #6c1340; font-weight: 600;" title="View discussion replies">
                                        <i class="fa fa-comment-dots text-primary"></i>
                                        <span>{{ $issue->replies_count }}</span>
                                        <span>{{ Str::plural('Reply', $issue->replies_count) }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="box p-5 text-center text-muted" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 12px;">
                            <i class="fa fa-folder-open fs-1 mb-3 text-secondary"></i>
                            <h4 class="fw-bold" style="color: #500a2f; font-size: 2.2rem;">No technical issues found</h4>
                            <p style="font-size: 1.6rem;">Be the first to report this issue or try adjusting your search filters.</p>
                            <button type="button" class="btn text-white fw-bold px-4 py-2 mt-2" data-bs-toggle="modal" data-bs-target="#reportIssueModal" style="background: #6c1340; font-size: 1.6rem; border-radius: 6px;">
                                Report Technical Issue
                            </button>
                        </div>
                    @endforelse

                    <!-- Pagination Links -->
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $issues->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- REPORT ISSUE MODAL -->
<div class="modal fade" id="reportIssueModal" tabindex="-1" aria-labelledby="reportIssueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
            <div class="modal-header py-3 px-4 text-white" style="background: linear-gradient(135deg, #6c1340 0%, #500a2f 100%);">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa fa-flag fs-5 text-warning"></i>
                    <h4 class="modal-title fw-bold text-white m-0" id="reportIssueModalLabel" style="font-size: 2.0rem;">Report Industry Technical Issue</h4>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('industry-tech-issues.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 p-md-5" style="max-height: 75vh; overflow-y: auto;">
                    <div class="box p-3 mb-4" style="background: #fdf7fa; border: 1px solid #ebd0de; font-size: 1.5rem; color: #500a2f;">
                        <i class="fa fa-info-circle text-danger me-2"></i>
                        Your reported issue will be published on the portal for peer discussion, and will be reviewed by <strong>Textiles Committee Technical Officers &amp; Quality Laboratories</strong> to provide certified solutions.
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Issue Title / Summary <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g. Shrinkage issue post garmenting in cotton shirting fabric" style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Industry / Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="industry_name" class="form-control" required placeholder="e.g. Saara Designers Pvt Ltd" style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" name="contact_person" class="form-control" required placeholder="e.g. Sanjay Jain" style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="name@company.com" style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Mobile / Phone Number</label>
                            <input type="tel" name="phone" class="form-control" placeholder="+91 9876543210" style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Issue Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select" required style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                                <option value="" disabled selected>-- Select Category --</option>
                                <option value="Fabric Defects">Fabric Defects</option>
                                <option value="Dyeing Issues">Dyeing Issues</option>
                                <option value="Weaving Defects">Weaving Defects</option>
                                <option value="Finishing Problems">Finishing Problems</option>
                                <option value="Testing & Quality">Testing & Quality</option>
                                <option value="Spinning">Spinning</option>
                                <option value="Garmenting">Garmenting</option>
                                <option value="Other">Other Technical Issue</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Urgency Level <span class="text-danger">*</span></label>
                            <select name="urgency" class="form-select" required style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                                <option value="Low">Low (General guidance / advisory)</option>
                                <option value="Medium" selected>Medium (Affecting sample lot)</option>
                                <option value="High">High (Bulk production stalled)</option>
                                <option value="Critical">Critical (Export lot rejected / deadline)</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Tags (comma-separated)</label>
                            <input type="text" name="tags" class="form-control" placeholder="e.g. Shrinkage, Cotton, Finishing, Garment" style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Detailed Technical Description <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="5" required placeholder="Provide exact parameters: fiber composition, fabric structure, GSM, machine make, chemicals/dyes used, and specific symptoms..." style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer py-3 px-4 bg-light">
                    <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="font-size: 1.55rem;">Cancel</button>
                    <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background: #6c1340; font-size: 1.55rem;">
                        Submit Technical Issue
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.vote-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const issueId = this.getAttribute('data-issue-id');
            const countSpan = this.querySelector('.vote-count');
            const token = '{{ csrf_token() }}';

            fetch('{{ url('/industry-tech-issues') }}/' + issueId + '/vote', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    countSpan.textContent = data.upvotes_count;
                }
            })
            .catch(err => console.error(err));
        });
    });
});
</script>
@endsection
