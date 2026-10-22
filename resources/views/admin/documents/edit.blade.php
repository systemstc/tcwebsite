@extends('layouts.admin')

@section('title', 'Edit Document')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">edit</span> Edit Document Details
        </h5>
        <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (English) <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $document->title_en) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (Hindi)</label>
                    <input type="text" name="title_hi" class="form-control" value="{{ old('title_hi', $document->title_hi) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                    <select name="category" class="form-select" required>
                        <option value="report" {{ $document->category === 'report' ? 'selected' : '' }}>Annual Report</option>
                        <option value="circular" {{ $document->category === 'circular' ? 'selected' : '' }}>Circular / Notification</option>
                        <option value="gazette" {{ $document->category === 'gazette' ? 'selected' : '' }}>Gazette / Policy</option>
                        <option value="guideline" {{ $document->category === 'guideline' ? 'selected' : '' }}>Guideline / Standard</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Publish Date</label>
                    <input type="date" name="published_date" class="form-control" value="{{ old('published_date', $document->published_date ? $document->published_date->format('Y-m-d') : '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $document->sort_order) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Upload New PDF File (Optional)</label>
                    <input type="file" name="file" class="form-control" accept=".pdf">
                    @if($document->file_url)
                        <div class="mt-2">
                            <a href="{{ asset($document->file_url) }}" target="_blank" class="small text-primary"><i class="fa fa-file-pdf-o"></i> View Current PDF</a>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Or External Document URL</label>
                    <input type="text" name="file_url" class="form-control" value="{{ old('file_url', $document->file_url) }}">
                </div>

                <div class="col-md-6">
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" {{ $document->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActive">Active</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Update Document</button>
            </div>
        </form>
    </div>
</div>
@endsection
