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

        $sports = [
            'Football',
            'Basketball',
            'Tennis',
            'Rugby',
            'Cricket',
            'Baseball',
            'Hockey',
            'Volleyball',
            'Golf',
            'Boxe',
            'MMA',
            'Badminton',
            'Tennis de table',
            'Handball',
            'Athlétisme',
            'Natation',
            'Cyclisme',
            'Escalade',
            'Ski',
            'Snowboard',
            'Surf',
            'Skateboard',
            'Roller',
            'Yoga',
            'Fitness',
            'Danse',
            'Gymnastique',
            'Musculation',
            'Marche',
            'Randonnée',
            'Course à pied',
            'Equitation',
            'Plongée',
            'Voile',
            'Stand up paddle',
            'Kitesurf',
            'Windsurf',
            'Canoë-kayak',
            'Canyoning',
            'Judo',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($sports),
            'description' => $this->faker->realText(100),
            'image' => 'https://source.unsplash.com/400x400/?' . $this->faker->randomElement($sports),
        ];
    }
}
