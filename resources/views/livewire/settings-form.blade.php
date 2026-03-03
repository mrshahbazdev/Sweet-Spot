<?php

use Livewire\Volt\Component;
use App\Models\SettingsWeight;

new class extends Component {
    public $weights = [];
    public $saved = false;

    public function mount()
    {
        $dbWeights = SettingsWeight::pluck('weight', 'criterion_key')->toArray();

        $this->weights = [
            'profitability' => $dbWeights['profitability'] ?? 3,
            'effort' => $dbWeights['effort'] ?? 2,
            'chemistry' => $dbWeights['chemistry'] ?? 2,
            'growth' => $dbWeights['growth'] ?? 3,
            'repeat' => $dbWeights['repeat'] ?? 2,
            'recommendation' => $dbWeights['recommendation'] ?? 1,
            'payment' => $dbWeights['payment'] ?? 2,
        ];
    }

    public function save()
    {
        foreach ($this->weights as $key => $weight) {
            SettingsWeight::updateOrCreate(
                ['criterion_key' => $key],
                ['weight' => (int) $weight]
            );
        }

        $this->saved = true;
        $this->dispatch('weights-saved');
    }
};
?>

<div>
    @section('title', 'Scoring Settings & Weights')

    <div class="bg-white rounded-xl border border-slate-200 p-8 shadow-sm max-w-2xl mx-auto">
        <h3 class="text-xl font-bold mb-2">{{ __('Adjust Scoring Engine Weights') }}</h3>
        <p class="text-slate-500 mb-8">Define how much influence each criterion has on the final Sweet Spot score. 1 is
            Lowest impact, 5 is Highest impact.</p>

        <div x-data="{ show: false }" x-on:weights-saved.window="show = true; setTimeout(() => show = false, 4000)"
            x-show="show" x-transition.opacity style="display: none;"
            class="mb-6 bg-emerald-50 text-emerald-600 border border-emerald-200 px-4 py-3 rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="font-medium text-sm">Settings saved successfully! You may want to recalculate scores
                now.</span>
        </div>

        <form wire:submit="save" class="space-y-6">

            @php
                $criteria = [
                    'profitability' => ['label' => 'Profitability (Margin/Hour)', 'desc' => 'Importance of high financial yield per hour invested.'],
                    'effort' => ['label' => 'Effort (Inverse)', 'desc' => 'Importance of low effort customers (automation/hands-off).'],
                    'chemistry' => ['label' => 'Chemistry', 'desc' => 'Importance of a good working relationship.'],
                    'growth' => ['label' => 'Growth Potential', 'desc' => 'Importance of future upselling or expansion capabilities.'],
                    'repeat' => ['label' => 'Repeat Rate', 'desc' => 'Importance of steady, repeating revenue.'],
                    'recommendation' => ['label' => 'Referrals via Network', 'desc' => 'Importance of new leads generated through this customer.'],
                    'payment' => ['label' => 'Payment Willingness', 'desc' => 'Importance of fast, hassle-free payment habits.'],
                ];
            @endphp

            @foreach($criteria as $key => $info)
                <div class="space-y-2">
                    <div class="flex justify-between items-end">
                        <div>
                            <label class="block font-bold text-slate-700">{{ $info['label'] }}</label>
                            <p class="text-xs text-slate-400">{{ $info['desc'] }}</p>
                        </div>
                        <span class="text-2xl font-black text-primary">{{ $weights[$key] }}</span>
                    </div>
                    <input type="range" wire:model.live="weights.{{ $key }}" min="1" max="5" step="1"
                        class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-primary">
                    <div class="flex justify-between text-[10px] font-bold text-slate-400 tracking-wider">
                        <span>1 - LOW</span>
                        <span>2</span>
                        <span>3 - MED</span>
                        <span>4</span>
                        <span>5 - HIGH</span>
                    </div>
                </div>
                <hr class="border-slate-100">
            @endforeach

            <div class="pt-4 flex items-center justify-between">
                <a href="{{ route('sweetspot.calculate') }}"
                    class="text-sm font-bold text-primary hover:underline">{{ __('Recalculate Now ↗') }}</a>

                <button type="submit"
                    class="px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-orange-700 transition shadow-lg shadow-primary/30 flex items-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    {{ __('Save Weights') }}
                </button>
            </div>
        </form>
    </div>


</div>