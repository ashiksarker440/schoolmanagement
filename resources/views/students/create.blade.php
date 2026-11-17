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
            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <h5 class="text-primary mb-3">Personal Information</h5>
                    <div class="row">
                        {{-- photo --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Photo</label>
                                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                                @error('photo')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
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
                                <label>Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" name="date_of_birth"
                                    class="form-control @error('date_of_birth') is-invalid @enderror"
                                    value="{{ old('date_of_birth') }}" required>
                                @error('date_of_birth')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="1" @selected(old('gender') == '1')>Male</option>
                                    <option value="2" @selected(old('gender') == '2')>Female</option>
                                    <option value="3" @selected(old('gender') == '3')>Other</option>
                                </select>
                                @error('gender')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Religion <span class="text-danger">*</span></label>
                                <select name="religion" class="form-control @error('religion') is-invalid @enderror"
                                    required>
                                    <option value="">-- Select Religion --</option>
                                    <option value="1" @selected(old('religion') == '1')>Islam</option>
                                    <option value="2" @selected(old('religion') == '2')>Hindu</option>
                                    <option value="3" @selected(old('religion') == '3')>Christian</option>
                                    <option value="4" @selected(old('religion') == '4')>Buddhist</option>
                                    <option value="5" @selected(old('religion') == '5')>Other</option>
                                </select>
                                @error('religion')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Blood Group <span class="text-danger">*</span></label>
                                <select name="blood_group" class="form-control @error('blood_group') is-invalid @enderror"
                                    required>
                                    <option value="">-- Select Blood Group --</option>
                                    <option value="A+" @selected(old('blood_group') == 'A+')>A+</option>
                                    <option value="A-" @selected(old('blood_group') == 'A-')>A-</option>
                                    <option value="B+" @selected(old('blood_group') == 'B+')>B+</option>
                                    <option value="B-" @selected(old('blood_group') == 'B-')>B-</option>
                                    <option value="AB+" @selected(old('blood_group') == 'AB+')>AB+</option>
                                    <option value="AB-" @selected(old('blood_group') == 'AB-')>AB-</option>
                                    <option value="O+" @selected(old('blood_group') == 'O+')>O+</option>
                                    <option value="O-" @selected(old('blood_group') == 'O-')>O-</option>
                                </select>
                                @error('blood_group')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Birth Certificate Number <span class="text-danger">*</span></label>
                                <input type="text" name="birth_certificate"
                                    class="form-control @error('birth_certificate') is-invalid @enderror"
                                    value="{{ old('birth_certificate') }}" required>
                                @error('birth_certificate')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>father_name <span class="text-danger">*</span></label>
                                <input type="text" name="father_name"
                                    class="form-control @error('father_name') is-invalid @enderror"
                                    value="{{ old('father_name') }}" required>
                                @error('father_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>mother_name <span class="text-danger">*</span></label>
                                <input type="text" name="mother_name"
                                    class="form-control @error('mother_name') is-invalid @enderror"
                                    value="{{ old('mother_name') }}" required>
                                @error('mother_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Father's Phone <span class="text-danger">*</span></label>
                                <input type="text" name="father_phone"
                                    class="form-control @error('father_phone') is-invalid @enderror"
                                    value="{{ old('father_phone') }}" required>
                                @error('father_phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mother's Phone <span class="text-danger">*</span></label>
                                <input type="text" name="mother_phone"
                                    class="form-control @error('mother_phone') is-invalid @enderror"
                                    value="{{ old('mother_phone') }}" required>
                                @error('mother_phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Father's Profession <span class="text-danger">*</span></label>
                                <input type="text" name="father_profession"
                                    class="form-control @error('father_profession') is-invalid @enderror"
                                    value="{{ old('father_profession') }}" required>
                                @error('father_profession')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mother's Profession <span class="text-danger">*</span></label>
                                <input type="text" name="mother_profession"
                                    class="form-control @error('mother_profession') is-invalid @enderror"
                                    value="{{ old('mother_profession') }}" required>
                                @error('mother_profession')<span class="invalid-feedback">{{ $message }}</span>@enderror
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
                                <label>Section <span class="text-danger">*</span></label>
                                <select name="section_id" class="form-control @error('section_id') is-invalid @enderror"
                                    required>
                                    <option value="">-- Select Section --</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}" @selected(old('section_id') == $section->id)>
                                            {{ $section->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('section_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Session <span class="text-danger">*</span></label>
                                <select name="student_session_id"
                                    class="form-control @error('student_session_id') is-invalid @enderror" required>
                                    <option value="">-- Select Session --</option>
                                    @foreach($studentSessions as $studentSession)
                                        <option value="{{ $studentSession->id }}"
                                            @selected(old('student_session_id') == $studentSession->id)>
                                            {{ $studentSession->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_session_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Group <span class="text-danger">*</span></label>
                                <select name="group_id" class="form-control @error('group_id') is-invalid @enderror"
                                    required>
                                    <option value="">-- Select Group --</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}" @selected(old('group_id') == $group->id)>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('group_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Shift <span class="text-danger">*</span></label>
                                <select name="shift_id" class="form-control @error('shift_id') is-invalid @enderror"
                                    required>
                                    <option value="">-- Select Shift --</option>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}" @selected(old('shift_id') == $shift->id)>
                                            {{ $shift->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('shift_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Roll Number <span class="text-danger">*</span></label>
                                <input type="text" name="roll_no"
                                    class="form-control @error('roll_no') is-invalid @enderror"
                                    value="{{ old('roll_no') }}" required>
                                @error('roll_no')<span class="invalid-feedback">{{ $message }}</span>@enderror
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