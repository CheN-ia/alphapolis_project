<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tag;
use App\Models\Novel;
use App\Models\Episode;
use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

    // === 【追加】すでにデータが存在するかどうかをチェック ===
        // tagsテーブルにデータがある場合は「やり直しモード」として動かす
        if (Tag::exists() || Genre::exists()) {

            // 1. 外部キー制約を一時的に無効化（エラー防止）
            Schema::disableForeignKeyConstraints();

            // 2. tags と genres を物理削除（IDも1リセット）
            DB::table('tags')->truncate();
            DB::table('genres')->truncate();

            // novel_tag 中間テーブルの古い紐付けデータも一度綺麗にクリア
            DB::table('novel_tag')->truncate();

            // 3. 外部キー制約を元に戻す
            Schema::enableForeignKeyConstraints();

            \Database\Factories\TagFactory::resetIndex();
            \Database\Factories\GenreFactory::resetIndex();

            $newTags = Tag::factory()->count(15)->create();
            $newGenres = Genre::factory()->count(5)->create();

            // 5. 既存の小説データに対して、新しいジャンルとタグを割り当て直す
            Novel::all()->each(function ($novel) use ($newTags, $newGenres) {

                // 新しいジャンルからランダムに1つ選んで、小説の genre_id を更新
                $novel->update([
                    'genre_id' => $newGenres->random()->id
                ]);

                // 新しいタグからランダムに1〜3個を選んで中間テーブルに結びつける
                $novel->tags()->attach($newTags->random(rand(1, 3)));
            });

            // 💡 ここで処理を終了（他のUserやNovelは一切触らない）
            return;
        }

        // 1. まずはベースとなる「ユーザー」と「タグ」と「ジャンル」を固定数作成

        \Database\Factories\TagFactory::resetIndex();
        \Database\Factories\GenreFactory::resetIndex();

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
                $commenters = $users->random(rand(0, 3));
                foreach ($commenters as $user) {
                    $novel->commentingUsers()->attach($user->id, [
                    // 💡 マイグレーションで定義したカラム名（例: body）に、Fakerで200文字のテキストを入れる
                        'comment' => fake()->realText(200),
                    ]);
                }
            });
    }
}
