@extends('layouts.admin')

@section('title', 'Campaigns & Initiatives Management')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-danger">campaign</span> Campaigns & Initiatives List
        </h5>
        <a href="{{ route('admin.campaigns.create') }}" class="btn btn-cms-primary btn-sm d-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Add New Campaign
        </a>
    </div>
    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th style="width: 100px;">Banner</th>
                        <th>Title</th>
                        <th>Target Link</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $c)
                        <tr>
                            <td>
                                <img src="{{ asset($c->image_url) }}" alt="Preview" style="height: 40px; width: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;">
                            </td>
                            <td>
                                <div class="fw-bold">{{ $c->title_en ?: $c->title_hi }}</div>
                                @if($c->title_hi && $c->title_en)
                                    <small class="text-muted">{{ $c->title_hi }}</small>
                                @endif
                            </td>
                            <td><a href="{{ $c->link_url }}" target="_blank" class="small">{{ Str::limit($c->link_url, 30) }}</a></td>
                            <td><span class="badge bg-light text-dark border">{{ $c->sort_order }}</span></td>
                            <td>
                                @if($c->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.campaigns.edit', $c->id) }}" class="btn btn-outline-primary btn-sm me-1" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.campaigns.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this campaign?');">
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
                            <td colspan="6" class="text-center py-4 text-muted">No campaigns available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
