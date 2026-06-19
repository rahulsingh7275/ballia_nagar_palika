@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card p-4">
            <div class="row">
                <div class="col-md-6">
                    <h2>Welcome, {{ $user->name }}</h2>
                    <p class="text-muted mb-0">Role: {{ $user->role?->label ?? 'User' }}</p>
                </div>
                <form method="GET" action="{{ route('dashboard') }}" class="col-md-6">
                    <div class="row">
                        <div class="col-6">
                        <label for="block_id" class="form-label mb-1">Filter by Block</label>
                        <select name="block_id" id="block_id" class="form-control">
                            <option value="">{{ $user->isAdmin() ? 'All Blocks' : 'All Assigned Blocks' }}</option>
                            @foreach($blocks as $block)
                                <option value="{{ $block->id }}" {{ (string) $selectedBlockId === (string) $block->id ? 'selected' : '' }}>
                                    {{ $block->name }}
                                </option>
                            @endforeach
                        </select>
                        </div>
                        <div class="col-6">
                            <label for="block_id"  class="form-label mb-1 col-12">&nbsp;</label>
<button type="submit" class="btn btn-primary btn-sm">Apply</button>
                        </div>
                    </div>

                   
                    
                </form>
            </div>

            <div class="row mt-4 g-3">
                <div class="col-md-3">
                    <div class="card bg-light shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="text-muted">House Tax Amount</h6>
                            <h3 class="mb-0">₹ {{ number_format($summary['house_tax'] ?? 0, 2) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="text-muted">Water Tax Amount</h6>
                            <h3 class="mb-0">₹ {{ number_format($summary['water_tax'] ?? 0, 2) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-light shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="text-muted">Sewer Tax Amount</h6>
                            <h3 class="mb-0">₹ {{ number_format($summary['sewer_tax'] ?? 0, 2) }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="text-white">Total Amount</h6>
                            <h3 class="mb-0 text-white">₹ {{ number_format($summary['total_tax'] ?? 0, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
