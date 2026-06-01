@extends('layouts.penyedia')

@section('title', 'Edit Lowongan - Penyedia Partimeku')
@section('page_title', 'Edit Lowongan')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-medium text-primary">Manajemen Lowongan</p>
            <h2 class="mt-1 text-2xl font-semibold text-text-dark">Edit Lowongan</h2>
            <p class="mt-1 text-sm text-text-gray">{{ $job['title'] }}</p>
        </div>
        <x-status-badge :status="$job['status']" />
    </div>

    <div class="rounded-md border border-info/20 bg-info/5 p-4 text-sm text-info">
        Perubahan pada lowongan dapat memerlukan review ulang admin sebelum tampil ke mahasiswa.
    </div>

    <x-card>
        <form data-provider-job-edit-form class="space-y-8">
            <div>
                <h3 class="text-base font-semibold text-text-dark">Informasi Pekerjaan</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium text-text-dark">
                        Nama pekerjaan
                        <x-input name="title" type="text" class="mt-2" :value="$job['title']" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Kategori pekerjaan
                        <x-select name="category_id" class="mt-2" required>
                            @foreach($categories as $category)
                                <option value="{{ $category['id'] }}" @selected($category['id'] === $job['category_id'])>{{ $category['name'] }}</option>
                            @endforeach
                        </x-select>
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Deskripsi pekerjaan
                        <x-textarea name="description" rows="5" class="mt-2" required>{{ $job['description'] }}</x-textarea>
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Syarat pekerjaan
                        <x-textarea name="requirements" rows="4" class="mt-2" required>{{ implode("\n", $job['requirements']) }}</x-textarea>
                    </label>
                </div>
            </div>

            <div>
                <h3 class="text-base font-semibold text-text-dark">Lokasi, Gaji, dan Jadwal</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium text-text-dark">
                        Lokasi
                        <x-input name="location" type="text" class="mt-2" :value="$job['location']" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Gaji / upah
                        <x-input name="salary" type="number" class="mt-2" :value="$job['salary']" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Tipe gaji
                        <x-select name="salary_type" class="mt-2" required>
                            @foreach($salaryTypes as $type)
                                <option @selected($type === $job['salary_type'])>{{ $type }}</option>
                            @endforeach
                        </x-select>
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Jadwal kerja
                        <x-input name="schedule" type="text" class="mt-2" :value="$job['schedule']" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Tanggal mulai kerja
                        <x-input name="start_date" type="date" class="mt-2" :value="$job['start_date']" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Tanggal akhir kerja
                        <x-input name="end_date" type="date" class="mt-2" :value="$job['end_date']" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Kuota
                        <x-input name="quota" type="number" class="mt-2" :value="$job['quota']" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark">
                        Batas akhir lamaran
                        <x-input name="deadline" type="date" class="mt-2" :value="$job['deadline']" required />
                    </label>
                    <label class="block text-sm font-medium text-text-dark sm:col-span-2">
                        Kontak tambahan opsional
                        <x-input name="contact" type="text" class="mt-2" placeholder="Nomor WhatsApp atau email opsional" />
                    </label>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-border-color pt-6 sm:flex-row sm:justify-between">
                <a href="{{ url('/penyedia/jobs/'.$job['id']) }}" class="inline-flex justify-center rounded-md border border-border-color bg-white px-4 py-2 text-sm font-medium text-text-dark hover:bg-surface">Batal</a>
                <button type="submit" class="inline-flex justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-blue-900">Simpan Perubahan</button>
            </div>
        </form>
    </x-card>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-provider-job-edit-form]').forEach((form) => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            showToast('Perubahan lowongan berhasil disimpan.', 'success');
        });
    });
</script>
@endpush
