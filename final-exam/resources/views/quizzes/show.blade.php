<h1>{{ $quiz->name }}</h1>
@foreach($quiz->questions as $question)
    <div>
        <h2>{{ $question->question }}</h2>
        <p>Answers: {{ $question->answer1 }}, {{ $question->answer2 }}, {{ $question->answer3 }}, {{ $question->answer4 }}</p>
    </div>
@endforeach