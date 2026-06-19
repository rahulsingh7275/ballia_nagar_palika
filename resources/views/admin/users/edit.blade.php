@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="card p-4">
    <h3>Edit User</h3>
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role_id" class="form-select" required>
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                        {{ $role->label }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Blocks</label>
            <select name="block_ids[]" class="form-control" multiple size="8">
                @foreach($blocks as $block)
                    <option value="{{ $block->id }}" {{ in_array($block->id, old('block_ids', $user->blocks->pluck('id')->all()), true) ? 'selected' : '' }}>
                        {{ $block->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl/Cmd to select multiple blocks.</small>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary">Update User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
