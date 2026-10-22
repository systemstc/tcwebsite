@extends('layouts.admin')

@section('title', 'Important Links Management')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">link</span> Important Links Directory
        </h5>
        <a href="{{ route('admin.important-links.create') }}" class="btn btn-cms-primary btn-sm d-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Add New Link
        </a>
    </div>
    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Target URL</th>
                        <th>Category</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($links as $l)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $l->title_en ?: $l->title_hi }}</div>
                                @if($l->title_hi && $l->title_en)
                                    <small class="text-muted">{{ $l->title_hi }}</small>
                                @endif
                            </td>
                            <td><a href="{{ $l->url }}" target="_blank" class="small">{{ Str::limit($l->url, 35) }}</a></td>
                            <td><span class="badge bg-light text-dark border text-uppercase">{{ $l->category }}</span></td>
                            <td><span class="badge bg-light text-dark border">{{ $l->sort_order }}</span></td>
                            <td>
                                @if($l->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.important-links.edit', $l->id) }}" class="btn btn-outline-primary btn-sm me-1" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.important-links.destroy', $l->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this link?');">
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
                            <td colspan="6" class="text-center py-4 text-muted">No important links recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
