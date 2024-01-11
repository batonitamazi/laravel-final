<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $questions = Question::where('user_id', $user->id)->get();

        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        $quizzes = Quiz::all();

        return view('questions.create', ['quizzes' => $quizzes]);
    }

    public function edit(Question $question)
    {
        $quizzes = Quiz::all();
        return view('questions.edit', compact('question', 'quizzes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer1' => 'required|string',
            'answer2' => 'required|string',
            'answer3' => 'required|string',
            'answer4' => 'required|string',
            'correct_answer' => 'required|in:answer1,answer2,answer3,answer4',
            'quiz_id' => 'required|exists:quizzes,id',
            'img_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('img_url')->store('question_photos', 'public');

        $quiz = Quiz::findOrFail($request->input('quiz_id'));
        $user = auth()->user();

        $question = $quiz->questions()->create([
            'question' => $request->input('question'),
            'answer1' => $request->input('answer1'),
            'answer2' => $request->input('answer2'),
            'answer3' => $request->input('answer3'),
            'answer4' => $request->input('answer4'),
            'correct_answer' => $request->input('correct_answer'),
            'user_id' => $user->id,
            'img_url' => $imagePath,
        ]);

        return redirect()->route('question.index');
    }



    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required|string',
            'answer1' => 'required|string',
            'answer2' => 'required|string',
            'answer3' => 'required|string',
            'answer4' => 'required|string',
            'correct_answer' => 'required|in:answer1,answer2,answer3,answer4',
            'quiz_id' => 'required|exists:quizzes,id',
            'img_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('main_photo')) {
            Storage::disk('public')->delete($question->img_url);

            // Upload the new photo
            $imagePath = $request->file('main_photo')->store('quiz_photos', 'public');
            $question->update(['img_url' => $imagePath]);
        }

        $question->update([
            'question' => $request->input('question'),
            'answer1' => $request->input('answer1'),
            'answer2' => $request->input('answer2'),
            'answer3' => $request->input('answer3'),
            'answer4' => $request->input('answer4'),
            'correct_answer' => $request->input('correct_answer'),

        ]);

        return redirect()->route('question.index');
    }

    public function destroy(Question $question)
    {
        Storage::disk('public')->delete($question->img_url);
        $question->delete();
        return redirect()->route('question.index', )->with('success', 'Question deleted successfully!');
    }

}