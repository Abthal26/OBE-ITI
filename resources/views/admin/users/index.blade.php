@extends('layouts.app')

@section('title', 'Pengguna')
@section('subtitle', 'Kelola data pengguna sistem')

@section('content')
<div class="space-y-6">
    <!-- Filter -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <form method="GET" class="flex items-center gap-2">
            <select name="role" class="form-input py-2" onchange="this.form.submit()">
                <option value="">Semua Role</option>
                <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="kaprodi" {{ $role == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                <option value="dosen" {{ $role == 'dosen' ? 'selected' : '' }}>Dosen</option>
            </select>
            <span class="text-gray-500">{{ $users->count() }} pengguna</span>
        </form>
        <a href="{{ route('admin.users.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Pengguna
        </a>
    </div>
    
    <!-- Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="table-header">Nama</th>
                        <th class="table-header">Email</th>
                        <th class="table-header">Role</th>
                        <th class="table-header text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="table-cell">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="table-cell text-gray-600">{{ $user->email }}</td>
                            <td class="table-cell">
                                @php
                                    $roleColors = [
                                        'admin' => 'bg-red-100 text-red-700',
                                        'kaprodi' => 'bg-blue-100 text-blue-700',
                                        'dosen' => 'bg-emerald-100 text-emerald-700',
                                    ];
                                @endphp
                                <span class="badge {{ $roleColors[$user->role] ?? 'badge-info' }} capitalize">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="table-cell text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="table-cell text-center py-12">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <p class="text-gray-500">Belum ada pengguna</p>
                                    <a href="{{ route('admin.users.create') }}" class="btn-primary">Tambah Pengguna Pertama</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
