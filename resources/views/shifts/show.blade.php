@extends('layouts.master')
@section('title', 'Shift Details')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-clock-history"></i></span>
                <div>
                    <h1 class="h3 mb-1">Shift Details</h1>
                </div>
            </div>
            <div class="heading-actions">
                <a href="{{ route('shifts.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to Shifts
                </a>
            </div>
        </div>

        <section class="panel mt-3">
            <div class="card-body">
                <h3 class="mb-4">{{ $shift->name }}</h3>

                <dl class="row mb-0">
                    <dt class="col-sm-3">Shift Name</dt>
                    <dd class="col-sm-9"><strong>{{ $shift->name }}</strong></dd>

                    <dt class="col-sm-3">Start Time</dt>
                    <dd class="col-sm-9">
                        @if($shift->start_time)
                            <span class="badge badge-info">
                                <i class="bi bi-clock"></i> {{ $shift->start_time }}
                            </span>
                        @else
                            -
                        @endif
                    </dd>

                    <dt class="col-sm-3">End Time</dt>
                    <dd class="col-sm-9">
                        @if($shift->end_time)
                            <span class="badge badge-info">
                                <i class="bi bi-clock-fill"></i> {{ $shift->end_time }}
                            </span>
                        @else
                            -
                        @endif
                    </dd>

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9">
                        @if($shift->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-secondary">Inactive</span>
                        @endif
                    </dd>

                    <dt class="col-sm-3">Created At</dt>
                    <dd class="col-sm-9">{{ $shift->created_at?->format('d M Y, h:i A') ?? '-' }}</dd>

                    <dt class="col-sm-3">Last Updated</dt>
                    <dd class="col-sm-9">{{ $shift->updated_at?->format('d M Y, h:i A') ?? '-' }}</dd>
                </dl>
            </div>
            <div class="card-footer">
                <a href="{{ route('shifts.edit', $shift) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('shifts.destroy', $shift) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this shift?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                <a href="{{ route('shifts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </section>
    </div>
@endsection