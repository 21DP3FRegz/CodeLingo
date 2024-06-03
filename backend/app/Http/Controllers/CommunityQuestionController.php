<?php

namespace App\Http\Controllers;

use App\Models\CommunityQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityQuestionController extends Controller
{

    public function index(Request $request)
    {
        $course_id = $request->query('course_id');

        if ($course_id) {
            $questions = CommunityQuestion::with('user', 'course')
                ->where('course_id', $course_id)
                ->get();
        } else {
            $questions = CommunityQuestion::with('user', 'course')->get();
        }

        return $questions;
    }

    public function show($id)
    {
        return CommunityQuestion::with('user', 'course')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'content' => 'required|string|max:255',
        ]);

        $question = CommunityQuestion::create([
            'user_id' => Auth::id(),
            'course_id' => $validatedData['course_id'],
            'content' => $validatedData['content'],
        ]);

        return response()->json($question, 201);
    }

    public function update(Request $request, $id)
    {
        $question = CommunityQuestion::where('user_id', Auth::id())->findOrFail($id);

        $validatedData = $request->validate([
            'content' => 'string|max:255',
        ]);

        $question->update($validatedData);

        return $question;
    }

    public function destroy($id)
    {
        $question = CommunityQuestion::where('user_id', Auth::id())->findOrFail($id);
        $question->delete();

        return response()->noContent();
    }
}
