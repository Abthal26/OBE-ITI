<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Cpl;
use App\Models\Student;
use App\Services\OBECalculationService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected OBECalculationService $calculationService;

    public function __construct(OBECalculationService $calculationService)
    {
        $this->calculationService = $calculationService;
    }

    /**
     * Display the kaprodi dashboard with program overview.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $programId = $user->program_id;
        
        if (!$programId) {
            return view('kaprodi.dashboard', ['error' => 'You are not assigned to any program.']);
        }
        
        // Get summary statistics
        $stats = [
            'total_courses' => Course::where('program_id', $programId)->count(),
            'total_students' => Student::where('program_id', $programId)->where('status', 'aktif')->count(),
            'total_cpls' => Cpl::where('program_id', $programId)->count(),
        ];
        
        // Get recent courses
        $recentCourses = Course::where('program_id', $programId)
            ->with('dosen')
            ->withCount(['students', 'cpmks'])
            ->orderBy('academic_year', 'desc')
            ->orderBy('academic_period')
            ->limit(10)
            ->get();
        
        // Get CPL achievement overview
        $cplAverages = $this->calculationService->getCPLClassAverage($programId);
        
        return view('kaprodi.dashboard', compact('stats', 'recentCourses', 'cplAverages'));
    }
}

