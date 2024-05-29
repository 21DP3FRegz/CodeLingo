<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserCourseController extends Controller
{
    public function index()
    {
        return UserCourse::where('user_id', Auth::id())->get();
    }

    public function show($id)
    {
        $userCourse = UserCourse::where('user_id', Auth::id())->findOrFail($id);
        return $userCourse;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => [
                'required',
                'exists:courses,id',
                Rule::unique('user_courses')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                }),
            ],
            'progress' => 'required|numeric|min:0',
        ]);

        $course = Course::with('lessons')->findOrFail($validatedData['course_id']);
        $maxLessonOrder = $course->lessons->max('lesson_order');

        if ($validatedData['progress'] > $maxLessonOrder) {
            return response()->json(['error' => 'Progress exceeds maximum lesson order'], 400);
        }

        $completionStatus = $validatedData['progress'] == $maxLessonOrder;

        $userCourse = UserCourse::create([
            'user_id' => Auth::id(),
            'course_id' => $validatedData['course_id'],
            'progress' => $validatedData['progress'],
            'completion_status' => $completionStatus,
        ]);

        return response()->json($userCourse, 201);
    }

    public function update(Request $request, $id)
    {
        $userCourse = UserCourse::where('user_id', Auth::id())->findOrFail($id);

        $validatedData = $request->validate([
            'progress' => 'required|numeric|min:0',
        ]);

        $course = Course::with('lessons')->findOrFail($userCourse->course_id);
        $maxLessonOrder = $course->lessons->max('lesson_order');

        if ($validatedData['progress'] > $maxLessonOrder) {
            return response()->json(['error' => 'Progress exceeds maximum lesson order'], 400);
        }

        $validatedData['completion_status'] = $validatedData['progress'] == $maxLessonOrder;

        $userCourse->update($validatedData);

        return response()->json($userCourse, 200);
    }

    public function destroy($id)
    {
        $userCourse = UserCourse::where('user_id', Auth::id())->findOrFail($id);
        $userCourse->delete();

        return response()->noContent();
    }
}
