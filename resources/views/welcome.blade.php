<x-app-layout>
    <x-slot name="header">
        <h2
            class="font-semibold text-2xl text-indigo-400 leading-tight tracking-wider uppercase flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ __('Игровые серверы') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Поиск -->
            <form action="{{ route('home') }}" method="GET"
                class="mb-10 flex shadow-lg rounded-lg overflow-hidden border border-gray-700">
                <div class="bg-gray-800 px-4 flex items-center text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Найти игру (например, Minecraft)..."
                    class="flex-1 bg-gray-800 border-none text-white focus:ring-0 placeholder-gray-500 py-4 text-lg">
                <button type="submit"
                    class="bg-indigo-600 text-white px-8 py-4 hover:bg-indigo-500 font-extrabold uppercase tracking-widest transition-colors">Поиск</button>
            </form>

            <!-- Игры -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($games as $game)
                    <div
                        class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-700 hover:border-indigo-500 hover:shadow-indigo-500/20 transition-all duration-300 flex flex-col group">
                        <div class="relative overflow-hidden">
                            <img src="{{ $game->image_url }}" alt="{{ $game->title }}"
                                class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent"></div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col relative z-10 -mt-10">
                            <h2 class="text-3xl font-black text-white mb-3 drop-shadow-md">{{ $game->title }}</h2>
                            <p class="text-gray-400 mb-6 flex-1 leading-relaxed text-sm">{{ $game->description }}</p>
                            <a href="{{ route('game.show', $game->id) }}"
                                class="text-center w-full bg-indigo-600/20 border border-indigo-500/50 text-indigo-300 font-bold py-3 rounded-xl hover:bg-indigo-500 hover:text-white transition-all">
                                Смотреть тарифы →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 bg-gray-800 rounded-2xl border border-gray-700 shadow-lg">
                        <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-400 mb-2">Игры не найдены</h3>
                        <p class="text-gray-500">Попробуйте изменить запрос поиска</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>