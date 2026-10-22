@extends('layouts.admin')

@section('title', 'Dignitaries & Ministers Management')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-danger">badge</span> Leadership & Dignitaries List
        </h5>
        <a href="{{ route('admin.dignitaries.create') }}" class="btn btn-cms-primary btn-sm d-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Add New Dignitary
        </a>
    </div>
    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th style="width: 80px;">Photo</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Category</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dignitaries as $d)
                        <tr>
                            <td>
                                <img src="{{ asset($d->photo_url) }}" alt="{{ $d->name_en }}" style="width: 45px; height: 45px; object-fit: cover; border-radius: 50%; border: 2px solid #cbd5e1;">
                            </td>
                            <td>
                                <div class="fw-bold">{{ $d->name_en }}</div>
                                @if($d->name_hi)
                                    <div class="small text-muted">{{ $d->name_hi }}</div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $d->designation_en }}</div>
                                @if($d->designation_hi)
                                    <small class="text-muted">{{ $d->designation_hi }}</small>
                                @endif
                            </td>
                            <td>
                                @if($d->type === 'prime_minister')
                                    <span class="badge bg-warning text-dark">Prime Minister</span>
                                @elseif($d->type === 'minister')
                                    <span class="badge bg-danger">Union Minister</span>
                                @elseif($d->type === 'secretary')
                                    <span class="badge bg-primary">Secretary</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $d->type)) }}</span>
                                @endif
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $d->sort_order }}</span></td>
                            <td>
                                @if($d->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.dignitaries.edit', $d->id) }}" class="btn btn-outline-primary btn-sm me-1" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.dignitaries.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this dignitary?');">
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
                            <td colspan="7" class="text-center py-4 text-muted">No dignitaries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
