@extends('layouts.master')
@section('title', 'Session Details')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-calendar3"></i></span>
                <div>
                    <h1 class="h3 mb-1">{{ $session->name }}</h1>
                </div>
            </div>
            <div class="heading-actions">
                <a href="{{ route('sessions.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <section class="panel mt-3">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">Session Name</dt>
                    <dd class="col-sm-9"><strong>{{ $session->name }}</strong></dd>

                    <dt class="col-sm-3">Created At</dt>
                    <dd class="col-sm-9">{{ $session->created_at?->format('d M Y, h:i A') ?? '-' }}</dd>

                    <dt class="col-sm-3">Last Updated</dt>
                    <dd class="col-sm-9">{{ $session->updated_at?->format('d M Y, h:i A') ?? '-' }}</dd>
                </dl>
            </div>
            <div class="card-footer">
                <a href="{{ route('sessions.edit', $session) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('sessions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </section>
    </div>
@endsection