<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Assessments = Komponen Penilaian (Quiz, UTS, UAS, Tugas, Praktikum, etc.)
     * Sheet: Pemetaan Asesmen (as rows)
     */
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('code', 50); // e.g., "Quiz1", "UTS", "UAS"
            $table->string('name'); // e.g., "Quiz 1", "Ujian Tengah Semester"
            $table->enum('type', ['quiz', 'tugas', 'uts', 'uas', 'praktikum', 'proyek', 'lainnya'])->default('lainnya');
            $table->decimal('max_score', 5, 2)->default(100.00); // Maximum possible score
            $table->timestamps();

            $table->unique(['course_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};

