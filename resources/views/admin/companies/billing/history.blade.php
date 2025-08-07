@extends('admin.dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Payment History for {{ $tenant->data['name'] ?? $tenant->id }}</h1>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Date</th>
                <th class="py-2 px-4 border-b">Amount</th>
                <th class="py-2 px-4 border-b">Status</th>
                <th class="py-2 px-4 border-b">Reference</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $payment->created_at }}</td>
                    <td class="py-2 px-4 border-b">£{{ number_format($payment->amount / 100, 2) }}</td>
                    <td class="py-2 px-4 border-b">{{ $payment->status }}</td>
                    <td class="py-2 px-4 border-b">{{ $payment->reference }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="py-2 px-4">No payments found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
