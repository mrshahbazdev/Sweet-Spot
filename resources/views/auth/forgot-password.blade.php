<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Sweet Spot | Forgot Password') }}</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"
        rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#ec5b13",
                        "background-light": "#f8f6f6",
                        "background-dark": "#221610",
                    },
                    fontFamily: {
                        "display": ["Public Sans", "sans-serif"],
                        "sans": ["Public Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
</head>

<body class="bg-background-light dark:bg-background-dark min-h-screen flex flex-col font-display">
    <div class="flex-1 flex flex-col items-center justify-center px-4 py-12">
        <div
            class="w-full max-w-md bg-white dark:bg-slate-900 shadow-xl rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800">
            <div class="px-8 pt-10 pb-6 text-center">
                <div class="flex items-center justify-center gap-2 text-primary mb-8">
                    <div class="size-8 bg-primary/10 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-2xl">insights</span>
                    </div>
                    <h2 class="text-slate-900 dark:text-slate-100 text-2xl font-bold leading-tight tracking-tight">
                        {{ __('Sweet Spot') }}</h2>
                </div>
                <div class="bg-primary/5 p-4 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-primary text-4xl">lock_reset</span>
                </div>
                <h1
                    class="text-slate-900 dark:text-slate-100 text-3xl font-black leading-tight tracking-[-0.033em] mb-3">
                    {{ __('Forgot password?') }}
                </h1>
                <p class="text-slate-600 dark:text-slate-400 text-base font-normal leading-relaxed">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </p>
            </div>

            <!-- Session Status -->
            <div class="px-8">
                <x-auth-session-status class="mb-4" :status="session('status')" />
            </div>

            <form method="POST" action="{{ route('password.email') }}" class="px-8 pb-10 space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="flex flex-col gap-2">
                    <label for="email" class="text-slate-700 dark:text-slate-300 text-sm font-semibold leading-normal">
                        {{ __('Email address') }}
                    </label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">mail</span>
                        <input id="email"
                            class="form-input flex w-full rounded-xl text-slate-900 dark:text-slate-100 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary h-14 placeholder:text-slate-400 pl-12 pr-4 text-base font-normal transition-all"
                            type="email" name="email" :value="old('email')" required autofocus
                            placeholder="{{ __('e.g. name@example.com') }}" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <button type="submit"
                    class="w-full flex cursor-pointer items-center justify-center overflow-hidden rounded-xl h-14 px-5 bg-primary hover:bg-primary/90 text-white text-base font-bold leading-normal tracking-[0.015em] transition-all shadow-lg shadow-primary/20">
                    <span>{{ __('Email Password Reset Link') }}</span>
                    <span class="material-symbols-outlined ml-2 text-xl">arrow_forward</span>
                </button>

                <div class="flex flex-col items-center gap-4 pt-2">
                    <a href="{{ route('login') }}"
                        class="group flex items-center gap-2 text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary text-sm font-semibold transition-colors">
                        <span
                            class="material-symbols-outlined text-lg transition-transform group-hover:-translate-x-1">arrow_back</span>
                        <span>{{ __('Back to Login') }}</span>
                    </a>
                </div>
            </form>

            <div
                class="px-8 py-6 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 flex justify-center items-center gap-4">
                <span
                    class="text-xs text-slate-400 uppercase tracking-widest font-bold">{{ __('Secure Access') }}</span>
                <span class="material-symbols-outlined text-slate-300 dark:text-slate-600">shield_lock</span>
            </div>
        </div>

        <div class="mt-8 flex gap-6">
            <a href="#"
                class="text-slate-400 hover:text-primary text-xs font-medium transition-colors">{{ __('Help Center') }}</a>
            <a href="#"
                class="text-slate-400 hover:text-primary text-xs font-medium transition-colors">{{ __('Privacy Policy') }}</a>
            <a href="#"
                class="text-slate-400 hover:text-primary text-xs font-medium transition-colors">{{ __('Terms of Service') }}</a>
        </div>
    </div>
</body>

</html>