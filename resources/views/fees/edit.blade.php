@extends('layouts.master')
@section('title', 'Edit Fee')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-pencil-square"></i></span>
                <div>
                    <h1 class="h3 mb-1">Edit Fee</h1>
                    <p class="text-muted mb-0">Update enrollment, categories, due date, or status.</p>
                </div>
            </div>
            <div class="heading-actions">
                <a href="{{ route('fees.show', $fee) }}" class="btn btn-outline-secondary btn-sm">Back to Details</a>
            </div>
        </div>

        <section class="panel mt-3">
            <form action="{{ route('fees.update', $fee) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label for="enrollment_id" class="form-label">Student Enrollment <span class="text-danger">*</span></label>
                        <select id="enrollment_id" name="enrollment_id" class="form-control" required>
                            @foreach($enrollments as $enrollment)
                                <option value="{{ $enrollment->id }}" @selected(old('enrollment_id', $fee->enrollment_id) == $enrollment->id)>
                                    {{ $enrollment->student->name ?? 'N/A' }}
                                    - Roll: {{ $enrollment->roll_no ?? '-' }}
                                    - Class: {{ $enrollment->classRoom->name ?? '-' }}
                                    - Section: {{ $enrollment->section->name ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('enrollment_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <h5 class="mb-3">Fee Categories & Amounts</h5>
                    <div class="row">
                        @foreach($categories as $category)
                            @php
                                $detail = $fee->details->firstWhere('fee_category_id', $category->id);
                            @endphp
                            <div class="col-md-6 mb-3">
                                <label for="amount-{{ $category->id }}" class="form-label">{{ $category->name }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                    <input
                                        id="amount-{{ $category->id }}"
                                        type="number"
                                        name="amounts[{{ $category->id }}]"
                                        class="form-control"
                                        step="0.01"
                                        min="0.01"
                                        max="99999999.99"
                                        value="{{ old('amounts.' . $category->id, $detail?->amount) }}"
                                        placeholder="Leave blank to remove this category"
                                    >
                                </div>
                                @error('amounts.' . $category->id)
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                    @error('amounts')
                        <small class="text-danger d-block mb-3">{{ $message }}</small>
                    @enderror

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                            <input
                                id="due_date"
                                type="date"
                                name="due_date"
                                class="form-control"
                                value="{{ old('due_date', $fee->due_date?->format('Y-m-d')) }}"
                                required
                            >
                            @error('due_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="unpaid" @selected(old('status', $fee->status) === 'unpaid')>Unpaid</option>
                                <option value="partial" @selected(old('status', $fee->status) === 'partial')>Partial</option>
                                <option value="paid" @selected(old('status', $fee->status) === 'paid')>Paid</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <a href="{{ route('fees.show', $fee) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </section>
    </div>
@endsection
