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
                <div class="bg-gray-800 p-16 rounded-2xl shadow-xl text-center border border-gray-700">
                    <svg class="w-24 h-24 text-gray-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <h2 class="text-3xl font-black text-gray-300 mb-6 tracking-tight">Ваша корзина пуста</h2>
                    <a href="{{ route('home') }}" class="inline-block bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-indigo-500 shadow-lg shadow-indigo-500/30 transition-all text-lg">
                        Выбрать мощный сервер
                    </a>
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