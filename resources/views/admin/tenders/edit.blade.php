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
        <form action="{{ route('admin.tenders.update', $tender->id) }}" method="POST" enctype="multipart/form-data">
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
                    @if($tender->file_url)
                        <div class="mt-2">
                            <a href="{{ asset($tender->file_url) }}" target="_blank" class="small text-primary"><i class="fa fa-file-pdf-o"></i> View Current PDF</a>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Or External Document URL</label>
                    <input type="text" name="file_url" class="form-control" value="{{ old('file_url', $tender->file_url) }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Details / Scope (Optional)</label>
                    <textarea name="description_en" class="form-control" rows="3">{{ old('description_en', $tender->description_en) }}</textarea>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.tenders.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Update Tender</button>
            </div>
        </form>
    </div>
</div>
@endsection
