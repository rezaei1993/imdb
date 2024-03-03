<?php

namespace Modules\Movie\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Movie\App\Models\Movie::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(2),
            'thumbnail' => $this->faker->imageUrl(),
            'imdb_thumbnail' => $this->faker->optional()->imageUrl(),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'size' => $this->faker->randomNumber(3) . 'MB',
            'imdb_id' => $this->faker->optional()->unique()->regexify('[A-Za-z0-9]{9}'),
            'imdb_rating' => $this->faker->optional()->randomFloat(1, 0, 10),

        ];
    }
}

