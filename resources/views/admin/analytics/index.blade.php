@extends('layouts.admin')

@section('title', 'Visitor & Bhashini Analytics')

@section('content')
<div class="container-fluid px-0">

    <!-- Header & Period Filter -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary px-2 py-1">Govt. of India</span>
                <span class="badge bg-success px-2 py-1"><i class="fa fa-language me-1"></i> Bhashini Powered</span>
            </div>
            <h4 class="fw-bold text-dark mb-1 mt-2">Visitor Analytics & Multi-Language Insights</h4>
            <p class="text-muted small mb-0">
                Official web metrics, regional language adoption via Bhashini AI, and top visited content for <strong>textilescommittee.gov.in</strong>
            </p>
        </div>

        <div class="d-flex align-items-center gap-2 bg-white p-1 rounded-3 shadow-sm border">
            <span class="text-muted small ps-2 fw-semibold"><i class="fa fa-calendar-alt me-1"></i> Period:</span>
            <div class="btn-group btn-group-sm" role="group">
                <a href="{{ route('admin.analytics.index', ['period' => '1']) }}" class="btn {{ $period == '1' ? 'btn-primary' : 'btn-light text-dark' }}">Today</a>
                <a href="{{ route('admin.analytics.index', ['period' => '7']) }}" class="btn {{ $period == '7' ? 'btn-primary' : 'btn-light text-dark' }}">7 Days</a>
                <a href="{{ route('admin.analytics.index', ['period' => '30']) }}" class="btn {{ $period == '30' ? 'btn-primary' : 'btn-light text-dark' }}">30 Days</a>
                <a href="{{ route('admin.analytics.index', ['period' => 'all']) }}" class="btn {{ $period == 'all' ? 'btn-primary' : 'btn-light text-dark' }}">All Time</a>
            </div>
        </div>
    </div>

    <!-- Top KPI Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Page Views -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 p-3 rounded-3" style="border-left: 4px solid #721835 !important;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Total Page Views</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ number_format($totalViews) }}</div>
                        <small class="text-success fw-semibold"><i class="fa fa-arrow-trend-up me-1"></i> Active traffic recorded</small>
                    </div>
                    <div class="p-3 rounded-circle" style="background: rgba(114, 24, 53, 0.1); color: #721835;">
                        <span class="material-symbols-outlined fs-2">visibility</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unique Visitors -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 p-3 rounded-3" style="border-left: 4px solid #0284c7 !important;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Unique Citizens / IPs</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ number_format($uniqueVisitors) }}</div>
                        <small class="text-info fw-semibold"><i class="fa fa-users me-1"></i> Unique visitors reached</small>
                    </div>
                    <div class="p-3 rounded-circle" style="background: rgba(2, 132, 199, 0.1); color: #0284c7;">
                        <span class="material-symbols-outlined fs-2">person_check</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bhashini Multi-language Usage -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 p-3 rounded-3" style="border-left: 4px solid #16a34a !important;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Bhashini Translations</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ number_format($bhashiniHits) }}</div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle fw-semibold">
                            {{ $bhashiniPercent }}% of total traffic
                        </span>
                    </div>
                    <div class="p-3 rounded-circle" style="background: rgba(22, 163, 74, 0.1); color: #16a34a;">
                        <span class="material-symbols-outlined fs-2">translate</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unique User Sessions -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 p-3 rounded-3" style="border-left: 4px solid #ea580c !important;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Citizen Sessions</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ number_format($uniqueSessions) }}</div>
                        <small class="text-muted">
                            Avg {{ $uniqueSessions > 0 ? round($totalViews / $uniqueSessions, 1) : 1 }} pages / session
                        </small>
                    </div>
                    <div class="p-3 rounded-circle" style="background: rgba(234, 88, 12, 0.1); color: #ea580c;">
                        <span class="material-symbols-outlined fs-2">devices</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row: Trend & Language Distribution -->
    <div class="row g-4 mb-4">
        <!-- Daily Traffic Trend Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-primary fs-5">monitoring</span>
                            Traffic Trend (Visits vs Bhashini Regional Translations)
                        </h6>
                        <small class="text-muted">Daily page views compared against regional language translation sessions</small>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div style="position: relative; height: 320px;">
                        <canvas id="trafficTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Language Distribution Donut Chart -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-success fs-5">pie_chart</span>
                            Language Split
                        </h6>
                        <small class="text-muted">Regional Bhashini vs English</small>
                    </div>
                </div>
                <div class="card-body p-3 d-flex flex-column align-items-center justify-content-center">
                    <div style="position: relative; height: 230px; width: 100%;">
                        <canvas id="languageShareChart"></canvas>
                    </div>
                    <div class="mt-3 text-center">
                        <span class="badge bg-success px-3 py-2 fs-7">
                            <i class="fa fa-language me-1"></i> {{ count($langDistribution) }} Languages Monitored
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bhashini Language Adoption Breakdown -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-warning fs-5">translate</span>
                    Bhashini & Indian Regional Language Access Breakdown
                </h6>
                <small class="text-muted">Showing exact number of citizens accessing textiles committee services in their mother tongue</small>
            </div>
            <span class="badge bg-light text-dark border">
                Total Regional Hits: {{ number_format($bhashiniHits) }}
            </span>
        </div>
        <div class="card-body p-3">
            <div class="row g-3">
                @php
                    $colors = ['#721835', '#0284c7', '#16a34a', '#ea580c', '#8b5cf6', '#ec4899', '#0d9488', '#eab308', '#64748b', '#6366f1'];
                @endphp
                @forelse($langDistribution as $idx => $lang)
                    @php
                        $pct = $totalViews > 0 ? round(($lang->views / $totalViews) * 100, 1) : 0;
                        $color = $colors[$idx % count($colors)];
                        $langObj = \App\Models\SiteAnalytic::getLanguageMeta($lang->lang);
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="p-3 border rounded-3 bg-light-subtle h-100">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge rounded-pill" style="background-color: {{ $color }}; color: #fff; font-size: 11px;">
                                        {{ strtoupper($lang->lang) }}
                                    </span>
                                    <span class="fw-bold text-dark">{{ $langObj['name'] }}</span>
                                    @if($langObj['native'] !== $langObj['name'])
                                        <span class="text-muted small">({{ $langObj['native'] }})</span>
                                    @endif
                                </div>
                                <span class="fw-bold fs-6" style="color: {{ $color }};">{{ number_format($lang->views) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-1 small text-muted">
                                <span>Share of Traffic</span>
                                <span class="fw-semibold">{{ $pct }}%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $pct }}%; background-color: {{ $color }};" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4 text-muted">
                        No language tracking data recorded yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Top Pages & Technology Breakdown Row -->
    <div class="row g-4 mb-4">
        <!-- Most Visited Pages Table -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-primary fs-5">leaderboard</span>
                            Top 10 Most Visited Pages & Content
                        </h6>
                        <small class="text-muted">Ranked by total page views and citizen engagement</small>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover m-0">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">#</th>
                                    <th>Page Title & URL</th>
                                    <th class="text-center" style="width: 120px;">Views</th>
                                    <th class="text-center" style="width: 110px;">Unique IPs</th>
                                    <th class="text-center" style="width: 110px;">Bhashini Hits</th>
                                    <th style="width: 130px;">Traffic Share</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topPages as $index => $page)
                                    @php
                                        $sharePct = $totalViews > 0 ? round(($page->total_views / $totalViews) * 100, 1) : 0;
                                    @endphp
                                    <tr>
                                        <td class="text-center">
                                            @if($index == 0)
                                                <span class="badge bg-warning text-dark rounded-circle" style="width: 24px; height: 24px; line-height: 18px;">1</span>
                                            @elseif($index == 1)
                                                <span class="badge bg-secondary rounded-circle" style="width: 24px; height: 24px; line-height: 18px;">2</span>
                                            @elseif($index == 2)
                                                <span class="badge bg-bronze rounded-circle" style="width: 24px; height: 24px; line-height: 18px; background-color: #cd7f32; color: #fff;">3</span>
                                            @else
                                                <span class="text-muted fw-semibold">{{ $index + 1 }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark text-truncate" style="max-width: 320px;" title="{{ $page->page_title }}">
                                                {{ $page->page_title ?: 'Textiles Committee Home' }}
                                            </div>
                                            <div class="small">
                                                <a href="{{ $page->path ?: '/' }}" target="_blank" class="text-primary text-decoration-none font-monospace">
                                                    {{ $page->path ?: '/' }} <i class="fa fa-external-link-alt ms-1" style="font-size: 10px;"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="text-center fw-bold text-dark">
                                            {{ number_format($page->total_views) }}
                                        </td>
                                        <td class="text-center text-muted">
                                            {{ number_format($page->unique_ips) }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                {{ number_format($page->bhashini_views) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 6px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $sharePct }}%;" aria-valuenow="{{ $sharePct }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="small fw-semibold text-muted">{{ $sharePct }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">No page visit records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Devices & Browsers Breakdown -->
        <div class="col-lg-4">
            <!-- Devices -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-info fs-5">devices</span>
                        Device Breakdown
                    </h6>
                </div>
                <div class="card-body p-3">
                    @forelse($deviceStats as $device)
                        @php
                            $dPct = $totalViews > 0 ? round(($device->count / $totalViews) * 100, 1) : 0;
                            $icon = match(strtolower($device->device_type)) {
                                'mobile' => 'smartphone',
                                'tablet' => 'tablet',
                                default => 'computer'
                            };
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="d-flex align-items-center gap-2 text-capitalize fw-semibold text-dark">
                                    <span class="material-symbols-outlined fs-6 text-secondary">{{ $icon }}</span>
                                    {{ $device->device_type ?: 'Desktop' }}
                                </span>
                                <span class="small text-muted">{{ number_format($device->count) }} ({{ $dPct }}%)</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-info" style="width: {{ $dPct }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small m-0">No device data available.</p>
                    @endforelse
                </div>
            </div>

            <!-- Browsers -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-secondary fs-5">public</span>
                        Browsers
                    </h6>
                </div>
                <div class="card-body p-3">
                    @forelse($browserStats as $browser)
                        @php
                            $bPct = $totalViews > 0 ? round(($browser->count / $totalViews) * 100, 1) : 0;
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold text-dark">{{ $browser->browser ?: 'Other' }}</span>
                                <span class="small text-muted">{{ number_format($browser->count) }} ({{ $bPct }}%)</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-secondary" style="width: {{ $bPct }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small m-0">No browser data available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Live Visitor Activity Stream -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-danger fs-5">pulse_alert</span>
                    Recent Real-time Visitor Stream
                </h6>
                <small class="text-muted">Live activity stream logged by the tracking engine</small>
            </div>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                <i class="fa fa-circle me-1" style="font-size: 8px;"></i> Live Tracking Active
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle table-hover m-0">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Page Visited</th>
                            <th>Language Used</th>
                            <th>Device & Browser</th>
                            <th>Citizen IP / Session</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentVisits as $visit)
                            @php
                                $langObj = \App\Models\SiteAnalytic::getLanguageMeta($visit->bhashini_lang ?: $visit->locale);
                            @endphp
                            <tr>
                                <td class="text-muted small text-nowrap">
                                    <i class="fa fa-clock me-1"></i> {{ $visit->created_at->diffForHumans() }}
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $visit->page_title ?: 'Home' }}</div>
                                    <span class="font-monospace small text-muted">{{ $visit->path }}</span>
                                </td>
                                <td>
                                    @if($visit->is_bhashini)
                                        <span class="badge bg-success text-white">
                                            <i class="fa fa-language me-1"></i> Bhashini: {{ $langObj['name'] }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-dark border">
                                            {{ $langObj['name'] }} (Default)
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-capitalize small fw-semibold text-dark">{{ $visit->device_type ?: 'Desktop' }}</span>
                                    <span class="text-muted small">· {{ $visit->browser ?: 'Browser' }}</span>
                                </td>
                                <td class="font-monospace small text-muted">
                                    {{ substr($visit->ip_address, 0, 8) }}***
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No recent visits recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Traffic Trend Chart
    const dailyData = @json($dailyTrend);
    const trendLabels = dailyData.map(d => d.date);
    const totalViewsData = dailyData.map(d => d.views);
    const bhashiniViewsData = dailyData.map(d => d.bhashini_views);

    const ctxTrend = document.getElementById('trafficTrendChart');
    if (ctxTrend) {
        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [
                    {
                        label: 'Total Citizen Visits',
                        data: totalViewsData,
                        borderColor: '#721835',
                        backgroundColor: 'rgba(114, 24, 53, 0.08)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Bhashini Language Translations',
                        data: bhashiniViewsData,
                        borderColor: '#16a34a',
                        backgroundColor: 'rgba(22, 163, 74, 0.08)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: { family: "'Noto Sans', sans-serif", size: 12, weight: '500' }
                        }
                    },
                    tooltip: {
                        padding: 10,
                        titleFont: { family: "'Noto Sans', sans-serif", weight: 'bold' },
                        bodyFont: { family: "'Noto Sans', sans-serif" }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: { font: { family: "'Noto Sans', sans-serif" } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: "'Noto Sans', sans-serif", size: 11 } }
                    }
                }
            }
        });
    }

    // Language Share Donut Chart
    const langData = @json($langDistribution);
    const langLabels = langData.map(l => {
        const langMap = {
            'en': 'English', 'hi': 'Hindi (हिन्दी)', 'mr': 'Marathi (मराठी)',
            'ta': 'Tamil (தமிழ்)', 'te': 'Telugu (తెలుగు)', 'gu': 'Gujarati (ગુજરાતી)',
            'bn': 'Bengali (বাংলা)', 'kn': 'Kannada (ಕನ್ನಡ)', 'ml': 'Malayalam (മലയാളം)',
            'or': 'Odia (ଓଡ଼ିଆ)', 'pa': 'Punjabi (ਪੰਜਾਬੀ)', 'as': 'Assamese (অসমীয়া)'
        };
        return langMap[l.lang] || l.lang.toUpperCase();
    });
    const langCounts = langData.map(l => l.views);

    const ctxLang = document.getElementById('languageShareChart');
    if (ctxLang) {
        new Chart(ctxLang, {
            type: 'doughnut',
            data: {
                labels: langLabels,
                datasets: [{
                    data: langCounts,
                    backgroundColor: [
                        '#721835', '#0284c7', '#16a34a', '#ea580c', '#8b5cf6',
                        '#ec4899', '#0d9488', '#eab308', '#64748b', '#6366f1'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            font: { family: "'Noto Sans', sans-serif", size: 11 }
                        }
                    }
                },
                cutout: '65%'
            }
        });
    }
});
</script>
@endpush
