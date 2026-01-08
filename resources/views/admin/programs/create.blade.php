@extends('layouts.app')

@section('title', 'Tambah Program Studi')
@section('subtitle', 'Buat program studi baru')

@section('content')
<div class="max-w-2xl">
    <div class="card p-8">
        <form action="{{ route('admin.programs.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="code" class="form-label">Kode Program <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    id="code" 
                    name="code" 
                    value="{{ old('code') }}"
                    class="form-input @error('code') border-red-500 @enderror"
                    placeholder="Contoh: IF, SI, TI"
                    required
                >
                @error('code')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="name" class="form-label">Nama Program <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    class="form-input @error('name') border-red-500 @enderror"
                    placeholder="Contoh: Teknik Informatika"
                    required
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="description" class="form-label">Deskripsi</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    class="form-input @error('description') border-red-500 @enderror"
                    placeholder="Deskripsi singkat tentang program studi..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
                <a href="{{ route('admin.programs.index') }}" class="btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

