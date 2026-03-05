<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-indigo-400 hover:text-indigo-300 font-black text-xl tracking-wider uppercase transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        GameHost
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Ссылка на Каталог (Витрину) -->
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-gray-300 hover:text-white">
                        {{ __('Каталог серверов') }}
                    </x-nav-link>

                    @auth
                        <!-- Ссылка на Личный кабинет -->
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300 hover:text-white">
                            {{ __('Личный кабинет') }}
                        </x-nav-link>

                        <!-- Корзина -->
                        <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')" class="text-gray-300 hover:text-white flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            {{ __('Корзина') }}
                        </x-nav-link>

                        <!-- Ссылка на Админку -->
                        @if(auth()->user()->is_admin)
                            <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')"
                                class="text-red-400 font-bold hover:text-red-300">
                                {{ __('Админ-панель') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown / Auth links -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-md text-gray-300 bg-gray-800 hover:text-white focus:outline-none transition ease-in-out duration-150">
                                <div>{{ auth()->user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-gray-800 border border-gray-700 rounded-md">
                                <x-dropdown-link :href="route('profile.edit')" class="text-gray-300 hover:bg-gray-700 hover:text-white">
                                    {{ __('Профиль') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-300 hover:bg-gray-700 hover:text-white">
                                        {{ __('Выйти') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-sm text-gray-300 hover:text-white font-bold transition">
                            {{ __('Войти') }}
                        </a>
                        <a href="{{ route('register') }}" class="text-sm bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500 font-bold transition">
                            {{ __('Регистрация') }}
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-300 hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-gray-300 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-800">
        <div class="pt-2 pb-3 space-y-1 border-t border-gray-700">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-gray-300 hover:text-white">
                {{ __('Каталог серверов') }}
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300 hover:text-white">
                    {{ __('Личный кабинет') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')" class="text-gray-300 hover:text-white">
                    {{ __('Корзина') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-700">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-200">{{ auth()->user()->name }}</div>
                    <div class="font-medium text-sm text-gray-400">{{ auth()->user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-300 hover:text-white">
                        {{ __('Профиль') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-300 hover:text-white">
                            {{ __('Выйти') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')" class="text-gray-300 hover:text-white">
                        {{ __('Войти') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')" class="text-gray-300 hover:text-white">
                        {{ __('Регистрация') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>