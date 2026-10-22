@extends('layouts.admin')

@section('title', 'Add Campaign Banner')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-danger">add_photo_alternate</span> New Campaign Details
        </h5>
        <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (English) <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" class="form-control" required placeholder="e.g. Swachhata Pakhwada 2026">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (Hindi)</label>
                    <input type="text" name="title_hi" class="form-control" placeholder="Enter Hindi text (optional)">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Upload Image File</label>
                    <input type="file" name="image_file" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Or Image Asset Path</label>
                    <input type="text" name="image_url" class="form-control" value="assets/images/banner1_swachhata.png">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Target Link URL</label>
                    <input type="text" name="link_url" class="form-control" value="#" placeholder="https:// or #">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="0">
                </div>
                <div class="col-md-3 d-flex align-items-center mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                        <label class="form-check-label fw-semibold" for="isActive">Active</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.campaigns.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Save Campaign</button>
            </div>
        </form>
    </div>
</div>
@endsection
