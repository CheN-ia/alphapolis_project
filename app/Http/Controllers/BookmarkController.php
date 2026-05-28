<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bookmark;
use App\Models\Novel;

//ブックマーク管理用のコントローラー

class BookmarkController extends Controller
{
    //ブックマーク閲覧
    public function bm_show($user_id)
    {
        $user = User::findOrFail($user_id);

        // そのユーザーがブックマークしている小説（Novels）を取得する
        $bookmarks = $user->bookmarkingNovels;
        return view('users.bookmarks.index', compact('bookmarks', 'user'));
    }

    //ブックマーク削除
    public function bm_delete(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

    // フォームから送られてきた novel_id を指定して中間テーブルのレコードを消す
        $user->bookmarkingNovels()->detach($request->novel_id);

        return redirect()->back()
        ->with('message', 'ブックマークを削除しました。');
    }

    //ブックマーク保存
    public function bm_store(Request $request, $user_id)
    {
        //
        //$request->novel_idと$user_idを中間テーブルに追加
        //
        $user = User::findOrFail($user_id);

        // 3. attach() を使って、中間テーブル（bookmarks）に user_id と novel_id の組み合わせを追加
        // すでにモデルに定義してある `bookmarkingNovels()` リレーションを呼び出します
        $user->bookmarkingNovels()->attach($request->novel_id);
        return redirect();
    }
}
