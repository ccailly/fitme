<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\fr_FR;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Community>
 */
class CommunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new fr_FR\Company($this->faker));
        $this->faker->addProvider(new fr_FR\Text($this->faker));

        return [
            'name' => $this->faker->unique()->company(),
            'description' => $this->faker->realText(200),
            'image' => 'https://source.unsplash.com/400x400/?community',
        ];
    }
}
