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
            </div>

            <!-- Таблица всех серверов -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-4">Управление всеми серверами (База данных)</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-gray-800 text-white">
                                    <th class="p-3">ID</th>
                                    <th class="p-3">Клиент (Владелец)</th>
                                    <th class="p-3">Игра / Тариф</th>
                                    <th class="p-3">IP Адрес</th>
                                    <th class="p-3">Статус</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allServers as $server)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="p-3 font-bold">#{{ $server->id }}</td>
                                        <td class="p-3 text-blue-600 font-bold">{{ $server->user->name }} <br><span
                                                class="text-xs text-gray-500">{{ $server->user->email }}</span></td>
                                        <td class="p-3">{{ $server->tariff->game->title }} - {{ $server->tariff->name }}
                                        </td>
                                        <td class="p-3 font-mono text-gray-600">{{ $server->ip_address }}</td>
                                        <td
                                            class="p-3 font-bold {{ $server->status == 'Активен' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $server->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>