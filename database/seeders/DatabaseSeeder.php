<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Course;
use App\Models\Cpl;
use App\Models\Cpmk;
use App\Models\Program;
use App\Models\Score;
use App\Models\Student;
use App\Models\User;
use App\Services\OBECalculationService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * This seeder creates sample data that mirrors the Excel file structure:
     * - Program with CPLs
     * - Course with CPMKs and Assessments
     * - Students with Scores
     * - CPMK-CPL mappings (CPL Bobot)
     * - Assessment-CPMK mappings (CPMK Bobot)
     */
    public function run(): void
    {
        // Create Program
        $program = Program::create([
            'code' => 'IF',
            'name' => 'Teknik Informatika',
            'description' => 'Program Studi Teknik Informatika',
        ]);

        // Create CPLs (Program Learning Outcomes)
        $cpls = [];
        $cplData = [
            ['code' => 'CPL1', 'description' => 'Mampu menerapkan pengetahuan matematika, sains, dan prinsip rekayasa untuk menyelesaikan masalah teknik informatika'],
            ['code' => 'CPL2', 'description' => 'Mampu merancang dan mengembangkan sistem berbasis komputer untuk memenuhi kebutuhan pengguna'],
            ['code' => 'CPL3', 'description' => 'Mampu menganalisis dan mengevaluasi sistem informasi dan teknologi'],
            ['code' => 'CPL4', 'description' => 'Mampu berkomunikasi secara efektif dalam tim multidisiplin'],
        ];
        
        foreach ($cplData as $data) {
            $cpls[$data['code']] = Cpl::create([
                'program_id' => $program->id,
                'code' => $data['code'],
                'description' => $data['description'],
            ]);
        }

        // Create Users
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@obe.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $kaprodi = User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'kaprodi@obe.test',
            'password' => Hash::make('password'),
            'role' => 'kaprodi',
            'program_id' => $program->id,
        ]);

        $dosen = User::create([
            'name' => 'Ir. Ahmad Wijaya, M.Kom',
            'email' => 'dosen@obe.test',
            'password' => Hash::make('password'),
            'role' => 'dosen',
            'program_id' => $program->id,
        ]);

        // Create Course
        $course = Course::create([
            'program_id' => $program->id,
            'dosen_id' => $dosen->id,
            'code' => 'IF201',
            'name' => 'Algoritma dan Struktur Data',
            'sks' => 3,
            'semester' => 3,
            'academic_year' => '2023/2024',
            'academic_period' => 'ganjil',
        ]);

        // Create CPMKs for the course
        $cpmks = [];
        $cpmkData = [
            ['code' => 'CPMK1', 'description' => 'Mampu memahami konsep dasar algoritma dan kompleksitas'],
            ['code' => 'CPMK2', 'description' => 'Mampu mengimplementasikan struktur data dasar (array, linked list, stack, queue)'],
            ['code' => 'CPMK3', 'description' => 'Mampu menerapkan algoritma sorting dan searching'],
            ['code' => 'CPMK4', 'description' => 'Mampu menganalisis efisiensi algoritma'],
        ];
        
        foreach ($cpmkData as $data) {
            $cpmks[$data['code']] = Cpmk::create([
                'course_id' => $course->id,
                'code' => $data['code'],
                'description' => $data['description'],
            ]);
        }

        // Create CPMK-CPL Mappings (Sheet: CPL Bobot)
        // This defines how each CPMK contributes to each CPL
        $cpmkCplMappings = [
            // CPMK1 contributes 30% to CPL1 and 20% to CPL3
            'CPMK1' => ['CPL1' => 30, 'CPL3' => 20],
            // CPMK2 contributes 25% to CPL1 and 25% to CPL2
            'CPMK2' => ['CPL1' => 25, 'CPL2' => 25],
            // CPMK3 contributes 25% to CPL2 and 25% to CPL3
            'CPMK3' => ['CPL2' => 25, 'CPL3' => 25],
            // CPMK4 contributes 20% to CPL1 and 30% to CPL3
            'CPMK4' => ['CPL1' => 20, 'CPL3' => 30],
        ];
        
        foreach ($cpmkCplMappings as $cpmkCode => $cplWeights) {
            foreach ($cplWeights as $cplCode => $weight) {
                $cpmks[$cpmkCode]->cpls()->attach($cpls[$cplCode]->id, ['weight' => $weight]);
            }
        }

        // Create Assessments
        $assessments = [];
        $assessmentData = [
            ['code' => 'Quiz1', 'name' => 'Quiz 1 - Konsep Dasar', 'type' => 'quiz', 'max_score' => 100],
            ['code' => 'Quiz2', 'name' => 'Quiz 2 - Struktur Data', 'type' => 'quiz', 'max_score' => 100],
            ['code' => 'Tugas1', 'name' => 'Tugas 1 - Implementasi Stack & Queue', 'type' => 'tugas', 'max_score' => 100],
            ['code' => 'Tugas2', 'name' => 'Tugas 2 - Algoritma Sorting', 'type' => 'tugas', 'max_score' => 100],
            ['code' => 'UTS', 'name' => 'Ujian Tengah Semester', 'type' => 'uts', 'max_score' => 100],
            ['code' => 'UAS', 'name' => 'Ujian Akhir Semester', 'type' => 'uas', 'max_score' => 100],
        ];
        
        foreach ($assessmentData as $data) {
            $assessments[$data['code']] = Assessment::create([
                'course_id' => $course->id,
                'code' => $data['code'],
                'name' => $data['name'],
                'type' => $data['type'],
                'max_score' => $data['max_score'],
            ]);
        }

        // Create Assessment-CPMK Mappings (Sheet: CPMK Bobot)
        // This defines how each assessment contributes to each CPMK
        // Sum of weights per CPMK should be 100%
        $assessmentCpmkMappings = [
            'Quiz1' => ['CPMK1' => 20],
            'Quiz2' => ['CPMK2' => 20],
            'Tugas1' => ['CPMK2' => 30],
            'Tugas2' => ['CPMK3' => 30],
            'UTS' => ['CPMK1' => 40, 'CPMK2' => 25, 'CPMK3' => 35, 'CPMK4' => 40],
            'UAS' => ['CPMK1' => 40, 'CPMK2' => 25, 'CPMK3' => 35, 'CPMK4' => 60],
        ];
        
        foreach ($assessmentCpmkMappings as $assessmentCode => $cpmkWeights) {
            foreach ($cpmkWeights as $cpmkCode => $weight) {
                $assessments[$assessmentCode]->cpmks()->attach($cpmks[$cpmkCode]->id, ['weight' => $weight]);
            }
        }

        // Create Students
        $students = [];
        $studentData = [
            ['nim' => '2023001', 'name' => 'Andi Pratama', 'angkatan' => 2023],
            ['nim' => '2023002', 'name' => 'Budi Setiawan', 'angkatan' => 2023],
            ['nim' => '2023003', 'name' => 'Citra Dewi', 'angkatan' => 2023],
            ['nim' => '2023004', 'name' => 'Dian Pertiwi', 'angkatan' => 2023],
            ['nim' => '2023005', 'name' => 'Eko Prasetyo', 'angkatan' => 2023],
            ['nim' => '2023006', 'name' => 'Fitri Handayani', 'angkatan' => 2023],
            ['nim' => '2023007', 'name' => 'Gilang Ramadhan', 'angkatan' => 2023],
            ['nim' => '2023008', 'name' => 'Hendra Wijaya', 'angkatan' => 2023],
            ['nim' => '2023009', 'name' => 'Indah Sari', 'angkatan' => 2023],
            ['nim' => '2023010', 'name' => 'Joko Santoso', 'angkatan' => 2023],
        ];
        
        foreach ($studentData as $data) {
            $students[$data['nim']] = Student::create([
                'program_id' => $program->id,
                'nim' => $data['nim'],
                'name' => $data['name'],
                'angkatan' => $data['angkatan'],
                'status' => 'aktif',
            ]);
        }

        // Enroll students in the course
        foreach ($students as $student) {
            $course->students()->attach($student->id);
        }

        // Create Scores (Sheet: AsesmenNilai)
        // Sample scores that mirror Excel data
        $scoreData = [
            '2023001' => ['Quiz1' => 85, 'Quiz2' => 78, 'Tugas1' => 90, 'Tugas2' => 88, 'UTS' => 75, 'UAS' => 80],
            '2023002' => ['Quiz1' => 70, 'Quiz2' => 75, 'Tugas1' => 82, 'Tugas2' => 78, 'UTS' => 68, 'UAS' => 72],
            '2023003' => ['Quiz1' => 92, 'Quiz2' => 88, 'Tugas1' => 95, 'Tugas2' => 90, 'UTS' => 85, 'UAS' => 88],
            '2023004' => ['Quiz1' => 65, 'Quiz2' => 70, 'Tugas1' => 75, 'Tugas2' => 72, 'UTS' => 60, 'UAS' => 65],
            '2023005' => ['Quiz1' => 88, 'Quiz2' => 82, 'Tugas1' => 85, 'Tugas2' => 88, 'UTS' => 78, 'UAS' => 82],
            '2023006' => ['Quiz1' => 78, 'Quiz2' => 80, 'Tugas1' => 88, 'Tugas2' => 85, 'UTS' => 72, 'UAS' => 76],
            '2023007' => ['Quiz1' => 55, 'Quiz2' => 60, 'Tugas1' => 70, 'Tugas2' => 65, 'UTS' => 50, 'UAS' => 55],
            '2023008' => ['Quiz1' => 95, 'Quiz2' => 92, 'Tugas1' => 98, 'Tugas2' => 95, 'UTS' => 90, 'UAS' => 92],
            '2023009' => ['Quiz1' => 72, 'Quiz2' => 68, 'Tugas1' => 78, 'Tugas2' => 75, 'UTS' => 65, 'UAS' => 70],
            '2023010' => ['Quiz1' => 82, 'Quiz2' => 85, 'Tugas1' => 88, 'Tugas2' => 82, 'UTS' => 75, 'UAS' => 78],
        ];
        
        foreach ($scoreData as $nim => $scores) {
            foreach ($scores as $assessmentCode => $scoreValue) {
                Score::create([
                    'student_id' => $students[$nim]->id,
                    'assessment_id' => $assessments[$assessmentCode]->id,
                    'score' => $scoreValue,
                ]);
            }
        }

        // Calculate achievements using the service
        $calculationService = new OBECalculationService();
        
        // Calculate CPMK achievements (Sheet: AsesmenCPMK)
        $calculationService->calculateAndSaveCPMKForCourse($course);
        
        // Calculate CPL achievements (Sheet: AsesmenCPL)
        $calculationService->calculateAndSaveCPLForProgram(
            $program->id,
            $course->academic_year,
            $course->academic_period
        );

        $this->command->info('Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Test Accounts:');
        $this->command->info('  Admin: admin@obe.test / password');
        $this->command->info('  Kaprodi: kaprodi@obe.test / password');
        $this->command->info('  Dosen: dosen@obe.test / password');
    }
}
