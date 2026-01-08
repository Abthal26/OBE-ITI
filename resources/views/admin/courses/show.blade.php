@extends('layouts.app')

@section('title', $course->name)
@section('subtitle', 'Detail mata kuliah')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.courses.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-lg bg-primary-100 text-primary-700 font-mono font-bold">{{ $course->code }}</span>
        </div>
        <a href="{{ route('admin.courses.edit', $course) }}" class="btn-secondary ml-auto">Edit</a>
    </div>
    
    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="card p-4">
            <p class="text-sm text-gray-500">Program Studi</p>
            <p class="font-semibold">{{ $course->program->name }}</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-500">Dosen Pengampu</p>
            <p class="font-semibold">{{ $course->dosen?->name ?? '-' }}</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-500">SKS / Semester</p>
            <p class="font-semibold">{{ $course->sks }} SKS / Semester {{ $course->semester }}</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-500">Periode</p>
            <p class="font-semibold">{{ $course->academic_year }} - {{ ucfirst($course->academic_period) }}</p>
        </div>
    </div>
    
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $course->cpmks->count() }}</p>
                    <p class="text-sm text-gray-500">CPMK</p>
                </div>
            </div>
        </div>
        
        <div class="card p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $course->assessments->count() }}</p>
                    <p class="text-sm text-gray-500">Asesmen</p>
                </div>
            </div>
        </div>
        
        <div class="card p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $course->students->count() }}</p>
                    <p class="text-sm text-gray-500">Mahasiswa</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CPMK List -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Daftar CPMK</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($course->cpmks as $cpmk)
                <div class="px-6 py-4">
                    <div class="flex items-start gap-4">
                        <span class="px-3 py-1 rounded-lg bg-primary-50 text-primary-700 font-mono font-medium text-sm">
                            {{ $cpmk->code }}
                        </span>
                        <p class="text-gray-700">{{ $cpmk->description }}</p>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-gray-500">Belum ada CPMK</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

