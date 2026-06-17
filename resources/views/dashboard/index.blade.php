@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card p-4">
            <h2>Welcome, {{ $user->name }}</h2>
            <p class="text-muted">Role: {{ $user->role?->label ?? 'User' }}</p>
            <div class="row mt-4 g-3">
                
            </div>
        </div>
    </div>
</div>
@endsection
