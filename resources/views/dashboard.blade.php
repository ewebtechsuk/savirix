<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    @php
                        $company = \App\Models\Tenant::where('data->company_id', '468173')->first();
                    @endphp
                    @if($company)
                        <div class="mt-6">
                            <h3 class="text-lg font-bold">Welcome to Aktonz Tenant Portal!</h3>
                            <div class="mt-2 text-green-600">Company profile found for Aktonz.</div>
                            <pre>{{ json_encode($company->data, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    @else
                        <div class="mt-6 text-red-600">No company profile found for Aktonz.</div>
                    @endif

                    @php
                        $tenants = \App\Models\Tenant::whereNotNull('data')->get();
                    @endphp
                    <div class="mt-6">
                        <h3 class="text-lg font-bold">Debug: All Tenants With Data</h3>
                        <ul>
                        @foreach($tenants as $tenant)
                            <li>
                                <strong>ID:</strong> {{ $tenant->id }}<br>
                                <strong>Data:</strong> {{ json_encode($tenant->data) }}
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
