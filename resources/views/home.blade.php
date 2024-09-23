<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
    <img id="background" class="absolute -left-20 top-0 max-w-[877px]"
         src="https://laravel.com/assets/img/welcome/background.svg"/>
    <div
        class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
            <main class="mt-6">
                <div class="grid gap-12 lg:grid-cols-1 lg:gap-12">
                    <div
                        id="docs-card"
                        class="justify-center flex items-start gap-12 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                    >
                        <div class="relative flex items-center gap-12 items-end">
                            <div id="docs-card-content" class="flex items-start gap-12 flex-col">
                                <div class="pt-3 sm:pt-5 lg:pt-0">
                                    <h2 class="text-xl font-semibold text-black dark:text-white text-center">Podaj kod sesji
                                        losowania oraz imie i nazwisko osoby losującej</h2>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="mt-4 flex rounded-md shadow-sm sm:max-w-md w-full justify-center">
                                    <form class="flex flex-wrap" method="post" action="{{ route('lottery-session.set') }}">
                                        @csrf
                                        <div class="w-full" style="margin: 10px 0">
                                            <input
                                                type="text"
                                                name="session_name"
                                                id="session_name"
                                                placeholder="Kod sesji"
                                                autocomplete="session_name"
                                                style="color: black; padding: 5px 10px"
                                                class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 w-full">
                                        </div>
                                        <div class="w-full" style="margin: 10px 0">
                                            <input
                                                type="text"
                                                name="name"
                                                id="name"
                                                placeholder="Imię i nazwisko"
                                                autocomplete="name"
                                                style="color: black; padding: 5px 10px"
                                                class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 w-full">
                                        </div>
                                        <div class="w-full flex justify-end">
                                            <button type="submit"
                                                    style="font-weight: bold;
                                                     padding: 5px 10px;
                                                     background-color: #FF2D20;
                                                     color: white;
                                                     border-radius: 5px">
                                                Wybierz
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                @auth
                                    <ul>
                                        @foreach($lotterySessions as $lotterySession)
                                            <li>
                                                <a href="{{ route('lottery-session.show', [$lotterySession->session_name]) }}">
                                                    {{ $lotterySession->session_name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
</body>
</html>
