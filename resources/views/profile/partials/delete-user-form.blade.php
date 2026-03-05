<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-200">
            {{ __('Удалить аккаунт') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('После удаления вашего аккаунта все его ресурсы и данные будут удалены безвозвратно. Пожалуйста, перед удалением скачайте любые данные, которые вы хотели бы сохранить.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-500 text-white px-6 py-2 rounded-lg font-bold shadow-lg shadow-red-500/30 transition-all"
    >{{ __('Удалить аккаунт') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-gray-800">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-200">
                {{ __('Вы уверены, что хотите удалить свой аккаунт?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                {{ __('После удаления вашего аккаунта все его ресурсы и данные будут безвозвратно удалены. Пожалуйста, введите ваш пароль, чтобы подтвердить удаление аккаунта.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Пароль') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 bg-gray-900 border-gray-700 text-white focus:border-red-500 focus:ring-red-500 rounded-lg"
                    placeholder="{{ __('Пароль') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-400" />
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" x-on:click="$dispatch('close')" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-6 py-2 rounded-lg font-bold transition-all">
                    {{ __('Отмена') }}
                </button>

                <button type="submit" class="ms-3 bg-red-600 hover:bg-red-500 text-white px-6 py-2 rounded-lg font-bold shadow-lg shadow-red-500/30 transition-all">
                    {{ __('Удалить аккаунт') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
