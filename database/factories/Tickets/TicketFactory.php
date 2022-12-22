<?php

declare(strict_types=1);

namespace Database\Factories\Tickets;

use App\Enum\TicketStatusEnum;
use App\Enum\TicketTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

final class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'ticket_code' => $this->faker->unique()->randomLetter,
            'subject' => $this->faker->randomLetter,
            'description' => '{}',
            'type' => TicketTypeEnum::EMAIL,
            'status' => TicketStatusEnum::NEW,
        ];
    }
}
