<?php

use Livewire\Volt\Component;
use App\Models\Customer;

new class extends Component {
    public $customerId;

    public function with()
    {
        $customer = Customer::with('score')->findOrFail($this->customerId);

        return [
            'customer' => $customer,
            'score' => $customer->score
        ];
    }
};
?>

<div>
    @section('title', 'Customer Score Detail: ' . $customer->name)

    <div class="mb-6">
        <a href="{{ route('customers.index') }}"
            class="text-sm text-slate-500 hover:text-primary transition flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Customers
        </a>
    </div>

    @if(!$score)
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                <span class="material-symbols-outlined">warning</span>
                <h3 class="font-bold text-lg">No Score Available</h3>
            </div>
            <p>This customer hasn't been scored yet. Please recalculate scoring from the dashboard.</p>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Summary Card -->
            <div
                class="lg:col-span-1 bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex flex-col items-center text-center">
                <div
                    class="size-20 bg-slate-100 rounded-full flex items-center justify-center mb-4 text-3xl font-bold text-slate-400">
                    {{ substr($customer->name, 0, 1) }}
                </div>
                <h3 class="text-2xl font-bold mb-1">{{ $customer->name }}</h3>
                <p class="text-slate-500 mb-6">{{ $customer->industry }}</p>

                <div class="w-full pt-6 border-t border-slate-100">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Total Score</p>
                    <div class="text-5xl font-black text-primary mb-2">{{ number_format($score->total_score, 1) }}</div>

                    @if($score->top_flag)
                        <div class="inline-block px-3 py-1 bg-primary/10 text-primary font-bold rounded-lg text-sm">
                            TOP 20% CUSTOMER
                        </div>
                    @else
                        <div class="inline-block px-3 py-1 bg-slate-100 text-slate-600 font-bold rounded-lg text-sm">
                            STANDARD TIER
                        </div>
                    @endif
                </div>
            </div>

            <!-- Detailed Metrics -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                <h3 class="text-lg font-bold mb-6">Score Breakdown (1-5 Scale)</h3>

                <div class="space-y-6">
                    <div class="grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-4 font-medium text-slate-600">Profitability</div>
                        <div class="col-span-6 bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-primary h-full" style="width: {{ ($score->profitability_score / 5) * 100 }}%">
                            </div>
                        </div>
                        <div class="col-span-2 text-right font-bold">{{ $score->profitability_score }}</div>
                    </div>

                    <div class="grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-4 font-medium text-slate-600">Effort (Inversed)</div>
                        <div class="col-span-6 bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-primary h-full opacity-90"
                                style="width: {{ ($score->effort_score / 5) * 100 }}%"></div>
                        </div>
                        <div class="col-span-2 text-right font-bold">{{ $score->effort_score }}</div>
                    </div>

                    <div class="grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-4 font-medium text-slate-600">Chemistry</div>
                        <div class="col-span-6 bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-primary h-full opacity-80"
                                style="width: {{ ($score->chemistry_score / 5) * 100 }}%"></div>
                        </div>
                        <div class="col-span-2 text-right font-bold">{{ $score->chemistry_score }}</div>
                    </div>

                    <div class="grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-4 font-medium text-slate-600">Growth Potential</div>
                        <div class="col-span-6 bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-primary h-full opacity-70"
                                style="width: {{ ($score->growth_score / 5) * 100 }}%"></div>
                        </div>
                        <div class="col-span-2 text-right font-bold">{{ $score->growth_score }}</div>
                    </div>

                    <div class="grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-4 font-medium text-slate-600">Repeat Rate</div>
                        <div class="col-span-6 bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-primary h-full opacity-60"
                                style="width: {{ ($score->repeat_score / 5) * 100 }}%"></div>
                        </div>
                        <div class="col-span-2 text-right font-bold">{{ $score->repeat_score }}</div>
                    </div>
                </div>
            </div>

            <!-- Raw Data Reference -->
            <div class="lg:col-span-3 bg-slate-50 border border-slate-200 rounded-xl p-6 mt-4">
                <h4 class="font-bold text-sm text-slate-500 uppercase tracking-wider mb-4">Raw Input Data</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="block text-slate-400">Revenue</span>
                        <span class="font-medium">€{{ number_format($customer->revenue, 2) }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400">Margin EUR</span>
                        <span class="font-medium">€{{ number_format($customer->profit_margin_eur, 2) }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400">Effort Hours</span>
                        <span class="font-medium">{{ $customer->effort_hours }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400">Margin / Hour</span>
                        <span
                            class="font-medium font-bold text-primary">€{{ number_format($score->margin_per_hour, 2) }}/hr</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>