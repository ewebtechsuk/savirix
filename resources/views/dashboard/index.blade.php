@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="fw-bold mb-4">Tenants / Companies</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('dashboard.create') }}" class="mb-4">
        @csrf
        <div class="row mb-2">
            <div class="col-md-4">
                <input type="text" name="company_id" class="form-control" placeholder="Company ID" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Company Name" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Add Tenant</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Company ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tenants as $tenant)
            <tr>
                <td>{{ $tenant->id ?? 'N/A' }}</td>
                <td>{{ is_array($tenant->data ?? null) ? ($tenant->data['company_id'] ?? 'N/A') : 'N/A' }}</td>
                <td>{{ is_array($tenant->data ?? null) ? ($tenant->data['name'] ?? 'N/A') : 'N/A' }}</td>
                <td>
                    <form method="POST" action="{{ route('dashboard.destroy', $tenant->id) }}" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    <a href="{{ route('dashboard.impersonate', $tenant->id) }}" class="btn btn-warning btn-sm">Impersonate Admin</a>
                    <a href="http://{{ is_array($tenant->data ?? null) ? ($tenant->data['company_id'] ?? '') : '' }}.ressapp.localhost:8888/login" class="btn btn-secondary btn-sm">Login as Tenant</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No tenants found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
