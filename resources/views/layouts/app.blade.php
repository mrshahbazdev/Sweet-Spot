<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sweet Spot') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen"
    x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-black/50 lg:hidden" @click="sidebarOpen = false"
            x-transition.opacity></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-30 w-64 flex-shrink-0 border-r border-slate-200 dark:border-primary/20 bg-white dark:bg-background-dark flex flex-col transition-transform duration-300 lg:static lg:translate-x-0">
            <div class="p-6 flex items-center justify-between lg:justify-start gap-3">
                <div class="flex items-center gap-3">
                    <div class="size-10 bg-primary rounded-xl flex items-center justify-center text-white">
                        <span class="material-symbols-outlined">analytics</span>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg leading-tight">{{ __('Sweet Spot') }}</h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('Strategic Analytics') }}</p>
                    </div>
                </div>
                <!-- Close Button (Mobile Only) -->
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-500 hover:text-slate-700">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <nav class="flex-1 px-4 space-y-1">
                <a href="{{ route('dashboard.sweetspot') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('dashboard.sweetspot') ? 'bg-primary text-white font-medium' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-primary/10 transition-colors' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>{{ __('Dashboard') }}</span>
                </a>
                <a href="{{ route('customers.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('customers.*') ? 'bg-primary text-white font-medium' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-primary/10 transition-colors' }}">
                    <span class="material-symbols-outlined">group</span>
                    <span>{{ __('Customers') }}</span>
                </a>
                <a href="{{ route('settings.weights.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('settings.*') ? 'bg-primary text-white font-medium' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-primary/10 transition-colors' }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span>{{ __('Settings') }}</span>
                </a>
                <a href="{{ route('team.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('team.*') || request()->routeIs('roles.*') ? 'bg-primary text-white font-medium' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-primary/10 transition-colors' }}">
                    <span class="material-symbols-outlined">group_work</span>
                    <span>{{ __('Team & Roles') }}</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-200 dark:border-primary/10">
                <div class="flex items-center gap-3 p-2 rounded-xl bg-slate-100 dark:bg-primary/5 mb-2">
                    <div class="size-8 rounded-full bg-primary/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-sm">person</span>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-semibold truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email ?? 'admin@sweetspot.com' }}
                        </p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors text-sm font-medium">
                        <span class="material-symbols-outlined">logout</span>
                        <span>{{ __('Logout') }}</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark w-full">
            <!-- Header -->
            <header
                class="sticky top-0 z-10 flex items-center justify-between px-4 lg:px-8 py-4 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-primary/20">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true"
                        class="lg:hidden size-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-primary/5 hover:bg-slate-200 dark:hover:bg-primary/20 transition-colors">
                        <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">menu</span>
                    </button>
                    <h2 class="text-lg lg:text-xl font-bold truncate hidden sm:block">
                        @yield('title', __('Customer Intelligence: Sweet Spot'))</h2>
                    @isset($header)
                        <div class="ml-4 font-semibold text-lg lg:text-xl text-gray-800 leading-tight hidden md:block">
                            {{ $header }}
                        </div>
                    @endisset
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative hidden sm:block">
                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                        <input type="text" placeholder="{{ __('Search insights...') }}"
                            class="pl-10 pr-4 py-2 bg-slate-100 dark:bg-primary/5 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary w-48 md:w-64">
                    </div>
                    <select onchange="window.location.href=this.value"
                        class="bg-transparent border-none text-sm font-medium text-slate-600 dark:text-slate-300 focus:ring-0 cursor-pointer">
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
                    @if(Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}"
                            class="size-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-primary/5 hover:bg-slate-200 dark:hover:bg-primary/20 transition-colors shrink-0">
                            <span class="material-symbols-outlined text-slate-600 dark:text-slate-300">person</span>
                        </a>
                    @endif
                </div>
            </header>

            <div class="p-4 lg:p-8 overflow-x-hidden">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>
    </div>

    @livewireScripts
</body>

</html>