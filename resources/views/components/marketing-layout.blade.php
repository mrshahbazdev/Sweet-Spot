<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $title ?? __('Sweet Spot | Customer Intelligence Engine') }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries,typography"></script>
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
                        "display": ["Public Sans"]
                    },
                },
            },
        }
    </script>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 transition-colors duration-200">
    <!-- Navigation -->
    <header
        class="sticky top-0 z-50 w-full border-b border-slate-200 dark:border-slate-800 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-2">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <div class="bg-primary p-1.5 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-xl">insights</span>
                        </div>
                        <span
                            class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">{{ __('Sweet Spot') }}</span>
                    </a>
                </div>
                <nav class="hidden md:flex items-center gap-8">
                    <a class="text-sm font-medium hover:text-primary transition-colors"
                        href="{{ url('/') }}#features">{{ __('Features') }}</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors"
                        href="{{ url('/') }}#pricing">{{ __('Pricing') }}</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors"
                        href="{{ url('/') }}#about">{{ __('About') }}</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors"
                        href="{{ route('docs') }}">{{ __('Documentation') }}</a>
                    <select onchange="window.location.href=this.value"
                        class="bg-transparent border-none text-sm font-medium focus:ring-0 cursor-pointer">
                        <option value="{{ route('language.switch', 'en') }}" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>EN</option>
                        <option value="{{ route('language.switch', 'es') }}" {{ app()->getLocale() == 'es' ? 'selected' : '' }}>ES</option>
                        <option value="{{ route('language.switch', 'fr') }}" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>FR</option>
                        <option value="{{ route('language.switch', 'de') }}" {{ app()->getLocale() == 'de' ? 'selected' : '' }}>DE</option>
                        <option value="{{ route('language.switch', 'zh') }}" {{ app()->getLocale() == 'zh' ? 'selected' : '' }}>ZH</option>
                        <option value="{{ route('language.switch', 'ar') }}" {{ app()->getLocale() == 'ar' ? 'selected' : '' }}>AR</option>
                        <option value="{{ route('language.switch', 'hi') }}" {{ app()->getLocale() == 'hi' ? 'selected' : '' }}>HI</option>
                        <option value="{{ route('language.switch', 'pt') }}" {{ app()->getLocale() == 'pt' ? 'selected' : '' }}>PT</option>
                        <option value="{{ route('language.switch', 'ru') }}" {{ app()->getLocale() == 'ru' ? 'selected' : '' }}>RU</option>
                        <option value="{{ route('language.switch', 'ja') }}" {{ app()->getLocale() == 'ja' ? 'selected' : '' }}>JA</option>
                    </select>
                    @auth
                        <a class="text-sm font-medium hover:text-primary transition-colors"
                            href="{{ route('dashboard.sweetspot') }}">{{ __('Dashboard') }}</a>
                    @else
                        <a class="text-sm font-medium hover:text-primary transition-colors"
                            href="{{ route('login') }}">{{ __('Login') }}</a>
                        <a href="{{ route('register') }}"
                            class="bg-primary hover:bg-primary/90 text-white px-5 py-2 rounded-xl text-sm font-bold transition-all shadow-sm">
                            {{ __('Get Started') }}
                        </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-slate-100 dark:bg-background-dark pt-20 pb-10 border-t border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-12 mb-16">
                <div class="col-span-2">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="bg-primary p-1.5 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-xl">insights</span>
                        </div>
                        <span
                            class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">{{ __('Sweet Spot') }}</span>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm max-w-xs mb-6">
                        {{ __('Leading customer intelligence for agencies who want to grow smarter, not just faster.') }}
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-slate-900 dark:text-white">{{ __('Product') }}</h4>
                    <ul class="flex flex-col gap-4 text-sm text-slate-500 dark:text-slate-400">
                        <li><a class="hover:text-primary transition-colors"
                                href="{{ route('docs') }}">{{ __('Documentation') }}</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('Features') }}</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('Pricing') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-slate-900 dark:text-white">{{ __('Company') }}</h4>
                    <ul class="flex flex-col gap-4 text-sm text-slate-500 dark:text-slate-400">
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('About Us') }}</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('Contact') }}</a></li>
                    </ul>
                </div>
            </div>
            <div
                class="pt-8 border-t border-slate-200 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-400">&copy; {{ date('Y') }}
                    {{ __('Sweet Spot Intelligence. All rights reserved.') }}
                </p>
                <p class="text-xs text-slate-400">{{ __('Handcrafted for elite agencies.') }}</p>
            </div>
        </div>
    </footer>
</body>

</html>