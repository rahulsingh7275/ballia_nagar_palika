@extends('layouts.app')

@section('title', 'Assigned Blocks')

@section('content')
<div class="card p-4">
    <h3>Assigned Blocks</h3>
    <p class="text-muted mb-4">User: {{ $user->name }} ({{ $user->email }})</p>

    @if($blocks->isEmpty())
        <div class="alert alert-warning">No blocks assigned to this user.</div>
    @else
        <div class="mb-3">
            <label class="form-label">Select Block</label>
            <select class="form-control" name="block_id">
                <option value="">Choose a block</option>
                @foreach($blocks as $block)
                    <option value="{{ $block->id }}">{{ $block->name }}</option>
                @endforeach
            </select>
        </div>
    @endif
</div>
@endsection
