@extends('layouts.public')

@section('title', 'Daftar Mahasiswa - Partimeku')

@section('content')
<section class="bg-surface py-10 sm:py-14">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-md border border-border-color bg-white shadow-sm">
            <div class="border-b border-border-color px-5 py-5 sm:px-6">
                <p class="text-sm font-medium text-primary">Akun Mahasiswa</p>
                <h1 class="mt-1 text-2xl font-semibold text-text-dark">Daftar sebagai Mahasiswa</h1>
                <p class="mt-2 text-sm text-text-gray">Lengkapi data akun, data kampus, dan upload KTM untuk proses verifikasi.</p>
                
            </div>
            @if(session('success'))
                <div class="m-5 rounded-md bg-green-50 p-4 border border-green-200">
                    <p class="text-sm font-medium text-green-800"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="m-5 rounded-md bg-red-50 p-4 border border-red-200">
                    <p class="text-sm font-bold text-red-800 mb-2"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Pendaftaran Gagal:</p>
                    <ul class="list-disc pl-5 text-sm font-medium text-red-800 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-6">
                @csrf
                <input type="hidden" name="role" value="mahasiswa">
                
                <!-- Step 1: Data Akun -->
                <div id="step-1-content" class="space-y-6">
                    <h2 class="text-lg font-semibold text-text-dark border-b border-border-color pb-2">Data Akun</h2>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block text-sm font-medium text-text-dark">Nama lengkap<x-input name="name" type="text" class="mt-2" placeholder="Nama lengkap" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Email<x-input name="email" type="email" class="mt-2" placeholder="nama@email.com" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Username<x-input name="username" type="text" class="mt-2" placeholder="username" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Nomor telepon<x-input name="phone" type="tel" class="mt-2" placeholder="08xxxxxxxxxx" required /></label>
                        <div>
                     <label class="block text-sm font-medium text-text-dark mb-1">Password</label>
                     <div class="relative mt-2">
                         <x-input name="password" type="password" class="w-full pr-12" placeholder="Minimal 8 karakter" required />
                         <button type="button" onclick="togglePassword(this)" class="absolute inset-y-0 right-0 px-4 flex items-center text-text-gray hover:text-text-dark transition-colors">
                             <i class="fa-solid fa-eye"></i>
                         </button>
                     </div>
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-text-dark mb-1">Konfirmasi password</label>
                     <div class="relative mt-2">
                         <x-input name="password_confirmation" type="password" class="w-full pr-12" placeholder="Ulangi password" required />
                         <button type="button" onclick="togglePassword(this)" class="absolute inset-y-0 right-0 px-4 flex items-center text-text-gray hover:text-text-dark transition-colors">
                             <i class="fa-solid fa-eye"></i>
                         </button>
                     </div>
                 </div>
                    </div>
                    <div class="flex flex-col-reverse gap-3 border-t border-border-color pt-6 sm:flex-row sm:justify-between mt-8">
                        <a href="{{ url('/register') }}" class="inline-flex justify-center rounded-md border border-border-color bg-white px-6 py-2 text-sm font-medium text-text-dark hover:bg-surface">Kembali</a>
                        <button type="button" onclick="nextStep()" class="inline-flex justify-center rounded-md bg-primary px-6 py-2 text-sm font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">Selanjutnya <i class="fa-solid fa-arrow-right ml-2 mt-0.5"></i></button>
                    </div>
                </div>

                <!-- Step 2: Data Mahasiswa -->
                <div id="step-2-content" class="hidden space-y-6">
                    <h2 class="text-lg font-semibold text-text-dark border-b border-border-color pb-2">Data Mahasiswa</h2>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block text-sm font-medium text-text-dark">Nama kampus<x-input name="campus" type="text" class="mt-2" placeholder="Nama kampus" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Jurusan<x-input name="major" type="text" class="mt-2" placeholder="Jurusan" required /></label>
                        <label class="block text-sm font-medium text-text-dark">Semester<x-select name="semester" class="mt-2" required><option value="">Pilih semester</option>@for($i = 1; $i <= 14; $i++)<option value="{{ $i }}">{{ $i }}</option>@endfor</x-select></label>
                        <label class="block text-sm font-medium text-text-dark">IPK<x-input name="ipk" type="number" step="0.01" min="0" max="4.00" class="mt-2" placeholder="Contoh: 3.50" required /></label>
                        <label class="block text-sm font-medium text-text-dark sm:col-span-2">Alamat<x-textarea name="address" rows="4" class="mt-2" placeholder="Alamat domisili" required></x-textarea></label>
                    </div>
                    
                    <div class="mt-6">
                        <x-upload-document-card name="ktm" title="Upload KTM" description="KTM digunakan untuk verifikasi akun mahasiswa." formats="JPG, PNG, PDF" maxSize="2MB" accept=".jpg,.jpeg,.png,.pdf" />
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-border-color pt-6 sm:flex-row sm:justify-between mt-8">
                        <button type="button" onclick="prevStep()" class="inline-flex justify-center rounded-md border border-border-color bg-white px-6 py-2 text-sm font-medium text-text-dark hover:bg-surface"><i class="fa-solid fa-arrow-left mr-2 mt-0.5"></i> Sebelumnya</button>
                        <button type="submit" class="inline-flex justify-center rounded-md bg-primary px-6 py-2 text-sm font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"><i class="fa-solid fa-check mr-2 mt-0.5"></i> Daftar Mahasiswa</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function togglePassword(button) {
        const input = button.previousElementSibling;
        const icon = button.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
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
