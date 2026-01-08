<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Score = Raw student scores for each assessment
 * Sheet: AsesmenNilai (cell values)
 */
class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'assessment_id',
        'score',
    ];

    protected $casts = [
        'score' => 'decimal:2',
    ];

    /**
     * Get the student that owns this score
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the assessment that this score belongs to
     */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }
}

