@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
    {{ $value ?? $slot }}
</label>