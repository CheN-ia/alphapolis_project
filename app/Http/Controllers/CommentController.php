<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    //
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

        return redirect()->back();
    }

}
