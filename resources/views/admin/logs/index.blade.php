@extends('layouts.admin')

@section('title', 'Audit & Security Logs')

@section('content')
<div class="cms-card">
    <div class="cms-card-header flex-wrap gap-2">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-danger">history</span> System Activity & Audit Logs
        </h5>

        <div class="d-flex align-items-center gap-2">
            @if(auth()->user()->isSuperAdmin())
                <form action="{{ route('admin.logs.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all audit logs?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fa fa-trash me-1"></i> Clear All Logs
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Filters -->
    <div class="p-3 bg-light border-bottom">
        <form action="{{ route('admin.logs.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search (User, IP, Details)..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="module" class="form-select form-select-sm">
                    <option value="">All Modules</option>
                    @foreach($modules as $m)
                        <option value="{{ $m }}" {{ request('module') === $m ? 'selected' : '' }}>{{ strtoupper($m) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="action" class="form-select form-select-sm">
                    <option value="">All Actions</option>
                    @foreach($actions as $a)
                        <option value="{{ $a }}" {{ request('action') === $a ? 'selected' : '' }}>{{ strtoupper($a) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-grow-1">Filter</button>
                <a href="{{ route('admin.logs.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="cms-card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Module</th>
                        <th>Details</th>
                        <th>IP Address</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td><small class="text-muted">{{ $log->id }}</small></td>
                            <td>
                                <strong class="text-dark">{{ $log->user_name ?? 'System / Guest' }}</strong>
                                @if($log->user)
                                    <div class="small text-muted">{{ $log->user->email }}</div>
                                @endif
                            </td>
                            <td>
                                @if($log->action === 'create')
                                    <span class="badge bg-success">Created</span>
                                @elseif($log->action === 'update' || $log->action === 'update_status')
                                    <span class="badge bg-primary">Updated</span>
                                @elseif($log->action === 'delete')
                                    <span class="badge bg-danger">Deleted</span>
                                @elseif($log->action === 'login')
                                    <span class="badge bg-info text-dark">Login</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($log->action) }}</span>
                                @endif
                            </td>
                            <td><span class="text-uppercase small fw-semibold text-secondary">{{ $log->module }}</span></td>
                            <td><small class="text-dark">{{ $log->details }}</small></td>
                            <td><small class="text-muted"><code>{{ $log->ip_address }}</code></small></td>
                            <td><small class="text-muted">{{ $log->created_at->diffForHumans() }}</small></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No activity logs recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($logs->hasPages())
        <div class="p-3 border-top">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection
