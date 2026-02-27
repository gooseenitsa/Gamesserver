<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameHost - Аренда серверов</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <!-- Шапка -->
    <nav class="bg-gray-900 text-white p-4 flex justify-between items-center shadow-lg">
        <a href="{{ route('home') }}" class="text-2xl font-bold uppercase tracking-widest text-blue-400">GameHost</a>
        <div>
            @auth
                <a href="{{ route('dashboard') }}" class="hover:text-gray-300">Личный кабинет</a>
            @else
                <a href="{{ route('login') }}" class="mr-4 hover:text-gray-300">Вход</a>
                <a href="{{ route('register') }}"
                    class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-500 transition">Регистрация</a>
            @endauth
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-4xl font-extrabold text-center mb-8">Выбери игру для своего сервера</h1>

        <!-- ФОРМА ПОИСКА -->
        <form action="{{ route('home') }}" method="GET" class="mb-10 max-w-xl mx-auto flex">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Найти игру (например, Minecraft)..."
                class="w-full border-gray-300 rounded-l-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-r-md hover:bg-blue-700">Поиск</button>
        </form>

        <!-- СЕТКА ИГР -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($games as $game)
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
                    <img src="{{ $game->image_url }}" alt="{{ $game->title }}" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold mb-2">{{ $game->title }}</h2>
                        <p class="text-gray-600 mb-6 line-clamp-2">{{ $game->description }}</p>
                        <a href="{{ route('game.show', $game->id) }}"
                            class="block w-full text-center bg-gray-900 text-white font-bold py-3 rounded hover:bg-gray-800">
                            Смотреть тарифы
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center text-gray-500 text-xl py-10">
                    Игры по вашему запросу не найдены 😢
                </div>
            @endforelse
        </div>
    </div>

</body>

</html>