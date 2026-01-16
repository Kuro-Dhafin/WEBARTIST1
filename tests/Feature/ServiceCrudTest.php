<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ServiceCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_artist_can_create_service()
    {
        Storage::fake('public');

        $artist = User::factory()->create(['role' => 'artist']);

        $response = $this->actingAs($artist)->post(route('artist.services.store'), [
            'title' => 'Test Service',
            'description' => 'Desc',
            'price' => 100,
            'pricing_type' => 'per_panel',
            'thumbnail' => UploadedFile::fake()->create('thumbnail.jpg', 100, 'image/jpeg')
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseCount('services', 1);
        Storage::disk('public')->assertExists('services/' . $response->json('thumbnail'));
    }

    public function test_non_artist_cannot_create_service()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);

        $this->actingAs($buyer)
            ->post(route('artist.services.store'), [])
            ->assertForbidden();
    }

    public function test_artist_can_update_own_service()
    {
        $artist = User::factory()->create(['role' => 'artist']);
        $service = Service::factory()->create(['artist_id' => $artist->id]);

        $this->actingAs($artist)
            ->put(route('artist.services.update', $service), [
                'title' => 'Updated',
            ])
            ->assertOk();

        $this->assertEquals('Updated', $service->fresh()->title);
    }

    public function test_artist_can_delete_own_service()
    {
        $artist = User::factory()->create(['role' => 'artist']);
        $service = Service::factory()->create(['artist_id' => $artist->id]);

        $this->actingAs($artist)
            ->delete(route('artist.services.destroy', $service))
            ->assertNoContent();

        $this->assertDatabaseCount('services', 0);
    }
}
