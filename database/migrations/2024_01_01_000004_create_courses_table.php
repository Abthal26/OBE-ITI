<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Courses = Mata Kuliah
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('dosen_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('code', 20); // e.g., "IF101"
            $table->string('name'); // e.g., "Algoritma dan Pemrograman"
            $table->integer('sks')->default(3);
            $table->integer('semester');
            $table->string('academic_year', 20); // e.g., "2023/2024"
            $table->enum('academic_period', ['ganjil', 'genap'])->default('ganjil');
            $table->timestamps();

            $table->unique(['code', 'academic_year', 'academic_period']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};

