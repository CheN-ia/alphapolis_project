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

    public function definition(): array
    {

        $tags = [
            '主人公最強', '悪役令嬢', '幼馴染', '日常', 'チート',
            '学園', 'VRMMO', '追放', 'ざまぁ', 'ほのぼの',
            'シリアス', 'ハッピーエンド', 'ダークファンタジー', '転生'
        ];

        return [
            // リストからランダムに選択（uniqueを指定しておくと重複を防げます）
            'tag' => $this->faker->randomElement($tags),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
