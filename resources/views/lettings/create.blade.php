@extends('layouts.app')

@section('content')
<div class="container-fluid pt-3">
    <h2 class="mb-4">Add Lettings Property</h2>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('lettings.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="address_1" class="form-label">Address Line 1</label>
                        <input type="text" class="form-control" id="address_1" name="address_1" required>
                    </div>
                    <div class="col-md-6">
                        <label for="borough" class="form-label">Borough</label>
                        <select class="form-control" id="borough" name="borough">
                            <option value="">Select Borough</option>
                            <option value="Hackney">Hackney</option>
                            <option value="Islington">Islington</option>
                            <option value="Newham">Newham</option>
                            <option value="Stratford">Stratford</option>
                            <!-- Add more boroughs as needed -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label">Property Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="">Select Type</option>
                            <option value="apartment">Apartment</option>
                            <option value="bungalow">Bungalow</option>
                            <option value="flat">Flat</option>
                            <option value="house">House</option>
                            <option value="studio">Studio</option>
                            <!-- Add more types as needed -->
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="available">Available</option>
                            <option value="let_agreed">Let Agreed</option>
                            <option value="let">Let</option>
                            <option value="withdrawn">Withdrawn</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="country" class="form-label">Country</label>
                        <select class="form-control" id="country" name="country">
                            <option value="GB">United Kingdom</option>
                            <option value="NG">Nigeria</option>
                            <option value="IN">India</option>
                            <option value="US">United States</option>
                            <!-- Add more countries as needed -->
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" id="pinned" name="pinned" value="1">
                            <label class="form-check-label" for="pinned">Pin Note</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <a href="{{ route('lettings.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
