<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * CPL = Capaian Pembelajaran Lulusan (Program Learning Outcomes)
     * Sheet: CPL Bobot (as column headers)
     */
    public function up(): void
    {
        Schema::create('cpls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->string('code', 20); // e.g., "CPL1", "CPL2"
            $table->text('description'); // Full description of the learning outcome
            $table->timestamps();

            $table->unique(['program_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpls');
    }
};

