<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    //投稿コメント一覧
    public function comment_show($user_id)
    {

        $user = User::findOrFail($user_id);

        // そのユーザーのコメントを取得する
        $comments = $user->comments;
        return view('users.comments.index', compact('comments', 'user'));
    }

    //コメント削除
    public function comment_delete(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        DB::table('comments')
            ->where('id', $request->comment_id)
            ->where('user_id', $user->id) // 他人のコメントを勝手に消せないようにガード
            ->delete();

        return redirect()->back()
        ->with('message', 'コメントを削除しました。');
    }

    //投稿コメント保存
    public function comment_store(Request $request, $user_id)
    {
        $request->validate([
            'novel_id' => ['required', 'exists:novels,id'], // 本当に存在する小説か
            'comment'     => ['required', 'string', 'max:400'], // コメント本文（文字数は任意で調整してください）
        ]);

        $user = User::findOrFail($user_id);

        $user->comments()->attach($request->novel_id, [
            'comment' => $request->comment
        ]);

        return redirect()->back();
    }

}
