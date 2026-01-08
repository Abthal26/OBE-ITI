@extends('layouts.app')

@section('title', 'Capaian CPL per Mahasiswa')
@section('subtitle', 'Detail capaian setiap mahasiswa')

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
                <label class="form-label">Angkatan</label>
                <select name="angkatan" class="form-input" onchange="this.form.submit()">
                    <option value="">Semua Angkatan</option>
                    @foreach($angkatans as $ank)
                        <option value="{{ $ank }}" {{ $angkatan == $ank ? 'selected' : '' }}>{{ $ank }}</option>
                    @endforeach
                </select>
            </div>
            <a href="{{ route('kaprodi.reports.cpl', request()->query()) }}" class="btn-secondary">
                ← Kembali
            </a>
        </form>
    </div>
    
    <!-- Students Table -->
    <div class="card">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="table-header sticky left-0 bg-gray-50 z-10">NIM</th>
                        <th class="table-header sticky left-20 bg-gray-50 z-10">Nama</th>
                        @foreach($cpls as $cpl)
                            <th class="table-header text-center min-w-[80px]">{{ $cpl->code }}</th>
                        @endforeach
                        <th class="table-header text-center">Rata-rata</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($students as $student)
                        @php
                            $cplScores = $student->cplAchievements->keyBy('cpl_id');
                            $totalScore = 0;
                            $scoreCount = 0;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="table-cell sticky left-0 bg-white font-mono text-sm">{{ $student->nim }}</td>
                            <td class="table-cell sticky left-20 bg-white">{{ $student->name }}</td>
                            @foreach($cpls as $cpl)
                                @php
                                    $achievement = $cplScores->get($cpl->id);
                                    $score = $achievement?->score;
                                    if ($score !== null) {
                                        $totalScore += $score;
                                        $scoreCount++;
                                    }
                                @endphp
                                <td class="table-cell text-center">
                                    @if($score !== null)
                                        <span class="inline-block px-2 py-1 rounded-lg text-sm font-medium
                                            {{ $score >= 70 ? 'bg-emerald-100 text-emerald-700' : ($score >= 55 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                            {{ number_format($score, 1) }}
                                        </span>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="table-cell text-center">
                                @if($scoreCount > 0)
                                    @php $avg = $totalScore / $scoreCount; @endphp
                                    <span class="inline-block px-3 py-1 rounded-lg text-sm font-bold
                                        {{ $avg >= 70 ? 'bg-emerald-100 text-emerald-700' : ($avg >= 55 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                        {{ number_format($avg, 1) }}
                                    </span>
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $students->withQueryString()->links() }}
    </div>
</div>
@endsection

