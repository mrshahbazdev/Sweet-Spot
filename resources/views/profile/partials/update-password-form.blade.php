<section>
    <header>
        <h2 class="text-xl font-bold text-slate-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password"
                class="block text-sm font-bold text-slate-700 mb-2">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="w-full px-4 py-2 bg-slate-50 border-slate-200 rounded-lg focus:ring-2 focus:ring-primary"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')"
                class="mt-2 text-red-500 text-xs" />
        </div>

        <div>
            <label for="update_password_password"
                class="block text-sm font-bold text-slate-700 mb-2">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password"
                class="w-full px-4 py-2 bg-slate-50 border-slate-200 rounded-lg focus:ring-2 focus:ring-primary"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-500 text-xs" />
        </div>

        <div>
            <label for="update_password_password_confirmation"
                class="block text-sm font-bold text-slate-700 mb-2">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="w-full px-4 py-2 bg-slate-50 border-slate-200 rounded-lg focus:ring-2 focus:ring-primary"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                class="mt-2 text-red-500 text-xs" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="px-6 py-2 bg-primary text-white font-bold rounded-xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-green-600 bg-green-50 px-3 py-1 rounded-md">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>