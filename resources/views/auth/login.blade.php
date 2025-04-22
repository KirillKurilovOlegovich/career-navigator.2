@extends('layouts.app')

@section('content')
    <main class="flex flex-col gap-14 py-10 container mx-auto max-w-[1280px] px-4 grow">
        <div class="flex flex-col gap-6 items-center justify-center grow">
            <p class="text-3xl font-PoiretOne uppercase text-center">Вход</p>
            <form class="flex flex-col gap-4 items-center w-full md:w-2/3 lg:w-1/2" method="POST"
                action="{{ route('login') }}">
                @csrf
                <div class="flex flex-col items-center max-md:flex-col gap-4 w-full">
                    <input type="email" name="email"
                        class="w-full md:w-1/2 rounded-xl border border-black/10 focus:outline-none px-4 py-2"
                        placeholder="Email">
                    <input type="password" name="password"
                        class="w-full md:w-1/2 rounded-xl border border-black/10 focus:outline-none px-4 py-2"
                        placeholder="••••••">
                </div>
                <button type="submit"
                    class="w-[260px] px-4 py-2 rounded-xl border border-black bg-black text-white ">Авторизоваться</button>
            </form>
            <div class="flex items-center justify-center gap-4 w-full md:w-2/3 lg:w-1/2">
                <div class="w-full h-px bg-black/10"></div>

            
            </div>
            <a href="{{ route('register') }}"
                class="w-[260px] px-4 py-2 rounded-xl border border-[#353535] bg-[#410c0c] text-white ">Зарегистрироваться</a>
        </div>
    </main>
@endsection
