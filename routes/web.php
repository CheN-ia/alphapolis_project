<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

    //alphapolis projects 追記（コントローラー名は仮のもの）
    //トップページ・検索結果・作品一覧・エピソード一覧
    Route::group(['prefix' => '/novels', 'as' => 'Novels.'], function() {
        Route::get('/', [NovelController::class, 'index']);
        Route::get('genre_id={genre_id}&tag_id={tag_id}', [NovelController::class, 'search']);
        Route::get('{novel_id}', [NovelController::class, 'show']);
        Route::get('{novel_id}/episode/{episode_id}', [NovelController::class, 'episode_show']);
    });

    //ユーザー管理画面
    Route::group(['prefix' => '{user_id}', 'as' => 'Users.'], function() {
        Route::get('/', [UserController::class, 'user_index']);
        //作品投稿編集
        Route::get('create', [UserController::class, 'work_create']);
        Route::post('/', [UserController::class, 'work_store']);
        Route::get('{novel_id}', [UserController::class, 'work_show']);
        Route::delete('{novel_id}', [UserController::class, 'work_delete']);
        Route::patch('{novel_id}', [UserController::class, 'work_update']);
        Route::edit('{novel_id}/edit', [UserController::class, 'work_edit']);

        //エピソード投稿編集
        Route::get('{novel_id}/create', [UserController::class, 'episode_create']);
        Route::post('{novel_id}', [UserController::class, 'episode_store']);
        Route::get('{novel_id}/{episode_id}', [UserController::class, 'episode_show']);
        Route::delete('{novel_id}/edit/{episode_id}', [UserController::class, 'work_update']);
        Route::patch('{novel_id}/{episode_id}', [UserController::class, 'work_delete']);
        Route::edit('{novel_id}/{episode_id}', [UserController::class, 'work_edit']);

        //ブックマーク一覧
        Route::group(['prefix' => '{user_id}/bm', 'as' => 'Users.'], function() {
        });

        //コメント管理画面
        Route::group(['prefix' => '{user_id}/bm', 'as' => 'Users.'], function() {
        });
    });


    //ユーザー設定
    Route::group(['prefix' => 'user', 'as' => 'Users.'], function() {
    });

});

require __DIR__.'/auth.php';
