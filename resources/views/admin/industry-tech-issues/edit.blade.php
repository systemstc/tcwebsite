@extends('layouts.admin')

@section('title', 'Edit Issue: ' . $issue->title)

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color: #500a2f;">Edit Technical Issue #{{ $issue->id }}</h4>
        <small class="text-muted">Modify parameters, contact details, tags, and classification.</small>
    </div>

    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.industry-tech-issues.show', $issue->id) }}" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">visibility</span>
            <span>View Details &amp; Solutions</span>
        </a>
        <a href="{{ route('admin.industry-tech-issues.index') }}" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
            <span>Back to List</span>
        </a>
    </div>
</div>

<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title mb-0">
            <span class="material-symbols-outlined text-primary">edit_note</span>
            <span>Update Issue Details</span>
        </h5>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.industry-tech-issues.update', $issue->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label fw-semibold">Issue Title / Technical Problem <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $issue->title) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Industry / Mill Name <span class="text-danger">*</span></label>
                    <input type="text" name="industry_name" class="form-control" value="{{ old('industry_name', $issue->industry_name) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Person <span class="text-danger">*</span></label>
                    <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', $issue->contact_person) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $issue->email) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Mobile / Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $issue->phone) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                    <select name="category" class="form-select" required>
                        <option value="Fabric Defects" {{ old('category', $issue->category) === 'Fabric Defects' ? 'selected' : '' }}>Fabric Defects</option>
                        <option value="Dyeing Issues" {{ old('category', $issue->category) === 'Dyeing Issues' ? 'selected' : '' }}>Dyeing Issues</option>
                        <option value="Weaving Defects" {{ old('category', $issue->category) === 'Weaving Defects' ? 'selected' : '' }}>Weaving Defects</option>
                        <option value="Finishing Problems" {{ old('category', $issue->category) === 'Finishing Problems' ? 'selected' : '' }}>Finishing Problems</option>
                        <option value="Testing & Quality" {{ old('category', $issue->category) === 'Testing & Quality' ? 'selected' : '' }}>Testing & Quality</option>
                        <option value="Spinning" {{ old('category', $issue->category) === 'Spinning' ? 'selected' : '' }}>Spinning</option>
                        <option value="Garmenting" {{ old('category', $issue->category) === 'Garmenting' ? 'selected' : '' }}>Garmenting</option>
                        <option value="Other" {{ old('category', $issue->category) === 'Other' ? 'selected' : '' }}>Other Technical Issue</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Urgency Level <span class="text-danger">*</span></label>
                    <select name="urgency" class="form-select" required>
                        <option value="Low" {{ old('urgency', $issue->urgency) === 'Low' ? 'selected' : '' }}>Low (Advisory guidance)</option>
                        <option value="Medium" {{ old('urgency', $issue->urgency) === 'Medium' ? 'selected' : '' }}>Medium (Affecting sample lot)</option>
                        <option value="High" {{ old('urgency', $issue->urgency) === 'High' ? 'selected' : '' }}>High (Production line stalled)</option>
                        <option value="Critical" {{ old('urgency', $issue->urgency) === 'Critical' ? 'selected' : '' }}>Critical (Export lot rejection risk)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="open" {{ old('status', $issue->status) === 'open' ? 'selected' : '' }}>Open (Needs solution)</option>
                        <option value="in_progress" {{ old('status', $issue->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="solved" {{ old('status', $issue->status) === 'solved' ? 'selected' : '' }}>Solved (Published to Knowledge Base)</option>
                        <option value="closed" {{ old('status', $issue->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tags (comma-separated)</label>
                    <input type="text" name="tags" class="form-control" value="{{ old('tags', $issue->tags) }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Detailed Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="5" required>{{ old('description', $issue->description) }}</textarea>
                </div>
            </div>

            <!-- Solution Section -->
            <div class="border rounded p-3 mb-4 bg-light">
                <h6 class="fw-bold text-success mb-2">
                    <i class="fa fa-circle-check me-1"></i> Technical Solution
                </h6>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Solution Provided By (Authority / Cell)</label>
                    <input type="text" name="solution_by" class="form-control" value="{{ old('solution_by', $issue->solution_by ?: 'Textiles Committee Technical Expert Cell') }}">
                </div>
                <div>
                    <label class="form-label small fw-semibold">Solution Steps / Recommendations</label>
                    <textarea name="solution" class="form-control" rows="4">{{ old('solution', $issue->solution) }}</textarea>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-end gap-2">
                <a href="{{ route('admin.industry-tech-issues.show', $issue->id) }}" class="btn btn-secondary px-4">Cancel</a>
                <button type="submit" class="btn text-white fw-bold px-4" style="background: #6c1340;">
                    <i class="fa fa-save me-1"></i> Update Issue
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
