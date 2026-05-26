<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tag;
use App\Models\Novel;
use App\Models\Episode;
use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // 1. まずはベースとなる「ユーザー」と「タグ」と「ジャンル」を固定数作成
        $users = User::factory()->count(20)->create();
        $tags = Tag::factory()->count(15)->create();
        $genres = Genre::factory()->count(5)->create(); // 先にジャンルを固定したい場合

        // 2. 小説をベースに、関連データをまとめて生成
        Novel::factory()
            ->count(30)
            ->recycle($genres)
            // ★第2引数に、モデルに定義したリレーション名「'episodes'」を明示する
            ->has(Episode::factory()->count(5), 'episodes')
            ->create()
            ->each(function ($novel) use ($users, $tags) {
                // 各小説に対して、さらに複雑なリレーション（中間テーブルやブックマーク）を設定

                // ランダムに1〜3個のタグを紐付ける（novel_tagテーブル）
                $novel->tags()->attach($tags->random(rand(1, 3)));

                // ランダムなユーザーが作者になる（worksテーブル）
                $novel->authors()->attach($users->random()); // ※モデルにリレーション定義が必要

                // ランダムなユーザーが数人ブックマークする（bookmarksテーブル）
                $novel->bookmarkingUsers()->attach($users->random(rand(0, 5)));

                // ランダムなユーザーがコメントする（commentsテーブル）
                $novel->commentingUsers()->attach($users->random(rand(0, 3)));
            });
    }
}
