<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

final class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'original_filename' => $this->faker->name,
            'file_name' => $this->faker->randomLetter,
            'file_size' => $this->faker->randomDigitNotNull,
            'file_path' => '',
            'file_type' => 'image/png',
            'disk' => 'gcs',
            'version' => 1,
            'url' => $this->faker->randomLetter,
        ];
    }
}
