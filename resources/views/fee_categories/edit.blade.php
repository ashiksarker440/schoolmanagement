@extends('layouts.master')
@section('title', 'Edit Fee Category')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-tag"></i></span>
            <div><h1 class="h3 mb-1">Edit Fee Category</h1></div>
        </div>
    </div>

    <section class="panel mt-3">
        <form action="{{ route('fee-categories.update', $feeCategory) }}" method="POST">
            @csrf @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $feeCategory->name) }}" required>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Default Amount (৳)</label>
                        <input type="number" step="0.01" name="default_amount" class="form-control"
                               value="{{ old('default_amount', $feeCategory->default_amount) }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Description</label>
                        <textarea name="description" rows="2" class="form-control">{{ old('description', $feeCategory->description) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                <a href="{{ route('fee-categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </section>
</div>
@endsection