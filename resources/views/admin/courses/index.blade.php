@extends('layouts.app')

@section('title', 'Mata Kuliah')
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
                <select name="academic_year" class="form-input py-2" onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year }}" {{ $academicYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </form>
            <span class="text-gray-500">{{ $courses->count() }} mata kuliah</span>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Mata Kuliah
        </a>
    </div>
    
    <!-- Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="table-header">Kode</th>
                        <th class="table-header">Nama</th>
                        <th class="table-header">Dosen Pengampu</th>
                        <th class="table-header text-center">SKS</th>
                        <th class="table-header text-center">Semester</th>
                        <th class="table-header">Periode</th>
                        <th class="table-header text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($courses as $course)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="table-cell">
                                <span class="px-2.5 py-1 rounded-lg bg-indigo-50 font-mono font-semibold text-indigo-700">{{ $course->code }}</span>
                            </td>
                            <td class="table-cell font-medium text-gray-900">{{ $course->name }}</td>
                            <td class="table-cell">{{ $course->dosen?->name ?? '-' }}</td>
                            <td class="table-cell text-center">
                                <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-700 font-medium">{{ $course->sks }}</span>
                            </td>
                            <td class="table-cell text-center">{{ $course->semester }}</td>
                            <td class="table-cell text-sm text-gray-500">
                                {{ $course->academic_year }} - {{ ucfirst($course->academic_period) }}
                            </td>
                            <td class="table-cell text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.courses.show', $course) }}" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.courses.edit', $course) }}" class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus mata kuliah ini?')">
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
                            <td colspan="7" class="table-cell text-center py-12">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <p class="text-gray-500">Belum ada mata kuliah</p>
                                    <a href="{{ route('admin.courses.create') }}" class="btn-primary">Tambah Mata Kuliah Pertama</a>
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
