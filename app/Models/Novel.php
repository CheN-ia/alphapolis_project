<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Novel extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = ['title', 'abstract', 'genre_id'];

    /**
     * エピソードとのリレーション（1対多）
     * メソッド名は必ず「複数形（episodes）」にしてください
     */
    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class);
    }

    // --- ついでにシーダーのエラーを予防するための設定 ---

    // 小説を執筆したユーザー一覧を取得するリレーション
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'works', 'novel_id', 'user_id')
                    ->withTimestamps();
    }

    public function tags()
    {
    // 第2引数には「小説とタグの中間テーブル名」を入れてください（例: 'novel_tag' や 'novel_tags' など）
    return $this->belongsToMany(Tag::class, 'novel_tag', 'novel_id', 'tag_id')
                ->withTimestamps();
    }
    /**
     * ブックマークしたユーザーとの多対多リレーション（bookmarksテーブル経由）
     */
    public function bookmarkingUsers()
    {
        return $this->belongsToMany(User::class, 'bookmarks');
    }

    /**
     * コメントしたユーザーとの多対多リレーション（commentsテーブル経由）
     */
    public function commentingUsers()
    {
        return $this->belongsToMany(User::class, 'comments')
                    ->withPivot('id','comment');;
    }


}
