@extends('admin.dashboard')
@section('content')
<div class="container max-w-lg mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Step 2: Company Details</h2>
    <form method="POST" action="{{ url('admin/companies/onboarding/users') }}">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold" for="company_name">Company Name</label>
            <input type="text" id="company_name" name="company_name" class="border rounded p-2 w-full" required value="{{ old('company_name', session('onboarding.company.company_name')) }}">
        </div>
        <div class="mb-4">
            <label class="block font-semibold" for="website">Website</label>
            <input type="text" id="website" name="website" class="border rounded p-2 w-full" value="{{ old('website', session('onboarding.company.website')) }}">
        </div>
        <div class="mb-4">
            <label class="block font-semibold" for="company_email">Company Email</label>
            <input type="email" id="company_email" name="company_email" class="border rounded p-2 w-full" required value="{{ old('company_email', session('onboarding.company.company_email')) }}">
        </div>
        <div class="mb-4">
            <label class="block font-semibold" for="company_phone">Company Phone</label>
            <input type="text" id="company_phone" name="company_phone" class="border rounded p-2 w-full" required value="{{ old('company_phone', session('onboarding.company.company_phone')) }}">
        </div>
        <button type="submit" class="btn btn-primary">Next</button>
    </form>
</div>
@endsection
