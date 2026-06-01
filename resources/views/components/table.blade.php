<div class="overflow-x-auto rounded-md border border-border-color shadow-sm">
    <table {{ $attributes->merge(['class' => 'w-full text-sm text-left whitespace-nowrap bg-white']) }}>
        @if(isset($thead))
            <thead class="text-xs text-text-gray uppercase bg-surface border-b border-border-color">
                {{ $thead }}
            </thead>
        @endif
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>