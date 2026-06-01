<div {{ $attributes->merge(['class' => 'bg-white rounded-md border border-border-color shadow-sm flex flex-col h-full']) }}>
    @if(isset($header))
        <div class="px-5 py-4 border-b border-border-color shrink-0">
            {{ $header }}
        </div>
    @endif
    
    <div class="p-5 flex-grow">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-5 py-4 border-t border-border-color bg-surface rounded-b-md shrink-0">
            {{ $footer }}
        </div>
    @endif
</div>