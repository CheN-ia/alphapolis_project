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
    protected static $index = 0;

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

        // 現在のインデックスに対応するタグを取得
        // (もしcountを配列数以上に指定された場合の安全対策として、一巡したら0に戻るように % で剰余算しています)
        $genre = $genres[self::$index % count($genres)];

        // 次回呼び出しのためにインデックスを進める
        self::$index++;

        return [
            'genre' => $genre,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public static function resetIndex(): void
    {
        self::$index = 0;
    }
}
