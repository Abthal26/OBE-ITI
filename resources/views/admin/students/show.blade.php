@extends('layouts.app')

@section('title', $student->name)
@section('subtitle', 'Detail mahasiswa')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.students.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <a href="{{ route('admin.students.edit', $student) }}" class="btn-secondary ml-auto">Edit</a>
    </div>
    
    <!-- Info Card -->
    <div class="card p-6">
        <div class="flex items-center gap-6">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white text-3xl font-bold">
                {{ substr($student->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $student->name }}</h2>
                <p class="text-gray-500 font-mono">{{ $student->nim }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="badge badge-info">{{ $student->program->code }}</span>
                    <span class="badge badge-success">Angkatan {{ $student->angkatan }}</span>
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
                </div>
            </div>
        </div>
    </div>
    
    <!-- CPL Achievement -->
    @if($student->cplAchievements->count() > 0)
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Capaian CPL</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($student->cplAchievements as $achievement)
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <span class="font-mono font-semibold text-primary-600">{{ $achievement->cpl->code }}</span>
                            <p class="text-2xl font-bold mt-1 {{ $achievement->score >= 70 ? 'text-emerald-600' : ($achievement->score >= 55 ? 'text-amber-600' : 'text-red-600') }}">
                                {{ number_format($achievement->score, 1) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    <!-- CPMK Achievement -->
    @if($student->cpmkAchievements->count() > 0)
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Capaian CPMK</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="table-header">CPMK</th>
                            <th class="table-header">Mata Kuliah</th>
                            <th class="table-header text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($student->cpmkAchievements as $achievement)
                            <tr>
                                <td class="table-cell font-mono font-medium text-primary-600">{{ $achievement->cpmk->code }}</td>
                                <td class="table-cell">{{ $achievement->cpmk->course->name ?? '-' }}</td>
                                <td class="table-cell text-center">
                                    <span class="inline-block px-3 py-1 rounded-lg font-medium
                                        {{ $achievement->score >= 70 ? 'bg-emerald-100 text-emerald-700' : ($achievement->score >= 55 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                        {{ number_format($achievement->score, 1) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    
    <!-- Enrolled Courses -->
    @if($student->courses->count() > 0)
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Mata Kuliah yang Diambil</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($student->courses as $course)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <span class="font-mono text-primary-600 font-medium">{{ $course->code }}</span>
                            <span class="text-gray-700 ml-2">{{ $course->name }}</span>
                        </div>
                        <span class="text-sm text-gray-500">{{ $course->academic_year }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

