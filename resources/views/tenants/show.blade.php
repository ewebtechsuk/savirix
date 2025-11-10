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
    <h2 class="mb-4" style="color: #222;">Tenant Details</h2>
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
            <form id="editTenantForm" method="POST" action="{{ route('tenants.update', $tenant->id) }}">
                @csrf
                @method('PUT')
                @php
                    $tenantData = is_array($tenant->data) ? $tenant->data : [];
                @endphp
                <div class="tab-content" id="tenantTabsContent">
                    <div class="tab-pane fade show active" id="customer" role="tabpanel">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label for="title" style="color: #333;">Title</label>
                                <input type="text" class="form-control" id="title" name="data[title]" value="{{ $tenantData['title'] ?? '' }}" autocomplete="honorific-prefix">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="first_name" style="color: #333;">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="data[first_name]" value="{{ $tenantData['first_name'] ?? '' }}" autocomplete="given-name">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="last_name" style="color: #333;">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="data[last_name]" value="{{ $tenantData['last_name'] ?? '' }}" autocomplete="family-name">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="phone" style="color: #333;">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="data[phone]" value="{{ $tenantData['phone'] ?? '' }}" autocomplete="tel">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="email" style="color: #333;">Email</label>
                                <input type="email" class="form-control" id="email" name="data[email]" value="{{ $tenantData['email'] ?? '' }}" autocomplete="email">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="company" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="company_name" style="color: #333;">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="data[company_name]" value="{{ $tenantData['company_name'] ?? ($tenantData['name'] ?? '') }}" autocomplete="organization">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="company_domain" style="color: #333;">Company Domain</label>
                                <input type="text" class="form-control" id="company_domain" name="data[company_domain]" value="{{ $tenantData['company_domain'] ?? $tenant->id }}" autocomplete="url">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="company_email" style="color: #333;">Company Email</label>
                                <input type="email" class="form-control" id="company_email" name="data[company_email]" value="{{ trim($tenantData['company_email'] ?? '') }}" autocomplete="email">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="company_phone" style="color: #333;">Company Phone</label>
                                <input type="tel" class="form-control" id="company_phone" name="data[company_phone]" value="{{ $tenantData['company_phone'] ?? '' }}" autocomplete="tel">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="company_address" style="color: #333;">Company Address</label>
                                <input type="text" class="form-control" id="company_address" name="data[company_address]" value="{{ $tenantData['company_address'] ?? '' }}" autocomplete="street-address">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="company_login_link" style="color: #333;">Company Login Link</label>
                                <input type="url" class="form-control" id="company_login_link" name="data[company_login_link]" value="{{ $tenantData['company_login_link'] ?? '' }}" autocomplete="url">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="users" role="tabpanel">
                        <div class="mb-3">
                            <h5>Tenant Users</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-secondary">Edit</a>
                                                <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No users found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <form method="POST" action="{{ route('tenants.addUser', $tenant->id) }}" class="mt-3">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <input type="text" name="name" class="form-control" placeholder="Name" required autocomplete="name">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="email" name="email" class="form-control" placeholder="Email" required autocomplete="email">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <input type="password" name="password" class="form-control" placeholder="Password" required autocomplete="new-password">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add User</button>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="billing" role="tabpanel">
                        <div class="alert alert-info">Billing tab coming soon.</div>
                    </div>
                </div>
                <button type="button" class="btn btn-success mt-3" onclick="showSavePopup()">Save Changes</button>
            </form>
        </div>
    </div>
</div>
<!-- Popup Modal -->
<div id="savePopup" class="modal" tabindex="-1" role="dialog" style="display:none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Save</h5>
        <button type="button" class="close" onclick="hideSavePopup()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Save changes to this tenant?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="document.getElementById('editTenantForm').submit();">Save</button>
        <button type="button" class="btn btn-secondary" onclick="hideSavePopup()">Cancel</button>
      </div>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-12 mb-3">
        <pre style="background:#f8f8f8;border:1px solid #eee;padding:10px;max-height:200px;overflow:auto;">
            {{ var_export($tenant->data, true) }}
        </pre>
    </div>
</div>
<script>
// Bootstrap tab switching
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
function showSavePopup() {
    document.getElementById('savePopup').style.display = 'block';
}
function hideSavePopup() {
    document.getElementById('savePopup').style.display = 'none';
}
</script>
@endsection
