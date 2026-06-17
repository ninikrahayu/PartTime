@extends('layouts.admin')

@section('title', 'Verifikasi Akun - Admin Partimeku')
@section('page_title', 'Verifikasi Akun')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-medium text-primary">Verifikasi Akun</p>
            <h2 class="mt-1 text-2xl font-semibold text-text-dark">Akun Mahasiswa dan Penyedia</h2>
            <p class="mt-1 text-sm text-text-gray">Tinjau dokumen verifikasi dan setujui akun yang memenuhi syarat.</p>
        </div>
        <div class="flex gap-2">
            <x-badge color="warning">{{ $students->where('status', 'pending')->count() }} mahasiswa pending</x-badge>
            <x-badge color="warning">{{ $providers->where('status', 'pending')->count() }} penyedia pending</x-badge>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-md bg-green-50 p-4 border border-green-200">
            <p class="text-sm font-medium text-green-800"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
        </div>
    @endif

    <x-card>
        <div class="grid gap-3 md:grid-cols-[1fr_220px]">
            <label class="block text-sm font-medium text-text-dark">
                Search akun
                <x-input class="mt-2" type="search" placeholder="Cari nama, email, atau username" />
            </label>
            <label class="block text-sm font-medium text-text-dark">
                Filter status
                <x-select class="mt-2">
                    <option value="">Semua status</option>
                    @foreach($verificationStatuses as $status)
                        <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                    @endforeach
                </x-select>
            </label>
        </div>
    </x-card>

    <div class="rounded-md border border-border-color bg-white shadow-sm">
        <div class="border-b border-border-color px-5">
            <nav class="-mb-px flex gap-6 overflow-x-auto">
                <button id="account-tab-mahasiswa" type="button" onclick="switchAccountTab('mahasiswa')" class="whitespace-nowrap border-b-2 border-primary px-1 py-4 text-sm font-medium text-primary">
                    <i class="fa-solid fa-user-graduate mr-2"></i>Mahasiswa
                </button>
                <button id="account-tab-penyedia" type="button" onclick="switchAccountTab('penyedia')" class="whitespace-nowrap border-b-2 border-transparent px-1 py-4 text-sm font-medium text-text-gray hover:border-border-color hover:text-text-dark">
                    <i class="fa-solid fa-building mr-2"></i>Penyedia
                </button>
            </nav>
        </div>

        {{-- Tab Mahasiswa --}}
        <div id="account-panel-mahasiswa" class="p-5">
            <x-table>
                <x-slot:thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Kampus / Jurusan</th>
                        <th>Status</th>
                        <th>Dokumen KTM</th>
                        <th>Tgl Daftar</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </x-slot:thead>
                @forelse($students as $student)
                    @php($profile = $student->profile)
                    <tr>
                        <td>
                            <div class="font-medium text-text-dark">{{ $student->name }}</div>
                            <div class="text-xs text-text-gray">{{ $student->email }}</div>
                        </td>
                        <td>
                            <div>{{ $profile->universitas ?? '-' }}</div>
                            <div class="text-xs text-text-gray">{{ $profile->jurusan ?? '-' }}</div>
                        </td>
                        <td>
                            @php
                                $statusMap = ['pending' => 'warning', 'verified' => 'success', 'rejected' => 'danger'];
                                $labelMap  = ['pending' => 'Menunggu', 'verified' => 'Terverifikasi', 'rejected' => 'Ditolak'];
                            @endphp
                            <x-badge color="{{ $statusMap[$student->status] ?? 'secondary' }}">
                                {{ $labelMap[$student->status] ?? $student->status }}
                            </x-badge>
                        </td>
                        <td>
                            @if($profile && $profile->ktm_path)
                                <a href="{{ asset('storage/'.$profile->ktm_path) }}" target="_blank" class="text-xs text-primary hover:underline">
                                    <i class="fa-solid fa-file mr-1"></i>Lihat KTM
                                </a>
                            @else
                                <span class="text-xs text-text-gray">Belum ada</span>
                            @endif
                        </td>
                        <td class="text-sm text-text-gray">{{ $student->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                @if($student->status === 'pending')
                                    <form method="POST" action="{{ route('admin.verifikasi.approve', $student->id) }}" onsubmit="return confirm('Setujui akun {{ $student->name }}?')">
                                        @csrf
                                        <button type="submit" class="rounded-md bg-success px-3 py-1.5 text-xs font-medium text-white hover:bg-green-700">Approve</button>
                                    </form>
                                    <button type="button" onclick="openModal('student-reject-{{ $student->id }}')" class="rounded-md bg-danger px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">Reject</button>
                                @else
                                    <span class="text-xs text-text-gray italic">Sudah diproses</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-text-gray">Belum ada mahasiswa terdaftar.</td></tr>
                @endforelse
            </x-table>
        </div>

        {{-- Tab Penyedia --}}
        <div id="account-panel-penyedia" class="hidden p-5">
            <x-table>
                <x-slot:thead>
                    <tr>
                        <th>Penyedia</th>
                        <th>Usaha / Instansi</th>
                        <th>Status</th>
                        <th>Dokumen</th>
                        <th>Tgl Daftar</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </x-slot:thead>
                @forelse($providers as $provider)
                    @php($profile = $provider->profile)
                    <tr>
                        <td>
                            <div class="font-medium text-text-dark">{{ $provider->name }}</div>
                            <div class="text-xs text-text-gray">{{ $provider->email }}</div>
                        </td>
                        <td>
                            <div>{{ $profile->business_name ?? '-' }}</div>
                            <div class="text-xs text-text-gray">{{ $profile->business_type ?? '-' }}</div>
                        </td>
                        <td>
                            @php
                                $statusMap = ['pending' => 'warning', 'verified' => 'success', 'rejected' => 'danger'];
                                $labelMap  = ['pending' => 'Menunggu', 'verified' => 'Terverifikasi', 'rejected' => 'Ditolak'];
                            @endphp
                            <x-badge color="{{ $statusMap[$provider->status] ?? 'secondary' }}">
                                {{ $labelMap[$provider->status] ?? $provider->status }}
                            </x-badge>
                        </td>
                        <td>
                            @if($profile && $profile->document_path)
                                <a href="{{ asset('storage/'.$profile->document_path) }}" target="_blank" class="text-xs text-primary hover:underline">
                                    <i class="fa-solid fa-file mr-1"></i>Lihat Dokumen
                                </a>
                            @else
                                <span class="text-xs text-text-gray">Belum ada</span>
                            @endif
                        </td>
                        <td class="text-sm text-text-gray">{{ $provider->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                @if($provider->status === 'pending')
                                    <form method="POST" action="{{ route('admin.verifikasi.approve', $provider->id) }}" onsubmit="return confirm('Setujui akun {{ $provider->name }}?')">
                                        @csrf
                                        <button type="submit" class="rounded-md bg-success px-3 py-1.5 text-xs font-medium text-white hover:bg-green-700">Approve</button>
                                    </form>
                                    <button type="button" onclick="openModal('provider-reject-{{ $provider->id }}')" class="rounded-md bg-danger px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">Reject</button>
                                @else
                                    <span class="text-xs text-text-gray italic">Sudah diproses</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-text-gray">Belum ada penyedia terdaftar.</td></tr>
                @endforelse
            </x-table>
        </div>
    </div>
</div>

{{-- Modal Reject Mahasiswa --}}
@foreach($students as $student)
    <x-modal id="student-reject-{{ $student->id }}" title="Tolak Verifikasi Mahasiswa">
        <form method="POST" action="{{ route('admin.verifikasi.reject', $student->id) }}">
            @csrf
            <div class="space-y-4">
                <p class="text-sm text-text-gray">Masukkan alasan penolakan untuk <strong>{{ $student->name }}</strong>.</p>
                <label class="block text-sm font-medium text-text-dark">
                    Alasan reject
                    <x-textarea name="reason" rows="4" class="mt-2" placeholder="Contoh: KTM tidak terlihat jelas."></x-textarea>
                </label>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('student-reject-{{ $student->id }}')" class="rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">Batal</button>
                <button type="submit" class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Tolak</button>
            </div>
        </form>
    </x-modal>
@endforeach

{{-- Modal Reject Penyedia --}}
@foreach($providers as $provider)
    <x-modal id="provider-reject-{{ $provider->id }}" title="Tolak Verifikasi Penyedia">
        <form method="POST" action="{{ route('admin.verifikasi.reject', $provider->id) }}">
            @csrf
            <div class="space-y-4">
                <p class="text-sm text-text-gray">Masukkan alasan penolakan untuk <strong>{{ $provider->name }}</strong>.</p>
                <label class="block text-sm font-medium text-text-dark">
                    Alasan reject
                    <x-textarea name="reason" rows="4" class="mt-2" placeholder="Contoh: Dokumen usaha tidak valid."></x-textarea>
                </label>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('provider-reject-{{ $provider->id }}')" class="rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">Batal</button>
                <button type="submit" class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Tolak</button>
            </div>
        </form>
    </x-modal>
@endforeach

@push('scripts')
<script>
    function switchAccountTab(activeTab) {
        const tabs = ['mahasiswa', 'penyedia'];
        tabs.forEach((tab) => {
            const button = document.getElementById(`account-tab-${tab}`);
            const panel  = document.getElementById(`account-panel-${tab}`);
            const isActive = tab === activeTab;
            if (button) {
                button.classList.toggle('border-primary', isActive);
                button.classList.toggle('text-primary', isActive);
                button.classList.toggle('border-transparent', !isActive);
                button.classList.toggle('text-text-gray', !isActive);
            }
            if (panel) panel.classList.toggle('hidden', !isActive);
        });
    }
</script>
@endpush
@endsection
