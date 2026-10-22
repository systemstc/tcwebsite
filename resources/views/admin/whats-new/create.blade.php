@extends('layouts.admin')

@section('title', "Add What's New Item")

@section('content')
<div class="cms-card">
    <div class="cms-card-header d-flex justify-content-between align-items-center">
        <h5 class="cms-card-title mb-0">
            <span class="material-symbols-outlined text-primary">add_circle</span> Add What's New Notification / Document
        </h5>
        <a href="{{ route('admin.whats-new.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.whats-new.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <!-- Title (English) -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (English) <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" class="form-control" required placeholder="e.g. Draft Questionnaire under Integrated Textile Census" value="{{ old('title_en') }}">
                </div>

                <!-- Title (Hindi) -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title (Hindi)</label>
                    <input type="text" name="title_hi" class="form-control" placeholder="उदा. एकीकृत वस्त्र गणना के तहत मसौदा प्रश्नावली" value="{{ old('title_hi') }}">
                </div>

                <!-- Category -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Category / Type <span class="text-danger">*</span></label>
                    <select name="category" class="form-select">
                        <option value="Notification" selected>Notification</option>
                        <option value="Notice">Notice</option>
                        <option value="Circular">Circular</option>
                        <option value="Tender / Vacancy">Tender / Vacancy</option>
                        <option value="Press Release">Press Release</option>
                        <option value="Update">General Update</option>
                        <option value="Offering / Scheme">Offering / Scheme</option>
                    </select>
                </div>

                <!-- Published Date -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Published Date <span class="text-danger">*</span></label>
                    <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                </div>

                <!-- Sort Order -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                </div>

                <!-- File Upload (PDF/Document) -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fa fa-file-pdf text-danger me-1"></i> Upload Document (PDF / DOC / XLS)
                    </label>
                    <input type="file" name="file_upload" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip">
                    <small class="text-muted">Automatic file size calculation (e.g. 1.59 MB) for the What's New page.</small>
                </div>

                <!-- Document URL (Alternative or External File URL) -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Or Direct Document URL</label>
                    <input type="text" name="document_url" class="form-control" placeholder="assets/docs/... or https://..." value="{{ old('document_url') }}">
                </div>

                <!-- External Detail Link URL -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">External / Detail Link URL</label>
                    <input type="text" name="link_url" class="form-control" value="{{ old('link_url', '#') }}" placeholder="https://... or #">
                </div>

                <!-- Custom File Size (Optional Override) -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Display File Size (Optional)</label>
                    <input type="text" name="file_size" class="form-control" placeholder="e.g. 1.59 MB or 566.12 KB" value="{{ old('file_size') }}">
                </div>

                <!-- Content / Description (English) -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Description / Notes (English)</label>
                    <textarea name="content_en" class="form-control" rows="3" placeholder="Brief summary or details...">{{ old('content_en') }}</textarea>
                </div>

                <!-- Content / Description (Hindi) -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Description / Notes (Hindi)</label>
                    <textarea name="content_hi" class="form-control" rows="3" placeholder="संक्षिप्त विवरण...">{{ old('content_hi') }}</textarea>
                </div>

                <!-- Toggles: Is New Badge & Active -->
                <div class="col-md-6">
                    <div class="form-check form-switch p-3 border rounded-3 bg-light">
                        <input class="form-check-input ms-0 me-3" type="checkbox" name="is_new" id="isNew" checked value="1">
                        <label class="form-check-label fw-bold text-dark" for="isNew">
                            <span class="badge bg-danger me-1">NEW</span> Display "NEW" Pulsing Badge
                        </label>
                        <small class="text-muted d-block mt-1">Highlights this item as newly added on the portal ticker and What's New page.</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check form-switch p-3 border rounded-3 bg-light">
                        <input class="form-check-input ms-0 me-3" type="checkbox" name="is_active" id="isActive" checked value="1">
                        <label class="form-check-label fw-bold text-dark" for="isActive">
                            <i class="fa fa-check-circle text-success me-1"></i> Published & Active
                        </label>
                        <small class="text-muted d-block mt-1">Visible to citizens on the public portal.</small>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.whats-new.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4 fw-semibold">
                    <i class="fa fa-save me-1"></i> Save What's New Post
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
