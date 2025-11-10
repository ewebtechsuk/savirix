@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Super Admin Dashboard</div>
                <div class="card-body">
                    <h3>Welcome, Super Admin!</h3>
                    <p>Here you can manage all companies, users, and view system-wide stats.</p>
                    <form method="POST" action="/admin/logout">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="flex flex-col w-64 h-full bg-gray-800 text-white p-4">
    <a href="{{ route('admin.dashboard') }}" class="mb-4 block">Dashboard</a>
    <a href="{{ route('admin.companies.index') }}" class="mb-4 block">Companies</a>
    <!-- Add more admin links here -->
</div>
@endsection
