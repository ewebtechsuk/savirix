@extends('admin.dashboard')
@section('content')
<div class="container max-w-lg mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Step 3: Users</h2>
    <form method="POST" action="{{ url('admin/companies/onboarding/billing') }}">
        @csrf
        <div class="mb-4">
            <label for="user_name" class="block font-semibold">User Name</label>
            <input type="text" id="user_name" name="user_name" class="border rounded p-2 w-full" required value="{{ old('user_name', session('onboarding.users.user_name')) }}">
        </div>
        <div class="mb-4">
            <label for="user_email" class="block font-semibold">User Email</label>
            <input type="email" id="user_email" name="user_email" class="border rounded p-2 w-full" required value="{{ old('user_email', session('onboarding.users.user_email')) }}">
        </div>
        <div class="mb-4">
            <label for="user_password" class="block font-semibold">User Password</label>
            <input type="password" id="user_password" name="user_password" class="border rounded p-2 w-full" required>
        </div>
        <button type="submit" class="btn btn-primary">Next</button>
    </form>
</div>
@endsection
