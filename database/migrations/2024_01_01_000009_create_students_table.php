<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Students = Mahasiswa
     * Sheet: AsesmenNilai (as rows - NIM and Nama columns)
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->string('nim', 20)->unique(); // Nomor Induk Mahasiswa
            $table->string('name');
            $table->integer('angkatan')->nullable(); // Year of enrollment
            $table->enum('status', ['aktif', 'tidak_aktif', 'lulus', 'cuti'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

