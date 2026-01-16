<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Tests\TestCase;

class BuyerOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_create_order()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $service = Service::factory()->create(['status' => 'approved']);

        $this->actingAs($buyer)
            ->post(route('buyer.orders.store', $service))
            ->assertCreated();

        $this->assertDatabaseHas('orders', [
            'buyer_id' => $buyer->id,
            'service_id' => $service->id,
            'status' => 'pending',
        ]);
    }

    public function test_buyer_can_cancel_own_pending_order()
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

    public function test_buyer_cannot_cancel_accepted_order()
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

    public function test_buyer_cannot_cancel_others_order()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $other = User::factory()->create(['role' => 'buyer']);
        $order = Order::factory()->create([
            'buyer_id' => $other->id,
            'status' => 'pending',
        ]);

        $this->actingAs($buyer)
            ->delete(route('buyer.orders.cancel', $order))
            ->assertForbidden();
    }
}
