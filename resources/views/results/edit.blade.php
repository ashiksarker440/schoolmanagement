@extends('layouts.master')
@section('title', 'Edit Result')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-pencil-square"></i></span>
            <div><h1 class="h3 mb-1">Edit Result</h1></div>
        </div>
    </div>

    <section class="panel mt-3">
        <form action="{{ route('results.update', $result) }}" method="POST">
            @csrf @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Student <span class="text-danger">*</span></label>
                        <select name="enrollment_id" class="form-control" required>
                            @foreach($enrollments as $enr)
                                <option value="{{ $enr->id }}" @selected(old('enrollment_id', $result->enrollment_id) == $enr->id)>
                                    {{ $enr->student->name ?? 'N/A' }} (Roll: {{ $enr->roll_no ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Exam & Subject <span class="text-danger">*</span></label>
                        <select name="exam_subject_id" class="form-control" required>
                            @foreach($examSubjects as $es)
                                <option value="{{ $es->id }}" @selected(old('exam_subject_id', $result->exam_subject_id) == $es->id)>
                                    {{ $es->exam->name ?? '' }} - {{ $es->subject->name ?? '' }} 
                                    ({{ $es->classRoom->name ?? '' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Obtained Marks <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="obtained_marks" class="form-control"
                               value="{{ old('obtained_marks', $result->obtained_marks) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="pass" @selected(old('status', $result->status) == 'pass')>Pass</option>
                            <option value="fail" @selected(old('status', $result->status) == 'fail')>Fail</option>
                            <option value="absent" @selected(old('status', $result->status) == 'absent')>Absent</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                <a href="{{ route('results.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </section>
</div>
@endsection