@extends('layouts.app')

@section('title', 'Laporan CPL')
@section('subtitle', 'Capaian Pembelajaran Lulusan')

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
            <div class="flex gap-2">
                <a href="{{ route('kaprodi.reports.cpl.students', request()->query()) }}" class="btn-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Per Mahasiswa
                </a>
            </div>
        </form>
    </div>
    
    <!-- CPL Summary -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Ringkasan Capaian CPL</h3>
            <p class="text-sm text-gray-500">Rata-rata capaian seluruh mahasiswa</p>
        </div>
        <div class="p-6">
            @if($cplAverages->count() > 0)
                <div class="space-y-6">
                    @foreach($cplAverages as $avg)
                        <div class="flex items-center gap-6">
                            <div class="w-20 flex-shrink-0">
                                <span class="font-mono font-bold text-primary-600 text-lg">{{ $avg->code }}</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-600">{{ $avg->student_count }} mahasiswa</span>
                                    <span class="font-bold {{ $avg->average_score >= 70 ? 'text-emerald-600' : ($avg->average_score >= 55 ? 'text-amber-600' : 'text-red-600') }}">
                                        {{ number_format($avg->average_score, 2) }}%
                                    </span>
                                </div>
                                <div class="w-full h-4 bg-gray-100 rounded-full overflow-hidden">
                                    <div 
                                        class="h-full rounded-full transition-all {{ $avg->average_score >= 70 ? 'bg-emerald-500' : ($avg->average_score >= 55 ? 'bg-amber-500' : 'bg-red-500') }}"
                                        style="width: {{ min($avg->average_score, 100) }}%"
                                    ></div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-400 mt-1">
                                    <span>Min: {{ number_format($avg->min_score, 1) }}</span>
                                    <span>Max: {{ number_format($avg->max_score, 1) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-8">Belum ada data capaian CPL</p>
            @endif
        </div>
    </div>
    
    <!-- CPL Details -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Detail CPL Program Studi</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($cpls as $cpl)
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <span class="px-3 py-1 rounded-lg bg-primary-50 text-primary-700 font-mono font-bold">
                            {{ $cpl->code }}
                        </span>
                        <div class="flex-1">
                            <p class="text-gray-700 mb-3">{{ $cpl->description }}</p>
                            
                            @if($cpl->cpmks->count() > 0)
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-2">CPMK yang berkontribusi:</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($cpl->cpmks as $cpmk)
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm">
                                                {{ $cpmk->code }}
                                                <span class="text-gray-400">({{ $cpmk->pivot->weight }}%)</span>
                                                <span class="text-gray-400">- {{ $cpmk->course->code }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

