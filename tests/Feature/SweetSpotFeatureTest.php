<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class SweetSpotFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function getAuthenticatedUser()
    {
        return User::factory()->create();
    }

    public function test_dashboard_renders()
    {
        $user = $this->getAuthenticatedUser();
        $response = $this->actingAs($user)->get('/dashboard/sweetspot');
        $response->assertStatus(200);
        $response->assertSee('Total Customers'); // Assert Livewire mounted properly
        $response->assertSee('Sweet Spot');
    }

    public function test_customers_index_renders()
    {
        $user = $this->getAuthenticatedUser();
        $response = $this->actingAs($user)->get('/customers');
        $response->assertStatus(200);
        $response->assertSee('Add Customer'); // Assert Volt component loaded
        $response->assertSee('Customers');
    }

    public function test_settings_index_renders()
    {
        $response = $this->actingAs($this->getAuthenticatedUser())->get(route('settings.weights.index'));
        $response->assertStatus(200);
        $response->assertSee('Weights');
    }

    public function test_calculate_endpoint_redirects_and_flashes()
    {
        $response = $this->actingAs($this->getAuthenticatedUser())->get(route('sweetspot.calculate'));
        $response->assertRedirect(route('dashboard.sweetspot'));
        $response->assertSessionHas('success');
    }
}
