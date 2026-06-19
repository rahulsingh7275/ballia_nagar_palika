@extends('layouts.app')

@section('title', 'Block Management')

@section('content')
<hr />
<div class="d-flex justify-content-between align-items-center mb-4 p-4">
    <h3>Manage Blocks</h3>
    <a href="{{ route('admin.blocks.create') }}" class="btn btn-primary">Create Block</a>
</div>

@if ($message = Session::get('status'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card p-3">
    <table class="table table-striped table-bordered mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($blocks as $block)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $block->name }}</td>
                    <td>{{ $block->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.blocks.edit', $block) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ route('admin.blocks.destroy', $block) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No blocks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
