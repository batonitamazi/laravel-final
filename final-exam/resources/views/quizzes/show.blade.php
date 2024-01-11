<div class="container mt-5">
    <h1>{{ $quiz->name }}</h1>
    <p id="question-info" class="mt-3"></p>
    <div id="quiz-container"></div>
    <a id="goToIndexPage" class="btn btn-primary" href="/" role="button" style="display: none;">Go Back</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let quizId = "{{ $quiz->id }}";
        let quizContainer = document.getElementById('quiz-container');
        let backBtn = document.getElementById("goToIndexPage");
        let questionInfo = document.getElementById('question-info');
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
            questionInfo.textContent = `Question ${currentQuestionIndex + 1}/` + {{{ $quiz->questions->count() }}};

        }

        function selectOption(selectedIndex, correctAnswer) {
            let correct_answer_number = correctAnswer.charAt(correctAnswer.length - 1) - 1;
            if (selectedIndex == correct_answer_number) {
                correctCount++;
            } else {
                mistakenCount++;
            }

            if (currentQuestionIndex < {{ $quiz->questions->count() }} - 1) {
                currentQuestionIndex++;
                loadQuestion(currentQuestionIndex);
            } else {
                displayResult();
            }
        }

        function displayResult() {
            quizContainer.innerHTML = `<h3>Quiz Completed! Corrected Answers are ${correctCount} mistakes ${mistakenCount} </h3>`;
            backBtn.style.display = '';
        }

        loadQuestion(currentQuestionIndex);
    });
</script>
