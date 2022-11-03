<?php

declare(strict_types=1);

namespace Database\Factories\Emails;

use App\Enum\EmailStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

final class EmailLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'message' => $this->faker->randomLetter(),
            'failed_details' => '',
            'status' => EmailStatusEnum::SENT,
            'cc' => $this->faker->email,
            'to' => $this->faker->email,
        ];
    }
}
