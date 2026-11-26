@extends('layouts.master')
@section('title', 'Edit Exam Subject')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-pencil-square"></i></span>
            <div><h1 class="h3 mb-1">Edit Exam Subject</h1></div>
        </div>
    </div>

    <section class="panel mt-3">
        <form action="{{ route('exam-subjects.update', $examSubject) }}" method="POST">
            @csrf @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Exam <span class="text-danger">*</span></label>
                        <select name="exam_id" class="form-control" required>
                            @foreach($exams as $e)
                                <option value="{{ $e->id }}" @selected(old('exam_id', $examSubject->exam_id) == $e->id)>{{ $e->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Class <span class="text-danger">*</span></label>
                        <select name="class_id" class="form-control" required>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" @selected(old('class_id', $examSubject->class_id) == $c->id)>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Subject <span class="text-danger">*</span></label>
                        <select name="subject_id" class="form-control" required>
                            @foreach($subjects as $s)
                                <option value="{{ $s->id }}" @selected(old('subject_id', $examSubject->subject_id) == $s->id)>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Exam Date</label>
                        <input type="date" name="exam_date" class="form-control" value="{{ old('exam_date', $examSubject->exam_date?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Full Marks <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="full_marks" class="form-control" value="{{ old('full_marks', $examSubject->full_marks) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Pass Marks <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="pass_marks" class="form-control" value="{{ old('pass_marks', $examSubject->pass_marks) }}" required>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                <a href="{{ route('exam-subjects.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </section>
</div>
@endsection