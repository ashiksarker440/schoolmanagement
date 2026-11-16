@extends('layouts.master')
@section('title', 'Edit Teachers')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
                <div>
                    <h1 class="h3 mb-1">Update Teacher</h1>
                </div>
            </div>
        </div>

        <section class="panel mt-3">
            <form action="{{ route('teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">

                    {{-- Login Information --}}
                    <h5 class="text-primary mb-3">Login Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $teacher->name) }}" required>
                                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $teacher->email) }}" required>
                                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>New Password <small class="text-muted">(leave empty to keep)</small></label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror">
                                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    {{-- Personal Information --}}
                    <h5 class="text-primary mb-3">Personal Information</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                    <option value="">-- Select Gender --</option>
                                    <option value="male" @selected(old('gender', $teacher->gender) == 'male')>Male</option>
                                    <option value="female" @selected(old('gender', $teacher->gender) == 'female')>Female</option>
                                    <option value="other" @selected(old('gender', $teacher->gender) == 'other')>Other</option>
                                </select>
                                @error('gender')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $teacher->phone) }}" placeholder="e.g. 01712345678">
                                @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Photo <small class="text-muted">(max 2MB)</small></label>
                                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror"
                                    accept="image/*">
                                @error('photo')<span class="invalid-feedback">{{ $message }}</span>@enderror

                                {{-- Current Photo Preview --}}
                                @if($teacher->photo)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/teachers/' . $teacher->photo) }}"
                                             alt="Current Photo" width="70" height="70"
                                             class="img-circle" style="object-fit: cover;">
                                        <small class="text-muted d-block">Current photo</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" rows="2"
                                    class="form-control">{{ old('address', $teacher->address) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <hr>
                    {{-- Professional Information --}}
                    <h5 class="text-primary mb-3">Professional Information</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Qualification</label>
                                <input type="text" name="qualification" class="form-control"
                                    value="{{ old('qualification', $teacher->qualification) }}"
                                    placeholder="e.g. M.Sc in Math">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Main Subject</label>
                                <input type="text" name="main_subject" class="form-control"
                                    value="{{ old('main_subject', $teacher->main_subject) }}"
                                    placeholder="e.g. Mathematics">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Salary (৳)</label>
                                <input type="number" step="0.01" name="salary" class="form-control"
                                    value="{{ old('salary', $teacher->salary) }}" placeholder="e.g. 30000">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Joining Date</label>
                                <input type="date" name="joining_date" class="form-control"
                                    value="{{ old('joining_date', $teacher->joining_date?->format('Y-m-d')) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="active" @selected(old('status', $teacher->status) == 'active')>Active</option>
                                    <option value="inactive" @selected(old('status', $teacher->status) == 'inactive')>Inactive</option>
                                </select>
                                @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-primary"><i class="fas fa-save"></i> Update Teacher</button>
                    <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </section>
    </div>
@endsection