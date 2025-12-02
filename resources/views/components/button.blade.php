@props([
    'type' => 'submit',
])

{{-- Alias so legacy <x-button> continues to work using the existing <x-primary-button> --}}
<x-primary-button
    :type="$type"
    {{ $attributes }}
>
    {{ $slot }}
</x-primary-button>
