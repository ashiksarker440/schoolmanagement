@extends('layouts.admin')
@section('title', 'sections Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $section->name }}</h3>
        </div>
    </div>
@endsection