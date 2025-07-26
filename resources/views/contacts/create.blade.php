@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-bold">Add Contact</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('contacts.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" class="form-select" required>
                                <option value="">Select type</option>
                                <option value="landlord" {{ old('type') == 'landlord' ? 'selected' : '' }}>Landlord</option>
                                <option value="applicant" {{ old('type') == 'applicant' ? 'selected' : '' }}>Applicant</option>
                                <option value="vendor" {{ old('type') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                                <option value="tenant" {{ old('type') == 'tenant' ? 'selected' : '' }}>Tenant</option>
                                <option value="contractor" {{ old('type') == 'contractor' ? 'selected' : '' }}>Contractor</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="groups" class="form-label">Groups</label>
                            <select name="groups[]" id="groups" class="form-select" multiple>
                                @foreach($allGroups as $group)
                                    <option value="{{ $group->id }}" {{ (collect(old('groups'))->contains($group->id)) ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <select name="tags[]" id="tags" class="form-select" multiple>
                                @foreach($allTags as $tag)
                                    <option value="{{ $tag->id }}" {{ (collect(old('tags'))->contains($tag->id)) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Contact</button>
                        <a href="{{ route('contacts.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
