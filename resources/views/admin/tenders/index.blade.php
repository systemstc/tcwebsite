@extends('layouts.admin')

@section('title', 'Tenders & Vacancies Management')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-success">gavel</span> Tenders & Vacancies List
        </h5>
        <a href="{{ route('admin.tenders.create') }}" class="btn btn-cms-primary btn-sm d-flex align-items-center gap-1">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span> Add New Tender / Vacancy
        </a>
    </div>
    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Ref. No.</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Published Date</th>
                        <th>Closing Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tenders as $t)
                        <tr>
                            <td><span class="badge bg-light text-dark border">{{ $t->reference_no ?? 'N/A' }}</span></td>
                            <td>
                                <div class="fw-bold">{{ $t->title_en ?: $t->title_hi }}</div>
                                @if($t->title_hi && $t->title_en)
                                    <small class="text-muted">{{ $t->title_hi }}</small>
                                @endif
                            </td>
                            <td>
                                @if($t->type === 'tender')
                                    <span class="badge bg-primary">Tender</span>
                                @elseif($t->type === 'vacancy')
                                    <span class="badge bg-success">Vacancy</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($t->type) }}</span>
                                @endif
                            </td>
                            <td><small class="text-muted">{{ $t->published_date ? $t->published_date->format('d-m-Y') : '-' }}</small></td>
                            <td>
                                <strong class="text-danger small">{{ $t->closing_date ? $t->closing_date->format('d-m-Y') : 'Open' }}</strong>
                            </td>
                            <td>
                                @if($t->status === 'open')
                                    <span class="badge bg-success">Open</span>
                                @else
                                    <span class="badge bg-secondary">Closed</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.tenders.edit', $t->id) }}" class="btn btn-outline-primary btn-sm me-1" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.tenders.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this tender/vacancy?');">
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
                            <td colspan="7" class="text-center py-4 text-muted">No tenders or vacancies available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
