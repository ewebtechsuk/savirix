@extends('layouts.app')

@section('content')
<div class="container-fluid pt-3">
    <div class="row mb-3">
        <div class="col">
            <h2>Lettings Property Details</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('lettings.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('properties.edit', $property) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Address</dt>
                <dd class="col-sm-9">{{ $property->address_1 }}</dd>

                <dt class="col-sm-3">Borough</dt>
                <dd class="col-sm-9">{{ $property->borough ?? '-' }}</dd>

                <dt class="col-sm-3">Type</dt>
                <dd class="col-sm-9">{{ ucfirst($property->type) }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">{{ ucfirst($property->status) }}</dd>

                <dt class="col-sm-3">Country</dt>
                <dd class="col-sm-9">{{ $property->country ?? 'GB' }}</dd>

                <dt class="col-sm-3">Notes</dt>
                <dd class="col-sm-9">{{ $property->notes }}</dd>

                <dt class="col-sm-3">Pinned</dt>
                <dd class="col-sm-9">
                    @if($property->pinned)
                        <span class="badge bg-success">Pinned</span>
                    @else
                        <span class="badge bg-secondary">Not Pinned</span>
                    @endif
                </dd>
            </dl>
        </div>
    </div>
    <!-- Optional: Map placeholder -->
    <div class="card mb-4">
        <div class="card-body">
            <h5>Map</h5>
            <div style="width: 100%; height: 300px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #888;">
                Map integration coming soon
            </div>
            <small class="help-text text-muted">
                <strong>Hint:</strong> Click on the circular handles to change the region's area.
            </small>
        </div>
    </div>
</div>
@endsection
