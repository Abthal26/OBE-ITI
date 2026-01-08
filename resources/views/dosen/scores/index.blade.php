@extends('layouts.app')

@section('title', 'Input Nilai')
@section('subtitle', $course->code . ' - ' . $course->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('dosen.dashboard') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <p class="text-sm text-gray-500">Sheet: AsesmenNilai</p>
            </div>
        </div>
        <a href="{{ route('dosen.courses.scores.enroll', $course) }}" class="btn-secondary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Tambah Mahasiswa
        </a>
    </div>
    
    @if($students->count() > 0 && $assessments->count() > 0)
        <!-- Score Matrix Form -->
        <form action="{{ route('dosen.courses.scores.update', $course) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="table-header sticky left-0 bg-gray-50 z-10">NIM</th>
                                <th class="table-header sticky left-20 bg-gray-50 z-10">Nama</th>
                                @foreach($assessments as $assessment)
                                    <th class="table-header text-center min-w-[100px]">
                                        <div class="flex flex-col">
                                            <span>{{ $assessment->code }}</span>
                                            <span class="text-xs font-normal text-gray-400">(max: {{ $assessment->max_score }})</span>
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($students as $student)
                                <tr class="hover:bg-gray-50">
                                    <td class="table-cell sticky left-0 bg-white font-mono text-sm">{{ $student->nim }}</td>
                                    <td class="table-cell sticky left-20 bg-white">{{ $student->name }}</td>
                                    @foreach($assessments as $assessment)
                                        <td class="table-cell p-1">
                                            <input 
                                                type="number" 
                                                name="scores[{{ $student->id }}][{{ $assessment->id }}]"
                                                value="{{ $scoreMatrix[$student->id]['scores'][$assessment->id] ?? '' }}"
                                                min="0"
                                                max="{{ $assessment->max_score }}"
                                                step="0.01"
                                                class="w-full px-2 py-1.5 border border-gray-200 rounded-lg text-center focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm"
                                                placeholder="-"
                                            >
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="flex items-center gap-4 mt-6">
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Nilai
                </button>
                <a href="{{ route('dosen.courses.report', $course) }}" class="btn-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Lihat Laporan
                </a>
            </div>
        </form>
    @else
        <div class="card p-12 text-center">
            @if($assessments->count() == 0)
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h4 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Asesmen</h4>
                <p class="text-gray-500 mb-4">Tambahkan asesmen terlebih dahulu sebelum input nilai.</p>
                <a href="{{ route('dosen.courses.assessments.create', $course) }}" class="btn-primary">
                    Tambah Asesmen
                </a>
            @else
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <h4 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Mahasiswa</h4>
                <p class="text-gray-500 mb-4">Daftarkan mahasiswa ke mata kuliah ini.</p>
                <a href="{{ route('dosen.courses.scores.enroll', $course) }}" class="btn-primary">
                    Tambah Mahasiswa
                </a>
            @endif
        </div>
    @endif
</div>
@endsection

