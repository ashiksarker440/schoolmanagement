@extends('layouts.master')
@section('title', 'Record Payment')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-cash-coin"></i></span>
            <div><h1 class="h3 mb-1">Record Fee Payment</h1></div>
        </div>
    </div>

    <section class="panel mt-3">
        <form action="{{ route('fee-payments.store') }}" method="POST">
            @csrf
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label>Fee (Student + Categories) <span class="text-danger">*</span></label>
                        <select name="fee_id" class="form-control" required>
                            <option value="">-- Select Fee --</option>
                            @foreach($fees as $fee)
                                <option value="{{ $fee->id }}" @selected(old('fee_id', $selectedFeeId) == $fee->id)>
                                    {{ $fee->enrollment->student->name ?? 'N/A' }}
                                    — {{ $fee->details->pluck('category.name')->filter()->join(', ') ?: 'No Category' }}
                                    — Due: ৳{{ number_format($fee->due_total, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Payment Amount (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="payment_amount" class="form-control"
                               value="{{ old('payment_amount') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Payment Date <span class="text-danger">*</span></label>
                        <input type="date" name="payment_date" class="form-control"
                               value="{{ old('payment_date', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Payment Method</label>
                        <select name="payment_method" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="cash"  @selected(old('payment_method') == 'cash')>Cash</option>
                            <option value="bkash" @selected(old('payment_method') == 'bkash')>bKash</option>
                            <option value="nagad" @selected(old('payment_method') == 'nagad')>Nagad</option>
                            <option value="bank"  @selected(old('payment_method') == 'bank')>Bank</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Transaction Reference</label>
                        <input type="text" name="transaction_reference" class="form-control"
                               value="{{ old('transaction_reference') }}" placeholder="TXN ID">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary"><i class="fas fa-save"></i> Save Payment</button>
                <a href="{{ route('fee-payments.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </section>
</div>
@endsection