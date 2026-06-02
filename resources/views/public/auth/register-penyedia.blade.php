@extends('layouts.public')

@section('title', 'Daftar Penyedia - Partimeku')

@section('content')
<section class="bg-surface py-10 sm:py-14">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-md border border-border-color bg-white shadow-sm">
            <div class="border-b border-border-color px-5 py-5 sm:px-6">
                <p class="text-sm font-medium text-primary">Akun Penyedia</p>
                <h1 class="mt-1 text-2xl font-semibold text-text-dark">Daftar sebagai Penyedia Lowongan</h1>
                <p class="mt-2 text-sm text-text-gray">Lengkapi data penanggung jawab dan data usaha untuk proses verifikasi admin.</p>
                
            </div>

            <form data-dummy-submit data-success-message="Pendaftaran penyedia berhasil dikirim. Status akun Menunggu Verifikasi." class="p-5 sm:p-6">
                
                <!-- Step 1: Data Penanggung Jawab -->
                <div id="step-1-content" class="space-y-6">
                    <h2 class="text-lg font-semibold text-text-dark border-b border-border-color pb-2">Data Penanggung Jawab</h2>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block text-sm font-medium text-text-dark">Nama penanggung jawab<x-input name="name" type="text" class="mt-2" placeholder="Nama lengkap" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Email<x-input name="email" type="email" class="mt-2" placeholder="nama@usaha.com" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Username<x-input name="username" type="text" class="mt-2" placeholder="username" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Nomor telepon<x-input name="phone" type="tel" class="mt-2" placeholder="08xxxxxxxxxx" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Password<x-input name="password" type="password" class="mt-2" placeholder="Minimal 8 karakter" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Konfirmasi password<x-input name="password_confirmation" type="password" class="mt-2" placeholder="Ulangi password" required /></label>
                    </div>
                    <div class="flex flex-col-reverse gap-3 border-t border-border-color pt-6 sm:flex-row sm:justify-between mt-8">
                        <a href="{{ url('/register') }}" class="inline-flex justify-center rounded-md border border-border-color bg-white px-6 py-2 text-sm font-medium text-text-dark hover:bg-surface">Kembali</a>
                        <button type="button" onclick="nextStep()" class="inline-flex justify-center rounded-md bg-primary px-6 py-2 text-sm font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">Selanjutnya <i class="fa-solid fa-arrow-right ml-2 mt-0.5"></i></button>
                    </div>
                </div>

                <!-- Step 2: Data Usaha atau Instansi -->
                <div id="step-2-content" class="hidden space-y-6">
                    <h2 class="text-lg font-semibold text-text-dark border-b border-border-color pb-2">Data Usaha atau Instansi</h2>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block text-sm font-medium text-text-dark">Nama usaha / instansi<x-input name="company_name" type="text" class="mt-2" placeholder="Nama usaha" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Jenis usaha / instansi<x-select name="company_type" class="mt-2" required><option value="">Pilih jenis</option><option>UMKM</option><option>Cafe</option><option>Retail</option><option>Event Organizer</option><option>Perusahaan</option><option>Instansi</option><option>Studio Kreatif</option><option>Lainnya</option></x-select></label>
                        <label class="block text-sm font-medium text-text-dark sm:col-span-2">Alamat usaha / instansi<x-textarea name="business_address" rows="3" class="mt-2" placeholder="Alamat usaha" required></x-textarea></label>
                        <label class="block text-sm font-medium text-text-dark sm:col-span-2">Deskripsi usaha / instansi<x-textarea name="business_description" rows="4" class="mt-2" placeholder="Deskripsikan usaha atau instansi" required></x-textarea></label>
                    </div>
                    
                    <div class="mt-6">
                        <x-upload-document-card name="verification_document" title="Upload Dokumen Verifikasi" description="Dokumen usaha digunakan untuk proses verifikasi penyedia (Contoh: NIB, SIUP, NPWP Usaha, atau Surat Keterangan Usaha)." formats="PDF, JPG, PNG" maxSize="5MB" accept=".pdf,.jpg,.jpeg,.png" />
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-border-color pt-6 sm:flex-row sm:justify-between mt-8">
                        <button type="button" onclick="prevStep()" class="inline-flex justify-center rounded-md border border-border-color bg-white px-6 py-2 text-sm font-medium text-text-dark hover:bg-surface"><i class="fa-solid fa-arrow-left mr-2 mt-0.5"></i> Sebelumnya</button>
                        <button type="submit" class="inline-flex justify-center rounded-md bg-primary px-6 py-2 text-sm font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"><i class="fa-solid fa-check mr-2 mt-0.5"></i> Daftar Penyedia</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function nextStep() {
        document.getElementById('step-1-content').classList.add('hidden');
        document.getElementById('step-2-content').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function prevStep() {
        document.getElementById('step-2-content').classList.add('hidden');
        document.getElementById('step-1-content').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endpush
@endsection
