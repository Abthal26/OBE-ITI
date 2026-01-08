<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Cpl;
use App\Models\Student;
use App\Services\OBECalculationService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected OBECalculationService $calculationService;

    public function __construct(OBECalculationService $calculationService)
    {
        $this->calculationService = $calculationService;
    }

    /**
     * Display the CPL achievement report for the program.
     */
    public function cplReport(Request $request)
    {
        $user = $request->user();
        $programId = $user->program_id;
        
        $academicYear = $request->query('academic_year');
        $academicPeriod = $request->query('academic_period');
        
        // Get available academic periods
        $academicYears = Course::where('program_id', $programId)
            ->distinct()
            ->orderBy('academic_year', 'desc')
            ->pluck('academic_year');
        
        // Get CPL achievement summary
        $cplAverages = $this->calculationService->getCPLClassAverage(
            $programId,
            $academicYear,
            $academicPeriod
        );
        
        // Get all CPLs for the program
        $cpls = Cpl::where('program_id', $programId)
            ->with('cpmks.course')
            ->orderBy('code')
            ->get();
        
        return view('kaprodi.reports.cpl', compact(
            'cpls',
            'cplAverages',
            'academicYears',
            'academicYear',
            'academicPeriod'
        ));
    }

    /**
     * Display detailed CPL achievement per student.
     */
    public function cplStudentReport(Request $request)
    {
        $user = $request->user();
        $programId = $user->program_id;
        
        $academicYear = $request->query('academic_year');
        $academicPeriod = $request->query('academic_period');
        $angkatan = $request->query('angkatan');
        
        // Get filters
        $academicYears = Course::where('program_id', $programId)
            ->distinct()
            ->orderBy('academic_year', 'desc')
            ->pluck('academic_year');
        
        $angkatans = Student::where('program_id', $programId)
            ->distinct()
            ->orderBy('angkatan', 'desc')
            ->pluck('angkatan');
        
        // Get students with their CPL achievements
        $students = Student::where('program_id', $programId)
            ->when($angkatan, fn($q) => $q->where('angkatan', $angkatan))
            ->with(['cplAchievements' => function ($q) use ($academicYear, $academicPeriod) {
                $q->when($academicYear, fn($q2) => $q2->where('academic_year', $academicYear))
                  ->when($academicPeriod, fn($q2) => $q2->where('academic_period', $academicPeriod))
                  ->with('cpl');
            }])
            ->orderBy('nim')
            ->paginate(50);
        
        // Get CPL list for headers
        $cpls = Cpl::where('program_id', $programId)->orderBy('code')->get();
        
        return view('kaprodi.reports.cpl-students', compact(
            'students',
            'cpls',
            'academicYears',
            'angkatans',
            'academicYear',
            'academicPeriod',
            'angkatan'
        ));
    }

    /**
     * Display course-level reports.
     */
    public function courseReport(Request $request)
    {
        $user = $request->user();
        $programId = $user->program_id;
        
        $academicYear = $request->query('academic_year');
        $academicPeriod = $request->query('academic_period');
        
        // Get filters
        $academicYears = Course::where('program_id', $programId)
            ->distinct()
            ->orderBy('academic_year', 'desc')
            ->pluck('academic_year');
        
        // Get courses with CPMK achievement summary
        $courses = Course::where('program_id', $programId)
            ->when($academicYear, fn($q) => $q->where('academic_year', $academicYear))
            ->when($academicPeriod, fn($q) => $q->where('academic_period', $academicPeriod))
            ->with(['dosen', 'cpmks'])
            ->withCount(['students', 'assessments'])
            ->orderBy('semester')
            ->orderBy('code')
            ->get();
        
        // Calculate CPMK averages for each course
        $courseReports = [];
        foreach ($courses as $course) {
            $courseReports[$course->id] = [
                'course' => $course,
                'cpmk_averages' => $this->calculationService->getCPMKClassAverage($course),
            ];
        }
        
        return view('kaprodi.reports.courses', compact(
            'courses',
            'courseReports',
            'academicYears',
            'academicYear',
            'academicPeriod'
        ));
    }

    /**
     * View detailed report for a specific course.
     */
    public function courseDetail(Course $course)
    {
        // Ensure the course belongs to the user's program
        $user = request()->user();
        if ($course->program_id !== $user->program_id) {
            abort(403);
        }
        
        $report = $this->calculationService->getCourseReport($course);
        $cpmkAverages = $this->calculationService->getCPMKClassAverage($course);
        
        // Weight validation
        $cpmkValidation = [];
        foreach ($course->cpmks as $cpmk) {
            $cpmkValidation[$cpmk->code] = $this->calculationService->validateCPMKWeights($cpmk);
        }
        
        return view('kaprodi.reports.course-detail', compact(
            'course',
            'report',
            'cpmkAverages',
            'cpmkValidation'
        ));
    }

    /**
     * Export CPL report to Excel.
     */
    public function exportCpl(Request $request)
    {
        $user = $request->user();
        $programId = $user->program_id;
        
        $academicYear = $request->query('academic_year');
        $academicPeriod = $request->query('academic_period');
        
        $cplAverages = $this->calculationService->getCPLClassAverage(
            $programId,
            $academicYear,
            $academicPeriod
        );
        
        // TODO: Implement Excel export using Laravel Excel
        return response()->json([
            'program_id' => $programId,
            'academic_year' => $academicYear,
            'academic_period' => $academicPeriod,
            'cpl_averages' => $cplAverages,
        ]);
    }
}

