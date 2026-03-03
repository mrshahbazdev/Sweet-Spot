<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class CustomerFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_customer_using_volt_component()
    {
        $user = User::factory()->create();

        Volt::actingAs($user)
            ->test('customer-table')
            ->set('name', 'Test Corp')
            ->set('industry', 'Healthcare')
            ->set('revenue', 10000)
            ->set('profit_margin_eur', 500)
            ->set('effort_hours', 10)
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('customers', [
            'name' => 'Test Corp',
            'industry' => 'Healthcare',
        ]);
    }
}
