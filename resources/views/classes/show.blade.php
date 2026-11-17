@extends('layouts.admin')
@section('title', 'Class Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $class->name }} {{ $class->section }}</h3>
        </div>
    </div>
@endsection