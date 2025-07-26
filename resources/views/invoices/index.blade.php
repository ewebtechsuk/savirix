@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Invoices</h1>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary">Add Invoice</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>Number</th>
                    <th>Date</th>
                    <th>Contact</th>
                    <th>Property</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Due</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->number }}</td>
                    <td>{{ $invoice->date }}</td>
                    <td>{{ optional($invoice->contact)->name }}</td>
                    <td>{{ optional($invoice->property)->title }}</td>
                    <td>£{{ number_format($invoice->amount, 2) }}</td>
                    <td>{{ ucfirst($invoice->status) }}</td>
                    <td>{{ $invoice->due_date }}</td>
                    <td>
                        <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-info btn-sm me-2">View</a>
                        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display:inline-block;">
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
        {{ $invoices->links() }}
    </div>
</div>
@endsection
