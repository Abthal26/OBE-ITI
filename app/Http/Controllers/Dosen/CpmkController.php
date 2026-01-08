<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Cpl;
use App\Models\Cpmk;
use App\Services\OBECalculationService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CpmkController extends Controller
{
    protected OBECalculationService $calculationService;

    public function __construct(OBECalculationService $calculationService)
    {
        $this->calculationService = $calculationService;
    }

    /**
     * Display CPMKs for a course.
     */
    public function index(Course $course)
    {
        $cpmks = $course->cpmks()
            ->with(['cpls', 'assessments'])
            ->get();
        
        // Get validation status for each CPMK
        $validationStatus = [];
        foreach ($cpmks as $cpmk) {
            $validationStatus[$cpmk->id] = $this->calculationService->validateCPMKWeights($cpmk);
        }
        
        return view('dosen.cpmks.index', compact('course', 'cpmks', 'validationStatus'));
    }

    /**
     * Show the form for creating a new CPMK.
     */
    public function create(Course $course)
    {
        $cpls = Cpl::where('program_id', $course->program_id)->get();
        
        return view('dosen.cpmks.create', compact('course', 'cpls'));
    }

    /**
     * Store a newly created CPMK.
     */
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('cpmks')->where('course_id', $course->id),
            ],
            'description' => 'required|string',
            'cpl_mappings' => 'nullable|array',
            'cpl_mappings.*.cpl_id' => 'required|exists:cpls,id',
            'cpl_mappings.*.weight' => 'required|numeric|min:0|max:100',
        ]);

        $cpmk = $course->cpmks()->create([
            'code' => $validated['code'],
            'description' => $validated['description'],
        ]);

        // Attach CPL mappings (Sheet: CPL Bobot)
        if (!empty($validated['cpl_mappings'])) {
            foreach ($validated['cpl_mappings'] as $mapping) {
                if ($mapping['weight'] > 0) {
                    $cpmk->cpls()->attach($mapping['cpl_id'], ['weight' => $mapping['weight']]);
                }
            }
        }

        return redirect()->route('dosen.courses.cpmks.index', $course)
            ->with('success', 'CPMK created successfully.');
    }

    /**
     * Show the form for editing the specified CPMK.
     */
    public function edit(Course $course, Cpmk $cpmk)
    {
        $cpls = Cpl::where('program_id', $course->program_id)->get();
        $cpmk->load('cpls');
        
        return view('dosen.cpmks.edit', compact('course', 'cpmk', 'cpls'));
    }

    /**
     * Update the specified CPMK.
     */
    public function update(Request $request, Course $course, Cpmk $cpmk)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('cpmks')->where('course_id', $course->id)->ignore($cpmk->id),
            ],
            'description' => 'required|string',
            'cpl_mappings' => 'nullable|array',
            'cpl_mappings.*.cpl_id' => 'required|exists:cpls,id',
            'cpl_mappings.*.weight' => 'required|numeric|min:0|max:100',
        ]);

        $cpmk->update([
            'code' => $validated['code'],
            'description' => $validated['description'],
        ]);

        // Sync CPL mappings (Sheet: CPL Bobot)
        $syncData = [];
        if (!empty($validated['cpl_mappings'])) {
            foreach ($validated['cpl_mappings'] as $mapping) {
                if ($mapping['weight'] > 0) {
                    $syncData[$mapping['cpl_id']] = ['weight' => $mapping['weight']];
                }
            }
        }
        $cpmk->cpls()->sync($syncData);

        return redirect()->route('dosen.courses.cpmks.index', $course)
            ->with('success', 'CPMK updated successfully.');
    }

    /**
     * Remove the specified CPMK.
     */
    public function destroy(Course $course, Cpmk $cpmk)
    {
        $cpmk->delete();

        return redirect()->route('dosen.courses.cpmks.index', $course)
            ->with('success', 'CPMK deleted successfully.');
    }
}

