@extends('layouts.admin')

@section('title', 'Inquiries & Feedback Management')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-warning">mail</span> Citizen Inquiries & Feedback Directory
        </h5>
    </div>
    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Sender (Name / Email)</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inq)
                        <tr class="{{ $inq->status === 'new' ? 'table-warning' : '' }}">
                            <td>
                                <div class="fw-bold">{{ $inq->name }}</div>
                                <div class="small text-muted">{{ $inq->email }}</div>
                            </td>
                            <td><small>{{ $inq->phone ?? '-' }}</small></td>
                            <td>
                                <div class="fw-semibold">{{ Str::limit($inq->subject, 35) }}</div>
                                <div class="small text-muted">{{ Str::limit($inq->message, 40) }}</div>
                            </td>
                            <td>
                                @if($inq->status === 'new')
                                    <span class="badge bg-danger">New</span>
                                @elseif($inq->status === 'read')
                                    <span class="badge bg-secondary">Read</span>
                                @else
                                    <span class="badge bg-success">Replied</span>
                                @endif
                            </td>
                            <td><small class="text-muted">{{ $inq->created_at->format('d-m-Y H:i') }}</small></td>
                            <td class="text-end">
                                <a href="{{ route('admin.inquiries.show', $inq->id) }}" class="btn btn-outline-primary btn-sm me-1" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.inquiries.destroy', $inq->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
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
                            <td colspan="6" class="text-center py-4 text-muted">No citizen inquiries recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
