<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class VerifyPurchasedCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $course = $request->route('course');
        
        if (!$course) {
            abort(404);
        }
        
        // Check if course is owned by the user
        $userOwnsCourse = User::find(Auth::id())->courses()
            ->where('courses.id', $course->id)
            ->exists();
            
        if (!$userOwnsCourse) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'You need to purchase this course to access it.');
        }
        
        return $next($request);
    }
}