@extends('layouts.admin')

@section('title', 'Create New Page')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">note_add</span> Create New Dynamic Page
        </h5>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.pages.store') }}" method="POST" id="pageForm">
            @csrf
            
            <div class="row g-3">
                <!-- Basic Info -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Page Title (English) <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" id="titleEn" class="form-control" required placeholder="e.g. Schemes & Programs, National Textile Policy" value="{{ old('title_en') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Page Title (Hindi)</label>
                    <input type="text" name="title_hi" class="form-control" placeholder="e.g. योजनाएं एवं कार्यक्रम" value="{{ old('title_hi') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">URL Slug</label>
                    <input type="text" name="slug" id="pageSlug" class="form-control" placeholder="e.g. national-textile-policy" value="{{ old('slug') }}">
                    <small class="text-muted">Auto-generated from title if left blank. Direct URL: <code>/page/your-slug</code></small>
                </div>

                <!-- Menu Placement -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Link to Header Menu <span class="badge bg-primary ms-1">Dynamic Menu</span></label>
                    <select name="menu_location" class="form-select">
                        <option value="none" {{ old('menu_location') == 'none' ? 'selected' : '' }}>None (Unlisted / Direct Link Only)</option>
                        <option value="ministry" {{ old('menu_location') == 'ministry' ? 'selected' : '' }}>Ministry (मंत्रालय) Dropdown</option>
                        <option value="offerings" {{ old('menu_location') == 'offerings' ? 'selected' : '' }}>Offerings (योजनाएं एवं सेवाएं) Dropdown</option>
                        <option value="documents" {{ old('menu_location') == 'documents' ? 'selected' : '' }}>Documents (दस्तावेज़) Dropdown</option>
                        <option value="media" {{ old('menu_location') == 'media' ? 'selected' : '' }}>Media (मीडिया) Dropdown</option>
                        <option value="connect" {{ old('menu_location') == 'connect' ? 'selected' : '' }}>Connect (संपर्क) Dropdown</option>
                        <option value="top" {{ old('menu_location') == 'top' ? 'selected' : '' }}>★ Top-Level Main Menu Item</option>
                    </select>
                    <small class="text-muted">Select which menu dropdown this page automatically appears in.</small>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 10) }}" min="0">
                    <small class="text-muted">Order in dropdown</small>
                </div>

                <div class="col-md-2 d-flex align-items-center mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                        <label class="form-check-label fw-semibold" for="isActive">Published</label>
                    </div>
                </div>

                <!-- Template Type -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Page Category / Layout Type</label>
                    <select name="template_type" id="templateType" class="form-select">
                        <option value="standard">Standard Official Article (टेक्स्ट, चित्र, हेडिंग्स)</option>
                        <option value="table">Government Data Table / Schedule (तालिका / आंकड़े)</option>
                        <option value="officers">Leadership & Officers Directory (अधिकारी सूची)</option>
                        <option value="downloads">Reports & Documents Downloads (दस्तावेज़ डाउनलोड)</option>
                        <option value="schemes">Scheme Guidelines & FAQs (योजना विवरण व प्रश्नोत्तरी)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Meta Summary (SEO)</label>
                    <input type="text" name="meta_description" class="form-control" placeholder="Brief 1-line description of this page..." value="{{ old('meta_description') }}">
                </div>
            </div>

            <!-- Page Design Toolbar (Provisions for inserting tables, images, grids) -->
            <div class="card mt-4 border-0 shadow-sm" style="background: #fdfafd; border: 1.5px dashed #c499b3 !important; border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <span class="fw-bold" style="color: #6c1340; font-size: 14px;">
                                <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Page Design Provisions (texmin.gov.in UI Components):
                            </span>
                            <div class="text-muted" style="font-size: 12px;">Click any button below to insert ready-made, responsive Government of India elements into the editor:</div>
                        </div>

                        <!-- Full Starter Templates -->
                        <div class="dropdown">
                            <button class="btn btn-sm text-white dropdown-toggle fw-bold" type="button" data-bs-toggle="dropdown" style="background: #6c1340;">
                                <i class="fa-solid fa-file-code me-1"></i> Load Full Starter Template
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="loadTemplate('table')"><i class="fa-solid fa-table me-2 text-primary"></i> Data Table Template</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="loadTemplate('officers')"><i class="fa-solid fa-users me-2 text-success"></i> Officers & Team Directory</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="loadTemplate('downloads')"><i class="fa-solid fa-file-pdf me-2 text-danger"></i> Reports & Downloads Page</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="loadTemplate('article')"><i class="fa-solid fa-newspaper me-2 text-warning"></i> Article with Image & Callout</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="loadTemplate('schemes')"><i class="fa-solid fa-list-check me-2 text-info"></i> Scheme Guidelines & FAQ</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Component Quick Insert Buttons -->
                    <div class="d-flex flex-wrap gap-2 mt-3 pt-2 border-top">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertSnippet('table')">
                            <i class="fa-solid fa-table me-1 text-primary"></i> + Insert Gov Data Table
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertSnippet('image')">
                            <i class="fa-solid fa-image me-1 text-success"></i> + Insert Image with Caption
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertSnippet('officers')">
                            <i class="fa-solid fa-id-card me-1 text-info"></i> + Insert Officer Cards
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertSnippet('downloads')">
                            <i class="fa-solid fa-file-pdf me-1 text-danger"></i> + Insert PDF Download Row
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertSnippet('callout')">
                            <i class="fa-solid fa-bullhorn me-1 text-warning"></i> + Insert Maroon Callout Box
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertSnippet('accordion')">
                            <i class="fa-solid fa-bars-staggered me-1 text-secondary"></i> + Insert Accordion FAQs
                        </button>
                        <button type="button" class="btn btn-outline-dark btn-sm ms-auto" onclick="previewCurrentContent()">
                            <i class="fa-solid fa-eye me-1"></i> Live Preview
                        </button>
                    </div>
                </div>
            </div>

            <!-- Content Editors -->
            <div class="row g-3 mt-2">
                <div class="col-12">
                    <label class="form-label fw-bold" style="color: #6c1340; font-size: 15px;">
                        Page Content (English - HTML / Rich Text) <span class="text-danger">*</span>
                    </label>
                    <textarea name="content_en" id="contentEn" class="form-control font-monospace" rows="14" placeholder="Enter page HTML content or use the Insert buttons above...">{{ old('content_en') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold text-secondary" style="font-size: 15px;">
                        Page Content (Hindi - Optional)
                    </label>
                    <textarea name="content_hi" id="contentHi" class="form-control font-monospace" rows="8" placeholder="हिंदी सामग्री (वैकल्पिक)...">{{ old('content_hi') }}</textarea>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Save & Publish Page
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Live Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: #6c1340; color: #fff;">
                <h5 class="modal-title" id="previewModalLabel">
                    <i class="fa-solid fa-display me-2"></i> Page Content Live Preview (texmin.gov.in Theme)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="background: #ffffff;">
                <h1 id="previewTitle" class="fw-bold mb-4" style="color: #6c1340; font-size: 2.8rem; border-bottom: 3px solid #c59b27; padding-bottom: 10px;">
                    Page Title Preview
                </h1>
                <div id="previewBody" class="gov-page-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close Preview</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Preview component styling matching front.blade.php */
.gov-page-content { font-size: 1.55rem; line-height: 1.85; color: #2c3e50; }
.gov-page-content p { margin-bottom: 1.2rem; }
.gov-page-content h2 { font-size: 2.2rem; font-weight: 700; color: #6c1340; margin-top: 1.8rem; margin-bottom: 1rem; border-bottom: 2px solid #f2e2eb; padding-bottom: 6px; }
.gov-page-content h3 { font-size: 1.85rem; font-weight: 600; color: #222; margin-top: 1.4rem; margin-bottom: 0.8rem; }
.gov-table-wrap { overflow-x: auto; margin: 20px 0; border-radius: 6px; border: 1px solid #e1d3dc; }
.gov-table { width: 100%; border-collapse: collapse; font-size: 1.45rem; margin-bottom: 0; }
.gov-table thead th { background: #6c1340; color: #ffffff; font-weight: 700; padding: 12px 14px; border: 1px solid #570e33; text-align: left; }
.gov-table tbody td { padding: 11px 14px; border: 1px solid #ebdbe3; vertical-align: middle; }
.gov-table tbody tr:nth-child(even) { background-color: #fdfafd; }
.gov-table tbody tr:hover { background-color: #f7eef3; }
.gov-callout { background: #faf4f7; border-left: 4px solid #6c1340; padding: 16px 20px; border-radius: 0 6px 6px 0; margin: 18px 0; font-size: 1.5rem; }
.gov-officer-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 18px; margin: 20px 0; }
.gov-officer-card { background: #ffffff; border: 1px solid #e8e0e5; border-radius: 8px; padding: 18px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.04); }
.gov-officer-img { width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid #6c1340; margin: 0 auto 12px; }
.gov-officer-name { font-size: 1.65rem; font-weight: 700; color: #6c1340; margin-bottom: 3px; }
.gov-officer-role { font-size: 1.35rem; color: #555; font-weight: 600; margin-bottom: 6px; }
</style>

@push('scripts')
<script>
    // Auto-generate slug from English title
    document.getElementById('titleEn').addEventListener('input', function() {
        var slugInput = document.getElementById('pageSlug');
        if (!slugInput.dataset.manual) {
            slugInput.value = this.value.toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }
    });

    document.getElementById('pageSlug').addEventListener('input', function() {
        this.dataset.manual = "true";
    });

    // Snippet Inserter Helper
    function insertSnippet(type) {
        var textarea = document.getElementById('contentEn');
        var snippet = '';

        if (type === 'table') {
            snippet = `
<!-- Government Data Table (texmin.gov.in style) -->
<div class="gov-table-wrap">
    <table class="gov-table">
        <thead>
            <tr>
                <th style="width: 80px;">S.No.</th>
                <th>Scheme / Initiative Name</th>
                <th>Implementing Division</th>
                <th>Outlay (₹ Crore)</th>
                <th>Beneficiaries Target</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td><strong>PM Mega Integrated Textile Region and Apparel (PM MITRA)</strong></td>
                <td>Infrastructure Division</td>
                <td>₹4,445 Cr</td>
                <td>1,00,000+</td>
                <td><span class="badge bg-success">Active / Operational</span></td>
            </tr>
            <tr>
                <td>2</td>
                <td><strong>Production Linked Incentive (PLI) for Textiles</strong></td>
                <td>Textile Division</td>
                <td>₹10,683 Cr</td>
                <td>64 Selected Units</td>
                <td><span class="badge bg-success">Active</span></td>
            </tr>
            <tr>
                <td>3</td>
                <td><strong>National Technical Textiles Mission (NTTM)</strong></td>
                <td>R&D Division</td>
                <td>₹1,480 Cr</td>
                <td>Technical Sector</td>
                <td><span class="badge bg-primary">Ongoing</span></td>
            </tr>
        </tbody>
    </table>
</div>
`;
        } else if (type === 'image') {
            snippet = `
<!-- Responsive Image Block with Caption -->
<div class="my-4 text-center">
    <div style="background: #fdfafd; padding: 12px; border: 1px solid #ebdbe3; border-radius: 8px; display: inline-block; max-width: 100%;">
        <img src="/assets/images/partner_logos_strip.png" alt="Government Initiative Showcase" class="img-fluid rounded" style="max-height: 380px; object-fit: cover;">
        <div class="mt-2 text-muted fw-semibold" style="font-size: 1.35rem;">
            Figure 1: Comprehensive ecosystem and modern facilities under Textiles Committee, Govt of India
        </div>
    </div>
</div>
`;
        } else if (type === 'officers') {
            snippet = `
<!-- Leadership & Officers Directory Grid -->
<h2>Leadership & Directory</h2>
<div class="gov-officer-grid">
    <div class="gov-officer-card">
        <img src="/assets/images/Textiles_Committee_Logo.png" alt="Officer Photo" class="gov-officer-img">
        <div class="gov-officer-name">Shri Giriraj Singh</div>
        <div class="gov-officer-role">Hon'ble Union Minister of Textiles</div>
        <div class="text-muted" style="font-size: 1.3rem;"><i class="fa fa-phone me-1"></i> +91-11-23061301</div>
        <div class="text-muted" style="font-size: 1.3rem;"><i class="fa fa-envelope me-1"></i> minister-textiles@gov.in</div>
    </div>
    <div class="gov-officer-card">
        <img src="/assets/images/Textiles_Committee_Logo.png" alt="Officer Photo" class="gov-officer-img">
        <div class="gov-officer-name">Shri Pabitra Margherita</div>
        <div class="gov-officer-role">Hon'ble Minister of State for Textiles</div>
        <div class="text-muted" style="font-size: 1.3rem;"><i class="fa fa-phone me-1"></i> +91-11-23062000</div>
        <div class="text-muted" style="font-size: 1.3rem;"><i class="fa fa-envelope me-1"></i> mos-textiles@gov.in</div>
    </div>
    <div class="gov-officer-card">
        <img src="/assets/images/Textiles_Committee_Logo.png" alt="Officer Photo" class="gov-officer-img">
        <div class="gov-officer-name">Secretary (Textiles)</div>
        <div class="gov-officer-role">Secretary to Government of India</div>
        <div class="text-muted" style="font-size: 1.3rem;"><i class="fa fa-phone me-1"></i> +91-11-23061769</div>
        <div class="text-muted" style="font-size: 1.3rem;"><i class="fa fa-envelope me-1"></i> secy-textiles@nic.in</div>
    </div>
</div>
`;
        } else if (type === 'downloads') {
            snippet = `
<!-- Official Reports & Document Downloads -->
<h2>Official Notifications & Guidelines</h2>
<div class="gov-table-wrap">
    <table class="gov-table">
        <thead>
            <tr>
                <th style="width: 120px;">Date</th>
                <th>Document Title / Subject</th>
                <th>File Format</th>
                <th style="width: 140px; text-align: center;">Download</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>12-10-2026</td>
                <td><strong>Comprehensive Guidelines on Quality Control Orders (QCOs) for Technical Textiles</strong></td>
                <td><span class="badge bg-danger"><i class="fa-solid fa-file-pdf me-1"></i> PDF (1.4 MB)</span></td>
                <td class="text-center"><a href="#" class="btn btn-sm text-white" style="background: #6c1340;"><i class="fa fa-download me-1"></i> Download</a></td>
            </tr>
            <tr>
                <td>04-10-2026</td>
                <td><strong>Annual Administrative Report & Financial Audited Statement (2025-26)</strong></td>
                <td><span class="badge bg-danger"><i class="fa-solid fa-file-pdf me-1"></i> PDF (3.2 MB)</span></td>
                <td class="text-center"><a href="#" class="btn btn-sm text-white" style="background: #6c1340;"><i class="fa fa-download me-1"></i> Download</a></td>
            </tr>
        </tbody>
    </table>
</div>
`;
        } else if (type === 'callout') {
            snippet = `
<!-- Important Highlight Callout Box -->
<div class="gov-callout">
    <div class="fw-bold" style="color: #6c1340; font-size: 1.7rem; margin-bottom: 6px;">
        <i class="fa-solid fa-circle-info me-2"></i> Important Statutory Information
    </div>
    <p class="m-0 text-dark">
        All applications and laboratory testing submissions must be processed through the certified Textiles Committee portal. For inquiries, please reference the official gazette notification guidelines.
    </p>
</div>
`;
        } else if (type === 'accordion') {
            snippet = `
<!-- Accordion / FAQ Section -->
<h2>Frequently Asked Questions & Eligibility</h2>
<div class="accordion my-3" id="faqAccordion">
    <div class="accordion-item" style="border: 1px solid #ebdbe3; margin-bottom: 8px; border-radius: 6px; overflow: hidden;">
        <h2 class="accordion-header" id="headingOne" style="margin: 0; border: none; padding: 0;">
            <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="background: #fbf5f8; color: #6c1340; font-size: 1.6rem;">
                1. What are the key objectives and eligibility criteria?
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
            <div class="accordion-body" style="font-size: 1.5rem; line-height: 1.8;">
                The primary objective is to enhance textile exports, certify product specifications, ensure international compliance, and empower domestic manufacturers across handloom, powerloom, and technical textiles sectors.
            </div>
        </div>
    </div>
    <div class="accordion-item" style="border: 1px solid #ebdbe3; margin-bottom: 8px; border-radius: 6px; overflow: hidden;">
        <h2 class="accordion-header" id="headingTwo" style="margin: 0; border: none; padding: 0;">
            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="background: #fbf5f8; color: #6c1340; font-size: 1.6rem;">
                2. How can an exporter apply for testing certification?
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
            <div class="accordion-body" style="font-size: 1.5rem; line-height: 1.8;">
                Exporters can register directly on our portal, submit test batch samples to accredited regional laboratories, and track their digital certificates online with QR-coded verification.
            </div>
        </div>
    </div>
</div>
`;
        }

        // Insert snippet at cursor or append
        var startPos = textarea.selectionStart;
        var endPos = textarea.selectionEnd;
        if (startPos || startPos === 0) {
            textarea.value = textarea.value.substring(0, startPos) + snippet + textarea.value.substring(endPos, textarea.value.length);
        } else {
            textarea.value += snippet;
        }
        textarea.focus();
    }

    // Full Starter Template Loader
    function loadTemplate(type) {
        if (!confirm('This will load a complete template into the English content editor. Continue?')) {
            return;
        }
        var textarea = document.getElementById('contentEn');
        var titleInput = document.getElementById('titleEn');

        if (type === 'table') {
            titleInput.value = titleInput.value || 'Key Schemes & Performance Statistics';
            textarea.value = `
<p class="lead">The Ministry of Textiles and Textiles Committee implement multiple flagships schemes aimed at boosting infrastructure, modernizing machinery, and increasing global export competitiveness.</p>

<div class="gov-callout">
    <strong>Notice:</strong> Data updated as of current financial quarter. For detailed notifications, refer to official Gazette publications.
</div>

<h2>Scheme Allocation & Implementation Schedule</h2>
<div class="gov-table-wrap">
    <table class="gov-table">
        <thead>
            <tr>
                <th style="width: 70px;">S.No</th>
                <th>Scheme Name</th>
                <th>Category</th>
                <th>Target Sector</th>
                <th>Budget (₹ Cr)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td><strong>PM MITRA Parks Scheme</strong></td>
                <td>Infrastructure</td>
                <td>Integrated Apparel & Textiles</td>
                <td>₹4,445 Cr</td>
                <td><span class="badge bg-success">7 Parks Approved</span></td>
            </tr>
            <tr>
                <td>2</td>
                <td><strong>PLI Scheme for Textiles</strong></td>
                <td>Incentive</td>
                <td>MMF Fabrics, Garments & Technical Textiles</td>
                <td>₹10,683 Cr</td>
                <td><span class="badge bg-success">Operational</span></td>
            </tr>
            <tr>
                <td>3</td>
                <td><strong>SAMARTH (Capacity Building)</strong></td>
                <td>Skilling</td>
                <td>Textile Workers & Artisans</td>
                <td>₹1,300 Cr</td>
                <td><span class="badge bg-primary">3.2 Lakh Trained</span></td>
            </tr>
            <tr>
                <td>4</td>
                <td><strong>Amended Technology Upgradation (ATUFS)</strong></td>
                <td>Technology</td>
                <td>Weaving & Processing Machinery</td>
                <td>₹5,450 Cr</td>
                <td><span class="badge bg-info text-dark">Active</span></td>
            </tr>
        </tbody>
    </table>
</div>

<h3>Key Highlights</h3>
<ul>
    <li>Fostering global competitiveness through world-class testing and certification standards.</li>
    <li>Direct support for handloom weavers and silk clusters nationwide.</li>
    <li>Dedicated R&D infrastructure for high-value technical textiles.</li>
</ul>
`;
        } else if (type === 'officers') {
            titleInput.value = titleInput.value || 'Organization Leadership & Officer Directory';
            textarea.value = `
<p class="lead">Directory of officials and leadership for the Textiles Committee, Ministry of Textiles, Government of India.</p>

<div class="gov-officer-grid">
    <div class="gov-officer-card">
        <img src="/assets/images/Textiles_Committee_Logo.png" alt="Officer" class="gov-officer-img">
        <div class="gov-officer-name">Shri Giriraj Singh</div>
        <div class="gov-officer-role">Hon'ble Union Minister of Textiles</div>
        <div class="text-muted" style="font-size: 1.3rem;"><i class="fa fa-phone me-1"></i> 011-23061301</div>
        <div class="text-muted" style="font-size: 1.3rem;"><i class="fa fa-envelope me-1"></i> minister-textiles@gov.in</div>
    </div>
    <div class="gov-officer-card">
        <img src="/assets/images/Textiles_Committee_Logo.png" alt="Officer" class="gov-officer-img">
        <div class="gov-officer-name">Secretary (Textiles)</div>
        <div class="gov-officer-role">Secretary, Ministry of Textiles</div>
        <div class="text-muted" style="font-size: 1.3rem;"><i class="fa fa-phone me-1"></i> 011-23061769</div>
        <div class="text-muted" style="font-size: 1.3rem;"><i class="fa fa-envelope me-1"></i> secy-textiles@nic.in</div>
    </div>
    <div class="gov-officer-card">
        <img src="/assets/images/Textiles_Committee_Logo.png" alt="Officer" class="gov-officer-img">
        <div class="gov-officer-name">Secretary & CEO</div>
        <div class="gov-officer-role">Textiles Committee, Mumbai HQ</div>
        <div class="text-muted" style="font-size: 1.3rem;"><i class="fa fa-phone me-1"></i> 022-66527500</div>
        <div class="text-muted" style="font-size: 1.3rem;"><i class="fa fa-envelope me-1"></i> secytc@nic.in</div>
    </div>
</div>
`;
        } else if (type === 'downloads') {
            titleInput.value = titleInput.value || 'Acts, Rules & Downloadable Documents';
            textarea.value = `
<p class="lead">Official downloadable gazettes, statutory acts, circulars, and annual publications issued by the Ministry of Textiles.</p>

<h2>Statutory Acts & Guidelines</h2>
<div class="gov-table-wrap">
    <table class="gov-table">
        <thead>
            <tr>
                <th style="width: 130px;">Date</th>
                <th>Title / Description</th>
                <th>File Format</th>
                <th style="width: 140px; text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>01-10-2026</td>
                <td><strong>Textiles Committee Act, 1963 (As Amended) & Operating Rules</strong></td>
                <td><span class="badge bg-danger"><i class="fa-solid fa-file-pdf me-1"></i> PDF (1.8 MB)</span></td>
                <td class="text-center"><a href="#" class="btn btn-sm text-white" style="background: #6c1340;"><i class="fa fa-download me-1"></i> Download</a></td>
            </tr>
            <tr>
                <td>15-09-2026</td>
                <td><strong>Laboratory Testing Quality Manual & Standard Operating Procedures</strong></td>
                <td><span class="badge bg-danger"><i class="fa-solid fa-file-pdf me-1"></i> PDF (3.4 MB)</span></td>
                <td class="text-center"><a href="#" class="btn btn-sm text-white" style="background: #6c1340;"><i class="fa fa-download me-1"></i> Download</a></td>
            </tr>
        </tbody>
    </table>
</div>
`;
        } else if (type === 'article') {
            titleInput.value = titleInput.value || 'About Textiles Committee & Core Mandate';
            textarea.value = `
<p class="lead">The Textiles Committee is a statutory body established under the Textiles Committee Act, 1963 under the administrative control of the Ministry of Textiles, Government of India.</p>

<div class="gov-callout">
    <strong>Core Mandate:</strong> To ensure the quality of textiles and textile machinery produced either for internal consumption or for export, and for matters connected therewith.
</div>

<h2>Key Functions & Responsibilities</h2>
<p>The primary functions of the Textiles Committee encompass quality surveillance, testing and certification of textiles and apparel, market research, and conducting techno-economic studies across India's vibrant textile cluster network.</p>

<div class="my-4 text-center">
    <div style="background: #fdfafd; padding: 12px; border: 1px solid #ebdbe3; border-radius: 8px; display: inline-block; max-width: 100%;">
        <img src="/assets/images/partner_logos_strip.png" alt="Textiles Committee Network" class="img-fluid rounded" style="max-height: 340px; object-fit: cover;">
        <div class="mt-2 text-muted fw-semibold" style="font-size: 1.35rem;">Textiles Committee accredited test laboratories and offices across major textile centers</div>
    </div>
</div>

<h2>Quality Certification & Testing Infrastructure</h2>
<p>Equipped with state-of-the-art testing laboratories located across 16 major textile production and export clusters in India, the Committee tests physical, chemical, eco-friendly, and microbiology parameters in conformity with ISO/IEC 17025 accreditation.</p>
`;
        }
    }

    // Live Preview
    function previewCurrentContent() {
        var title = document.getElementById('titleEn').value || 'Page Title Preview';
        var content = document.getElementById('contentEn').value;
        if (!content) {
            alert('Please enter or insert some content first to preview!');
            return;
        }
        document.getElementById('previewTitle').innerText = title;
        document.getElementById('previewBody').innerHTML = content;
        var modal = new bootstrap.Modal(document.getElementById('previewModal'));
        modal.show();
    }
</script>
@endpush
@endsection
