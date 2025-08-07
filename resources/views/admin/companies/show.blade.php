@extends('admin.dashboard')

@section('content')
<div class="container mx-auto p-4 max-w-2xl">
    <h1 class="text-2xl font-bold mb-4">Company Details</h1>
    <div class="mb-6 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="companyTabs" role="tablist">
            <li class="me-2">
                <a href="#personal" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-blue-600 hover:border-blue-600 active" id="personal-tab" data-toggle="tab">Personal Information</a>
            </li>
            <li class="me-2">
                <a href="#company" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-blue-600 hover:border-blue-600" id="company-tab" data-toggle="tab">Company Information</a>
            </li>
            <li class="me-2">
                <a href="{{ route('admin.companies.users', $company->id) }}" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-blue-600 hover:border-blue-600">Users</a>
            </li>
            <li class="me-2">
                <a href="{{ route('admin.companies.billing', $company->id) }}" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-blue-600 hover:border-blue-600">Billings</a>
            </li>
        </ul>
    </div>
    <form action="{{ route('admin.companies.update', $company->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div id="tabContent">
            <div id="personal" class="tab-pane active">
                <div class="bg-white rounded shadow p-4 mb-4">
                    <h2 class="font-bold mb-2">Personal Information</h2>
                    <div class="mb-2"><label class="font-semibold">Title:</label> <input type="text" name="data[title]" value="{{ $company->data['title'] ?? '' }}" class="border rounded p-1 w-full" /></div>
                    <div class="mb-2"><label class="font-semibold">First Name:</label> <input type="text" name="data[first_name]" value="{{ $company->data['first_name'] ?? '' }}" class="border rounded p-1 w-full" /></div>
                    <div class="mb-2"><label class="font-semibold">Surname:</label> <input type="text" name="data[surname]" value="{{ $company->data['surname'] ?? '' }}" class="border rounded p-1 w-full" /></div>
                    <div class="mb-2"><label class="font-semibold">Mobile:</label> <input type="text" name="data[mobile]" value="{{ $company->data['mobile'] ?? '' }}" class="border rounded p-1 w-full" /></div>
                </div>
            </div>
            <div id="company" class="tab-pane" style="display:none;">
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
                    <div class="mb-2"><label class="font-semibold">Status:</label> <input type="text" name="data[status]" value="{{ $company->status ?? 'Active' }}" class="border rounded p-1 w-full" /></div>
                    <div class="mb-2"><label class="font-semibold">Company ID:</label> <input type="text" value="{{ $company->data['company_id'] ?? '' }}" class="border rounded p-1 w-full bg-gray-100" readonly /></div>
                    <div class="mb-2"><label class="font-semibold">Company Number:</label> <input type="text" name="data[company_number]" value="{{ $company->data['company_number'] ?? '' }}" class="border rounded p-1 w-full" /></div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Save Changes</button>
    </form>
</div>
<script>
    // Simple tab switcher
    document.querySelectorAll('#companyTabs a').forEach(tab => {
        tab.addEventListener('click', function(e) {
            if(this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                document.querySelectorAll('.tab-pane').forEach(pane => pane.style.display = 'none');
                document.querySelector(this.getAttribute('href')).style.display = 'block';
                document.querySelectorAll('#companyTabs a').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });
</script>
@endsection
