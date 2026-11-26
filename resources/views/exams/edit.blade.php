@extends('layouts.master')
@section('title', 'Edit Exam')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-pencil-square"></i></span>
            <div><h1 class="h3 mb-1">Edit Exam</h1></div>
        </div>
    </div>

    <section class="panel mt-3">
        <form action="{{ route('exams.update', $exam) }}" method="POST">
            @csrf @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Exam Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $exam->name) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Session</label>
                        <select name="session_id" class="form-control">
                            <option value="">-- Select Session --</option>
                            @foreach($sessions as $s)
                                <option value="{{ $s->id }}" @selected(old('session_id', $exam->session_id) == $s->id)>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $exam->start_date?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $exam->end_date?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="upcoming" @selected(old('status', $exam->status) == 'upcoming')>Upcoming</option>
                            <option value="ongoing" @selected(old('status', $exam->status) == 'ongoing')>Ongoing</option>
                            <option value="completed" @selected(old('status', $exam->status) == 'completed')>Completed</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                <a href="{{ route('exams.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </section>
</div>
@endsection