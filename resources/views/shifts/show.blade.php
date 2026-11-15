@extends('layouts.admin')
@section('title', 'shifts Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $shift->name }} {{ $shift->section }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Teacher:</strong> {{ $shift->teacher->name ?? 'Not Assigned' }}</p>
            <p><strong>Total Students:</strong> {{ $shift->students->count() }}</p>
            <a href="{{ route('shifts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@endsection