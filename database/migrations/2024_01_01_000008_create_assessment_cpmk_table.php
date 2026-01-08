<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pivot table: Assessment to CPMK mapping with weights
     * Sheet: CPMK Bobot - defines weight of each assessment contributing to each CPMK
     * 
     * Excel Logic: Each assessment can contribute to multiple CPMKs
     * The weight represents the percentage contribution of assessment to CPMK
     * Sum of weights for all assessments per CPMK should equal 100%
     */
    public function up(): void
    {
        Schema::create('assessment_cpmk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->foreignId('cpmk_id')->constrained()->onDelete('cascade');
            $table->decimal('weight', 5, 2); // Weight/Bobot (0.00 - 100.00)
            $table->timestamps();

            $table->unique(['assessment_id', 'cpmk_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_cpmk');
    }
};

