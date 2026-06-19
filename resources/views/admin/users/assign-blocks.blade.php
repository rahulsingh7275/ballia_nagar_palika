@extends('layouts.app')

@section('title', 'Assign Blocks')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3>Assign Blocks</h3>
            <p class="mb-0 text-muted">{{ $user->name }} ({{ $user->email }})</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
    </div>

    @if ($message = Session::get('status'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store-blocks', $user) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Select Blocks</label>
            <select name="block_ids[]" class="form-control" multiple size="10">
                @foreach($blocks as $block)
                    <option value="{{ $block->id }}" {{ in_array($block->id, old('block_ids', $user->blocks->pluck('id')->all()), true) ? 'selected' : '' }}>
                        {{ $block->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl/Cmd to select multiple blocks.</small>
        </div>
        <button class="btn btn-primary">Save Blocks</button>
    </form>
</div>
@endsection
