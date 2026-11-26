@extends('layouts.master')
@section('title', 'Edit Certificate')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-pencil-square"></i></span>
            <div><h1 class="h3 mb-1">Edit Certificate</h1></div>
        </div>
    </div>

    <section class="panel mt-3">
        <form action="{{ route('certificates.update', $certificate) }}" method="POST">
            @csrf @method('PUT')
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Certificate No</label>
                        <input type="text" class="form-control" value="{{ $certificate->certificate_no }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Student <span class="text-danger">*</span></label>
                        <select name="enrollment_id" class="form-control" required>
                            @foreach($enrollments as $enr)
                                <option value="{{ $enr->id }}" @selected(old('enrollment_id', $certificate->enrollment_id) == $enr->id)>
                                    {{ $enr->student->name ?? 'N/A' }} (Roll: {{ $enr->roll_no ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Certificate Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-control" required>
                            @foreach($types as $key => $label)
                                <option value="{{ $key }}" @selected(old('type', $certificate->type) == $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Issue Date <span class="text-danger">*</span></label>
                        <input type="date" name="issue_date" class="form-control" value="{{ old('issue_date', $certificate->issue_date?->format('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Remarks</label>
                        <textarea name="remarks" rows="2" class="form-control">{{ old('remarks', $certificate->remarks) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                <a href="{{ route('certificates.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </section>
</div>
@endsection