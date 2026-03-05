<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Мои игровые серверы') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if($servers->isEmpty())
                        <div class="text-center py-10">
                            <h3 class="text-2xl font-bold text-gray-600 mb-4">У вас пока нет активных серверов</h3>
                            <a href="{{ route('home') }}"
                                class="bg-blue-600 text-white px-6 py-3 rounded-md font-bold hover:bg-blue-700">Перейти в
                                каталог</a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-700">
                                        <th class="p-4 rounded-tl-lg border-b-2">Игра / Тариф</th>
                                        <th class="p-4 border-b-2">IP Адрес</th>
                                        <th class="p-4 border-b-2">Статус</th>
                                        <th class="p-4 border-b-2">Оплачен до</th>
                                        <th class="p-4 rounded-tr-lg border-b-2 text-right">Управление</th>
                                    </tr>
                                </thead>
                                    @foreach($servers as $server)
                                        <tbody x-data="{ openReview: false }">
                                        <tr class="border-b hover:bg-gray-50 transition">
                                            <td class="p-4">
                                                <div class="font-bold text-lg flex items-center gap-3">
                                                    <!-- Маленькая иконка игры -->
                                                    <img src="{{ $server->tariff->game->image_url }}"
                                                        class="w-10 h-10 rounded object-cover shadow">
                                                    {{ $server->tariff->game->title }}
                                                </div>
                                                <div class="text-gray-500 text-sm mt-1">Тариф: {{ $server->tariff->name }}
                                                    ({{ $server->tariff->slots }} слотов)</div>
                                            </td>

                                            <td class="p-4 font-mono text-gray-800 bg-gray-50 rounded select-all cursor-pointer hover:bg-gray-200 transition"
                                                title="Нажмите, чтобы скопировать">
                                                {{ $server->ip_address }}
                                            </td>

                                            <td class="p-4">
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                                                                    {{ $server->status == 'Активен' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                    {{ $server->status }}
                                                </span>
                                            </td>

                                            <td class="p-4 text-gray-600">
                                                {{ \Carbon\Carbon::parse($server->expires_at)->format('d.m.Y') }}
                                            </td>

                                            <td class="p-4 text-right flex justify-end gap-2">
                                                <!-- Кнопка Отзыв (Alpine.js) -->
                                                <button @click="openReview = !openReview" type="button"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-bold shadow transition">
                                                    📝 Отзыв
                                                </button>

                                                <!-- Кнопка Включить / Выключить -->
                                                <form action="{{ route('server.toggle', $server->id) }}" method="POST">
                                                    @csrf
                                                    @if($server->status == 'Активен')
                                                        <button type="submit"
                                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm font-bold shadow transition">
                                                            ⏹ Остановить
                                                        </button>
                                                    @else
                                                        <button type="submit"
                                                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm font-bold shadow transition">
                                                            ▶ Запустить
                                                        </button>
                                                    @endif
                                                </form>

                                                <!-- Кнопка Удалить -->
                                                <form action="{{ route('server.destroy', $server->id) }}" method="POST"
                                                    onsubmit="return confirm('Вы уверены, что хотите удалить сервер навсегда?');">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm font-bold shadow transition">
                                                        ✖ Удалить
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        
                                        <!-- Форма отзыва (скрыта по умолчанию) -->
                                        <tr x-show="openReview" x-cloak class="bg-indigo-50 border-b">
                                            <td colspan="5" class="p-4">
                                                <form action="{{ route('server.review.store', $server->id) }}" method="POST" class="max-w-3xl bg-white p-4 rounded shadow border border-indigo-100">
                                                    @csrf
                                                    <h4 class="font-bold text-indigo-800 mb-2">Оставить отзыв о сервере: {{ $server->tariff->game->title }} ({{ $server->tariff->name }})</h4>
                                                    <textarea name="text" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm mb-3" placeholder="Напишите, как вам этот сервер..." required></textarea>
                                                    <div class="flex items-center gap-4">
                                                        <label class="text-sm font-medium text-gray-700">Оценка:</label>
                                                        <select name="rating" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                            <option value="5">⭐⭐⭐⭐⭐ (5) Отлично</option>
                                                            <option value="4">⭐⭐⭐⭐ (4) Хорошо</option>
                                                            <option value="3">⭐⭐⭐ (3) Нормально</option>
                                                            <option value="2">⭐⭐ (2) Плохо</option>
                                                            <option value="1">⭐ (1) Ужасно</option>
                                                        </select>
                                                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm font-bold hover:bg-indigo-700 shadow transition">
                                                            Отправить отзыв
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                        </tbody>
                                    @endforeach
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>