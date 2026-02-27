<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Моя корзина</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <nav class="bg-gray-900 text-white p-4 flex justify-between items-center shadow-lg">
        <a href="{{ route('home') }}" class="text-2xl font-bold uppercase tracking-widest text-blue-400">GameHost</a>
        <div>
            <a href="{{ route('home') }}" class="mr-6 hover:text-gray-300">← Вернуться в каталог</a>
            <a href="{{ route('dashboard') }}" class="hover:text-gray-300">Личный кабинет</a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-4xl font-extrabold mb-8">Оформление заказа</h1>

        @if($cartItems->isEmpty())
            <div class="bg-white p-10 rounded-xl shadow-md text-center">
                <h2 class="text-2xl font-bold text-gray-600 mb-4">Ваша корзина пуста</h2>
                <a href="{{ route('home') }}" class="bg-blue-600 text-white px-6 py-3 rounded-md font-bold hover:bg-blue-700">Выбрать сервер</a>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="p-4">Услуга (Игра / Тариф)</th>
                            <th class="p-4">Цена за месяц</th>
                            <th class="p-4">Период (Мес.)</th>
                            <th class="p-4">Итого</th>
                            <th class="p-4 text-right">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr class="border-b">
                                <td class="p-4">
                                    <div class="font-bold text-lg">{{ $item->tariff->game->title }}</div>
                                    <div class="text-gray-600">Тариф: {{ $item->tariff->name }} ({{ $item->tariff->slots }} слотов)</div>
                                </td>
                                <td class="p-4 font-bold text-gray-700">{{ $item->tariff->price }} ₽</td>
                                <td class="p-4">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <input type="number" name="months" value="{{ $item->months }}" min="1" max="12" class="w-20 border-gray-300 rounded shadow-sm text-center">
                                        <button type="submit" class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200">↻ Обновить</button>
                                    </form>
                                </td>
                                <td class="p-4 font-extrabold text-blue-600 text-xl">{{ $item->tariff->price * $item->months }} ₽</td>
                                <td class="p-4 text-right">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold">Удалить ✖</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="p-6 bg-gray-50 flex justify-between items-center border-t border-gray-200">
                    <div class="text-2xl font-medium text-gray-600">К оплате: <span class="font-extrabold text-gray-900 text-4xl ml-2">{{ $totalPrice }} ₽</span></div>
                    
                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-extrabold text-xl py-4 px-10 rounded shadow-lg transition transform hover:scale-105">
                            Оплатить и запустить сервер
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</body>
</html>