<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'institution_id' => null,
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(),
            'size' => 5000,
            'mime_type' => 'application/pdf',
            'file_name' => 'alsfkjalkfaal.pdf',
            'downloads' => 0,
        ];
    }
}
