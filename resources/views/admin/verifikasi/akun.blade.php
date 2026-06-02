@extends('layouts.admin')

@section('title', 'Verifikasi Akun - Admin Partimeku')
@section('page_title', 'Verifikasi Akun')

@php
    $statusOptions = collect($verificationStatuses)->pluck('label', 'value');
@endphp

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-medium text-primary">Verifikasi Akun</p>
            <h2 class="mt-1 text-2xl font-semibold text-text-dark">Akun Mahasiswa dan Penyedia</h2>
            <p class="mt-1 text-sm text-text-gray">Tinjau dokumen verifikasi dan setujui akun yang memenuhi syarat.</p>
        </div>
        <div class="flex gap-2">
            <x-badge color="warning">{{ $students->where('verification_status', 'menunggu_verifikasi')->count() }} mahasiswa pending</x-badge>
            <x-badge color="warning">{{ $providers->where('verification_status', 'menunggu_verifikasi')->count() }} penyedia pending</x-badge>
        </div>
    </div>

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

        <div id="account-panel-mahasiswa" class="p-5">
            <x-table>
                <x-slot:thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Kampus</th>
                        <th>Status</th>
                        <th>Dokumen</th>
                        <th>Tanggal Daftar</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </x-slot:thead>
                @foreach($students as $student)
                    @php($profile = $studentProfiles->get($student['id']))
                    <tr>
                        <td>
                            <div class="font-medium text-text-dark">{{ $student['name'] }}</div>
                            <div class="text-xs text-text-gray">{{ $student['email'] }}</div>
                        </td>
                        <td>
                            <div>{{ $profile['campus'] ?? '-' }}</div>
                            <div class="text-xs text-text-gray">{{ $profile['major'] ?? '-' }}</div>
                        </td>
                        <td><x-status-badge :status="$student['verification_status']" /></td>
                        <td>
                            <div class="text-sm">{{ $profile['ktm_file'] ?? 'KTM belum tersedia' }}</div>
                            <div class="text-xs text-text-gray">{{ $profile['cv_file'] ?? 'CV opsional belum tersedia' }}</div>
                        </td>
                        <td>{{ $student['created_at'] }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="openModal('student-detail-{{ $student['id'] }}')" class="rounded-md border border-border-color bg-white px-3 py-1.5 text-xs font-medium text-text-dark hover:bg-surface">Detail</button>
                                @if($student['verification_status'] === 'menunggu_verifikasi')
                                    <button type="button" onclick="approveDummy('Akun mahasiswa berhasil disetujui.')" class="rounded-md bg-success px-3 py-1.5 text-xs font-medium text-white hover:bg-green-700">Approve</button>
                                    <button type="button" onclick="openModal('student-reject-{{ $student['id'] }}')" class="rounded-md bg-danger px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">Reject</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>

        <div id="account-panel-penyedia" class="hidden p-5">
            <x-table>
                <x-slot:thead>
                    <tr>
                        <th>Penyedia</th>
                        <th>Usaha / Instansi</th>
                        <th>Status</th>
                        <th>Dokumen</th>
                        <th>Tanggal Daftar</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </x-slot:thead>
                @foreach($providers as $provider)
                    @php($profile = $providerProfiles->get($provider['id']))
                    <tr>
                        <td>
                            <div class="font-medium text-text-dark">{{ $provider['name'] }}</div>
                            <div class="text-xs text-text-gray">{{ $provider['email'] }}</div>
                        </td>
                        <td>
                            <div>{{ $profile['company_name'] ?? '-' }}</div>
                            <div class="text-xs text-text-gray">{{ $profile['company_type'] ?? '-' }}</div>
                        </td>
                        <td><x-status-badge :status="$provider['verification_status']" /></td>
                        <td>
                            <div class="text-sm">{{ $profile['verification_document'] ?? 'Dokumen belum tersedia' }}</div>
                            <div class="text-xs text-text-gray">{{ $profile['logo'] ?? 'Logo belum tersedia' }}</div>
                        </td>
                        <td>{{ $provider['created_at'] }}</td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="openModal('provider-detail-{{ $provider['id'] }}')" class="rounded-md border border-border-color bg-white px-3 py-1.5 text-xs font-medium text-text-dark hover:bg-surface">Detail</button>
                                @if($provider['verification_status'] === 'menunggu_verifikasi')
                                    <button type="button" onclick="approveDummy('Akun penyedia berhasil disetujui.')" class="rounded-md bg-success px-3 py-1.5 text-xs font-medium text-white hover:bg-green-700">Approve</button>
                                    <button type="button" onclick="openModal('provider-reject-{{ $provider['id'] }}')" class="rounded-md bg-danger px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">Reject</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
    </div>
</div>

@foreach($students as $student)
    @php($profile = $studentProfiles->get($student['id']))
    <x-modal id="student-detail-{{ $student['id'] }}" title="Detail Verifikasi Mahasiswa">
        <div class="space-y-5">
            <x-verification-status-panel :status="$student['verification_status']" :rejection-reason="$profile['rejection_reason'] ?? null" />
            <div class="grid gap-3 text-sm sm:grid-cols-2">
                <div><span class="text-text-gray">Nama</span><p class="font-medium text-text-dark">{{ $student['name'] }}</p></div>
                <div><span class="text-text-gray">Email</span><p class="font-medium text-text-dark">{{ $student['email'] }}</p></div>
                <div><span class="text-text-gray">Kampus</span><p class="font-medium text-text-dark">{{ $profile['campus'] ?? '-' }}</p></div>
                <div><span class="text-text-gray">Jurusan</span><p class="font-medium text-text-dark">{{ $profile['major'] ?? '-' }}</p></div>
                <div><span class="text-text-gray">Semester</span><p class="font-medium text-text-dark">{{ $profile['semester'] ?? '-' }}</p></div>
                <div><span class="text-text-gray">Telepon</span><p class="font-medium text-text-dark">{{ $student['phone'] }}</p></div>
            </div>
            <div class="rounded-md border border-border-color bg-surface p-4">
                <h4 class="text-sm font-semibold text-text-dark">Preview Dokumen</h4>
                <div class="mt-3 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-md border border-border-color bg-white p-3">
                        <p class="text-xs text-text-gray">KTM</p>
                        <p class="mt-1 truncate text-sm font-medium text-text-dark">{{ $profile['ktm_file'] ?? '-' }}</p>
                        @if(isset($profile['ktm_file']))
                        <div class="mt-2 flex gap-3">
                            <a href="#" target="_blank" class="text-xs text-primary hover:text-blue-900"><i class="fa-solid fa-eye mr-1"></i>Preview</a>
                            <a href="#" download="{{ $profile['ktm_file'] }}" class="text-xs text-primary hover:text-blue-900"><i class="fa-solid fa-download mr-1"></i>Download</a>
                        </div>
                        @endif
                    </div>
                    <div class="rounded-md border border-border-color bg-white p-3">
                        <p class="text-xs text-text-gray">CV Opsional</p>
                        <p class="mt-1 truncate text-sm font-medium text-text-dark">{{ $profile['cv_file'] ?? '-' }}</p>
                        @if(isset($profile['cv_file']))
                        <div class="mt-2 flex gap-3">
                            <a href="#" target="_blank" class="text-xs text-primary hover:text-blue-900"><i class="fa-solid fa-eye mr-1"></i>Preview</a>
                            <a href="#" download="{{ $profile['cv_file'] }}" class="text-xs text-primary hover:text-blue-900"><i class="fa-solid fa-download mr-1"></i>Download</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-modal>

    <x-modal id="student-reject-{{ $student['id'] }}" title="Tolak Verifikasi Mahasiswa">
        <div class="space-y-4">
            <p class="text-sm text-text-gray">Masukkan alasan penolakan untuk {{ $student['name'] }}.</p>
            <label class="block text-sm font-medium text-text-dark">Alasan reject<x-textarea rows="4" class="mt-2" placeholder="Contoh: KTM tidak terlihat jelas."></x-textarea></label>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('student-reject-{{ $student['id'] }}')" class="rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">Batal</button>
                <button type="button" onclick="rejectDummy('student-reject-{{ $student['id'] }}', 'Verifikasi mahasiswa berhasil ditolak.')" class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Tolak</button>
            </div>
        </div>
    </x-modal>
@endforeach

@foreach($providers as $provider)
    @php($profile = $providerProfiles->get($provider['id']))
    <x-modal id="provider-detail-{{ $provider['id'] }}" title="Detail Verifikasi Penyedia">
        <div class="space-y-5">
            <x-verification-status-panel :status="$provider['verification_status']" :rejection-reason="$profile['rejection_reason'] ?? null" />
            <div class="grid gap-3 text-sm sm:grid-cols-2">
                <div><span class="text-text-gray">Penanggung Jawab</span><p class="font-medium text-text-dark">{{ $provider['name'] }}</p></div>
                <div><span class="text-text-gray">Email</span><p class="font-medium text-text-dark">{{ $provider['email'] }}</p></div>
                <div><span class="text-text-gray">Usaha</span><p class="font-medium text-text-dark">{{ $profile['company_name'] ?? '-' }}</p></div>
                <div><span class="text-text-gray">Jenis</span><p class="font-medium text-text-dark">{{ $profile['company_type'] ?? '-' }}</p></div>
                <div class="sm:col-span-2"><span class="text-text-gray">Alamat</span><p class="font-medium text-text-dark">{{ $profile['address'] ?? '-' }}</p></div>
            </div>
            <div class="rounded-md border border-border-color bg-surface p-4">
                <h4 class="text-sm font-semibold text-text-dark">Preview Dokumen</h4>
                <div class="mt-3 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-md border border-border-color bg-white p-3">
                        <p class="text-xs text-text-gray">Dokumen Usaha</p>
                        <p class="mt-1 truncate text-sm font-medium text-text-dark">{{ $profile['verification_document'] ?? '-' }}</p>
                        @if(isset($profile['verification_document']))
                        <div class="mt-2 flex gap-3">
                            <a href="#" target="_blank" class="text-xs text-primary hover:text-blue-900"><i class="fa-solid fa-eye mr-1"></i>Preview</a>
                            <a href="#" download="{{ $profile['verification_document'] }}" class="text-xs text-primary hover:text-blue-900"><i class="fa-solid fa-download mr-1"></i>Download</a>
                        </div>
                        @endif
                    </div>
                    <div class="rounded-md border border-border-color bg-white p-3">
                        <p class="text-xs text-text-gray">Logo Usaha</p>
                        <p class="mt-1 truncate text-sm font-medium text-text-dark">{{ $profile['logo'] ?? '-' }}</p>
                        @if(isset($profile['logo']))
                        <div class="mt-2 flex gap-3">
                            <a href="#" target="_blank" class="text-xs text-primary hover:text-blue-900"><i class="fa-solid fa-eye mr-1"></i>Preview</a>
                            <a href="#" download="{{ $profile['logo'] }}" class="text-xs text-primary hover:text-blue-900"><i class="fa-solid fa-download mr-1"></i>Download</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-modal>

    <x-modal id="provider-reject-{{ $provider['id'] }}" title="Tolak Verifikasi Penyedia">
        <div class="space-y-4">
            <p class="text-sm text-text-gray">Masukkan alasan penolakan untuk {{ $profile['company_name'] ?? $provider['name'] }}.</p>
            <label class="block text-sm font-medium text-text-dark">Alasan reject<x-textarea rows="4" class="mt-2" placeholder="Contoh: Dokumen usaha tidak valid."></x-textarea></label>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal('provider-reject-{{ $provider['id'] }}')" class="rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">Batal</button>
                <button type="button" onclick="rejectDummy('provider-reject-{{ $provider['id'] }}', 'Verifikasi penyedia berhasil ditolak.')" class="rounded-md bg-danger px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Tolak</button>
            </div>
        </div>
    </x-modal>
@endforeach

@push('scripts')
<script>
    function switchAccountTab(activeTab) {
        const tabs = ['mahasiswa', 'penyedia'];

        tabs.forEach((tab) => {
            const button = document.getElementById(`account-tab-${tab}`);
            const panel = document.getElementById(`account-panel-${tab}`);
            const isActive = tab === activeTab;

            if (button) {
                button.classList.toggle('border-primary', isActive);
                button.classList.toggle('text-primary', isActive);
                button.classList.toggle('border-transparent', !isActive);
                button.classList.toggle('text-text-gray', !isActive);
            }

            if (panel) {
                panel.classList.toggle('hidden', !isActive);
            }
        });
    }
</script>
@endpush
@endsection
