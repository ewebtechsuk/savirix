@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h3>Edit Note</h3>
    <form action="{{ route('contacts.updateNote', [$contact, $note]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <input type="text" name="note" id="note" class="form-control" value="{{ old('note', $note->note) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('contacts.show', $contact) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
