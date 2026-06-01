@props(['tabs' => []])
<div class="border-b border-border-color mb-4">
    <nav class="-mb-px flex space-x-6 overflow-x-auto" aria-label="Tabs">
        @foreach($tabs as $tab)
            <a href="{{ $tab['url'] ?? '#' }}" class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium {{ ($tab['active'] ?? false) ? 'border-primary text-primary' : 'border-transparent text-text-gray hover:border-border-color hover:text-text-dark' }}">
                @if(isset($tab['icon']))
                    <i class="{{ $tab['icon'] }} mr-2"></i>
                @endif
                {{ $tab['label'] }}
            </a>
        @endforeach
    </nav>
</div>