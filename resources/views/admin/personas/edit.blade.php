@extends('layouts.admin')

@section('title', 'Edit User Persona')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">edit</span> Edit User Persona Details
        </h5>
        <a href="{{ route('admin.personas.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.personas.update', $persona->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (English) <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $persona->title_en) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (Hindi)</label>
                    <input type="text" name="title_hi" class="form-control" value="{{ old('title_hi', $persona->title_hi) }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Description (English)</label>
                    <textarea name="description_en" class="form-control" rows="2">{{ old('description_en', $persona->description_en) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Description (Hindi)</label>
                    <textarea name="description_hi" class="form-control" rows="2">{{ old('description_hi', $persona->description_hi) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Icon (Material Symbols)</label>
                    <input type="text" name="icon" class="form-control" value="{{ old('icon', $persona->icon) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Target Link URL</label>
                    <input type="text" name="link_url" class="form-control" value="{{ old('link_url', $persona->link_url) }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $persona->sort_order) }}">
                </div>
                <div class="col-md-3 d-flex align-items-center mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" {{ $persona->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActive">Active</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.personas.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Update Persona</button>
            </div>
        </form>
    </div>
</div>
@endsection
