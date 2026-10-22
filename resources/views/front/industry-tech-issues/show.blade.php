@extends('layouts.front')

@section('title', $issue->title . ' | Industry Tech Issues | Textiles Committee')

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
                <a href="{{ route('industry-tech-issues.index') }}">Industry Tech Issues</a>
                <span class="mx-1">/</span>
                <span>Issue #{{ $issue->id }}</span>
            </div>
            <h1 class="inner-hero-title">
                {{ Str::limit($issue->title, 70) }}
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

<!-- 2. MAIN CONTENT -->
<main class="maincontent inner-page-main">
    <div class="container mt-4">
        <div class="row g-5">
            <!-- LEFT COLUMN: Sticky Visionbox & Meta -->
            <div class="col-md-12 col-lg-4 stickyBox">
                <div class="visionbox">
                    <div>
                        <h2>{{ $issue->title }}</h2>
                        <p>{{ strtoupper($issue->category) }} &bull; {{ strtoupper($issue->status) }}</p>
                    </div>
                </div>

                <!-- Issue Details Metadata Box -->
                <div class="box mt-4 p-4" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 12px;">
                    <h4 style="color: #500a2f; font-size: 1.85rem; font-weight: 700; margin-bottom: 12px; border-bottom: 2px solid #ebd0de; padding-bottom: 8px;">
                        Report Summary
                    </h4>

                    <div style="font-size: 1.55rem; line-height: 1.85; color: #2b2b2b;">
                        <div><strong>Industry:</strong> {{ $issue->industry_name }}</div>
                        <div><strong>Category:</strong> {{ $issue->category }}</div>
                        <div>
                            <strong>Urgency:</strong>
                            @php
                                $urgencyColor = match(strtolower($issue->urgency)) {
                                    'critical' => 'background: #fee2e2; color: #991b1b;',
                                    'high' => 'background: #ffedd5; color: #9a3412;',
                                    'medium' => 'background: #fef9c3; color: #854d0e;',
                                    'low' => 'background: #dcfce7; color: #166534;',
                                    default => 'background: #f3f4f6; color: #374151;',
                                };
                            @endphp
                            <span class="badge" style="{{ $urgencyColor }} font-size: 1.3rem;">{{ $issue->urgency }}</span>
                        </div>
                        <div>
                            <strong>Status:</strong>
                            <span class="badge {{ $issue->status === 'solved' ? 'bg-success' : 'bg-primary' }}" style="font-size: 1.3rem;">
                                {{ strtoupper($issue->status) }}
                            </span>
                        </div>
                        <div><strong>Posted:</strong> {{ $issue->created_at->format('M d, Y h:i A') }}</div>
                    </div>

                    <div class="mt-4 pt-3 border-top" style="border-color: #ebd0de !important;">
                        <a href="{{ route('industry-tech-issues.index') }}" class="btn btn-outline-secondary w-100 py-2 d-flex align-items-center justify-content-center gap-2" style="font-size: 1.55rem; border-color: #ebd0de; color: #500a2f;">
                            <i class="fa fa-arrow-left"></i>
                            <span>Back to All Issues</span>
                        </a>
                    </div>
                </div>

                <!-- Upvote Action Box -->
                <div class="box mt-4 p-4 text-center" style="background: #ffffff; border: 1.5px solid #ebd0de; border-radius: 12px;">
                    <div style="font-size: 1.55rem; color: #555; margin-bottom: 12px;">Facing or interested in this issue?</div>
                    <button type="button" class="btn w-100 fw-bold py-2 vote-btn {{ $hasVoted ? 'btn-primary' : 'btn-outline-primary' }}" data-issue-id="{{ $issue->id }}" style="font-size: 1.6rem; border-radius: 6px;">
                        <i class="fa fa-thumbs-up me-1"></i>
                        <span class="vote-count">{{ $issue->upvotes_count }}</span>
                        <span>{{ Str::plural('Upvote', $issue->upvotes_count) }}</span>
                    </button>
                </div>
            </div>

            <!-- RIGHT COLUMN: Aboutcontent & Details -->
            <div class="col-md-12 col-lg-8">
                <div class="aboutcontent text-justify">
                    <!-- Issue Description -->
                    <h2>Issue Description</h2>
                    <div class="box p-4 mb-4" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 10px;">
                        <p style="font-size: 1.65rem; line-height: 1.85; color: #150202; margin: 0; white-space: pre-line;">
                            {{ $issue->description }}
                        </p>
                    </div>

                    @if($issue->tags)
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @foreach(explode(',', $issue->tags) as $t)
                                @php $t = trim($t); @endphp
                                @if(!empty($t))
                                    <span class="badge py-2 px-3" style="background: #fdf7fa; color: #6c1340; border: 1px solid #ebd0de; font-size: 1.35rem;">#{{ $t }}</span>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <!-- Solution Found Box -->
                    @if(!empty($issue->solution))
                        <h2>Solution Found</h2>
                        <div class="box p-4 p-md-5 mb-5" style="background: #f0fdf4; border: 2px solid #86efac; border-radius: 12px;">
                            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom" style="border-color: #bbf7d0 !important;">
                                <div class="d-flex align-items-center gap-2">
                                    <span style="width: 32px; height: 32px; border-radius: 50%; background: #16a34a; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 16px;">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    <strong style="color: #15803d; font-size: 2.0rem;">Verified Solution</strong>
                                </div>
                                <span class="badge bg-success text-white py-1 px-3" style="font-size: 1.3rem;">
                                    {{ $issue->solution_by ?: 'Textiles Committee Technical Expert' }}
                                </span>
                            </div>

                            <div style="font-size: 1.65rem; line-height: 1.85; color: #150202; white-space: pre-line;">
                                {!! nl2br(e($issue->solution)) !!}
                            </div>

                            @if($issue->solution_provided_at)
                                <div class="text-end text-muted mt-3 pt-2 border-top" style="border-color: #bbf7d0 !important; font-size: 1.35rem;">
                                    Certified technical resolution provided on {{ $issue->solution_provided_at->format('M d, Y') }}
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Discussion Section -->
                    <h2 id="discussion">Discussion &amp; Industry Responses ({{ $replies->count() }})</h2>

                    <div class="d-flex flex-column gap-3 mb-5">
                        @forelse($replies as $reply)
                            <div class="box p-4" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 10px;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div>
                                        <strong style="color: #500a2f; font-size: 1.7rem;">{{ $reply->name }}</strong>
                                        @if($reply->industry)
                                            <span class="text-muted" style="font-size: 1.45rem;"> &bull; {{ $reply->industry }}</span>
                                        @endif
                                    </div>
                                    <span class="text-muted" style="font-size: 1.35rem;">{{ $reply->created_at->diffForHumans() }}</span>
                                </div>

                                <p style="font-size: 1.65rem; line-height: 1.85; color: #150202; margin-bottom: 12px; white-space: pre-line;">
                                    {{ $reply->message }}
                                </p>

                                @if($reply->email || $reply->industry)
                                    <div class="pt-2 border-top text-muted" style="border-color: #ebd0de !important; font-size: 1.35rem;">
                                        @if($reply->industry)
                                            <span>Industry: <strong class="text-dark">{{ $reply->industry }}</strong></span>
                                        @endif
                                        @if($reply->email)
                                            <span class="ms-3">Email: <strong class="text-dark">{{ $reply->email }}</strong></span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="box p-4 text-center text-muted" style="background: #ffffff; border: 1px solid #ebd0de; border-radius: 10px;">
                                <p style="font-size: 1.6rem; margin: 0;">No peer responses yet. Share your experience or advice below!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Submit Response Form -->
                    <h2>Submit Your Response</h2>
                    <div class="box p-4 p-md-5 mb-5" style="background: #ffffff; border: 1.5px solid #ebd0de; border-radius: 12px;">
                        <form action="{{ route('industry-tech-issues.reply', $issue->id) }}" method="POST">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Your Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required placeholder="Enter your name" style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Your Industry / Organization</label>
                                    <input type="text" name="industry" class="form-control" placeholder="Your industry / organization" style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Your Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required placeholder="Your email address" style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Your Mobile</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="Your mobile number" style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;">
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold" style="color: #500a2f; font-size: 1.55rem;">Your Response / Suggestion <span class="text-danger">*</span></label>
                                    <textarea name="message" class="form-control" rows="5" required placeholder="Share insights, technical suggestions, or ask follow-up questions..." style="border: 1px solid #ebd0de; padding: 12px 16px; font-size: 1.55rem; border-radius: 6px;"></textarea>
                                </div>

                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn text-white fw-bold px-4 py-2" style="background: #6c1340; border-radius: 6px; font-size: 1.65rem;">
                                        Submit Response
                                    </button>
                                    <div class="small text-muted mt-2" style="font-size: 1.35rem;">
                                        Your name and email will be displayed with your response.
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const voteBtn = document.querySelector('.vote-btn');
    if (voteBtn) {
        voteBtn.addEventListener('click', function(e) {
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
    }
});
</script>
@endsection
