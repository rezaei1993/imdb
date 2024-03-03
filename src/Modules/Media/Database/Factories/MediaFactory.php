<?php

namespace Modules\Media\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Media\App\Models\Media::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'size' => $this->faker->randomNumber(3) . 'MB',
            'user_id' => $this->faker->numberBetween(1, 10), // Assuming users exist with IDs from 1 to 10
            'files' => json_encode([$this->faker->word() . '.' . $this->faker->fileExtension]),
            'type' => $this->faker->randomElement(['image', 'video', 'audio', 'zip', 'doc']),
            'uuid' => $this->faker->uuid,
            'filename' => $this->faker->word() . '.' . $this->faker->fileExtension,
            'directory' => $this->faker->optional()->word(),
            'is_private' => $this->faker->boolean(),
        ];
    }
}

