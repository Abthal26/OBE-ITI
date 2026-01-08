<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * CPMK = Capaian Pembelajaran Mata Kuliah (Course Learning Outcomes)
 */
class Cpmk extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'code',
        'description',
    ];

    /**
     * Get the course that owns this CPMK
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get all CPLs that this CPMK contributes to
     * Pivot contains 'weight' (bobot) - from Sheet: CPL Bobot
     */
    public function cpls(): BelongsToMany
    {
        return $this->belongsToMany(Cpl::class, 'cpmk_cpl')
            ->withPivot('weight')
            ->withTimestamps();
    }

    /**
     * Get all assessments that contribute to this CPMK
     * Pivot contains 'weight' (bobot) - from Sheet: CPMK Bobot
     */
    public function assessments(): BelongsToMany
    {
        return $this->belongsToMany(Assessment::class, 'assessment_cpmk')
            ->withPivot('weight')
            ->withTimestamps();
    }

    /**
     * Get all CPMK achievements for students
     */
    public function achievements(): HasMany
    {
        return $this->hasMany(CpmkAchievement::class);
    }
}

