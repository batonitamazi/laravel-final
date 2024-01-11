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
            <img src="{{ asset('storage/' . $question->img_url) }}" alt="{{ $question->name }}">
            <div class="card-body">
                <h5 class="card-title">{{ $question->question }}</h5>
                <div class="row col-md-12">
                    <a href="{{ route('question.edit', $question) }}" class="col-md-4 btn btn-primary">Edit
                        Question</a>
                    <form class="col-md-6" method="POST" action="{{ route('question.delete', $question) }}"
                        onsubmit="return confirm('Are you sure you want to delete this Question?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Quiz</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @endforeach
</div>
@endsection