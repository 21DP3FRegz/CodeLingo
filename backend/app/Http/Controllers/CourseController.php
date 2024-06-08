<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return Course::all();
    }

    public function show($id)
    {
        return Course::with('lessons')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_name' => 'required|string|max:255|unique:courses',
            'description' => 'required|string',
            'language' => 'sometimes|string|max:255',
        ]);

        return Course::create($validatedData);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'course_name' => 'string|max:255|unique:courses',
            'description' => 'string',
            'language' => 'string|max:255',
        ]);

        $course = Course::findOrFail($id);
        $course->update($validatedData);

        return $course;
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->noContent();
    }
}
