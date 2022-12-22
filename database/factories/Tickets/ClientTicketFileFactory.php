<?php

declare(strict_types=1);

namespace Database\Factories\Tickets;

use App\Enum\TicketFileStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ClientTicketFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->randomLetter,
            'status' => TicketFileStatusEnum::NEW,
        ];
    }
}
