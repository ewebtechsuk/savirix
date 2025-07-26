@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="fw-bold mb-0">Properties</h1>
                        <a href="{{ route('properties.create') }}" class="btn btn-primary">Add Property</a>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form method="GET" action="{{ route('properties.index') }}" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search properties..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle bg-white mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">Photo</th>
                                    <th class="px-4 py-3">Title</th>
                                    <th class="px-4 py-3">Price</th>
                                    <th class="px-4 py-3">Type</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($properties as $property)
                                <tr>
                                    <td class="px-4 py-3">
                                        @if($property->photo)
                                            <img src="{{ asset('storage/' . $property->photo) }}" alt="Photo" class="rounded" width="60">
                                        @else
                                            <span class="text-muted">No photo</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold px-4 py-3">{{ $property->title }}</td>
                                    <td class="px-4 py-3">£{{ number_format($property->price, 2) }}</td>
                                    <td class="px-4 py-3">{{ ucfirst($property->type) }}</td>
                                    <td class="px-4 py-3"><span class="badge bg-{{ $property->status == 'available' ? 'success' : 'secondary' }}">{{ ucfirst($property->status) }}</span></td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('properties.show', $property) }}" class="btn btn-info btn-sm me-2">View</a>
                                        <a href="{{ route('properties.edit', $property) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                                        <form action="{{ route('properties.destroy', $property) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
