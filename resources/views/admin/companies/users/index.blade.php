@extends('admin.dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Users for {{ $tenant->data['name'] ?? $tenant->id }}</h1>
    <a href="{{ route('admin.companies.users.add', $tenant->id) }}" class="btn btn-primary mb-4">Add User</a>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('admin.companies.users.edit', [$tenant->id, $user->id]) }}" class="text-yellow-600 mr-2">Edit</a>
                        <form action="{{ route('admin.companies.users.delete', [$tenant->id, $user->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="return confirm('Delete this user?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
