@extends('layouts.admin')

@section('title', 'Related Links & Portals Management')

@section('content')
<div class="cms-card">
    <div class="cms-card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h5 class="cms-card-title mb-1">
                <span class="material-symbols-outlined text-primary">link</span> Related Links & Portals Directory
            </h5>
            <small class="text-muted">Portals and links managed here are displayed dynamically on the public <a href="{{ route('related-links.index') }}" target="_blank" class="fw-bold text-decoration-none" style="color: #500a2f;"><i class="fa-solid fa-arrow-up-right-from-square small"></i> /related-links</a> page linked in the website footer.</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('related-links.index') }}" target="_blank" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                <span class="material-symbols-outlined" style="font-size: 18px;">visibility</span> View Public Page
            </a>
            <a href="{{ route('admin.important-links.create') }}" class="btn btn-cms-primary btn-sm d-flex align-items-center gap-1">
                <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Add New Portal / Link
            </a>
        </div>
    </div>
    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle m-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">Order</th>
                        <th>Portal / Link Title</th>
                        <th>Target URL</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($links as $l)
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $l->sort_order }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $l->title_en ?: $l->title_hi }}</div>
                                @if($l->title_hi && $l->title_hi !== $l->title_en)
                                    <small class="text-muted">{{ $l->title_hi }}</small>
                                @endif
                            </td>
                            <td>
                                <a href="{{ $l->url }}" target="_blank" class="small text-decoration-none d-inline-flex align-items-center gap-1" style="color: #500a2f;">
                                    <span>{{ Str::limit($l->url, 45) }}</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i>
                                </a>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $l->category }}</span></td>
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
                                <form action="{{ route('admin.important-links.destroy', $l->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this portal link?');">
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
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-link-slash fa-2x mb-3 text-secondary d-block"></i>
                                No portal links found. Click <strong>"Add New Portal / Link"</strong> to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
