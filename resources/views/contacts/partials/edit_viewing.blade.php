@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h3>Edit Viewing</h3>
    <form action="{{ route('contacts.updateViewing', [$contact, $viewing]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="property" class="form-label">Property ID</label>
            <input type="text" name="property" id="property" class="form-control" value="{{ old('property', $viewing->property_id) }}" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="datetime-local" name="date" id="date" class="form-control" value="{{ old('date', $viewing->date ? \Carbon\Carbon::parse($viewing->date)->format('Y-m-d\TH:i') : '' ) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('contacts.show', $contact) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
