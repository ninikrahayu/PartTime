@extends('layouts.admin')
@section('title', 'Manajemen Lamaran - Admin Partimeku')
@section('page_title', 'Manajemen Lamaran')

@section('content')
<div class="space-y-6">
    <!-- Action Bar -->
    <form method="GET" action="{{ route('admin.applications.index') }}" class="flex flex-col sm:flex-row justify-between gap-4">
        <div class="flex flex-col sm:flex-row gap-4 flex-1 items-center">
            <x-search-input name="search" value="{{ request('search') }}" placeholder="Cari nama pelamar..." class="w-full sm:w-64" />
            <x-select name="status" class="w-full sm:w-40" onchange="this.form.submit()">
                <option value="">Status</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Menunggu</option>
                <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </x-select>
            <x-input name="date" type="date" value="{{ request('date') }}" class="w-full sm:w-40" onchange="this.form.submit()" />
            
            @if(request()->hasAny(['search', 'status', 'date']) && (request('search') != '' || request('status') != '' || request('date') != ''))
                <a href="{{ route('admin.applications.index') }}" class="text-sm text-danger hover:underline whitespace-nowrap">
                    <i class="fa-solid fa-xmark mr-1"></i> Reset Filter
                </a>
            @endif
        </div>
        <div class="flex gap-2">
            <button type="submit" class="hidden">Search</button>
            <a href="{{ route('admin.applications.export.xls') }}" class="inline-flex items-center rounded-md bg-success border border-transparent px-4 py-2 text-sm font-medium text-white shadow-md hover:bg-green-700 focus:ring-2 focus:ring-success/50 transition-all">
                <i class="fa-solid fa-file-excel mr-2"></i> Export XLS
            </a>
            <a href="{{ route('admin.applications.export.pdf') }}" class="inline-flex items-center rounded-md bg-danger border border-transparent px-4 py-2 text-sm font-medium text-white shadow-md hover:bg-red-700 focus:ring-2 focus:ring-danger/50 transition-all">
                <i class="fa-solid fa-file-pdf mr-2"></i> Export PDF
            </a>
        </div>
    </form>
    
    <div class="text-sm text-text-gray">
        Menampilkan {{ $applications->firstItem() ?? 0 }} - {{ $applications->lastItem() ?? 0 }} dari {{ $applications->total() }} data
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
                        <a href="{{ url('/admin/applications/'.$app['id']) }}" class="text-text-gray hover:text-primary transition-colors" title="Detail">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </x-table>
        <div class="p-4 border-t border-border-color">
            {{ $applications->appends(request()->query())->links() }}
        </div>
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
