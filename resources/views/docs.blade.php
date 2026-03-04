<x-marketing-layout>
    <x-slot name="title">
        {{ __('Documentation') }} | Sweet Spot
    </x-slot>

    <!-- Hero Section -->
    <section
        class="relative pt-20 pb-16 lg:pt-24 lg:pb-20 overflow-hidden bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div
                class="inline-flex items-center justify-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider mb-6">
                <span class="material-symbols-outlined text-sm">menu_book</span>
                {{ __('Knowledge Base') }}
            </div>
            <h1
                class="text-4xl lg:text-5xl font-black leading-tight tracking-tight text-slate-900 dark:text-white mb-4">
                {{ __('Sweet Spot') }} <span class="text-primary">{{ __('Documentation') }}</span>
            </h1>
            <p class="text-lg text-slate-600 dark:text-slate-400">
                {{ __('Everything you need to know to get the most out of your customer intelligence platform.') }}
            </p>
        </div>
    </section>

    <!-- Docs Content -->
    <section class="py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="text-gray-900 dark:text-slate-100 prose prose-lg dark:prose-invert prose-primary max-w-none prose-headings:font-bold prose-a:text-primary">
                {!! $content !!}
            </div>
        </div>
    </section>
</x-marketing-layout>