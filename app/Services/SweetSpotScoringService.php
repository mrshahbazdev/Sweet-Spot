<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerScore;
use App\Models\SettingsWeight;
use Illuminate\Support\Facades\DB;

class SweetSpotScoringService
{
    /**
     * Calculate scores for all customers and rank them.
     */
    public function calculateAll()
    {
        DB::transaction(function () {
            $customers = Customer::all();
            if ($customers->isEmpty()) {
                return;
            }

            $metrics = [
                'margins' => [],
                'efforts' => [],
                'repeats' => [],
                'recommendations' => []
            ];

            foreach ($customers as $customer) {
                $marginPerHour = ($customer->effort_hours > 0)
                    ? ($customer->profit_margin_eur / $customer->effort_hours)
                    : 0;

                $metrics['margins'][$customer->id] = $marginPerHour;
                $metrics['efforts'][$customer->id] = $customer->effort_hours ?? 0;
                $metrics['repeats'][$customer->id] = $customer->repeat_rate ?? 0;
                $metrics['recommendations'][$customer->id] = $customer->recommendations ?? 0;
            }

            $mins = [
                'margin' => min($metrics['margins']),
                'effort' => min($metrics['efforts']),
                'repeat' => min($metrics['repeats']),
                'recommendation' => min($metrics['recommendations'])
            ];

            $maxs = [
                'margin' => max($metrics['margins']),
                'effort' => max($metrics['efforts']),
                'repeat' => max($metrics['repeats']),
                'recommendation' => max($metrics['recommendations'])
            ];

            $weights = SettingsWeight::pluck('weight', 'criterion_key')->toArray();

            $w = [
                'profitability' => $weights['profitability'] ?? 3,
                'effort' => $weights['effort'] ?? 2,
                'chemistry' => $weights['chemistry'] ?? 2,
                'growth' => $weights['growth'] ?? 3,
                'repeat' => $weights['repeat'] ?? 2,
                'recommendation' => $weights['recommendation'] ?? 1,
                'payment' => $weights['payment'] ?? 2
            ];

            $totalWeight = array_sum($w) ?: 1;
            $customerScoresData = [];

            foreach ($customers as $customer) {
                $marginPerHour = $metrics['margins'][$customer->id];
                $effortHours = $metrics['efforts'][$customer->id];
                $repeatRate = $metrics['repeats'][$customer->id];
                $recommendations = $metrics['recommendations'][$customer->id];

                $scores = [
                    'profitability' => $this->normalizeTo5($marginPerHour, $mins['margin'], $maxs['margin']),
                    'effort' => $this->normalizeTo5Inverse($effortHours, $mins['effort'], $maxs['effort']),
                    'chemistry' => $customer->chemistry_score ?? 3, // Default 3 if missing
                    'growth' => $customer->growth_score ?? 3,
                    'repeat' => $this->normalizeTo5($repeatRate, $mins['repeat'], $maxs['repeat']),
                    'recommendation' => $this->normalizeTo5($recommendations, $mins['recommendation'], $maxs['recommendation']),
                    'payment' => $customer->payment_willingness ?? 3,
                ];

                $totalScore = (
                    ($scores['profitability'] * $w['profitability']) +
                    ($scores['effort'] * $w['effort']) +
                    ($scores['chemistry'] * $w['chemistry']) +
                    ($scores['growth'] * $w['growth']) +
                    ($scores['repeat'] * $w['repeat']) +
                    ($scores['recommendation'] * $w['recommendation']) +
                    ($scores['payment'] * $w['payment'])
                ) / $totalWeight;

                $customerScoresData[] = [
                    'customer_id' => $customer->id,
                    'margin_per_hour' => $marginPerHour,
                    'profitability_score' => $scores['profitability'],
                    'effort_score' => $scores['effort'],
                    'chemistry_score' => $scores['chemistry'],
                    'growth_score' => $scores['growth'],
                    'repeat_score' => $scores['repeat'],
                    'recommendation_score' => $scores['recommendation'],
                    'payment_score' => $scores['payment'],
                    'total_score' => round($totalScore, 2),
                ];
            }

            // Rank customers
            usort($customerScoresData, function ($a, $b) {
                return $b['total_score'] <=> $a['total_score'];
            });

            $totalCustomers = count($customerScoresData);
            $top20Count = ceil($totalCustomers * 0.20);

            $now = now();

            foreach ($customerScoresData as $index => $data) {
                $rank = $index + 1;
                $isTop = $rank <= $top20Count;

                CustomerScore::updateOrCreate(
                    ['customer_id' => $data['customer_id']],
                    [
                        'margin_per_hour' => $data['margin_per_hour'],
                        'profitability_score' => $data['profitability_score'],
                        'effort_score' => $data['effort_score'],
                        'chemistry_score' => $data['chemistry_score'],
                        'growth_score' => $data['growth_score'],
                        'repeat_score' => $data['repeat_score'],
                        'recommendation_score' => $data['recommendation_score'],
                        'payment_score' => $data['payment_score'],
                        'total_score' => $data['total_score'],
                        'rank' => $rank,
                        'top_flag' => $isTop,
                        'calculated_at' => $now
                    ]
                );
            }
        });
    }

    private function normalizeTo5($value, $min, $max)
    {
        if ($max == $min) {
            return 3; // Default middle if all values are identical
        }

        $normalized = (($value - $min) / ($max - $min)) * 4 + 1;
        return round($normalized, 2);
    }

    private function normalizeTo5Inverse($value, $min, $max)
    {
        if ($max == $min)
            return 3;
        // Inverse: smaller value gets higher score
        $normalized = (($max - $value) / ($max - $min)) * 4 + 1;
        return round($normalized, 2);
    }
}
