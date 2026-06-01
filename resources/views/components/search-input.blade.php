<div class="relative">
    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none z-10">
        <i class="fa-solid fa-search text-text-gray"></i>
    </div>
    <x-input type="text" style="padding-left: 2.5rem;" class="{{ $attributes->get('class') }}" {{ $attributes->except(['class', 'style']) }} />
</div>