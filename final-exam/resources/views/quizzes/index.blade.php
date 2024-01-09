@extends('welcome')

@section('content')
    <h1 class="mt-4">Quizzes</h1>
    @auth
        <div class="mt-4">
            <a href="{{ route('quiz.create') }}" class="btn btn-primary">Create Quiz</a>
        </div>
    @endauth
    <div class="row mt-4">
        @foreach($quizzes as $quiz)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $quiz->main_photo) }}" alt="{{ $quiz->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $quiz->name }}</h5>
                        <p class="card-text">{{ $quiz->description }}</p>
                        <p class="card-text">Author: {{ $quiz->author->name }}</p>
                        @auth
                            @if(auth()->user()->id == $quiz->author->id)
                                <a href="{{ route('quiz.edit', $quiz) }}" class="btn btn-primary">Edit Quiz</a>
                            @else
                                <a href="{{ route('quiz.show', $quiz) }}" class="btn btn-primary">Start Quiz</a>
                            @endif
                        @else
                            <a href="{{ route('quiz.show', $quiz) }}" class="btn btn-primary">Start Quiz</a>
                        @endauth
                        
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
