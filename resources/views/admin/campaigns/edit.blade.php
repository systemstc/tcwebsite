@extends('layouts.admin')

@section('title', 'Edit Campaign Banner')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">edit</span> Edit Campaign Details
        </h5>
        <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.campaigns.update', $campaign->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (English) <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $campaign->title_en) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (Hindi)</label>
                    <input type="text" name="title_hi" class="form-control" value="{{ old('title_hi', $campaign->title_hi) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Upload New Image File (Optional)</label>
                    <input type="file" name="image_file" class="form-control" accept="image/*">
                    <div class="mt-2">
                        <img src="{{ asset($campaign->image_url) }}" alt="Preview" style="height: 50px; border-radius: 4px; border: 1px solid #ccc;">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Image Asset Path / URL</label>
                    <input type="text" name="image_url" class="form-control" value="{{ old('image_url', $campaign->image_url) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Target Link URL</label>
                    <input type="text" name="link_url" class="form-control" value="{{ old('link_url', $campaign->link_url) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $campaign->sort_order) }}">
                </div>
                <div class="col-md-3 d-flex align-items-center mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" {{ $campaign->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActive">Active</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.campaigns.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Update Campaign</button>
            </div>
        </form>
    </div>
</div>
@endsection
