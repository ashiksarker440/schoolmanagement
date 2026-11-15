@extends('layouts.master')
@section('title', 'Add Student')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-person" aria-hidden="true"></i></span>
                <div>
                    <h1 class="h3 mb-1">Add Students</h1>
                </div>
            </div>

        </div>

        <section class="panel mt-3">
            <form action="{{ route('students.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <h5 class="text-primary mb-3">Login Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" required>
                                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required>
                                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5 class="text-primary mb-3">Academic Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class <span class="text-danger">*</span></label>
                                <select name="class_id" class="form-control @error('class_id') is-invalid @enderror"
                                    required>
                                    <option value="">-- Select Class --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" @selected(old('class_id') == $class->id)>
                                            {{ $class->name }} {{ $class->section }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Roll Number <span class="text-danger">*</span></label>
                                <input type="text" name="roll_number"
                                    class="form-control @error('roll_number') is-invalid @enderror"
                                    value="{{ old('roll_number') }}" required>
                                @error('roll_number')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" name="date_of_birth"
                                    class="form-control @error('date_of_birth') is-invalid @enderror"
                                    value="{{ old('date_of_birth') }}" required>
                                @error('date_of_birth')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5 class="text-primary mb-3">Guardian Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Guardian Name <span class="text-danger">*</span></label>
                                <input type="text" name="guardian_name"
                                    class="form-control @error('guardian_name') is-invalid @enderror"
                                    value="{{ old('guardian_name') }}" required>
                                @error('guardian_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Guardian Phone <span class="text-danger">*</span></label>
                                <input type="text" name="guardian_phone"
                                    class="form-control @error('guardian_phone') is-invalid @enderror"
                                    value="{{ old('guardian_phone') }}" required>
                                @error('guardian_phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" rows="2" class="form-control">{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary"><i class="fas fa-save"></i> Save Student</button>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </section>
    </div>
@endsection