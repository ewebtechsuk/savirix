@extends('layouts.app')

@section('content')
<div class="container py-5" style="background: #f8fafc; min-height: 100vh;">
    <h2 class="mb-4" style="color: #222;">Tenant Management</h2>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span style="font-size: 1.2rem; color: #333;">Companies</span>
            <a href="{{ route('tenants.create') }}" class="btn btn-primary">Add Tenant</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0" style="border-radius: 8px; overflow: hidden;">
                <thead class="thead-light">
                    <tr>
                        <th style="padding: 16px;">ID</th>
                        <th style="padding: 16px;">Company ID</th>
                        <th style="padding: 16px;">Name</th>
                        <th style="padding: 16px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tenants as $tenant)
                        <tr>
                            <td style="padding: 16px;">{{ $tenant->id }}</td>
                            <td style="padding: 16px;">
                                <a href="{{ route('tenants.show', $tenant->id) }}" class="text-primary text-decoration-underline">
                                    {{ $tenant->data['company_id'] ?? 'N/A' }}
                                </a>
                            </td>
                            <td style="padding: 16px;">
                                <a href="{{ route('tenants.show', $tenant->id) }}" class="text-primary text-decoration-underline">
                                    {{ $tenant->data['company_name'] ?? $tenant->data['name'] ?? 'N/A' }}
                                </a>
                            </td>
                            <td style="padding: 16px;">
                                <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                                <a href="{{ route('tenants.delete', $tenant->id) }}" class="btn btn-sm btn-outline-danger">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center" style="padding: 16px;">No tenants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
