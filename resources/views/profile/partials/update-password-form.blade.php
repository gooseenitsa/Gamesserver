<section>
    <header>
        <h2 class="text-lg font-medium text-gray-200">
            {{ __('Обновить пароль') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('Убедитесь, что ваш аккаунт использует длинный и случайный пароль для безопасности.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Текущий пароль')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-400" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Новый пароль')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-400" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Подтвердите пароль')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-gray-900 border-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-lg font-bold shadow-lg shadow-indigo-500/30 transition-all">
                {{ __('Сохранить') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-400 font-medium"
                >{{ __('Сохранено.') }}</p>
            @endif
        </div>
    </form>
</section>
