@extends('layouts.admin')

@section('title', 'Add New Banner')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-danger">add_photo_alternate</span> New Banner Details
        </h5>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (In English)</label>
                    <input type="text" name="title_en" class="form-control" value="{{ old('title_en') }}" placeholder="e.g. 12th National Handloom Day - 2026">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (In Hindi)</label>
                    <input type="text" name="title_hi" class="form-control" value="{{ old('title_hi') }}" placeholder="Enter Hindi text (optional)">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Subtitle (In English)</label>
                    <input type="text" name="subtitle_en" class="form-control" value="{{ old('subtitle_en') }}" placeholder="Short subtitle">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Subtitle (In Hindi)</label>
                    <input type="text" name="subtitle_hi" class="form-control" value="{{ old('subtitle_hi') }}" placeholder="Enter Hindi text (optional)">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Upload Image File</label>
                    <input type="file" name="image_file" class="form-control" accept="image/*">
                    <small class="text-muted">Standard size: 1920x600 or 1500x550 pixels (JPG, PNG, WebP)</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Or Image Asset Path</label>
                    <input type="text" name="image_url" class="form-control" value="assets/images/BANNER-1-1.png" placeholder="assets/images/BANNER-1-1.png">
                </div>

                <!-- Banner Image Fitting / Display Mode -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined text-primary" style="font-size: 20px;">aspect_ratio</span> 
                        Banner Image Fitting Option
                    </label>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="border rounded p-3 bg-light h-100">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="display_mode" id="modeContain" value="contain" {{ old('display_mode') === 'contain' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-dark" for="modeContain">
                                        Fit Full Image (Contain)
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <strong>Best for Flyers & Posters!</strong> Displays 100% of the image without any cropping. Fills sides with a smooth ambient backdrop.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3 bg-light h-100">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="display_mode" id="modeCover" value="cover" {{ old('display_mode', 'cover') === 'cover' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-dark" for="modeCover">
                                        Crop to Fill (Cover)
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <strong>Default for Wide Banners.</strong> Fills the entire slider edge-to-edge. Ideal for landscape panoramas (~1920x600).
                                </small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3 bg-light h-100">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="display_mode" id="modeFill" value="fill" {{ old('display_mode') === 'fill' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-dark" for="modeFill">
                                        Stretch to Fill (Stretch)
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    Forces the graphic to stretch across 100% width and 100% height of the slider.
                                </small>
                            </div>
                        </div>
                    </div>
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
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                        <label class="form-check-label fs-6 fw-semibold" for="isActive">Active</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Save Banner</button>
            </div>
        </form>
    </div>
</div>
@endsection
