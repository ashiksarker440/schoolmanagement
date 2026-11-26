@extends('layouts.master')
@section('title', 'Add Subject')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-book-half"></i></span>
            <div><h1 class="h3 mb-1">Add Subject</h1></div>
        </div>
    </div>

    <section class="panel mt-3">
        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Subject ID</label>
                        <input type="text" name="subject_id" class="form-control" value="{{ old('subject_id') }}" placeholder="e.g. SUB-01">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Subject Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Code</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code') }}" placeholder="e.g. MATH">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Mark Type <span class="text-danger">*</span></label>
                        <select name="mark_type" class="form-control" required>
                            <option value="">-- Select Mark Type --</option>
                            @foreach($markTypes as $key => $label)
                                <option value="{{ $key }}" @selected(old('mark_type') == $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Description</label>
                        <textarea name="description" rows="2" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" value="1" id="is_active" class="form-check-input" @checked(old('is_active', true))>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </section>
</div>
@endsection