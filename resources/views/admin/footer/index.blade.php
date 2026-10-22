@extends('layouts.admin')

@section('title', 'Footer Management')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color: #500a2f;">Footer Management</h4>
        <small class="text-muted">Manage the 4-column useful links, social media handles, national portal badges, and footer bottom legal text.</small>
    </div>

    <div class="d-flex align-items-center gap-2">
        <a href="{{ url('/') }}#footerContact" target="_blank" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">open_in_new</span>
            <span>Preview Footer</span>
        </a>
    </div>
</div>

<form action="{{ route('admin.footer.update') }}" method="POST">
    @csrf

    <!-- SECTION 1: Useful Links (4-Column Layout) -->
    <div class="cms-card mb-4">
        <div class="cms-card-header d-flex align-items-center justify-content-between">
            <h5 class="cms-card-title mb-0">
                <span class="material-symbols-outlined text-primary">link</span>
                <span>Useful Links (4-Column Grid)</span>
            </h5>
            <button type="button" class="btn btn-sm text-white" id="btnAddLink" style="background: #6c1340;">
                <i class="fa fa-plus me-1"></i> Add Footer Link
            </button>
        </div>
        <div class="cms-card-body">
            <p class="text-muted small mb-3">
                Links are grouped into 4 columns under <strong>USEFUL LINKS</strong>, matching the official Textiles Committee footer layout.
            </p>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="linksTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 25%;">Link Title</th>
                            <th style="width: 35%;">URL or Route</th>
                            <th style="width: 15%;">Column</th>
                            <th style="width: 12%;">Target</th>
                            <th style="width: 8%;" class="text-center">Active</th>
                            <th style="width: 5%;" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="linksTbody">
                        @foreach($links as $index => $link)
                            <tr class="link-row">
                                <td>
                                    <input type="text" name="link_titles[]" class="form-control form-control-sm fw-semibold" value="{{ $link['title'] ?? '' }}" required placeholder="e.g. Archives">
                                </td>
                                <td>
                                    <input type="text" name="link_urls[]" class="form-control form-control-sm" value="{{ $link['url'] ?? '' }}" required placeholder="e.g. /page/reports-budget or #feedbackModal">
                                </td>
                                <td>
                                    <select name="link_cols[]" class="form-select form-select-sm">
                                        <option value="1" {{ ($link['col'] ?? 1) == 1 ? 'selected' : '' }}>Column 1</option>
                                        <option value="2" {{ ($link['col'] ?? 1) == 2 ? 'selected' : '' }}>Column 2</option>
                                        <option value="3" {{ ($link['col'] ?? 1) == 3 ? 'selected' : '' }}>Column 3</option>
                                        <option value="4" {{ ($link['col'] ?? 1) == 4 ? 'selected' : '' }}>Column 4</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="link_targets[]" class="form-select form-select-sm">
                                        <option value="_self" {{ ($link['target'] ?? '_self') === '_self' ? 'selected' : '' }}>Same Tab (_self)</option>
                                        <option value="_blank" {{ ($link['target'] ?? '_self') === '_blank' ? 'selected' : '' }}>New Tab (_blank)</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <input type="hidden" name="link_actives[{{ $index }}]" value="0">
                                    <div class="form-check form-switch d-inline-block">
                                        <input class="form-check-input" type="checkbox" name="link_actives[{{ $index }}]" value="1" {{ !empty($link['is_active']) ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-delete-row" title="Delete Link">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SECTION 2: Social Media Handles & National Badges -->
    <div class="row g-4 mb-4">
        <!-- Social Media Channels -->
        <div class="col-lg-6">
            <div class="cms-card h-100">
                <div class="cms-card-header">
                    <h5 class="cms-card-title mb-0">
                        <span class="material-symbols-outlined text-danger">share</span>
                        <span>Social Media Channels (Subscribe For Updates)</span>
                    </h5>
                </div>
                <div class="cms-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">
                            <i class="fa-brands fa-x-twitter me-1"></i> Twitter / X Handle URL
                        </label>
                        <input type="text" name="twitter_handle" class="form-control" value="{{ $twitter }}" placeholder="https://x.com/TexMinIndia">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">
                            <i class="fa-brands fa-youtube me-1 text-danger"></i> YouTube Channel URL
                        </label>
                        <input type="text" name="youtube_url" class="form-control" value="{{ $youtube }}" placeholder="https://youtube.com/@ministryoftextiles">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">
                            <i class="fa-brands fa-facebook-f me-1 text-primary"></i> Facebook Page URL
                        </label>
                        <input type="text" name="facebook_url" class="form-control" value="{{ $facebook }}" placeholder="https://facebook.com/TexMinIndia">
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold small">
                            <i class="fa-brands fa-instagram me-1" style="color: #e1306c;"></i> Instagram Profile URL
                        </label>
                        <input type="text" name="instagram_url" class="form-control" value="{{ $instagram }}" placeholder="https://instagram.com/ministryoftextiles">
                    </div>
                </div>
            </div>
        </div>

        <!-- National Portal Badges & Features -->
        <div class="col-lg-6">
            <div class="cms-card h-100">
                <div class="cms-card-header">
                    <h5 class="cms-card-title mb-0">
                        <span class="material-symbols-outlined text-success">verified</span>
                        <span>Government Badges &amp; Controls</span>
                    </h5>
                </div>
                <div class="cms-card-body">
                    <!-- MyGov Badge -->
                    <div class="p-3 mb-3 border rounded bg-light">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/images/mygov_badge_exact.png') }}" alt="MyGov" height="22" class="border">
                                <strong class="small">MyGov Badge (मेरी सरकार)</strong>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="mygov_enabled" value="1" {{ $mygovEnabled == '1' ? 'checked' : '' }}>
                            </div>
                        </div>
                        <input type="url" name="mygov_url" class="form-control form-control-sm" value="{{ $mygovUrl }}" placeholder="https://www.mygov.in/">
                    </div>

                    <!-- India.gov.in Badge -->
                    <div class="p-3 mb-3 border rounded bg-light">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/images/indiagov_badge_exact.png') }}" alt="India.gov.in" height="22" class="border">
                                <strong class="small">National Portal Badge (india.gov.in)</strong>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="indiagov_enabled" value="1" {{ $indiagovEnabled == '1' ? 'checked' : '' }}>
                            </div>
                        </div>
                        <input type="url" name="indiagov_url" class="form-control form-control-sm" value="{{ $indiagovUrl }}" placeholder="https://www.india.gov.in/">
                    </div>

                    <!-- Back to Top Button -->
                    <div class="p-3 border rounded bg-light d-flex align-items-center justify-content-between">
                        <div>
                            <strong class="d-block small">Back to Top Scroll Button (↑)</strong>
                            <small class="text-muted">Displays round button on the right for one-click smooth scrolling to top.</small>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="footer_scroll_top_enabled" value="1" {{ $scrollTopEnabled == '1' ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 3: Legal Copyright & Last Updated Date -->
    <div class="cms-card mb-4">
        <div class="cms-card-header">
            <h5 class="cms-card-title mb-0">
                <span class="material-symbols-outlined text-warning">copyright</span>
                <span>Footer Bottom Bar &amp; Last Updated Date</span>
            </h5>
        </div>
        <div class="cms-card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Copyright / Ownership Statement (English)</label>
                    <input type="text" name="footer_copyright_en" class="form-control" value="{{ $copyrightEn }}" required>
                    <div class="form-text">As shown in reference image: "This Website belong to Ministry of Textiles, Government of India"</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Copyright Statement (Hindi)</label>
                    <input type="text" name="footer_copyright_hi" class="form-control" value="{{ $copyrightHi }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Last Updated Date Mode</label>
                    <select name="footer_updated_mode" class="form-select" id="dateModeSelect">
                        <option value="auto" {{ $dateMode === 'auto' ? 'selected' : '' }}>Automatic (Always shows current date dynamically)</option>
                        <option value="custom" {{ $dateMode === 'custom' ? 'selected' : '' }}>Custom Fixed Date</option>
                    </select>
                </div>

                <div class="col-md-6" id="customDateWrap" style="{{ $dateMode === 'custom' ? '' : 'display: none;' }}">
                    <label class="form-label fw-semibold small">Custom Date (DD.MM.YYYY)</label>
                    <input type="text" name="footer_custom_date" class="form-control" value="{{ $customDate }}" placeholder="21.04.2026">
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Button Bar -->
    <div class="d-flex align-items-center justify-content-end gap-2 mb-5">
        <button type="submit" class="btn text-white fw-bold px-5 py-2 fs-6 shadow-sm" style="background: #6c1340; border-radius: 6px;">
            <i class="fa fa-save me-1"></i> Save Footer Settings
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('linksTbody');
    const btnAdd = document.getElementById('btnAddLink');
    const dateModeSelect = document.getElementById('dateModeSelect');
    const customDateWrap = document.getElementById('customDateWrap');

    dateModeSelect.addEventListener('change', function() {
        customDateWrap.style.display = this.value === 'custom' ? 'block' : 'none';
    });

    tbody.addEventListener('click', function(e) {
        if (e.target.closest('.btn-delete-row')) {
            const rows = tbody.querySelectorAll('.link-row');
            if (rows.length > 1) {
                e.target.closest('.link-row').remove();
            } else {
                alert('At least one footer link is required.');
            }
        }
    });

    btnAdd.addEventListener('click', function() {
        const nextIndex = tbody.querySelectorAll('.link-row').length;
        const tr = document.createElement('tr');
        tr.className = 'link-row';
        tr.innerHTML = `
            <td>
                <input type="text" name="link_titles[]" class="form-control form-control-sm fw-semibold" required placeholder="Link title">
            </td>
            <td>
                <input type="text" name="link_urls[]" class="form-control form-control-sm" required placeholder="/page/slug or URL">
            </td>
            <td>
                <select name="link_cols[]" class="form-select form-select-sm">
                    <option value="1">Column 1</option>
                    <option value="2">Column 2</option>
                    <option value="3">Column 3</option>
                    <option value="4" selected>Column 4</option>
                </select>
            </td>
            <td>
                <select name="link_targets[]" class="form-select form-select-sm">
                    <option value="_self" selected>Same Tab (_self)</option>
                    <option value="_blank">New Tab (_blank)</option>
                </select>
            </td>
            <td class="text-center">
                <input type="hidden" name="link_actives[${nextIndex}]" value="0">
                <div class="form-check form-switch d-inline-block">
                    <input class="form-check-input" type="checkbox" name="link_actives[${nextIndex}]" value="1" checked>
                </div>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-outline-danger btn-sm btn-delete-row" title="Delete Link">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
});
</script>
@endsection
