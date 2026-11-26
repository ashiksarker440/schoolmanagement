@extends('layouts.master')
@section('title', 'Subject Details')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-book"></i></span>
            <div><h1 class="h3 mb-1">{{ $subject->name }}</h1></div>
        </div>
        <div class="heading-actions">
            <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>

    <section class="panel mt-3">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Subject ID</dt>
                <dd class="col-sm-9">{{ $subject->subject_id ?? '-' }}</dd>

                <dt class="col-sm-3">Name</dt>
                <dd class="col-sm-9"><strong>{{ $subject->name }}</strong></dd>

                <dt class="col-sm-3">Code</dt>
                <dd class="col-sm-9">{{ $subject->code ?? '-' }}</dd>

                <dt class="col-sm-3">Mark Type</dt>
                <dd class="col-sm-9">
                    <span class="badge bg-info">
                        {{ \App\Models\Subject::markTypes()[$subject->mark_type] ?? $subject->mark_type }}
                    </span>
                </dd>

                <dt class="col-sm-3">Description</dt>
                <dd class="col-sm-9">{{ $subject->description ?? '-' }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    @if($subject->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Inactive</span>
                    @endif
                </dd>
            </dl>
        </div>
        <div class="card-footer">
            <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
            <a href="{{ route('subjects.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </section>
</div>
@endsection