<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Tag::class;

    // クラス共通で状態を保持する静的カウント変数
    protected static $index = 0;

    public function definition(): array
    {
        $tags = [
            '主人公最強', '悪役令嬢', '幼馴染', '日常', 'チート',
            '学園', 'VRMMO', '追放', 'ざまぁ', 'ほのぼの',
            'シリアス', 'ハッピーエンド', 'ダークファンタジー', '転生','転移'
        ];

        // 現在のインデックスに対応するタグを取得
        // (もしcountを配列数以上に指定された場合の安全対策として、一巡したら0に戻るように % で剰余算しています)
        $tag = $tags[self::$index % count($tags)];

        // 次回呼び出しのためにインデックスを進める
        self::$index++;

        return [
            'tag' => $tag,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public static function resetIndex(): void
    {
        self::$index = 0;
    }
}
