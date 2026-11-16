@extends('layouts.admin')
@section('title', 'Teachers Details')

@section('content')
    <div class="row">
        {{-- Left: Profile Card --}}
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @if($teacher->photo)
                            <img src="{{ asset('storage/teachers/' . $teacher->photo) }}" alt="{{ $teacher->name }}"
                                class="img-circle elevation-2" width="100" height="100" style="object-fit: cover;">
                        @else
                            <i class="fas fa-user-circle fa-5x text-primary"></i>
                        @endif
                    </div>
                    <h3 class="profile-username text-center mt-2">{{ $teacher->name }}</h3>
                    <p class="text-muted text-center">
                        {{ $teacher->main_subject ?? 'Teacher' }}
                        @if($teacher->status === 'active')
                            <span class="badge badge-success ml-1">Active</span>
                        @else
                            <span class="badge badge-secondary ml-1">Inactive</span>
                        @endif
                    </p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Email</b>
                            <span class="float-right">{{ $teacher->email ?? '-' }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Phone</b>
                            <span class="float-right">{{ $teacher->phone ?? '-' }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Gender</b>
                            <span class="float-right">{{ ucfirst($teacher->gender ?? '-') }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Qualification</b>
                            <span class="float-right">{{ $teacher->qualification ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Right: Details --}}
        <div class="col-md-8">
            {{-- Professional Info --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Professional Info</h3>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Main Subject</dt>
                        <dd class="col-sm-9">{{ $teacher->main_subject ?? '-' }}</dd>

                        <dt class="col-sm-3">Salary</dt>
                        <dd class="col-sm-9">
                            {{ $teacher->salary ? '৳ ' . number_format($teacher->salary, 2) : '-' }}
                        </dd>

                        <dt class="col-sm-3">Joining Date</dt>
                        <dd class="col-sm-9">{{ $teacher->joining_date?->format('d M Y') ?? '-' }}</dd>

                        <dt class="col-sm-3">Address</dt>
                        <dd class="col-sm-9">{{ $teacher->address ?? '-' }}</dd>
                    </dl>
                </div>
            </div>

            {{-- Assigned Classes --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Assigned Classes ({{ $teacher->classes->count() }})</h3>
                </div>
                <div class="card-body">
                    @forelse($teacher->classes as $class)
                        <span class="badge badge-info p-2 mb-2">
                            <i class="fas fa-chalkboard"></i>
                            {{ $class->name }} {{ $class->section }}
                        </span>
                    @empty
                        <p class="text-muted mb-0">No classes assigned yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Back Button --}}
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Teachers
            </a>
            <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
@endsection