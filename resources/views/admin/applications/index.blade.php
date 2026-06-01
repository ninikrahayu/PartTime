@extends('layouts.admin')
@section('title', 'Manajemen Lamaran - Admin Partimeku')
@section('page_title', 'Manajemen Lamaran')

@section('content')
<div class="space-y-6">
    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between gap-4">
        <div class="flex flex-col sm:flex-row gap-4 flex-1">
            <x-search-input placeholder="Cari nama pelamar..." class="w-full sm:w-64" />
            <x-select class="w-full sm:w-40">
                <option value="">Status</option>
                <option value="menunggu">Menunggu</option>
                <option value="diterima">Diterima</option>
                <option value="ditolak">Ditolak</option>
            </x-select>
            <x-input type="date" class="w-full sm:w-40" />
        </div>
    </div>

    <!-- Table -->
    <x-card class="p-0 border-none shadow-sm overflow-hidden">
        <x-table>
            <x-slot name="thead">
                <tr>
                    <th scope="col" class="px-6 py-3">Pelamar</th>
                    <th scope="col" class="px-6 py-3">Lowongan & Penyedia</th>
                    <th scope="col" class="px-6 py-3">Tgl Lamar</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </x-slot>
            @foreach($applications as $app)
            <tr class="bg-white border-b border-border-color hover:bg-surface">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs shrink-0">
                            {{ substr($app['student_name'], 0, 1) }}
                        </div>
                        <div class="font-medium text-text-dark">{{ $app['student_name'] }}</div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-text-dark text-sm">{{ $app['job_title'] }}</div>
                    <div class="text-xs text-text-gray">{{ $app['provider_name'] }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-text-gray">
                    {{ \Carbon\Carbon::parse($app['applied_at'])->format('d M Y') }}
                </td>
                <td class="px-6 py-4">
                    <x-status-badge :status="$app['status']" />
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <button onclick="showToast('Detail lamaran', 'info')" class="text-text-gray hover:text-primary transition-colors" title="Detail & Timeline">
                            <i class="fa-solid fa-list-check"></i>
                        </button>
                        <button onclick="showToast('Lihat Review Dua Arah', 'info')" class="text-text-gray hover:text-warning transition-colors" title="Review">
                            <i class="fa-solid fa-star-half-stroke"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </x-table>
        <x-pagination />
    </x-card>
</div>

@push('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    function confirmAction(id) { closeModal(id); showToast('Berhasil', 'success'); }
</script>
@endpush
@endsection
