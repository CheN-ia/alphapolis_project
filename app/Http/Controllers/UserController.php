<?php

namespace App\Http\Controllers;

//使用するモデルの呼び出し
use App\Models\User;
// use App\Models\Novel;
// use App\Models\Comment;
// use App\Models\Bookmark;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    public function user_index($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('users.index', compact('user'));
    }

    //
    public function user_show($user_id)
    {

        $user = User::findOrFail($user_id);
        return view('user-settings.index', compact('user'));
    }

    public function user_edit($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('user-settings.edit', compact('user'));
    }

    public function user_update(Request $request, $user_id)
    {
    // 1. 指定されたユーザーを取得（存在しない場合は404）
        $user = User::findOrFail($user_id);

        // 2. バリデーションの実施
        $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('UserSettings.user_show', ['user_id' => $user->id])
        ->with('message', '変更が反映されました。');
    }
}
