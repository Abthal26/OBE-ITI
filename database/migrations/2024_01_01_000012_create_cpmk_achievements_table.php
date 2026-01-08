<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * CPMK Achievements = Calculated CPMK scores per student
     * Sheet: AsesmenCPMK (calculated values)
     * 
     * This is a CALCULATED table (can be cached for performance)
     * Formula: CPMK_Score = Σ(Assessment_Score × Assessment_Weight / 100)
     */
    public function up(): void
    {
        Schema::create('cpmk_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('cpmk_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->decimal('score', 5, 2)->nullable(); // Calculated CPMK score
            $table->timestamps();

            $table->unique(['student_id', 'cpmk_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpmk_achievements');
    }
};

