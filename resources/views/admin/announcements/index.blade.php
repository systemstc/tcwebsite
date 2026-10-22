@extends('layouts.admin')

@section('title', 'Announcements Management')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">campaign</span> Scrolling Announcements List
        </h5>
        <a href="{{ route('admin.announcements.create') }}" class="btn btn-cms-primary btn-sm d-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Add New Announcement
        </a>
    </div>
    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Announcement Details</th>
                        <th>Target Link</th>
                        <th>Tag</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($announcements as $a)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $a->title_en ?: $a->title_hi }}</div>
                                @if($a->title_hi && $a->title_en)
                                    <div class="small text-muted">{{ $a->title_hi }}</div>
                                @endif
                            </td>
                            <td><a href="{{ $a->link_url }}" target="_blank" class="small">{{ Str::limit($a->link_url, 30) }}</a></td>
                            <td>
                                @if($a->is_new)
                                    <span class="badge bg-danger">NEW</span>
                                @else
                                    <span class="badge bg-light text-dark border">Normal</span>
                                @endif
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $a->sort_order }}</span></td>
                            <td>
                                @if($a->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.announcements.edit', $a->id) }}" class="btn btn-outline-primary btn-sm me-1" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.announcements.destroy', $a->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
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
                            <td colspan="6" class="text-center py-4 text-muted">No announcements available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
