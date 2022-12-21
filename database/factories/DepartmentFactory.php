<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enum\DepartmentStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

final class DepartmentFactory extends Factory
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
            'description' => $this->faker->randomLetter,
            'status' => DepartmentStatusEnum::ACTIVE,
            'min_delivery_days' => 7,
        ];
    }
}
