<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_services()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $services = Service::factory()->count(5)->create();

        $response = $this->actingAs($admin)->get(route('admin.services.index'));
        $response->assertStatus(200);

        foreach ($services as $service) {
            $response->assertSee($service->title);
        }
    }

    public function test_admin_can_update_service_status()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $service = Service::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($admin)->patch(route('admin.services.update', $service->id), [
            'status' => 'approved'
        ]);

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', ['id' => $service->id, 'status' => 'approved']);
    }

    public function test_non_admin_cannot_update_service_status()
    {
        $user = User::factory()->create(['role' => 'buyer']);
        $service = Service::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($user)->patch(route('admin.services.update', $service->id), [
            'status' => 'approved'
        ]);

        $response->assertStatus(403);
    }
}
