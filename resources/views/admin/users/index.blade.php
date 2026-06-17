@extends('layouts.admin')
@section('title', 'Manajemen Pengguna - Admin Partimeku')
@section('page_title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-md bg-green-50 p-4 border border-green-200">
            <p class="text-sm font-medium text-green-800"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</p>
        </div>
    @endif
    <!-- Action Bar -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row justify-between gap-4">
        <div class="flex flex-col sm:flex-row gap-4 flex-1 items-center">
            <x-search-input name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full sm:w-64" />
            
            <x-select name="role" class="w-full sm:w-48" onchange="this.form.submit()">
                <option value="">Semua Role</option>
                <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                <option value="penyedia" {{ request('role') == 'penyedia' ? 'selected' : '' }}>Penyedia</option>
            </x-select>
            
            <x-select name="status" class="w-full sm:w-48" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </x-select>

            @if(request()->hasAny(['search', 'role', 'status']) && (request('search') != '' || request('role') != '' || request('status') != ''))
                <a href="{{ route('admin.users.index') }}" class="text-sm text-danger hover:underline whitespace-nowrap">
                    <i class="fa-solid fa-xmark mr-1"></i> Reset Filter
                </a>
            @endif
        </div>
        <div class="flex gap-2">
            <button type="submit" class="hidden">Search</button>
            <a href="{{ route('admin.users.export.xls') }}" class="inline-flex items-center rounded-md bg-success border border-transparent px-4 py-2 text-sm font-medium text-white shadow-md hover:bg-green-700 focus:ring-2 focus:ring-success/50 transition-all">
                <i class="fa-solid fa-file-excel mr-2"></i> Export XLS
            </a>
            <a href="{{ route('admin.users.export.pdf') }}" class="inline-flex items-center rounded-md bg-danger border border-transparent px-4 py-2 text-sm font-medium text-white shadow-md hover:bg-red-700 focus:ring-2 focus:ring-danger/50 transition-all">
                <i class="fa-solid fa-file-pdf mr-2"></i> Export PDF
            </a>
            <a href="{{ url('/admin/users/create') }}" class="inline-flex items-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:brightness-90 transition-all">
                <i class="fa-solid fa-plus mr-2"></i> Tambah
            </a>
        </div>
    </form>
    
    <div class="text-sm text-text-gray">
        Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data
    </div>

    <!-- Table -->
    <x-card class="p-0 border-none shadow-sm overflow-hidden">
        <x-table>
            <x-slot name="thead">
                <tr>
                    <th scope="col" class="px-6 py-3">Pengguna</th>
                    <th scope="col" class="px-6 py-3">Role</th>
                    <th scope="col" class="px-6 py-3">Tgl Daftar</th>
                    <th scope="col" class="px-6 py-3">Akun</th>
                    <th scope="col" class="px-6 py-3">Verifikasi</th>
                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </x-slot>
            @foreach($users as $user)
            <tr class="bg-white border-b border-border-color hover:bg-surface">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user['name']) }}&background=random&color=fff" alt="" class="w-8 h-8 rounded-full">
                        <div>
                            <div class="font-medium text-text-dark">{{ $user['name'] }}</div>
                            <div class="text-xs text-text-gray">{{ $user['email'] }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="capitalize text-sm">{{ $user['role'] }}</span>
                </td>
                <td class="px-6 py-4 text-sm text-text-gray">
                    {{ \Carbon\Carbon::parse($user['created_at'])->format('d M Y') }}
                </td>
                <td class="px-6 py-4">
                    <x-status-badge :status="$user['account_status']" />
                </td>
                <td class="px-6 py-4">
                    <x-status-badge :status="$user['verification_status']" />
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ url('/admin/users/'.$user['id']) }}" class="text-text-gray hover:text-primary transition-colors" title="Detail">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ url('/admin/users/'.$user['id'].'/edit') }}" class="text-text-gray hover:text-warning transition-colors" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.users.toggle-active', $user['id']) }}" class="inline">
                            @csrf @method('PUT')
                            @if($user['account_status'] === 'aktif')
                                <button type="submit" onclick="return confirm('Nonaktifkan pengguna ini?')" class="text-text-gray hover:text-warning transition-colors" title="Nonaktifkan">
                                    <i class="fa-solid fa-ban"></i>
                                </button>
                            @else
                                <button type="submit" onclick="return confirm('Aktifkan pengguna ini?')" class="text-text-gray hover:text-success transition-colors" title="Aktifkan">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            @endif
                        </form>
                        <form method="POST" action="{{ route('admin.users.destroy', $user['id']) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus pengguna ini permanen?')" class="text-text-gray hover:text-danger transition-colors" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </x-table>
        <div class="p-4 border-t border-border-color">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </x-card>
</div>

</div>
@endsection
