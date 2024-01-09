@extends('welcome')

@section('content')
    <h1>{{ $quiz->name }}</h1>

    <!-- Display existing questions -->
    <h2>Existing Questions:</h2>
    @foreach($quiz->questions as $question)
        <div>
            <h3>{{ $question->question }}</h3>
            <p>Options: {{ $question->answer1 }}, {{ $question->answer2 }}, {{ $question->answer3 }}, {{ $question->answer4 }}</p>
        </div>
    @endforeach
    <!-- Attach question to quiz form -->
    <h2>Attach Question to Quiz:</h2>
    <form method="POST" action="{{ route('question.attachToQuiz', [$question, $quiz]) }}">
        @csrf
        <label for="question">Select a Question:</label>
        <select name="question_id" id="question">
            @foreach($questions as $availableQuestion)
                <option value="{{ $availableQuestion->id }}">{{ $availableQuestion->question }}</option>
            @endforeach
        </select>

        <button type="submit">Attach Question</button>
    </form>
@endsection
