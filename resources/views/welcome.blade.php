<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Каталог серверов') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Поиск -->
            <form action="{{ route('home') }}" method="GET" class="mb-8 flex shadow-sm rounded-md">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Найти игру (например, Minecraft)..."
                    class="flex-1 border-gray-300 rounded-l-md focus:border-indigo-500 focus:ring-indigo-500">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-r-md hover:bg-indigo-700 font-bold transition">Поиск</button>
            </form>

            <!-- Игры -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($games as $game)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 flex flex-col">
                        <img src="{{ $game->image_url }}" alt="{{ $game->title }}"
                            class="w-full h-64 object-cover border-b border-gray-100">
                        <div class="p-6 flex-1 flex flex-col">
                            <h2 class="text-2xl font-extrabold text-gray-900 mb-2">{{ $game->title }}</h2>
                            <p class="text-gray-600 mb-6 flex-1">{{ $game->description }}</p>
                            <a href="{{ route('game.show', $game->id) }}"
                                class="text-center bg-gray-900 text-white font-bold py-3 rounded-lg hover:bg-gray-800 transition">
                                Смотреть тарифы →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center text-gray-500 py-10 bg-white rounded-lg shadow">
                        Игры по вашему запросу не найдены.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>