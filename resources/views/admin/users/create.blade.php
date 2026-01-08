@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('subtitle', 'Buat akun pengguna baru')

@section('content')
<div class="max-w-2xl">
    <div class="card p-8">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="name" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input @error('name') border-red-500 @enderror" placeholder="Nama lengkap pengguna" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input @error('email') border-red-500 @enderror" placeholder="email@example.com" required>
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="password" class="form-label">Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password" name="password" class="form-input @error('password') border-red-500 @enderror" required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                </div>
            </div>
            
            <div>
                <label for="role" class="form-label">Role <span class="text-red-500">*</span></label>
                <select id="role" name="role" class="form-input" required>
                    <option value="dosen" {{ old('role', 'dosen') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="kaprodi" {{ old('role') == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                <p class="mt-1 text-sm text-gray-500">
                    Dosen dan Kaprodi akan otomatis terhubung ke Program Studi {{ $program->name }}
                </p>
            </div>
            
            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
