@extends('layouts.app')

@section('content')
    <main class="flex flex-col gap-14 py-10 container mx-auto max-w-[1280px] px-4">
        <div id="tabs" class="flex gap-6 max-lg:flex-col">
            <ul class="flex flex-col gap-2 w-full lg:w-1/3">
                <li class="w-fit">
                    <a href="{{ route('profile') }}" class="flex items-center gap-2 py-2">
                        <div class="flex items-center justify-center w-10 h-10 p-2 bg-black/10 rounded-full">
                            <img src="{{ asset('Images/header/profile.png') }}" alt="">
                        </div>
                        <span>Мои данные</span>
                    </a>
                </li>
                @if (Auth::user() and Auth::user()->is_admin == 1)
                    <li class="w-fit">
                        <a href="{{ route('Admin') }}" class="flex items-center gap-2 py-2">
                            <div class="flex items-center justify-center w-10 h-10 p-2 bg-black/10 rounded-full">
                                <img src="{{ asset('Images/header/profile.png') }}" alt="">
                            </div>
                            <span>Админ</span>
                        </a>
                    </li>
                @endif
            
                <li class="w-fit">
                    <button class="flex items-center gap-2 py-2" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        <div class="flex items-center justify-center w-10 h-10 p-2 bg-black/10 rounded-full">
                            <img src="{{ asset('Images/header/logout.png') }}" alt="">
                        </div>
                        <span>Выйти</span>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                    </button>
                </li>
            </ul>
            <div id="tab-1" class="w-full lg:w-2/3 flex flex-col gap-6">
    <p class="text-3xl font-PoiretOne uppercase">{{ $quiz->title ?? 'New Quiz' }}</p>
    <form id="testForm" method="POST" action="{{ route('addQuestions') }}">
        @csrf
        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

        <div id="questionContainer">
        @foreach ($quiz->questions as $index => $question)
            <div class="question-item flex items-center max-md:flex-col gap-4 w-full mb-4" data-index="{{ $index }}">
                <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">
                <label for="question_{{ $index }}">Вопрос:</label>
                <input type="text" name="questions[{{ $index }}][question_text]" value="{{ $question->question_text }}" data-question-id="{{ $question->id }}" class="w-full md:w-1/2 rounded-xl border border-black/10 focus:outline-none px-4 py-2">
                <label for="answer_{{ $index }}">Ответ:</label>
                <input type="text" name="questions[{{ $index }}][correct_answer]" value="{{ $question->correct_answer }}" class="w-full md:w-1/2 rounded-xl border border-black/10 focus:outline-none px-4 py-2">
                <a href="deleteQuestion/{{ $question->id }}" class="removeQuestionLink" data-question-id="{{ $question->id }}">Удалить</a>            </div>
        @endforeach
   
        </div>

        <button type="button" id="addQuestionBtn" class="px-4 py-2 rounded-xl border border-black bg-black text-white transition-all duration-500 hover:text-black hover:bg-transparent text-center font-PoiretOne">Добавить новый вопрос</button>
        <button type="submit" class="px-4 py-2 rounded-xl border border-black bg-black text-white transition-all duration-500 hover:text-black hover:bg-transparent text-center font-PoiretOne">Сохранить вопрос</button>
    </form>
</div>

<script>
let questionIndex = 0; // Start at 0 to align with array indices
let questionIds = {}; // Store question IDs to avoid overwriting

document.getElementById('addQuestionBtn').addEventListener('click', () => {
    const questionContainer = document.getElementById('questionContainer');
    let uniqueId = Date.now() + Math.random(); //Or use a better unique ID generator
    newQuestion = `
        <div class="question-item flex items-center max-md:flex-col gap-4 w-full mb-4" id="${uniqueId}" data-index="${questionIndex}">
            <input type="hidden" name="questions[${questionIndex}][id]" value="">
            <label for="question_${questionIndex}">Вопрос:</label>
            <input type="text" name="questions[${questionIndex}][question_text]" class="w-full md:w-1/2 rounded-xl border border-black/10 focus:outline-none px-4 py-2" placeholder="Вопрос">
            <label for="answer_${questionIndex}">Ответ:</label>
            <input type="text" name="questions[${questionIndex}][correct_answer]" class="w-full md:w-1/2 rounded-xl border border-black/10 focus:outline-none px-4 py-2" placeholder="Ответ">
        
        </div>
    `;

    questionContainer.insertAdjacentHTML('beforeend', newQuestion);
    questionIndex++;
    addRemoveButtonEventListeners();
});

function addRemoveButtonEventListeners() {
    const questionContainer = document.getElementById('questionContainer');
    questionContainer.addEventListener('click', (event) => {
        if (event.target.classList.contains('removeQuestionBtn')) {
            event.preventDefault();
            const button = event.target;
            const questionId = button.dataset.id; //Use data-id for newly added questions
            deleteQuestion(questionId);
        }
    });
}

function deleteQuestion(questionId) {
    if (!questionId) {
        console.error("Question ID is missing.");
        return;
    }

    fetch(`/deleteQuestion/${questionId}`, { //You use the same route as before
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(errorData => {
                throw new Error(`HTTP error! status: ${response.status}, message: ${errorData.message}`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            document.getElementById(questionId).remove();
        } else {
            alert('Error deleting question: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting the question. Check the console for details.');
    });
}   



addRemoveButtonEventListeners();    
</script>



           
        </div>
    </main>

@endsection
