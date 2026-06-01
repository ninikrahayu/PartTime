@props(['disabled' => false])
<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border border-border-color bg-background text-text-dark rounded-md focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary px-3 py-2 w-full transition-all disabled:bg-gray-100 disabled:cursor-not-allowed']) !!}>
    {{ $slot }}
</select>