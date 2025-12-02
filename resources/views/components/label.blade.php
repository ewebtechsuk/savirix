@props([
    'for' => null,
    'value' => null,
])

<label
    @if($for) for="{{ $for }}" @endif
    {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}
>
    @if($value !== null)
        {{ $value }}
    @else
        {{ $slot }}
    @endif
</label>
