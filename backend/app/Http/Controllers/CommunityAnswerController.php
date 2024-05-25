<?php

namespace App\Http\Controllers;

use App\Models\CommunityAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityAnswerController extends Controller
{

    public function index()
    {
        return CommunityAnswer::with('user', 'question')->get();
    }

    public function show($id)
    {
        return CommunityAnswer::with('user', 'question')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question_id' => 'required|exists:community_questions,id',
            'content' => 'required|string|max:255',
        ]);

        $answer = CommunityAnswer::create([
            'user_id' => Auth::id(),
            'question_id' => $validatedData['question_id'],
            'content' => $validatedData['content'],
        ]);

        return response()->json($answer, 201);
    }

    public function update(Request $request, $id)
    {
        $answer = CommunityAnswer::where('user_id', Auth::id())->findOrFail($id);

        $validatedData = $request->validate([
            'content' => 'string|max:255',
        ]);

        $answer->update($validatedData);

        return $answer;
    }

    public function destroy($id)
    {
        $answer = CommunityAnswer::where('user_id', Auth::id())->findOrFail($id);
        $answer->delete();

        return response()->noContent();
    }
}
