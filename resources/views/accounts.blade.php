@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h1 class="fw-bold">Accounts</h1>
            <p class="text-muted">This is your accounts page. You can manage invoices, payments, and financial reports here.</p>
            <a href="{{ route('invoices.index') }}" class="btn btn-outline-primary me-2">View Invoices</a>
            <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">View Payments</a>
        </div>
    </div>
</div>
@endsection
