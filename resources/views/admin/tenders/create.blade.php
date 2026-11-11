@extends('layouts.admin')

@section('title', 'Add Tender / Vacancy')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-success">post_add</span> New Tender / Vacancy Details
        </h5>
        <a href="{{ route('admin.tenders.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form id="tenderForm" action="{{ route('admin.tenders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (English) <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" class="form-control" required placeholder="e.g. RFP for Appointment of Auditor">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (Hindi)</label>
                    <input type="text" name="title_hi" class="form-control" placeholder="Enter Hindi text (optional)">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required>
                        <option value="tender">Tender</option>
                        <option value="vacancy">Vacancy / Career</option>
                        <option value="auction">Auction / Notice</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Reference Number</label>
                    <input type="text" name="reference_no" class="form-control" placeholder="e.g. TC/TND/2026/04">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select">
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Publish Date</label>
                    <input type="date" name="published_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Closing Date</label>
                    <input type="date" name="closing_date" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Upload PDF Document</label>
                    <input type="file" name="file" class="form-control" accept=".pdf">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Or External Document URL</label>
                    <input type="text" name="file_url" class="form-control" placeholder="https://">
                </div>

                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
                        <label class="form-label fw-semibold mb-0">
                            Details / Scope of Tender <span class="text-muted fw-normal small">(Optional)</span>
                        </label>
                        <ul class="nav nav-pills custom-editor-tabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="tab-en-btn" data-bs-toggle="pill" data-bs-target="#tab-desc-en" type="button">
                                    <i class="fa fa-language me-1"></i> English
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="tab-hi-btn" data-bs-toggle="pill" data-bs-target="#tab-desc-hi" type="button">
                                    हिंदी (Hindi)
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <!-- English Tab -->
                        <div class="tab-pane fade show active" id="tab-desc-en" role="tabpanel">
                            <div class="cms-editor-wrapper">
                                <div id="quill-editor-en">{!! old('description_en') !!}</div>
                            </div>
                            <div class="form-text small text-muted mt-1 d-flex justify-content-between flex-wrap">
                                <span><i class="fa fa-info-circle text-primary me-1"></i> Highlight any text to make <strong>Bold</strong> or click <i class="fa fa-link"></i> to insert a redirect link.</span>
                                <span class="text-secondary fw-semibold">English Description</span>
                            </div>
                        </div>

                        <!-- Hindi Tab -->
                        <div class="tab-pane fade" id="tab-desc-hi" role="tabpanel">
                            <div class="cms-editor-wrapper">
                                <div id="quill-editor-hi">{!! old('description_hi') !!}</div>
                            </div>
                            <div class="form-text small text-muted mt-1 d-flex justify-content-between flex-wrap">
                                <span>हिंदी में विवरण एवं कार्य क्षेत्र (वैकल्पिक)</span>
                                <span class="text-secondary fw-semibold">Hindi Description</span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="description_en" id="hidden_description_en">
                    <input type="hidden" name="description_hi" id="hidden_description_hi">
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.tenders.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Publish Tender</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<!-- Quill Rich Text Editor (CDN with local fallback) -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
<style>
    /* Clean Tab Design */
    .custom-editor-tabs {
        background: #f1f5f9;
        padding: 3px;
        border-radius: 6px;
        gap: 4px;
        border: 1px solid #e2e8f0;
    }
    .custom-editor-tabs .nav-link {
        font-size: 12.5px;
        font-weight: 600;
        color: #475569;
        padding: 4px 14px;
        border-radius: 4px;
        transition: all 0.15s ease;
    }
    .custom-editor-tabs .nav-link:hover {
        color: #1e293b;
    }
    .custom-editor-tabs .nav-link.active {
        background: #721835;
        color: #ffffff;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
    }

    /* Single Seamless Editor Card */
    .cms-editor-wrapper {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        overflow: hidden;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .cms-editor-wrapper:focus-within {
        border-color: #721835;
        box-shadow: 0 0 0 3px rgba(114, 24, 53, 0.12);
    }
    .cms-editor-wrapper .ql-toolbar.ql-snow {
        border: none !important;
        border-bottom: 1px solid #e2e8f0 !important;
        background: #f8fafc;
        padding: 6px 10px;
    }
    .cms-editor-wrapper .ql-container.ql-snow {
        border: none !important;
        font-family: inherit;
    }
    .cms-editor-wrapper .ql-editor {
        min-height: 140px;
        max-height: 280px;
        overflow-y: auto;
        padding: 12px 14px;
        font-size: 14px;
        line-height: 1.6;
        color: #1e293b;
    }
    .cms-editor-wrapper .ql-editor.ql-blank::before {
        color: #94a3b8;
        font-style: normal;
        left: 14px;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
<script>
    (function() {
        function initQuill() {
            var toolbarOptions = [
                [{ 'header': [2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'color': [] }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                ['link'],
                ['clean']
            ];

            if (typeof Quill !== 'undefined') {
                var quillEn = new Quill('#quill-editor-en', {
                    theme: 'snow',
                    placeholder: 'Write or paste description, highlight text to bold, italic, or add links to redirect...',
                    modules: { toolbar: toolbarOptions }
                });

                var quillHi = new Quill('#quill-editor-hi', {
                    theme: 'snow',
                    placeholder: 'हिंदी में विवरण (यदि लागू हो)...',
                    modules: { toolbar: toolbarOptions }
                });

                // Tab switch refresh
                document.getElementById('tab-hi-btn')?.addEventListener('shown.bs.tab', function () {
                    if (quillHi) quillHi.update();
                });
                document.getElementById('tab-en-btn')?.addEventListener('shown.bs.tab', function () {
                    if (quillEn) quillEn.update();
                });

                var form = document.getElementById('tenderForm');
                if (form) {
                    form.addEventListener('submit', function() {
                        var htmlEn = quillEn.root.innerHTML;
                        if (quillEn.getText().trim().length === 0 && !htmlEn.includes('<img')) {
                            htmlEn = '';
                        }
                        document.getElementById('hidden_description_en').value = htmlEn;

                        var htmlHi = quillHi.root.innerHTML;
                        if (quillHi.getText().trim().length === 0 && !htmlHi.includes('<img')) {
                            htmlHi = '';
                        }
                        document.getElementById('hidden_description_hi').value = htmlHi;
                    });
                }
            } else {
                console.warn('Quill not available; activating native textarea fallback.');
                var elEn = document.getElementById('quill-editor-en');
                var elHi = document.getElementById('quill-editor-hi');
                if (elEn) {
                    var valEn = elEn.innerHTML.trim();
                    elEn.outerHTML = '<textarea name="description_en" id="hidden_description_en" class="form-control" rows="5" style="font-size: 14px;" placeholder="Write description (HTML/Links supported)...">' + valEn + '</textarea>';
                }
                if (elHi) {
                    var valHi = elHi.innerHTML.trim();
                    elHi.outerHTML = '<textarea name="description_hi" id="hidden_description_hi" class="form-control" rows="4" style="font-size: 14px;" placeholder="हिंदी में विवरण...">' + valHi + '</textarea>';
                }
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initQuill);
        } else {
            initQuill();
        }
    })();
</script>
@endpush
@endsection
