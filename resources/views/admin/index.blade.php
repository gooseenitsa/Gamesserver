<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-red-500 leading-tight flex items-center gap-2">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                </path>
            </svg>
            ПАНЕЛЬ АДМИНИСТРАТОРА
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/50 text-red-400 px-6 py-4 rounded-xl relative shadow-lg">
                    <ul class="list-disc list-inside font-medium">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Статистика -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-700 relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-16 h-full bg-blue-500/10"></div>
                    <div class="text-blue-400 uppercase font-black tracking-widest text-xs mb-2">Всего клиентов</div>
                    <div class="text-5xl font-black text-white">{{ $usersCount }}</div>
                </div>
                <div class="bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-700 relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-16 h-full bg-green-500/10"></div>
                    <div class="text-green-400 uppercase font-black tracking-widest text-xs mb-2">Активных серверов
                    </div>
                    <div class="text-5xl font-black text-white">{{ $allServers->where('status', 'Активен')->count() }}
                    </div>
                </div>
                <div class="bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-700 relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-16 h-full bg-red-500/10"></div>
                    <div class="text-red-400 uppercase font-black tracking-widest text-xs mb-2">Остановлено</div>
                    <div class="text-5xl font-black text-white">
                        {{ $allServers->where('status', 'Остановлен')->count() }}</div>
                </div>
            </div>

            <!-- Блок Добавления (Игры, Тарифы, Ручная выдача серверов) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Добавить игру -->
                <div class="bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-700">
                    <h3 class="text-lg font-black mb-6 text-white flex items-center gap-2">
                        <span class="bg-indigo-500/20 p-2 rounded-lg text-indigo-400"><svg class="w-5 h-5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                </path>
                            </svg></span>
                        Добавить игру
                    </h3>
                    <form action="{{ route('admin.game.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Название
                                игры</label>
                            <input type="text" name="title" required
                                class="block w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Ссылка на
                                обложку</label>
                            <input type="url" name="image_url" required
                                class="block w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="https://...">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Описание</label>
                            <textarea name="description" required rows="2"
                                class="block w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-2.5 px-4 rounded-lg font-bold transition">
                            Добавить игру
                        </button>
                    </form>
                </div>

                <!-- Добавить тариф -->
                <div class="bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-700">
                    <h3 class="text-lg font-black mb-6 text-white flex items-center gap-2">
                        <span class="bg-green-500/20 p-2 rounded-lg text-green-400"><svg class="w-5 h-5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg></span>
                        Добавить тариф
                    </h3>
                    <form action="{{ route('admin.tariff.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Игра</label>
                            <select name="game_id" required
                                class="block w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                <option value="">Выберите игру...</option>
                                @foreach($games as $game)
                                    <option value="{{ $game->id }}">{{ $game->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Название
                                тарифа</label>
                            <input type="text" name="name" required
                                class="block w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:border-green-500 focus:ring-green-500 sm:text-sm">
                        </div>
                        <div class="flex gap-4">
                            <div class="w-1/2">
                                <label
                                    class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Слоты</label>
                                <input type="number" name="slots" min="1" required
                                    class="block w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:border-green-500 focus:ring-green-500 sm:text-sm">
                            </div>
                            <div class="w-1/2">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">RAM
                                    (MB)</label>
                                <input type="number" name="ram_mb" min="128" step="128" required
                                    class="block w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:border-green-500 focus:ring-green-500 sm:text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Цена
                                (₽/мес)</label>
                            <input type="number" name="price" min="0" required
                                class="block w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:border-green-500 focus:ring-green-500 sm:text-sm">
                        </div>
                        <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-500 text-white py-2.5 px-4 rounded-lg font-bold transition mt-2">
                            Добавить тариф
                        </button>
                    </form>
                </div>

                <!-- Выдать сервер -->
                <div class="bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-700 flex flex-col">
                    <h3 class="text-lg font-black mb-6 text-white flex items-center gap-2">
                        <span class="bg-yellow-500/20 p-2 rounded-lg text-yellow-400"><svg class="w-5 h-5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                </path>
                            </svg></span>
                        Выдать сервер вручную
                    </h3>
                    <form action="{{ route('admin.server.store') }}" method="POST"
                        class="space-y-4 flex-1 flex flex-col">
                        @csrf
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Пользователь</label>
                            <select name="user_id" required
                                class="block w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                <option value="">Выберите клиента...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Тариф
                                (Игра)</label>
                            <select name="tariff_id" required
                                class="block w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                <option value="">Выберите тариф...</option>
                                @foreach($tariffs as $tariff)
                                    <option value="{{ $tariff->id }}">
                                        {{ $tariff->game->title ?? 'Неизвестно' }} - {{ $tariff->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Срок
                                (Месяцев)</label>
                            <input type="number" name="months" min="1" value="1" required
                                class="block w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                        </div>
                        <div class="mt-auto pt-4">
                            <button type="submit"
                                class="w-full bg-yellow-600 hover:bg-yellow-500 text-gray-900 py-2.5 px-4 rounded-lg font-bold transition">
                                Выдать сервер
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Фильтр серверов -->
            <div class="bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-700">
                <h3 class="text-lg font-black mb-4 text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                        </path>
                    </svg>
                    Фильтр серверов
                </h3>
                <form action="{{ route('admin.index') }}" method="GET"
                    class="flex flex-col md:flex-row gap-4 items-end">

                    <div class="w-full md:w-1/4">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Клиент</label>
                        <select name="user_id"
                            class="block w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Все клиенты</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-1/4">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Игра</label>
                        <select name="game_id"
                            class="block w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Все игры</option>
                            @foreach($games as $game)
                                <option value="{{ $game->id }}" {{ request('game_id') == $game->id ? 'selected' : '' }}>
                                    {{ $game->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-1/4">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Статус</label>
                        <select name="status"
                            class="block w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Любой статус</option>
                            <option value="Активен" {{ request('status') == 'Активен' ? 'selected' : '' }}>Активен
                            </option>
                            <option value="Остановлен" {{ request('status') == 'Остановлен' ? 'selected' : '' }}>
                                Остановлен</option>
                        </select>
                    </div>

                    <div class="flex gap-2 w-full md:w-1/4">
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-2 px-4 rounded-lg text-sm font-bold transition">
                            Применить
                        </button>
                        <a href="{{ route('admin.index') }}"
                            class="w-full text-center border border-gray-600 hover:bg-gray-700 text-gray-300 py-2 px-4 rounded-lg text-sm font-bold transition">
                            Сбросить
                        </a>
                    </div>
                </form>
            </div>

            <!-- Таблица всех серверов -->
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-700">
                <div class="p-6">
                    <h3 class="text-xl font-black mb-6 text-white">Управление серверами <span
                            class="text-gray-500 font-normal text-base ml-2">Найдено: {{ $allServers->count() }}</span>
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-gray-900/80 text-gray-400 uppercase tracking-wider">
                                    <th class="p-4 rounded-tl-lg">ID</th>
                                    <th class="p-4">Клиент (Владелец)</th>
                                    <th class="p-4">Игра / Тариф</th>
                                    <th class="p-4">IP Адрес</th>
                                    <th class="p-4">Статус</th>
                                    <th class="p-4 rounded-tr-lg text-right">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allServers as $server)
                                    <tr class="border-b border-gray-700 hover:bg-gray-700/50 transition">
                                        <td class="p-4 font-mono text-gray-500 font-bold">#{{ $server->id }}</td>

                                        <td class="p-4">
                                            <div class="text-indigo-400 font-bold">{{ $server->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $server->user->email }}</div>
                                        </td>

                                        <td class="p-4">
                                            <span
                                                class="font-bold text-white">{{ $server->tariff->game->title ?? 'Неизвестно' }}</span><br>
                                            <span
                                                class="text-xs text-gray-400">{{ $server->tariff->name ?? 'Без тарифа' }}</span>
                                        </td>

                                        <td class="p-4 font-mono text-gray-300">
                                            <span
                                                class="bg-gray-900 border border-gray-700 px-2 py-1 rounded">{{ $server->ip_address }}</span>
                                        </td>

                                        <td class="p-4">
                                            <span
                                                class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider flex w-max items-center gap-1.5
                                                    {{ $server->status == 'Активен' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20' }}">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full {{ $server->status == 'Активен' ? 'bg-green-400' : 'bg-red-400' }}"></span>
                                                {{ $server->status }}
                                            </span>
                                        </td>

                                        <td class="p-4 text-right flex justify-end gap-2">
                                            <!-- Кнопка Вкл/Выкл -->
                                            <form action="{{ route('admin.server.toggle', $server->id) }}" method="POST">
                                                @csrf
                                                @if($server->status == 'Активен')
                                                    <button type="submit"
                                                        class="bg-yellow-500/20 text-yellow-500 border border-yellow-500/30 hover:bg-yellow-500 hover:text-gray-900 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                                        Остановить
                                                    </button>
                                                @else
                                                    <button type="submit"
                                                        class="bg-green-500/20 text-green-400 border border-green-500/30 hover:bg-green-500 hover:text-gray-900 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                                        Запустить
                                                    </button>
                                                @endif
                                            </form>

                                            <!-- Кнопка Удалить -->
                                            <form action="{{ route('admin.server.destroy', $server->id) }}" method="POST"
                                                onsubmit="return confirm('Удалить сервер пользователя {{ $server->user->name }} навсегда?');">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-red-500/20 text-red-400 border border-red-500/30 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                                    Удалить
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-gray-500 font-bold">
                                            <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                                </path>
                                            </svg>
                                            По вашему запросу серверов не найдено.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>