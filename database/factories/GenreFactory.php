<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Genre>
 */
class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Genre::class;

    public function definition(): array
    {
        $genres = [
            '異世界ファンタジー',
            '現代ファンタジー',
            '恋愛・ラブコメ',
            'SF・現代ドラマ',
            'ホラー・ミステリー',
            'エッセイ・ノンフィクション',
        ];
        return [
            // リストからランダムに1つ選択（重複を避けたい場合はシーダー側の設計で調整）
            'genre' => $this->faker->randomElement($genres),
        ];
    }
}
