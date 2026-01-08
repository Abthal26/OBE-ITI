<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * CPMK = Capaian Pembelajaran Mata Kuliah (Course Learning Outcomes)
     * Sheet: CPMK Bobot (as column headers)
     */
    public function up(): void
    {
        Schema::create('cpmks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('code', 20); // e.g., "CPMK1", "CPMK2"
            $table->text('description'); // Full description of the course learning outcome
            $table->timestamps();

            $table->unique(['course_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpmks');
    }
};

