<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index(Request $request)
    {
        $program = Program::getDefault();
        $academicYear = $request->query('academic_year');
        
        $courses = Course::with('dosen')
            ->where('program_id', $program->id)
            ->when($academicYear, fn($q) => $q->where('academic_year', $academicYear))
            ->orderBy('academic_year', 'desc')
            ->orderBy('semester')
            ->orderBy('code')
            ->get();
        
        $academicYears = Course::where('program_id', $program->id)
            ->distinct()
            ->pluck('academic_year');
        
        return view('admin.courses.index', compact('courses', 'program', 'academicYears', 'academicYear'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $program = Program::getDefault();
        $dosens = User::where('role', 'dosen')->orderBy('name')->get();
        
        return view('admin.courses.create', compact('program', 'dosens'));
    }

    /**
     * Store a newly created course.
     */
    public function store(Request $request)
    {
        $program = Program::getDefault();
        
        $validated = $request->validate([
            'dosen_id' => 'nullable|exists:users,id',
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8',
            'academic_year' => 'required|string|max:20',
            'academic_period' => 'required|in:ganjil,genap',
        ]);

        // Check uniqueness
        $exists = Course::where('code', $validated['code'])
            ->where('academic_year', $validated['academic_year'])
            ->where('academic_period', $validated['academic_period'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['code' => 'Mata kuliah sudah ada untuk periode akademik tersebut.'])->withInput();
        }

        $validated['program_id'] = $program->id;

        Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        $course->load(['program', 'dosen', 'cpmks', 'assessments', 'students']);
        
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        $program = Program::getDefault();
        $dosens = User::where('role', 'dosen')->orderBy('name')->get();
        
        return view('admin.courses.edit', compact('course', 'program', 'dosens'));
    }

    /**
     * Update the specified course.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'dosen_id' => 'nullable|exists:users,id',
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8',
            'academic_year' => 'required|string|max:20',
            'academic_period' => 'required|in:ganjil,genap',
        ]);

        // Check uniqueness (excluding current course)
        $exists = Course::where('code', $validated['code'])
            ->where('academic_year', $validated['academic_year'])
            ->where('academic_period', $validated['academic_period'])
            ->where('id', '!=', $course->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['code' => 'Mata kuliah sudah ada untuk periode akademik tersebut.'])->withInput();
        }

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    /**
     * Remove the specified course.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Mata kuliah berhasil dihapus.');
    }
}
