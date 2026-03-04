<?php

use Livewire\Volt\Component;
use App\Models\Customer;
use App\Models\CustomerScore;

new class extends Component {
    public function with()
    {
        $totalCustomers = Customer::count();
        $averageScore = CustomerScore::avg('total_score') ?? 0;
        $topCustomersCount = CustomerScore::where('top_flag', true)->count();
        $topPercent = $totalCustomers > 0 ? ($topCustomersCount / $totalCustomers) * 100 : 0;

        $topCustomers = CustomerScore::with('customer')
            ->whereHas('customer')
            ->orderByDesc('total_score')
            ->take(10)
            ->get();

        $allScores = CustomerScore::with('customer')
            ->whereHas('customer')
            ->get();

        return [
            'totalCustomers' => $totalCustomers,
            'averageScore' => round($averageScore, 1),
            'topPercent' => round($topPercent, 1),
            'topCustomers' => $topCustomers,
            'allScores' => $allScores,
            'totalRevenue' => Customer::sum('revenue') ?? 0,
        ];
    }
};
?>

<div>
    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-sm font-medium text-slate-500">{{ __('Total Customers') }}</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-3xl font-bold">{{ number_format($totalCustomers) }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-sm font-medium text-slate-500">{{ __('Average Score') }}</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-3xl font-bold">{{ $averageScore }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-sm font-medium text-slate-500">{{ __('Top Customers %') }}</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-3xl font-bold">{{ $topPercent }}%</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-sm font-medium text-slate-500">{{ __('Total Revenue') }}</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-3xl font-bold">€{{ number_format($totalRevenue, 2) }}</h3>
            </div>
        </div>
    </div>

    <!-- Main Analytics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
        <!-- Quadrant Graph -->
        <div
            class="lg:col-span-8 bg-white dark:bg-primary/5 rounded-xl border border-slate-200 dark:border-primary/20 p-6 flex flex-col shadow-sm">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-lg font-bold">{{ __('Profitability vs Effort') }}</h3>
                    <p class="text-sm text-slate-500">{{ __('Resource allocation efficiency') }}</p>
                </div>
                <div class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full">
                    {{ __('OPTIMAL GROWTH ZONE') }}
                </div>
            </div>
            <div class="relative flex-1 min-h-[400px] border-l border-b border-slate-300 dark:border-slate-700 m-8">
                <!-- Effort Axis Label -->
                <div
                    class="absolute -left-12 top-1/2 -rotate-90 text-xs font-bold text-slate-400 uppercase tracking-widest">
                    {{ __('Profitability') }}
                </div>
                <!-- Profitability Axis Label -->
                <div
                    class="absolute -bottom-10 left-1/2 -translate-x-1/2 text-xs font-bold text-slate-400 uppercase tracking-widest">
                    {{ __('Customer Effort') }}
                </div>

                <!-- Quadrant Dividers -->
                <div class="absolute inset-0 flex">
                    <div class="w-1/2 h-full border-r border-dashed border-slate-200 dark:border-slate-800"></div>
                </div>
                <div class="absolute inset-0 flex flex-col">
                    <div class="h-1/2 w-full border-b border-dashed border-slate-200 dark:border-slate-800"></div>
                </div>

                <!-- Data Points (SVG/HTML) -->
                <div class="absolute inset-0">
                    <!-- Example Bubbles representing Customers -->
                    <!-- In a real dynamic scenario, these could be looped over topCustomers -->
                    @foreach($allScores as $index => $score)
                        @php
                            // Determine relative position based on Effort (X) and Profitability (Y)
                            // Lower effort = left side (0-50%), Higher profitability = top side (0-50%)
                            $effortScale = min(max(($score->customer->effort_hours ?? 50) / 100 * 100, 5), 95); // Example scaling
                            $profitScale = min(max(($score->customer->profit_margin_eur ?? 500) / 1000 * 100, 5), 95); // Example scaling
                            $xPos = $effortScale;
                            $yPos = 100 - $profitScale;
                            $sizeClasses = $score->top_flag ? 'size-12 bg-primary/40 border-primary animate-pulse' : 'size-6 bg-slate-400/20 border-slate-400/40 opacity-60 hover:opacity-100 z-10 hover:z-20';
                        @endphp
                        <div class="absolute rounded-full border-2 flex items-center justify-center text-[10px] font-bold group {{ $sizeClasses }}"
                            style="top: {{ $yPos }}%; left: {{ $xPos }}%;">
                            @if($score->top_flag)
                                <span
                                    class="opacity-0 group-hover:opacity-100 absolute -top-8 bg-slate-800 text-white px-2 py-1 rounded text-xs whitespace-nowrap transition-opacity z-50">
                                    {{ $score->customer->name }} (Top)
                                </span>
                            @else
                                <span
                                    class="opacity-0 group-hover:opacity-100 absolute -top-8 bg-slate-600 text-white px-2 py-1 rounded text-xs whitespace-nowrap transition-opacity z-50">
                                    {{ $score->customer->name }}
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Industry Breakdown -->
        <div
            class="lg:col-span-4 bg-white dark:bg-primary/5 rounded-xl border border-slate-200 dark:border-primary/20 p-6 shadow-sm">
            <h3 class="text-lg font-bold mb-6">{{ __('Industry Breakdown') }}</h3>
            <div class="space-y-6">
                @php
                    // Aggregate customer counts by industry
                    $industries = \App\Models\Customer::select('industry', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                        ->groupBy('industry')
                        ->orderByDesc('total')
                        ->take(5)
                        ->get();
                    $totalIndustry = \App\Models\Customer::count();
                @endphp
                @foreach($industries as $index => $industryData)
                    @php
                        $percentage = $totalIndustry > 0 ? round(($industryData->total / $totalIndustry) * 100) : 0;
                        $bgOpacity = max(20, 100 - ($index * 20));
                        $barColor = $index === 0 ? 'bg-primary' : "bg-primary/$bgOpacity";
                    @endphp
                    <div class="relative pt-1">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium">{{ $industryData->industry ?? __('Other') }}</span>
                            <span class="text-xs font-bold text-primary">{{ $percentage }}%</span>
                        </div>
                        <div class="overflow-hidden h-2 text-xs flex rounded bg-slate-100 dark:bg-slate-800">
                            <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center {{ $barColor }}"
                                style="width:{{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
                @if($industries->isEmpty())
                    <p class="text-sm text-slate-500 text-center py-8">{{ __('No industry data available yet.') }}</p>
                @endif
            </div>

            <div class="mt-8 p-4 bg-primary/5 rounded-xl border border-primary/10">
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed italic">
                    {{ __('"Industry focus based on current customer base."') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Top Customers Table -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50">
            <h3 class="text-lg font-bold">{{ __('Top 10 Customers') }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3">{{ __('Rank') }}</th>
                        <th class="px-6 py-3">{{ __('Customer Name') }}</th>
                        <th class="px-6 py-3">{{ __('Industry') }}</th>
                        <th class="px-6 py-3">{{ __('Score') }}</th>
                        <th class="px-6 py-3">{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($topCustomers as $score)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-primary">#{{ $score->rank }}</td>
                            <td class="px-6 py-4 font-medium">{{ $score->customer->name }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $score->customer->industry }}</td>
                            <td class="px-6 py-4 font-bold">{{ number_format($score->total_score, 2) }}</td>
                            <td class="px-6 py-4">
                                @if($score->top_flag)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-black bg-primary text-white">TOP</span>
                                @else
                                    <span
                                        class="px-2 py-0.5 rounded text-[10px] font-black bg-slate-300 text-slate-700">STD</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                {{ __('No scored customers found. Adjust weights and recalculate to see top customers.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>