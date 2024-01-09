@extends('welcome')

@section('content')
    <div class="mt-4 container-fluid col-md-6">
        <h1>Edit Quiz</h1>

        <form method="POST" action="{{ route('quiz.update', $quiz) }}" id="editQuizForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Quiz Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $quiz->name }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required>{{ $quiz->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="main_photo" class="form-label">Main Photo</label>
                <input type="file" class="form-control" id="main_photo" name="main_photo" accept="image/*">
                <img src="{{ asset('storage/' . $quiz->main_photo) }}" alt="{{ $quiz->name }}" class="mt-2" style="max-width: 200px;">
            </div>

            <button type="submit" class="btn btn-primary">Update Quiz</button>
        </form>
    </div>
@endsection
