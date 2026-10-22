@extends('layouts.admin')

@section('title', 'Hero Banners Management')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-danger">view_carousel</span> Slider Banners List
        </h5>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-cms-primary btn-sm d-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Add New Banner
        </a>
    </div>
    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th style="width: 100px;">Preview</th>
                        <th>Title (Hindi / English)</th>
                        <th>Subtitle</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $b)
                        <tr>
                            <td>
                                <img src="{{ asset($b->image_url) }}" alt="Preview" style="height: 48px; width: 85px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;">
                            </td>
                            <td>
                                <div class="fw-bold">{{ $b->title_hi }}</div>
                                <div class="small text-muted">{{ $b->title_en }}</div>
                            </td>
                            <td><small class="text-muted">{{ Str::limit($b->subtitle_hi ?? $b->subtitle_en, 50) }}</small></td>
                            <td><span class="badge bg-light text-dark border">{{ $b->sort_order }}</span></td>
                            <td>
                                @if($b->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.banners.edit', $b->id) }}" class="btn btn-outline-primary btn-sm me-1" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.banners.destroy', $b->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this banner?');">
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
                            <td colspan="6" class="text-center py-4 text-muted">No banners found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
