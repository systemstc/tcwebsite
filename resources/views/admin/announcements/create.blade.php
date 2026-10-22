@extends('layouts.admin')

@section('title', 'Add Announcement')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">add_alert</span> New Announcement Details
        </h5>
        <a href="{{ route('admin.announcements.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.announcements.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Announcement Text (English) <span class="text-danger">*</span></label>
                    <textarea name="title_en" class="form-control" rows="2" required placeholder="Write the announcement text in English...">{{ old('title_en') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Announcement Text (Hindi)</label>
                    <textarea name="title_hi" class="form-control" rows="2" placeholder="Enter Hindi text (optional)">{{ old('title_hi') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Target Link URL (Optional)</label>
                    <input type="text" name="link_url" class="form-control" value="#" placeholder="https:// or #">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="0">
                </div>
                <div class="col-md-3 d-flex flex-column justify-content-center">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="is_new" id="isNew" checked>
                        <label class="form-check-label fw-semibold" for="isNew">Show 'NEW' Tag</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                        <label class="form-check-label fw-semibold" for="isActive">Active</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Save Announcement</button>
            </div>
        </form>
    </div>
</div>
@endsection
