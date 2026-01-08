@extends('layouts.app')

@section('title', 'Edit CPMK')
@section('subtitle', $cpmk->code)

@section('content')
<div class="max-w-2xl space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('dosen.courses.cpmks.index', $course) }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
    </div>
    
    <div class="card p-8">
        <form action="{{ route('dosen.courses.cpmks.update', [$course, $cpmk]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="code" class="form-label">Kode CPMK <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    id="code" 
                    name="code" 
                    value="{{ old('code', $cpmk->code) }}"
                    class="form-input @error('code') border-red-500 @enderror"
                    required
                >
                @error('code')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="description" class="form-label">Deskripsi CPMK <span class="text-red-500">*</span></label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    class="form-input @error('description') border-red-500 @enderror"
                    required
                >{{ old('description', $cpmk->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- CPL Mapping -->
            <div>
                <label class="form-label">Pemetaan ke CPL (Sheet: CPL Bobot)</label>
                <p class="text-sm text-gray-500 mb-3">Tentukan bobot kontribusi CPMK ini ke setiap CPL</p>
                
                @php
                    $currentMappings = $cpmk->cpls->keyBy('id');
                @endphp
                
                <div class="space-y-3">
                    @foreach($cpls as $cpl)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                            <div class="flex-1">
                                <span class="font-mono font-medium text-primary-600">{{ $cpl->code }}</span>
                                <p class="text-sm text-gray-600 truncate">{{ Str::limit($cpl->description, 60) }}</p>
                            </div>
                            <div class="w-32">
                                <input type="hidden" name="cpl_mappings[{{ $loop->index }}][cpl_id]" value="{{ $cpl->id }}">
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        name="cpl_mappings[{{ $loop->index }}][weight]"
                                        value="{{ old('cpl_mappings.'.$loop->index.'.weight', $currentMappings->get($cpl->id)?->pivot?->weight ?? 0) }}"
                                        min="0"
                                        max="100"
                                        step="0.01"
                                        class="form-input pr-8 text-right"
                                    >
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">%</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update
                </button>
                <a href="{{ route('dosen.courses.cpmks.index', $course) }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

