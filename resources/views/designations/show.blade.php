@extends('layouts.admin')
@section('title', 'designations Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $Designations->name }} {{ $Designations->section }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Teacher:</strong> {{ $Designations->teacher->name ?? 'Not Assigned' }}</p>
            <p><strong>Total Students:</strong> {{ $Designations->students->count() }}</p>
            <a href="{{ route('designations.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@endsection