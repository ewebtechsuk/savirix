@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="fw-bold mb-4">Edit Invoice</h1>
    <form action="{{ route('invoices.update', $invoice) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="number" class="form-label">Invoice Number</label>
                <input type="text" class="form-control" id="number" name="number" value="{{ old('number', $invoice->number) }}" required>
            </div>
            <div class="col-md-6">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $invoice->date) }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="contact_id" class="form-label">Contact</label>
                <select class="form-select" id="contact_id" name="contact_id" required>
                    <option value="">Select Contact</option>
                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}" {{ (old('contact_id', $invoice->contact_id) == $contact->id) ? 'selected' : '' }}>{{ $contact->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="property_id" class="form-label">Property</label>
                <select class="form-select" id="property_id" name="property_id">
                    <option value="">Select Property</option>
                    @foreach($properties as $property)
                        <option value="{{ $property->id }}" {{ (old('property_id', $invoice->property_id) == $property->id) ? 'selected' : '' }}>{{ $property->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="amount" class="form-label">Amount (£)</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount', $invoice->amount) }}" required>
            </div>
            <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="unpaid" {{ (old('status', $invoice->status) == 'unpaid') ? 'selected' : '' }}>Unpaid</option>
                    <option value="paid" {{ (old('status', $invoice->status) == 'paid') ? 'selected' : '' }}>Paid</option>
                    <option value="overdue" {{ (old('status', $invoice->status) == 'overdue') ? 'selected' : '' }}>Overdue</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date', $invoice->due_date) }}">
            </div>
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $invoice->notes) }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Update Invoice</button>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection
