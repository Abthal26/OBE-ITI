<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Course;
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
     * Show the complete OBE report for a course.
     * This replicates all Excel sheets in a single view.
     */
    public function show(Course $course)
    {
        // First, ensure CPMK achievements are calculated
        $this->calculationService->calculateAndSaveCPMKForCourse($course);
        
        // Then calculate CPL achievements
        $this->calculationService->calculateAndSaveCPLForProgram(
            $course->program_id,
            $course->academic_year,
            $course->academic_period
        );
        
        // Get the complete report
        $report = $this->calculationService->getCourseReport($course);
        
        // Get class averages
        $cpmkAverages = $this->calculationService->getCPMKClassAverage($course);
        $cplAverages = $this->calculationService->getCPLClassAverage(
            $course->program_id,
            $course->academic_year,
            $course->academic_period
        );
        
        // Weight validation
        $cpmkValidation = [];
        foreach ($course->cpmks as $cpmk) {
            $cpmkValidation[$cpmk->code] = $this->calculationService->validateCPMKWeights($cpmk);
        }
        
        $cplValidation = [];
        foreach ($course->program->cpls as $cpl) {
            $cplValidation[$cpl->code] = $this->calculationService->validateCPLWeights($cpl);
        }
        
        return view('dosen.reports.show', compact(
            'course',
            'report',
            'cpmkAverages',
            'cplAverages',
            'cpmkValidation',
            'cplValidation'
        ));
    }

    /**
     * Export report to Excel format.
     */
    public function export(Course $course)
    {
        // Ensure calculations are up to date
        $this->calculationService->calculateAndSaveCPMKForCourse($course);
        $this->calculationService->calculateAndSaveCPLForProgram(
            $course->program_id,
            $course->academic_year,
            $course->academic_period
        );
        
        $report = $this->calculationService->getCourseReport($course);
        
        // TODO: Implement Excel export using Laravel Excel (maatwebsite/excel)
        // For now, return JSON
        return response()->json($report);
    }

    /**
     * Recalculate all achievements for a course.
     */
    public function recalculate(Course $course)
    {
        $cpmkCount = $this->calculationService->calculateAndSaveCPMKForCourse($course);
        $cplCount = $this->calculationService->calculateAndSaveCPLForProgram(
            $course->program_id,
            $course->academic_year,
            $course->academic_period
        );
        
        return redirect()->route('dosen.courses.report', $course)
            ->with('success', "Recalculated {$cpmkCount} CPMK and {$cplCount} CPL achievements.");
    }
}

