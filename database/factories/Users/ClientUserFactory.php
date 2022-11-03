<?php

declare(strict_types=1);

namespace Database\Factories\Users;

use App\Enum\ClientRoleEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ClientUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'client_role' => $this->faker->randomElement(ClientRoleEnum::toArray()),
        ];
    }
}
