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
            <main class="mt-6">
                <div class="grid gap-6 lg:grid-cols-12 lg:gap-8">
                    <div
                        id="docs-card"
                        class="w-full flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                    >
                        <div class="w-full relative flex items-center gap-6 items-end">
                            <div id="docs-card-content" class="w-full flex items-start gap-12 flex-col">
                                <div class="w-full pt-3 sm:pt-5 lg:pt-0 justify-center flex flex-wrap">
                                    <h2 class="text-xl font-semibold text-black dark:text-white text-center">
                                        Kliknij aby utworzyć nową sesję do losowania
                                    </h2>
                                    <form action="{{ route('lottery-session.store') }}" method="POST">
                                        @csrf
                                        <button type="submit" style="
                                        font-weight: bold;
                                        padding: 5px 10px;
                                        background-color: #FF2D20;
                                        margin-top: 5px;
                                        color: white;
                                        border-radius: 5px">
                                            Generuj sesję
                                        </button>
                                    </form>
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
