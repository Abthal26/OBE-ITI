<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cpl;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CplController extends Controller
{
    /**
     * Display a listing of CPLs.
     */
    public function index()
    {
        $program = Program::getDefault();
        
        $cpls = Cpl::where('program_id', $program->id)
            ->orderBy('code')
            ->get();
        
        return view('admin.cpls.index', compact('cpls', 'program'));
    }

    /**
     * Show the form for creating a new CPL.
     */
    public function create()
    {
        $program = Program::getDefault();
        
        return view('admin.cpls.create', compact('program'));
    }

    /**
     * Store a newly created CPL.
     */
    public function store(Request $request)
    {
        $program = Program::getDefault();
        
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('cpls')->where('program_id', $program->id),
            ],
            'description' => 'required|string',
        ]);

        $validated['program_id'] = $program->id;

        Cpl::create($validated);

        return redirect()->route('admin.cpls.index')
            ->with('success', 'CPL berhasil ditambahkan.');
    }

    /**
     * Display the specified CPL.
     */
    public function show(Cpl $cpl)
    {
        $cpl->load(['program', 'cpmks.course']);
        
        return view('admin.cpls.show', compact('cpl'));
    }

    /**
     * Show the form for editing the specified CPL.
     */
    public function edit(Cpl $cpl)
    {
        $program = Program::getDefault();
        
        return view('admin.cpls.edit', compact('cpl', 'program'));
    }

    /**
     * Update the specified CPL.
     */
    public function update(Request $request, Cpl $cpl)
    {
        $program = Program::getDefault();
        
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('cpls')
                    ->where('program_id', $program->id)
                    ->ignore($cpl->id),
            ],
            'description' => 'required|string',
        ]);

        $cpl->update($validated);

        return redirect()->route('admin.cpls.index')
            ->with('success', 'CPL berhasil diperbarui.');
    }

    /**
     * Remove the specified CPL.
     */
    public function destroy(Cpl $cpl)
    {
        $cpl->delete();

        return redirect()->route('admin.cpls.index')
            ->with('success', 'CPL berhasil dihapus.');
    }
}
