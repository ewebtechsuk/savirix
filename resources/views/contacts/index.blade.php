@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Contacts</h1>
        <a href="{{ route('contacts.create') }}" class="btn btn-primary">Add Contact</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="table-responsive">
        <form id="bulkContactsForm" method="POST" action="{{ route('contacts.bulk') }}">
            @csrf
            <div class="mb-2 d-flex gap-2 align-items-center">
                <select id="bulkAction" name="action" class="form-select form-select-sm" style="width:auto;">
                    <option value="">Bulk Actions</option>
                    <option value="email">Send Email</option>
                    <option value="sms">Send SMS</option>
                    <option value="tag">Add Tag</option>
                    <option value="delete">Delete</option>
                </select>
                <input type="text" id="bulkTagInput" name="tag" class="form-control form-control-sm d-none" placeholder="Tag name" style="width:150px;">
                <button type="submit" class="btn btn-sm btn-secondary">Apply</button>
            </div>
            <table class="table table-hover align-middle bg-white">
                <thead class="table-light">
                    <tr>
                        <th><input type="checkbox" id="selectAllContacts"></th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Groups</th>
                        <th>Tags</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                    <tr>
                        <td><input type="checkbox" name="contacts[]" value="{{ $contact->id }}" class="contactCheckbox"></td>
                        <td>{{ ucfirst($contact->type) }}</td>
                        <td class="fw-semibold">{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>{{ $contact->address }}</td>
                        <td>
                            @foreach($contact->groups as $group)
                                <span class="badge bg-info">{{ $group->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            @foreach($contact->tags as $tag)
                                <span class="badge bg-secondary">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('contacts.show', $contact) }}" class="btn btn-info btn-sm me-2">View</a>
                            <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
    <div class="mt-3">
        {{ $contacts->links() }}
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('selectAllContacts').addEventListener('change', function() {
        document.querySelectorAll('.contactCheckbox').forEach(cb => cb.checked = this.checked);
    });
    document.getElementById('bulkAction').addEventListener('change', function() {
        document.getElementById('bulkTagInput').classList.toggle('d-none', this.value !== 'tag');
    });
});
</script>
@endsection
