@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">settings</span> Portal Configuration & Settings
        </h5>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 1. PORTAL IDENTITY & BRANDING (EMBLEM & LOGO UPLOAD) -->
            <h5 class="fw-bold mb-3" style="color: var(--cms-primary); border-bottom: 2px solid #e2e8f0; padding-bottom: 6px;">
                1. Portal Identity & Branding (State Emblem & Official Logo)
            </h5>
            <div class="row g-4 mb-4">
                <!-- State Emblem of India Upload -->
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light h-100" style="border-color: #ebd0de !important;">
                        <label class="form-label fw-bold d-flex align-items-center justify-content-between mb-2">
                            <span><i class="fa fa-shield-halved text-primary me-2"></i> State Emblem of India (Ashoka Lion Capital)</span>
                            @if(\App\Models\Setting::get('site_emblem'))
                                <span class="badge bg-success">Custom Uploaded</span>
                            @else
                                <span class="badge bg-secondary">Default Emblem</span>
                            @endif
                        </label>

                        <!-- Preview Area -->
                        <div class="d-flex align-items-center gap-3 my-3 p-3 bg-white border rounded">
                            <div class="border rounded p-2 bg-light d-flex align-items-center justify-content-center" style="width: 90px; height: 90px; flex-shrink: 0;">
                                @php
                                    $emblemUrl = \App\Models\Setting::get('site_emblem');
                                @endphp
                                @if($emblemUrl)
                                    <img src="{{ asset($emblemUrl) }}" alt="State Emblem" style="max-height: 80px; max-width: 80px; object-fit: contain;">
                                @else
                                    <img src="{{ asset('assets/images/header_emblem_logo.png') }}" alt="Default Emblem" style="max-height: 80px; max-width: 80px; object-fit: contain;">
                                @endif
                            </div>
                            <div class="flex-grow-1 small">
                                <div class="fw-semibold text-dark">Current State Emblem</div>
                                <div class="text-muted text-break">{{ $emblemUrl ? $emblemUrl : 'Using default built-in State Emblem' }}</div>
                                @if($emblemUrl)
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="remove_site_emblem" id="removeSiteEmblem" value="1">
                                        <label class="form-check-label text-danger fw-semibold" for="removeSiteEmblem">
                                            <i class="fa fa-trash-can me-1"></i> Remove custom emblem & restore default
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Upload Input -->
                        <label class="form-label fw-semibold small text-dark mb-1">Upload New Emblem Image</label>
                        <input type="file" name="site_emblem_file" class="form-control" accept="image/png,image/svg+xml,image/jpeg,image/webp">
                        <small class="text-muted d-block mt-1">Recommended: Transparent PNG or SVG vector (height ~80px). Used alongside header brand titles.</small>
                    </div>
                </div>

                <!-- Textiles Committee Official Logo Upload -->
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light h-100" style="border-color: #ebd0de !important;">
                        <label class="form-label fw-bold d-flex align-items-center justify-content-between mb-2">
                            <span><i class="fa fa-certificate text-danger me-2"></i> Textiles Committee Official Logo</span>
                            @if(\App\Models\Setting::get('site_logo'))
                                <span class="badge bg-success">Custom Uploaded</span>
                            @else
                                <span class="badge bg-secondary">Default Logo</span>
                            @endif
                        </label>

                        <!-- Preview Area -->
                        <div class="d-flex align-items-center gap-3 my-3 p-3 bg-white border rounded">
                            <div class="border rounded p-2 bg-light d-flex align-items-center justify-content-center" style="width: 90px; height: 90px; flex-shrink: 0;">
                                @php
                                    $logoUrl = \App\Models\Setting::get('site_logo');
                                @endphp
                                @if($logoUrl)
                                    <img src="{{ asset($logoUrl) }}" alt="Committee Logo" style="max-height: 80px; max-width: 80px; object-fit: contain;">
                                @else
                                    <img src="{{ asset('assets/images/Textiles_Committee_Logo.png') }}" alt="Default Logo" style="max-height: 80px; max-width: 80px; object-fit: contain;">
                                @endif
                            </div>
                            <div class="flex-grow-1 small">
                                <div class="fw-semibold text-dark">Current Official Logo</div>
                                <div class="text-muted text-break">{{ $logoUrl ? $logoUrl : 'Using default Textiles Committee logo' }}</div>
                                @if($logoUrl)
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="remove_site_logo" id="removeSiteLogo" value="1">
                                        <label class="form-check-label text-danger fw-semibold" for="removeSiteLogo">
                                            <i class="fa fa-trash-can me-1"></i> Remove custom logo & restore default
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Upload Input -->
                        <label class="form-label fw-semibold small text-dark mb-1">Upload New Logo Image</label>
                        <input type="file" name="site_logo_file" class="form-control" accept="image/png,image/svg+xml,image/jpeg,image/webp">
                        <small class="text-muted d-block mt-1">Recommended: Transparent PNG or SVG (height ~80px). Used in header, admin sidebar & document exports.</small>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-3" style="color: var(--cms-primary); border-bottom: 2px solid #e2e8f0; padding-bottom: 6px;">
                2. General Information
            </h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Site Name (English)</label>
                    <input type="text" name="site_title_en" class="form-control" value="{{ \App\Models\Setting::get('site_title_en') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Site Name (Hindi)</label>
                    <input type="text" name="site_title_hi" class="form-control" value="{{ \App\Models\Setting::get('site_title_hi') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tagline (English)</label>
                    <input type="text" name="site_tagline_en" class="form-control" value="{{ \App\Models\Setting::get('site_tagline_en') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tagline (Hindi)</label>
                    <input type="text" name="site_tagline_hi" class="form-control" value="{{ \App\Models\Setting::get('site_tagline_hi') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Visitor Counter Baseline</label>
                    <input type="number" name="visitor_count" class="form-control" value="{{ \App\Models\Setting::get('visitor_count', 8614226) }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">About Us Home Page Summary (First 300 characters shown with Read More)</label>
                    <textarea name="about_us_text_en" class="form-control" rows="3" placeholder="Enter concise overview narrative...">{{ \App\Models\Setting::get('about_us_text_en') }}</textarea>
                    <div class="form-text">This text will be gracefully truncated to 300 characters on the home page followed by a Read More button linking to History.</div>
                </div>
            </div>

            <h5 class="fw-bold mb-3" style="color: var(--cms-primary); border-bottom: 2px solid #e2e8f0; padding-bottom: 6px;">
                3. Contact Directory
            </h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Email</label>
                    <input type="email" name="contact_email" class="form-control" value="{{ \App\Models\Setting::get('contact_email') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Phone</label>
                    <input type="text" name="contact_phone" class="form-control" value="{{ \App\Models\Setting::get('contact_phone') }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Headquarters Address (English)</label>
                    <textarea name="contact_address_en" class="form-control" rows="2">{{ \App\Models\Setting::get('contact_address_en') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Headquarters Address (Hindi)</label>
                    <textarea name="contact_address_hi" class="form-control" rows="2">{{ \App\Models\Setting::get('contact_address_hi') }}</textarea>
                </div>
            </div>

            <h5 class="fw-bold mb-3" style="color: var(--cms-primary); border-bottom: 2px solid #e2e8f0; padding-bottom: 6px;">
                4. Social Media Handles
            </h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Twitter / X URL</label>
                    <input type="text" name="twitter_handle" class="form-control" value="{{ \App\Models\Setting::get('twitter_handle') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Facebook URL</label>
                    <input type="text" name="facebook_url" class="form-control" value="{{ \App\Models\Setting::get('facebook_url') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">YouTube URL</label>
                    <input type="text" name="youtube_url" class="form-control" value="{{ \App\Models\Setting::get('youtube_url') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Instagram URL</label>
                    <input type="text" name="instagram_url" class="form-control" value="{{ \App\Models\Setting::get('instagram_url') }}">
                </div>
            </div>

            <h5 class="fw-bold mb-3 mt-4" style="color: var(--cms-primary); border-bottom: 2px solid #e2e8f0; padding-bottom: 6px;">
                5. Government Sponsored Schemes & SAMARTH Statistics (Home Page)
            </h5>
            <div class="row g-3 mb-4">
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Section Title</label>
                    <input type="text" name="samarth_scheme_title" class="form-control" value="{{ \App\Models\Setting::get('samarth_scheme_title', 'Government Sponsored Schemes') }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Section Description</label>
                    <textarea name="samarth_scheme_desc" class="form-control" rows="2">{{ \App\Models\Setting::get('samarth_scheme_desc', 'The Ministry of Textiles, Government of India has designated the Textiles Committee as the Resource Support Agency (RSA) with the view to operate as technical arm for maintaining Quality in the process of implementation of the scheme SAMARTH.') }}</textarea>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Registrations</label>
                    <input type="text" name="stat_registrations" class="form-control" value="{{ \App\Models\Setting::get('stat_registrations', '29,379') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Handlooms covered</label>
                    <input type="text" name="stat_handlooms_covered" class="form-control" value="{{ \App\Models\Setting::get('stat_handlooms_covered', '968,018') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Active Assessors</label>
                    <input type="text" name="stat_active_assessors" class="form-control" value="{{ \App\Models\Setting::get('stat_active_assessors', '4,301') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Entry-level Trainees covered</label>
                    <input type="text" name="stat_entry_trainees_covered" class="form-control" value="{{ \App\Models\Setting::get('stat_entry_trainees_covered', '682,414') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Total Weavers</label>
                    <input type="text" name="stat_total_weavers" class="form-control" value="{{ \App\Models\Setting::get('stat_total_weavers', '21,245') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Societies</label>
                    <input type="text" name="stat_societies" class="form-control" value="{{ \App\Models\Setting::get('stat_societies', '5,867') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Origin Certificates issued</label>
                    <input type="text" name="stat_origin_certificates" class="form-control" value="{{ \App\Models\Setting::get('stat_origin_certificates', '67,381') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Lots Inspected</label>
                    <input type="text" name="stat_lots_inspected" class="form-control" value="{{ \App\Models\Setting::get('stat_lots_inspected', '112') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Exporters Registered under REX</label>
                    <input type="text" name="stat_exporters_rex" class="form-control" value="{{ \App\Models\Setting::get('stat_exporters_rex', '6,786') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Upskill Trainees covered</label>
                    <input type="text" name="stat_upskill_trainees" class="form-control" value="{{ \App\Models\Setting::get('stat_upskill_trainees', '25,220') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Labels issued PTL</label>
                    <input type="text" name="stat_labels_ptl" class="form-control" value="{{ \App\Models\Setting::get('stat_labels_ptl', '216,850,838') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Entry Level Trainees Assessed</label>
                    <input type="text" name="stat_trainees_assessed" class="form-control" value="{{ \App\Models\Setting::get('stat_trainees_assessed', '635,305') }}">
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <button type="submit" class="btn btn-cms-primary px-5 py-2 fs-6">
                    <i class="fa fa-save me-1"></i> Save All Settings & Branding
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
