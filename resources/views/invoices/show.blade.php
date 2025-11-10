@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Invoice #{{ $invoice->number }}</h1>
        <div>
            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning me-2">Edit</a>
            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>Date:</strong> {{ $invoice->date }}
                </div>
                <div class="col-md-6">
                    <strong>Due Date:</strong> {{ $invoice->due_date }}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>Contact:</strong> {{ optional($invoice->contact)->name }}
                </div>
                <div class="col-md-6">
                    <strong>Property:</strong> {{ optional($invoice->property)->title }}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <strong>Amount:</strong> £{{ number_format($invoice->amount, 2) }}
                </div>
                <div class="col-md-6">
                    <strong>Status:</strong> {{ ucfirst($invoice->status) }}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-12">
                    <strong>Notes:</strong><br>
                    <div class="border rounded p-2 bg-light">{{ $invoice->notes }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
