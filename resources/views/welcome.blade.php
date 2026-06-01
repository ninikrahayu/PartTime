<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Task 3 - Partimeku</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="p-8">
    
    <div class="max-w-4xl mx-auto space-y-8">
        <div>
            <h1 class="text-3xl mb-2"><i class="fa-solid fa-check-circle text-success mr-2"></i>Task 3 Selesai</h1>
            <p class="text-text-gray">Data dummy dari JSON berhasil dibaca dan ditampilkan.</p>
        </div>

        @if(isset($meta))
        <div class="bg-surface p-6 border border-border-color rounded-md">
            <h3 class="text-xl mb-2 text-primary font-bold">Project Meta</h3>
            <p><strong>Nama Project:</strong> {{ $meta['project_name'] }}</p>
            <p><strong>Versi:</strong> {{ $meta['version'] }}</p>
        </div>
        @endif

        <div class="bg-surface p-6 border border-border-color rounded-md">
            <h3 class="text-xl mb-4 text-primary font-bold">Daftar Lowongan (Data JSON)</h3>
            
            <div class="space-y-4">
                @if(isset($jobs) && $jobs->count() > 0)
                    @foreach($jobs as $job)
                        <div class="bg-white border border-border-color rounded-md p-4 flex justify-between items-center shadow-sm">
                            <div>
                                <h4 class="font-bold text-lg">{{ $job['title'] }}</h4>
                                <p class="text-text-gray text-sm">{{ $job['provider_name'] }} &bull; <i class="fa-solid fa-location-dot"></i> {{ $job['location'] }}</p>
                            </div>
                            <div>
                                <span class="bg-blue-100 text-info px-3 py-1 rounded-full text-sm font-medium">{{ $job['category'] }}</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-text-gray">Data kosong atau tidak ditemukan.</p>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
