<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * CPL Achievement = Final CPL scores per student
 * Sheet: AsesmenCPL (calculated values)
 * 
 * Formula (Excel Logic):
 * CPL_Score = Σ(CPMK_Score × CPMK_Weight / 100)
 * 
 * Where:
 * - CPMK_Score = calculated CPMK achievement score
 * - CPMK_Weight = weight from cpmk_cpl pivot table
 */
class CplAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'cpl_id',
        'score',
        'academic_year',
        'academic_period',
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
     * Get the CPL that this achievement belongs to
     */
    public function cpl(): BelongsTo
    {
        return $this->belongsTo(Cpl::class);
    }
}

