<!-- @foreach($quiz->questions as $question)
    <div>
        <h2>{{ $question->question }}</h2>
        <p>Answers: {{ $question->answer1 }}, {{ $question->answer2 }}, {{ $question->answer3 }}, {{ $question->answer4 }}</p>
    </div>
@endforeach -->
<div class="container mt-5">
    <h1>{{ $quiz->name }}</h1>
    <div id="quiz-container">
        <!-- Questions and options will be loaded here dynamically -->
    </div>
    <a id="goToIndexPage" class="btn btn-primary" href="/" role="button" style="display: none;">Go Back</a>
</div>
<script>
        document.addEventListener('DOMContentLoaded', function () {
        let quizId = "{{ $quiz->id }}";
        let quizContainer = document.getElementById('quiz-container');
        let backBtn = document.getElementById("goToIndexPage");
        let currentQuestionIndex = 0;
        let correctCount = 0;
        let mistakenCount = 0
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
            const questionCard = document.createElement('div');
            questionCard.classList.add('card', 'mt-4');
            questionCard.innerHTML = `
                <div class="card-body">
                    <h5 class="card-title">${question.question}</h5>
                    <div class="list-group">
                        ${question.options.map((option, index) => `
                            <button type="button" class="list-group-item list-group-item-action">
                                ${option}
                            </button>
                        `).join('')}
                    </div>
                </div>
            `;

            quizContainer.innerHTML = '';
            quizContainer.appendChild(questionCard);

            // Add a click event listener to all buttons in the list-group
            const buttons = questionCard.querySelectorAll('.list-group-item');
            buttons.forEach((button, index) => {
                button.addEventListener('click', function () {
                    selectOption(index, question.correct_answer);
                });
            });
        }

        function selectOption(selectedIndex, correctAnswer) {
            console.log(selectedIndex, correctAnswer)
            let correct_answer_number = correctAnswer.charAt(correctAnswer.length - 1) - 1;
            if (selectedIndex == correct_answer_number) {
                correctCount++;
            } else {
                mistakenCount++;
            }

            if (currentQuestionIndex < {{ $quiz->questions->count() }} - 1 ) {
                currentQuestionIndex++;
                loadQuestion(currentQuestionIndex);
            } else {
                displayResult();
            }
        }

        loadQuestion(currentQuestionIndex);
        function displayResult(){
            quizContainer.innerHTML = `<h3>Quiz Completed! Corrected Answers are ${correctCount}  mistakes ${mistakenCount} or Redirect </h3>`;
            backBtn.style.display = '';
        }
        // quizContainer.addEventListener('click', function (event) {
        //     if (event.target.tagName === 'BUTTON') {
        //         setTimeout(function () {
        //             currentQuestionIndex++;

        //             if (currentQuestionIndex < {{ $quiz->questions->count() }}) {
        //                 loadQuestion(currentQuestionIndex);
        //             } else {
        //                 quizContainer.innerHTML = `<h3>Quiz Completed! Corrected Answers are ${correctCount}  mistakes ${mistakenCount} or Redirect </h3>`;
        //             }
        //         }, 1000);
        //     }
        // });
    }); 
</script>