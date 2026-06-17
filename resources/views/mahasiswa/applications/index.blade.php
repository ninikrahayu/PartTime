@extends('layouts.mahasiswa')
@section('title', 'Lamaran Saya - Mahasiswa Partimeku')
@section('page_title', 'Status Lamaran')

@section('content')
<div class="max-w-7xl mx-auto space-y-4 md:space-y-6">

    <div class="flex flex-col md:flex-row justify-between gap-4">
        <div class="flex-1 w-full md:w-auto">
            <x-search-input placeholder="Cari nama lowongan atau penyedia..." class="w-full bg-white shadow-sm" />
        </div>
        <div class="flex gap-2 w-full md:w-auto">
            <x-select class="w-full md:w-48 bg-white shadow-sm">
                <option value="">Semua Status</option>
                <option value="menunggu">Menunggu Review</option>
                <option value="diproses">Sedang Diproses</option>
                <option value="diterima">Diterima</option>
                <option value="ditolak">Ditolak</option>
                <option value="selesai">Selesai</option>
            </x-select>
        </div>
    </div>

    @if(count($applications) > 0)
        <div class="space-y-4">
            @foreach($applications as $app)
                <x-card class="p-0 border-border-color shadow-sm overflow-hidden hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ url('/mahasiswa/applications/'.$app->id) }}'">
                    <div class="p-4 sm:p-5 flex flex-col sm:flex-row gap-4 sm:items-center justify-between">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="w-12 h-12 rounded-md bg-surface border border-border-color flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-briefcase text-text-gray text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-text-dark text-base sm:text-lg mb-1 line-clamp-1">{{ $app->lowongan->judul ?? '-' }}</h3>
                                <p class="text-sm text-text-gray mb-2">{{ $app->lowongan->penyedia->name ?? '-' }}</p>
                                <div class="flex items-center gap-4 text-xs text-text-gray">
                                    <span class="flex items-center gap-1"><i class="fa-regular fa-calendar"></i> Melamar pada {{ $app->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 sm:mt-0 flex items-center justify-between sm:flex-col sm:items-end gap-3 border-t sm:border-t-0 border-border-color pt-4 sm:pt-0">
                            <x-status-badge :status="$app->status" />
                            <span class="text-sm font-medium text-primary flex items-center gap-1 group-hover:underline">
                                Lihat Detail <i class="fa-solid fa-arrow-right text-xs"></i>
                            </span>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>
        
        <div class="mt-6">
            <x-pagination />
        </div>
    @else
        <x-empty-state icon="fa-paper-plane" title="Belum Ada Lamaran" description="Anda belum mengirimkan lamaran apapun. Mulai eksplorasi lowongan yang tersedia.">
            <x-slot name="action">
                <a href="{{ url('/mahasiswa/jobs') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md text-white bg-primary hover:bg-blue-900 shadow-sm transition-colors text-sm"><i class="fa-solid fa-search mr-2"></i> Cari Lowongan</a>
            </x-slot>
        </x-empty-state>
    @endif

</div>
@endsection
