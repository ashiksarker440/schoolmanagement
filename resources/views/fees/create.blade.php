@extends('layouts.master')
@section('title', 'Add Fee')

@section('content')

    <div class="container-fluid px-3 px-lg-4 py-4">

        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon">
                    <i class="bi bi-cash-coin"></i>
                </span>
                <div>
                    <h1 class="h3 mb-1">Add Student Fees</h1>
                    <p class="text-muted mb-0">Create multiple fees for one student</p>
                </div>
            </div>
        </div>

        <section class="panel mt-3">

            <form action="{{ route('fees.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    {{-- Student Enrollment --}}
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="form-label">
                                Student Enrollment <span class="text-danger">*</span>
                            </label>

                            <select name="enrollment_id" class="form-control @error('enrollment_id') is-invalid @enderror"
                                required>

                                <option value="">-- Select Student --</option>

                                @foreach($enrollments as $enr)
                                    <option value="{{ $enr->id }}" @selected(old('enrollment_id') == $enr->id)>

                                        {{ $enr->student->name ?? 'N/A' }}
                                        - Roll: {{ $enr->roll_no ?? '-' }}
                                        - Class: {{ $enr->classRoom->name ?? '-' }}
                                        - Section: {{ $enr->section->name ?? '-' }}

                                    </option>
                                @endforeach
                            </select>

                            @error('enrollment_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5 class="mb-3">
                            <i class="bi bi-list-check"></i>
                            Select Fee Categories
                        </h5>

                        <div class="row">
                            @foreach($categories as $cat)
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3 h-100">
                                        <div class="form-check">
                                            <input
                                                id="fee-category-{{ $cat->id }}"
                                                class="form-check-input fee-category-checkbox"
                                                type="checkbox"
                                                name="selected_categories[]"
                                                value="{{ $cat->id }}"
                                                data-amount-url="{{ route('fees.categories.amount', $cat) }}"
                                                data-default-amount="{{ $cat->default_amount }}"
                                                data-amount-input="fee-amount-{{ $cat->id }}"
                                                @checked(in_array($cat->id, old('selected_categories', [])))
                                                @disabled($cat->default_amount <= 0)
                                            >
                                            <label class="form-check-label fw-semibold" for="fee-category-{{ $cat->id }}">
                                                {{ $cat->name }}
                                            </label>
                                        </div>

                                        <div class="input-group mt-3">
                                            <span class="input-group-text">৳</span>
                                            <input
                                                id="fee-amount-{{ $cat->id }}"
                                                class="form-control fee-category-amount"
                                                type="number"
                                                name="amounts[{{ $cat->id }}]"
                                                step="0.01"
                                                min="0.01"
                                                max="99999999.99"
                                                value="{{ in_array($cat->id, old('selected_categories', [])) ? old('amounts.' . $cat->id, number_format($cat->default_amount, 2, '.', '')) : '' }}"
                                                placeholder="{{ $cat->default_amount > 0 ? 'Select category to load saved amount' : 'No saved amount' }}"
                                                @disabled(!in_array($cat->id, old('selected_categories', [])))
                                                aria-label="{{ $cat->name }} amount"
                                            >
                                        </div>

                                        <small class="text-muted">Saved amount: ৳{{ number_format($cat->default_amount, 2) }}</small>
                                        <small id="fee-category-error-{{ $cat->id }}" class="text-danger d-block" aria-live="polite"></small>
                                        @error('amounts.' . $cat->id)
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @error('selected_categories')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        @error('amounts')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror

                        <div class="alert alert-light border mt-2 mb-0">
                            Total selected fees: <strong>৳<span id="fee-total">0.00</span></strong>
                        </div>
                    </div>

                    {{-- Due Date and Status --}}
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Due Date <span class="text-danger">*</span>
                            </label>

                            <input type="date" name="due_date" class="form-control"
                                value="{{ old('due_date', date('Y-m-d')) }}" required>

                            @error('due_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>

                            <select name="status" class="form-control" required>

                                <option value="unpaid" @selected(old('status', 'unpaid') == 'unpaid')>
                                    Unpaid
                                </option>

                                <option value="partial" @selected(old('status') == 'partial')>
                                    Partial
                                </option>

                                <option value="paid" @selected(old('status') == 'paid')>
                                    Paid
                                </option>

                            </select>

                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                </div>

                <div class="card-footer">

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Save All Fees
                    </button>

                    <a href="{{ route('fees.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </section>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.fee-category-checkbox');
            const totalElement = document.getElementById('fee-total');

            function updateTotal() {
                let total = 0;
                checkboxes.forEach(function (checkbox) {
                    if (!checkbox.checked) {
                        return;
                    }

                    const amountInput = document.getElementById(checkbox.dataset.amountInput);
                    total += Number.parseFloat(amountInput.value) || 0;
                });
                totalElement.textContent = total.toFixed(2);
            }

            checkboxes.forEach(function (checkbox) {
                const amountInput = document.getElementById(checkbox.dataset.amountInput);

                if (checkbox.checked && !amountInput.value) {
                    amountInput.value = Number(checkbox.dataset.defaultAmount).toFixed(2);
                }

                checkbox.addEventListener('change', async function () {
                    const errorElement = document.getElementById('fee-category-error-' + checkbox.value);
                    errorElement.textContent = '';

                    if (!checkbox.checked) {
                        amountInput.value = '';
                        amountInput.disabled = true;
                        updateTotal();
                        return;
                    }

                    checkbox.disabled = true;
                    amountInput.disabled = true;
                    amountInput.placeholder = 'Loading saved amount...';

                    try {
                        const response = await fetch(checkbox.dataset.amountUrl, {
                            headers: { 'Accept': 'application/json' }
                        });
                        if (!response.ok) {
                            throw new Error('Unable to fetch category amount.');
                        }

                        const data = await response.json();
                        const amount = Number(data.amount);
                        if (!Number.isFinite(amount) || amount <= 0) {
                            throw new Error('Category has no valid saved amount.');
                        }

                        amountInput.value = amount.toFixed(2);
                    } catch (error) {
                        checkbox.checked = false;
                        amountInput.value = '';
                        amountInput.disabled = true;
                        amountInput.placeholder = 'Could not load saved amount';
                        errorElement.textContent = error.message;
                    } finally {
                        checkbox.disabled = false;
                        amountInput.disabled = !checkbox.checked;
                        updateTotal();
                    }
                });

                amountInput.addEventListener('input', updateTotal);
            });

            updateTotal();
        });
    </script>
@endpush