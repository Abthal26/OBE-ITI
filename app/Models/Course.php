<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Course = Mata Kuliah
 */
class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'dosen_id',
        'code',
        'name',
        'sks',
        'semester',
        'academic_year',
        'academic_period',
    ];

    /**
     * Get the program that owns this course
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the dosen (lecturer) assigned to this course
     */
    public function dosen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    /**
     * Get all CPMKs for this course
     */
    public function cpmks(): HasMany
    {
        return $this->hasMany(Cpmk::class);
    }

    /**
     * Get all assessments for this course
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    /**
     * Get all students enrolled in this course
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'course_student')
            ->withTimestamps();
    }

    /**
     * Get all CPMK achievements for this course
     */
    public function cpmkAchievements(): HasMany
    {
        return $this->hasMany(CpmkAchievement::class);
    }
}

