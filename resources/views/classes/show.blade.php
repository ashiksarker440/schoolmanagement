@extends('layouts.admin')
@section('title', 'Class Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $class->name }} {{ $class->section }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Teacher:</strong> {{ $class->teacher->name ?? 'Not Assigned' }}</p>
            <p><strong>Total Students:</strong> {{ $class->students->count() }}</p>
            <a href="{{ route('classes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@endsection