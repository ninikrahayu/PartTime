<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Partimeku - Ruang Mahasiswa')</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface text-text-dark font-sans antialiased">

    @php
        $menus = [
            ['url' => 'mahasiswa/dashboard', 'icon' => 'fa-solid fa-house', 'title' => 'Beranda'],
            ['url' => 'mahasiswa/jobs', 'icon' => 'fa-solid fa-magnifying-glass', 'title' => 'Lowongan'],
            ['url' => 'mahasiswa/favorites', 'icon' => 'fa-solid fa-heart', 'title' => 'Favorit'],
            ['url' => 'mahasiswa/applications', 'icon' => 'fa-solid fa-file-lines', 'title' => 'Lamaran'],
            ['url' => 'mahasiswa/reviews', 'icon' => 'fa-solid fa-star', 'title' => 'Review'],
            ['url' => 'mahasiswa/profile', 'icon' => 'fa-solid fa-user', 'title' => 'Profil'],
        ];
    @endphp

    <!-- App Container -->
    <div class="min-h-screen flex flex-col md:flex-row pb-16 md:pb-0">
        
        <!-- ================= MOBILE VIEW ================= -->
        <!-- Mobile Topbar -->
        <header class="md:hidden bg-white border-b border-border-color h-14 flex items-center justify-between px-4 sticky top-0 z-30 shadow-sm">
            <h1 class="text-lg font-bold text-primary truncate">@yield('page_title', 'Partimeku')</h1>
            <button class="text-text-gray hover:text-primary relative p-1">
                <i class="fa-regular fa-bell text-xl"></i>
                <span class="absolute top-0 right-0 flex h-3 w-3 items-center justify-center rounded-full bg-danger text-[8px] text-white">1</span>
            </button>
        </header>

        <!-- Mobile Bottom Navigation -->
        <nav class="md:hidden fixed bottom-0 inset-x-0 bg-white border-t border-border-color flex justify-between items-center h-16 z-40 px-1 shadow-[0_-2px_10px_rgba(0,0,0,0.05)]">
            @foreach($menus as $menu)
                <a href="{{ url('/'.$menu['url']) }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 transition-colors {{ request()->is($menu['url'].'*') ? 'text-primary' : 'text-text-gray hover:text-text-dark' }}">
                    <i class="{{ $menu['icon'] }} text-lg {{ request()->is($menu['url'].'*') ? 'text-primary mb-0.5' : '' }}"></i>
                    <span class="text-[10px] font-medium leading-none {{ request()->is($menu['url'].'*') ? 'font-bold' : '' }}">{{ $menu['title'] }}</span>
                </a>
            @endforeach
        </nav>


        <!-- ================= DESKTOP VIEW ================= -->
        <!-- Desktop Sidebar -->
        <aside class="hidden md:flex flex-col w-64 bg-white border-r border-border-color fixed inset-y-0 left-0 z-50">
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center px-6 border-b border-border-color">
                <a href="{{ url('/mahasiswa/dashboard') }}" class="text-xl font-bold text-primary flex items-center gap-2">
                    <i class="fa-solid fa-briefcase text-secondary"></i>
                    Partimeku
                </a>
            </div>

            <!-- Sidebar Navigation -->
            <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <div class="text-xs font-semibold text-text-gray uppercase tracking-wider mb-2 px-3">Menu Mahasiswa</div>
                @foreach($menus as $menu)
                    <a href="{{ url('/'.$menu['url']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition-colors {{ request()->is($menu['url'].'*') ? 'bg-primary/10 text-primary' : 'text-text-gray hover:bg-surface hover:text-text-dark' }}">
                        <i class="{{ $menu['icon'] }} w-5 text-center {{ request()->is($menu['url'].'*') ? 'text-primary' : '' }}"></i>
                        {{ $menu['title'] }}
                    </a>
                @endforeach
            </div>

            <!-- Sidebar Footer (Profile & Logout) -->
            <div class="p-4 border-t border-border-color">
                <div class="flex items-center gap-3 mb-4 px-2">
                    <img src="https://ui-avatars.com/api/?name=Mahasiswa&background=1E3A8A&color=fff" alt="User" class="w-10 h-10 rounded-full object-cover">
                    <div class="text-sm overflow-hidden">
                        <p class="font-semibold text-text-dark truncate">Raka Pratama</p>
                        <p class="text-text-gray text-xs truncate">Mahasiswa</p>
                    </div>
                </div>
                <a href="{{ url('/login') }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-danger hover:bg-danger/10 transition-colors">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                    Logout
                </a>
            </div>
        </aside>

        <!-- Desktop Main Wrapper -->
        <div class="hidden md:flex flex-1 flex-col min-w-0 md:ml-64">
            
            <!-- Desktop Topbar -->
            <header class="h-16 bg-white border-b border-border-color flex items-center justify-between px-6 sticky top-0 z-30">
                <h1 class="text-lg font-semibold text-text-dark truncate">@yield('page_title', 'Dashboard')</h1>
                <div class="flex items-center gap-4">
                </div>
            </header>

            <!-- Desktop Content -->
            <main class="flex-1 p-6 lg:p-8 overflow-y-auto">
                @yield('content')
            </main>
        </div>

        <!-- Mobile Content -->
        <main class="md:hidden flex-1 p-4 overflow-y-auto">
            @yield('content')
        </main>

    </div>

    <x-toast />

    <script>
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
