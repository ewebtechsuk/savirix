<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Total Properties</h5>
                            <p class="display-6 fw-bold">{{ \App\Models\Property::count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Available</h5>
                            <p class="display-6 fw-bold text-success">{{ \App\Models\Property::where('status', 'available')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Sold/Let</h5>
                            <p class="display-6 fw-bold text-secondary">{{ \App\Models\Property::where('status', '!=', 'available')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Recent Activity</h5>
                            <p class="fw-bold">{{ \App\Models\Property::latest()->first()?->title ?? 'No recent' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3">Quick Actions</h4>
                    <a href="{{ route('properties.create') }}" class="btn btn-primary me-2">Add Property</a>
                    <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary">View All Properties</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
