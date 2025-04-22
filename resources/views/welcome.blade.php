@extends('layouts.app')

@section('content')
    <main class="flex flex-col gap-14 py-10 container mx-auto max-w-[1280px] px-4"> 
        <div class="flex flex-col gap-6">
            <p class="text-3xl font-PoiretOne uppercase">Новинки</p>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <form method="post" action="{{ route('seatch') }}">  <!-- Или ваш маршрут главной страницы -->
            @csrf
            <div class="mb-3">
                    <label for="category_filter" class="form-label">Фильтр по категории:</label>
                    <select class="form-control" id="category_filter" name="category">
                        <option value="">Категории</option>
                        @foreach ($categories as $category)
                        @if ($category->status == 'active')
                        <option value="{{ $category->id }}">{{ $category->name }}</option>

                        @endif
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Фильтр</button>
            </form> 
            @if (isset($quizzes) && $quizzes->count() > 0)
          
        <ul>
       
            @foreach ($quizzes as $quiz)
            @if($quiz->status == 'approved')
            <div class="border rounded-md font-serif">
            <li>
            Тест: <a href="{{ route('lets_quiz', ['quiz' => $quiz->id]) }}">{{ $quiz->title }}</a>                </li>
            </div>
            @endif
            @endforeach
            
        </ul>
        @if($quizzes instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $quizzes->links() }}
        @endif

    @else
        <p>No quizzes found.</p>
    @endif
            </div>
        </div>
        <img src="{{ asset('Images/hero/main.png') }}" alt="" class="rounded-xl w-full h-[30vw]">

        <div class="flex flex-col gap-6">
            <p class="text-3xl font-PoiretOne uppercase">СВЕЖИЕ НОВОСТИ</p>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="flex flex-col gap-4 rounded-xl p-4 shadow-[0px_0px_13px_-7px_black] border border-black/10">
                    <img src="{{ asset('Images/news/xxh.png') }}" alt="" class="w-full roundeed-xl">
                    <p class="font-PoiretOne">ы добавили в нашу библиотеку три новые игры: «Каркассон», «7 чудес» и «Манчкин»! Приходите и попробуйте свои силы в этих захватывающих играх.</p>
                    <p class="opacity-50 self-end">15 марта 2024</p>
                </div>
                <div class="flex flex-col gap-4 rounded-xl p-4 shadow-[0px_0px_13px_-7px_black] border border-black/10">
                    <img src="{{ asset('Images/news/xxh.png') }}" alt="" class="w-full roundeed-xl">
                    <p class="font-PoiretOne">Приглашаем всех любителей поездов и стратегий на турнир по “Ticket to Ride”! Регистрация открыта, лучшие игроки получат ценные призы!</p>
                    <p class="opacity-50 self-end">27 апреля 2024</p>
                </div>
                <div class="flex flex-col gap-4 rounded-xl p-4 shadow-[0px_0px_13px_-7px_black] border border-black/10">
                    <img src="{{ asset('Images/news/xxh.png') }}" alt="" class="w-full roundeed-xl">
                    <p class="font-PoiretOne">Мы внесли небольшие изменения в правила игры «Дженга», чтобы сделать ее еще интереснее. Ознакомьтесь с обновленными правилами на нашем сайте.</p>
                    <p class="opacity-50 self-end">10 июня 2024</p>
                </div>
                <div class="flex flex-col gap-4 rounded-xl p-4 shadow-[0px_0px_13px_-7px_black] border border-black/10">
                    <img src="{{ asset('Images/news/xxh.png') }}" alt="" class="w-full roundeed-xl">
                    <p class="font-PoiretOne">На этой неделе у нас действуют скидки на все настольные игры! Отличная возможность пополнить свою коллекцию или попробовать что-то новое. Успейте воспользоваться выгодным предложением!</p>
                    <p class="opacity-50 self-end">22 августа 2024</p>
                </div>
            </div>
        </div>
    </main>

@endsection
