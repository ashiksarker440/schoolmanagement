@extends('layouts.master')
@section('title', 'Student Details')

@section('content')
    @php
        $genders = [1 => 'Male', 2 => 'Female', 3 => 'Other'];
        $religions = [1 => 'Islam', 2 => 'Hindu', 3 => 'Christian', 4 => 'Buddhist', 5 => 'Other'];
    @endphp

    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-person-vcard" aria-hidden="true"></i></span>
                <div>
                    <h1 class="h3 mb-1">{{ $student->name }}</h1>
                    <p class="text-muted mb-0">Student details</p>
                </div>
            </div>
            <div class="heading-actions">
                <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-4 mb-3">
                <section class="panel h-100">
                    <div class="card-body text-center">
                        @if($student->photo)
                            <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}"
                                class="rounded-circle mb-3" width="100" height="100" style="object-fit: cover;">
                        @else
                            <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
                        @endif
                        <h2 class="h5">{{ $student->name }}</h2>
                        <p class="text-muted">Student ID: {{ $student->id }}</p>
                        <dl class="row text-left mb-0">
                            <dt class="col-5">Roll</dt>
                            <dd class="col-7">{{ $student->enrollment?->roll_no ?? '-' }}</dd>
                            <dt class="col-5">Class</dt>
                            <dd class="col-7">{{ $student->enrollment?->classRoom?->name ?? '-' }}</dd>
                            <dt class="col-5">Section</dt>
                            <dd class="col-7">{{ $student->enrollment?->section?->name ?? '-' }}</dd>
                            <dt class="col-5">Session</dt>
                            <dd class="col-7">{{ $student->enrollment?->studentSession?->name ?? '-' }}</dd>
                        </dl>
                    </div>
                </section>
            </div>

            <div class="col-lg-8">
                <section class="panel mb-3">
                    <div class="panel-header">
                        <h2 class="h5 mb-0">Personal Information</h2>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Date of Birth</dt>
                            <dd class="col-sm-8">{{ $student->date_of_birth?->format('d M Y') ?? '-' }}</dd>

                            <dt class="col-sm-4">Gender</dt>
                            <dd class="col-sm-8">{{ $genders[$student->gender] ?? '-' }}</dd>

                            <dt class="col-sm-4">Religion</dt>
                            <dd class="col-sm-8">{{ $religions[$student->religion] ?? '-' }}</dd>

                            <dt class="col-sm-4">Blood Group</dt>
                            <dd class="col-sm-8">{{ $student->blood_group ?? '-' }}</dd>

                            <dt class="col-sm-4">Birth Certificate</dt>
                            <dd class="col-sm-8">{{ $student->birth_certificate ?? '-' }}</dd>

                            <dt class="col-sm-4">Address</dt>
                            <dd class="col-sm-8">{{ $student->address ?? '-' }}</dd>
                        </dl>
                    </div>
                </section>

                <section class="panel mb-3">
                    <div class="panel-header">
                        <h2 class="h5 mb-0">Family & Guardian Information</h2>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Father</dt>
                            <dd class="col-sm-8">
                                {{ $student->father_name ?? '-' }}
                                @if($student->father_phone || $student->father_profession)
                                    <br><small class="text-muted">
                                        {{ $student->father_phone ?? '-' }} · {{ $student->father_profession ?? '-' }}
                                    </small>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Mother</dt>
                            <dd class="col-sm-8">
                                {{ $student->mother_name ?? '-' }}
                                @if($student->mother_phone || $student->mother_profession)
                                    <br><small class="text-muted">
                                        {{ $student->mother_phone ?? '-' }} · {{ $student->mother_profession ?? '-' }}
                                    </small>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Guardian</dt>
                            <dd class="col-sm-8">{{ $student->guardian_name ?? '-' }}</dd>

                            <dt class="col-sm-4">Guardian Phone</dt>
                            <dd class="col-sm-8">{{ $student->guardian_phone ?? '-' }}</dd>
                        </dl>
                    </div>
                </section>

                <section class="panel">
                    <div class="panel-header">
                        <h2 class="h5 mb-0">Latest Academic Information</h2>
                    </div>
                    <div class="card-body">
                        @if($student->enrollment)
                            <dl class="row mb-0">
                                <dt class="col-sm-4">Class</dt>
                                <dd class="col-sm-8">{{ $student->enrollment->classRoom?->name ?? '-' }}</dd>

                                <dt class="col-sm-4">Section</dt>
                                <dd class="col-sm-8">{{ $student->enrollment->section?->name ?? '-' }}</dd>

                                <dt class="col-sm-4">Session</dt>
                                <dd class="col-sm-8">{{ $student->enrollment->studentSession?->name ?? '-' }}</dd>

                                <dt class="col-sm-4">Shift</dt>
                                <dd class="col-sm-8">{{ $student->enrollment->shift?->name ?? '-' }}</dd>

                                <dt class="col-sm-4">Group</dt>
                                <dd class="col-sm-8">{{ $student->enrollment->group?->name ?? '-' }}</dd>

                                <dt class="col-sm-4">Roll Number</dt>
                                <dd class="col-sm-8">{{ $student->enrollment->roll_no ?? '-' }}</dd>

                                <dt class="col-sm-4">Enrollment Date</dt>
                                <dd class="col-sm-8">
                                    {{ $student->enrollment->enrollment_date?->format('d M Y') ?? '-' }}
                                </dd>
                            </dl>
                        @else
                            <p class="text-muted mb-0">No enrollment information is available.</p>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
