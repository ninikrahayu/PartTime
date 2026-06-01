@props(['label' => 'Filter', 'options' => []])
<div class="relative inline-block text-left">
    <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden')" class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface" id="menu-button" aria-expanded="true" aria-haspopup="true">
        {{ $label }}
        <i class="fa-solid fa-chevron-down -mr-1 text-text-gray"></i>
    </button>
    <div class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
        <div class="py-1" role="none">
            {{ $slot }}
        </div>
    </div>
</div>