@extends('layouts.app')

@section('title', $user->name)
@section('subtitle', 'Detail pengguna')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn-secondary ml-auto">Edit</a>
    </div>
    
    <div class="card p-6">
        <div class="flex items-center gap-6">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-primary-500 to-purple-500 flex items-center justify-center text-white text-3xl font-bold">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                <p class="text-gray-500">{{ $user->email }}</p>
                <div class="flex items-center gap-2 mt-2">
                    @php
                        $roleColors = [
                            'admin' => 'bg-red-100 text-red-700',
                            'kaprodi' => 'bg-blue-100 text-blue-700',
                            'dosen' => 'bg-emerald-100 text-emerald-700',
                        ];
                    @endphp
                    <span class="badge {{ $roleColors[$user->role] ?? 'badge-info' }} capitalize">{{ $user->role }}</span>
                    @if($user->program)
                        <span class="badge badge-info">{{ $user->program->code }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @if($user->role === 'dosen' && $user->courses->count() > 0)
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Mata Kuliah yang Diampu</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($user->courses as $course)
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

