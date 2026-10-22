@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="cms-card">
    <div class="cms-card-header">
        <h5 class="cms-card-title">
            <span class="material-symbols-outlined text-primary">edit</span> Edit User Account
        </h5>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to List</a>
    </div>
    <div class="cms-card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">New Password (Leave blank to keep current)</label>
                    <input type="password" name="password" class="form-control" placeholder="Optional new password">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter new password">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-select" required>
                        <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>Editor (Can create & edit content)</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin (Can manage modules and users)</option>
                        <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>Super Admin (Full system control)</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-center mt-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" {{ $user->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActive">Account Active</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                <button type="submit" class="btn btn-cms-primary px-4">Update User</button>
            </div>
        </form>
    </div>
</div>
@endsection
