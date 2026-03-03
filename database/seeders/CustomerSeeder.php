<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $customers = [
            ['name' => 'Acme Corporation', 'industry' => 'Technology', 'revenue' => 1500000, 'profit_margin_eur' => 450000, 'effort_hours' => 200, 'chemistry_score' => 4, 'growth_score' => 5, 'repeat_rate' => 85, 'recommendations' => 3, 'payment_willingness' => 5],
            ['name' => 'Globex Corp', 'industry' => 'Financial Services', 'revenue' => 2200000, 'profit_margin_eur' => 600000, 'effort_hours' => 400, 'chemistry_score' => 3, 'growth_score' => 4, 'repeat_rate' => 90, 'recommendations' => 1, 'payment_willingness' => 4],
            ['name' => 'Cyberdyne Systems', 'industry' => 'Technology', 'revenue' => 3500000, 'profit_margin_eur' => 1000000, 'effort_hours' => 800, 'chemistry_score' => 2, 'growth_score' => 5, 'repeat_rate' => 70, 'recommendations' => 0, 'payment_willingness' => 5],
            ['name' => 'Soylent Corp', 'industry' => 'Healthcare', 'revenue' => 800000, 'profit_margin_eur' => 250000, 'effort_hours' => 150, 'chemistry_score' => 5, 'growth_score' => 3, 'repeat_rate' => 95, 'recommendations' => 5, 'payment_willingness' => 4],
            ['name' => 'Initech', 'industry' => 'Technology', 'revenue' => 500000, 'profit_margin_eur' => 100000, 'effort_hours' => 300, 'chemistry_score' => 2, 'growth_score' => 2, 'repeat_rate' => 60, 'recommendations' => 0, 'payment_willingness' => 2],
            ['name' => 'Umbrella Corp', 'industry' => 'Healthcare', 'revenue' => 5000000, 'profit_margin_eur' => 2000000, 'effort_hours' => 1200, 'chemistry_score' => 1, 'growth_score' => 4, 'repeat_rate' => 50, 'recommendations' => 0, 'payment_willingness' => 5],
            ['name' => 'Massive Dynamic', 'industry' => 'Manufacturing', 'revenue' => 1200000, 'profit_margin_eur' => 300000, 'effort_hours' => 250, 'chemistry_score' => 4, 'growth_score' => 4, 'repeat_rate' => 80, 'recommendations' => 2, 'payment_willingness' => 3],
            ['name' => 'Stark Industries', 'industry' => 'Manufacturing', 'revenue' => 8000000, 'profit_margin_eur' => 3500000, 'effort_hours' => 900, 'chemistry_score' => 3, 'growth_score' => 5, 'repeat_rate' => 90, 'recommendations' => 4, 'payment_willingness' => 5],
            ['name' => 'Wayne Enterprises', 'industry' => 'Financial Services', 'revenue' => 4500000, 'profit_margin_eur' => 1200000, 'effort_hours' => 500, 'chemistry_score' => 4, 'growth_score' => 3, 'repeat_rate' => 85, 'recommendations' => 3, 'payment_willingness' => 5],
            ['name' => 'Gekko & Co', 'industry' => 'Financial Services', 'revenue' => 900000, 'profit_margin_eur' => 400000, 'effort_hours' => 350, 'chemistry_score' => 2, 'growth_score' => 2, 'repeat_rate' => 40, 'recommendations' => 0, 'payment_willingness' => 1],
        ];

        foreach ($customers as $c) {
            Customer::create($c);
        }
    }
}
