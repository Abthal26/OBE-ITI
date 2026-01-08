<?php

namespace App\Http\Middleware;

use App\Models\Course;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserOwnsCourse
{
    /**
     * Handle an incoming request.
     * Ensures that a dosen can only access their own courses.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Admin and Kaprodi can access all courses
        if ($user->isAdmin() || $user->isKaprodi()) {
            return $next($request);
        }
        
        // Get course ID from route
        $courseId = $request->route('course') ?? $request->route('id');
        
        if ($courseId) {
            $course = $courseId instanceof Course ? $courseId : Course::find($courseId);
            
            if ($course && $course->dosen_id !== $user->id) {
                abort(403, 'You do not have permission to access this course.');
            }
        }
        
        return $next($request);
    }
}

