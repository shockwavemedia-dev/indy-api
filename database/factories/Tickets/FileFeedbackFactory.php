<?php

declare(strict_types=1);

namespace Database\Factories\Tickets;

use Illuminate\Database\Eloquent\Factories\Factory;

final class FileFeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'feedback' => $this->faker->randomLetter
        ];
    }
}
