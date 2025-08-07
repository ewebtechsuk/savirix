@extends('layouts.app')

@section('content')
<div class="container-fluid pt-3">
    <div class="row mb-3">
        <div class="col">
            <h2>Edit Lettings Property</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('lettings.show', $property) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('lettings.update', $property) }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="address_1" class="form-label">Address Line 1</label>
                        <input type="text" class="form-control" id="address_1" name="address_1" value="{{ old('address_1', $property->address_1) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="borough" class="form-label">Borough</label>
                        <select class="form-control" id="borough" name="borough">
                            <option value="">Select Borough</option>
                            <option value="Hackney" @if($property->borough=='Hackney') selected @endif>Hackney</option>
                            <option value="Islington" @if($property->borough=='Islington') selected @endif>Islington</option>
                            <option value="Newham" @if($property->borough=='Newham') selected @endif>Newham</option>
                            <option value="Stratford" @if($property->borough=='Stratford') selected @endif>Stratford</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label">Property Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="apartment" @if($property->type=='apartment') selected @endif>Apartment</option>
                            <option value="bungalow" @if($property->type=='bungalow') selected @endif>Bungalow</option>
                            <option value="flat" @if($property->type=='flat') selected @endif>Flat</option>
                            <option value="house" @if($property->type=='house') selected @endif>House</option>
                            <option value="studio" @if($property->type=='studio') selected @endif>Studio</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="available" @if($property->status=='available') selected @endif>Available</option>
                            <option value="let_agreed" @if($property->status=='let_agreed') selected @endif>Let Agreed</option>
                            <option value="let" @if($property->status=='let') selected @endif>Let</option>
                            <option value="withdrawn" @if($property->status=='withdrawn') selected @endif>Withdrawn</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="country" class="form-label">Country</label>
                        <select class="form-control" id="country" name="country">
                            <option value="GB" @if($property->country=='GB') selected @endif>United Kingdom</option>
                            <option value="NG" @if($property->country=='NG') selected @endif>Nigeria</option>
                            <option value="IN" @if($property->country=='IN') selected @endif>India</option>
                            <option value="US" @if($property->country=='US') selected @endif>United States</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $property->notes) }}</textarea>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" id="pinned" name="pinned" value="1" @if($property->pinned) checked @endif>
                            <label class="form-check-label" for="pinned">Pin Note</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
