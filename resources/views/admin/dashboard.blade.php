@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')

    <!-- Top Metric Widgets -->
    <div class="row g-3 mb-4">
        <!-- Banners Widget -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 rounded-3" style="border-left: 4px solid #721835 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Banners & Sliders</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $stats['banners'] }}</div>
                    </div>
                    <div class="bg-light p-3 rounded-circle text-danger">
                        <span class="material-symbols-outlined fs-2">view_carousel</span>
                    </div>
                </div>
                <a href="{{ route('admin.banners.index') }}" class="small text-danger fw-semibold mt-2 d-inline-block text-decoration-none">
                    Manage Banners &rarr;
                </a>
            </div>
        </div>

        <!-- Schemes Widget -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 rounded-3" style="border-left: 4px solid #0284c7 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Schemes & Services</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $stats['schemes'] }}</div>
                    </div>
                    <div class="bg-light p-3 rounded-circle text-primary">
                        <span class="material-symbols-outlined fs-2">verified</span>
                    </div>
                </div>
                <a href="{{ route('admin.schemes.index') }}" class="small text-primary fw-semibold mt-2 d-inline-block text-decoration-none">
                    Manage Schemes &rarr;
                </a>
            </div>
        </div>

        <!-- Tenders Widget -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 rounded-3" style="border-left: 4px solid #16a34a !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Tenders & Vacancies</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $stats['tenders'] }}</div>
                    </div>
                    <div class="bg-light p-3 rounded-circle text-success">
                        <span class="material-symbols-outlined fs-2">gavel</span>
                    </div>
                </div>
                <a href="{{ route('admin.tenders.index') }}" class="small text-success fw-semibold mt-2 d-inline-block text-decoration-none">
                    Manage Tenders &rarr;
                </a>
            </div>
        </div>

        <!-- Inquiries Widget -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 rounded-3" style="border-left: 4px solid #ea580c !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Feedback & Inquiries</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $stats['inquiries'] }}</div>
                    </div>
                    <div class="bg-light p-3 rounded-circle text-warning">
                        <span class="material-symbols-outlined fs-2">mail</span>
                    </div>
                </div>
                <a href="{{ route('admin.inquiries.index') }}" class="small text-warning fw-semibold mt-2 d-inline-block text-decoration-none">
                    {{ $stats['new_inquiries'] }} New Messages &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Visitor & Bhashini Multi-Language Intelligence (Live Analytics) -->
    <div class="card border-0 shadow-sm rounded-3 mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #faf8fc 100%);">
        <div class="card-header bg-transparent py-3 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary px-2 py-1">Govt. Official</span>
                    <span class="badge bg-success px-2 py-1"><i class="fa fa-language me-1"></i> Bhashini Enabled</span>
                </div>
                <h5 class="fw-bold mb-0 text-dark mt-2 d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-danger">analytics</span>
                    Visitor Intelligence & Bhashini Multi-Language Analytics
                </h5>
                <small class="text-muted">Domain: <strong>textilescommittee.gov.in</strong> | Real-time citizen access metrics across India</small>
            </div>
            <a href="{{ route('admin.analytics.index') }}" class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1 fw-semibold">
                <span>View Full Analytics Portal</span>
                <span class="material-symbols-outlined fs-6">arrow_forward</span>
            </a>
        </div>
        <div class="card-body p-4">
            <!-- Analytics KPI Badges -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="p-3 bg-white border rounded-3 shadow-xs">
                        <span class="text-muted small text-uppercase fw-semibold">Total Page Views</span>
                        <div class="fs-3 fw-bold text-dark mt-1">{{ number_format($analyticsStats['total_views']) }}</div>
                        <small class="text-success fw-semibold"><i class="fa fa-check-circle me-1"></i> All portal traffic</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 bg-white border rounded-3 shadow-xs">
                        <span class="text-muted small text-uppercase fw-semibold">Unique Citizens (IPs)</span>
                        <div class="fs-3 fw-bold text-primary mt-1">{{ number_format($analyticsStats['unique_visitors']) }}</div>
                        <small class="text-muted">Unique visitors tracked</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 bg-white border rounded-3 shadow-xs">
                        <span class="text-muted small text-uppercase fw-semibold">Bhashini Translations</span>
                        <div class="fs-3 fw-bold text-success mt-1">{{ number_format($analyticsStats['bhashini_hits']) }}</div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                            {{ $analyticsStats['bhashini_percent'] }}% Multi-language Share
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 bg-white border rounded-3 shadow-xs">
                        <span class="text-muted small text-uppercase fw-semibold">Portal Footfall Counter</span>
                        <div class="fs-3 fw-bold text-secondary mt-1">{{ number_format($stats['visitor_count']) }}</div>
                        <small class="text-muted">NIC official counter</small>
                    </div>
                </div>
            </div>

            <!-- Top Visited Pages & Language Distribution Snapshot -->
            <div class="row g-4">
                <!-- Most Visited Pages -->
                <div class="col-lg-7">
                    <div class="p-3 bg-white border rounded-3 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold text-dark d-flex align-items-center gap-2">
                                <span class="material-symbols-outlined text-primary fs-5">leaderboard</span>
                                Most Visited Pages
                            </span>
                            <a href="{{ route('admin.analytics.index') }}" class="small text-decoration-none">Full Ranking &rarr;</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless m-0 align-middle">
                                <tbody>
                                    @forelse($topPages as $idx => $p)
                                        @php
                                            $share = $analyticsStats['total_views'] > 0 ? round(($p->total_views / $analyticsStats['total_views']) * 100, 1) : 0;
                                        @endphp
                                        <tr class="border-bottom">
                                            <td style="width: 25px;" class="text-muted fw-bold">{{ $idx + 1 }}.</td>
                                            <td>
                                                <div class="fw-semibold text-dark text-truncate" style="max-width: 260px;" title="{{ $p->page_title }}">
                                                    {{ $p->page_title ?: 'Home' }}
                                                </div>
                                                <span class="font-monospace small text-muted">{{ $p->path ?: '/' }}</span>
                                            </td>
                                            <td class="text-end fw-bold text-dark">{{ number_format($p->total_views) }}</td>
                                            <td style="width: 90px;">
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar bg-primary" style="width: {{ $share }}%"></div>
                                                </div>
                                                <div class="small text-muted text-end" style="font-size: 10px;">{{ $share }}%</div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-muted small">No data yet</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Citizen Languages Access Breakdown -->
                <div class="col-lg-5">
                    <div class="p-3 bg-white border rounded-3 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold text-dark d-flex align-items-center gap-2">
                                <span class="material-symbols-outlined text-success fs-5">translate</span>
                                Languages Used (Bhashini)
                            </span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Regional</span>
                        </div>
                        @forelse($topLanguages as $lang)
                            @php
                                $langObj = \App\Models\SiteAnalytic::getLanguageMeta($lang->lang);
                                $lpct = $analyticsStats['total_views'] > 0 ? round(($lang->views / $analyticsStats['total_views']) * 100, 1) : 0;
                            @endphp
                            <div class="mb-2 pb-2 border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-semibold text-dark small">
                                        {{ $langObj['name'] }} <span class="text-muted">({{ $langObj['native'] }})</span>
                                    </span>
                                    <span class="small fw-bold">{{ number_format($lang->views) }} <span class="text-muted fw-normal">({{ $lpct }}%)</span></span>
                                </div>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-success" style="width: {{ $lpct }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small m-0">No language data recorded yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Navigation Shortcuts -->
    <div class="cms-card mb-4">
        <div class="cms-card-header">
            <h5 class="cms-card-title">
                <span class="material-symbols-outlined text-primary">touch_app</span> Quick Actions
            </h5>
        </div>
        <div class="cms-card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <a href="{{ route('admin.banners.create') }}" class="btn btn-outline-dark w-100 p-3 text-start d-flex align-items-center gap-3">
                        <span class="material-symbols-outlined text-danger fs-3">add_photo_alternate</span>
                        <div>
                            <div class="fw-bold">Add Banner</div>
                            <small class="text-muted">Upload slider image</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.announcements.create') }}" class="btn btn-outline-dark w-100 p-3 text-start d-flex align-items-center gap-3">
                        <span class="material-symbols-outlined text-primary fs-3">add_alert</span>
                        <div>
                            <div class="fw-bold">Add Announcement</div>
                            <small class="text-muted">New ticker notification</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.tenders.create') }}" class="btn btn-outline-dark w-100 p-3 text-start d-flex align-items-center gap-3">
                        <span class="material-symbols-outlined text-success fs-3">post_add</span>
                        <div>
                            <div class="fw-bold">Post Tender / Vacancy</div>
                            <small class="text-muted">With PDF and deadline</small>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.documents.create') }}" class="btn btn-outline-dark w-100 p-3 text-start d-flex align-items-center gap-3">
                        <span class="material-symbols-outlined text-warning fs-3">upload_file</span>
                        <div>
                            <div class="fw-bold">Upload Document</div>
                            <small class="text-muted">Gazette, report or circular</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Logs & Recent Inquiries -->
    <div class="row g-4">
        <!-- Recent Feedback -->
        <div class="col-lg-6">
            <div class="cms-card h-100">
                <div class="cms-card-header">
                    <h5 class="cms-card-title">
                        <span class="material-symbols-outlined text-warning">chat</span> Recent Inquiries
                    </h5>
                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
                </div>
                <div class="cms-card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentInquiries as $inquiry)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $inquiry->name }}</span>
                                            <div class="small text-muted">{{ $inquiry->email }}</div>
                                        </td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 180px;">{{ $inquiry->subject }}</span>
                                        </td>
                                        <td>
                                            @if($inquiry->status === 'new')
                                                <span class="badge bg-danger">New</span>
                                            @elseif($inquiry->status === 'in_progress')
                                                <span class="badge bg-warning text-dark">In Progress</span>
                                            @elseif($inquiry->status === 'resolved')
                                                <span class="badge bg-success">Resolved</span>
                                            @else
                                                <span class="badge bg-secondary">Closed</span>
                                            @endif
                                        </td>
                                        <td><small class="text-muted">{{ $inquiry->created_at->diffForHumans() }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No inquiries received yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Audit Logs -->
        <div class="col-lg-6">
            <div class="cms-card h-100">
                <div class="cms-card-header">
                    <h5 class="cms-card-title">
                        <span class="material-symbols-outlined text-info">history</span> Recent System Audit Logs
                    </h5>
                    <a href="{{ route('admin.logs.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
                </div>
                <div class="cms-card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Module</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentLogs as $log)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $log->user_name }}</span>
                                            <div class="small text-muted">{{ $log->ip_address }}</div>
                                        </td>
                                        <td>
                                            @if($log->action === 'create')
                                                <span class="badge bg-success">Created</span>
                                            @elseif($log->action === 'update')
                                                <span class="badge bg-primary">Updated</span>
                                            @elseif($log->action === 'delete')
                                                <span class="badge bg-danger">Deleted</span>
                                            @elseif($log->action === 'login')
                                                <span class="badge bg-info text-dark">Login</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($log->action) }}</span>
                                            @endif
                                        </td>
                                        <td><span class="text-uppercase small fw-semibold text-secondary">{{ $log->module }}</span></td>
                                        <td><small class="text-muted">{{ $log->created_at->diffForHumans() }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No activity logs recorded.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
