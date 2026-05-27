<?php

namespace App\Http\Controllers;

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
        return view('users.bookmarks.index', compact('bookmarks'));
    }

    //ブックマーク削除
    public function bm_delete()
    {
    }

    public function bm_store()
    {
    }
}
