@extends('layouts.master')
@section('title', 'Add shifts')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-person" aria-hidden="true"></i></span>
                <div>
                    <h1 class="h3 mb-1">Add shifts</h1>
                </div>
            </div>

        </div>

        <section class="panel mt-3">
            <form action="{{ route('shifts.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label> shifts Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Section</label>
                        <input type="text" name="section" class="form-control" value="{{ old('section') }}">
                    </div>
                    <div class="form-group">
                        <label>Teacher</label>
                        <select name="teacher_id" class="form-control">
                            <option value="">-- Select Teacher --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    <a href="{{ route('shifts.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </section>
    </div>
@endsection