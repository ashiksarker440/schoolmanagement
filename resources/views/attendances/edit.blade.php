@extends('layouts.master')
@section('title', 'Edit Attendance')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between mb-3">
            <h3>Edit Attendance</h3>

            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">
                Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('attendances.update', $attendance->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- Class --}}
                        <div class="col-md-6 mb-3">
                            <label>Class *</label>

                            <select id="class_id" class="form-control" required>
                                <option value="">Select Class</option>

                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" @selected(
                                        old('class_id', $attendance->enrollment->class_id ?? '') == $class->id
                                    )>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Section --}}
                        <div class="col-md-6 mb-3">
                            <label>Section *</label>

                            <select id="section_id" class="form-control" required>
                                <option value="">Select Section</option>
                            </select>
                        </div>

                        {{-- Student --}}
                        <div class="col-md-6 mb-3">
                            <label>Student Enrollment *</label>

                            <select name="enrollment_id" id="enrollment_id"
                                class="form-control @error('enrollment_id') is-invalid @enderror" required>
                                <option value="">Select Student</option>
                            </select>

                            @error('enrollment_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Roll Number --}}
                        <div class="col-md-6 mb-3">
                            <label>Roll Number</label>

                            <input type="text" id="roll_no" class="form-control"
                                value="{{ $attendance->enrollment->roll_no ?? '' }}" readonly>
                        </div>

                        {{-- Attendance Date --}}
                        <div class="col-md-6 mb-3">
                            <label>Attendance Date *</label>

                            <input type="date" name="attendance_date"
                                class="form-control @error('attendance_date') is-invalid @enderror"
                                value="{{ old('attendance_date', $attendance->attendance_date ? $attendance->attendance_date->format('Y-m-d') : '') }}"
                                required>

                            @error('attendance_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6 mb-3">
                            <label>Status *</label>

                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>

                                <option value="1" @selected(old('status', $attendance->status) == 1)>
                                    Present
                                </option>

                                <option value="0" @selected(old('status', $attendance->status) == 0)>
                                    Absent
                                </option>

                                <option value="2" @selected(old('status', $attendance->status) == 2)>
                                    Late
                                </option>
                            </select>

                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Remarks --}}
                        <div class="col-md-12 mb-3">
                            <label>Remarks</label>

                            <textarea name="remarks" class="form-control"
                                rows="3">{{ old('remarks', $attendance->remarks) }}</textarea>

                            @error('remarks')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <button type="submit" class="btn btn-success">
                        Update Attendance
                    </button>

                    <a href="{{ route('attendances.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </form>

            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const classSelect = document.getElementById('class_id');
            const sectionSelect = document.getElementById('section_id');
            const studentSelect = document.getElementById('enrollment_id');
            const rollInput = document.getElementById('roll_no');

            const sectionsUrl = @json(url('/attendances/get-sections'));
            const studentsUrl = @json(route('attendances.getStudents'));

            const oldClassId = @json(old('class_id', $attendance->enrollment->class_id ?? ''));
            const oldSectionId = @json(old('section_id', $attendance->enrollment->section_id ?? ''));
            const oldEnrollmentId = @json(old('enrollment_id', $attendance->enrollment_id));

            // Load Sections
            function loadSections(classId, selectedSectionId = null) {

                sectionSelect.innerHTML = '<option value="">Select Section</option>';
                studentSelect.innerHTML = '<option value="">Select Student</option>';
                studentSelect.disabled = true;
                rollInput.value = '';

                if (!classId) {
                    sectionSelect.disabled = true;
                    return Promise.resolve();
                }

                sectionSelect.disabled = true;

                return fetch(`${sectionsUrl}/${classId}`, {
                    headers: { 'Accept': 'application/json' }
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Could not load sections');
                        return response.json();
                    })
                    .then(sections => {

                        sections.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.textContent = section.name;

                            if (String(section.id) === String(selectedSectionId)) {
                                option.selected = true;
                            }

                            sectionSelect.appendChild(option);
                        });

                        sectionSelect.disabled = false;
                    });
            }

            // Load Students
            function loadStudents(classId, sectionId, selectedEnrollmentId = null) {

                studentSelect.innerHTML = '<option value="">Select Student</option>';
                studentSelect.disabled = true;
                rollInput.value = '';

                if (!classId || !sectionId) {
                    return Promise.resolve();
                }

                const params = new URLSearchParams({
                    class_id: classId,
                    section_id: sectionId
                });

                return fetch(`${studentsUrl}?${params.toString()}`, {
                    headers: { 'Accept': 'application/json' }
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Could not load students');
                        return response.json();
                    })
                    .then(students => {

                        students.forEach(student => {

                            const option = document.createElement('option');

                            option.value = student.enrollment_id;
                            option.textContent = student.name;
                            option.dataset.roll = student.roll_no;

                            if (String(student.enrollment_id) === String(selectedEnrollmentId)) {
                                option.selected = true;
                                rollInput.value = student.roll_no ?? '';
                            }

                            studentSelect.appendChild(option);
                        });

                        studentSelect.disabled = false;
                    });
            }

            // Class change
            classSelect.addEventListener('change', function () {

                loadSections(this.value);
            });

            // Section change
            sectionSelect.addEventListener('change', function () {

                loadStudents(classSelect.value, this.value);
            });

            // Student change
            studentSelect.addEventListener('change', function () {

                const selectedOption = this.options[this.selectedIndex];

                rollInput.value = selectedOption.dataset.roll || '';
            });

            // Load existing values when Edit page opens
            loadSections(oldClassId, oldSectionId)
                .then(() => {
                    return loadStudents(oldClassId, oldSectionId, oldEnrollmentId);
                })
                .catch(error => {
                    console.error(error);
                    alert('Unable to load attendance information.');
                });

        });
    </script>

@endsection