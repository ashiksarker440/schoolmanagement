@extends('layouts.admin')
@section('title', 'departments Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $department->name }} {{ $department->section }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Teacher:</strong> {{ $department->teacher->name ?? 'Not Assigned' }}</p>
            <p><strong>Total Students:</strong> {{ $department->students->count() }}</p>
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@endsection