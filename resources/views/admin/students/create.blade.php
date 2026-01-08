@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')
@section('subtitle', 'Program Studi ' . $program->name)

@section('content')
<div class="max-w-2xl">
    <div class="card p-8">
        <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-6">
            @csrf
            
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
                    <label for="nim" class="form-label">NIM <span class="text-red-500">*</span></label>
                    <input type="text" id="nim" name="nim" value="{{ old('nim') }}" class="form-input @error('nim') border-red-500 @enderror" placeholder="2023001" required>
                    @error('nim')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="angkatan" class="form-label">Angkatan <span class="text-red-500">*</span></label>
                    <input type="number" id="angkatan" name="angkatan" value="{{ old('angkatan', date('Y')) }}" min="2000" max="2100" class="form-input" required>
                </div>
            </div>
            
            <div>
                <label for="name" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input @error('name') border-red-500 @enderror" placeholder="Nama lengkap mahasiswa" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="status" class="form-label">Status <span class="text-red-500">*</span></label>
                <select id="status" name="status" class="form-input" required>
                    <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="cuti" {{ old('status') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                    <option value="lulus" {{ old('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                </select>
            </div>
            
            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
                <a href="{{ route('admin.students.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
