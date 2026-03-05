<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-red-600 leading-tight flex items-center gap-2">
            🛡️ ПАНЕЛЬ АДМИНИСТРАТОРА
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Статистика -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <div class="text-gray-500 uppercase font-bold text-sm">Всего клиентов</div>
                    <div class="text-3xl font-extrabold text-gray-900">{{ $usersCount }}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                    <div class="text-gray-500 uppercase font-bold text-sm">Активных серверов</div>
                    <div class="text-3xl font-extrabold text-gray-900">
                        {{ $allServers->where('status', 'Активен')->count() }}</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
                    <div class="text-gray-500 uppercase font-bold text-sm">Остановленных</div>
                    <div class="text-3xl font-extrabold text-gray-900">
                        {{ $allServers->where('status', 'Остановлен')->count() }}</div>
                </div>
            </div>

            <!-- Блок Добавления (Игры, Тарифы, Ручная выдача серверов) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Добавить игру -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">🎮 Добавить игру</h3>
                    <form action="{{ route('admin.game.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Название игры</label>
                            <input type="text" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ссылка на обложку</label>
                            <input type="url" name="image_url" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="https://...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Описание</label>
                            <textarea name="description" required rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded font-bold text-sm transition">
                            Добавить игру
                        </button>
                    </form>
                </div>

                <!-- Добавить тариф -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">💰 Добавить тариф</h3>
                    <form action="{{ route('admin.tariff.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Игра</label>
                            <select name="game_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">Выберите игру...</option>
                                @foreach($games as $game)
                                    <option value="{{ $game->id }}">{{ $game->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Название тарифа (Напр. Basic)</label>
                            <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <div class="flex gap-2">
                            <div class="w-1/2">
                                <label class="block text-sm font-medium text-gray-700">Слоты</label>
                                <input type="number" name="slots" min="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                            <div class="w-1/2">
                                <label class="block text-sm font-medium text-gray-700">RAM (MB)</label>
                                <input type="number" name="ram_mb" min="128" step="128" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Цена (₽/мес)</label>
                            <input type="number" name="price" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded font-bold text-sm transition">
                            Добавить тариф
                        </button>
                    </form>
                </div>

                <!-- Выдать сервер -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">🎁 Выдать сервер вручную</h3>
                    <form action="{{ route('admin.server.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Пользователь</label>
                            <select name="user_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">Выберите клиента...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Тариф (Игра)</label>
                            <select name="tariff_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">Выберите тариф...</option>
                                @foreach($tariffs as $tariff)
                                    <option value="{{ $tariff->id }}">
                                        {{ $tariff->game->title ?? 'Неизвестно' }} - {{ $tariff->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Срок (Месяцев)</label>
                            <input type="number" name="months" min="1" value="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded font-bold text-sm transition mt-7">
                            Выдать сервер
                        </button>
                    </form>
                </div>
            </div>

            <!-- Фильтр серверов -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4 text-gray-800">🔍 Фильтр серверов</h3>
                <form action="{{ route('admin.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    
                    <div class="w-full md:w-1/4">
                        <label class="block text-sm font-medium text-gray-700">Клиент</label>
                        <select name="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">Все клиенты</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-1/4">
                        <label class="block text-sm font-medium text-gray-700">Игра</label>
                        <select name="game_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">Все игры</option>
                            @foreach($games as $game)
                                <option value="{{ $game->id }}" {{ request('game_id') == $game->id ? 'selected' : '' }}>
                                    {{ $game->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-1/4">
                        <label class="block text-sm font-medium text-gray-700">Статус</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">Любой статус</option>
                            <option value="Активен" {{ request('status') == 'Активен' ? 'selected' : '' }}>Активен</option>
                            <option value="Остановлен" {{ request('status') == 'Остановлен' ? 'selected' : '' }}>Остановлен</option>
                        </select>
                    </div>

                    <div class="flex gap-2 w-full md:w-1/4">
                        <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white py-2 px-4 rounded text-sm font-bold transition">
                            Применить
                        </button>
                        <a href="{{ route('admin.index') }}" class="w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded text-sm font-bold transition">
                            Сбросить
                        </a>
                    </div>
                </form>
            </div>

            <!-- Таблица всех серверов -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-6">Управление серверами (Всего найдено: {{ $allServers->count() }})</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-gray-800 text-white">
                                    <th class="p-3 rounded-tl-lg">ID</th>
                                    <th class="p-3">Клиент (Владелец)</th>
                                    <th class="p-3">Игра / Тариф</th>
                                    <th class="p-3">IP Адрес</th>
                                    <th class="p-3">Статус</th>
                                    <th class="p-3 rounded-tr-lg text-right">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allServers as $server)
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="p-3 font-bold text-gray-500">#{{ $server->id }}</td>

                                        <td class="p-3">
                                            <div class="text-indigo-600 font-bold">{{ $server->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $server->user->email }}</div>
                                        </td>

                                        <td class="p-3">
                                            <span class="font-bold">{{ $server->tariff->game->title ?? 'Неизвестно' }}</span><br>
                                            <span class="text-xs text-gray-500">{{ $server->tariff->name ?? 'Без тарифа' }}</span>
                                        </td>

                                        <td class="p-3 font-mono text-gray-800 bg-gray-100 rounded px-2 py-1">
                                            {{ $server->ip_address }}
                                        </td>

                                        <td class="p-3">
                                            <span
                                                class="px-2 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                                    {{ $server->status == 'Активен' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $server->status }}
                                            </span>
                                        </td>

                                        <td class="p-3 text-right flex justify-end gap-2">
                                            <!-- Кнопка Вкл/Выкл -->
                                            <form action="{{ route('admin.server.toggle', $server->id) }}" method="POST">
                                                @csrf
                                                @if($server->status == 'Активен')
                                                    <button type="submit"
                                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs font-bold shadow">
                                                        Остановить
                                                    </button>
                                                @else
                                                    <button type="submit"
                                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs font-bold shadow">
                                                        Запустить
                                                    </button>
                                                @endif
                                            </form>

                                            <!-- Кнопка Удалить -->
                                            <form action="{{ route('admin.server.destroy', $server->id) }}" method="POST"
                                                onsubmit="return confirm('Удалить сервер пользователя {{ $server->user->name }} навсегда?');">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-bold shadow">
                                                    Удалить
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-6 text-center text-gray-500 font-bold">
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