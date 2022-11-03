<?php

declare(strict_types=1);

namespace Database\Factories\Tickets;

use App\Enum\TicketEmailStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

final class TicketEmailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'cc' => $this->faker->safeEmail(),
            'message' => '{}',
            'title' => $this->faker->randomLetter,
            'status' => TicketEmailStatusEnum::PENDING,
        ];
    }
}
