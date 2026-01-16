<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_users()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $users = User::factory()->count(5)->create();


        $response = $this->actingAs($admin)->get(route('admin.users.index'));
        $response->assertStatus(200);
        

        foreach ($users as $user) {
            $response->assertSee($user->name);
        }
    }

    public function test_admin_can_update_user_status()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($admin)->patch(route('admin.users.update', $user->id), [
            'status' => 'active'
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'status' => 'active']);
    }

    public function test_non_admin_cannot_update_user_status()
    {
        $user = User::factory()->create(['role' => 'buyer']);
        $target = User::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($user)->patch(route('admin.users.update', $target->id), [
            'status' => 'active'
        ]);

        $response->assertStatus(403);
    }
}
