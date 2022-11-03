<?php

declare(strict_types=1);

namespace Database\Factories\Users;

use App\Enum\AdminRoleEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

final class AdminUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'admin_role' => $this->faker->randomElement(AdminRoleEnum::toArray()),
        ];
    }
}
