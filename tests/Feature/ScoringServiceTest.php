<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Customer;
use App\Models\SettingsWeight;
use App\Models\CustomerScore;
use App\Services\SweetSpotScoringService;

class ScoringServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_calculates_scores_and_ranks_correctly()
    {
        // Setup Weights
        $weights = [
            'profitability' => 3,
            'effort' => 2,
            'chemistry' => 4,
            'growth' => 3,
            'repeat' => 2,
            'recommendation' => 1,
            'payment' => 5
        ];
        foreach ($weights as $key => $weight) {
            SettingsWeight::create(['criterion_key' => $key, 'weight' => $weight]);
        }

        // Setup 3 Customers
        Customer::create([
            'name' => 'Top Customer',
            'revenue' => 10000,
            'profit_margin_eur' => 5000,
            'effort_hours' => 10,
            'chemistry_score' => 5,
            'growth_score' => 5,
            'repeat_rate' => 100,
            'recommendations' => 5,
            'payment_willingness' => 5
        ]); // Margin/hr = 500

        Customer::create([
            'name' => 'Mid Customer',
            'revenue' => 5000,
            'profit_margin_eur' => 1000,
            'effort_hours' => 20,
            'chemistry_score' => 3,
            'growth_score' => 3,
            'repeat_rate' => 50,
            'recommendations' => 2,
            'payment_willingness' => 3
        ]); // Margin/hr = 50

        Customer::create([
            'name' => 'Bad Customer',
            'revenue' => 1000,
            'profit_margin_eur' => 10,
            'effort_hours' => 50,
            'chemistry_score' => 1,
            'growth_score' => 1,
            'repeat_rate' => 0,
            'recommendations' => 0,
            'payment_willingness' => 1
        ]); // Margin/hr = 0.2

        // Run Service
        $service = new SweetSpotScoringService();
        $service->calculateAll();

        // Assertions
        $this->assertEquals(3, CustomerScore::count());

        $top = CustomerScore::whereHas('customer', function ($q) {
            $q->where('name', 'Top Customer'); })->first();
        $mid = CustomerScore::whereHas('customer', function ($q) {
            $q->where('name', 'Mid Customer'); })->first();
        $bad = CustomerScore::whereHas('customer', function ($q) {
            $q->where('name', 'Bad Customer'); })->first();

        // Ranks
        $this->assertEquals(1, $top->rank);
        $this->assertEquals(2, $mid->rank);
        $this->assertEquals(3, $bad->rank);

        // Top Flag (Top 20% of 3 is 1 (rounded up))
        $this->assertTrue((bool) $top->top_flag);
        $this->assertFalse((bool) $mid->top_flag);
        $this->assertFalse((bool) $bad->top_flag);
    }
}
