<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author' => $this->faker->name(),
            'book_title' => $this->faker->sentence(3), // Generates a 3-word title
            'book_description' => $this->faker->paragraph(), // Random paragraph
            'genre' => $this->faker->randomElement(['Fiction', 'Non-Fiction', 'Fantasy', 'Mystery', 'Science Fiction', 'Biography']),
            'format' => $this->faker->randomElement(['Audiofile', 'eBook']),
            'status' => $this->faker->boolean(), // Randomly true or false
            'book_publication_date' => $this->faker->date(), // Random date
        ];
    }
}
