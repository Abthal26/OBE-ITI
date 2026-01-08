@extends('layouts.app')

@section('title', 'Tambah CPL')
@section('subtitle', 'Program Studi ' . $program->name)

@section('content')
<div class="max-w-2xl">
    <div class="card p-8">
        <form action="{{ route('admin.cpls.store') }}" method="POST" class="space-y-6">
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
            
            <div>
                <label for="code" class="form-label">Kode CPL <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    id="code" 
                    name="code" 
                    value="{{ old('code') }}"
                    class="form-input @error('code') border-red-500 @enderror"
                    placeholder="Contoh: CPL1, CPL2"
                    required
                >
                @error('code')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="description" class="form-label">Deskripsi CPL <span class="text-red-500">*</span></label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    class="form-input @error('description') border-red-500 @enderror"
                    placeholder="Contoh: Mampu menerapkan pengetahuan matematika dan sains untuk menyelesaikan masalah..."
                    required
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
                <a href="{{ route('admin.cpls.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
