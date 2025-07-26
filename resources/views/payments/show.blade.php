@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Payment Details</h1>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back to Payments</a>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Invoice: {{ optional($payment->invoice)->number }}</h5>
            <p class="card-text"><strong>Date:</strong> {{ $payment->date }}</p>
            <p class="card-text"><strong>Amount:</strong> £{{ number_format($payment->amount, 2) }}</p>
            <p class="card-text"><strong>Method:</strong> {{ $payment->method }}</p>
            <p class="card-text"><strong>Notes:</strong> {{ $payment->notes }}</p>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('payments.edit', $payment) }}" class="btn btn-warning btn-sm me-2">Edit</a>
            <form action="{{ route('payments.destroy', $payment) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
