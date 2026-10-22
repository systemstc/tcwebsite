@extends('layouts.admin')

@section('title', 'Edit Social Media Post')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title d-flex align-items-center gap-2">
            <span class="material-symbols-outlined text-primary">edit</span> Edit {{ $socialPost->getPlatformLabel() }} Post
        </h5>
        <a href="{{ route('admin.social-posts.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="cms-card-body p-4">
        <form action="{{ route('admin.social-posts.update', $socialPost->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <!-- Platform Selection -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Social Platform <span class="text-danger">*</span></label>
                    <select name="platform" class="form-select @error('platform') is-invalid @enderror" required>
                        <option value="twitter" {{ old('platform', $socialPost->platform) === 'twitter' ? 'selected' : '' }}>X (Twitter)</option>
                        <option value="youtube" {{ old('platform', $socialPost->platform) === 'youtube' ? 'selected' : '' }}>YouTube</option>
                        <option value="facebook" {{ old('platform', $socialPost->platform) === 'facebook' ? 'selected' : '' }}>Facebook</option>
                        <option value="instagram" {{ old('platform', $socialPost->platform) === 'instagram' ? 'selected' : '' }}>Instagram</option>
                    </select>
                    @error('platform')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Post URL -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Post Link / URL <span class="text-danger">*</span></label>
                    <input type="url" name="post_url" class="form-control @error('post_url') is-invalid @enderror" value="{{ old('post_url', $socialPost->post_url) }}" required>
                    <div class="form-text text-muted">The destination link when users click on this post or play button.</div>
                    @error('post_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Title / Headline -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title / Headline</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $socialPost->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Post Date -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Post Date / Timestamp</label>
                    <input type="text" name="post_date" class="form-control" value="{{ old('post_date', $socialPost->post_date) }}">
                </div>

                <!-- Post Content / Caption -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Post Caption / Content</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="3">{{ old('content', $socialPost->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Current Image & Upload -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Upload Image / Thumbnail</label>
                    @if($socialPost->media_image)
                        <div class="mb-2 d-flex align-items-center gap-2">
                            <img src="{{ $socialPost->getDisplayImage() }}" alt="Current" style="height: 60px; width: 90px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;">
                            <small class="text-muted">Current Thumbnail</small>
                        </div>
                    @endif
                    <input type="file" name="media_image_file" class="form-control @error('media_image_file') is-invalid @enderror" accept="image/*">
                    <div class="form-text text-muted">Leave empty to keep existing image or auto YouTube thumbnail.</div>
                    @error('media_image_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Display Order -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Display Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $socialPost->sort_order) }}" min="0">
                </div>

                <!-- Status -->
                <div class="col-md-3 d-flex align-items-center mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" value="1" {{ $socialPost->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActiveSwitch">Active (Show on Home)</label>
                    </div>
                </div>

                <!-- Optional Details Collapsible -->
                <div class="col-12 mt-3">
                    <div class="card bg-light border p-3">
                        <h6 class="fw-bold mb-2 text-dark">Additional Metrics (Optional)</h6>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label small">Likes Count</label>
                                <input type="text" name="likes_count" class="form-control form-control-sm" value="{{ old('likes_count', $socialPost->likes_count) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Comments Count</label>
                                <input type="text" name="comments_count" class="form-control form-control-sm" value="{{ old('comments_count', $socialPost->comments_count) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Shares / Retweets Count</label>
                                <input type="text" name="shares_count" class="form-control form-control-sm" value="{{ old('shares_count', $socialPost->shares_count) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-12 mt-4 text-end">
                    <a href="{{ route('admin.social-posts.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-cms-primary">
                        <i class="fa fa-save me-1"></i> Update Post
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
