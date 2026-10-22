@extends('layouts.admin')

@section('title', 'Schemes & Services Management')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">verified</span> Schemes & Services List
        </h5>
        <a href="{{ route('admin.schemes.create') }}" class="btn btn-cms-primary btn-sm d-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Add New Scheme
        </a>
    </div>
    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schemes as $s)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $s->title_en ?: $s->title_hi }}</div>
                                @if($s->title_hi && $s->title_en)
                                    <div class="small text-muted">{{ $s->title_hi }}</div>
                                @endif
                            </td>
                            <td><small class="text-muted">{{ Str::limit($s->description_en ?: $s->description_hi, 60) }}</small></td>
                            <td>
                                <span class="badge bg-light text-dark border text-uppercase">{{ $s->category }}</span>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $s->sort_order }}</span></td>
                            <td>
                                @if($s->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.schemes.edit', $s->id) }}" class="btn btn-outline-primary btn-sm me-1" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.schemes.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this scheme?');">
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
                            <td colspan="6" class="text-center py-4 text-muted">No schemes available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
