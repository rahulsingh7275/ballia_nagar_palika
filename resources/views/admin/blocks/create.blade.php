@extends('layouts.app')

@section('title', 'Create Block')

@section('content')
<hr />
<div class="card p-4">
    <h3>Create New Block</h3>
    <form method="POST" action="{{ route('admin.blocks.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Block Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <button class="btn btn-primary">Create Block</button>
        <a href="{{ route('admin.blocks.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
