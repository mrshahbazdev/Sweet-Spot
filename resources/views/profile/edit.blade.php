<x-app-layout>
    @section('title', __('User Profile Settings'))

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div class="space-y-1">
            <h1 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                {{ __('Profile Settings') }}
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-lg">
                {{ __('Manage your account credentials and personal preferences.') }}</p>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-8">
            <div class="p-4 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-2xl">
                <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white border border-slate-200 shadow-sm rounded-2xl">
                <div class="max-w-2xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-red-50 border border-red-200 shadow-sm rounded-2xl">
                <div class="max-w-2xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>