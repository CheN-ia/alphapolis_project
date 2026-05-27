<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Novel;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    // app/Models/User.php 内
    public function bookmarkingNovels()
    {
        // 第2引数に中間テーブル名「works」を指定します
        return $this->belongsToMany(Novel::class,'bookmarks');
    // ユーザーが作成した小説一覧を取得するリレーション
    public function novels(): BelongsToMany
    {
        // belongsToMany(関連付けるモデル名, 中間テーブル名, 中間テーブル内での自分のID, 相手のID)
        return $this->belongsToMany(Novel::class, 'works', 'user_id', 'novel_id')
                    ->withTimestamps(); // 中間テーブルのcreated_at/updated_atも自動更新する場合
    }
}
