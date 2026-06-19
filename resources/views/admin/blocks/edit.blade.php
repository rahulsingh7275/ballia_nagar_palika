@extends('layouts.app')

@section('title', 'Edit Block')

@section('content')
<div class="card p-4">
    <h3>Edit Block</h3>
    <form method="POST" action="{{ route('admin.blocks.update', $block) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Block Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $block->name) }}" required>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary">Update Block</button>
            <a href="{{ route('admin.blocks.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
