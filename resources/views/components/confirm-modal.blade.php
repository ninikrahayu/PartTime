@props(['id', 'title' => 'Konfirmasi', 'message' => 'Apakah Anda yakin?', 'confirmText' => 'Ya, Lanjutkan', 'cancelText' => 'Batal', 'type' => 'danger'])
@php
    $btnColor = $type === 'danger' ? 'bg-danger hover:bg-red-700 text-white' : 'bg-primary hover:bg-blue-900 text-white';
    $iconColor = $type === 'danger' ? 'text-danger bg-danger/10' : 'text-primary bg-primary/10';
    $icon = $type === 'danger' ? 'fa-triangle-exclamation' : 'fa-circle-question';
@endphp
<x-modal :id="$id" title="">
    <div class="sm:flex sm:items-start">
        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full {{ $iconColor }} sm:mx-0 sm:h-10 sm:w-10">
            <i class="fa-solid {{ $icon }} text-lg"></i>
        </div>
        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
            <h3 class="text-lg font-semibold leading-6 text-text-dark" id="modal-title">{{ $title }}</h3>
            <div class="mt-2">
                <p class="text-sm text-text-gray">{{ $message }}</p>
            </div>
        </div>
    </div>
    <x-slot name="footer">
        <button type="button" class="inline-flex w-full justify-center rounded-md {{ $btnColor }} px-3 py-2 text-sm font-semibold shadow-sm sm:ml-3 sm:w-auto" onclick="confirmAction('{{ $id }}')">
            {{ $confirmText }}
        </button>
        <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-text-dark shadow-sm ring-1 ring-inset ring-border-color hover:bg-surface sm:mt-0 sm:w-auto" onclick="closeModal('{{ $id }}')">
            {{ $cancelText }}
        </button>
    </x-slot>
</x-modal>