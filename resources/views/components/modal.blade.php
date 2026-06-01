@props(['id', 'title' => ''])
<div id="{{ $id }}" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/50 transition-opacity modal-overlay" onclick="closeModal('{{ $id }}')"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-md bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-border-color flex justify-between items-center">
                    <h3 class="text-lg font-semibold leading-6 text-text-dark" id="modal-title">{{ $title }}</h3>
                    <button type="button" onclick="closeModal('{{ $id }}')" class="text-text-gray hover:text-text-dark">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    {{ $slot }}
                </div>
                @if(isset($footer))
                    <div class="bg-surface px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-border-color">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>