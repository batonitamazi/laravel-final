@extends('welcome')

@section('content')
    <h1 class="mt-4">Edit Question</h1>

    <form method="POST" action="{{ route('question.update', $question) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="question" class="form-label">Question</label>
            <textarea class="form-control" id="question" name="question" rows="3" required>{{ $question->question }}</textarea>
        </div>

        <div class="mb-3">
            <label for="answer1" class="form-label">Option 1</label>
            <input type="text" class="form-control" id="answer1" name="answer1" value="{{ $question->answer1 }}" required>
        </div>

        <div class="mb-3">
            <label for="answer2" class="form-label">Option 2</label>
            <input type="text" class="form-control" id="answer2" name="answer2" value="{{ $question->answer2 }}" required>
        </div>

        <div class="mb-3">
            <label for="answer3" class="form-label">Option 3</label>
            <input type="text" class="form-control" id="answer3" name="answer3" value="{{ $question->answer3 }}" required>
        </div>

        <div class="mb-3">
            <label for="answer4" class="form-label">Option 4</label>
            <input type="text" class="form-control" id="answer4" name="answer4" value="{{ $question->answer4 }}" required>
        </div>

        <div class="mb-3">
            <label for="correct_answer" class="form-label">Correct Answer</label>
            <select class="form-select" id="correct_answer" name="correct_answer" required>
                <option value="answer1" {{ $question->correct_answer == 'answer1' ? 'selected' : '' }}>Option 1</option>
                <option value="answer2" {{ $question->correct_answer == 'answer2' ? 'selected' : '' }}>Option 2</option>
                <option value="answer3" {{ $question->correct_answer == 'answer3' ? 'selected' : '' }}>Option 3</option>
                <option value="answer4" {{ $question->correct_answer == 'answer4' ? 'selected' : '' }}>Option 4</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="quiz_id" class="form-label">Select a Quiz</label>
            <select class="form-select" id="quiz_id" name="quiz_id" required>
                @foreach($quizzes as $quiz)
                    <option value="{{ $quiz->id }}" {{ $question->quiz_id == $quiz->id ? 'selected' : '' }}>{{ $quiz->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Question</button>
    </form>
@endsection
