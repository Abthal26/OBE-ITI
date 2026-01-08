<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Student = Mahasiswa
 */
class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'nim',
        'name',
        'angkatan',
        'status',
    ];

    /**
     * Get the program that this student belongs to
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get all courses this student is enrolled in
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_student')
            ->withTimestamps();
    }

    /**
     * Get all scores for this student
     */
    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }

    /**
     * Get all CPMK achievements for this student
     */
    public function cpmkAchievements(): HasMany
    {
        return $this->hasMany(CpmkAchievement::class);
    }

    /**
     * Get all CPL achievements for this student
     */
    public function cplAchievements(): HasMany
    {
        return $this->hasMany(CplAchievement::class);
    }
}

