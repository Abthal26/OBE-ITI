@extends('layouts.app')

@section('title', 'Edit Asesmen')
@section('subtitle', $assessment->code)

@section('content')
<div class="max-w-2xl space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('dosen.courses.assessments.index', $course) }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
    </div>
    
    <div class="card p-8">
        <form action="{{ route('dosen.courses.assessments.update', [$course, $assessment]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="code" class="form-label">Kode <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        id="code" 
                        name="code" 
                        value="{{ old('code', $assessment->code) }}"
                        class="form-input @error('code') border-red-500 @enderror"
                        required
                    >
                </div>
                
                <div>
                    <label for="type" class="form-label">Tipe <span class="text-red-500">*</span></label>
                    <select id="type" name="type" class="form-input" required>
                        <option value="quiz" {{ old('type', $assessment->type) == 'quiz' ? 'selected' : '' }}>Quiz</option>
                        <option value="tugas" {{ old('type', $assessment->type) == 'tugas' ? 'selected' : '' }}>Tugas</option>
                        <option value="uts" {{ old('type', $assessment->type) == 'uts' ? 'selected' : '' }}>UTS</option>
                        <option value="uas" {{ old('type', $assessment->type) == 'uas' ? 'selected' : '' }}>UAS</option>
                        <option value="praktikum" {{ old('type', $assessment->type) == 'praktikum' ? 'selected' : '' }}>Praktikum</option>
                        <option value="proyek" {{ old('type', $assessment->type) == 'proyek' ? 'selected' : '' }}>Proyek</option>
                        <option value="lainnya" {{ old('type', $assessment->type) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label for="name" class="form-label">Nama Asesmen <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $assessment->name) }}"
                    class="form-input"
                    required
                >
            </div>
            
            <div>
                <label for="max_score" class="form-label">Nilai Maksimum <span class="text-red-500">*</span></label>
                <input 
                    type="number" 
                    id="max_score" 
                    name="max_score" 
                    value="{{ old('max_score', $assessment->max_score) }}"
                    min="1"
                    max="1000"
                    class="form-input"
                    required
                >
            </div>
            
            <!-- CPMK Mapping -->
            @php
                $currentMappings = $assessment->cpmks->keyBy('id');
            @endphp
            
            <div>
                <label class="form-label">Pemetaan ke CPMK (Sheet: CPMK Bobot)</label>
                <div class="space-y-3">
                    @foreach($cpmks as $cpmk)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                            <div class="flex-1">
                                <span class="font-mono font-medium text-primary-600">{{ $cpmk->code }}</span>
                                <p class="text-sm text-gray-600 truncate">{{ Str::limit($cpmk->description, 60) }}</p>
                            </div>
                            <div class="w-32">
                                <input type="hidden" name="cpmk_mappings[{{ $loop->index }}][cpmk_id]" value="{{ $cpmk->id }}">
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        name="cpmk_mappings[{{ $loop->index }}][weight]"
                                        value="{{ old('cpmk_mappings.'.$loop->index.'.weight', $currentMappings->get($cpmk->id)?->pivot?->weight ?? 0) }}"
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
                <button type="submit" class="btn-primary">Update</button>
                <a href="{{ route('dosen.courses.assessments.index', $course) }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

