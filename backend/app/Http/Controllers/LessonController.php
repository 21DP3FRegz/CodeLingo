<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        return Lesson::all();
    }

    public function show($id)
    {
        return Lesson::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Получаем количество уроков для данного курса
        $lessonCount = Lesson::where('course_id', $validatedData['course_id'])->count();

        // Вычисляем порядковый номер нового урока
        $validatedData['lesson_order'] = $lessonCount + 1;

        return Lesson::create($validatedData);
    }

    public function update(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);

        $validatedData = $request->validate([
            'course_id' => 'exists:courses,id',
            'title' => 'string|max:255',
            'content' => 'string',
            'lesson_order' => 'integer',
        ]);

        $lesson->update($validatedData);

        return $lesson;
    }

    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();

        return response()->noContent();
    }
}
