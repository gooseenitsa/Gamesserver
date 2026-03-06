<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-200 leading-tight flex items-center gap-3">
                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Корзина покупок
            </h2>
            <a href="{{ route('home') }}" class="text-indigo-400 hover:text-indigo-300 font-bold text-sm flex items-center gap-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                В каталог
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($cartItems->isEmpty())
                <div class="relative bg-gray-800/80 rounded-3xl overflow-hidden border border-gray-700/80 shadow-2xl">
                    <!-- Декоративный градиент -->
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 via-transparent to-green-500/5 pointer-events-none"></div>
                    <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
                    
                    <div class="relative flex flex-col lg:flex-row items-center gap-12 lg:gap-16 p-12 lg:p-16">
                        <!-- Левая часть: иконка + текст -->
                        <div class="flex flex-col items-center lg:items-start text-center lg:text-left flex-1">
                            <div class="relative mb-8">
                                <div class="w-28 h-28 rounded-2xl bg-gray-900/80 border border-gray-600 flex items-center justify-center rotate-3 hover:rotate-0 transition-transform duration-300">
                                    <svg class="w-14 h-14 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                </div>
                                <span class="absolute -bottom-2 -right-2 text-4xl opacity-20">?</span>
                            </div>
                            <h2 class="text-3xl lg:text-4xl font-black text-white mb-3 tracking-tight">Корзина пока пуста</h2>
                            <p class="text-gray-400 text-lg max-w-md">Добавьте тариф из каталога — и через пару кликов ваш игровой сервер уже будет запущен.</p>
                        </div>
                        
                        <!-- Разделитель на десктопе -->
                        <div class="hidden lg:block w-px h-40 bg-gradient-to-b from-transparent via-gray-600 to-transparent self-center"></div>
                        
                        <!-- Правая часть: CTA -->
                        <div class="flex flex-col items-center lg:items-end gap-6 flex-shrink-0">
                            <a href="{{ route('home') }}" class="group inline-flex items-center gap-3 bg-indigo-600 hover:bg-indigo-500 text-white px-10 py-4 rounded-2xl font-bold text-lg shadow-xl shadow-indigo-500/25 transition-all hover:shadow-indigo-500/40 hover:scale-[1.02]">
                                <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Перейти в каталог серверов
                            </a>
                            <p class="text-gray-500 text-sm">Minecraft, CS2, Rust, ARK и другие</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-700">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-900/80 text-gray-400 text-sm uppercase tracking-wider">
                                    <th class="p-6">Услуга</th>
                                    <th class="p-6">Цена / мес.</th>
                                    <th class="p-6 text-center">Период</th>
                                    <th class="p-6 text-right">Итого</th>
                                    <th class="p-6 text-right">Удалить</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    <tr class="border-b border-gray-700 hover:bg-gray-700/30 transition-colors">
                                        <td class="p-6">
                                            <div class="flex items-center gap-4">
                                                <img src="{{ $item->tariff->game->image_url }}" class="w-14 h-14 rounded-lg object-cover border border-gray-600 shadow">
                                                <div>
                                                    <div class="font-black text-xl text-white">{{ $item->tariff->game->title }}</div>
                                                    <div class="text-indigo-400 font-semibold mt-1">Тариф: {{ $item->tariff->name }} <span class="text-gray-500 font-normal">({{ $item->tariff->slots }} слотов)</span></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-6 font-bold text-gray-300 text-lg">{{ $item->tariff->price }} ₽</td>
                                        <td class="p-6 text-center">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline-flex items-center gap-2 bg-gray-900 p-1.5 rounded-lg border border-gray-700">
                                                @csrf
                                                <input type="number" name="months" value="{{ $item->months }}" min="1" max="12" class="w-16 bg-gray-800 border-none text-white rounded text-center focus:ring-1 focus:ring-indigo-500">
                                                <button type="submit" class="p-2 text-indigo-400 hover:bg-gray-700 rounded transition" title="Обновить срок">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="p-6 text-right font-black text-indigo-400 text-2xl tracking-tight">{{ $item->tariff->price * $item->months }} ₽</td>
                                        <td class="p-6 text-right">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-red-500 hover:text-red-400 hover:bg-red-500/10 p-2 rounded-lg transition" title="Удалить из корзины">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="p-8 bg-gray-900 border-t border-gray-700 flex flex-col md:flex-row justify-between items-center gap-6">
                        <div class="text-gray-400 text-lg">
                            Итого к оплате: <span class="font-black text-white text-5xl ml-3 tracking-tighter">{{ $totalPrice }} ₽</span>
                        </div>
                        
                        <form action="{{ route('cart.checkout') }}" method="POST" class="w-full md:w-auto">
                            @csrf
                            <button type="submit" class="w-full md:w-auto bg-green-600 hover:bg-green-500 text-white font-black text-xl py-4 px-12 rounded-xl shadow-lg shadow-green-500/20 transition transform hover:scale-105 flex items-center justify-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Оплатить и запустить
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>