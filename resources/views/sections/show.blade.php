@extends('layouts.admin')
@section('title', 'sections Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $section->name }} {{ $section->section }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Teacher:</strong> {{ $section->teacher->name ?? 'Not Assigned' }}</p>
            <p><strong>Total Students:</strong> {{ $section->students->count() }}</p>
            <a href="{{ route('sections.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@endsection