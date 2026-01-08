<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProgramController extends Controller
{
    /**
     * Display a listing of programs.
     */
    public function index()
    {
        $programs = Program::withCount(['cpls', 'courses', 'students'])->get();
        
        return view('admin.programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new program.
     */
    public function create()
    {
        return view('admin.programs.create');
    }

    /**
     * Store a newly created program.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:programs,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Program::create($validated);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program created successfully.');
    }

    /**
     * Display the specified program.
     */
    public function show(Program $program)
    {
        $program->load(['cpls', 'courses', 'students']);
        
        return view('admin.programs.show', compact('program'));
    }

    /**
     * Show the form for editing the specified program.
     */
    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    /**
     * Update the specified program.
     */
    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', Rule::unique('programs')->ignore($program->id)],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $program->update($validated);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program updated successfully.');
    }

    /**
     * Remove the specified program.
     */
    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program deleted successfully.');
    }
}

