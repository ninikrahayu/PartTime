@extends('layouts.mahasiswa')
@section('title', 'Lowongan Favorit - Mahasiswa Partimeku')
@section('page_title', 'Favorit Saya')

@section('content')
<div class="max-w-7xl mx-auto space-y-4 md:space-y-6">

    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-2">
        <p class="text-sm text-text-gray">Anda menyimpan <strong>{{ count($favorites) }}</strong> lowongan part time.</p>
    </div>

    @if(count($favorites) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($favorites as $job)
                <x-card class="hover:shadow-md transition-shadow group flex flex-col h-full cursor-pointer relative border-border-color shadow-sm" onclick="window.location.href='{{ url('/mahasiswa/jobs/'.$job['id']) }}'">
                    
                    <!-- Remove Favorit Button -->
                    <button class="absolute top-3 right-3 w-8 h-8 rounded-full bg-surface border border-danger flex items-center justify-center text-danger hover:bg-danger hover:text-white transition-colors z-10" onclick="event.stopPropagation(); showToast('Dihapus dari Favorit', 'info'); this.closest('.group').remove();">
                        <i class="fa-solid fa-heart"></i>
                    </button>

                    <div class="flex items-start gap-3 mb-3">
                        <img src="{{ asset($job['provider_logo'] ?? 'images/dummy/default-logo.png') }}" alt="{{ $job['provider_name'] }}" class="w-12 h-12 rounded-md object-cover border border-border-color" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($job['provider_name']) }}&background=F9FAFB'">
                        <div class="flex-1 pr-8">
                            <h3 class="font-bold text-text-dark group-hover:text-primary transition-colors line-clamp-1 text-base">{{ $job['title'] }}</h3>
                            <p class="text-xs text-text-gray">{{ $job['provider_name'] }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-1.5 mb-4 flex-grow">
                        <div class="flex items-center text-xs text-text-gray">
                            <i class="fa-solid fa-location-dot w-4 text-center text-primary/70"></i> {{ $job['location'] }}
                        </div>
                        <div class="flex items-center text-xs text-text-gray font-medium text-text-dark mt-2">
                            <i class="fa-solid fa-money-bill-wave w-4 text-center text-primary/70"></i> Rp {{ number_format($job['salary'], 0, ',', '.') }}
                        </div>
                    </div>
                    
                    <div class="mt-auto pt-3 border-t border-border-color flex justify-between items-center">
                        <x-badge color="info">{{ $job['category'] }}</x-badge>
                        <x-button class="py-1 px-3 text-xs" onclick="event.stopPropagation(); window.location.href='{{ url('/mahasiswa/jobs/'.$job['id']) }}'">Lamar</x-button>
                    </div>
                </x-card>
            @endforeach
        </div>
    @else
        <x-empty-state icon="fa-heart" title="Belum Ada Favorit" description="Anda belum menyimpan lowongan apapun. Mulai cari dan simpan lowongan yang Anda sukai!">
            <x-slot name="action">
                <a href="{{ url('/mahasiswa/jobs') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md text-white bg-primary hover:bg-blue-900 shadow-sm transition-colors text-sm"><i class="fa-solid fa-search mr-2"></i> Cari Lowongan</a>
            </x-slot>
        </x-empty-state>
    @endif

</div>

<div id="toast-container" class="fixed bottom-20 md:bottom-4 right-4 z-[200] flex flex-col gap-2"></div>
<template id="toast-template">
    <div class="toast-item flex items-center w-full max-w-xs p-4 text-text-dark bg-white rounded-md shadow-lg border border-border-color transition-all duration-300 transform translate-x-full opacity-0">
        <div class="toast-icon inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg"></div>
        <div class="toast-message ml-3 text-sm font-medium"></div>
        <button type="button" class="toast-close ml-auto -mx-1.5 -my-1.5 bg-white text-text-gray hover:text-text-dark rounded-md p-1.5 inline-flex items-center justify-center h-8 w-8"><i class="fa-solid fa-xmark"></i></button>
    </div>
</template>
@endsection
