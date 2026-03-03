<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Livewire\Volt\Volt;
use Tests\TestCase;

class RoleManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_roles_page_is_protected(): void
    {
        $response = $this->get('/roles');
        $response->assertRedirect('/login');
    }

    public function test_roles_page_renders_for_authenticated_users(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/roles');

        $response->assertStatus(200);
        $response->assertSee('Role Management');
        $response->assertSeeVolt('role-management');
    }
}
