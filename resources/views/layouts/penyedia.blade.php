<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Penyedia Dashboard - Partimeku')</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface text-text-dark font-sans antialiased">

    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Sidebar Overlay for Mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="bg-white border-r border-border-color w-64 flex-shrink-0 flex flex-col fixed inset-y-0 left-0 transform -translate-x-full md:sticky md:top-0 md:h-screen md:translate-x-0 z-50 transition-transform duration-300 ease-in-out">
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center px-6 border-b border-border-color">
                <a href="{{ url('/penyedia/dashboard') }}" class="text-xl font-bold text-primary flex items-center gap-2">
                    <i class="fa-solid fa-briefcase text-secondary"></i>
                    Penyedia Panel
                </a>
            </div>

            <!-- Sidebar Navigation -->
            <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                @php
                    $menus = [
                        ['url' => 'penyedia/dashboard', 'icon' => 'fa-solid fa-gauge', 'title' => 'Dashboard'],
                        [
                            'title' => 'Lowongan', 
                            'icon' => 'fa-solid fa-briefcase',
                            'is_active' => request()->is('penyedia/jobs*'),
                            'submenu' => [
                                ['url' => 'penyedia/jobs', 'title' => 'Daftar Lowongan', 'exact' => true],
                                ['url' => 'penyedia/jobs/create', 'title' => 'Tambah Lowongan', 'exact' => false],
                            ]
                        ],
                        ['url' => 'penyedia/applications', 'icon' => 'fa-solid fa-file-lines', 'title' => 'Lamaran Masuk'],
                        ['url' => 'penyedia/reviews', 'icon' => 'fa-solid fa-star', 'title' => 'Review'],
                        ['url' => 'penyedia/profile', 'icon' => 'fa-solid fa-user-gear', 'title' => 'Profil Akun'],
                    ];
                @endphp

                @foreach($menus as $menu)
                    @if(isset($menu['submenu']))
                        <div class="relative">
                            <button onclick="toggleSubmenu(this)" class="w-full flex items-center justify-between px-3 py-2.5 rounded-md text-sm font-medium transition-colors {{ $menu['is_active'] ? 'bg-primary/10 text-primary' : 'text-text-gray hover:bg-surface hover:text-text-dark' }}">
                                <div class="flex items-center gap-3">
                                    <i class="{{ $menu['icon'] }} w-5 text-center {{ $menu['is_active'] ? 'text-primary' : '' }}"></i>
                                    {{ $menu['title'] }}
                                </div>
                                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200 {{ $menu['is_active'] ? 'rotate-180' : '' }}"></i>
                            </button>
                            <div class="submenu-container mt-1 space-y-1 overflow-hidden transition-all duration-200 {{ $menu['is_active'] ? 'block' : 'hidden' }}">
                                @foreach($menu['submenu'] as $sub)
                                    @php
                                        $subActive = $sub['exact'] ? request()->is($sub['url']) : request()->is($sub['url'].'*');
                                    @endphp
                                    <a href="{{ url('/'.$sub['url']) }}" class="block px-3 py-2 pl-11 rounded-md text-sm transition-colors {{ $subActive ? 'text-primary font-semibold' : 'text-text-gray hover:bg-surface hover:text-text-dark' }}">
                                        {{ $sub['title'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ url('/'.$menu['url']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition-colors {{ request()->is($menu['url'].'*') ? 'bg-primary/10 text-primary' : 'text-text-gray hover:bg-surface hover:text-text-dark' }}">
                            <i class="{{ $menu['icon'] }} w-5 text-center {{ request()->is($menu['url'].'*') ? 'text-primary' : '' }}"></i>
                            {{ $menu['title'] }}
                        </a>
                    @endif
                @endforeach
            </div>

            <!-- Sidebar Footer (Logout) -->
            <div class="p-4 border-t border-border-color">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-danger hover:bg-danger/10 transition-colors">
                        <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-border-color flex items-center justify-between px-4 sm:px-6 z-30 sticky top-0">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="md:hidden text-text-gray hover:text-primary focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-text-dark truncate">@yield('page_title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-4">

                    <!-- User Profile Dropdown -->
                    <div class="flex items-center gap-2 cursor-pointer border-l border-border-color pl-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Penyedia') }}&background=1E3A8A&color=fff" alt="Penyedia" class="w-8 h-8 rounded-full object-cover">
                        <div class="hidden sm:block text-sm">
                            <p class="font-semibold text-text-dark leading-none">{{ Auth::user()->name ?? 'Penyedia Part Time' }}</p>
                            <p class="text-text-gray text-xs mt-1">Akun Penyedia</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
                @yield('content')
            </main>

        </div>
    </div>

    <x-toast />

    <!-- Scripts -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function toggleSubmenu(btn) {
            const container = btn.nextElementSibling;
            const icon = btn.querySelector('.fa-chevron-down');
            
            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                container.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        function openModal(id) {
            const modal = document.getElementById(id);

            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);

            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const template = document.getElementById('toast-template');

            if (!container || !template) {
                return;
            }

            const toast = template.content.firstElementChild.cloneNode(true);
            const icon = toast.querySelector('.toast-icon');
            const text = toast.querySelector('.toast-message');
            const close = toast.querySelector('.toast-close');
            const variants = {
                success: ['bg-success/10', 'text-success', 'fa-circle-check'],
                danger: ['bg-danger/10', 'text-danger', 'fa-circle-xmark'],
                warning: ['bg-warning/10', 'text-warning', 'fa-triangle-exclamation'],
                info: ['bg-info/10', 'text-info', 'fa-circle-info'],
            };
            const variant = variants[type] || variants.success;

            icon.classList.add(variant[0], variant[1]);
            icon.innerHTML = `<i class="fa-solid ${variant[2]}"></i>`;
            text.textContent = message;
            container.appendChild(toast);

            requestAnimationFrame(() => toast.classList.remove('translate-x-full', 'opacity-0'));

            const removeToast = () => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            };

            close.addEventListener('click', removeToast);
            setTimeout(removeToast, 3000);
        }

        function confirmAction(id) {
            closeModal(id);
            showToast('Aksi berhasil diproses.', 'success');
        }
    </script>
    @stack('scripts')
</body>
</html>
