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
<!-- <div id="timer">05:00</div>  -->
<h1>{{ $quiz->title }}</h1>
<div id="questionContainer"></div>
<div id="chart"></div> 
<div id="results"></div>
            
                    </div>

                </form>
            </div>

            



           
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
  {{-- Данные о вопросах викторины, передаваемые с сервера (через Laravel's @json). --}}
  let quizQuestions = @json($quiz->questions);

  {{-- Счетчики правильных и неправильных ответов. --}}
  let correctAnswers = 0;
  let incorrectAnswers = 0;

  {{-- Массив для хранения ответов пользователя. Важно: объявлен вне функций для сохранения данных между вызовами функций. --}}
  let userAnswers = [];

  {{-- Индекс текущего вопроса. Важно: объявлен вне функций для отслеживания прогресса. --}}
  let currentQuestionIndex = 0;

  {{-- Функция для отображения вопроса. Принимает индекс вопроса в качестве аргумента. --}}
  function showQuestion(index) {
    {{-- Проверка на корректность индекса. --}}
    if (index < 0 || index >= quizQuestions.length) {
      return; {{-- Выходим, если индекс некорректный. --}}
    }
    {{-- Получаем элемент с идентификатором 'questionContainer', куда будет выводиться вопрос. --}}
    const questionDiv = document.getElementById('questionContainer');
    {{-- Обработка ошибки, если элемент не найден. --}}
    if (!questionDiv) {
      console.error("Элемент с идентификатором 'questionContainer' не найден!");
      return; {{-- Выходим, если элемент не найден. --}}
    }
    {{-- Получаем текущий вопрос из массива quizQuestions. --}}
    const question = quizQuestions[index];
    {{-- Создаем HTML-код для вопроса, используя шаблонные литералы. --}}
    const questionHTML = `
      <div class="question-item">
        <p><strong>${question.question_text}</strong></p> {{-- Выводим текст вопроса --}}
        <input type="text" id="userAnswer${index}" name="userAnswer${index}" placeholder="Ваш ответ"> {{-- Поле ввода для ответа пользователя --}}
        <button type="button" onclick="checkAnswer(${index})">Ответить</button> {{-- Кнопка для проверки ответа --}}
      </div>
    `;
    {{-- Важное изменение: используем insertAdjacentHTML для добавления HTML-кода, а не замены всего содержимого questionDiv. Это позволяет отображать несколько вопросов. --}}
    questionDiv.insertAdjacentHTML('beforeend', questionHTML);
  }
  // ... (остальной код для проверки ответа и т.д.)


 
/**
 * Проверяет ответ пользователя на вопрос викторины.
 * @param {number} index Индекс текущего вопроса в массиве quizQuestions.
 */
function checkAnswer(index) {
    // Создаем ID элемента для ответа пользователя.
    const userAnswerId = `userAnswer${index}`;
    // Получаем элемент ответа пользователя по ID.
    const userAnswerElement = document.getElementById(userAnswerId);

    // Проверка на существование элемента.
    if (!userAnswerElement) {
        console.error(`Element with ID "${userAnswerId}" not found!`);
        return; // Прерываем выполнение, если элемент не найден.
    }

    // Получаем ответ пользователя, обрезаем пробелы в начале и конце.
    const userAnswer = userAnswerElement.value.trim();
    // Получаем ID викторины из Blade-шаблона.
    const quizId = {{ $quiz->id }};
    // Получаем ID вопроса из массива вопросов.
    const questionId = quizQuestions[index].id;

    // Отправляем запрос на сервер с помощью fetch.
    fetch(`/quizzes/answer`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            // Токен CSRF для защиты от подделки межсайтовых запросов.
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            // Данные для отправки на сервер.
            user_id: {{ Auth::id() }}, // ID пользователя (из Laravel's Auth).
            quiz_id: quizId, // ID викторины.
            question_id: questionId, // ID вопроса.
            user_answer: userAnswer // Ответ пользователя.
        })
    })
    .then(response => response.json()) // Преобразуем ответ сервера в JSON.
    .then(data => {
        console.log('Response from server:', data); // Выводим ответ сервера в консоль.
        // Обработка ситуации, если пользователь уже ответил на этот вопрос.
        if (data.alreadyAnswered) {
            alert(data.message); // Выводим сообщение об ошибке.
            return; // Прерываем выполнение.
        }
        // Добавляем пустые элементы в массив userAnswers, если необходимо.
        while (userAnswers.length <= index) {
            userAnswers.push("");
        }
        // Сохраняем ответ пользователя в массив userAnswers.
        userAnswers[index] = userAnswer;
        console.log(`User's answer for question ${index + 1}: ${userAnswer}`); // Выводим ответ в консоль.

        // Проверяем правильность ответа (без учёта регистра).
        if (userAnswer.toLowerCase() === quizQuestions[index].correct_answer.toLowerCase()) {
            correctAnswers++; // Увеличиваем счётчик правильных ответов.
        } else {
            incorrectAnswers++; // Увеличиваем счётчик неправильных ответов.
        }
        // Переходим к следующему вопросу.
        currentQuestionIndex++;

        // Проверка на окончание викторины.
        if (currentQuestionIndex < quizQuestions.length) {
            showQuestion(currentQuestionIndex); // Отображаем следующий вопрос.
        } else {
            showResults(); // Отображаем результаты.
        }
    })
    .catch(error => {
        console.error('Error:', error); // Выводим ошибку в консоль.
        alert("Произошла ошибка при отправке ответа. Попробуйте ещё раз."); // Выводим сообщение об ошибке пользователю.
    });
}
let chart = null; // Объявление переменной chart вне функции для сохранения состояния графика между вызовами.

/**
 * Отображает результаты викторины, включая график и список вопросов с ответами.
 */
function showResults() {
    // Данные для графика: количество правильных и неправильных ответов.
    const chartData = [{
        name: 'Правильно',
        data: [correctAnswers],
        color: '#f1b44c' // Цвет для правильных ответов.
    }, {
        name: 'Неправильно',
        data: [incorrectAnswers],
        color: '#556ee6' // Цвет для неправильных ответов.
    }];

    // Настройки для графика ApexCharts.
    var options = {
        series: [{
            name: 'Ответы', // Название ряда данных.
            data: [incorrectAnswers, correctAnswers] // Данные: сначала неправильные, потом правильные ответы.
        }],
        chart: {
            height: 350, // Высота графика.
            type: 'bar', // Тип графика - столбчатая диаграмма.
        },
        plotOptions: { // Настройки для группировки столбцов.
            bar: {
                horizontal: false, // Столбцы вертикальные.
                columnWidth: '55%', // Ширина столбцов.
            }
        },
        xaxis: { // Настройки оси X.
            categories: ['Неправильно', 'Правильно'], // Категории на оси X.
        },
        labels: ['Неправильно', 'Правильно'], // Подписи для данных.
        colors: ['#556ee6', '#f1b44c'], // Цвета столбцов.
        responsive: [{ // Настройки адаптивности для разных размеров экрана.
            breakpoint: 480, // Точка разрыва (пикселей).
            options: {
                chart: {
                    width: 200 // Ширина графика при меньшем разрешении.
                },
                legend: {
                    position: 'bottom' // Положение легенды при меньшем разрешении.
                }
            }
        }]
    };

    // Создание или обновление графика.
    if (chart === null) {
        // Если график еще не создан, создаем его.
        chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render(); // Рендеринг графика.
    } else {
        // Если график уже существует, обновляем его данные и настройки.
        chart.updateOptions(options);
        chart.updateSeries(options.series);
    }

    // Получаем элемент для отображения результатов.
    const resultsDiv = document.getElementById('results');
    // Создаем HTML-код для отображения результатов.
    let resultsHTML = '<h2>Результат</h2>';
    // Проходим по каждому вопросу и формируем HTML-код для отображения вопроса, ответа пользователя и правильного ответа.
    quizQuestions.forEach((question, index) => {
        resultsHTML += `<p><strong>${question.question_text}</strong><br>Ваш ответ: ${userAnswers[index] || "Не отвечено"}<br>Правильный ответ: ${question.correct_answer}</p>`;
    });
    // Выводим HTML-код в элемент resultsDiv.
    resultsDiv.innerHTML = resultsHTML;
}


        

        // вызов фунции 
        showQuestion(currentQuestionIndex);

        </script>
@endsection

