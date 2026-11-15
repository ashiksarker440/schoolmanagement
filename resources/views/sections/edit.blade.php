@extends('layouts.master')
@section('title', 'Edit sections')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-person" aria-hidden="true"></i></span>
                <div>
                    <h1 class="h3 mb-1">Edit sections</h1>
                </div>
            </div>

        </div>

        <section class="panel mt-3">
            <form action="{{ route('sections.update', $section) }}" method="POST">
                @csrf @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Department Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $section->name) }}" required>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Section</label>
                        <input type="text" name="section" class="form-control"
                            value="{{ old('section', $section->section) }}">
                    </div>
                    <div class="form-group">
                        <label>Teacher</label>
                        <select name="teacher_id" class="form-control">
                            <option value="">-- Select Teacher --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" @selected($section->teacher_id == $teacher->id)>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                    <a href="{{ route('sections.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </section>
    </div>
@endsection