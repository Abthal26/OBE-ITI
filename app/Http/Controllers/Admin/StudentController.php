<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $program = Program::getDefault();
        $angkatan = $request->query('angkatan');
        $status = $request->query('status');
        $search = $request->query('search');
        
        $students = Student::where('program_id', $program->id)
            ->when($angkatan, fn($q) => $q->where('angkatan', $angkatan))
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($search, fn($q) => $q->where(function($query) use ($search) {
                $query->where('nim', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%");
            }))
            ->orderBy('angkatan', 'desc')
            ->orderBy('nim')
            ->paginate(50);
        
        $angkatans = Student::where('program_id', $program->id)
            ->distinct()
            ->orderBy('angkatan', 'desc')
            ->pluck('angkatan');
        
        return view('admin.students.index', compact('students', 'program', 'angkatans', 'angkatan', 'status', 'search'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $program = Program::getDefault();
        
        return view('admin.students.create', compact('program'));
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $program = Program::getDefault();
        
        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:students,nim',
            'name' => 'required|string|max:255',
            'angkatan' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:aktif,tidak_aktif,lulus,cuti',
        ]);

        $validated['program_id'] = $program->id;

        Student::create($validated);

        return redirect()->route('admin.students.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        $student->load(['program', 'courses', 'cpmkAchievements.cpmk', 'cplAchievements.cpl']);
        
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $program = Program::getDefault();
        
        return view('admin.students.edit', compact('student', 'program'));
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nim' => ['required', 'string', 'max:20', Rule::unique('students')->ignore($student->id)],
            'name' => 'required|string|max:255',
            'angkatan' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:aktif,tidak_aktif,lulus,cuti',
        ]);

        $student->update($validated);

        return redirect()->route('admin.students.index')
            ->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified student.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Mahasiswa berhasil dihapus.');
    }

    /**
     * Import students from CSV/Excel.
     */
    public function import(Request $request)
    {
        $program = Program::getDefault();
        
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls',
        ]);

        // TODO: Implement import logic
        // This would use a library like Laravel Excel (maatwebsite/excel)
        
        return back()->with('success', 'Mahasiswa berhasil diimpor.');
    }
}
