@extends('layouts.app')

@section('content')
<div class="container py-5" style="background: #f8fafc; min-height: 100vh;">
    <h2 class="mb-4" style="color: #222;">Delete Tenant</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('tenants.destroy', $tenant->id) }}">
                @csrf
                @method('DELETE')
                <p style="color: #333;">Are you sure you want to delete <strong>{{ $tenant->data['name'] ?? $tenant->id }}</strong>?</p>
                <button type="submit" class="btn btn-danger">Delete</button>
                <a href="{{ route('tenants.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
