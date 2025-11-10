@extends('admin.dashboard')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Companies</h1>
        <a href="{{ route('admin.companies.onboarding.personal') }}" class="btn btn-primary">Add Company</a>
    </div>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">Subdomain</th>
                <th class="py-2 px-4 border-b">Status</th>
                <th class="py-2 px-4 border-b">Login Link</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $company->data['company_id'] ?? '' }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('admin.companies.show', $company->id) }}" class="text-blue-600 underline">
                            {{ $company->data['company_name'] ?? $company->data['name'] ?? $company->id }}
                        </a>
                    </td>
                    <td class="py-2 px-4 border-b">{{ optional($company->domains[0] ?? null)['domain'] ?? '' }}</td>
                    <td class="py-2 px-4 border-b">{{ $company->data['status'] ?? 'Active' }}</td>
                    <td class="py-2 px-4 border-b">
                        @if(isset($company->domains[0]['domain']))
                            <a href="//{{ $company->domains[0]['domain'] }}" target="_blank" class="text-blue-600 underline">Login</a>
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('admin.companies.edit', $company->id) }}" class="text-yellow-600 mr-2">Edit</a>
                        <form action="{{ route('admin.companies.destroy', $company->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="return confirm('Delete this company?')">Delete</button>
                        </form>
                        <a href="{{ route('admin.companies.impersonate', $company->id) }}" class="text-green-600 ml-2">Login as</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
