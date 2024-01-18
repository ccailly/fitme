<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\fr_FR;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sport>
 */
class SportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $this->faker->addProvider(new fr_FR\Text($this->faker));

        $sports = ['Football', 'Basketball', 'Tennis', 'Rugby', 'Cricket', 'Baseball', 'Hockey', 'Volleyball', 'Golf', 'Boxing'];

        return [
            'name' => $this->faker->unique()->randomElement($sports),
            'description' => $this->faker->realText(100),
            'image' => 'https://source.unsplash.com/400x400/?' . $this->faker->randomElement($sports),
        ];
    }
}
