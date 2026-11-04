@extends('layouts.admin')

@section('title', 'Edit Portal / Related Link')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">edit</span> Edit Portal / Related Link
        </h5>
        <a href="{{ route('admin.important-links.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.important-links.update', $importantLink->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Portal / Link Title (English) <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $importantLink->title_en) }}" required placeholder="e.g. DigiLocker">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Portal / Link Title (Hindi)</label>
                    <input type="text" name="title_hi" class="form-control" value="{{ old('title_hi', $importantLink->title_hi) }}" placeholder="वैकल्पिक हिंदी नाम (वैकल्पिक)">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Website URL <span class="text-danger">*</span></label>
                    <input type="url" name="url" class="form-control" value="{{ old('url', $importantLink->url) }}" required placeholder="https://www.example.gov.in">
                    <small class="text-muted">Include https:// or http://</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Target Window</label>
                    <select name="target" class="form-select">
                        <option value="_blank" {{ old('target', $importantLink->target) === '_blank' ? 'selected' : '' }}>Open in New Tab (_blank)</option>
                        <option value="_self" {{ old('target', $importantLink->target) === '_self' ? 'selected' : '' }}>Open in Same Tab (_self)</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Category</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $importantLink->category) }}" placeholder="e.g. Government Portals, Handlooms, Schemes">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $importantLink->sort_order) }}">
                    <small class="text-muted">Lower numbers appear first</small>
                </div>

                <div class="col-md-4 d-flex align-items-center mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" {{ $importantLink->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActive">Active (Visible on public page)</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.important-links.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Update Portal Link</button>
            </div>
        </form>
    </div>
</div>
@endsection
