@extends('layouts.admin')

@section('title', 'Add Dignitary')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-danger">person_add</span> New Dignitary Details
        </h5>
        <a href="{{ route('admin.dignitaries.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.dignitaries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Name (English) <span class="text-danger">*</span></label>
                    <input type="text" name="name_en" class="form-control" required placeholder="e.g. Shri Giriraj Singh">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Name (Hindi)</label>
                    <input type="text" name="name_hi" class="form-control" placeholder="Enter Hindi text (optional)">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Designation (English) <span class="text-danger">*</span></label>
                    <input type="text" name="designation_en" class="form-control" required placeholder="e.g. Hon'ble Minister of Textiles">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Designation (Hindi)</label>
                    <input type="text" name="designation_hi" class="form-control" placeholder="Enter Hindi text (optional)">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Category (Type) <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required>
                        <option value="minister">Union Minister (Cabinet / MoS)</option>
                        <option value="prime_minister">Prime Minister</option>
                        <option value="secretary">Secretary</option>
                        <option value="official">Senior Official</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Upload Photo File</label>
                    <input type="file" name="photo_file" class="form-control" accept="image/*">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Or Photo Path</label>
                    <input type="text" name="photo_url" class="form-control" value="assets/images/giriraj_singh.png">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Message / Quote (English)</label>
                    <textarea name="quote_en" class="form-control" rows="2" placeholder="Message or quote in English..."></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Message / Quote (Hindi)</label>
                    <textarea name="quote_hi" class="form-control" rows="2" placeholder="Enter Hindi text (optional)"></textarea>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Quote Date</label>
                    <input type="text" name="quote_date" class="form-control" placeholder="13.04.2024">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Profile Link URL</label>
                    <input type="text" name="profile_link" class="form-control" value="#">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="0">
                </div>
                <div class="col-md-2 d-flex align-items-center mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                        <label class="form-check-label fw-semibold" for="isActive">Active</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.dignitaries.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Save Dignitary</button>
            </div>
        </form>
    </div>
</div>
@endsection
