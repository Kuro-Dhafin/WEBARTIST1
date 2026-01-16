<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtistOrderStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_artist_can_accept_pending_order()
    {
        $artist = User::factory()->create(['role' => 'artist']);
        $service = Service::factory()->create(['artist_id' => $artist->id]);
        $order = Order::factory()->create([
            'service_id' => $service->id,
            'status' => 'pending',
        ]);

        $this->actingAs($artist)
            ->patch("/artist/orders/{$order->id}/accept")
            ->assertNoContent();

        $this->assertEquals('accepted', $order->fresh()->status);
    }

    public function test_artist_cannot_complete_pending_order()
    {
        $artist = User::factory()->create(['role' => 'artist']);
        $service = Service::factory()->create(['artist_id' => $artist->id]);
        $order = Order::factory()->create([
            'service_id' => $service->id,
            'status' => 'pending',
        ]);

        $this->actingAs($artist)
            ->patch("/artist/orders/{$order->id}/complete")
            ->assertForbidden();
    }

    public function test_non_owner_artist_cannot_manage_order()
    {
        $artist = User::factory()->create(['role' => 'artist']);
        $other = User::factory()->create(['role' => 'artist']);
        $service = Service::factory()->create(['artist_id' => $other->id]);
        $order = Order::factory()->create([
            'service_id' => $service->id,
            'status' => 'pending',
        ]);

        $this->actingAs($artist)
            ->patch("/artist/orders/{$order->id}/accept")
            ->assertForbidden();
    }
}

