<?php

namespace Database\Factories;

use App\Enum\ClientStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'client_code' => $this->faker->unique()->name,
            'address' => $this->faker->randomLetter(),
            'phone' => $this->faker->randomLetter(),
            'timezone' => 'AU',
            'client_since' => '1990-10-10',
            'main_client_id' => null,
            'overview' => $this->faker->randomLetter(),
            'rating' => $this->faker->randomElement([1, 5, 10]),
            'status' => ClientStatusEnum::ACTIVE,
        ];
    }
}
