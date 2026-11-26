@extends('layouts.master')
@section('title', 'Exam Subject Details')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-journal-text"></i></span>
            <div><h1 class="h3 mb-1">Exam Subject Details</h1></div>
        </div>
        <div class="heading-actions">
            <a href="{{ route('exam-subjects.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>

    <section class="panel mt-3">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Exam</dt><dd class="col-sm-9"><strong>{{ $examSubject->exam->name ?? '-' }}</strong></dd>
                <dt class="col-sm-3">Class</dt><dd class="col-sm-9">{{ $examSubject->classRoom->name ?? '-' }}</dd>
                <dt class="col-sm-3">Subject</dt><dd class="col-sm-9">{{ $examSubject->subject->name ?? '-' }}</dd>
                <dt class="col-sm-3">Full Marks</dt><dd class="col-sm-9">{{ $examSubject->full_marks }}</dd>
                <dt class="col-sm-3">Pass Marks</dt><dd class="col-sm-9">{{ $examSubject->pass_marks }}</dd>
                <dt class="col-sm-3">Exam Date</dt><dd class="col-sm-9">{{ $examSubject->exam_date?->format('d M Y') ?? '-' }}</dd>
            </dl>
        </div>
        <div class="card-footer">
            <a href="{{ route('exam-subjects.edit', $examSubject) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
            <a href="{{ route('exam-subjects.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
    </section>
</div>
@endsection