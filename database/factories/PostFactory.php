<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\fr_FR;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new fr_FR\Text($this->faker));
        return [
            'content' => $this->faker->realText(100),
            'community_id' => Community::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            "is_event" => $this->faker->boolean(),
        ];
    }
}
