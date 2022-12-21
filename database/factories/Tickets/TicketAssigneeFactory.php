<?php

declare(strict_types=1);

namespace Database\Factories\Tickets;

use App\Enum\TicketAssigneeStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

final class TicketAssigneeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'status' => TicketAssigneeStatusEnum::OPEN,
        ];
    }
}
