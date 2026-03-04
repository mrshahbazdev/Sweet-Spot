<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ __('Sweet Spot | Customer Intelligence Engine') }}</title>
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
                        "display": ["Public Sans"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
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
                    <div class="bg-primary p-1.5 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-xl">insights</span>
                    </div>
                    <span
                        class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">{{ __('Sweet Spot') }}</span>
                </div>
                <nav class="hidden md:flex items-center gap-8">
                    <a class="text-sm font-medium hover:text-primary transition-colors"
                        href="#features">{{ __('Features') }}</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors"
                        href="#pricing">{{ __('Pricing') }}</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors"
                        href="#about">{{ __('About') }}</a>
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
                <div class="md:hidden">
                    <span class="material-symbols-outlined cursor-pointer">menu</span>
                </div>
            </div>
        </div>
    </header>
    <!-- Hero Section -->
    <section class="relative pt-20 pb-16 lg:pt-32 lg:pb-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="flex flex-col gap-8 text-left">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider w-fit">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        {{ __('New: Advanced Profitability Quadrants') }}
                    </div>
                    <h1
                        class="text-5xl lg:text-7xl font-black leading-tight tracking-tight text-slate-900 dark:text-white">
                        {{ __('Identify Your Most') }} <span class="text-primary">{{ __('Profitable') }}</span>
                        {{ __('Customers') }}
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-400 max-w-xl">
                        {{ __("Sweet Spot's weighted scoring engine turns raw data into actionable insights, helping you focus on the clients that actually drive growth.") }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            <a href="{{ route('dashboard.sweetspot') }}"
                                class="bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-xl text-base font-bold transition-all shadow-lg flex items-center justify-center gap-2 w-fit">
                                {{ __('Go to Dashboard') }} <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="bg-primary hover:bg-primary/90 text-white px-8 py-4 rounded-xl text-base font-bold transition-all shadow-lg flex items-center justify-center gap-2 w-fit">
                                {{ __('Start Free Trial') }} <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                            <button
                                class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white px-8 py-4 rounded-xl text-base font-bold transition-all hover:bg-slate-50 dark:hover:bg-slate-700">
                                {{ __('Book a Demo') }}
                            </button>
                        @endauth
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -inset-4 bg-primary/20 rounded-3xl blur-3xl opacity-30"></div>
                    <div
                        class="relative bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 p-2 overflow-hidden aspect-video">
                        <img class="rounded-xl w-full h-full object-cover"
                            data-alt="Modern SaaS dashboard showing customer profitability charts and scoring analytics"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuC12CMYo8u2gc3qmTdq4dojRH95OKBfWMEPAiLHLY6DvkPRsJW7J05AeIrWBjQJ2ZuMKWqptRNe4ZxHsla3dtm83tRCJVMmTiADQo62IG3qhqsqEqlwiciQgukJHMrNirY0fvj3Fm_waVkD2QPA3dMtCYin6UhRfDoXXHmjiSp4vYLmCzGC20N7RpFGbvkqxkSnpeVsucmplZy3nrJZ-HGbj0klnUuEAM0pOI-fOPXJYtq3GMOzL2Rd2kBsgWtB1tWf2HWr2kUqPxE" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Social Proof -->
    <section class="py-12 border-y border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-background-dark/30">
        <div class="max-w-7xl mx-auto px-4">
            <p class="text-center text-sm font-semibold text-slate-500 uppercase tracking-widest mb-8">
                {{ __('Trusted by Industry Leaders') }}
            </p>
            <div
                class="flex flex-wrap justify-center gap-8 md:gap-16 opacity-50 grayscale hover:grayscale-0 transition-all">
                <div class="flex items-center gap-2 text-xl font-bold"> <span
                        class="material-symbols-outlined text-primary">auto_graph</span> GrowthLogic</div>
                <div class="flex items-center gap-2 text-xl font-bold"> <span
                        class="material-symbols-outlined text-primary">account_balance</span> FinScale</div>
                <div class="flex items-center gap-2 text-xl font-bold"> <span
                        class="material-symbols-outlined text-primary">rocket_launch</span> StarVault</div>
                <div class="flex items-center gap-2 text-xl font-bold"> <span
                        class="material-symbols-outlined text-primary">hub</span> NexusCorp</div>
            </div>
        </div>
    </section>
    <!-- Problem/Solution Section -->
    <section class="py-24 bg-background-light dark:bg-background-dark">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-6">
                {{ __('Stop Guessing, Start Growing.') }}
            </h2>
            <p class="text-xl text-slate-600 dark:text-slate-400 mb-16 leading-relaxed">
                {{ __("Most agencies and B2B companies waste 40% of their time on clients that aren't profitable. Sweet Spot transforms raw customer data into actionable rankings using specialized scores for profitability, effort, and chemistry.") }}
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="p-8 rounded-2xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-primary mb-4 flex justify-center"><span
                            class="material-symbols-outlined text-4xl">payments</span></div>
                    <h3 class="font-bold text-lg mb-2">{{ __('Profitability') }}</h3>
                    <p class="text-sm text-slate-500">{{ __('Real-time tracking of revenue vs. resource cost.') }}</p>
                </div>
                <div
                    class="p-8 rounded-2xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-primary mb-4 flex justify-center"><span
                            class="material-symbols-outlined text-4xl">speed</span></div>
                    <h3 class="font-bold text-lg mb-2">{{ __('Effort') }}</h3>
                    <p class="text-sm text-slate-500">{{ __('Measure account management hours and friction.') }}</p>
                </div>
                <div
                    class="p-8 rounded-2xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-primary mb-4 flex justify-center"><span
                            class="material-symbols-outlined text-4xl">favorite</span></div>
                    <h3 class="font-bold text-lg mb-2">{{ __('Chemistry') }}</h3>
                    <p class="text-sm text-slate-500">{{ __('Subjective alignment scores from your frontline team.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- Features Showcase -->
    <section class="py-24 bg-slate-50 dark:bg-slate-900/20" id="features">
        <div class="max-w-7xl mx-auto px-4">
            <div class="mb-16 text-left max-w-2xl">
                <h2 class="text-4xl font-black text-slate-900 dark:text-white mb-4">
                    {{ __('Powerful Features for Precise Growth') }}
                </h2>
                <p class="text-slate-600 dark:text-slate-400">
                    {{ __("Everything you need to master your customer portfolio and maximize your agency's efficiency.") }}
                </p>
            </div>
            <div class="grid lg:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div
                    class="group flex flex-col gap-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-8 hover:border-primary/50 transition-all">
                    <div
                        class="h-12 w-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all">
                        <span class="material-symbols-outlined">tune</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">
                            {{ __('Granular Scoring Engine') }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('Define custom weights on a 1-5 scale for every metric to match your unique business goals and service model.') }}
                        </p>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div
                    class="group flex flex-col gap-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-8 hover:border-primary/50 transition-all">
                    <div
                        class="h-12 w-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all">
                        <span class="material-symbols-outlined">bubble_chart</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ __('Advanced Analytics') }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('Visualize your portfolio with our Profitability vs. Effort quadrant and Top 10 rankings. See who to nurture and who to fire.') }}
                        </p>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div
                    class="group flex flex-col gap-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-8 hover:border-primary/50 transition-all">
                    <div
                        class="h-12 w-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ __('Team Collaboration') }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ __('Scale with confidence using granular roles and permissions. Collect data from account managers effortlessly.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Pricing Section -->
    <section class="py-24 bg-background-light dark:bg-background-dark" id="pricing">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-slate-900 dark:text-white mb-4">
                    {{ __('Simple, Transparent Pricing') }}
                </h2>
                <p class="text-slate-600 dark:text-slate-400">
                    {{ __('Scale your intelligence as your customer base grows.') }}
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Starter -->
                <div
                    class="flex flex-col p-8 rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
                    <div class="mb-8">
                        <h3 class="text-lg font-bold mb-2">{{ __('Starter') }}</h3>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-black text-slate-900 dark:text-white">$49</span>
                            <span class="text-slate-500">{{ __('/mo') }}</span>
                        </div>
                        <p class="text-sm text-slate-500 mt-2 italic">{{ __('For growing small agencies') }}</p>
                    </div>
                    <ul class="flex flex-col gap-4 mb-8 flex-1">
                        <li class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                            {{ __('Up to 20 Clients') }}
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                            {{ __('Basic Scoring Engine') }}
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                            {{ __('2 Team Members') }}
                        </li>
                    </ul>
                    <button
                        class="w-full py-3 px-4 rounded-xl border border-slate-200 dark:border-slate-700 font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">{{ __('Choose Starter') }}</button>
                </div>
                <!-- Pro -->
                <div
                    class="flex flex-col p-8 rounded-3xl border-2 border-primary bg-white dark:bg-slate-900 relative shadow-xl transform scale-105">
                    <div
                        class="absolute -top-4 left-1/2 -translate-x-1/2 bg-primary text-white px-4 py-1 rounded-full text-xs font-bold uppercase">
                        {{ __('Most Popular') }}
                    </div>
                    <div class="mb-8">
                        <h3 class="text-lg font-bold mb-2">{{ __('Professional') }}</h3>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-black text-slate-900 dark:text-white">$149</span>
                            <span class="text-slate-500">{{ __('/mo') }}</span>
                        </div>
                        <p class="text-sm text-slate-500 mt-2 italic">{{ __('For performance-driven firms') }}</p>
                    </div>
                    <ul class="flex flex-col gap-4 mb-8 flex-1">
                        <li class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                            {{ __('Unlimited Clients') }}
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                            {{ __('Advanced Quadrant View') }}
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                            {{ __('10 Team Members') }}
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                            {{ __('CRM Integration') }}
                        </li>
                    </ul>
                    <button
                        class="w-full py-3 px-4 rounded-xl bg-primary text-white font-bold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">{{ __('Get Started Now') }}</button>
                </div>
                <!-- Enterprise -->
                <div
                    class="flex flex-col p-8 rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
                    <div class="mb-8">
                        <h3 class="text-lg font-bold mb-2">{{ __('Enterprise') }}</h3>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-black text-slate-900 dark:text-white">$499</span>
                            <span class="text-slate-500">{{ __('/mo') }}</span>
                        </div>
                        <p class="text-sm text-slate-500 mt-2 italic">{{ __('For global enterprises') }}</p>
                    </div>
                    <ul class="flex flex-col gap-4 mb-8 flex-1">
                        <li class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                            {{ __('Dedicated Account Manager') }}
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                            {{ __('Custom Data Processing') }}
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                            {{ __('Unlimited Teams') }}
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                            {{ __('SSO & Advanced Security') }}
                        </li>
                    </ul>
                    <button
                        class="w-full py-3 px-4 rounded-xl border border-slate-200 dark:border-slate-700 font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">{{ __('Contact Sales') }}</button>
                </div>
            </div>
        </div>
    </section>
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
                    <div class="flex gap-4">
                        <a class="h-10 w-10 rounded-full border border-slate-300 dark:border-slate-700 flex items-center justify-center hover:bg-primary hover:text-white transition-all"
                            href="#">
                            <span class="material-symbols-outlined text-lg">public</span>
                        </a>
                        <a class="h-10 w-10 rounded-full border border-slate-300 dark:border-slate-700 flex items-center justify-center hover:bg-primary hover:text-white transition-all"
                            href="#">
                            <span class="material-symbols-outlined text-lg">mail</span>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-slate-900 dark:text-white">{{ __('Product') }}</h4>
                    <ul class="flex flex-col gap-4 text-sm text-slate-500 dark:text-slate-400">
                        <li><a class="hover:text-primary transition-colors"
                                href="{{ route('docs') }}">{{ __('Documentation') }}</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('Features') }}</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('Analytics') }}</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('Integrations') }}</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('Pricing') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-slate-900 dark:text-white">{{ __('Company') }}</h4>
                    <ul class="flex flex-col gap-4 text-sm text-slate-500 dark:text-slate-400">
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('About Us') }}</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('Careers') }}</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('Blog') }}</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('Contact') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-slate-900 dark:text-white">{{ __('Legal') }}</h4>
                    <ul class="flex flex-col gap-4 text-sm text-slate-500 dark:text-slate-400">
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('Privacy Policy') }}</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('Terms of Service') }}</a>
                        </li>
                        <li><a class="hover:text-primary transition-colors" href="#">{{ __('Cookie Policy') }}</a></li>
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