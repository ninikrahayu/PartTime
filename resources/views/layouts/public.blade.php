<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Partimeku - Platform Part Time Mahasiswa')</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen bg-background text-text-dark font-sans antialiased">

    <!-- Navbar -->
    <header class="bg-white border-b border-border-color sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-primary flex items-center gap-2">
                        <i class="fa-solid fa-briefcase text-secondary"></i>
                        Partimeku
                    </a>
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'text-primary font-bold active' : 'text-text-gray font-medium' }} hover:text-primary transition-colors" data-target="home">Beranda</a>
                    <a href="{{ url('/lowongan') }}" class="nav-link {{ Request::is('lowongan*') ? 'text-primary font-bold active' : 'text-text-gray font-medium' }} hover:text-primary transition-colors" data-target="lowongan">Lowongan</a>
                    <a href="{{ url('/#cara-kerja') }}" class="nav-link text-text-gray hover:text-primary font-medium transition-colors" data-target="cara-kerja">Cara Kerja</a>
                </nav>

                <!-- Desktop CTA Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ url('/login') }}" class="text-primary bg-white border border-primary hover:bg-primary/5 px-4 py-2 rounded-md font-medium transition-colors">
                        Masuk
                    </a>
                    <a href="{{ url('/register') }}" class="bg-primary text-white hover:bg-blue-900 px-4 py-2 rounded-md font-medium transition-colors shadow-sm">
                        Daftar
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-text-gray hover:text-primary focus:outline-none p-2">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Menu Panel (Hidden by default) -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-border-color bg-white">
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="{{ url('/') }}" class="mobile-nav-link block px-3 py-2 rounded-md text-base {{ Request::is('/') ? 'font-bold text-primary bg-primary/5 active' : 'font-medium text-text-gray' }} hover:text-primary hover:bg-surface" data-target="home">Beranda</a>
                <a href="{{ url('/lowongan') }}" class="mobile-nav-link block px-3 py-2 rounded-md text-base {{ Request::is('lowongan*') ? 'font-bold text-primary bg-primary/5 active' : 'font-medium text-text-gray' }} hover:text-primary hover:bg-surface" data-target="lowongan">Lowongan</a>
                <a href="{{ url('/#cara-kerja') }}" class="mobile-nav-link block px-3 py-2 rounded-md text-base font-medium text-text-gray hover:text-primary hover:bg-surface" data-target="cara-kerja">Cara Kerja</a>
                
                <div class="pt-4 flex flex-col gap-2">
                    <a href="{{ url('/login') }}" class="w-full text-center text-primary bg-white border border-primary hover:bg-primary/5 px-4 py-2 rounded-md font-medium transition-colors">
                        Masuk
                    </a>
                    <a href="{{ url('/register') }}" class="w-full text-center bg-primary text-white hover:bg-blue-900 px-4 py-2 rounded-md font-medium transition-colors shadow-sm">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-border-color mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <a href="{{ url('/') }}" class="text-2xl font-bold text-primary flex items-center gap-2 mb-4">
                        <i class="fa-solid fa-briefcase text-secondary"></i>
                        Partimeku
                    </a>
                    <p class="text-text-gray text-sm mb-4 max-w-md">
                        Platform pencarian kerja part time yang menghubungkan mahasiswa dengan UMKM dan penyedia lowongan lokal secara mudah, aman, dan terpercaya.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-text-gray hover:text-primary"><i class="fa-brands fa-instagram text-xl"></i></a>
                        <a href="#" class="text-text-gray hover:text-primary"><i class="fa-brands fa-linkedin text-xl"></i></a>
                        <a href="#" class="text-text-gray hover:text-primary"><i class="fa-brands fa-twitter text-xl"></i></a>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-bold text-text-dark mb-4">Navigasi</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ url('/') }}" class="text-text-gray hover:text-primary transition-colors">Beranda</a></li>
                        <li><a href="{{ url('/lowongan') }}" class="text-text-gray hover:text-primary transition-colors">Cari Lowongan</a></li>
                        <li><a href="{{ url('/register/penyedia') }}" class="text-text-gray hover:text-primary transition-colors">Pasang Lowongan</a></li>
                        <li><a href="{{ url('/#cara-kerja') }}" class="text-text-gray hover:text-primary transition-colors">Cara Kerja</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold text-text-dark mb-4">Pusat Bantuan</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-text-gray hover:text-primary transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-text-gray hover:text-primary transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-text-gray hover:text-primary transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-text-gray hover:text-primary transition-colors">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-border-color mt-8 pt-8 text-center text-sm text-text-gray">
                &copy; {{ date('Y') }} Partimeku. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

    <!-- Script for Mobile Menu Toggle and Scrollspy -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            const icon = btn.querySelector('i');

            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
                if (menu.classList.contains('hidden')) {
                    icon.classList.remove('fa-xmark');
                    icon.classList.add('fa-bars');
                } else {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-xmark');
                }
            });

            // Scrollspy / Active Link Management
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link, .mobile-nav-link');
            
            function setActiveLink(targetId) {
                navLinks.forEach(link => {
                    const isMobile = link.classList.contains('mobile-nav-link');
                    const linkTarget = link.getAttribute('data-target');
                    
                    if (isMobile) {
                        link.classList.remove('font-bold', 'text-primary', 'bg-primary/5', 'active');
                        link.classList.add('font-medium', 'text-text-gray');
                    } else {
                        link.classList.remove('font-bold', 'text-primary', 'active');
                        link.classList.add('font-medium', 'text-text-gray');
                    }
                    
                    if (linkTarget === targetId) {
                        if (isMobile) {
                            link.classList.remove('font-medium', 'text-text-gray');
                            link.classList.add('font-bold', 'text-primary', 'bg-primary/5', 'active');
                        } else {
                            link.classList.remove('font-medium', 'text-text-gray');
                            link.classList.add('font-bold', 'text-primary', 'active');
                        }
                    }
                });
            }

            if (currentPath === '/' || currentPath === '') {
                window.addEventListener('scroll', () => {
                    let current = 'home';
                    const scrollY = window.scrollY;
                    const caraKerja = document.getElementById('cara-kerja');
                    
                    if (caraKerja && scrollY >= caraKerja.offsetTop - 150) {
                        current = 'cara-kerja';
                    }
                    
                    setActiveLink(current);
                });

                if (window.location.hash === '#cara-kerja') {
                    setActiveLink('cara-kerja');
                    setTimeout(() => {
                        const el = document.getElementById('cara-kerja');
                        if (el) {
                            window.scrollTo({
                                top: el.offsetTop - 80,
                                behavior: 'smooth'
                            });
                        }
                    }, 100);
                }
            }
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const target = this.getAttribute('data-target');
                    const href = this.getAttribute('href');
                    
                    if (href.includes('#') && (currentPath === '/' || currentPath === '')) {
                        setActiveLink(target);
                        
                        if (!menu.classList.contains('hidden')) {
                            menu.classList.add('hidden');
                            icon.classList.remove('fa-xmark');
                            icon.classList.add('fa-bars');
                        }
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
