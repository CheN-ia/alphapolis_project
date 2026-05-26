<?php

namespace Database\Factories;

use App\Models\Episode;
use App\Models\Novel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Episode>
 */
class EpisodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->realText(30),
            'text' => $this->faker->realText(1000),
            'image' => $this->faker->imageUrl(),
            'PV' => $this->faker->numberBetween(0, 5000),
            'novel_id' => Novel::factory(), // ★自動的に小説を作ってIDを紐付ける
        ];
    }
}
