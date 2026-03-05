<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $game->title }}
            </h2>
            <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-sm">← Назад в
                каталог</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Инфо об игре -->
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex gap-8 items-center">
                <img src="{{ $game->image_url }}" class="w-48 h-48 object-cover rounded-lg shadow-md">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $game->title }}</h1>
                    <p class="text-lg text-gray-600">{{ $game->description }}</p>
                </div>
            </div>

            <!-- Тарифы и сортировка -->
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Тарифные планы</h2>
                    <form action="{{ route('game.show', $game->id) }}" method="GET">
                        <select name="sort" onchange="this.form.submit()" class="border-gray-300 rounded-md text-sm">
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Сначала
                                дешевые</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Сначала
                                дорогие</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($tariffs as $tariff)
                        <div
                            class="border rounded-xl p-6 text-center hover:border-indigo-500 hover:shadow-lg transition flex flex-col">
                            <h3 class="text-xl font-extrabold text-gray-900 mb-2">{{ $tariff->name }}</h3>
                            <p class="text-gray-500 mb-4">{{ $tariff->slots }} слотов | {{ $tariff->ram_mb }} MB RAM</p>
                            <div class="text-3xl font-black text-indigo-600 mb-6">{{ $tariff->price }} ₽<span
                                    class="text-sm font-normal text-gray-500">/мес</span></div>

                            @auth
                                <form action="{{ route('cart.add', $tariff->id) }}" method="POST" class="mt-auto">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-green-500 text-white font-bold py-3 rounded hover:bg-green-600 transition">В
                                        корзину</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                    class="block mt-auto w-full bg-gray-200 text-gray-700 font-bold py-3 rounded hover:bg-gray-300 transition">Войдите
                                    для покупки</a>
                            @endauth
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Отзывы -->
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Отзывы игроков</h2>

                @auth
                    <form action="{{ route('review.store', $game->id) }}" method="POST"
                        class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                        @csrf
                        <div class="mb-4 flex gap-4 items-center">
                            <label class="font-bold text-gray-700">Ваша оценка:</label>
                            <select name="rating" class="border-gray-300 rounded-md">
                                <option value="5">⭐⭐⭐⭐⭐ 5/5</option>
                                <option value="4">⭐⭐⭐⭐ 4/5</option>
                                <option value="3">⭐⭐⭐ 3/5</option>
                                <option value="2">⭐⭐ 2/5</option>
                                <option value="1">⭐ 1/5</option>
                            </select>
                        </div>
                        <textarea name="text" required placeholder="Поделитесь впечатлениями о сервере..."
                            class="w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500 mb-4"
                            rows="3"></textarea>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-md font-bold hover:bg-indigo-700">Оставить
                            отзыв</button>
                    </form>
                @endauth

                <div class="space-y-4">
                    @forelse($reviews as $review)
                        <div class="p-4 border border-gray-100 rounded-lg">
                            <div class="flex justify-between mb-2">
                                <span class="font-bold text-gray-900">{{ $review->user->name }}</span>
                                <span class="text-sm text-gray-500">{{ $review->created_at->format('d.m.Y') }}</span>
                            </div>
                            <div class="text-yellow-500 text-sm mb-2">Оценка: {{ $review->rating }} / 5</div>
                            <p class="text-gray-700">{{ $review->text }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">Пока нет отзывов.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>