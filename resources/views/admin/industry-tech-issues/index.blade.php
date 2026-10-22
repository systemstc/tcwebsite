@extends('layouts.admin')

@section('title', 'Industry Tech Issues Management')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color: #500a2f;">Industry Tech Issues &amp; Solutions</h4>
        <small class="text-muted">Manage reported technical issues, provide official laboratory/expert solutions, and moderate peer discussions.</small>
    </div>

    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.industry-tech-issues.create') }}" class="btn btn-sm text-white d-inline-flex align-items-center gap-1" style="background: #6c1340;">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span>
            <span>Log Technical Issue</span>
        </a>
        <a href="{{ route('industry-tech-issues.index') }}" target="_blank" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">open_in_new</span>
            <span>View Public Portal</span>
        </a>
    </div>
</div>

<!-- Stats Counter Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Total Issues</div>
                    <div class="fs-4 fw-bold text-dark">{{ $stats['total'] }}</div>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 8px; background: #fdf7fa; color: #6c1340; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined fs-4">build_circle</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Open (Need Solution)</div>
                    <div class="fs-4 fw-bold text-danger">{{ $stats['open'] }}</div>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 8px; background: #fff1f2; color: #e11d48; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined fs-4">warning</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">In Progress</div>
                    <div class="fs-4 fw-bold text-warning">{{ $stats['in_progress'] }}</div>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 8px; background: #fefce8; color: #ca8a04; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined fs-4">pending</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card border shadow-sm">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold">Solved (Knowledge Base)</div>
                    <div class="fs-4 fw-bold text-success">{{ $stats['solved'] }}</div>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 8px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined fs-4">task_alt</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters Bar -->
<div class="cms-card mb-4">
    <div class="cms-card-body p-3">
        <form action="{{ route('admin.industry-tech-issues.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Search title, industry, or description...">
            </div>

            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- All Statuses --</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="solved" {{ request('status') === 'solved' ? 'selected' : '' }}>Solved</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="category" class="form-select form-select-sm">
                    <option value="">-- All Categories --</option>
                    <option value="Fabric Defects" {{ request('category') === 'Fabric Defects' ? 'selected' : '' }}>Fabric Defects</option>
                    <option value="Dyeing Issues" {{ request('category') === 'Dyeing Issues' ? 'selected' : '' }}>Dyeing Issues</option>
                    <option value="Weaving Defects" {{ request('category') === 'Weaving Defects' ? 'selected' : '' }}>Weaving Defects</option>
                    <option value="Finishing Problems" {{ request('category') === 'Finishing Problems' ? 'selected' : '' }}>Finishing Problems</option>
                    <option value="Testing & Quality" {{ request('category') === 'Testing & Quality' ? 'selected' : '' }}>Testing & Quality</option>
                    <option value="Spinning" {{ request('category') === 'Spinning' ? 'selected' : '' }}>Spinning</option>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary flex-grow-1">Filter</button>
                @if(request()->hasAny(['q', 'status', 'category']))
                    <a href="{{ route('admin.industry-tech-issues.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Table Card -->
<div class="cms-card">
    <div class="cms-card-header d-flex align-items-center justify-content-between">
        <h5 class="cms-card-title m-0">Reported Issues Directory</h5>
        <span class="text-muted small">Showing {{ $issues->firstItem() ?? 0 }} - {{ $issues->lastItem() ?? 0 }} of {{ $issues->total() }}</span>
    </div>

    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle m-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Issue Summary / Title</th>
                        <th>Industry &amp; Contact</th>
                        <th>Category</th>
                        <th>Urgency</th>
                        <th>Status</th>
                        <th>Activity</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($issues as $issue)
                        <tr class="{{ $issue->status === 'open' ? 'table-warning' : '' }}">
                            <td><span class="text-muted small">#{{ $issue->id }}</span></td>
                            <td>
                                <a href="{{ route('admin.industry-tech-issues.show', $issue->id) }}" class="fw-bold text-dark text-decoration-none">
                                    {{ Str::limit($issue->title, 55) }}
                                </a>
                                @if(!empty($issue->solution))
                                    <div><span class="badge bg-success-subtle text-success small"><i class="fa fa-check me-1"></i> Solution Provided</span></div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $issue->industry_name }}</div>
                                <small class="text-muted">{{ $issue->contact_person }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $issue->category }}</span>
                            </td>
                            <td>
                                @php
                                    $urgencyBadge = match(strtolower($issue->urgency)) {
                                        'critical' => 'bg-danger text-white',
                                        'high' => 'bg-warning text-dark',
                                        'medium' => 'bg-info text-dark',
                                        'low' => 'bg-success text-white',
                                        default => 'bg-secondary text-white',
                                    };
                                @endphp
                                <span class="badge {{ $urgencyBadge }}">{{ $issue->urgency }}</span>
                            </td>
                            <td>
                                @if($issue->status === 'solved')
                                    <span class="badge bg-success">Solved</span>
                                @elseif($issue->status === 'in_progress')
                                    <span class="badge bg-warning text-dark">In Progress</span>
                                @elseif($issue->status === 'open')
                                    <span class="badge bg-danger">Open</span>
                                @else
                                    <span class="badge bg-secondary">Closed</span>
                                @endif
                            </td>
                            <td>
                                <div class="small text-muted d-flex align-items-center gap-2">
                                    <span title="Upvotes"><i class="fa fa-thumbs-up text-warning"></i> {{ $issue->upvotes_count }}</span>
                                    <span title="Replies"><i class="fa fa-comment-dots text-primary"></i> {{ $issue->replies_count }}</span>
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">{{ $issue->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.industry-tech-issues.show', $issue->id) }}" class="btn btn-outline-primary btn-sm me-1" title="View & Provide Solution">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ route('industry-tech-issues.show', $issue->slug) }}" target="_blank" class="btn btn-outline-secondary btn-sm me-1" title="View in Frontend">
                                    <i class="fa fa-external-link"></i>
                                </a>
                                <form action="{{ route('admin.industry-tech-issues.destroy', $issue->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this technical issue?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <span class="material-symbols-outlined fs-1 text-secondary mb-2">inbox</span>
                                <div>No technical issues found.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($issues->hasPages())
        <div class="cms-card-footer p-3 d-flex justify-content-center">
            {{ $issues->links() }}
        </div>
    @endif
</div>
@endsection
