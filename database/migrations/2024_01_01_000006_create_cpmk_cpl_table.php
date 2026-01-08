<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pivot table: CPMK to CPL mapping with weights
     * Sheet: CPL Bobot - defines weight of each CPMK contributing to each CPL
     * 
     * Excel Logic: Each CPMK can contribute to multiple CPLs
     * The weight represents the percentage contribution of CPMK to CPL
     */
    public function up(): void
    {
        Schema::create('cpmk_cpl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cpmk_id')->constrained()->onDelete('cascade');
            $table->foreignId('cpl_id')->constrained()->onDelete('cascade');
            $table->decimal('weight', 5, 2); // Weight/Bobot (0.00 - 100.00 or 0.00 - 1.00)
            $table->timestamps();

            $table->unique(['cpmk_id', 'cpl_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpmk_cpl');
    }
};

