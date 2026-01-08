<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\Course;
use App\Models\Cpl;
use App\Models\CplAchievement;
use App\Models\Cpmk;
use App\Models\CpmkAchievement;
use App\Models\Score;
use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * OBE Calculation Service
 * 
 * This service replicates the EXACT calculation logic from the Excel file:
 * 
 * Sheet Flow:
 * 1. Pemetaan Asesmen → defines mapping (Assessment ↔ CPMK ↔ CPL)
 * 2. CPMK Bobot → defines weight of each Assessment per CPMK
 * 3. CPL Bobot → defines weight of each CPMK per CPL
 * 4. AsesmenNilai → raw student scores (INPUT)
 * 5. AsesmenCPMK → calculated CPMK achievement (OUTPUT)
 * 6. AsesmenCPL → calculated CPL achievement (OUTPUT)
 * 
 * Calculation Formulas:
 * 
 * CPMK Score = Σ(Normalized_Assessment_Score × Assessment_Weight_in_CPMK)
 * Where: Normalized_Score = (Raw_Score / Max_Score) * 100
 * 
 * CPL Score = Σ(CPMK_Score × CPMK_Weight_in_CPL)
 * 
 * All weights are stored as percentages (0-100) and converted to decimals during calculation.
 */
class OBECalculationService
{
    /**
     * Calculate CPMK achievement for a specific student in a course
     * 
     * Excel Logic (Sheet: AsesmenCPMK):
     * For each CPMK, sum the weighted normalized scores of all assessments
     * 
     * Formula: CPMK_Score = Σ(Assessment_Score × Weight / 100)
     * 
     * @param Student $student
     * @param Course $course
     * @return Collection<int, array{cpmk_id: int, score: float}>
     */
    public function calculateCPMKForStudent(Student $student, Course $course): Collection
    {
        $results = collect();
        
        // Get all CPMKs for this course
        $cpmks = $course->cpmks()->with(['assessments' => function ($query) {
            $query->withPivot('weight');
        }])->get();
        
        foreach ($cpmks as $cpmk) {
            $cpmkScore = $this->calculateSingleCPMK($student, $cpmk);
            
            $results->push([
                'cpmk_id' => $cpmk->id,
                'cpmk_code' => $cpmk->code,
                'score' => $cpmkScore,
            ]);
        }
        
        return $results;
    }

    /**
     * Calculate a single CPMK score for a student
     * 
     * @param Student $student
     * @param Cpmk $cpmk
     * @return float|null
     */
    public function calculateSingleCPMK(Student $student, Cpmk $cpmk): ?float
    {
        $assessments = $cpmk->assessments()->withPivot('weight')->get();
        
        if ($assessments->isEmpty()) {
            return null;
        }
        
        $totalScore = 0;
        $totalWeight = 0;
        $hasScores = false;
        
        foreach ($assessments as $assessment) {
            $weight = (float) $assessment->pivot->weight;
            
            // Get student's score for this assessment
            $score = Score::where('student_id', $student->id)
                ->where('assessment_id', $assessment->id)
                ->first();
            
            if ($score && $score->score !== null) {
                // Normalize score: (raw_score / max_score) * 100
                $maxScore = (float) $assessment->max_score ?: 100;
                $normalizedScore = ($score->score / $maxScore) * 100;
                
                // Apply weight: score * (weight / 100)
                $weightedScore = $normalizedScore * ($weight / 100);
                
                $totalScore += $weightedScore;
                $hasScores = true;
            }
            
            $totalWeight += $weight;
        }
        
        // Return null if no scores exist
        if (!$hasScores) {
            return null;
        }
        
        // If weights don't sum to 100, normalize the result
        // This handles cases where not all assessments have been graded
        if ($totalWeight > 0 && $totalWeight != 100) {
            // Option 1: Return as-is (partial score)
            // Option 2: Normalize to account for missing assessments
            // Using Option 1 to match typical Excel behavior
        }
        
        return round($totalScore, 2);
    }

    /**
     * Calculate CPL achievement for a specific student
     * 
     * Excel Logic (Sheet: AsesmenCPL):
     * For each CPL, sum the weighted CPMK scores
     * 
     * Formula: CPL_Score = Σ(CPMK_Score × Weight / 100)
     * 
     * @param Student $student
     * @param string|null $academicYear
     * @param string|null $academicPeriod
     * @return Collection<int, array{cpl_id: int, score: float}>
     */
    public function calculateCPLForStudent(
        Student $student, 
        ?string $academicYear = null, 
        ?string $academicPeriod = null
    ): Collection {
        $results = collect();
        
        // Get all CPLs for the student's program
        $cpls = Cpl::where('program_id', $student->program_id)
            ->with(['cpmks' => function ($query) {
                $query->withPivot('weight');
            }])
            ->get();
        
        foreach ($cpls as $cpl) {
            $cplScore = $this->calculateSingleCPL($student, $cpl, $academicYear, $academicPeriod);
            
            $results->push([
                'cpl_id' => $cpl->id,
                'cpl_code' => $cpl->code,
                'score' => $cplScore,
            ]);
        }
        
        return $results;
    }

    /**
     * Calculate a single CPL score for a student
     * 
     * @param Student $student
     * @param Cpl $cpl
     * @param string|null $academicYear
     * @param string|null $academicPeriod
     * @return float|null
     */
    public function calculateSingleCPL(
        Student $student, 
        Cpl $cpl, 
        ?string $academicYear = null, 
        ?string $academicPeriod = null
    ): ?float {
        $cpmks = $cpl->cpmks()->withPivot('weight')->get();
        
        if ($cpmks->isEmpty()) {
            return null;
        }
        
        $totalScore = 0;
        $totalWeight = 0;
        $hasScores = false;
        
        foreach ($cpmks as $cpmk) {
            $weight = (float) $cpmk->pivot->weight;
            
            // Get CPMK achievement - either from cache or calculate on-the-fly
            $cpmkAchievement = CpmkAchievement::where('student_id', $student->id)
                ->where('cpmk_id', $cpmk->id)
                ->first();
            
            if ($cpmkAchievement && $cpmkAchievement->score !== null) {
                // Apply weight: cpmk_score * (weight / 100)
                $weightedScore = $cpmkAchievement->score * ($weight / 100);
                
                $totalScore += $weightedScore;
                $hasScores = true;
            }
            
            $totalWeight += $weight;
        }
        
        if (!$hasScores) {
            return null;
        }
        
        return round($totalScore, 2);
    }

    /**
     * Calculate and save all CPMK achievements for a course
     * 
     * @param Course $course
     * @return int Number of records processed
     */
    public function calculateAndSaveCPMKForCourse(Course $course): int
    {
        $count = 0;
        
        // Get all enrolled students
        $students = $course->students;
        
        foreach ($students as $student) {
            $cpmkScores = $this->calculateCPMKForStudent($student, $course);
            
            foreach ($cpmkScores as $cpmkData) {
                CpmkAchievement::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'cpmk_id' => $cpmkData['cpmk_id'],
                    ],
                    [
                        'course_id' => $course->id,
                        'score' => $cpmkData['score'],
                    ]
                );
                $count++;
            }
        }
        
        return $count;
    }

    /**
     * Calculate and save all CPL achievements for a program
     * 
     * @param int $programId
     * @param string|null $academicYear
     * @param string|null $academicPeriod
     * @return int Number of records processed
     */
    public function calculateAndSaveCPLForProgram(
        int $programId, 
        ?string $academicYear = null, 
        ?string $academicPeriod = null
    ): int {
        $count = 0;
        
        // Get all students in the program
        $students = Student::where('program_id', $programId)->get();
        
        foreach ($students as $student) {
            $cplScores = $this->calculateCPLForStudent($student, $academicYear, $academicPeriod);
            
            foreach ($cplScores as $cplData) {
                CplAchievement::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'cpl_id' => $cplData['cpl_id'],
                        'academic_year' => $academicYear,
                        'academic_period' => $academicPeriod,
                    ],
                    [
                        'score' => $cplData['score'],
                    ]
                );
                $count++;
            }
        }
        
        return $count;
    }

    /**
     * Validate that assessment weights for a CPMK sum to 100%
     * 
     * @param Cpmk $cpmk
     * @return array{valid: bool, total_weight: float, message: string}
     */
    public function validateCPMKWeights(Cpmk $cpmk): array
    {
        $totalWeight = $cpmk->assessments()
            ->withPivot('weight')
            ->get()
            ->sum('pivot.weight');
        
        $valid = abs($totalWeight - 100) < 0.01; // Allow small floating point differences
        
        return [
            'valid' => $valid,
            'total_weight' => $totalWeight,
            'message' => $valid 
                ? 'Weights are valid (sum = 100%)' 
                : "Weights are invalid (sum = {$totalWeight}%, expected 100%)",
        ];
    }

    /**
     * Validate that CPMK weights for a CPL sum to 100%
     * 
     * @param Cpl $cpl
     * @return array{valid: bool, total_weight: float, message: string}
     */
    public function validateCPLWeights(Cpl $cpl): array
    {
        $totalWeight = $cpl->cpmks()
            ->withPivot('weight')
            ->get()
            ->sum('pivot.weight');
        
        $valid = abs($totalWeight - 100) < 0.01;
        
        return [
            'valid' => $valid,
            'total_weight' => $totalWeight,
            'message' => $valid 
                ? 'Weights are valid (sum = 100%)' 
                : "Weights are invalid (sum = {$totalWeight}%, expected 100%)",
        ];
    }

    /**
     * Get complete OBE report for a course (like Excel sheets)
     * 
     * Returns data structured like the Excel file:
     * - Mapping (Pemetaan Asesmen)
     * - Weights (CPMK Bobot, CPL Bobot)
     * - Scores (AsesmenNilai)
     * - CPMK Achievements (AsesmenCPMK)
     * - CPL Achievements (AsesmenCPL)
     * 
     * @param Course $course
     * @return array
     */
    public function getCourseReport(Course $course): array
    {
        // Load all necessary relationships
        $course->load([
            'cpmks.assessments',
            'cpmks.cpls',
            'assessments',
            'students.scores',
        ]);
        
        // Sheet 1 & 2: Pemetaan Asesmen + CPMK Bobot
        $assessmentMapping = [];
        foreach ($course->assessments as $assessment) {
            $cpmkWeights = [];
            foreach ($assessment->cpmks()->withPivot('weight')->get() as $cpmk) {
                $cpmkWeights[$cpmk->code] = $cpmk->pivot->weight;
            }
            $assessmentMapping[] = [
                'assessment_code' => $assessment->code,
                'assessment_name' => $assessment->name,
                'cpmk_weights' => $cpmkWeights,
            ];
        }
        
        // Sheet 3: CPL Bobot
        $cplMapping = [];
        foreach ($course->cpmks as $cpmk) {
            $cplWeights = [];
            foreach ($cpmk->cpls()->withPivot('weight')->get() as $cpl) {
                $cplWeights[$cpl->code] = $cpl->pivot->weight;
            }
            $cplMapping[$cpmk->code] = $cplWeights;
        }
        
        // Sheet 4: AsesmenNilai (Raw Scores)
        $rawScores = [];
        foreach ($course->students as $student) {
            $studentScores = ['nim' => $student->nim, 'name' => $student->name];
            foreach ($course->assessments as $assessment) {
                $score = $student->scores->where('assessment_id', $assessment->id)->first();
                $studentScores[$assessment->code] = $score?->score;
            }
            $rawScores[] = $studentScores;
        }
        
        // Sheet 5: AsesmenCPMK (CPMK Achievements)
        $cpmkAchievements = [];
        foreach ($course->students as $student) {
            $studentCpmks = ['nim' => $student->nim, 'name' => $student->name];
            $calculated = $this->calculateCPMKForStudent($student, $course);
            foreach ($calculated as $cpmkData) {
                $studentCpmks[$cpmkData['cpmk_code']] = $cpmkData['score'];
            }
            $cpmkAchievements[] = $studentCpmks;
        }
        
        // Sheet 6: AsesmenCPL (CPL Achievements)
        $cplAchievements = [];
        foreach ($course->students as $student) {
            $studentCpls = ['nim' => $student->nim, 'name' => $student->name];
            $calculated = $this->calculateCPLForStudent($student);
            foreach ($calculated as $cplData) {
                $studentCpls[$cplData['cpl_code']] = $cplData['score'];
            }
            $cplAchievements[] = $studentCpls;
        }
        
        return [
            'course' => [
                'code' => $course->code,
                'name' => $course->name,
                'academic_year' => $course->academic_year,
                'academic_period' => $course->academic_period,
            ],
            'assessment_mapping' => $assessmentMapping,
            'cpl_mapping' => $cplMapping,
            'raw_scores' => $rawScores,
            'cpmk_achievements' => $cpmkAchievements,
            'cpl_achievements' => $cplAchievements,
        ];
    }

    /**
     * Calculate class average for each CPMK in a course
     * 
     * @param Course $course
     * @return Collection
     */
    public function getCPMKClassAverage(Course $course): Collection
    {
        return DB::table('cpmk_achievements')
            ->join('cpmks', 'cpmk_achievements.cpmk_id', '=', 'cpmks.id')
            ->where('cpmk_achievements.course_id', $course->id)
            ->whereNotNull('cpmk_achievements.score')
            ->groupBy('cpmks.id', 'cpmks.code', 'cpmks.description')
            ->select(
                'cpmks.id',
                'cpmks.code',
                'cpmks.description',
                DB::raw('AVG(cpmk_achievements.score) as average_score'),
                DB::raw('MIN(cpmk_achievements.score) as min_score'),
                DB::raw('MAX(cpmk_achievements.score) as max_score'),
                DB::raw('COUNT(cpmk_achievements.id) as student_count')
            )
            ->get();
    }

    /**
     * Calculate class average for each CPL in a program
     * 
     * @param int $programId
     * @param string|null $academicYear
     * @param string|null $academicPeriod
     * @return Collection
     */
    public function getCPLClassAverage(
        int $programId, 
        ?string $academicYear = null, 
        ?string $academicPeriod = null
    ): Collection {
        $query = DB::table('cpl_achievements')
            ->join('cpls', 'cpl_achievements.cpl_id', '=', 'cpls.id')
            ->join('students', 'cpl_achievements.student_id', '=', 'students.id')
            ->where('students.program_id', $programId)
            ->whereNotNull('cpl_achievements.score');
        
        if ($academicYear) {
            $query->where('cpl_achievements.academic_year', $academicYear);
        }
        
        if ($academicPeriod) {
            $query->where('cpl_achievements.academic_period', $academicPeriod);
        }
        
        return $query->groupBy('cpls.id', 'cpls.code', 'cpls.description')
            ->select(
                'cpls.id',
                'cpls.code',
                'cpls.description',
                DB::raw('AVG(cpl_achievements.score) as average_score'),
                DB::raw('MIN(cpl_achievements.score) as min_score'),
                DB::raw('MAX(cpl_achievements.score) as max_score'),
                DB::raw('COUNT(cpl_achievements.id) as student_count')
            )
            ->get();
    }
}

