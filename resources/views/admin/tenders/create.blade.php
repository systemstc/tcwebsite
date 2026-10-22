@extends('layouts.admin')

@section('title', 'Add Tender / Vacancy')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-success">post_add</span> New Tender / Vacancy Details
        </h5>
        <a href="{{ route('admin.tenders.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.tenders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (English) <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" class="form-control" required placeholder="e.g. RFP for Appointment of Auditor">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (Hindi)</label>
                    <input type="text" name="title_hi" class="form-control" placeholder="Enter Hindi text (optional)">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required>
                        <option value="tender">Tender</option>
                        <option value="vacancy">Vacancy / Career</option>
                        <option value="auction">Auction / Notice</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Reference Number</label>
                    <input type="text" name="reference_no" class="form-control" placeholder="e.g. TC/TND/2026/04">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select">
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Publish Date</label>
                    <input type="date" name="published_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Closing Date</label>
                    <input type="date" name="closing_date" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Upload PDF Document</label>
                    <input type="file" name="file" class="form-control" accept=".pdf">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Or External Document URL</label>
                    <input type="text" name="file_url" class="form-control" placeholder="https://">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Details / Scope (Optional)</label>
                    <textarea name="description_en" class="form-control" rows="3" placeholder="Brief scope of tender or eligibility criteria..."></textarea>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.tenders.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Publish Tender</button>
            </div>
        </form>
    </div>
</div>
@endsection
