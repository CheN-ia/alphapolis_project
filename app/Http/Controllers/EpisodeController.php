<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
public function episode_create(string $novel_id)
{
    // フォルダ構造に合わせて 'users.' を最初に追加
    return view('episodes.create', compact('novel_id'));
}

    public function episode_store(Request $request,string $novel_id)
{
    // バリデーション
    $request->validate([
        'title' => 'required|string|max:255',
        'text' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 最大2MBなど
    ]);

    $episode = new Episode();
    $episode->novel_id = $novel_id;
    $episode->title = $request->title;
    $episode->text = $request->text;
    $episode->PV = 0; // 初期値

    // 画像があるときだけ保存処理をする（ない場合は自動的に null またはデフォルト値になる）
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('episodes', 'public');
        $episode->image = $path;
    } else {
        $episode->image = null; // 明示的にnullを入れてもOK
    }

    $episode->save();

    return redirect()->route('work.show', $novel_id)->with('success', 'エピソードを追加しました。');
}

    public function episode_delete(string $novel_id,string $episode_id)
    {
        $episode = Episode::findOrFail($episode_id);

        $episode->delete();
        // 削除後は作品一覧（work.show）にリダイレクト
        return redirect()->route('work.show', $novel_id)->with('success', 'エピソードを削除しました。');;
    }

public function episode_show(string $novel_id, string $episode_id)
{
    // 該当するエピソードを取得
    $episode = Episode::findOrFail($episode_id);

    // エピソードが所属する小説のIDも一緒にビューに渡す
    return view('episodes.show', compact('episode', 'novel_id'));
}

public function episode_edit(string $novel_id, string $episode_id)
{
    $episode = Episode::findOrFail($episode_id);

    // ★修正：compactに 'novel_id' を追加してBladeに渡す
    return view('episodes.edit', compact('episode', 'novel_id'));
}

public function episode_update(Request $request, string $novel_id, string $episode_id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'text' => 'required|string',
        'image' => 'nullable|image|max:2048',
    ]);

    $episode = Episode::findOrFail($episode_id);
    $episode->title = $request->title;
    $episode->text = $request->text;

    // 新しい画像がアップロードされた場合
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('episodes', 'public');
        $episode->image = $path;
    }

    $episode->save();

    // 更新後は管理用のエピソード詳細（show）に戻る
    return redirect()->route('work.episode.show', [$novel_id, $episode->id])->with('success', 'エピソードを更新しました。');
}
}
