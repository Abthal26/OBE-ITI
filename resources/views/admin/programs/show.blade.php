@extends('layouts.app')

@section('title', $program->name)
@section('subtitle', 'Detail program studi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.programs.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 rounded-lg bg-primary-100 text-primary-700 font-mono font-bold">{{ $program->code }}</span>
                <h2 class="text-xl font-bold text-gray-900">{{ $program->name }}</h2>
            </div>
        </div>
        <a href="{{ route('admin.programs.edit', $program) }}" class="btn-secondary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </a>
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
                    <p class="text-2xl font-bold text-gray-900">{{ $program->cpls->count() }}</p>
                    <p class="text-sm text-gray-500">CPL Terdaftar</p>
                </div>
            </div>
        </div>
        
        <div class="card p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $program->courses->count() }}</p>
                    <p class="text-sm text-gray-500">Mata Kuliah</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ $program->students->count() }}</p>
                    <p class="text-sm text-gray-500">Mahasiswa Aktif</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CPL List -->
    <div class="card">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-900">Daftar CPL</h3>
            <a href="{{ route('admin.cpls.create') }}?program_id={{ $program->id }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                + Tambah CPL
            </a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($program->cpls as $cpl)
                <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-4">
                        <span class="px-3 py-1 rounded-lg bg-blue-50 text-blue-700 font-mono font-medium text-sm">
                            {{ $cpl->code }}
                        </span>
                        <p class="text-gray-700 flex-1">{{ $cpl->description }}</p>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center text-gray-500">
                    Belum ada CPL untuk program ini
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

