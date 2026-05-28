<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Episode extends Model
{
    use HasFactory;
    use SoftDeletes;

    // エピソードは1つのNovelに属する
    public function novel(): BelongsTo
    {
        // 外部キーが 'novel_id' であれば第2引数は不要です
        return $this->belongsTo(Novel::class);
    }
}
