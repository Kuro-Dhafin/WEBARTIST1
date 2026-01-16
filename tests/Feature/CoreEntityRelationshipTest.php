<?php

namespace Tests\Feature;

use App\Models\{User, Service, Order};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoreEntityRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_artist_has_services()
    {
        $artist = User::factory()->create(['role' => 'artist']);
        Service::factory()->count(2)->create(['artist_id' => $artist->id]);

        $this->assertCount(2, $artist->services);
    }

    public function test_buyer_has_orders()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        Order::factory()->create(['buyer_id' => $buyer->id]);

        $this->assertCount(1, $buyer->orders);
    }

    public function test_service_has_orders()
    {
        $service = Service::factory()->create();
        Order::factory()->count(2)->create(['service_id' => $service->id]);

        $this->assertCount(2, $service->orders);
    }
}


