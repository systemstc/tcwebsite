@extends('layouts.admin')

@section('title', 'Add User Persona')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">add_circle</span> New User Persona Details
        </h5>
        <a href="{{ route('admin.personas.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.personas.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (English) <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" class="form-control" required placeholder="e.g. Weavers & Artisans">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (Hindi)</label>
                    <input type="text" name="title_hi" class="form-control" placeholder="Enter Hindi text (optional)">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Description (English)</label>
                    <textarea name="description_en" class="form-control" rows="2" placeholder="Brief persona description in English..."></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Description (Hindi)</label>
                    <textarea name="description_hi" class="form-control" rows="2" placeholder="Enter Hindi text (optional)"></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Icon (Material Symbols)</label>
                    <input type="text" name="icon" class="form-control" value="groups" placeholder="e.g. groups, handloom, storefront">
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
                <a href="{{ route('admin.personas.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Save Persona</button>
            </div>
        </form>
    </div>
</div>
@endsection
