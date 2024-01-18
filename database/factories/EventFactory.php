<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\fr_FR;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new fr_FR\Address($this->faker));
        $this->faker->addProvider(new fr_FR\Text($this->faker));
        return [
            'name' => $this->faker->realText(20),
            'description' => $this->faker->realText(100),
            'user_id' => User::inRandomOrder()->first()->id,
            'community_id' => Community::inRandomOrder()->first()->id,
            'date_time' => $this->faker->dateTimeBetween('now', '+1 years'),
            'location' => $this->faker->address(),
            'max_participants' => $this->faker->numberBetween(10, 100),
        ];
    }
}
