@extends('admin.dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Add Company</h1>
    <form action="{{ route('admin.companies.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Company Name</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Subdomain</label>
            <input type="text" name="subdomain" class="w-full border rounded p-2" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Company</button>
    </form>
</div>
@endsection

{{-- This file is deprecated. Use the onboarding wizard instead. --}}
