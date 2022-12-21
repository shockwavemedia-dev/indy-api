<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'marketing_quota' => 0,
            'extra_quota' => 0,
            'total_used' => 0,
            'is_enabled' => 1,
        ];
    }
}
