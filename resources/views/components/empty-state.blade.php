@props(['icon' => 'fa-folder-open', 'title' => 'Tidak Ada Data', 'description' => ''])
<div class="flex flex-col items-center justify-center py-12 px-4 text-center">
    <div class="w-16 h-16 bg-surface border border-border-color rounded-full flex items-center justify-center mb-4">
        <i class="fa-solid {{ $icon }} text-2xl text-text-gray"></i>
    </div>
    <h3 class="text-lg font-medium text-text-dark">{{ $title }}</h3>
    @if($description)
        <p class="mt-1 text-sm text-text-gray max-w-sm">{{ $description }}</p>
    @endif
    @if(isset($action))
        <div class="mt-4">
            {{ $action }}
        </div>
    @endif
</div>