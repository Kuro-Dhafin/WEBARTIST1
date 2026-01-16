<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_artist_can_update_own_service()
    {
        $artist = User::factory()->create(['role' => 'artist']);
        $service = Service::factory()->create(['artist_id' => $artist->id]);

        $this->assertTrue($artist->can('update', $service));
    }

    public function test_artist_cannot_update_other_service()
    {
        $artist = User::factory()->create(['role' => 'artist']);
        $service = Service::factory()->create();

        $this->assertFalse($artist->can('update', $service));
    }

    public function test_buyer_can_cancel_pending_order()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'status' => 'pending',
        ]);

        $this->assertTrue($buyer->can('cancel', $order));
    }

    public function test_buyer_cannot_cancel_accepted_order()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'status' => 'accepted',
        ]);

        $this->assertFalse($buyer->can('cancel', $order));
    }

    public function test_admin_bypasses_policies()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $service = Service::factory()->create();

        $this->assertTrue($admin->can('delete', $service));
    }
}
