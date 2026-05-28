<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NovelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ==========================================
// 1. 一般公開ルート（ログイン不要、または閲覧のみ）
// ==========================================
Route::group(['prefix' => 'novels', 'as' => 'novels.'], function() {
    Route::get('/', [NovelController::class, 'index'])->name('index');
    Route::get('genre_id={genre_id}&tag_id={tag_id}', [NovelController::class, 'search'])->name('search');
    Route::get('{novel_id}', [NovelController::class, 'show'])->name('show');

    // 【改善点】読者が読むためのエピソード画面。{user_id} を不要にしました！
    Route::get('{novel_id}/episode/{episode_id}', [NovelController::class, 'episode_show'])->name('episode_show');
});


// ==========================================
// 2. 認証必須ルート（マイページ・投稿管理・設定など）
// ==========================================
Route::middleware('auth')->group(function () {

    // プロフィール設定（Breezeデフォルト）
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ユーザー設定（user-settings/配下のビューに対応）
    Route::group(['prefix' => 'user-settings', 'as' => 'usersettings.'], function() {
        Route::get('{user_id}', [UserController::class, 'user_show'])->name('user_show');;
        Route::get('{user_id}/edit', [UserController::class, 'user_edit']);
        Route::patch('{user_id}', [UserController::class, 'user_update']);
    });

    // ユーザー管理画面・マイページ（users/配下のビューに対応）
    Route::group(['prefix' => 'user/{user_id}', 'as' => 'users.'], function() {
        Route::get('/', [UserController::class, 'user_index'])->name('mypage');

        // ブックマーク一覧
        Route::group(['prefix' => 'bm', 'as' => 'bookmarks.'], function() {
            Route::get('/', [BookmarkController::class, 'bm_show'])->name('index'); // name追加
            Route::delete('{bm_id}', [BookmarkController::class, 'bm_delete'])->name('delete');
            Route::post('/', [BookmarkController::class, 'bm_store'])->name('store');
        });

        // コメント管理画面
        Route::group(['prefix' => 'comment', 'as' => 'comment.'], function() {
            Route::get('/', [CommentController::class, 'comment_show'])->name('index'); // name追加
            Route::delete('{comment_id}', [CommentController::class, 'comment_delete'])->name('delete');
            Route::post('{comment_id}', [CommentController::class, 'comment_store'])->name('store');
        });

        // 作品【投稿・編集】（users/works/ 配下のビューに対応）
        Route::group(['prefix' => 'works'], function() {
        Route::get('/', [WorkController::class, 'work_index'])->name('work_index');
        Route::get('create', [WorkController::class, 'work_create'])->name('work_create');
        Route::post('/', [WorkController::class, 'work_store'])->name('work_store');
        Route::get('{novel_id}', [WorkController::class, 'work_show'])->name('work_show');
        Route::get('{novel_id}/edit', [WorkController::class, 'work_edit'])->name('work_edit');
        Route::patch('{novel_id}', [WorkController::class, 'work_update'])->name('work_update');
        Route::delete('{novel_id}', [WorkController::class, 'work_delete'])->name('work_delete');
        });

        // // エピソード【投稿・編集】（users/episodes/ 配下のビューに対応）
        // // URLの重複や競合を防ぐため、頭に `episodes` というプレフィックスを挟むと綺麗になります
        // Route::group(['prefix' => 'episodes/{novel_id}', 'as' => 'episodes.'], function() {
        //     Route::get('create', [EpisodeController::class, 'episode_create'])->name('create');
        //     Route::post('store', [EpisodeController::class, 'episode_store'])->name('store');
        //     Route::get('{episode_id}/edit', [EpisodeController::class, 'work_edit'])->name('edit'); // メソッド名は適宜修正してください
        //     Route::patch('{episode_id}', [EpisodeController::class, 'work_update'])->name('update');
        //     Route::delete('{episode_id}', [EpisodeController::class, 'work_delete'])->name('delete');
        // });
    });
});

require __DIR__.'/auth.php';
