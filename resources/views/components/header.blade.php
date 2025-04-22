<header class="w-full flex flex-col gap-4 relative font-PoiretOne">
    <div class="container mx-auto max-w-[1280px] p-4 flex items-center gap-6 justify-between border-b border-black/10">
        <a href="{{ route('index') }}">
            <P class="text-[36px]">КЗНА</P>
        </a>
        <nav id="menu"
            class="flex items-center gap-6 max-lg:bg-white max-lg:absolute max-lg:top-0 max-lg:-translate-y-full max-lg:left-0 max-lg:flex-col max-lg:w-full transition-all duration-500 max-lg:py-6 max-lg:z-[4]">

    
            <div class="flex items-center gap-4">
                <a href="{{ route('profile') }}">
                    <img src="{{ asset('Images/header/profile.png') }}" alt="" class="w-8">
                </a>
            </div>
            <a href="{{ route('profile') }}"
                class="px-4 py-2 rounded-xl border border-black bg-black text-white transition-all duration-500 hover:text-black hover:bg-transparent">
                @guest
                    Вход
                @else
                    Профиль
                @endguest
            </a>
        </nav>
        <button id="toggler" class="lg:hidden">
            <img src="{{ asset('Images/header/menu.png') }}" alt="">
        </button>
    </div>
    <div id="overlay" class="w-full fixed inset-0 top-32 bg-black/70 max-lg:z-[3] hidden lg:hidden"></div>
</header>
