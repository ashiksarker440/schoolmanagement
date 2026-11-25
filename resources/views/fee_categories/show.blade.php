@extends('layouts.master')
@section('title', 'Category Details')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-tag"></i></span>
            <div><h1 class="h3 mb-1">{{ $feeCategory->name }}</h1></div>
        </div>
    </div>

    <section class="panel mt-3">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Name</dt><dd class="col-sm-9">{{ $feeCategory->name }}</dd>
                <dt class="col-sm-3">Default Amount</dt><dd class="col-sm-9">৳{{ number_format($feeCategory->default_amount, 2) }}</dd>
                <dt class="col-sm-3">Description</dt><dd class="col-sm-9">{{ $feeCategory->description ?? '-' }}</dd>
            </dl>
        </div>
        <div class="card-footer">
            <a href="{{ route('fee-categories.edit', $feeCategory) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('fee-categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </section>
</div>
@endsection