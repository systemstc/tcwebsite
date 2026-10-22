@extends('layouts.admin')

@section('title', 'Manage Technical Issue #' . $issue->id)

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <a href="{{ route('admin.industry-tech-issues.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
            <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span> Back to Directory
        </a>
        <h4 class="fw-bold mb-0 text-dark">Technical Issue #{{ $issue->id }}</h4>
    </div>

    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.industry-tech-issues.edit', $issue->id) }}" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
            <span>Edit Details</span>
        </a>

        <a href="{{ route('industry-tech-issues.show', $issue->slug) }}" target="_blank" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">open_in_new</span>
            <span>View on Website</span>
        </a>

        <form action="{{ route('admin.industry-tech-issues.destroy', $issue->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this issue?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="fa fa-trash me-1"></i> Delete Issue
            </button>
        </form>
    </div>
</div>

<div class="row g-4">
    <!-- LEFT COLUMN: Issue Details & Replies Moderation -->
    <div class="col-lg-7">
        <!-- Issue Content Card -->
        <div class="cms-card mb-4">
            <div class="cms-card-header d-flex align-items-center justify-content-between">
                <h5 class="cms-card-title m-0">Issue Details</h5>
                <span class="badge {{ $issue->status === 'solved' ? 'bg-success' : ($issue->status === 'open' ? 'bg-danger' : 'bg-warning text-dark') }} text-uppercase">
                    {{ $issue->status }}
                </span>
            </div>

            <div class="cms-card-body">
                <h4 class="fw-bold text-dark mb-3">{{ $issue->title }}</h4>

                <div class="bg-light p-3 rounded mb-3 border">
                    <div class="row g-2 small">
                        <div class="col-sm-6">
                            <span class="text-muted">Industry:</span> <strong class="text-dark">{{ $issue->industry_name }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted">Contact Person:</span> <strong class="text-dark">{{ $issue->contact_person }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted">Email:</span> <strong class="text-dark">{{ $issue->email ?: 'N/A' }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted">Phone:</span> <strong class="text-dark">{{ $issue->phone ?: 'N/A' }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted">Category:</span> <span class="badge bg-secondary">{{ $issue->category }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted">Urgency:</span> <span class="badge bg-warning text-dark">{{ $issue->urgency }}</span>
                        </div>
                        <div class="col-12">
                            <span class="text-muted">Submitted on:</span> <span class="text-dark">{{ $issue->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-bold text-secondary small text-uppercase mb-1">Issue Description</label>
                    <div class="p-3 bg-white border rounded text-dark" style="font-size: 0.95rem; line-height: 1.6; white-space: pre-line;">
                        {{ $issue->description }}
                    </div>
                </div>

                @if($issue->tags)
                    <div>
                        <label class="fw-bold text-secondary small text-uppercase mb-1">Tags</label>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach(explode(',', $issue->tags) as $tag)
                                <span class="badge bg-light text-dark border">#{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Replies & Discussion Moderation Card -->
        <div class="cms-card">
            <div class="cms-card-header d-flex align-items-center justify-content-between">
                <h5 class="cms-card-title m-0">Discussion Replies ({{ $issue->replies->count() }})</h5>
            </div>

            <div class="cms-card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($issue->replies as $reply)
                        <div class="list-group-item p-3">
                            <div class="d-flex align-items-start justify-content-between mb-2">
                                <div>
                                    <strong class="text-dark">{{ $reply->name }}</strong>
                                    @if($reply->industry)
                                        <span class="text-muted small">({{ $reply->industry }})</span>
                                    @endif
                                    <div class="text-muted small">{{ $reply->email }} • {{ $reply->phone ?: 'No phone' }}</div>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <small class="text-muted">{{ $reply->created_at->format('d M Y, H:i') }}</small>
                                    <form action="{{ route('admin.industry-tech-issues.reply.destroy', [$issue->id, $reply->id]) }}" method="POST" onsubmit="return confirm('Delete this user reply?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm p-1" title="Delete reply">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <p class="mb-0 text-dark small" style="white-space: pre-line;">
                                {{ $reply->message }}
                            </p>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted small">
                            No peer replies have been submitted yet for this issue.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: Official Solution Editor & Status Updater -->
    <div class="col-lg-5">
        <!-- Status Changer Card -->
        <div class="cms-card mb-4">
            <div class="cms-card-header">
                <h5 class="cms-card-title m-0">Quick Status Update</h5>
            </div>
            <div class="cms-card-body">
                <form action="{{ route('admin.industry-tech-issues.status', $issue->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Current Status</label>
                        <select name="status" class="form-select">
                            <option value="open" {{ $issue->status === 'open' ? 'selected' : '' }}>Open (Pending Solution)</option>
                            <option value="in_progress" {{ $issue->status === 'in_progress' ? 'selected' : '' }}>In Progress (Under Technical Review)</option>
                            <option value="solved" {{ $issue->status === 'solved' ? 'selected' : '' }}>Solved (Solution Verified &amp; Published)</option>
                            <option value="closed" {{ $issue->status === 'closed' ? 'selected' : '' }}>Closed (Archived)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                        Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Official Technical Solution Card -->
        <div class="cms-card" style="border: 1.5px solid #86efac;">
            <div class="cms-card-header d-flex align-items-center justify-content-between" style="background: #f0fdf4;">
                <div class="d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined text-success">verified</span>
                    <h5 class="cms-card-title m-0 text-success">Official Solution Found</h5>
                </div>
                @if($issue->solution)
                    <span class="badge bg-success">Published</span>
                @else
                    <span class="badge bg-warning text-dark">Pending</span>
                @endif
            </div>

            <div class="cms-card-body">
                <p class="small text-muted mb-3">
                    The text entered here will be highlighted in the official green <strong>"Solution Found"</strong> box on the public portal for all industry members to reference.
                </p>

                <form action="{{ route('admin.industry-tech-issues.solution', $issue->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Official Solution Text <span class="text-danger">*</span></label>
                        <textarea name="solution" class="form-control" rows="8" required placeholder="Step-by-step technical advice, standard testing procedures, machine settings, or corrective parameters...">{{ old('solution', $issue->solution) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Solution Authority / Department</label>
                        <input type="text" name="solution_by" class="form-control" value="{{ old('solution_by', $issue->solution_by ?: 'Textiles Committee Quality Assurance Cell') }}" placeholder="e.g. Textiles Committee Eco-Testing Laboratory">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mark Issue Status As</label>
                        <select name="status" class="form-select">
                            <option value="solved" selected>Solved (Recommended)</option>
                            <option value="in_progress">In Progress</option>
                            <option value="open">Open</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold">
                        <i class="fa fa-check me-1"></i> Save &amp; Publish Official Solution
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
