<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dosen dashboard with their courses.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $courses = Course::where('dosen_id', $user->id)
            ->withCount(['students', 'cpmks', 'assessments'])
            ->orderBy('academic_year', 'desc')
            ->orderBy('academic_period')
            ->get();
        
        return view('dosen.dashboard', compact('courses'));
    }
}

