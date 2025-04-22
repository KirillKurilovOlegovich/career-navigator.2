@extends('layouts.app')

@section('content')
    <main class="flex flex-col gap-14 py-10 container mx-auto max-w-[1280px] px-4">
        <div class="flex flex-col gap-6">
            <p class="text-3xl font-PoiretOne uppercase">Викторины</p>
            <div class="grid grid-cols-2 md:grid-cols-2 xl:grid-cols-4 gap-6">
            @foreach ($Quiz as $item)
            <div class="flex flex-col gap-4 shadow-md rounded-md p-[2%]">
                <p class="text-2xl font-bold">Название: {{ $item->title }}</p>
                <p class="text-2xl font-bold">Описание: {{ $item->description ?? 'Нет описания' }}</p>  <!-- Added description -->
                <p class="text-2xl font-bold">Статус: {{ $item->status ?? 'Нет статуса' }}</p>  <!-- Added description -->

                <div class="grid grid-cols-2 gap-4">
                <a class="flex justify-center bg-red-400 px-6 py-2 rounded-md" href="{{ route('RejectQuiz', $item) }}">Отклонить</a>
                <a class="flex justify-center bg-green-500 text-white px-6 py-2 rounded-md" href="{{ route('ApproveQuiz', $item) }}">Одобрить</a>
                </div>

                <div class="flex flex-col gap-2">
                    <p class="text-3xl font-PoiretOne uppercase mt-4">Вопросы</p>
                    @if ($item->questions->count() > 0)
                        <ul>
                            @foreach ($item->questions as $question)
                                <li>{{ $question->question_text }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Для этой викторины вопросов пока нет.</p>
                    @endif
                </div>
            </div>
        @endforeach
            </div>
        </div>
        <p>Категории</p>
        @foreach ($quiz_categories as $item)
            <div class="flex flex-col gap-4 shadow-md rounded-md p-[2%]">
                <p class="text-2xl font-bold">Название: {{ $item->name }}</p>
                <p class="text-2xl font-bold">Статус: {{ $item->status ?? 'Нет статуса' }}</p>  <!-- Added description -->

                <div class="grid grid-cols-2 gap-4">
                <a class="flex justify-center bg-red-400 px-6 py-2 rounded-md" href="{{ route('Delete', $item->id) }}">Отклонить</a>
                <a class="flex justify-center bg-green-500 text-white px-6 py-2 rounded-md" href="{{ route('Actvie', $item->id) }}">Одобрить</a>
                </div>
            </div>
      

        @endforeach
        <div class="flex flex-col gap-6">
            
        </div>
    </main>
@endsection
