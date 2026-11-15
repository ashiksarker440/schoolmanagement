@extends('layouts.admin')
@section('title', 'Student Details')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <i class="fas fa-user-circle fa-5x text-primary"></i>
                </div>
                <h3 class="profile-username text-center mt-2">{{ $student->user->name }}</h3>
                <p class="text-muted text-center">{{ $student->user->email }}</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item"><b>Roll</b> <span class="float-right">{{ $student->roll_number }}</span></li>
                    <li class="list-group-item"><b>Class</b> <span class="float-right">{{ $student->classRoom->name ?? '-' }}</span></li>
                    <li class="list-group-item"><b>DOB</b> <span class="float-right">{{ $student->date_of_birth?->format('d M Y') }}</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Guardian & Other Info</h3></div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Guardian</dt><dd class="col-sm-9">{{ $student->guardian_name }}</dd>
                    <dt class="col-sm-3">Phone</dt><dd class="col-sm-9">{{ $student->guardian_phone }}</dd>
                    <dt class="col-sm-3">Address</dt><dd class="col-sm-9">{{ $student->address ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection