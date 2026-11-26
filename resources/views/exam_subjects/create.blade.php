@extends('layouts.master')
@section('title', 'Add Exam Subject')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-journal-plus"></i></span>
            <div><h1 class="h3 mb-1">Add Exam Subjects</h1></div>
        </div>
    </div>

    <section class="panel mt-3">
        <form action="{{ route('exam-subjects.store') }}" method="POST">
            @csrf
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Exam <span class="text-danger">*</span></label>
                        <select name="exam_id" class="form-control" required>
                            <option value="">-- Select Exam --</option>
                            @foreach($exams as $e)
                                <option value="{{ $e->id }}" @selected(old('exam_id', request('exam_id')) == $e->id)>{{ $e->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Class <span class="text-danger">*</span></label>
                        <select name="class_id" class="form-control" required>
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" @selected(old('class_id') == $c->id)>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-primary mb-0">Subjects</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="selectAllSubjects">
                        <i class="bi bi-check-all"></i> Select All Subjects
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 5%">
                                    <input type="checkbox" id="mainSelectAll">
                                </th>
                                <th>Subject</th>
                                <th style="width: 20%">Full Marks</th>
                                <th style="width: 20%">Pass Marks</th>
                                <th style="width: 25%">Exam Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $s)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selected_subjects[]" value="{{ $s->id }}" class="subject-checkbox">
                                    </td>
                                    <td><strong>{{ $s->name }}</strong></td>
                                    <td>
                                        <input type="number" name="full_marks[{{ $s->id }}]" class="form-control form-control-sm" value="{{ old('full_marks.' . $s->id, 100) }}" min="1" step="0.01">
                                    </td>
                                    <td>
                                        <input type="number" name="pass_marks[{{ $s->id }}]" class="form-control form-control-sm" value="{{ old('pass_marks.' . $s->id, 33) }}" min="0" step="0.01">
                                    </td>
                                    <td>
                                        <input type="date" name="exam_date[{{ $s->id }}]" class="form-control form-control-sm" value="{{ old('exam_date.' . $s->id) }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary"><i class="fas fa-save"></i> Save Subjects</button>
                <a href="{{ route('exam-subjects.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mainCheckbox = document.getElementById('mainSelectAll');
        const selectAllBtn = document.getElementById('selectAllSubjects');
        const checkboxes = document.querySelectorAll('.subject-checkbox');

        // মেইন চেকবক্স (টেবিলের হেডারে)
        mainCheckbox.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = mainCheckbox.checked);
        });

        // সিলেক্ট অল বাটন
        selectAllBtn.addEventListener('click', function () {
            const isChecked = !Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = isChecked);
            mainCheckbox.checked = isChecked;
        });
    });
</script>
@endpush