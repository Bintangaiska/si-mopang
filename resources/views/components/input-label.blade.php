@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-polri-silver-dark']) }}>
    {{ $value ?? $slot }}
</label>