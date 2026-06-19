@extends('layouts.app')

@section('title', 'User Block Assignments')

@section('content')
<div class="card p-4">
    <h3>User Block Assignments</h3>

    @if ($message = Session::get('status'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.user-block-assignments.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Select User</label>
                <select name="user_id" class="form-control" required onchange="if(this.value){ window.location.href = '{{ route('admin.user-block-assignments.index') }}?user_id=' + this.value; }">
                    <option value="">Choose User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $selectedUserId) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Select Blocks</label>
                <select name="block_ids[]" class="form-control" multiple size="3" required>
                    @foreach($blocks as $block)
                        <option value="{{ $block->id }}" {{ in_array($block->id, old('block_ids', $selectedBlockIds), true) ? 'selected' : '' }}>
                            {{ $block->name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Hold Ctrl/Cmd to select multiple blocks.</small>
            </div>
        </div>
        <button class="btn btn-primary">Save Assignment</button>
    </form>

    <hr class="my-4">

    <h5>Current Assignments</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-striped mb-0">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Block</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->user?->name }}</td>
                        <td>{{ $assignment->user?->email }}</td>
                        <td>{{ $assignment->block?->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No assignments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
