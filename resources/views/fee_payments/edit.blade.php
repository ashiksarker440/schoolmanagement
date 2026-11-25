@extends('layouts.master')
@section('title', 'Edit Payment')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-pencil-square"></i></span>
            <div><h1 class="h3 mb-1">Edit Payment</h1></div>
        </div>
    </div>

    <section class="panel mt-3">
        <form action="{{ route('fee-payments.update', $payment) }}" method="POST">
            @csrf @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label>Fee <span class="text-danger">*</span></label>
                        <select name="fee_id" class="form-control" required>
                            @foreach($fees as $fee)
                                <option value="{{ $fee->id }}" @selected(old('fee_id', $payment->fee_id) == $fee->id)>
                                    {{ $fee->enrollment->student->name ?? 'N/A' }} — Due: ৳{{ number_format($fee->due_total, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Payment Amount (৳) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="payment_amount" class="form-control"
                               value="{{ old('payment_amount', $payment->payment_amount) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Payment Date <span class="text-danger">*</span></label>
                        <input type="date" name="payment_date" class="form-control"
                               value="{{ old('payment_date', $payment->payment_date?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Payment Method</label>
                        <select name="payment_method" class="form-control">
                            <option value="">-- Select --</option>
                            @foreach(['cash' => 'Cash', 'bkash' => 'bKash', 'nagad' => 'Nagad', 'bank' => 'Bank'] as $k => $v)
                                <option value="{{ $k }}" @selected(old('payment_method', $payment->payment_method) == $k)>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Transaction Reference</label>
                        <input type="text" name="transaction_reference" class="form-control"
                               value="{{ old('transaction_reference', $payment->transaction_reference) }}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                <a href="{{ route('fee-payments.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </section>
</div>
@endsection