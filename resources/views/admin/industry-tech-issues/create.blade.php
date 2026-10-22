@extends('layouts.admin')

@section('title', 'Log New Technical Issue')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color: #500a2f;">Log New Technical Issue</h4>
        <small class="text-muted">Directly create a new industry technical problem from backend communication or technical assistance request.</small>
    </div>

    <a href="{{ route('admin.industry-tech-issues.index') }}" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
        <span>Back to List</span>
    </a>
</div>

<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title mb-0">
            <span class="material-symbols-outlined text-primary">add_task</span>
            <span>Issue Details &amp; Parameters</span>
        </h5>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.industry-tech-issues.store') }}" method="POST">
            @csrf

            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label fw-semibold">Issue Title / Technical Problem <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="e.g. Shrinkage issue post garmenting in 100% cotton poplin">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Industry / Mill Name <span class="text-danger">*</span></label>
                    <input type="text" name="industry_name" class="form-control" value="{{ old('industry_name') }}" required placeholder="e.g. Vardhman Textiles Ltd.">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Person <span class="text-danger">*</span></label>
                    <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person') }}" required placeholder="e.g. Rajesh Kumar (Quality Head)">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="e.g. quality@vardhman.com">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Mobile / Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+91 9876543210">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                    <select name="category" class="form-select" required>
                        <option value="" disabled selected>-- Select Category --</option>
                        <option value="Fabric Defects" {{ old('category') === 'Fabric Defects' ? 'selected' : '' }}>Fabric Defects</option>
                        <option value="Dyeing Issues" {{ old('category') === 'Dyeing Issues' ? 'selected' : '' }}>Dyeing Issues</option>
                        <option value="Weaving Defects" {{ old('category') === 'Weaving Defects' ? 'selected' : '' }}>Weaving Defects</option>
                        <option value="Finishing Problems" {{ old('category') === 'Finishing Problems' ? 'selected' : '' }}>Finishing Problems</option>
                        <option value="Testing & Quality" {{ old('category') === 'Testing & Quality' ? 'selected' : '' }}>Testing & Quality</option>
                        <option value="Spinning" {{ old('category') === 'Spinning' ? 'selected' : '' }}>Spinning</option>
                        <option value="Garmenting" {{ old('category') === 'Garmenting' ? 'selected' : '' }}>Garmenting</option>
                        <option value="Other" {{ old('category') === 'Other' ? 'selected' : '' }}>Other Technical Issue</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Urgency Level <span class="text-danger">*</span></label>
                    <select name="urgency" class="form-select" required>
                        <option value="Low" {{ old('urgency') === 'Low' ? 'selected' : '' }}>Low (Advisory guidance)</option>
                        <option value="Medium" {{ old('urgency', 'Medium') === 'Medium' ? 'selected' : '' }}>Medium (Affecting sample lot)</option>
                        <option value="High" {{ old('urgency') === 'High' ? 'selected' : '' }}>High (Production line stalled)</option>
                        <option value="Critical" {{ old('urgency') === 'Critical' ? 'selected' : '' }}>Critical (Export lot rejection risk)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="open" {{ old('status', 'open') === 'open' ? 'selected' : '' }}>Open (Needs solution)</option>
                        <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="solved" {{ old('status') === 'solved' ? 'selected' : '' }}>Solved (Published to Knowledge Base)</option>
                        <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tags (comma-separated)</label>
                    <input type="text" name="tags" class="form-control" value="{{ old('tags') }}" placeholder="Shrinkage, Cotton, Finishing, Garment">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Detailed Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="5" required placeholder="Provide exact process parameters, yarn count, machine make, chemicals/dyes, test findings, and observed defect symptoms...">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Optional Initial Solution -->
            <div class="border rounded p-3 mb-4 bg-light">
                <h6 class="fw-bold text-success mb-2">
                    <i class="fa fa-circle-check me-1"></i> Technical Solution (Optional, if solution already available)
                </h6>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Solution Provided By (Authority / Cell)</label>
                    <input type="text" name="solution_by" class="form-control" value="{{ old('solution_by', 'Textiles Committee Technical Expert Cell') }}">
                </div>
                <div>
                    <label class="form-label small fw-semibold">Solution Steps / Laboratory Recommendations</label>
                    <textarea name="solution" class="form-control" rows="4" placeholder="Enter verified corrective actions, temperature/humidity settings, machine speed, chemical dosages...">{{ old('solution') }}</textarea>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-end gap-2">
                <a href="{{ route('admin.industry-tech-issues.index') }}" class="btn btn-secondary px-4">Cancel</a>
                <button type="submit" class="btn text-white fw-bold px-4" style="background: #6c1340;">
                    <i class="fa fa-save me-1"></i> Save Technical Issue
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
