@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar py-4 border-end">
            <div class="sidebar-sticky">
                <h5 class="mb-4 text-primary fw-bold">Admin Panel</h5>
                <ul class="nav flex-column mb-4">
                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="#">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#">
                            <i class="bi bi-people me-2"></i> Users
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#">
                            <i class="bi bi-shield-lock me-2"></i> Roles & Permissions
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#">
                            <i class="bi bi-gear me-2"></i> Settings
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#">
                            <i class="bi bi-journal-text me-2"></i> Logs
                        </a>
                    </li>
                </ul>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-5 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-4">
                <h2 class="h3 fw-bold">Admin Dashboard</h2>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="adminUserDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i> Admin
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminUserDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.panel') }}">Admin Panel</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
            <!-- Dashboard Widgets -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title text-muted">Total Users</h6>
                            <h3 class="fw-bold">--</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title text-muted">Active Roles</h6>
                            <h3 class="fw-bold">--</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title text-muted">System Logs</h6>
                            <h3 class="fw-bold">--</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="card-title text-muted">Settings</h6>
                            <h3 class="fw-bold">--</h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Placeholder for more admin content -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Welcome to the Admin Panel</h5>
                    <p class="card-text">Use the sidebar to manage users, roles, settings, and view system logs. This page can be extended with more widgets and management tools as needed.</p>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
.sidebar {
    min-height: 100vh;
}
.sidebar .nav-link.active {
    font-weight: bold;
    color: #0d6efd;
}
</style>
@endpush
