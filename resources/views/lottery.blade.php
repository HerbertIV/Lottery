<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('components.head')
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
@include('components.snow')
<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
    <img id="background" class="absolute -left-20 top-0 max-w-[877px]"
         src="https://laravel.com/assets/img/welcome/background.svg"/>
    <div
        class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
            <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                <div class="flex lg:justify-center lg:col-start-2">
                    <img src="{{ asset('santa.png') }}"/>
                </div>
            </header>

            <main class="mt-6">
                <div class="grid gap-6 lg:grid-cols-12 lg:gap-8">
                    <div
                        id="docs-card"
                        class="w-full flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:focus-visible:ring-[#FF2D20]"
                    >
                        <div class="w-full relative flex items-center gap-6 lg:items-end justify-center">
                            <div id="docs-card-content"
                                 class="w-full flex items-start gap-12 lg:flex-col justify-center" style="width: 500px">
                                <div class="w-full pt-3 sm:pt-5 lg:pt-0 justify-center flex flex-wrap">
                                    <div class="w-full text-center">
                                        <h2 class="text-xl font-semibold text-black dark:text-white">
                                            Cześć {{ Str::title($member->name) }}
                                        </h2>
                                    </div>
                                    @if ($member->canDraw($activeLotterySessionTurn) && $activeLotterySessionTurn)
                                        <div class="w-full text-center">
                                            <h2 class="text-xl font-semibold text-black dark:text-white">Sesja losowania
                                                aktywna
                                                do: {{ $activeLotterySessionTurn->date_to->format('d-m-Y') }}</h2>
                                        </div>
                                        <div class="w-full text-center">
                                            <h2 class="text-xl font-semibold text-black dark:text-white">Kliknij aby
                                                wylosować osobę</h2>
                                            <form
                                                action="{{ route('lottery-session.draw_member', ['lotterySession' => $lotterySessionName, 'member' => $member]) }}"
                                                method="POST">
                                                @csrf
                                                <button class="lottery-button" type="submit" style="
                                                    margin-top: 15px;
                                                    font-weight: bold;
                                                    padding: 10px 20px;
                                                    margin-left: 15px;
                                                    background-color: #FF2D20;
                                                    color: white;
                                                    border-radius: 5px;
                                                    font-size: 24px;
                                                    ">
                                                    Losuj
                                                </button>
                                            </form>
                                        </div>

                                    @else
                                        @isset ($memberDrawn)
                                            <h2 class="text-xl font-semibold text-black dark:text-white">
                                                Wylosowałeś: <span style="color: red">{{ Str::title($memberDrawn->name) }}</span>
                                            </h2>
                                        @else
                                            <h2 class="text-xl font-semibold text-black dark:text-white">
                                                Ty już losowałeś, albo losowanie jeszcze się nie zaczęło
                                            </h2>
                                        @endif
                                    @endif
                                </div>

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
