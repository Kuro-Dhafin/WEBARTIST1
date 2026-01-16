<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderPlacementTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_place_order_on_approved_service()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $service = Service::factory()->create(['status' => 'approved']);

        $response = $this->actingAs($buyer)
            ->post(route('buyer.orders.store', $service));

        $response->assertStatus(201);
        $this->assertDatabaseCount('orders', 1);
    }

    public function test_buyer_cannot_order_unapproved_service()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $service = Service::factory()->create(['status' => 'pending']);

        $this->actingAs($buyer)
            ->post(route('buyer.orders.store', $service))
            ->assertForbidden();
    }

    public function test_buyer_can_cancel_pending_order()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'status' => 'pending',
        ]);

        $this->actingAs($buyer)
            ->delete(route('buyer.orders.cancel', $order))
            ->assertNoContent();

        $this->assertEquals('cancelled', $order->fresh()->status);
    }

    public function test_buyer_cannot_cancel_non_pending_order()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'status' => 'accepted',
        ]);

        $this->actingAs($buyer)
            ->delete(route('buyer.orders.cancel', $order))
            ->assertForbidden();
    }
}

