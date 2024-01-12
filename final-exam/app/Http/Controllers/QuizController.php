<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Quiz;


class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount('questions')->latest()->get();
        return view('quizzes.index', compact('quizzes'));
    }

    public function show(Quiz $quiz)
    {
        return view('quizzes.show', compact('quiz'));
    }

    public function create()
    {
        return view('quizzes.create');
    }

    public function edit(Quiz $quiz)
    {
        return view('quizzes.edit', compact('quiz'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'main_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

           // Upload the image

        $imagePath = $request->file('main_photo')->store('quiz_photos', 'public');

        $quiz = auth()->user()->quizzes()->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'main_photo' => $imagePath,
        ]);
        return redirect()->route('quiz.index');
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'main_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $quiz->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        if ($request->hasFile('main_photo')) {
            Storage::disk('public')->delete($quiz->main_photo);

            // Upload the new photo
            $imagePath = $request->file('main_photo')->store('quiz_photos', 'public');
            $quiz->update(['main_photo' => $imagePath]);
        }

        return redirect()->route('quiz.index',)
            ->with('success', 'Quiz updated successfully!');
    }

    public function getQuestion(Quiz $quiz, $index)
    {
        $questions = $quiz->questions;

        if ($index >= 0 && $index < count($questions)) {
            $question = $questions[$index];

            // You may customize the question data you want to return
            $questionData = [
                'question' => $question->question,
                'options' => [
                    $question->answer1,
                    $question->answer2,
                    $question->answer3,
                    $question->answer4,
                ],
                'correct_answer' => $question->correct_answer,
                'img_url' => $question->img_url,
            ];

            return response()->json(['question' => $questionData]);
        }

        return response()->json(['error' => 'Question not found'], 404);
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->questions()->delete();

        Storage::disk('public')->delete($quiz->main_photo);

        $quiz->delete();

        return redirect()->route('quiz.index',)->with('success', 'Quiz deleted successfully!');
    }
}
