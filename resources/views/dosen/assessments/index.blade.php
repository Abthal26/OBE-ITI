@extends('layouts.app')

@section('title', 'Kelola Asesmen')
@section('subtitle', $course->code . ' - ' . $course->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('dosen.dashboard') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <p class="text-sm text-gray-500">Sheet: Pemetaan Asesmen & CPMK Bobot</p>
        </div>
        <a href="{{ route('dosen.courses.assessments.create', $course) }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Asesmen
        </a>
    </div>
    
    @if($assessments->count() > 0)
        <div class="card">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="table-header">Kode</th>
                            <th class="table-header">Nama</th>
                            <th class="table-header">Tipe</th>
                            <th class="table-header text-center">Max</th>
                            <th class="table-header">Pemetaan CPMK</th>
                            <th class="table-header text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($assessments as $assessment)
                            <tr class="hover:bg-gray-50">
                                <td class="table-cell">
                                    <span class="font-mono font-medium text-emerald-600">{{ $assessment->code }}</span>
                                </td>
                                <td class="table-cell">{{ $assessment->name }}</td>
                                <td class="table-cell">
                                    <span class="badge badge-info capitalize">{{ $assessment->type }}</span>
                                </td>
                                <td class="table-cell text-center">{{ $assessment->max_score }}</td>
                                <td class="table-cell">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($assessment->cpmks as $cpmk)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-primary-50 text-primary-700 text-xs">
                                                {{ $cpmk->code }}
                                                <span class="text-primary-400">({{ $cpmk->pivot->weight }}%)</span>
                                            </span>
                                        @empty
                                            <span class="text-sm text-gray-400">-</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="table-cell text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('dosen.courses.assessments.edit', [$course, $assessment]) }}" class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('dosen.courses.assessments.destroy', [$course, $assessment]) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus asesmen ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h4 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Asesmen</h4>
            <p class="text-gray-500 mb-4">Tambahkan komponen penilaian (Quiz, UTS, UAS, dll).</p>
            <a href="{{ route('dosen.courses.assessments.create', $course) }}" class="btn-primary">Tambah Asesmen Pertama</a>
        </div>
    @endif
</div>
@endsection

