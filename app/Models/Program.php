<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Program extends Model
{
    use HasFactory;

    /**
     * Default program code for single-program mode (Informatika)
     */
    public const DEFAULT_CODE = 'IF';

    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    /**
     * Get the default (Informatika) program.
     * Cached for performance.
     */
    public static function getDefault(): ?self
    {
        return Cache::rememberForever('default_program', function () {
            return self::where('code', self::DEFAULT_CODE)->first();
        });
    }

    /**
     * Get the default program ID.
     */
    public static function getDefaultId(): ?int
    {
        return self::getDefault()?->id;
    }

    /**
     * Clear the cached default program.
     */
    public static function clearDefaultCache(): void
    {
        Cache::forget('default_program');
    }

    /**
     * Get all CPLs for this program
     */
    public function cpls(): HasMany
    {
        return $this->hasMany(Cpl::class);
    }

    /**
     * Get all courses for this program
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get all students in this program
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get all users (dosen/kaprodi) in this program
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

