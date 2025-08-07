@extends('layouts.app')

@section('content')
<style>
    .nav-tabs {
        background: #374151;
        border-radius: 8px 8px 0 0;
        padding: 0.5rem 1rem;
    }
    .nav-tabs .nav-link {
        color: #fff;
        background: transparent;
        border: none;
        margin-right: 8px;
        font-weight: 500;
        border-radius: 6px 6px 0 0;
        transition: background 0.2s, color 0.2s;
    }
    .nav-tabs .nav-link:hover {
        color: #60a5fa;
        background: #4b5563;
    }
    .nav-tabs .nav-link.active {
        color: #60a5fa;
        background: #1e293b;
    }
    .tab-content {
        background: #f3f4f6;
        border-radius: 0 0 8px 8px;
        padding: 2rem 1rem 1rem 1rem;
    }
</style>
<div class="container py-5" style="background: #f8fafc; min-height: 100vh;">
    <h2 class="mb-4" style="color: #222;">Add Tenant</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <ul class="nav nav-tabs mb-3" id="tenantTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="customer-tab" data-bs-toggle="tab" data-bs-target="#customer" type="button" role="tab">Customer Details</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="company-tab" data-bs-toggle="tab" data-bs-target="#company" type="button" role="tab">Company Details</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">Users</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="billing-tab" data-bs-toggle="tab" data-bs-target="#billing" type="button" role="tab">Billing</button>
        </li>
    </ul>
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('tenants.store') }}">
                @csrf
                <div class="tab-content" id="tenantTabsContent">
                    <div class="tab-pane fade show active" id="customer" role="tabpanel">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label for="title" style="color: #333;">Title</label>
                                <input type="text" class="form-control" id="title" name="data[title]" autocomplete="honorific-prefix">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="first_name" style="color: #333;">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="data[first_name]" autocomplete="given-name">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="last_name" style="color: #333;">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="data[last_name]" autocomplete="family-name">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="phone" style="color: #333;">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="data[phone]" autocomplete="tel">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="email" style="color: #333;">Email</label>
                                <input type="email" class="form-control" id="email" name="data[email]" autocomplete="email">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="company" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="company_name" style="color: #333;">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="data[company_name]" autocomplete="organization">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="subdomain" style="color: #333;">Subdomain</label>
                                <input type="text" class="form-control" id="subdomain" name="subdomain" required autocomplete="url">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="company_domain" style="color: #333;">Company Domain</label>
                                <input type="text" class="form-control" id="company_domain" name="data[company_domain]" autocomplete="url">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="company_email" style="color: #333;">Company Email</label>
                                <input type="email" class="form-control" id="company_email" name="data[company_email]" autocomplete="email">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="company_phone" style="color: #333;">Company Phone</label>
                                <input type="tel" class="form-control" id="company_phone" name="data[company_phone]" autocomplete="tel">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="company_address" style="color: #333;">Company Address</label>
                                <input type="text" class="form-control" id="company_address" name="data[company_address]" autocomplete="street-address">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="company_login_link" style="color: #333;">Company Login Link</label>
                                <input type="url" class="form-control" id="company_login_link" name="data[company_login_link]" autocomplete="url">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="users" role="tabpanel">
                        <div class="mb-3">
                            <h5>Initial User</h5>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <input type="text" name="user[name]" class="form-control" placeholder="Name" autocomplete="name">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <input type="email" name="user[email]" class="form-control" placeholder="Email" autocomplete="email">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <input type="password" name="user[password]" class="form-control" placeholder="Password" autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="billing" role="tabpanel">
                        <div class="alert alert-info">Billing tab coming soon.</div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Create Tenant</button>
            </form>
        </div>
    </div>
</div>
<script>
const triggerTabList = [].slice.call(document.querySelectorAll('#tenantTabs button'));
triggerTabList.forEach(function (triggerEl) {
    triggerEl.addEventListener('click', function (event) {
        event.preventDefault();
        triggerTabList.forEach(function (el) {
            el.classList.remove('active');
        });
        triggerEl.classList.add('active');
        const tabContent = document.querySelectorAll('.tab-pane');
        tabContent.forEach(function (pane) {
            pane.classList.remove('show', 'active');
        });
        const target = document.querySelector(triggerEl.getAttribute('data-bs-target'));
        if (target) {
            target.classList.add('show', 'active');
        }
    });
});
</script>
@endsection
