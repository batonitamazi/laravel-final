@extends('welcome')
@section('content')
    <div class="mt-4 container-fluid col-md-6">
        <h1>Create Quiz</h1>

        <form method="POST" action="{{ route('quiz.store') }}"  id="createQuizForm" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Quiz Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>

            <div class="mb-3">
                <label for="main_photo" class="form-label">Main Photo</label>
                <input type="file" class="form-control" id="main_photo" name="main_photo" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Quiz</button>
        </form>
    </div>
    @endsection