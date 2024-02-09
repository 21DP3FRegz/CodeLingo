<?php

namespace App\Http\Controllers;

use App\Models\UserCourse;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userCourses = $user->courses()->with('course')->get();

        return Inertia::render('Courses/Index', [
            'userCourses' => $userCourses
        ]);
    }

    public function create(Request $request, $courseId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);

        $userCourse = UserCourse::firstOrCreate([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ], [
            'progress' => 0,
            'completion_status' => false,
        ]);

        return redirect()->route('courses.index')->with('message', 'Course started successfully!');
    }
}