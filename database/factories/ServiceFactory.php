<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'artist_id' => User::factory()->state(['role' => 'artist']),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'price' => 100,
            'pricing_type' => 'per_panel',
            'status' => 'approved',
        ];
    }
}

