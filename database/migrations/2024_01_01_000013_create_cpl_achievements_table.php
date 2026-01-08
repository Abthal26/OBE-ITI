<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * CPL Achievements = Final CPL scores per student
     * Sheet: AsesmenCPL (calculated values)
     * 
     * This is a CALCULATED table (can be cached for performance)
     * Formula: CPL_Score = Σ(CPMK_Score × CPMK_Weight / 100)
     */
    public function up(): void
    {
        Schema::create('cpl_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('cpl_id')->constrained()->onDelete('cascade');
            $table->decimal('score', 5, 2)->nullable(); // Calculated CPL score
            $table->string('academic_year', 20)->nullable();
            $table->enum('academic_period', ['ganjil', 'genap'])->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'cpl_id', 'academic_year', 'academic_period'], 'student_cpl_period_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpl_achievements');
    }
};

