<?php

namespace Database\Factories;

use App\Models\Novel;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Novel>
 */
class NovelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->realText(20), // 日本語設定なら日本語になります
            'abstract' => $this->faker->realText(200),
            'genre_id' => Genre::factory(), // ★自動的にジャンルを作ってIDを紐付ける
        ];
    }
}
