<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use App\Models\Order;
use App\Models\OrderLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_orders()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $buyer = User::factory()->create(['role' => 'buyer']);
        $service = Service::factory()->create();

        $orders = Order::factory()->count(3)->create([
            'buyer_id' => $buyer->id,
            'service_id' => $service->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.orders.index'));

        $response->assertStatus(200);

        foreach ($orders as $order) {
            $response->assertSee((string) $order->id);
        }
    }

    public function test_admin_can_view_order_logs()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $buyer = User::factory()->create(['role' => 'buyer']);
        $service = Service::factory()->create();

        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'service_id' => $service->id,
        ]);

        $log = OrderLog::factory()->create([
            'order_id' => $order->id,
            'message' => 'Order created',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.orders.logs', $order->id));

        $response->assertStatus(200);
        $response->assertSee($log->message);
    }

    public function test_non_admin_cannot_access_orders()
    {
        $user = User::factory()->create(['role' => 'buyer']);
        $order = Order::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.orders.index'))
            ->assertStatus(403);

        $this->actingAs($user)
            ->get(route('admin.orders.logs', $order->id))
            ->assertStatus(403);
    }
}
