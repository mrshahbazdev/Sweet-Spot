<x-guest-layout>
    <div class="mb-8">
        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-6">
            <span class="material-symbols-outlined text-3xl text-primary">mark_email_read</span>
        </div>
        <h2 class="text-2xl font-black text-slate-900 mb-2">{{ __('Verify Your Email') }}</h2>
        <p class="text-sm text-slate-500 leading-relaxed">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 flex gap-3 text-sm text-green-800">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            <p>{{ __('A new verification link has been sent to the email address you provided during registration.') }}</p>
        </div>
    @endif

    <div class="mt-8 flex flex-col gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-primary/20 text-sm font-bold text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all">
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>