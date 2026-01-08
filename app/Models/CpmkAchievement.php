<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * CPMK Achievement = Calculated CPMK scores per student
 * Sheet: AsesmenCPMK (calculated values)
 * 
 * Formula (Excel Logic):
 * CPMK_Score = Σ(Assessment_Score × Assessment_Weight / 100)
 * 
 * Where:
 * - Assessment_Score = normalized score (score / max_score * 100)
 * - Assessment_Weight = weight from assessment_cpmk pivot table
 */
class CpmkAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'cpmk_id',
        'course_id',
        'score',
    ];

    protected $casts = [
        'score' => 'decimal:2',
    ];

    /**
     * Get the student that owns this achievement
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the CPMK that this achievement belongs to
     */
    public function cpmk(): BelongsTo
    {
        return $this->belongsTo(Cpmk::class);
    }

    /**
     * Get the course that this achievement belongs to
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}

