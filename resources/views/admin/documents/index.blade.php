@extends('layouts.admin')

@section('title', 'Documents & Publications Management')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-warning">folder_open</span> Documents & Circulars List
        </h5>
        <a href="{{ route('admin.documents.create') }}" class="btn btn-cms-primary btn-sm d-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Upload Document
        </a>
    </div>
    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>File / Link</th>
                        <th>Published Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $doc->title_en ?: $doc->title_hi }}</div>
                                @if($doc->title_hi && $doc->title_en)
                                    <small class="text-muted">{{ $doc->title_hi }}</small>
                                @endif
                            </td>
                            <td><span class="badge bg-light text-dark border text-uppercase">{{ $doc->category }}</span></td>
                            <td>
                                @if($doc->file_url)
                                    <a href="{{ asset($doc->file_url) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="fa fa-file-pdf-o text-danger"></i> PDF ({{ $doc->file_size ?? 'Download' }})
                                    </a>
                                @else
                                    <span class="text-muted small">No file</span>
                                @endif
                            </td>
                            <td><small class="text-muted">{{ $doc->published_date ? $doc->published_date->format('d-m-Y') : '-' }}</small></td>
                            <td>
                                @if($doc->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.documents.edit', $doc->id) }}" class="btn btn-outline-primary btn-sm me-1" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.documents.destroy', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this document?');">
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
                            <td colspan="6" class="text-center py-4 text-muted">No documents uploaded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
