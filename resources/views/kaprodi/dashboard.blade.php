@extends('layouts.app')

@section('title', 'Dashboard Kaprodi')
@section('subtitle', 'Monitoring capaian program studi')

@section('content')
@if(isset($error))
    <div class="card p-12 text-center">
        <svg class="w-16 h-16 text-amber-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <h4 class="text-lg font-medium text-gray-900 mb-2">{{ $error }}</h4>
        <p class="text-gray-500">Hubungi administrator untuk penugasan program studi.</p>
    </div>
@else
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card p-6 bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Mata Kuliah</p>
                    <p class="text-3xl font-bold mt-1">{{ $stats['total_courses'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="card p-6 bg-gradient-to-br from-emerald-500 to-emerald-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm">Mahasiswa Aktif</p>
                    <p class="text-3xl font-bold mt-1">{{ $stats['total_students'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="card p-6 bg-gradient-to-br from-purple-500 to-purple-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Total CPL</p>
                    <p class="text-3xl font-bold mt-1">{{ $stats['total_cpls'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CPL Achievement Overview -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-900">Rata-rata Capaian CPL</h3>
                <p class="text-sm text-gray-500">Berdasarkan seluruh mahasiswa aktif</p>
            </div>
            <a href="{{ route('kaprodi.reports.cpl') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                Lihat Detail →
            </a>
        </div>
        <div class="p-6">
            @if($cplAverages->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($cplAverages as $avg)
                        <div class="text-center p-4 bg-gray-50 rounded-xl">
                            <span class="font-mono font-semibold text-primary-600">{{ $avg->code }}</span>
                            <div class="mt-2">
                                <span class="text-2xl font-bold {{ $avg->average_score >= 70 ? 'text-emerald-600' : ($avg->average_score >= 55 ? 'text-amber-600' : 'text-red-600') }}">
                                    {{ number_format($avg->average_score, 1) }}
                                </span>
                            </div>
                            <div class="w-full h-2 bg-gray-200 rounded-full mt-2 overflow-hidden">
                                <div 
                                    class="h-full rounded-full {{ $avg->average_score >= 70 ? 'bg-emerald-500' : ($avg->average_score >= 55 ? 'bg-amber-500' : 'bg-red-500') }}"
                                    style="width: {{ min($avg->average_score, 100) }}%"
                                ></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-8">Belum ada data capaian CPL</p>
            @endif
        </div>
    </div>
    
    <!-- Recent Courses -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-900">Mata Kuliah Terbaru</h3>
            <a href="{{ route('kaprodi.reports.courses') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                Lihat Semua →
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="table-header">Kode</th>
                        <th class="table-header">Mata Kuliah</th>
                        <th class="table-header">Dosen</th>
                        <th class="table-header text-center">Mahasiswa</th>
                        <th class="table-header text-center">CPMK</th>
                        <th class="table-header">Periode</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentCourses as $course)
                        <tr class="hover:bg-gray-50">
                            <td class="table-cell">
                                <span class="font-mono font-medium text-primary-600">{{ $course->code }}</span>
                            </td>
                            <td class="table-cell">{{ $course->name }}</td>
                            <td class="table-cell">{{ $course->dosen?->name ?? '-' }}</td>
                            <td class="table-cell text-center">
                                <span class="badge badge-info">{{ $course->students_count }}</span>
                            </td>
                            <td class="table-cell text-center">
                                <span class="badge badge-success">{{ $course->cpmks_count }}</span>
                            </td>
                            <td class="table-cell text-sm text-gray-500">
                                {{ $course->academic_year }} - {{ ucfirst($course->academic_period) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="table-cell text-center py-8 text-gray-500">
                                Belum ada mata kuliah terdaftar
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection

