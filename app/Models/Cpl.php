<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * CPL = Capaian Pembelajaran Lulusan (Program Learning Outcomes)
 */
class Cpl extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'code',
        'description',
    ];

    /**
     * Get the program that owns this CPL
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get all CPMKs that contribute to this CPL
     * Pivot contains 'weight' (bobot) - from Sheet: CPL Bobot
     */
    public function cpmks(): BelongsToMany
    {
        return $this->belongsToMany(Cpmk::class, 'cpmk_cpl')
            ->withPivot('weight')
            ->withTimestamps();
    }

    /**
     * Get all CPL achievements for students
     */
    public function achievements(): HasMany
    {
        return $this->hasMany(CplAchievement::class);
    }
}

