<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TestController extends Controller
{
    public function index()
    {
        return Test::all();
    }

    public function show($id)
    {
        return Test::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'question' => [
                'required',
                'string',
                Rule::unique('tests')->where(function ($query) use ($request) {
                    return $query->where('lesson_id', $request->lesson_id);
                }),
            ],
            'options' => 'required|array',
            'correct_answer' => 'required|integer',
        ]);

        return Test::create($validatedData);
    }

    public function update(Request $request, $id)
    {
        $test = Test::findOrFail($id);

        $validatedData = $request->validate([
            'lesson_id' => 'exists:lessons,id',
            'question' => 'string',
            'options' => 'array',
            'correct_answer' => 'integer',
        ]);

        $test->update($validatedData);

        return $test;
    }

    public function destroy($id)
    {
        $test = Test::findOrFail($id);
        $test->delete();

        return response()->noContent();
    }
}
