@extends('layouts.front')

@php
    $isHindi = session('locale') == 'hi';
    $isVacancy = $tender->type === 'vacancy';
    $typeLabel = $isVacancy ? ($isHindi ? 'रिक्ति / भर्ती' : 'Vacancy') : ($isHindi ? 'निविदा / प्रस्ताव' : 'Tender');
    $listRoute = $isVacancy ? route('vacancies.index') : route('tenders.index');
    $listLabel = $isVacancy ? ($isHindi ? 'रिक्तियां' : 'Vacancies') : ($isHindi ? 'निविदाएं' : 'Tenders');
    
    $title = $isHindi ? ($tender->title_hi ?: $tender->title_en) : ($tender->title_en ?: $tender->title_hi);
    $desc = $isHindi ? ($tender->description_hi ?: $tender->description_en) : ($tender->description_en ?: $tender->description_hi);
    
    $ref = $tender->reference_no ?: ($isVacancy ? 'TC/VAC/' . $tender->id : 'TC/TND/' . $tender->id);
    $pubDateFormatted = $tender->published_date ? \Carbon\Carbon::parse($tender->published_date)->format('d F Y') : '-';
    $dueDateFormatted = $tender->closing_date ? \Carbon\Carbon::parse($tender->closing_date)->format('d F Y') : ($isHindi ? 'खुली / जब तक भरी न जाए' : 'Open until filled');
    
    $isClosed = $tender->closing_date && \Carbon\Carbon::parse($tender->closing_date)->isPast();
    $hasDoc = !empty($tender->document_url);
    $docUrl = $hasDoc ? route($isVacancy ? 'vacancies.document' : 'tenders.document', $tender->id) : null;
    $downloadUrl = $hasDoc ? ($docUrl . '?download=1') : null;
@endphp

@section('title', $title . ' | ' . ($isHindi ? 'वस्त्र समिति' : 'Textiles Committee'))

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
                <a href="{{ route('home') }}">{{ $isHindi ? 'मुख्य पृष्ठ' : 'Home' }}</a>
                <span class="mx-1">/</span>
                <span>{{ $isHindi ? 'सेवाएं एवं योजनाएं' : 'Offerings' }}</span>
                <span class="mx-1">/</span>
                <a href="{{ $listRoute }}">{{ $listLabel }}</a>
                <span class="mx-1">/</span>
                <span>{{ $isHindi ? 'विवरण' : 'Details' }}</span>
            </div>
            <h1 class="inner-hero-title">
                {{ $title }}
            </h1>
        </div>
    </div>
</section>

<!-- Detail Content Section -->
<main class="maincontent inner-page-main py-4 py-md-5">
    <div class="page-container">
        <div class="row g-4">
            <!-- Left Main Column -->
            <div class="col-lg-8">
                <div class="tender-detail-card mb-4">
                    <!-- Status & Meta Header -->
                    <div class="tender-detail-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="badge-type-pill">{{ $typeLabel }}</span>
                            <span class="badge-ref-pill">Ref: {{ $ref }}</span>
                        </div>
                        <div>
                            @if($isClosed)
                                <span class="badge-status-closed">
                                    <span class="status-dot-closed"></span>
                                    {{ $isHindi ? 'बंद / समय समाप्त' : 'Closed' }}
                                </span>
                            @else
                                <span class="badge-status-active">
                                    <span class="status-dot-active"></span>
                                    {{ $isHindi ? 'सक्रिय / आवेदन खुला है' : 'Active / Open' }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Meta Strip -->
                    <div class="tender-meta-grid my-4">
                        <div class="meta-box">
                            <span class="material-symbols-outlined meta-box-icon">calendar_today</span>
                            <div>
                                <div class="meta-box-label">{{ $isHindi ? 'प्रकाशन तिथि' : 'Published Date' }}</div>
                                <div class="meta-box-value">{{ $pubDateFormatted }}</div>
                            </div>
                        </div>

                        <div class="meta-box">
                            <span class="material-symbols-outlined meta-box-icon">event_busy</span>
                            <div>
                                <div class="meta-box-label">{{ $isHindi ? 'अंतिम तिथि' : 'Closing / Due Date' }}</div>
                                <div class="meta-box-value {{ $isClosed ? 'text-danger' : 'text-success' }}">{{ $dueDateFormatted }}</div>
                            </div>
                        </div>

                        <div class="meta-box">
                            <span class="material-symbols-outlined meta-box-icon">apartment</span>
                            <div>
                                <div class="meta-box-label">{{ $isHindi ? 'संगठन / प्रभाग' : 'Department' }}</div>
                                <div class="meta-box-value">Textiles Committee, Mumbai</div>
                            </div>
                        </div>
                    </div>

                    <!-- Full Description -->
                    <div class="tender-desc-section">
                        <h2 class="section-subheading">
                            <span class="material-symbols-outlined icon-subheading">description</span>
                            {{ $isHindi ? 'विवरण एवं कार्य क्षेत्र' : 'Description & Scope of Work' }}
                        </h2>
                        <div class="tender-desc-content">
                            @if(!empty($desc))
                                @if(strip_tags($desc) !== $desc)
                                    {!! $desc !!}
                                @else
                                    {!! nl2br(e($desc)) !!}
                                @endif
                            @else
                                <p class="text-muted italic">
                                    {{ $isHindi ? 'इस सूचना के लिए कोई विस्तृत विवरण उपलब्ध नहीं है। कृपया संलग्न आधिकारिक दस्तावेज देखें।' : 'No additional text description provided. Please refer to the official notification document attached below.' }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Document Download / Viewer Box -->
                    @if($hasDoc)
                        <div class="tender-doc-box mt-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="pdf-file-icon-wrap">
                                        <span class="material-symbols-outlined pdf-file-icon">picture_as_pdf</span>
                                    </div>
                                    <div>
                                        <h3 class="h5 fw-bold mb-1 text-dark">
                                            {{ $isHindi ? 'आधिकारिक दस्तावेज / निविदा पत्र' : 'Official Notification Document' }}
                                        </h3>
                                        <p class="text-muted mb-0 small">PDF Document &bull; {{ $isHindi ? 'वस्त्र समिति द्वारा अधिकृत' : 'Authorized by Textiles Committee' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ $docUrl }}" target="_blank" class="btn btn-outline-custom-maroon btn-sm">
                                        <span class="material-symbols-outlined fs-6 align-middle me-1">open_in_new</span>
                                        {{ $isHindi ? 'नया टैब में खोलें' : 'Open in New Tab' }}
                                    </a>
                                    <a href="{{ $downloadUrl }}" class="btn btn-custom-maroon btn-sm">
                                        <span class="material-symbols-outlined fs-6 align-middle me-1">download</span>
                                        {{ $isHindi ? 'डाउनलोड करें' : 'Download Document' }}
                                    </a>
                                </div>
                            </div>

                            <!-- Embedded Document Viewer with direct server streaming -->
                            <div class="pdf-viewer-frame-wrap">
                                <iframe src="{{ $docUrl }}#toolbar=1" class="pdf-iframe" title="{{ $title }}"></iframe>
                            </div>
                        </div>
                    @endif

                    <!-- Back Button -->
                    <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <a href="{{ $listRoute }}" class="btn btn-outline-secondary">
                            &larr; {{ $isHindi ? 'सभी ' . $listLabel . ' पर वापस जाएं' : 'Back to All ' . $listLabel }}
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-link text-decoration-none" style="color: #6c1340;">
                            {{ $isHindi ? 'मुख्य पृष्ठ' : 'Home' }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar Column -->
            <div class="col-lg-4">
                <!-- Important Notes Box -->
                <div class="sidebar-help-card mb-4">
                    <h3 class="sidebar-help-title">
                        <span class="material-symbols-outlined">help_outline</span>
                        {{ $isHindi ? 'महत्वपूर्ण दिशानिर्देश' : 'Important Instructions' }}
                    </h3>
                    <ul class="sidebar-help-list">
                        <li>{{ $isHindi ? 'सभी बोलियां और आवेदन निर्धारित तिथि और समय से पहले जमा किए जाने चाहिए।' : 'All bids and applications must be submitted strictly prior to the closing date and time.' }}</li>
                        <li>{{ $isHindi ? 'समय सीमा के बाद प्राप्त किसी भी प्रस्ताव पर विचार नहीं किया जाएगा।' : 'Late submissions will not be entertained under any circumstances.' }}</li>
                        <li>{{ $isHindi ? 'किसी भी शुद्धिपत्र (Corrigendum) या संशोधन के लिए नियमित रूप से इस पृष्ठ की जांच करें।' : 'Bidders and applicants are advised to visit the website regularly for any corrigendum or updates.' }}</li>
                    </ul>
                </div>

                <!-- Contact & Queries Box -->
                <div class="sidebar-contact-card">
                    <h3 class="sidebar-contact-title">
                        <span class="material-symbols-outlined">contact_phone</span>
                        {{ $isHindi ? 'संपर्क एवं सहायता' : 'Contact & Inquiries' }}
                    </h3>
                    <p class="sidebar-contact-text">
                        {{ $isHindi ? 'इस सूचना से संबंधित किसी भी स्पष्टीकरण के लिए कृपया संपर्क करें:' : 'For clarifications regarding this notice, please contact:' }}
                    </p>
                    <div class="sidebar-contact-info">
                        <div><strong>Textiles Committee</strong></div>
                        <div>P. Balu Road, Prabhadevi Chowk,</div>
                        <div>Mumbai - 400 025, Maharashtra, India</div>
                        <div class="mt-2">
                            <span class="material-symbols-outlined align-middle fs-6 text-muted">mail</span>
                            <a href="mailto:secy.tc@nic.in" class="text-decoration-none" style="color: #6c1340;">secy.tc@nic.in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.tender-detail-card {
    background: #ffffff;
    border: 1px solid #ebd0de;
    border-radius: 12px;
    padding: 32px 36px;
    box-shadow: 0 4px 16px rgba(108, 19, 64, 0.05);
}
@media (max-width: 768px) {
    .tender-detail-card {
        padding: 20px 18px;
    }
}
.badge-type-pill {
    background: #f7d2df;
    color: #6c1340;
    font-weight: 700;
    font-size: 1.3rem;
    padding: 6px 14px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.badge-ref-pill {
    background: #f0f2f5;
    color: #444455;
    font-weight: 600;
    font-size: 1.3rem;
    padding: 6px 14px;
    border-radius: 20px;
}
.badge-status-active {
    background: #e6f7ec;
    color: #198754;
    font-weight: 700;
    font-size: 1.35rem;
    padding: 6px 14px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.status-dot-active {
    width: 8px;
    height: 8px;
    background: #198754;
    border-radius: 50%;
    display: inline-block;
}
.badge-status-closed {
    background: #fde8e8;
    color: #dc3545;
    font-weight: 700;
    font-size: 1.35rem;
    padding: 6px 14px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.status-dot-closed {
    width: 8px;
    height: 8px;
    background: #dc3545;
    border-radius: 50%;
    display: inline-block;
}
.tender-meta-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    padding: 20px;
    background: #faf5f8;
    border-radius: 10px;
    border: 1px solid #ebd0de;
}
@media (max-width: 768px) {
    .tender-meta-grid {
        grid-template-columns: 1fr;
    }
}
.meta-box {
    display: flex;
    align-items: center;
    gap: 12px;
}
.meta-box-icon {
    font-size: 2.6rem;
    color: #6c1340;
}
.meta-box-label {
    font-size: 1.25rem;
    color: #777788;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.3px;
}
.meta-box-value {
    font-size: 1.55rem;
    font-weight: 700;
    color: #222233;
}
.section-subheading {
    font-size: 2rem;
    font-weight: 700;
    color: #6c1340;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.icon-subheading {
    font-size: 2.4rem;
    color: #6c1340;
}
.tender-desc-content {
    font-size: 1.55rem;
    line-height: 1.8;
    color: #333344;
    background: #ffffff;
    padding: 24px 28px;
    border-radius: 8px;
    border: 1px solid #f0e6ec;
}
.tender-desc-content p {
    margin-bottom: 14px;
}
.tender-desc-content p:last-child {
    margin-bottom: 0;
}
.tender-desc-content a {
    color: #6c1340;
    font-weight: 600;
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: color 0.2s ease;
}
.tender-desc-content a:hover {
    color: #9e1857;
}
.tender-desc-content strong,
.tender-desc-content b {
    font-weight: 700;
    color: #1a1a2e;
}
.tender-desc-content ul,
.tender-desc-content ol {
    padding-left: 24px;
    margin-bottom: 14px;
}
.tender-desc-content li {
    margin-bottom: 6px;
}
.tender-desc-content h1,
.tender-desc-content h2,
.tender-desc-content h3,
.tender-desc-content h4 {
    color: #1a1a2e;
    font-weight: 700;
    margin-top: 18px;
    margin-bottom: 10px;
}
.tender-doc-box {
    background: #faf5f8;
    border: 1.5px solid #dca7bc;
    border-radius: 10px;
    padding: 20px 24px;
}
.pdf-file-icon-wrap {
    width: 48px;
    height: 48px;
    background: #6c1340;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
}
.pdf-file-icon {
    font-size: 2.8rem;
}
.pdf-viewer-frame-wrap {
    width: 100%;
    height: 600px;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #dca7bc;
    margin-top: 16px;
    background: #eef2f5;
}
.pdf-iframe {
    width: 100%;
    height: 100%;
    border: none;
}
.btn-custom-maroon {
    background: #6c1340;
    color: #ffffff;
    border: 1px solid #6c1340;
    font-weight: 600;
    padding: 8px 18px;
    font-size: 1.35rem;
}
.btn-custom-maroon:hover {
    background: #500a2f;
    color: #ffffff;
}
.btn-outline-custom-maroon {
    background: transparent;
    color: #6c1340;
    border: 1.5px solid #6c1340;
    font-weight: 600;
    padding: 8px 18px;
    font-size: 1.35rem;
}
.btn-outline-custom-maroon:hover {
    background: #6c1340;
    color: #ffffff;
}
.sidebar-help-card {
    background: #fffdf7;
    border: 1px solid #fae1a0;
    border-radius: 10px;
    padding: 22px 24px;
}
.sidebar-help-title {
    font-size: 1.7rem;
    font-weight: 700;
    color: #946200;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.sidebar-help-list {
    margin: 0;
    padding-left: 20px;
    font-size: 1.35rem;
    line-height: 1.6;
    color: #555544;
}
.sidebar-help-list li {
    margin-bottom: 10px;
}
.sidebar-contact-card {
    background: #ffffff;
    border: 1px solid #ebd0de;
    border-radius: 10px;
    padding: 22px 24px;
}
.sidebar-contact-title {
    font-size: 1.7rem;
    font-weight: 700;
    color: #6c1340;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.sidebar-contact-text {
    font-size: 1.35rem;
    color: #666677;
    margin-bottom: 12px;
}
.sidebar-contact-info {
    font-size: 1.35rem;
    line-height: 1.6;
    color: #333344;
}
</style>
@endsection
