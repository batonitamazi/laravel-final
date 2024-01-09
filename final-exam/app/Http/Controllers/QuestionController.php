<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;


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
        ]);

        $quiz = Quiz::findOrFail($request->input('quiz_id'));
        $user = auth()->user();
        
        $question = $quiz->questions()->create([
            'question' => $request->input('question'),
            'answer1' => $request->input('answer1'),
            'answer2' => $request->input('answer2'),
            'answer3' => $request->input('answer3'),
            'answer4' => $request->input('answer4'),
            'correct_answer' => $request->input('correct_answer'),
            'user_id' => $user->id
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
        ]);

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

}
