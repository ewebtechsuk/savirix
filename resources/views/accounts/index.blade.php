<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Accounts') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Accounts module for Aktonz tenant.<br>
                    @php
                        $tenant = tenant();
                    @endphp
                    <div class="mt-4 text-sm text-gray-600">
                        <strong>Tenant ID:</strong> {{ $tenant ? $tenant->id : 'none' }}<br>
                        <strong>Company ID:</strong> {{ $tenant ? $tenant->company_id : 'none' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
