@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Payments</h1>
        <a href="{{ route('payments.create') }}" class="btn btn-primary">Add Payment</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Invoice</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->date }}</td>
                    <td>{{ optional($payment->invoice)->number }}</td>
                    <td>£{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->method }}</td>
                    <td>{{ $payment->notes }}</td>
                    <td>
                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-info btn-sm me-2">View</a>
                        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $payments->links() }}
    </div>
</div>
@endsection
