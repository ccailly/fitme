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
        $rand_image_width = rand(400, 800);
        $rand_image_height = rand(400, 800);
        $this->faker->addProvider(new fr_FR\Text($this->faker));
        return [
            'content' => $this->faker->realText(100),
            'image' => 'https://source.unsplash.com/' . $rand_image_width . 'x' . $rand_image_height . '/?sport-event',
            'community_id' => Community::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
