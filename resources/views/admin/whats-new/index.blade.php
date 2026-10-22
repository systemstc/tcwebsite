@extends('layouts.admin')

@section('title', "What's New Updates Management")

@section('content')
<div class="cms-card">
    <div class="cms-card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="cms-card-title mb-0">
                <span class="material-symbols-outlined text-primary">feed</span> What's New Updates Directory
            </h5>
            <small class="text-muted">Manage all public notices, announcements, and documents displayed on the What's New page.</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('whats-new.index') }}" target="_blank" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                <span class="material-symbols-outlined" style="font-size: 18px;">open_in_new</span> View Public Page
            </a>
            <a href="{{ route('admin.whats-new.create') }}" class="btn btn-cms-primary btn-sm d-flex align-items-center gap-1">
                <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Add New Update
            </a>
        </div>
    </div>
    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle table-hover m-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;" class="text-center">#</th>
                        <th>Title & Details</th>
                        <th>Category</th>
                        <th>Document / Attachment</th>
                        <th>Published Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        @php
                            $pubDate = $item->date ?: $item->published_date;
                        @endphp
                        <tr>
                            <td class="text-center text-muted fw-bold">{{ $item->id }}</td>
                            <td>
                                <div class="fw-bold text-dark">
                                    {{ $item->title_en ?: $item->title_hi }}
                                    @if($item->is_new)
                                        <span class="badge bg-danger ms-1" style="font-size: 10px;">NEW</span>
                                    @endif
                                </div>
                                @if($item->title_hi && $item->title_en)
                                    <small class="text-muted d-block">{{ $item->title_hi }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                    {{ $item->category ?: 'Notification' }}
                                </span>
                            </td>
                            <td>
                                @if($item->document_url)
                                    <a href="{{ asset($item->document_url) }}" target="_blank" class="text-decoration-none d-inline-flex align-items-center gap-1 text-danger small fw-semibold">
                                        <i class="fa fa-file-pdf"></i>
                                        <span>View ({{ $item->file_size ?: 'Doc' }})</span>
                                    </a>
                                @elseif($item->link_url && $item->link_url !== '#')
                                    <a href="{{ $item->link_url }}" target="_blank" class="text-decoration-none small text-primary">
                                        <i class="fa fa-external-link-alt me-1"></i> Link
                                    </a>
                                @else
                                    <span class="text-muted small">No file</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted fw-semibold">
                                    {{ $pubDate ? \Carbon\Carbon::parse($pubDate)->format('d M Y') : '-' }}
                                </small>
                            </td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Active</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.whats-new.edit', $item->id) }}" class="btn btn-outline-primary btn-sm me-1" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.whats-new.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this update?');">
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
                            <td colspan="7" class="text-center py-4 text-muted">No updates available. Click "Add New Update" to create one.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
