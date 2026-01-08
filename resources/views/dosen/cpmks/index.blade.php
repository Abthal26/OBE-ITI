@extends('layouts.app')

@section('title', 'Kelola CPMK')
@section('subtitle', $course->code . ' - ' . $course->name)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('dosen.dashboard') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <p class="text-sm text-gray-500">Sheet: CPMK Bobot & CPL Bobot</p>
        </div>
        <a href="{{ route('dosen.courses.cpmks.create', $course) }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah CPMK
        </a>
    </div>
    
    @if($cpmks->count() > 0)
        <div class="grid gap-4">
            @foreach($cpmks as $cpmk)
                <div class="card p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 rounded-lg bg-primary-50 text-primary-700 font-mono font-semibold">
                                    {{ $cpmk->code }}
                                </span>
                                @if(isset($validationStatus[$cpmk->id]) && !$validationStatus[$cpmk->id]['valid'])
                                    <span class="badge badge-warning">
                                        Bobot: {{ $validationStatus[$cpmk->id]['total_weight'] }}%
                                    </span>
                                @else
                                    <span class="badge badge-success">Bobot: 100%</span>
                                @endif
                            </div>
                            <p class="text-gray-700 mb-4">{{ $cpmk->description }}</p>
                            
                            <!-- CPL Mapping -->
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500 mb-2">Berkontribusi ke CPL:</p>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($cpmk->cpls as $cpl)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm">
                                            {{ $cpl->code }}
                                            <span class="text-blue-400">({{ $cpl->pivot->weight }}%)</span>
                                        </span>
                                    @empty
                                        <span class="text-sm text-gray-400">Belum dipetakan ke CPL</span>
                                    @endforelse
                                </div>
                            </div>
                            
                            <!-- Assessment Mapping -->
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-2">Asesmen yang berkontribusi:</p>
                                <div class="flex flex-wrap gap-2">
                                    @forelse($cpmk->assessments as $assessment)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-sm">
                                            {{ $assessment->code }}
                                            <span class="text-emerald-400">({{ $assessment->pivot->weight }}%)</span>
                                        </span>
                                    @empty
                                        <span class="text-sm text-gray-400">Belum ada asesmen</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2 ml-4">
                            <a href="{{ route('dosen.courses.cpmks.edit', [$course, $cpmk]) }}" class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('dosen.courses.cpmks.destroy', [$course, $cpmk]) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus CPMK ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <h4 class="text-lg font-medium text-gray-900 mb-2">Belum Ada CPMK</h4>
            <p class="text-gray-500 mb-4">Tambahkan CPMK untuk mata kuliah ini.</p>
            <a href="{{ route('dosen.courses.cpmks.create', $course) }}" class="btn-primary">Tambah CPMK Pertama</a>
        </div>
    @endif
</div>
@endsection

