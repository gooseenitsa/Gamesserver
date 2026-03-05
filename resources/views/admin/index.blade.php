<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-red-600 leading-tight flex items-center gap-2">
            🛡️ ПАНЕЛЬ АДМИНИСТРАТОРА
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

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

            <!-- Таблица всех серверов с управлением -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-6">Управление всеми серверами (База данных)</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-gray-800 text-white">
                                    <th class="p-3 rounded-tl-lg">ID</th>
                                    <th class="p-3">Клиент (Владелец)</th>
                                    <th class="p-3">Игра / Тариф</th>
                                    <th class="p-3">IP Адрес</th>
                                    <th class="p-3">Статус</th>
                                    <th class="p-3 rounded-tr-lg text-right">Действия админа</th>
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
                                            <span class="font-bold">{{ $server->tariff->game->title }}</span><br>
                                            <span class="text-xs text-gray-500">{{ $server->tariff->name }}</span>
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
                                        <td colspan="6" class="p-6 text-center text-gray-500 font-bold">В базе пока нет ни
                                            одного купленного сервера.</td>
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