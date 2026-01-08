@extends('layouts.app')

@section('title', 'Capaian Pembelajaran Lulusan')
@section('subtitle', 'Program Studi ' . $program->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <span class="px-3 py-1.5 rounded-lg bg-indigo-100 text-indigo-700 font-semibold">
                {{ $program->code }}
            </span>
            <span class="text-gray-500">{{ $cpls->count() }} CPL terdaftar</span>
        </div>
        <a href="{{ route('admin.cpls.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah CPL
        </a>
    </div>
    
    <!-- Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="table-header w-32">Kode</th>
                        <th class="table-header">Deskripsi</th>
                        <th class="table-header text-right w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($cpls as $cpl)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="table-cell">
                                <span class="px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-700 font-mono font-semibold">
                                    {{ $cpl->code }}
                                </span>
                            </td>
                            <td class="table-cell">
                                <p class="text-gray-700">{{ $cpl->description }}</p>
                            </td>
                            <td class="table-cell text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.cpls.edit', $cpl) }}" class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.cpls.destroy', $cpl) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus CPL ini?')">
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
                            <td colspan="3" class="table-cell text-center py-12">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    <p class="text-gray-500">Belum ada CPL terdaftar</p>
                                    <a href="{{ route('admin.cpls.create') }}" class="btn-primary">Tambah CPL Pertama</a>
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
