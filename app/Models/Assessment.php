<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Assessment = Komponen Penilaian (Quiz, UTS, UAS, Tugas, etc.)
 */
class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'code',
        'name',
        'type',
        'max_score',
    ];

    protected $casts = [
        'max_score' => 'decimal:2',
    ];

    /**
     * Get the course that owns this assessment
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get all CPMKs that this assessment contributes to
     * Pivot contains 'weight' (bobot) - from Sheet: CPMK Bobot
     */
    public function cpmks(): BelongsToMany
    {
        return $this->belongsToMany(Cpmk::class, 'assessment_cpmk')
            ->withPivot('weight')
            ->withTimestamps();
    }

    /**
     * Get all scores for this assessment
     */
    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}

