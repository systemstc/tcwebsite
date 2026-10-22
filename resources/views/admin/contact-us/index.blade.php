@extends('layouts.admin')

@section('title', 'Contact Us Management')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color: #500a2f;">Contact Us Management</h4>
        <small class="text-muted">Manage central headquarters information, Web Information Manager (WIM), CISO, and interactive map embed.</small>
    </div>

    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">mail</span>
            <span>Citizen Inquiries ({{ $stats['new_inquiries'] }} New)</span>
        </a>

        <a href="{{ url('/page/contact-us') }}" target="_blank" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">open_in_new</span>
            <span>View Public Page</span>
        </a>
    </div>
</div>

<!-- Quick Statistics Bar -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-md-4">
        <div class="card border shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Total Inquiries Received</div>
                    <div class="fs-4 fw-bold text-dark">{{ $stats['total_inquiries'] }}</div>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 8px; background: #fdf7fa; color: #6c1340; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined fs-4">inbox</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="card border shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">New / Unaddressed Inquiries</div>
                    <div class="fs-4 fw-bold text-danger">{{ $stats['new_inquiries'] }}</div>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 8px; background: #fff1f2; color: #e11d48; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined fs-4">mark_email_unread</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="card border shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Answered / Resolved</div>
                    <div class="fs-4 fw-bold text-success">{{ $stats['replied_inquiries'] }}</div>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 8px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined fs-4">check_circle</span>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('admin.contact-us.update') }}" method="POST">
    @csrf

    <!-- SECTION 1: Visionbox & Introduction Text -->
    <div class="cms-card mb-4">
        <div class="cms-card-header">
            <h5 class="cms-card-title mb-0">
                <span class="material-symbols-outlined text-primary">visibility</span>
                <span>Sidebar Vision Card &amp; Page Introduction</span>
            </h5>
        </div>
        <div class="cms-card-body">
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-semibold small">Visionbox Text (English - Left Grey Box)</label>
                    <textarea name="contact_vision_en" class="form-control" rows="2" required>{{ $data['contact_vision_en'] }}</textarea>
                    <div class="form-text">Displayed prominently in the sticky grey sidebar (.visionbox) on the left side of the Contact Us page.</div>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold small">Main Content Introductory Narrative</label>
                    <textarea name="contact_intro_en" class="form-control" rows="3" required>{{ $data['contact_intro_en'] }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: Central Headquarters Address -->
    <div class="cms-card mb-4">
        <div class="cms-card-header">
            <h5 class="cms-card-title mb-0">
                <span class="material-symbols-outlined text-danger">location_on</span>
                <span>Central Headquarters &amp; Communication Details</span>
            </h5>
        </div>
        <div class="cms-card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Ministry / Parent Authority</label>
                    <input type="text" name="contact_ministry_en" class="form-control" value="{{ $data['contact_ministry_en'] }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Organization Name</label>
                    <input type="text" name="contact_org_name_en" class="form-control" value="{{ $data['contact_org_name_en'] }}" required>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold small">Physical Head Office Address</label>
                    <textarea name="contact_address_en" class="form-control" rows="2" required>{{ $data['contact_address_en'] }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">EPABX Helpline Phone(s)</label>
                    <input type="text" name="contact_phone" class="form-control" value="{{ $data['contact_phone'] }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Secretary Direct Line</label>
                    <input type="text" name="contact_secretary_phone" class="form-control" value="{{ $data['contact_secretary_phone'] }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Official Email Address</label>
                    <input type="email" name="contact_email" class="form-control" value="{{ $data['contact_email'] }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Office Working Hours</label>
                    <input type="text" name="contact_hours" class="form-control" value="{{ $data['contact_hours'] }}" required>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 3: WIM & CISO Designated Officers (Image 1 Style) -->
    <div class="row g-4 mb-4">
        <!-- Web Information Manager (WIM) -->
        <div class="col-lg-6">
            <div class="cms-card h-100">
                <div class="cms-card-header">
                    <h5 class="cms-card-title mb-0">
                        <span class="material-symbols-outlined text-primary">badge</span>
                        <span>Web Information Manager (WIM)</span>
                    </h5>
                </div>
                <div class="cms-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Officer Name</label>
                        <input type="text" name="wim_name" class="form-control" value="{{ $data['wim_name'] }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Designation</label>
                        <input type="text" name="wim_designation" class="form-control" value="{{ $data['wim_designation'] }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Office Address</label>
                        <textarea name="wim_address" class="form-control" rows="2" required>{{ $data['wim_address'] }}</textarea>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Telephone</label>
                            <input type="text" name="wim_phone" class="form-control" value="{{ $data['wim_phone'] }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Email Address</label>
                            <input type="text" name="wim_email" class="form-control" value="{{ $data['wim_email'] }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chief Information Security Officer (CISO) -->
        <div class="col-lg-6">
            <div class="cms-card h-100">
                <div class="cms-card-header">
                    <h5 class="cms-card-title mb-0">
                        <span class="material-symbols-outlined text-success">security</span>
                        <span>Chief Information Security Officer (CISO)</span>
                    </h5>
                </div>
                <div class="cms-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Officer Name</label>
                        <input type="text" name="ciso_name" class="form-control" value="{{ $data['ciso_name'] }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Designation</label>
                        <input type="text" name="ciso_designation" class="form-control" value="{{ $data['ciso_designation'] }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Administrative Role</label>
                        <input type="text" name="ciso_role" class="form-control" value="{{ $data['ciso_role'] }}" required placeholder="e.g. Administrative Owner (CIO)">
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold small">Office Address</label>
                        <textarea name="ciso_address" class="form-control" rows="2" required>{{ $data['ciso_address'] }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 4: Google Map Embed -->
    <div class="cms-card mb-4">
        <div class="cms-card-header">
            <h5 class="cms-card-title mb-0">
                <span class="material-symbols-outlined text-info">map</span>
                <span>Google Map Embed Configuration</span>
            </h5>
        </div>
        <div class="cms-card-body">
            <div class="mb-3">
                <label class="form-label fw-semibold small">Google Maps Embed URL (iframe src)</label>
                <input type="text" name="contact_map_url" class="form-control" value="{{ $data['contact_map_url'] }}" required>
                <div class="form-text">Paste the <code>src</code> attribute from Google Maps Share &rarr; Embed a map.</div>
            </div>

            <div class="ratio ratio-21x9 rounded overflow-hidden border shadow-sm" style="max-height: 240px;">
                <iframe src="{{ $data['contact_map_url'] }}" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="d-flex align-items-center justify-content-end gap-2 mb-5">
        <button type="submit" class="btn text-white fw-bold px-5 py-2 fs-6 shadow-sm" style="background: #6c1340; border-radius: 6px;">
            <i class="fa fa-save me-1"></i> Save &amp; Sync Contact Us Page
        </button>
    </div>
</form>
@endsection
