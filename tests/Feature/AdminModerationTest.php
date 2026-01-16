<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminModerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_ban_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $this->actingAs($admin)
            ->patch(route('admin.users.update', $user), ['is_banned' => true])
            ->assertRedirect(route('admin.users.index'));

        $this->assertTrue($user->fresh()->is_banned);
    }

    public function test_non_admin_cannot_ban_user()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $user = User::factory()->create();

        $this->actingAs($buyer)
            ->patch(route('admin.users.update', $user), ['is_banned' => true])
            ->assertForbidden();
    }

    public function test_admin_can_approve_service()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $service = Service::factory()->create(['status' => 'pending']);

        $this->actingAs($admin)
            ->patch(route('admin.services.update', $service), ['status' => 'approved'])
            ->assertRedirect(route('admin.services.index'));

        $this->assertEquals('approved', $service->fresh()->status);
    }

    public function test_admin_can_view_all_orders()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Order::factory()->count(3)->create();

        $this->actingAs($admin)
            ->get(route('admin.orders.index'))
            ->assertOk()
            ->assertViewIs('admin.orders.index');
    }
}
