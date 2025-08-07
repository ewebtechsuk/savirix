@extends('layouts.app')

@section('content')
<div class="container-fluid pt-3">
    <h2 class="mb-4">Lettings</h2>
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('lettings.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ request('address') }}">
                </div>
                <div class="col-md-3">
                    <label for="borough" class="form-label">Borough</label>
                    <select class="form-control" id="borough" name="borough">
                        <option value="">All Boroughs</option>
                        <option value="Hackney">Hackney</option>
                        <option value="Islington">Islington</option>
                        <option value="Newham">Newham</option>
                        <option value="Stratford">Stratford</option>
                        <!-- Add more boroughs as needed -->
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">All Statuses</option>
                        <option value="available">Available</option>
                        <option value="let_agreed">Let Agreed</option>
                        <option value="let">Let</option>
                        <option value="withdrawn">Withdrawn</option>
                        <!-- Add more statuses as needed -->
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-control" id="country" name="country">
                        <option value="">All Countries</option>
                        <option value="GB">United Kingdom</option>
                        <option value="NG">Nigeria</option>
                        <option value="IN">India</option>
                        <option value="US">United States</option>
                        <!-- Add more countries as needed -->
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Address</th>
                        <th>Borough</th>
                        <th>Status</th>
                        <th>Country</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($properties as $property)
                        <tr>
                            <td>{{ $property->address_1 ?? $property->title }}</td>
                            <td>{{ $property->borough ?? '-' }}</td>
                            <td>{{ ucfirst($property->status) }}</td>
                            <td>{{ $property->country ?? 'GB' }}</td>
                            <td>
                                <a href="{{ route('properties.show', $property) }}" class="btn btn-sm btn-outline-info">View</a>
                                <a href="{{ route('properties.edit', $property) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No lettings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
