@extends('layouts.app')

@section('title', 'Laporan Mata Kuliah')
@section('subtitle', 'Capaian CPMK per mata kuliah')

@section('content')
<div class="space-y-6">
    <!-- Filter -->
    <div class="card p-4">
        <form method="GET" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[150px]">
                <label class="form-label">Tahun Akademik</label>
                <select name="academic_year" class="form-input" onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year }}" {{ $academicYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[150px]">
                <label class="form-label">Semester</label>
                <select name="academic_period" class="form-input" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="ganjil" {{ $academicPeriod == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="genap" {{ $academicPeriod == 'genap' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>
        </form>
    </div>
    
    <!-- Courses List -->
    @foreach($courses as $course)
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-lg bg-primary-50 text-primary-700 font-mono font-medium">
                            {{ $course->code }}
                        </span>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $course->name }}</h4>
                            <p class="text-sm text-gray-500">
                                {{ $course->dosen?->name ?? 'Belum ada dosen' }} • 
                                {{ $course->students_count }} mahasiswa •
                                {{ $course->academic_year }} {{ ucfirst($course->academic_period) }}
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('kaprodi.reports.courses.detail', $course) }}" class="btn-secondary text-sm">
                        Detail →
                    </a>
                </div>
            </div>
            
            @if(isset($courseReports[$course->id]) && $courseReports[$course->id]['cpmk_averages']->count() > 0)
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach($courseReports[$course->id]['cpmk_averages'] as $avg)
                            <div class="text-center p-3 bg-gray-50 rounded-xl">
                                <span class="font-mono text-sm font-medium text-primary-600">{{ $avg->code }}</span>
                                <div class="mt-1">
                                    <span class="text-xl font-bold {{ $avg->average_score >= 70 ? 'text-emerald-600' : ($avg->average_score >= 55 ? 'text-amber-600' : 'text-red-600') }}">
                                        {{ number_format($avg->average_score, 1) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="p-6 text-center text-gray-500">
                    Belum ada data CPMK
                </div>
            @endif
        </div>
    @endforeach
    
    @if($courses->count() == 0)
        <div class="card p-12 text-center">
            <p class="text-gray-500">Tidak ada mata kuliah untuk filter yang dipilih</p>
        </div>
    @endif
</div>
@endsection

