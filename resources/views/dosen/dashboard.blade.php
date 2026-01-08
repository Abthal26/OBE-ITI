@extends('layouts.app')

@section('title', 'Dashboard Dosen')
@section('subtitle', 'Kelola mata kuliah Anda')

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="card p-6 bg-gradient-to-r from-primary-600 to-primary-700 text-white">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-primary-100">Anda memiliki {{ $courses->count() }} mata kuliah yang diampu</p>
            </div>
        </div>
    </div>
    
    <!-- Courses Grid -->
    <div>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Mata Kuliah Anda</h3>
        
        @if($courses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($courses as $course)
                    <div class="card hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <span class="inline-block px-3 py-1 rounded-lg bg-primary-50 text-primary-700 font-mono text-sm font-medium mb-2">
                                        {{ $course->code }}
                                    </span>
                                    <h4 class="font-semibold text-gray-900">{{ $course->name }}</h4>
                                </div>
                                <span class="badge badge-info">{{ $course->sks }} SKS</span>
                            </div>
                            
                            <div class="space-y-2 text-sm text-gray-600 mb-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $course->academic_year }} - {{ ucfirst($course->academic_period) }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $course->students_count }} Mahasiswa
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-2 text-center mb-4">
                                <div class="bg-gray-50 rounded-lg p-2">
                                    <p class="text-lg font-bold text-gray-900">{{ $course->cpmks_count }}</p>
                                    <p class="text-xs text-gray-500">CPMK</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-2">
                                    <p class="text-lg font-bold text-gray-900">{{ $course->assessments_count }}</p>
                                    <p class="text-xs text-gray-500">Asesmen</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            <div class="grid grid-cols-4 gap-2">
                                <a href="{{ route('dosen.courses.cpmks.index', $course) }}" 
                                   class="flex flex-col items-center p-2 rounded-lg hover:bg-white transition-colors group"
                                   title="CPMK">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    <span class="text-xs text-gray-500 group-hover:text-primary-600 mt-1">CPMK</span>
                                </a>
                                <a href="{{ route('dosen.courses.assessments.index', $course) }}" 
                                   class="flex flex-col items-center p-2 rounded-lg hover:bg-white transition-colors group"
                                   title="Asesmen">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="text-xs text-gray-500 group-hover:text-emerald-600 mt-1">Asesmen</span>
                                </a>
                                <a href="{{ route('dosen.courses.scores.index', $course) }}" 
                                   class="flex flex-col items-center p-2 rounded-lg hover:bg-white transition-colors group"
                                   title="Input Nilai">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span class="text-xs text-gray-500 group-hover:text-amber-600 mt-1">Nilai</span>
                                </a>
                                <a href="{{ route('dosen.courses.report', $course) }}" 
                                   class="flex flex-col items-center p-2 rounded-lg hover:bg-white transition-colors group"
                                   title="Laporan">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="text-xs text-gray-500 group-hover:text-purple-600 mt-1">Laporan</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h4 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Mata Kuliah</h4>
                <p class="text-gray-500">Anda belum ditugaskan untuk mengampu mata kuliah apapun.</p>
            </div>
        @endif
    </div>
</div>
@endsection

