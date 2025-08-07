@extends('admin.dashboard')

@section('content')
<div class="container mx-auto p-4 max-w-2xl">
    <h1 class="text-2xl font-bold mb-4">Edit Company</h1>
    <form action="{{ route('admin.companies.update', $company->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="bg-white rounded shadow p-4 mb-4">
            <h2 class="font-bold mb-2">Personal Information</h2>
            <div class="mb-2"><label class="font-semibold">Title:</label> <input type="text" name="data[title]" value="{{ $company->data['title'] ?? '' }}" class="border rounded p-1 w-full" /></div>
            <div class="mb-2"><label class="font-semibold">First Name:</label> <input type="text" name="data[first_name]" value="{{ $company->data['first_name'] ?? '' }}" class="border rounded p-1 w-full" /></div>
            <div class="mb-2"><label class="font-semibold">Surname:</label> <input type="text" name="data[surname]" value="{{ $company->data['surname'] ?? '' }}" class="border rounded p-1 w-full" /></div>
            <div class="mb-2"><label class="font-semibold">Mobile:</label> <input type="text" name="data[mobile]" value="{{ $company->data['mobile'] ?? '' }}" class="border rounded p-1 w-full" /></div>
        </div>
        <div class="bg-white rounded shadow p-4 mb-4">
            <h2 class="font-bold mb-2">Company Information</h2>
            <div class="mb-2"><label class="font-semibold">Company Name:</label> <input type="text" name="data[company_name]" value="{{ $company->data['company_name'] ?? $company->name ?? $company->id }}" class="border rounded p-1 w-full" /></div>
            <div class="mb-2"><label class="font-semibold">Website URL:</label> <input type="text" name="data[website]" value="{{ $company->data['website'] ?? '' }}" class="border rounded p-1 w-full" /></div>
            <div class="mb-2"><label class="font-semibold">Email:</label> <input type="email" name="data[company_email]" value="{{ $company->data['company_email'] ?? '' }}" class="border rounded p-1 w-full" /></div>
            <div class="mb-2"><label class="font-semibold">Phone:</label> <input type="text" name="data[company_phone]" value="{{ $company->data['company_phone'] ?? '' }}" class="border rounded p-1 w-full" /></div>
            <div class="mb-2"><label class="font-semibold">Address:</label> <input type="text" name="data[address]" value="{{ $company->data['address'] ?? '' }}" class="border rounded p-1 w-full" /></div>
            <div class="mb-2"><label class="font-semibold">Social Links:</label> <input type="text" name="data[social_links]" value="{{ $company->data['social_links'] ?? '' }}" class="border rounded p-1 w-full" /></div>
            <div class="mb-2"><label class="font-semibold">VAT Number:</label> <input type="text" name="data[vat_number]" value="{{ $company->data['vat_number'] ?? '' }}" class="border rounded p-1 w-full" /></div>
            <div class="mb-2"><label class="font-semibold">Subdomain:</label> <input type="text" name="subdomain" value="{{ $company->domain ?? $company->getAttribute('domains')[0]['domain'] ?? '' }}" class="border rounded p-1 w-full" /></div>
            <div class="mb-2"><label class="font-semibold">Status:</label> <input type="text" name="data[status]" value="{{ $company->data['status'] ?? 'Active' }}" class="border rounded p-1 w-full" /></div>
            <div class="mb-2"><label class="font-semibold">Company ID:</label> <input type="text" value="{{ $company->data['company_id'] ?? '' }}" class="border rounded p-1 w-full bg-gray-100" readonly /></div>
            <div class="mb-2"><label class="font-semibold">Company Number:</label> <input type="text" name="data[company_number]" value="{{ $company->data['company_number'] ?? '' }}" class="border rounded p-1 w-full" /></div>
        </div>
        <button type="submit" class="btn btn-primary">Update Company</button>
    </form>
</div>
@endsection
