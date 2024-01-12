@extends('welcome')
@section('content')
<div class="container mt-5">
        <h1>{{ $quiz->name }}</h1>
        <p id="question-info" class="mt-3"></p>

        <div class="card mt-4" id="quiz-card">
            <img id="question-image" src="" alt="Question Image">
            <div class="card-body">
                <h5 class="card-title" id="question-title"></h5>
                <div class="list-group" id="options-list"></div>
            </div>
        </div>

        <a id="goToIndexPage" class="btn btn-primary" href="/" role="button" style="display: none;">Go Back</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let quizId = "{{ $quiz->id }}";
            let questionInfo = document.getElementById('question-info');
            let questionTitle = document.getElementById('question-title');
            let questionImage = document.getElementById('question-image');
            let optionsList = document.getElementById('options-list');
            let backBtn = document.getElementById("goToIndexPage");
            let currentQuestionIndex = 0;
            let correctCount = 0;
            let mistakenCount = 0;

            function loadQuestion(index) {
                let xhr = new XMLHttpRequest();
                xhr.open('GET', `/quiz/${quizId}/question/${index}`);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        let question = JSON.parse(xhr.responseText).question;
                        displayQuestion(question);
                    }
                };
                xhr.send();
            }

            function displayQuestion(question) {
                questionTitle.textContent = question.question;
                questionImage.src = "{{ asset('storage/') }}" + '/' + question.img_url; // Update the image source
                optionsList.innerHTML = '';
                question.options.forEach((option, index) => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.classList.add('list-group-item', 'list-group-item-action');
                    button.textContent = option;

                    button.addEventListener('click', function () {
                        selectOption(index, question.correct_answer);
                    });

                    optionsList.appendChild(button);
                });

                questionInfo.textContent = `Question ${currentQuestionIndex + 1}/${{$quiz->questions->count()}}`;
            }

            function selectOption(selectedIndex, correctAnswer) {
                let correct_answer_number = correctAnswer.charAt(correctAnswer.length - 1) - 1;
                if (selectedIndex == correct_answer_number) {
                    correctCount++;
                } else {
                    mistakenCount++;
                }
                if (currentQuestionIndex < {{$quiz->questions->count()}} - 1) {
                    currentQuestionIndex++;
                    loadQuestion(currentQuestionIndex);
                } else {
                    displayResult();
                }
            }

            function displayResult() {
                document.getElementById('quiz-card').style.display = 'none';
                questionInfo.textContent = `Quiz Completed! Correct Answers: ${correctCount}, Mistakes: ${mistakenCount}`;
                backBtn.style.display = '';
            }

            loadQuestion(currentQuestionIndex);
        });
    </script>
@endsection
