<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderLogFactory extends Factory
{
    protected $model = OrderLog::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'message' => $this->faker->sentence(),
        ];
    }
}
