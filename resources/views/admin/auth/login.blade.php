<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Partimeku</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-surface font-sans text-text-dark antialiased">
    <main class="flex min-h-screen items-center justify-center px-4 py-10 sm:px-6">
        <section class="w-full max-w-md rounded-md border border-border-color bg-white p-5 shadow-sm sm:p-6">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-md bg-primary/10 text-primary">
                    <i class="fa-solid fa-briefcase text-lg"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-text-gray">Partimeku</p>
                    <h1 class="text-xl font-semibold text-text-dark">Login Admin</h1>
                </div>
            </div>

            <form id="admin-login-form" class="mt-6 space-y-4">
                <label class="block text-sm font-medium text-text-dark">
                    Email / username
                    <x-input name="login" type="text" class="mt-2" placeholder="admin@parttime.test" required />
                </label>
                <label class="block text-sm font-medium text-text-dark">
                    Password
                    <x-input name="password" type="password" class="mt-2" placeholder="Password admin" required />
                </label>

                <div class="rounded-md border border-info/20 bg-info/5 p-3 text-sm text-info">
                    Gunakan kredensial dummy untuk simulasi frontend.
                </div>

                <button type="submit" class="inline-flex w-full items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>
                    Masuk Admin
                </button>
            </form>
        </section>
    </main>

    <x-toast />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('admin-login-form');

            window.showToast = function(message, type = 'success') {
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
                setTimeout(removeToast, 2500);
            };

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                window.showToast('Berhasil masuk ke dashboard admin.', 'success');
                setTimeout(() => {
                    window.location.href = '{{ url('/admin/dashboard') }}';
                }, 700);
            });
        });
    </script>
</body>
</html>
