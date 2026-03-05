<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-2xl text-gray-200 leading-tight">
                {{ $game->title }}
            </h2>
            <a href="{{ route('home') }}" class="text-indigo-400 hover:text-indigo-300 font-bold text-sm flex items-center gap-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Назад в каталог
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Инфо об игре -->
            <div class="bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-700 flex flex-col md:flex-row gap-8 items-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <img src="{{ $game->image_url }}" class="w-full md:w-64 h-64 md:h-auto object-cover rounded-xl shadow-2xl border border-gray-600 z-10">
                <div class="z-10">
                    <h1 class="text-5xl font-black text-white mb-4 tracking-tight drop-shadow-md">{{ $game->title }}</h1>
                    <p class="text-xl text-gray-300 leading-relaxed">{{ $game->description }}</p>
                </div>
            </div>

            <!-- Тарифы и сортировка -->
            <div class="bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-700">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                    <h2 class="text-3xl font-black text-white flex items-center gap-3">
                        <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Тарифные планы
                    </h2>
                    <form action="{{ route('game.show', $game->id) }}" method="GET">
                        <select name="sort" onchange="this.form.submit()" class="bg-gray-900 border border-gray-600 text-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 px-4">
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>По возрастанию цены</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>По убыванию цены</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($tariffs as $tariff)
                        <div class="bg-gray-900 border border-gray-700 rounded-2xl p-8 text-center hover:border-indigo-500 hover:shadow-indigo-500/20 transition-all flex flex-col relative group">
                            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-transparent via-indigo-500 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            
                            <h3 class="text-2xl font-extrabold text-white mb-2">{{ $tariff->name }}</h3>
                            <div class="text-gray-400 mb-6 flex justify-center gap-4 text-sm font-medium">
                                <span class="bg-gray-800 px-3 py-1 rounded-md">{{ $tariff->slots }} слотов</span>
                                <span class="bg-gray-800 px-3 py-1 rounded-md">{{ $tariff->ram_mb }} MB RAM</span>
                            </div>
                            
                            <div class="text-4xl font-black text-indigo-400 mb-8 mt-auto">
                                {{ $tariff->price }} ₽<span class="text-lg font-normal text-gray-500">/мес</span>
                            </div>

                            @auth
                                <form action="{{ route('cart.add', $tariff->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3.5 rounded-xl hover:bg-indigo-500 shadow-lg shadow-indigo-500/30 transition-all">
                                        В корзину
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="block w-full bg-gray-700 text-gray-300 font-bold py-3.5 rounded-xl hover:bg-gray-600 hover:text-white transition-all">
                                    Войдите для покупки
                                </a>
                            @endauth
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Отзывы -->
            <div class="bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-700">
                <h2 class="text-3xl font-black text-white mb-8 flex items-center gap-3">
                    <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                    Отзывы игроков
                </h2>

                @auth
                    <form action="{{ route('review.store', $game->id) }}" method="POST" class="mb-10 p-6 bg-gray-900 rounded-xl border border-gray-700">
                        @csrf
                        <div class="mb-5 flex flex-col sm:flex-row sm:items-center gap-4">
                            <label class="font-bold text-gray-300">Ваша оценка:</label>
                            <div class="flex gap-2">
                                <select name="rating" class="bg-gray-800 border-gray-600 text-white rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="5">⭐⭐⭐⭐⭐ 5/5</option>
                                    <option value="4">⭐⭐⭐⭐ 4/5</option>
                                    <option value="3">⭐⭐⭐ 3/5</option>
                                    <option value="2">⭐⭐ 2/5</option>
                                    <option value="1">⭐ 1/5</option>
                                </select>
                            </div>
                        </div>
                        <textarea name="text" required placeholder="Поделитесь впечатлениями об игре на наших серверах..."
                            class="w-full bg-gray-800 border-gray-600 text-white rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mb-4 placeholder-gray-500"
                            rows="3"></textarea>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-500 shadow-lg shadow-indigo-500/30 transition-all">
                            Оставить отзыв
                        </button>
                    </form>
                @endauth

                <div class="space-y-6">
                    @forelse($reviews as $review)
                        <div class="p-6 bg-gray-900 border border-gray-700 rounded-xl hover:border-gray-600 transition-colors">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-2">
                                <div>
                                    <span class="font-bold text-white text-lg">{{ $review->user->name }}</span>
                                    @if($review->tariff)
                                        <div class="mt-1">
                                            <span class="text-xs font-semibold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 px-2 py-1 rounded-md">
                                                Тариф: {{ $review->tariff->name }} ({{ $review->tariff->slots }} слотов)
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <span class="text-sm text-gray-500 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $review->created_at->format('d.m.Y') }}
                                </span>
                            </div>
                            <div class="text-yellow-400 text-sm mb-3 flex items-center gap-1">
                                @for($i = 0; $i < $review->rating; $i++)
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                                @for($i = $review->rating; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-gray-700 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                            <p class="text-gray-300 leading-relaxed">{{ $review->text }}</p>
                        </div>
                    @empty
                        <div class="text-center py-10 bg-gray-900 border border-gray-700 rounded-xl">
                            <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <p class="text-gray-400 font-medium">Пока нет отзывов. Станьте первым!</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>