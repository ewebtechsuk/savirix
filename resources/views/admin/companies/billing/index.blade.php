@extends('admin.dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Billing for {{ $tenant->data['name'] ?? $tenant->id }}</h1>
    <div class="mb-4">
        <p>Total Users: <strong>{{ $userCount }}</strong></p>
        <p>Free Users: <strong>1</strong></p>
        <p>Additional Users: <strong>{{ $additionalUsers }}</strong></p>
        <p>Price per Additional User: <strong>£10</strong></p>
        <p class="text-xl mt-2">Total Due: <strong>£{{ $total }}</strong></p>
    </div>
    <a href="{{ route('admin.companies.billing.pay', $tenant->id) }}" class="btn btn-primary mb-2">Pay Now (Card)</a>
    <a href="{{ route('admin.companies.billing.manual', $tenant->id) }}" class="btn btn-secondary mb-2">Manual Bank Transfer</a>
    <a href="{{ route('admin.companies.billing.history', $tenant->id) }}" class="btn btn-secondary mb-2">View Payment History</a>
</div>
@endsection
