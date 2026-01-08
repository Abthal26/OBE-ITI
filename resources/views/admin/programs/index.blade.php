@extends('layouts.app')

@section('title', 'Program Studi')
@section('subtitle', 'Kelola data program studi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-gray-600">Total {{ $programs->count() }} program studi terdaftar</p>
        </div>
        <a href="{{ route('admin.programs.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Program
        </a>
    </div>
    
    <!-- Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="table-header">Kode</th>
                        <th class="table-header">Nama Program</th>
                        <th class="table-header text-center">CPL</th>
                        <th class="table-header text-center">Mata Kuliah</th>
                        <th class="table-header text-center">Mahasiswa</th>
                        <th class="table-header text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($programs as $program)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="table-cell">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-primary-50 text-primary-700 font-mono font-medium">
                                    {{ $program->code }}
                                </span>
                            </td>
                            <td class="table-cell">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $program->name }}</p>
                                    @if($program->description)
                                        <p class="text-sm text-gray-500 truncate max-w-xs">{{ $program->description }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="table-cell text-center">
                                <span class="badge badge-info">{{ $program->cpls_count }} CPL</span>
                            </td>
                            <td class="table-cell text-center">
                                <span class="badge badge-success">{{ $program->courses_count }} MK</span>
                            </td>
                            <td class="table-cell text-center">
                                <span class="badge badge-warning">{{ $program->students_count }} Mhs</span>
                            </td>
                            <td class="table-cell text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.programs.show', $program) }}" class="p-2 text-gray-500 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" title="Lihat">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.programs.edit', $program) }}" class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus program ini?')">
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
                            <td colspan="6" class="table-cell text-center py-12">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <p class="text-gray-500 mb-4">Belum ada program studi</p>
                                    <a href="{{ route('admin.programs.create') }}" class="btn-primary">
                                        Tambah Program Pertama
                                    </a>
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

