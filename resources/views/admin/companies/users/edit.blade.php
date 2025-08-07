@extends('admin.dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit User</h1>
    <form action="{{ route('admin.companies.users.update', [$tenant->id, $user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="w-full border rounded p-2" value="{{ $user->name }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="w-full border rounded p-2" value="{{ $user->email }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Password (leave blank to keep current)</label>
            <input type="password" name="password" class="w-full border rounded p-2">
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
