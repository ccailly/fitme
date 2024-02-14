@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium mb-2']) }}>
    {{ $value ?? $slot }}
</label>
