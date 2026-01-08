@extends('layouts.app')

@section('title', 'Tambah Asesmen')
@section('subtitle', $course->code . ' - ' . $course->name)

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
        <form action="{{ route('dosen.courses.assessments.store', $course) }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="code" class="form-label">Kode <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        id="code" 
                        name="code" 
                        value="{{ old('code') }}"
                        class="form-input @error('code') border-red-500 @enderror"
                        placeholder="Contoh: Quiz1, UTS"
                        required
                    >
                    @error('code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="type" class="form-label">Tipe <span class="text-red-500">*</span></label>
                    <select 
                        id="type" 
                        name="type" 
                        class="form-input @error('type') border-red-500 @enderror"
                        required
                    >
                        <option value="">Pilih Tipe</option>
                        <option value="quiz" {{ old('type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                        <option value="tugas" {{ old('type') == 'tugas' ? 'selected' : '' }}>Tugas</option>
                        <option value="uts" {{ old('type') == 'uts' ? 'selected' : '' }}>UTS</option>
                        <option value="uas" {{ old('type') == 'uas' ? 'selected' : '' }}>UAS</option>
                        <option value="praktikum" {{ old('type') == 'praktikum' ? 'selected' : '' }}>Praktikum</option>
                        <option value="proyek" {{ old('type') == 'proyek' ? 'selected' : '' }}>Proyek</option>
                        <option value="lainnya" {{ old('type') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="name" class="form-label">Nama Asesmen <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    class="form-input @error('name') border-red-500 @enderror"
                    placeholder="Contoh: Quiz 1 - Konsep Dasar"
                    required
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="max_score" class="form-label">Nilai Maksimum <span class="text-red-500">*</span></label>
                <input 
                    type="number" 
                    id="max_score" 
                    name="max_score" 
                    value="{{ old('max_score', 100) }}"
                    min="1"
                    max="1000"
                    class="form-input @error('max_score') border-red-500 @enderror"
                    required
                >
                @error('max_score')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- CPMK Mapping (Sheet: CPMK Bobot) -->
            <div>
                <label class="form-label">Pemetaan ke CPMK (Sheet: CPMK Bobot)</label>
                <p class="text-sm text-gray-500 mb-3">Tentukan bobot kontribusi asesmen ini ke setiap CPMK</p>
                
                @if($cpmks->count() > 0)
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
                                            value="{{ old('cpmk_mappings.'.$loop->index.'.weight', 0) }}"
                                            min="0"
                                            max="100"
                                            step="0.01"
                                            class="form-input pr-8 text-right"
                                            placeholder="0"
                                        >
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">%</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 bg-amber-50 text-amber-700 rounded-xl text-sm">
                        <strong>Perhatian:</strong> Belum ada CPMK untuk mata kuliah ini. 
                        <a href="{{ route('dosen.courses.cpmks.create', $course) }}" class="underline">Tambah CPMK terlebih dahulu</a>.
                    </div>
                @endif
            </div>
            
            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
                <a href="{{ route('dosen.courses.assessments.index', $course) }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

