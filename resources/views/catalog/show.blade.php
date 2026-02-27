<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $game->title }} - Тарифы</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <!-- Шапка (Такая же, чтобы не ломать дизайн) -->
    <nav class="bg-gray-900 text-white p-4 flex justify-between items-center shadow-lg">
        <a href="{{ route('home') }}" class="text-2xl font-bold uppercase tracking-widest text-blue-400">GameHost</a>
        <div>
            <a href="{{ route('home') }}" class="mr-6 hover:text-gray-300">← Назад в каталог</a>
            @auth
                <a href="{{ route('dashboard') }}" class="hover:text-gray-300">Личный кабинет</a>
            @else
                <a href="{{ route('login') }}" class="mr-4 hover:text-gray-300">Вход</a>
                <a href="{{ route('register') }}" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-500">Регистрация</a>
            @endauth
        </div>
    </nav>

    <!-- Информация об игре -->
    <div class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 flex items-center gap-8">
            <img src="{{ $game->image_url }}"
                class="w-48 h-48 object-cover rounded-lg shadow-2xl border-4 border-gray-700">
            <div>
                <h1 class="text-5xl font-extrabold mb-4">{{ $game->title }}</h1>
                <p class="text-xl text-gray-300 max-w-2xl">{{ $game->description }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-10 px-4">
        <div class="flex justify-between items-end mb-8">
            <h2 class="text-3xl font-bold">Выберите тарифный план</h2>

            <!-- ФОРМА СОРТИРОВКИ -->
            <form action="{{ route('game.show', $game->id) }}" method="GET" class="flex items-center gap-2">
                <label class="text-gray-600 font-medium">Сортировка:</label>
                <select name="sort" onchange="this.form.submit()"
                    class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Сначала дешевые
                    </option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Сначала дорогие
                    </option>
                </select>
            </form>
        </div>

        <!-- СЕТКА ТАРИФОВ -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($tariffs as $tariff)
                <div
                    class="bg-white border-2 border-transparent hover:border-blue-500 rounded-xl p-6 flex flex-col text-center shadow-lg transition">
                    <h3 class="text-2xl font-bold mb-2">{{ $tariff->name }}</h3>
                    <div class="text-gray-600 mb-6 space-y-2">
                        <p>🎮 Слотов: <span class="font-bold text-gray-900">{{ $tariff->slots }}</span></p>
                        <p>💾 ОЗУ: <span class="font-bold text-gray-900">{{ $tariff->ram_mb }} MB</span></p>
                    </div>
                    <div class="text-4xl font-extrabold text-blue-600 mb-6">{{ $tariff->price }} ₽<span
                            class="text-base text-gray-500 font-normal">/мес</span></div>

                    <form action="{{ route('cart.add', $tariff->id) }}" method="POST" class="mt-auto">
                        @csrf
                        <button type="submit"
                            class="w-full bg-green-500 text-white font-bold py-3 rounded hover:bg-green-600 transition shadow-md">
                            В корзину
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

</body>

</html>