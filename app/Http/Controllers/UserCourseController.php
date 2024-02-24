<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserCourse;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCourseController extends Controller
{
    public function create(Request $request, $courseId)
    {
        $user = auth()->user();
        $course = Course::findOrFail($courseId);

        // Check if the user already has this course
        if ($user->courses()->where('course_id', $courseId)->exists()) {
            return response()->json(['message' => 'User already has this course.']);
        }

        // Create a new user course
        UserCourse::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'progress' => 0,
            'completion_status' => false,
        ]);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
