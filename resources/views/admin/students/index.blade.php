@extends('layouts.app')

@section('title', 'Mahasiswa')
@section('subtitle', 'Program Studi ' . $program->name)

@section('content')
<div class="space-y-6">
    <!-- Filter -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <span class="px-3 py-1.5 rounded-lg bg-indigo-100 text-indigo-700 font-semibold">
                {{ $program->code }}
            </span>
            <form method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ $search }}" class="form-input py-2" placeholder="Cari NIM/Nama..." onchange="this.form.submit()">
                <select name="angkatan" class="form-input py-2" onchange="this.form.submit()">
                    <option value="">Semua Angkatan</option>
                    @foreach($angkatans as $ank)
                        <option value="{{ $ank }}" {{ $angkatan == $ank ? 'selected' : '' }}>{{ $ank }}</option>
                    @endforeach
                </select>
                <select name="status" class="form-input py-2" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ $status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ $status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="cuti" {{ $status == 'cuti' ? 'selected' : '' }}>Cuti</option>
                    <option value="lulus" {{ $status == 'lulus' ? 'selected' : '' }}>Lulus</option>
                </select>
            </form>
        </div>
        <a href="{{ route('admin.students.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Mahasiswa
        </a>
    </div>
    
    <!-- Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="table-header">NIM</th>
                        <th class="table-header">Nama</th>
                        <th class="table-header text-center">Angkatan</th>
                        <th class="table-header">Status</th>
                        <th class="table-header text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($students as $student)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="table-cell">
                                <span class="font-mono font-semibold text-indigo-600">{{ $student->nim }}</span>
                            </td>
                            <td class="table-cell font-medium text-gray-900">{{ $student->name }}</td>
                            <td class="table-cell text-center">
                                <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-700 font-medium">{{ $student->angkatan ?? '-' }}</span>
                            </td>
                            <td class="table-cell">
                                @php
                                    $statusColors = [
                                        'aktif' => 'bg-emerald-100 text-emerald-700',
                                        'tidak_aktif' => 'bg-gray-100 text-gray-700',
                                        'lulus' => 'bg-blue-100 text-blue-700',
                                        'cuti' => 'bg-amber-100 text-amber-700',
                                    ];
                                @endphp
                                <span class="badge {{ $statusColors[$student->status] ?? 'badge-info' }} capitalize">
                                    {{ str_replace('_', ' ', $student->status) }}
                                </span>
                            </td>
                            <td class="table-cell text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.students.show', $student) }}" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.students.edit', $student) }}" class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus mahasiswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="table-cell text-center py-12">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <p class="text-gray-500">Belum ada mahasiswa</p>
                                    <a href="{{ route('admin.students.create') }}" class="btn-primary">Tambah Mahasiswa Pertama</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pagination -->
    @if($students->hasPages())
    <div class="flex justify-center">
        {{ $students->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
