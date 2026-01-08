<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Course;
use App\Services\OBECalculationService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AssessmentController extends Controller
{
    protected OBECalculationService $calculationService;

    public function __construct(OBECalculationService $calculationService)
    {
        $this->calculationService = $calculationService;
    }

    /**
     * Display assessments for a course (Sheet: Pemetaan Asesmen).
     */
    public function index(Course $course)
    {
        $assessments = $course->assessments()
            ->with('cpmks')
            ->get();
        
        $cpmks = $course->cpmks;
        
        return view('dosen.assessments.index', compact('course', 'assessments', 'cpmks'));
    }

    /**
     * Show the form for creating a new assessment.
     */
    public function create(Course $course)
    {
        $cpmks = $course->cpmks;
        
        return view('dosen.assessments.create', compact('course', 'cpmks'));
    }

    /**
     * Store a newly created assessment.
     */
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('assessments')->where('course_id', $course->id),
            ],
            'name' => 'required|string|max:255',
            'type' => 'required|in:quiz,tugas,uts,uas,praktikum,proyek,lainnya',
            'max_score' => 'required|numeric|min:1|max:1000',
            'cpmk_mappings' => 'nullable|array',
            'cpmk_mappings.*.cpmk_id' => 'required|exists:cpmks,id',
            'cpmk_mappings.*.weight' => 'required|numeric|min:0|max:100',
        ]);

        $assessment = $course->assessments()->create([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'type' => $validated['type'],
            'max_score' => $validated['max_score'],
        ]);

        // Attach CPMK mappings (Sheet: CPMK Bobot)
        if (!empty($validated['cpmk_mappings'])) {
            foreach ($validated['cpmk_mappings'] as $mapping) {
                if ($mapping['weight'] > 0) {
                    $assessment->cpmks()->attach($mapping['cpmk_id'], ['weight' => $mapping['weight']]);
                }
            }
        }

        return redirect()->route('dosen.courses.assessments.index', $course)
            ->with('success', 'Assessment created successfully.');
    }

    /**
     * Show the form for editing the specified assessment.
     */
    public function edit(Course $course, Assessment $assessment)
    {
        $cpmks = $course->cpmks;
        $assessment->load('cpmks');
        
        return view('dosen.assessments.edit', compact('course', 'assessment', 'cpmks'));
    }

    /**
     * Update the specified assessment.
     */
    public function update(Request $request, Course $course, Assessment $assessment)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('assessments')->where('course_id', $course->id)->ignore($assessment->id),
            ],
            'name' => 'required|string|max:255',
            'type' => 'required|in:quiz,tugas,uts,uas,praktikum,proyek,lainnya',
            'max_score' => 'required|numeric|min:1|max:1000',
            'cpmk_mappings' => 'nullable|array',
            'cpmk_mappings.*.cpmk_id' => 'required|exists:cpmks,id',
            'cpmk_mappings.*.weight' => 'required|numeric|min:0|max:100',
        ]);

        $assessment->update([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'type' => $validated['type'],
            'max_score' => $validated['max_score'],
        ]);

        // Sync CPMK mappings (Sheet: CPMK Bobot)
        $syncData = [];
        if (!empty($validated['cpmk_mappings'])) {
            foreach ($validated['cpmk_mappings'] as $mapping) {
                if ($mapping['weight'] > 0) {
                    $syncData[$mapping['cpmk_id']] = ['weight' => $mapping['weight']];
                }
            }
        }
        $assessment->cpmks()->sync($syncData);

        return redirect()->route('dosen.courses.assessments.index', $course)
            ->with('success', 'Assessment updated successfully.');
    }

    /**
     * Remove the specified assessment.
     */
    public function destroy(Course $course, Assessment $assessment)
    {
        $assessment->delete();

        return redirect()->route('dosen.courses.assessments.index', $course)
            ->with('success', 'Assessment deleted successfully.');
    }
}

