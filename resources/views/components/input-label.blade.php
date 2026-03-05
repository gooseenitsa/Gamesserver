@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-xs text-gray-400 uppercase tracking-wide']) }}>
    {{ $value ?? $slot }}
</label>
