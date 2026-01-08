<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Score;
use App\Models\Student;
use App\Services\OBECalculationService;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    protected OBECalculationService $calculationService;

    public function __construct(OBECalculationService $calculationService)
    {
        $this->calculationService = $calculationService;
    }

    /**
     * Display the score input matrix (Sheet: AsesmenNilai).
     */
    public function index(Course $course)
    {
        $course->load(['assessments', 'students.scores']);
        
        $students = $course->students()->orderBy('nim')->get();
        $assessments = $course->assessments()->orderBy('code')->get();
        
        // Build score matrix
        $scoreMatrix = [];
        foreach ($students as $student) {
            $scoreMatrix[$student->id] = [
                'nim' => $student->nim,
                'name' => $student->name,
                'scores' => [],
            ];
            
            foreach ($assessments as $assessment) {
                $score = $student->scores->where('assessment_id', $assessment->id)->first();
                $scoreMatrix[$student->id]['scores'][$assessment->id] = $score?->score;
            }
        }
        
        return view('dosen.scores.index', compact('course', 'students', 'assessments', 'scoreMatrix'));
    }

    /**
     * Update scores for a course (bulk update).
     * This replicates Excel input behavior where scores are entered in a matrix.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'array',
            'scores.*.*' => 'nullable|numeric|min:0',
        ]);

        // Get max scores for validation
        $assessments = $course->assessments->keyBy('id');
        
        foreach ($validated['scores'] as $studentId => $studentScores) {
            foreach ($studentScores as $assessmentId => $scoreValue) {
                // Validate max score
                $maxScore = $assessments[$assessmentId]?->max_score ?? 100;
                
                if ($scoreValue !== null && $scoreValue !== '') {
                    if ($scoreValue > $maxScore) {
                        return back()->withErrors([
                            "scores.{$studentId}.{$assessmentId}" => "Score cannot exceed max score ({$maxScore}).",
                        ]);
                    }
                    
                    Score::updateOrCreate(
                        [
                            'student_id' => $studentId,
                            'assessment_id' => $assessmentId,
                        ],
                        [
                            'score' => $scoreValue,
                        ]
                    );
                } else {
                    // Delete score if value is empty/null
                    Score::where('student_id', $studentId)
                        ->where('assessment_id', $assessmentId)
                        ->delete();
                }
            }
        }

        // Recalculate CPMK achievements after score update
        $this->calculationService->calculateAndSaveCPMKForCourse($course);

        return redirect()->route('dosen.courses.scores.index', $course)
            ->with('success', 'Scores updated successfully.');
    }

    /**
     * Enroll students in the course.
     */
    public function enrollStudents(Request $request, Course $course)
    {
        $validated = $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $course->students()->syncWithoutDetaching($validated['student_ids']);

        return redirect()->route('dosen.courses.scores.index', $course)
            ->with('success', 'Students enrolled successfully.');
    }

    /**
     * Remove a student from the course.
     */
    public function unenrollStudent(Course $course, Student $student)
    {
        $course->students()->detach($student->id);
        
        // Also delete their scores for this course
        Score::where('student_id', $student->id)
            ->whereHas('assessment', fn($q) => $q->where('course_id', $course->id))
            ->delete();

        return redirect()->route('dosen.courses.scores.index', $course)
            ->with('success', 'Student removed from course.');
    }

    /**
     * Show available students to enroll.
     */
    public function showEnrollForm(Course $course)
    {
        $enrolledIds = $course->students()->pluck('students.id');
        
        $availableStudents = Student::where('program_id', $course->program_id)
            ->whereNotIn('id', $enrolledIds)
            ->where('status', 'aktif')
            ->orderBy('nim')
            ->get();
        
        return view('dosen.scores.enroll', compact('course', 'availableStudents'));
    }
}

