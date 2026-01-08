@extends('layouts.app')

@section('title', 'Edit Mata Kuliah')
@section('subtitle', $course->code . ' - ' . $course->name)

@section('content')
<div class="max-w-2xl">
    <div class="card p-8">
        <form action="{{ route('admin.courses.update', $course) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Program Info (Read-only) -->
            <div class="p-4 bg-indigo-50 border border-indigo-100 rounded-xl">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1.5 rounded-lg bg-indigo-600 text-white font-semibold text-sm">
                        {{ $program->code }}
                    </span>
                    <div>
                        <p class="font-medium text-gray-900">{{ $program->name }}</p>
                        <p class="text-sm text-gray-500">Program Studi</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="code" class="form-label">Kode MK <span class="text-red-500">*</span></label>
                    <input type="text" id="code" name="code" value="{{ old('code', $course->code) }}" class="form-input @error('code') border-red-500 @enderror" required>
                    @error('code')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="sks" class="form-label">SKS <span class="text-red-500">*</span></label>
                    <input type="number" id="sks" name="sks" value="{{ old('sks', $course->sks) }}" min="1" max="6" class="form-input" required>
                </div>
            </div>
            
            <div>
                <label for="name" class="form-label">Nama Mata Kuliah <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $course->name) }}" class="form-input" required>
            </div>
            
            <div>
                <label for="dosen_id" class="form-label">Dosen Pengampu</label>
                <select id="dosen_id" name="dosen_id" class="form-input">
                    <option value="">Pilih Dosen (Opsional)</option>
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}" {{ old('dosen_id', $course->dosen_id) == $dosen->id ? 'selected' : '' }}>
                            {{ $dosen->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="semester" class="form-label">Semester <span class="text-red-500">*</span></label>
                    <input type="number" id="semester" name="semester" value="{{ old('semester', $course->semester) }}" min="1" max="8" class="form-input" required>
                </div>
                <div>
                    <label for="academic_year" class="form-label">Tahun Akademik <span class="text-red-500">*</span></label>
                    <input type="text" id="academic_year" name="academic_year" value="{{ old('academic_year', $course->academic_year) }}" class="form-input" required>
                </div>
                <div>
                    <label for="academic_period" class="form-label">Periode <span class="text-red-500">*</span></label>
                    <select id="academic_period" name="academic_period" class="form-input" required>
                        <option value="ganjil" {{ old('academic_period', $course->academic_period) == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="genap" {{ old('academic_period', $course->academic_period) == 'genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>
            </div>
            
            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update
                </button>
                <a href="{{ route('admin.courses.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
