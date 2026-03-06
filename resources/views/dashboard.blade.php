<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01">
                </path>
            </svg>
            {{ __('Мои игровые серверы') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-700">
                <div class="p-6 text-gray-200">

                    @if($servers->isEmpty())
                        <div class="text-center py-16">
                            <svg class="w-20 h-20 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            <h3 class="text-2xl font-bold text-gray-400 mb-6">У вас пока нет активных серверов</h3>
                            <a href="{{ route('home') }}"
                                class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-500 shadow-lg shadow-indigo-500/30 transition-all inline-block">
                                Выбрать игру в каталоге
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-900/50 text-gray-400 text-sm uppercase tracking-wider">
                                        <th class="p-4 rounded-tl-lg">Игра / Тариф</th>
                                        <th class="p-4">IP Адрес</th>
                                        <th class="p-4">Статус</th>
                                        <th class="p-4">Оплачен до</th>
                                        <th class="p-4 rounded-tr-lg text-right">Управление</th>
                                    </tr>
                                </thead>
                                @foreach($servers as $server)
                                    <tbody x-data="{ openReview: false }">
                                        <tr class="border-b border-gray-700 hover:bg-gray-700/50 transition">
                                            <td class="p-4">
                                                <div class="font-bold text-lg text-white flex items-center gap-4">
                                                    <img src="{{ $server->tariff->game->image_url }}"
                                                        class="w-12 h-12 rounded-lg object-cover shadow border border-gray-600">
                                                    <div>
                                                        {{ $server->tariff->game->title }}
                                                        <div class="text-gray-400 text-sm mt-1 font-normal">
                                                            Тариф: <span
                                                                class="text-indigo-400 font-semibold">{{ $server->tariff->name }}</span>
                                                            ({{ $server->tariff->slots }} слотов)
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="p-4" x-data="{ copied: false }">
                                                <button
                                                    @click="navigator.clipboard.writeText('{{ $server->ip_address }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                                    class="font-mono text-gray-300 bg-gray-900 px-3 py-1.5 rounded-lg border border-gray-700 hover:border-indigo-500 hover:text-indigo-400 transition-all flex items-center gap-2 group relative"
                                                    title="Нажмите, чтобы скопировать">
                                                    {{ $server->ip_address }}
                                                    <svg x-show="!copied"
                                                        class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    <svg x-show="copied" x-cloak class="w-4 h-4 text-green-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span x-show="copied" x-cloak
                                                        class="absolute -top-8 left-1/2 -translate-x-1/2 bg-green-500 text-white text-xs px-2 py-1 rounded shadow">Скопировано!</span>
                                                </button>
                                            </td>

                                            <td class="p-4">
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider flex w-max items-center gap-1.5
                                                            {{ $server->status == 'Активен' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20' }}">
                                                    <span
                                                        class="w-2 h-2 rounded-full {{ $server->status == 'Активен' ? 'bg-green-400 animate-pulse' : 'bg-red-400' }}"></span>
                                                    {{ $server->status }}
                                                </span>
                                            </td>

                                            <td class="p-4 text-gray-400">
                                                {{ \Carbon\Carbon::parse($server->expires_at)->format('d.m.Y') }}
                                            </td>

                                            <td class="p-4 text-right flex justify-end gap-2">
                                                <!-- Кнопка Отзыв -->
                                                <button @click="openReview = !openReview" type="button"
                                                    class="bg-blue-600/20 text-blue-400 border border-blue-600/30 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-lg text-sm font-bold shadow transition flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                    Отзыв
                                                </button>

                                                <!-- Кнопка Включить / Выключить -->
                                                <form action="{{ route('server.toggle', $server->id) }}" method="POST">
                                                    @csrf
                                                    @if($server->status == 'Активен')
                                                        <button type="submit"
                                                            class="bg-yellow-500/20 text-yellow-500 border border-yellow-500/30 hover:bg-yellow-500 hover:text-gray-900 px-4 py-2 rounded-lg text-sm font-bold shadow transition">
                                                            Остановить
                                                        </button>
                                                    @else
                                                        <button type="submit"
                                                            class="bg-green-500/20 text-green-400 border border-green-500/30 hover:bg-green-500 hover:text-gray-900 px-4 py-2 rounded-lg text-sm font-bold shadow transition">
                                                            Запустить
                                                        </button>
                                                    @endif
                                                </form>

                                                <!-- Кнопка Удалить -->
                                                <form action="{{ route('server.destroy', $server->id) }}" method="POST"
                                                    onsubmit="return confirm('Вы уверены, что хотите удалить сервер навсегда?');">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-red-500/20 text-red-400 border border-red-500/30 hover:bg-red-500 hover:text-white px-4 py-2 rounded-lg text-sm font-bold shadow transition">
                                                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Форма отзыва -->
                                        <tr x-show="openReview" x-cloak class="bg-gray-800/50 border-b border-gray-700">
                                            <td colspan="5" class="p-6">
                                                <form action="{{ route('server.review.store', $server->id) }}" method="POST"
                                                    class="max-w-3xl bg-gray-900 p-6 rounded-xl shadow-lg border border-gray-700 mx-auto">
                                                    @csrf
                                                    <h4 class="font-bold text-indigo-400 mb-4 flex items-center gap-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                                            </path>
                                                        </svg>
                                                        Поделитесь впечатлениями о сервере
                                                    </h4>
                                                    <textarea name="text" rows="3"
                                                        class="w-full bg-gray-800 border-gray-700 text-white rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm mb-4 placeholder-gray-500"
                                                        placeholder="Как вам пинг, стабильность и работа техподдержки?"
                                                        required></textarea>

                                                    <div class="flex flex-col sm:flex-row items-center gap-4 justify-between">
                                                        <div class="flex items-center gap-3">
                                                            <label class="text-sm font-medium text-gray-400">Оценка:</label>
                                                            <select name="rating"
                                                                class="bg-gray-800 border-gray-700 text-white rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                                <option value="5">⭐⭐⭐⭐⭐ (5) Отлично</option>
                                                                <option value="4">⭐⭐⭐⭐ (4) Хорошо</option>
                                                                <option value="3">⭐⭐⭐ (3) Нормально</option>
                                                                <option value="2">⭐⭐ (2) Плохо</option>
                                                                <option value="1">⭐ (1) Ужасно</option>
                                                            </select>
                                                        </div>
                                                        <button type="submit"
                                                            class="w-full sm:w-auto bg-indigo-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-indigo-500 shadow-lg shadow-indigo-500/30 transition">
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