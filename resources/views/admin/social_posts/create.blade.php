@extends('layouts.admin')

@section('title', 'Add New Social Media Post')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title d-flex align-items-center gap-2">
            <span class="material-symbols-outlined text-primary">add_link</span> Add New Social Media Post Link
        </h5>
        <a href="{{ route('admin.social-posts.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="cms-card-body p-4">
        <form action="{{ route('admin.social-posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <!-- Platform Selection -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Select Social Platform <span class="text-danger">*</span></label>
                    <select name="platform" class="form-select @error('platform') is-invalid @enderror" required id="platformSelect">
                        <option value="">-- Choose Platform --</option>
                        <option value="twitter" {{ old('platform') === 'twitter' ? 'selected' : '' }}>X (Twitter)</option>
                        <option value="youtube" {{ old('platform') === 'youtube' ? 'selected' : '' }}>YouTube</option>
                        <option value="facebook" {{ old('platform') === 'facebook' ? 'selected' : '' }}>Facebook</option>
                        <option value="instagram" {{ old('platform') === 'instagram' ? 'selected' : '' }}>Instagram</option>
                    </select>
                    @error('platform')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Post URL -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Post Link / URL <span class="text-danger">*</span></label>
                    <input type="url" name="post_url" class="form-control @error('post_url') is-invalid @enderror" placeholder="https://..." value="{{ old('post_url') }}" required id="postUrlInput">
                    <div class="form-text text-muted" id="urlHelperText">Paste the full URL to the tweet, YouTube video, Facebook post, or Instagram reel.</div>
                    @error('post_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Title / Headline -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title / Headline</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="e.g. Interaction Meeting with Union Minister" value="{{ old('title') }}">
                    <div class="form-text text-muted">Used as the video title for YouTube or bold headline for posts.</div>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Post Date -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Post Date / Timestamp</label>
                    <input type="text" name="post_date" class="form-control" placeholder="e.g. Aug 10, 2025 or 2 days ago" value="{{ old('post_date', date('M d, Y')) }}">
                </div>

                <!-- Post Content / Caption -->
                <div class="col-12">
                    <label class="form-label fw-semibold">Post Caption / Content</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="3" placeholder="Enter post text, description, or tweet message...">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Custom Media Image Upload -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Upload Image / Video Thumbnail</label>
                    <input type="file" name="media_image_file" class="form-control @error('media_image_file') is-invalid @enderror" accept="image/*">
                    <div class="form-text text-muted">Optional. For YouTube videos, thumbnail is automatically generated from the video URL if left empty.</div>
                    @error('media_image_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Display Order -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Display Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 1) }}" min="0">
                    <div class="form-text text-muted">Lower numbers show first.</div>
                </div>

                <!-- Status -->
                <div class="col-md-3 d-flex align-items-center mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" value="1" checked>
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
                                <input type="text" name="likes_count" class="form-control form-control-sm" placeholder="e.g. 142" value="{{ old('likes_count', '142') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Comments Count</label>
                                <input type="text" name="comments_count" class="form-control form-control-sm" placeholder="e.g. 18" value="{{ old('comments_count', '18') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Shares / Retweets Count</label>
                                <input type="text" name="shares_count" class="form-control form-control-sm" placeholder="e.g. 24" value="{{ old('shares_count', '24') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-12 mt-4 text-end">
                    <a href="{{ route('admin.social-posts.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-cms-primary">
                        <i class="fa fa-save me-1"></i> Save & Publish Post
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlInput = document.getElementById('postUrlInput');
    const platformSelect = document.getElementById('platformSelect');
    const titleInput = document.querySelector('input[name="title"]');
    const contentTextarea = document.querySelector('textarea[name="content"]');
    const urlHelper = document.getElementById('urlHelperText');

    let debounceTimer;

    function detectPlatform(url) {
        url = url.toLowerCase();
        if (url.includes('youtube.com') || url.includes('youtu.be')) return 'youtube';
        if (url.includes('twitter.com') || url.includes('x.com')) return 'twitter';
        if (url.includes('facebook.com') || url.includes('fb.watch') || url.includes('fb.com')) return 'facebook';
        if (url.includes('instagram.com')) return 'instagram';
        return '';
    }

    urlInput.addEventListener('input', function() {
        const url = this.value.trim();
        const detected = detectPlatform(url);
        if (detected) {
            platformSelect.value = detected;
            urlHelper.innerHTML = `<span class="text-success"><i class="fa-solid fa-check-circle me-1"></i> Auto-detected: <strong>${detected.toUpperCase()}</strong></span>`;
        }

        clearTimeout(debounceTimer);
        if (url && (url.startsWith('http://') || url.startsWith('https://'))) {
            urlHelper.innerHTML = `<span class="text-muted"><i class="fa-solid fa-spinner fa-spin me-1"></i> Fetching details automatically...</span>`;
            debounceTimer = setTimeout(() => {
                fetch(`{{ route('admin.social-posts.fetch-metadata') }}?url=${encodeURIComponent(url)}`)
                    .then(r => r.json())
                    .then(res => {
                        if (res.success && res.data) {
                            if (res.data.platform && !platformSelect.value) {
                                platformSelect.value = res.data.platform;
                            }
                            if (!titleInput.value && res.data.title) {
                                titleInput.value = res.data.title;
                            }
                            if (!contentTextarea.value && res.data.content) {
                                contentTextarea.value = res.data.content;
                            }
                            urlHelper.innerHTML = `<span class="text-success"><i class="fa-solid fa-wand-magic-sparkles me-1"></i> Post information fetched automatically!</span>`;
                        }
                    })
                    .catch(() => {
                        urlHelper.innerHTML = `<span class="text-success"><i class="fa-solid fa-check-circle me-1"></i> Ready to publish.</span>`;
                    });
            }, 600);
        }
    });
});
</script>
@endsection
