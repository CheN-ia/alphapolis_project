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
        Route::get('{user_id}', [UserController::class, 'user_show'])->name('user_show');
        Route::get('{user_id}/edit', [UserController::class, 'user_edit']);
        Route::patch('{user_id}', [UserController::class, 'user_update']);
    });

    // --- ★【改善】作品・エピソード管理（works）を外に独立 ---
    // URLから「user/{user_id}」が消え、ルート名も「work.xxx」にスッキリします
    Route::group(['prefix' => 'works', 'as' => 'work.'], function() {
        Route::get('/', [WorkController::class, 'work_index'])->name('index');
        Route::get('create', [WorkController::class, 'work_create'])->name('create');
        Route::post('/', [WorkController::class, 'work_store'])->name('store');

        Route::get('{novel_id}', [WorkController::class, 'work_show'])->name('show');
        Route::get('{novel_id}/edit', [WorkController::class, 'work_edit'])->name('edit');
        Route::patch('{novel_id}', [WorkController::class, 'work_update'])->name('update');
        Route::delete('{novel_id}', [WorkController::class, 'work_delete'])->name('delete');

        // エピソード管理（work.episode.xxx）
        Route::group(['prefix' => '{novel_id}/episodes', 'as' => 'episode.'], function() {
            Route::get('create', [EpisodeController::class, 'episode_create'])->name('create');
            Route::post('/', [EpisodeController::class, 'episode_store'])->name('store');
            Route::get('{episode_id}', [EpisodeController::class, 'episode_show'])->name('show');
            Route::get('{episode_id}/edit', [EpisodeController::class, 'episode_edit'])->name('edit');
            Route::patch('{episode_id}', [EpisodeController::class, 'episode_update'])->name('update');
            Route::delete('{episode_id}', [EpisodeController::class, 'episode_delete'])->name('delete');
        });
    });

    // ユーザーマイページ・ブックマーク・コメント（これらは user/{user_id} のまま維持）
    Route::group(['prefix' => 'user/{user_id}', 'as' => 'users.'], function() {
        Route::get('/', [UserController::class, 'user_index'])->name('mypage');

        // ブックマーク一覧
        Route::group(['prefix' => 'bm', 'as' => 'bookmarks.'], function() {
            Route::get('/', [BookmarkController::class, 'bm_show'])->name('index');
            Route::delete('{bm_id}', [BookmarkController::class, 'bm_delete'])->name('delete');
            Route::post('/', [BookmarkController::class, 'bm_store'])->name('store');
        });

        // コメント管理画面
        Route::group(['prefix' => 'comment', 'as' => 'comment.'], function() {
            Route::get('/', [CommentController::class, 'comment_show'])->name('index'); // name追加
            Route::delete('{comment_id}', [CommentController::class, 'comment_delete'])->name('delete');
            Route::post('{comment_id}', [CommentController::class, 'comment_store'])->name('store');
        });
    });
});


require __DIR__.'/auth.php';
