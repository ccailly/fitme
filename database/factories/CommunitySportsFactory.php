<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\Sport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommunitySports>
 */
class CommunitySportsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'community_id' => Community::inRandomOrder()->first()->id,
            'sport_id' => Sport::inRandomOrder()->first()->id,
        ];
    }
}
