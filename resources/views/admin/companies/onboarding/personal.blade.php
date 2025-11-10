@extends('admin.dashboard')
@section('content')
<div class="container max-w-lg mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Step 1: Personal Details</h2>
    <form method="POST" action="{{ route('admin.companies.onboarding.company') }}">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold">First Name</label>
            <input type="text" name="first_name" class="border rounded p-2 w-full" required value="{{ old('first_name', session('onboarding.personal.first_name')) }}">
        </div>
        <div class="mb-4">
            <label class="block font-semibold">Surname</label>
            <input type="text" name="surname" class="border rounded p-2 w-full" required value="{{ old('surname', session('onboarding.personal.surname')) }}">
        </div>
        <div class="mb-4">
            <label class="block font-semibold">Mobile</label>
            <input type="text" name="mobile" class="border rounded p-2 w-full" required value="{{ old('mobile', session('onboarding.personal.mobile')) }}">
        </div>
        <button type="submit" class="btn btn-primary">Next</button>
    </form>
</div>
@endsection
