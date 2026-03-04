<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Sweet Spot - Register') }}</title>

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
                        "display": ["Public Sans"],
                        "sans": ["Public Sans", "sans-serif"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen">
    <div class="flex flex-col lg:flex-row min-h-screen">

        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-primary/10">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/40 to-primary/80 mix-blend-multiply z-10"></div>
            <div class="absolute inset-0 z-0 bg-cover bg-center"
                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCTFNExvPEMIx_K21wndwFsy0Xio6sGPaRYOrauXhRbSgsR9HHlbVvmgwelNtSfUCmCrrCpZfi0Dvu1LgFN0RHv0v5Q-A98CU4wl5x-KIejA-i7wiFziZ4a6kS7KV2UPAPi3arbQHEkdIiNfwQq3V8UqNaMqfdV6M3XaWnxIyKTN6B4yBzIjmg2XHkohUIefX3y_8OVNEb8nF_7QugMLCDmqgRMCjdykdeCvGowmFN0Vbp0SBWC_XlN2_PtomlheFo4LbU2Eyk9kkM')">
            </div>
            <div class="relative z-20 flex flex-col justify-between p-12 h-full text-white">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-4xl">insights</span>
                    <h1 class="text-2xl font-bold tracking-tight">Sweet Spot</h1>
                </div>
                <div class="max-w-md">
                    <h2 class="text-5xl font-extrabold leading-tight mb-6">
                        {{ __('Empower your sweet business today.') }}</h2>
                    <p class="text-xl opacity-90 leading-relaxed">
                        {{ __("Join agencies and studios managing their ideal clients with Sweet Spot's intuitive tools.") }}
                    </p>
                </div>
                <div class="flex gap-4">
                    <p class="text-sm font-medium self-center">{{ __('Trusted by top-tier consultants') }}</p>
                </div>
            </div>
        </div>

        <div
            class="flex-1 flex flex-col justify-center px-6 py-12 lg:px-24 bg-background-light dark:bg-background-dark">
            <div class="max-w-md w-full mx-auto">
                <div class="lg:hidden flex items-center gap-2 mb-10 text-primary">
                    <span class="material-symbols-outlined text-3xl">insights</span>
                    <h1 class="text-xl font-bold tracking-tight">Sweet Spot</h1>
                </div>

                <div class="mb-10">
                    <h2 class="text-3xl font-extrabold text-slate-900 dark:text-slate-100">{{ __('Create an account') }}
                    </h2>
                    <p class="mt-2 text-slate-600 dark:text-slate-400">
                        {{ __('Start optimizing your client roster today.') }}</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 gap-5">
                        <!-- Name -->
                        <label class="block">
                            <span
                                class="text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1 mb-1 block">{{ __('Full Name') }}</span>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined text-slate-400 text-lg">person</span>
                                </div>
                                <input id="name"
                                    class="block w-full pl-11 pr-4 py-3.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none text-slate-900 dark:text-slate-100"
                                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                    placeholder="{{ __('John Doe') }}" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </label>

                        <!-- Email -->
                        <label class="block">
                            <span
                                class="text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1 mb-1 block">{{ __('Work Email') }}</span>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined text-slate-400 text-lg">mail</span>
                                </div>
                                <input id="email"
                                    class="block w-full pl-11 pr-4 py-3.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none text-slate-900 dark:text-slate-100"
                                    type="email" name="email" :value="old('email')" required autocomplete="username"
                                    placeholder="{{ __('john@company.com') }}" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </label>

                        <!-- Password -->
                        <label class="block">
                            <span
                                class="text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1 mb-1 block">{{ __('Password') }}</span>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined text-slate-400 text-lg">lock</span>
                                </div>
                                <input id="password"
                                    class="block w-full pl-11 pr-4 py-3.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none text-slate-900 dark:text-slate-100"
                                    type="password" name="password" required autocomplete="new-password"
                                    placeholder="••••••••" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </label>

                        <label class="block">
                            <span
                                class="text-sm font-semibold text-slate-700 dark:text-slate-300 ml-1 mb-1 block">{{ __('Confirm Password') }}</span>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined text-slate-400 text-lg">lock</span>
                                </div>
                                <input id="password_confirmation"
                                    class="block w-full pl-11 pr-4 py-3.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none text-slate-900 dark:text-slate-100"
                                    type="password" name="password_confirmation" required autocomplete="new-password"
                                    placeholder="••••••••" />
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </label>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full flex justify-center items-center py-4 px-4 border border-transparent rounded-xl text-base font-bold text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors shadow-lg shadow-primary/20">
                            {{ __('Create Account') }}
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-slate-600 dark:text-slate-400">
                        {{ __('Already have an account?') }}
                        <a class="text-primary font-bold hover:underline ml-1"
                            href="{{ route('login') }}">{{ __('Log in here') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>