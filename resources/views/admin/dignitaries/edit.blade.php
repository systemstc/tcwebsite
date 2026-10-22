@extends('layouts.admin')

@section('title', 'Edit Dignitary')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">edit</span> Edit Dignitary Details
        </h5>
        <a href="{{ route('admin.dignitaries.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.dignitaries.update', $dignitary->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Name (English) <span class="text-danger">*</span></label>
                    <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $dignitary->name_en) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Name (Hindi)</label>
                    <input type="text" name="name_hi" class="form-control" value="{{ old('name_hi', $dignitary->name_hi) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Designation (English) <span class="text-danger">*</span></label>
                    <input type="text" name="designation_en" class="form-control" value="{{ old('designation_en', $dignitary->designation_en) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Designation (Hindi)</label>
                    <input type="text" name="designation_hi" class="form-control" value="{{ old('designation_hi', $dignitary->designation_hi) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Category (Type) <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required>
                        <option value="minister" {{ $dignitary->type === 'minister' ? 'selected' : '' }}>Union Minister (Cabinet / MoS)</option>
                        <option value="prime_minister" {{ $dignitary->type === 'prime_minister' ? 'selected' : '' }}>Prime Minister</option>
                        <option value="secretary" {{ $dignitary->type === 'secretary' ? 'selected' : '' }}>Secretary</option>
                        <option value="official" {{ $dignitary->type === 'official' ? 'selected' : '' }}>Senior Official</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Upload New Photo (Optional)</label>
                    <input type="file" name="photo_file" class="form-control" accept="image/*">
                    <div class="mt-2">
                        <img src="{{ asset($dignitary->photo_url) }}" alt="Preview" style="height: 45px; width: 45px; border-radius: 50%; object-fit: cover;">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Photo Asset Path / URL</label>
                    <input type="text" name="photo_url" class="form-control" value="{{ old('photo_url', $dignitary->photo_url) }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Message / Quote (English)</label>
                    <textarea name="quote_en" class="form-control" rows="2">{{ old('quote_en', $dignitary->quote_en) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Message / Quote (Hindi)</label>
                    <textarea name="quote_hi" class="form-control" rows="2">{{ old('quote_hi', $dignitary->quote_hi) }}</textarea>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Quote Date</label>
                    <input type="text" name="quote_date" class="form-control" value="{{ old('quote_date', $dignitary->quote_date) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Profile Link URL</label>
                    <input type="text" name="profile_link" class="form-control" value="{{ old('profile_link', $dignitary->profile_link) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $dignitary->sort_order) }}">
                </div>
                <div class="col-md-2 d-flex align-items-center mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" {{ $dignitary->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActive">Active</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.dignitaries.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Update Dignitary</button>
            </div>
        </form>
    </div>
</div>
@endsection
