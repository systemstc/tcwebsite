@extends('layouts.admin')

@section('title', 'User Personas Management')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">groups</span> User Personas & Target Audiences
        </h5>
        <a href="{{ route('admin.personas.create') }}" class="btn btn-cms-primary btn-sm d-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Add New Persona
        </a>
    </div>
    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Target Link</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($personas as $p)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $p->title_en ?: $p->title_hi }}</div>
                                @if($p->title_hi && $p->title_en)
                                    <small class="text-muted">{{ $p->title_hi }}</small>
                                @endif
                            </td>
                            <td><small class="text-muted">{{ Str::limit($p->description_en ?: $p->description_hi, 50) }}</small></td>
                            <td><a href="{{ $p->link_url }}" target="_blank" class="small">{{ Str::limit($p->link_url, 30) }}</a></td>
                            <td><span class="badge bg-light text-dark border">{{ $p->sort_order }}</span></td>
                            <td>
                                @if($p->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.personas.edit', $p->id) }}" class="btn btn-outline-primary btn-sm me-1" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.personas.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this persona?');">
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
                            <td colspan="6" class="text-center py-4 text-muted">No user personas configured.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
