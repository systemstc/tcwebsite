@extends('layouts.admin')

@section('title', 'Inquiry Details')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="cms-card">
            <div class="cms-card-header">
                <h5 class="cms-card-title">
                    <span class="material-symbols-outlined text-warning">mark_email_read</span> Message Content #{{ $inquiry->id }}
                </h5>
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
            </div>
            <div class="cms-card-body">
                <div class="mb-4 pb-3 border-bottom">
                    <h4 class="fw-bold mb-2">{{ $inquiry->subject }}</h4>
                    <div class="text-muted small">
                        Submitted: {{ $inquiry->created_at->format('d-m-Y H:i:s') }} ({{ $inquiry->created_at->diffForHumans() }})
                        | IP: {{ $inquiry->ip_address }}
                    </div>
                </div>

                <div class="bg-light p-4 rounded-3 fs-6 lh-base text-dark mb-4" style="white-space: pre-line;">
                    {{ $inquiry->message }}
                </div>

                <div class="d-flex gap-2">
                    <a href="mailto:{{ $inquiry->email }}?subject=Re: {{ urlencode($inquiry->subject) }}" class="btn btn-cms-primary">
                        <i class="fa fa-reply me-1"></i> Reply via Email
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="cms-card">
            <div class="cms-card-header">
                <h5 class="cms-card-title">Sender Information</h5>
            </div>
            <div class="cms-card-body">
                <p class="mb-2"><strong>Name:</strong> {{ $inquiry->name }}</p>
                <p class="mb-2"><strong>Email:</strong> <a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></p>
                <p class="mb-4"><strong>Phone:</strong> {{ $inquiry->phone ?? 'Not provided' }}</p>

                <hr>

                <h6 class="fw-bold mb-3">Update Status</h6>
                <form action="{{ route('admin.inquiries.status', $inquiry->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            <option value="new" {{ $inquiry->status === 'new' ? 'selected' : '' }}>New</option>
                            <option value="read" {{ $inquiry->status === 'read' ? 'selected' : '' }}>Read</option>
                            <option value="replied" {{ $inquiry->status === 'replied' ? 'selected' : '' }}>Replied</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-success w-100 fw-bold">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
