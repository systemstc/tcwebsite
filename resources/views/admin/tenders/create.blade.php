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
                    <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
                        <span>Details / Scope (English)</span>
                        <span class="text-muted small"><i class="fa fa-info-circle me-1"></i> Highlight text to make <strong>Bold</strong> or add a <i class="fa fa-link"></i> <strong>Link</strong></span>
                    </label>
                    <div id="quill-editor-en" class="bg-white" style="min-height: 180px; border: 1px solid #ced4da; border-radius: 6px; padding: 12px;">{!! old('description_en') !!}</div>
                    <input type="hidden" name="description_en" id="hidden_description_en">
                    <div class="form-text small text-muted mt-1">
                        Select any text and click the link icon (<i class="fa fa-link"></i>) in the toolbar to add redirect URLs to portals, application forms, or external websites.
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
                        <span>Details / Scope (Hindi - वैकल्पिक)</span>
                    </label>
                    <div id="quill-editor-hi" class="bg-white" style="min-height: 140px; border: 1px solid #ced4da; border-radius: 6px; padding: 12px;">{!! old('description_hi') !!}</div>
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
    .ql-toolbar.ql-snow {
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        border-color: #cbd5e1 !important;
        background: #f8fafc;
    }
    .ql-container.ql-snow {
        border-bottom-left-radius: 6px;
        border-bottom-right-radius: 6px;
        border-color: #cbd5e1 !important;
        font-family: inherit;
        border-top: none !important;
    }
    .ql-editor {
        min-height: 180px;
        font-size: 14.5px;
        line-height: 1.6;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
<script>
    (function() {
        function initQuill() {
            var toolbarOptions = [
                [{ 'header': [1, 2, 3, 4, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                ['link', 'clean']
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
                // Fail-safe textarea fallback if script blocked or unreachable
                console.warn('Quill not available; activating native textarea fallback.');
                var elEn = document.getElementById('quill-editor-en');
                var elHi = document.getElementById('quill-editor-hi');
                if (elEn) {
                    var valEn = elEn.innerHTML.trim();
                    elEn.outerHTML = '<textarea name="description_en" id="hidden_description_en" class="form-control" rows="6" style="font-size: 14.5px;" placeholder="Write description (HTML/Links supported)...">' + valEn + '</textarea>';
                }
                if (elHi) {
                    var valHi = elHi.innerHTML.trim();
                    elHi.outerHTML = '<textarea name="description_hi" id="hidden_description_hi" class="form-control" rows="4" style="font-size: 14.5px;" placeholder="हिंदी में विवरण...">' + valHi + '</textarea>';
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
