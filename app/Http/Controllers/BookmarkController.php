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

        // すでにブックマーク済みかチェック
        // contains() を使うと中間テーブルにそのIDが存在するか確認できます
        if ($user->bookmarkingNovels()->where('novel_id', [$request->novel_id])->exists()) {
            return redirect()->back()
                ->with('message', 'ブックマーク済み。');
        }

        // 存在しない場合のみ追加
        // syncWithoutDetaching でも良いですが、存在チェック後なので attach
        $user->bookmarkingNovels()->attach([$request->novel_id]);

        return redirect()->back()
            ->with('message', 'ブックマークに追加しました。');
        }
}
