@extends('layouts.app')

@section('title', $cpl->code)
@section('subtitle', 'Detail CPL')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.cpls.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-lg bg-primary-100 text-primary-700 font-mono font-bold">{{ $cpl->code }}</span>
            <span class="badge badge-info">{{ $cpl->program->code }}</span>
        </div>
        <a href="{{ route('admin.cpls.edit', $cpl) }}" class="btn-secondary ml-auto">Edit</a>
    </div>
    
    <div class="card p-6">
        <h3 class="font-semibold text-gray-900 mb-2">Deskripsi</h3>
        <p class="text-gray-700">{{ $cpl->description }}</p>
    </div>
    
    @if($cpl->cpmks->count() > 0)
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">CPMK yang Berkontribusi</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($cpl->cpmks as $cpmk)
                    <div class="px-6 py-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start gap-4">
                                <span class="px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-mono font-medium text-sm">
                                    {{ $cpmk->code }}
                                </span>
                                <div>
                                    <p class="text-gray-700">{{ $cpmk->description }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ $cpmk->course->code }} - {{ $cpmk->course->name }}</p>
                                </div>
                            </div>
                            <span class="badge badge-info">{{ $cpmk->pivot->weight }}%</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

