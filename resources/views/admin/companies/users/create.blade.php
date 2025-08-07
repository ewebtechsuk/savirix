@extends('admin.dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Add User</h1>
    <form action="{{ route('admin.companies.users.add', $tenant->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded p-2" required>
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
    </form>
</div>
@endsection
