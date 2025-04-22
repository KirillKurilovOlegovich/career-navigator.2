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
                <p class="text-3xl font-PoiretOne uppercase">ЛИЧНЫЕ ДАННЫЕ</p>
                <form class="flex flex-col gap-4 items-center w-full" action="{{ route('editProfile') }}" method="POST">
                    @csrf
                    <div class="flex items-center max-md:flex-col gap-4 w-full">
                        <input type="text" name="surname" value="{{ Auth::user()->surname }}"
                            class="w-full md:w-1/2 rounded-xl border border-black/10 focus:outline-none px-4 py-2"
                            placeholder="Фамилия">
                        <input type="text" name="name" value="{{ Auth::user()->name }}"
                            class="w-full md:w-1/2 rounded-xl border border-black/10 focus:outline-none px-4 py-2"
                            placeholder="Имя">
                
                    </div>
                    <div class="flex items-center max-md:flex-col gap-4 w-full">
                        <input type="email" name="email" value="{{ Auth::user()->email }}"
                            class="w-full md:w-1/2 rounded-xl border border-black/10 focus:outline-none px-4 py-2"
                            placeholder="Email">
                        <input type="password" name="password"
                            class="w-full md:w-1/2 rounded-xl border border-black/10 focus:outline-none px-4 py-2"
                            placeholder="••••••">
                    </div>
                    <div class="flex items-center max-md:flex-col gap-4 w-full">
                        <input type="text" name="phone" value="{{ Auth::user()->number }}"
                            class="w-full md:w-full rounded-xl border border-black/10 focus:outline-none px-4 py-2"
                            placeholder="Телефон">
                     
                    </div>
                
                    <button type="submit"
                        class="w-[260px] px-4 py-2 rounded-xl border border-black bg-black text-white transition-all duration-500 hover:text-black hover:bg-transparent text-center font-PoiretOne">Обновить</button>
                </form>
            </div>
            <div id="tab-2" class="w-full lg:w-2/3 flex flex-col gap-6">
                <p class="text-3xl font-PoiretOne uppercase">МОИ ТЕСТЫ</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">



            </div>
            </div>

        </div>
        <h1>Ответы для викторины: {{ $quiz->title }}</h1>

@if(isset($message))
    <p>{{ $message }}</p>
@else
<a href="{{ route('export-quiz-answers', ['quiz_id' => $quiz->id]) }}" class="btn btn-success">Скачать в Excel</a>    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Пользователя</th>
                <th>Вопрос</th>
                <th>Ответ Пользователя</th>
                <th>Правильный Ответ</th>
                <th>Результат</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($answers as $answer)
                <tr>
                    <td class="border text-center" class="border">{{ $answer->user_id }}</td class="border text-center">
                    <td class="border text-center">{{ $answer->question->question_text }}</td class="border text-center">
                    <td class="border text-center">{{ $answer->user_answer }}</td class="border text-center">
                    <td class="border text-center">{{ $answer->question->correct_answer }}</td class="border text-center">
                    <td class="border text-center">
                        @if ($answer->user_answer === $answer->question->correct_answer)
                            <span class="text-success">Правильно</span>
                        @else
                            <span class="text-danger">Неправильно</span>
                        @endif
                    </td class="border text-center">
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
    </main>
@endsection
