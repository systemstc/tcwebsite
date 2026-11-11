@extends('layouts.admin')

@section('title', 'Edit Tender / Vacancy')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">edit</span> Edit Tender / Vacancy Details
        </h5>
        <a href="{{ route('admin.tenders.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form id="tenderForm" action="{{ route('admin.tenders.update', $tender->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (English) <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $tender->title_en) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (Hindi)</label>
                    <input type="text" name="title_hi" class="form-control" value="{{ old('title_hi', $tender->title_hi) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required>
                        <option value="tender" {{ $tender->type === 'tender' ? 'selected' : '' }}>Tender</option>
                        <option value="vacancy" {{ $tender->type === 'vacancy' ? 'selected' : '' }}>Vacancy / Career</option>
                        <option value="auction" {{ $tender->type === 'auction' ? 'selected' : '' }}>Auction / Notice</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Reference Number</label>
                    <input type="text" name="reference_no" class="form-control" value="{{ old('reference_no', $tender->reference_no) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select">
                        <option value="open" {{ $tender->status === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="closed" {{ $tender->status === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Publish Date</label>
                    <input type="date" name="published_date" class="form-control" value="{{ old('published_date', $tender->published_date ? $tender->published_date->format('Y-m-d') : '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Closing Date</label>
                    <input type="date" name="closing_date" class="form-control" value="{{ old('closing_date', $tender->closing_date ? $tender->closing_date->format('Y-m-d') : '') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Upload New PDF File (Optional)</label>
                    <input type="file" name="file" class="form-control" accept=".pdf">
                    @if($tender->document_url)
                        <div class="mt-2">
                            <a href="{{ asset($tender->document_url) }}" target="_blank" class="small text-primary"><i class="fa fa-file-pdf"></i> View Current PDF</a>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Or External Document URL</label>
                    <input type="text" name="file_url" class="form-control" value="{{ old('file_url', $tender->document_url) }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
                        <span>Details / Scope (English)</span>
                        <span class="text-muted small"><i class="fa fa-info-circle me-1"></i> Highlight text to make <strong>Bold</strong> or add a <i class="fa fa-link"></i> <strong>Link</strong></span>
                    </label>
                    <div id="quill-editor-en" class="bg-white">{!! old('description_en', $tender->description_en) !!}</div>
                    <input type="hidden" name="description_en" id="hidden_description_en">
                    <div class="form-text small text-muted mt-1">
                        Select any text and click the link icon (<i class="fa fa-link"></i>) in the toolbar to add redirect URLs to portals, application forms, or external websites.
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold d-flex justify-content-between align-items-center">
                        <span>Details / Scope (Hindi - वैकल्पिक)</span>
                    </label>
                    <div id="quill-editor-hi" class="bg-white">{!! old('description_hi', $tender->description_hi) !!}</div>
                    <input type="hidden" name="description_hi" id="hidden_description_hi">
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.tenders.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Update Tender</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
<style>
    .ql-toolbar.ql-snow {
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        border-color: #cbd5e1;
        background: #f8fafc;
    }
    .ql-container.ql-snow {
        border-bottom-left-radius: 6px;
        border-bottom-right-radius: 6px;
        border-color: #cbd5e1;
        font-family: inherit;
    }
    .ql-editor {
        min-height: 180px;
        font-size: 14.5px;
        line-height: 1.6;
    }
</style>
<script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toolbarOptions = [
            [{ 'header': [1, 2, 3, 4, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            ['link', 'clean']
        ];

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
    });
</script>
@endpush
@endsection
