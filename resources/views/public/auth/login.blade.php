<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Partimeku</title>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-50/50 min-h-screen flex items-center justify-center p-4 font-sans text-text-dark">

    <!-- Card Wrapper -->
    <div class="max-w-5xl w-full bg-white rounded-[2rem] shadow-xl overflow-hidden flex flex-col md:flex-row min-h-[600px]">
        
        <!-- Left Side: Form -->
        <div class="w-full md:w-1/2 p-10 md:p-16 flex flex-col justify-center relative">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="absolute top-8 left-10 md:left-16 flex items-center gap-2 font-bold text-lg text-primary hover:opacity-80 transition-opacity">
                <i class="fa-solid fa-briefcase text-secondary"></i> Partimeku
            </a>

            <div class="mt-12 md:mt-0 w-full mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold text-text-dark mb-10 tracking-tight">Masuk ke akun Anda</h1>
                

                <form data-dummy-submit data-success-message="Berhasil masuk ke dashboard." class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-2">Email</label>
                        <x-input name="login" type="text" placeholder="Masukkan email Anda" class="w-full py-3.5 px-4 bg-surface border-border-color rounded-xl" required />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-2">Password</label>
                        <div class="relative">
                            <x-input name="password" type="password" placeholder="Masukkan password yang kuat" class="w-full py-3.5 px-4 pr-12 bg-surface border-border-color rounded-xl" required />
                            <button type="button" class="absolute inset-y-0 right-0 px-4 flex items-center text-text-gray hover:text-text-dark transition-colors">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-3 text-sm mt-4">
                        <label class="inline-flex items-center gap-2 text-text-gray font-medium cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-border-color text-primary focus:ring-primary w-4 h-4"> Ingat saya
                        </label>
                        <a href="{{ url('/forgot-password') }}" class="font-medium text-primary hover:text-blue-900 hover:underline">Lupa password?</a>
                    </div>

                    <div class="flex flex-col items-center gap-4 mt-8 pt-2">
                        <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white font-semibold py-3.5 px-8 rounded-xl shadow-md transition-colors">
                            Masuk Sekarang!
                        </button>
                        <span class="text-sm font-medium text-text-gray"> Belum punya akun? <a href="{{ url('/register') }}" class="text-sm font-medium text-text-gray hover:text-primary hover:underline underline-offset-4 decoration-2 transition-all">
                            Daftar
                        </a>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side: Image -->
        <div class="hidden md:block w-1/2 p-4">
            <div class="w-full h-full rounded-[1.5rem] bg-surface overflow-hidden relative">
                <!-- Gunakan gambar placeholder dummy yang cocok dengan tema mahasiswa -->
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1000&auto=format&fit=crop" alt="Mahasiswa" class="w-full h-full object-cover object-center" />
            </div>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
