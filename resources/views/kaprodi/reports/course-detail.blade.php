@extends('layouts.app')

@section('title', 'Detail Mata Kuliah')
@section('subtitle', $course->code . ' - ' . $course->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('kaprodi.reports.courses') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <p class="text-sm text-gray-500">
                {{ $course->dosen?->name ?? 'Belum ada dosen' }} • 
                {{ $course->academic_year }} - {{ ucfirst($course->academic_period) }}
            </p>
        </div>
    </div>
    
    <!-- Weight Validation -->
    @foreach($cpmkValidation as $code => $validation)
        @if(!$validation['valid'])
            <div class="p-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span><strong>{{ $code }}:</strong> {{ $validation['message'] }}</span>
            </div>
        @endif
    @endforeach
    
    <!-- CPMK Summary -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Ringkasan Capaian CPMK</h3>
        </div>
        <div class="p-6">
            @if($cpmkAverages->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($cpmkAverages as $avg)
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-mono font-semibold text-primary-600">{{ $avg->code }}</span>
                                <span class="text-2xl font-bold {{ $avg->average_score >= 70 ? 'text-emerald-600' : ($avg->average_score >= 55 ? 'text-amber-600' : 'text-red-600') }}">
                                    {{ number_format($avg->average_score, 1) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mb-2 truncate">{{ $avg->description }}</p>
                            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div 
                                    class="h-full rounded-full {{ $avg->average_score >= 70 ? 'bg-emerald-500' : ($avg->average_score >= 55 ? 'bg-amber-500' : 'bg-red-500') }}"
                                    style="width: {{ min($avg->average_score, 100) }}%"
                                ></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-400 mt-1">
                                <span>{{ $avg->student_count }} mhs</span>
                                <span>{{ number_format($avg->min_score, 0) }}-{{ number_format($avg->max_score, 0) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-4">Belum ada data CPMK</p>
            @endif
        </div>
    </div>
    
    <!-- CPMK Detail per Student -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Capaian CPMK per Mahasiswa</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="table-header">NIM</th>
                        <th class="table-header">Nama</th>
                        @foreach($course->cpmks as $cpmk)
                            <th class="table-header text-center">{{ $cpmk->code }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($report['cpmk_achievements'] as $row)
                        <tr class="hover:bg-gray-50">
                            <td class="table-cell font-mono text-sm">{{ $row['nim'] }}</td>
                            <td class="table-cell">{{ $row['name'] }}</td>
                            @foreach($course->cpmks as $cpmk)
                                @php $score = $row[$cpmk->code] ?? null; @endphp
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

