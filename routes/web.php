<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

//追加コントローラー
use App\Http\Controllers\NovelController;
use Illuminate\Queue\Console\UserController;
use App\Http\Controllers\WorkController;
use Illuminate\Queue\Console\EpisodeController;
use App\Http\Controllers\BookmarkController;
use Illuminate\Queue\Console\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    ///
    //alphapolis projects 追記（コントローラー名は仮のもの）
    ///
    //トップページ・検索結果・作品一覧・エピソード一覧
    Route::group(['prefix' => '/novels', 'as' => 'Novels.'], function() {
        Route::get('/', [NovelController::class, 'index']);
        Route::get('genre_id={genre_id}&tag_id={tag_id}', [NovelController::class, 'search']);
        Route::get('{novel_id}', [NovelController::class, 'show']);
        Route::get('{novel_id}/episode/{episode_id}', [NovelController::class, 'episode_show']);
    });

    //ユーザー設定
    Route::group(['prefix' => 'user-settings/{user_id}', 'as' => 'UserSettings.'], function() {
        Route::get('/', [UserController::class, 'work_show']);
        Route::patch('/', [UserController::class, 'work_update']);
        Route::post('/', [UserController::class, 'work_store']);
    });

    //ユーザー管理画面
    Route::group(['prefix' => '{user_id}', 'as' => 'Users.'], function() {
        Route::get('/', [UserController::class, 'user_index']);

        //作品投稿編集
        Route::get('create', [WorkController::class, 'work_create']);
        Route::post('/', [WorkController::class, 'work_store']);
        Route::get('{novel_id}', [WorkController::class, 'work_show']);
        Route::delete('{novel_id}', [WorkController::class, 'work_delete']);
        Route::patch('{novel_id}', [WorkController::class, 'work_update']);
        Route::get('{novel_id}/edit', [WorkController::class, 'work_edit']);

        //エピソード投稿編集
        Route::get('{novel_id}/create', [EpisodeController::class, 'episode_create']);
        Route::post('{novel_id}', [EpisodeController::class, 'episode_store']);
        Route::get('{novel_id}/{episode_id}', [EpisodeController::class, 'episode_show']);
        Route::delete('{novel_id}/edit/{episode_id}', [EpisodeController::class, 'work_delete']);
        Route::patch('{novel_id}/{episode_id}', [EpisodeController::class, 'work_update']);
        Route::get('{novel_id}/{episode_id}', [EpisodeController::class, 'work_edit']);

        //ブックマーク一覧
        Route::group(['prefix' => 'bm', 'as' => 'Bookmarks.'], function() {
            Route::get('/', [BookmarkController::class, 'bm_show']);
            Route::delete('{bm_id}', [BookmarkController::class, 'bm_delete']);
            Route::post('/', [BookmarkController::class, 'bm_store']);
        });

        //コメント管理画面
        Route::group(['prefix' => 'comment', 'as' => 'Comment.'], function() {
            Route::get('/', [CommentController::class, 'bm_show']);
            Route::delete('{comment_id}', [CommentController::class, 'bm_delete']);
        });
    });

});

require __DIR__.'/auth.php';
