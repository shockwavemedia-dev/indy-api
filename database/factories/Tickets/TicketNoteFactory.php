<?php

namespace Database\Factories\Tickets;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'note' => '{}',
        ];
    }
}
