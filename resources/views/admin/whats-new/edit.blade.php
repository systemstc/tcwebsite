@extends('layouts.admin')

@section('title', "Edit What's New Item")

@section('content')
@php
    $item = $whatsNew ?? $item;
@endphp
<div class="cms-card">
    <div class="cms-card-header d-flex justify-content-between align-items-center">
        <h5 class="cms-card-title mb-0">
            <span class="material-symbols-outlined text-primary">edit</span> Edit What's New Post
        </h5>
        <a href="{{ route('admin.whats-new.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.whats-new.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <!-- Title (English) -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (English) <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $item->title_en) }}" required placeholder="e.g. Draft Questionnaire under Integrated Textile Census">
                </div>

                <!-- Title (Hindi) -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (Hindi)</label>
                    <input type="text" name="title_hi" class="form-control" value="{{ old('title_hi', $item->title_hi) }}" placeholder="उदा. एकीकृत वस्त्र गणना के तहत मसौदा प्रश्नावली">
                </div>

                <!-- Category -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Category / Type <span class="text-danger">*</span></label>
                    <select name="category" class="form-select">
                        @php $cat = old('category', $item->category ?: 'Notification'); @endphp
                        <option value="Notification" {{ $cat == 'Notification' ? 'selected' : '' }}>Notification</option>
                        <option value="Notice" {{ $cat == 'Notice' ? 'selected' : '' }}>Notice</option>
                        <option value="Circular" {{ $cat == 'Circular' ? 'selected' : '' }}>Circular</option>
                        <option value="Tender / Vacancy" {{ $cat == 'Tender / Vacancy' ? 'selected' : '' }}>Tender / Vacancy</option>
                        <option value="Press Release" {{ $cat == 'Press Release' ? 'selected' : '' }}>Press Release</option>
                        <option value="Update" {{ $cat == 'Update' ? 'selected' : '' }}>General Update</option>
                        <option value="Offering / Scheme" {{ $cat == 'Offering / Scheme' ? 'selected' : '' }}>Offering / Scheme</option>
                    </select>
                </div>

                <!-- Published Date -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Published Date <span class="text-danger">*</span></label>
                    <input type="date" name="date" class="form-control" value="{{ old('date', $item->date ? $item->date->format('Y-m-d') : date('Y-m-d')) }}" required>
                </div>

                <!-- Sort Order -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
                </div>

                <!-- File Upload (PDF/Document) -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fa fa-file-pdf text-danger me-1"></i> Replace Document File (PDF / DOC / XLS)
                    </label>
                    <input type="file" name="file_upload" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip">
                    @if($item->document_url)
                        <div class="small mt-1 text-success d-flex align-items-center gap-1">
                            <i class="fa fa-check-circle"></i>
                            <span>Current File: </span>
                            <a href="{{ asset($item->document_url) }}" target="_blank" class="fw-semibold text-success text-decoration-none font-monospace">
                                {{ basename($item->document_url) }} ({{ $item->file_size ?: 'Download' }})
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Document URL -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Or Direct Document URL</label>
                    <input type="text" name="document_url" class="form-control" value="{{ old('document_url', $item->document_url) }}" placeholder="assets/docs/... or https://...">
                </div>

                <!-- External Detail Link URL -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">External / Detail Link URL</label>
                    <input type="text" name="link_url" class="form-control" value="{{ old('link_url', $item->link_url ?: '#') }}">
                </div>

                <!-- Custom File Size -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Display File Size</label>
                    <input type="text" name="file_size" class="form-control" value="{{ old('file_size', $item->file_size) }}" placeholder="e.g. 1.59 MB">
                </div>

                <!-- Description (English) -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Description / Notes (English)</label>
                    <textarea name="content_en" class="form-control" rows="3">{{ old('content_en', $item->content_en) }}</textarea>
                </div>

                <!-- Description (Hindi) -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Description / Notes (Hindi)</label>
                    <textarea name="content_hi" class="form-control" rows="3">{{ old('content_hi', $item->content_hi) }}</textarea>
                </div>

                <!-- Toggles: Is New Badge & Active -->
                <div class="col-md-6">
                    <div class="form-check form-switch p-3 border rounded-3 bg-light">
                        <input class="form-check-input ms-0 me-3" type="checkbox" name="is_new" id="isNew" value="1" {{ !empty($item->is_new) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="isNew">
                            <span class="badge bg-danger me-1">NEW</span> Display "NEW" Pulsing Badge
                        </label>
                        <small class="text-muted d-block mt-1">Highlights this item as newly added on the portal ticker and What's New page.</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check form-switch p-3 border rounded-3 bg-light">
                        <input class="form-check-input ms-0 me-3" type="checkbox" name="is_active" id="isActive" value="1" {{ !empty($item->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="isActive">
                            <i class="fa fa-check-circle text-success me-1"></i> Published & Active
                        </label>
                        <small class="text-muted d-block mt-1">Visible to citizens on the public portal.</small>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.whats-new.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4 fw-semibold">
                    <i class="fa fa-save me-1"></i> Update What's New Post
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
