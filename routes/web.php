<?php

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\CplController as AdminCplController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Dosen\AssessmentController;
use App\Http\Controllers\Dosen\CpmkController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\ReportController as DosenReportController;
use App\Http\Controllers\Dosen\ScoreController;
use App\Http\Controllers\Kaprodi\DashboardController as KaprodiDashboardController;
use App\Http\Controllers\Kaprodi\ReportController as KaprodiReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| OBE System Routes organized by user role:
| - Admin: Full system management
| - Dosen: Course management and score input
| - Kaprodi: View and approve reports
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        
        // Programs Management
        Route::resource('programs', ProgramController::class);
        
        // CPL Management
        Route::resource('cpls', AdminCplController::class);
        
        // Courses Management
        Route::resource('courses', AdminCourseController::class);
        
        // Users Management
        Route::resource('users', UserController::class);
        
        // Students Management
        Route::resource('students', AdminStudentController::class);
        Route::post('students/import', [AdminStudentController::class, 'import'])->name('students.import');
    });

/*
|--------------------------------------------------------------------------
| Dosen Routes
|--------------------------------------------------------------------------
*/
Route::prefix('dosen')
    ->name('dosen.')
    ->middleware(['auth', 'role:dosen,admin'])
    ->group(function () {
        
        // Dashboard
        Route::get('/', [DosenDashboardController::class, 'index'])->name('dashboard');
        
        // Course-specific routes
        Route::prefix('courses/{course}')
            ->name('courses.')
            ->middleware('owns.course')
            ->group(function () {
                
                // CPMK Management (Sheet: CPMK Bobot, CPL Bobot mapping)
                Route::resource('cpmks', CpmkController::class)->except(['show']);
                
                // Assessment Management (Sheet: Pemetaan Asesmen, CPMK Bobot)
                Route::resource('assessments', AssessmentController::class)->except(['show']);
                
                // Score Input (Sheet: AsesmenNilai)
                Route::get('scores', [ScoreController::class, 'index'])->name('scores.index');
                Route::put('scores', [ScoreController::class, 'update'])->name('scores.update');
                Route::get('scores/enroll', [ScoreController::class, 'showEnrollForm'])->name('scores.enroll');
                Route::post('scores/enroll', [ScoreController::class, 'enrollStudents'])->name('scores.enroll.store');
                Route::delete('scores/students/{student}', [ScoreController::class, 'unenrollStudent'])->name('scores.unenroll');
                
                // Reports (Sheet: AsesmenCPMK, AsesmenCPL)
                Route::get('report', [DosenReportController::class, 'show'])->name('report');
                Route::get('report/export', [DosenReportController::class, 'export'])->name('report.export');
                Route::post('report/recalculate', [DosenReportController::class, 'recalculate'])->name('report.recalculate');
            });
    });

/*
|--------------------------------------------------------------------------
| Kaprodi Routes
|--------------------------------------------------------------------------
*/
Route::prefix('kaprodi')
    ->name('kaprodi.')
    ->middleware(['auth', 'role:kaprodi,admin'])
    ->group(function () {
        
        // Dashboard
        Route::get('/', [KaprodiDashboardController::class, 'index'])->name('dashboard');
        
        // CPL Reports
        Route::get('reports/cpl', [KaprodiReportController::class, 'cplReport'])->name('reports.cpl');
        Route::get('reports/cpl/students', [KaprodiReportController::class, 'cplStudentReport'])->name('reports.cpl.students');
        Route::get('reports/cpl/export', [KaprodiReportController::class, 'exportCpl'])->name('reports.cpl.export');
        
        // Course Reports
        Route::get('reports/courses', [KaprodiReportController::class, 'courseReport'])->name('reports.courses');
        Route::get('reports/courses/{course}', [KaprodiReportController::class, 'courseDetail'])->name('reports.courses.detail');
    });

/*
|--------------------------------------------------------------------------
| Authentication Routes (Basic - can be replaced with Laravel Breeze/Jetstream)
|--------------------------------------------------------------------------
*/
Route::get('login', function () {
    return view('auth.login');
})->name('login');

Route::post('login', function () {
    $credentials = request()->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (auth()->attempt($credentials)) {
        request()->session()->regenerate();
        
        $user = auth()->user();
        
        // Redirect based on role
        return match ($user->role) {
            'admin' => redirect()->route('admin.cpls.index'),
            'kaprodi' => redirect()->route('kaprodi.dashboard'),
            'dosen' => redirect()->route('dosen.dashboard'),
            default => redirect('/'),
        };
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
})->name('login.store');

Route::post('logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    
    return redirect('/');
})->name('logout');
