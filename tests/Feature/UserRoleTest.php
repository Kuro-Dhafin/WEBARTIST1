<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_role_is_buyer()
    {
        $user = User::factory()->create();

        $this->assertEquals('buyer', $user->role);
        $this->assertTrue($user->isBuyer());
        $this->assertFalse($user->isArtist());
        $this->assertFalse($user->isAdmin());
    }

    public function test_artist_role_helpers()
    {
        $artist = User::factory()->create(['role' => 'artist']);

        $this->assertTrue($artist->isArtist());
        $this->assertFalse($artist->isBuyer());
    }

    public function test_admin_role_helpers()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($admin->isAdmin());
    }
}
