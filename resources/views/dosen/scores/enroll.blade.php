@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')
@section('subtitle', $course->code . ' - ' . $course->name)

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('dosen.courses.scores.index', $course) }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
    </div>
    
    @if($availableStudents->count() > 0)
        <form action="{{ route('dosen.courses.scores.enroll.store', $course) }}" method="POST">
            @csrf
            
            <div class="card">
                <div class="px-6 py-4 border-b border-gray-100">
                    <p class="text-sm text-gray-600">Pilih mahasiswa yang akan didaftarkan ke mata kuliah ini</p>
                </div>
                
                <div class="divide-y divide-gray-50 max-h-[500px] overflow-y-auto">
                    @foreach($availableStudents as $student)
                        <label class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 cursor-pointer transition-colors">
                            <input 
                                type="checkbox" 
                                name="student_ids[]" 
                                value="{{ $student->id }}"
                                class="w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                            >
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $student->name }}</p>
                                <p class="text-sm text-gray-500 font-mono">{{ $student->nim }}</p>
                            </div>
                            <span class="badge badge-info">{{ $student->angkatan }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            
            <div class="flex items-center gap-4 mt-6">
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Daftarkan Mahasiswa Terpilih
                </button>
                <a href="{{ route('dosen.courses.scores.index', $course) }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    @else
        <div class="card p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h4 class="text-lg font-medium text-gray-900 mb-2">Semua Mahasiswa Sudah Terdaftar</h4>
            <p class="text-gray-500">Tidak ada mahasiswa yang tersedia untuk didaftarkan.</p>
        </div>
    @endif
</div>
@endsection

