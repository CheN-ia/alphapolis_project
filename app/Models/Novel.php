<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Novel extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    /**
     * 作者（ユーザー）との多対多リレーション（worksテーブル経由）
     */
    public function authors()
    {
        return $this->belongsToMany(User::class, 'works');
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
        return $this->belongsToMany(User::class, 'comments');
    }

    /**
     * タグとの多対多リレーション（novel_tagテーブル経由）
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'novel_tag');
    }
}
