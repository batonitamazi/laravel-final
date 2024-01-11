@extends('welcome')

@section('content')
    <h1 class="mt-4">Questions</h1>
    @auth
        <div class="mt-4">
            <a href="{{ route('question.create') }}" class="btn btn-primary">Create Question</a>
        </div>
    @endauth
    <div class="row mt-4">
    @foreach($questions as $question)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $question->question }}</h5>
                    <p class="card-text">Options: {{ $question->answer1 }}, {{ $question->answer2 }}, {{ $question->answer3 }}, {{ $question->answer4 }}</p>
                    <a href="{{ route('question.edit', $question) }}" class="btn btn-primary">Edit Question</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection