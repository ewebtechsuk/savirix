@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Add Payment</h1>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back to Payments</a>
    </div>
    <form action="{{ route('payments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="invoice_id" class="form-label">Invoice</label>
            <select name="invoice_id" id="invoice_id" class="form-select" required>
                <option value="">Select Invoice</option>
                @foreach($invoices as $invoice)
                    <option value="{{ $invoice->id }}" {{ old('invoice_id') == $invoice->id ? 'selected' : '' }}>
                        {{ $invoice->number }} - £{{ number_format($invoice->amount, 2) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required>
        </div>
        <div class="mb-3">
            <label for="method" class="form-label">Method</label>
            <input type="text" name="method" id="method" class="form-control" value="{{ old('method') }}">
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" id="notes" class="form-control">{{ old('notes') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Payment</button>
    </form>
</div>
@endsection
