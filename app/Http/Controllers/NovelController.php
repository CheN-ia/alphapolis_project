<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Models\Novel;
use App\Models\Tag;
use App\Models\Episode;
use Illuminate\Support\Facades\Auth;
use Pest\Support\View;

class NovelController extends Controller
{
    public function index(Request $request)
    {
            // お問い合わせのレコードをすべて取得
        $works = Novel::all();
        $user = Auth::user();
                // ジャンル一覧とタグ一覧を全件取得
        $genres = Genre::all();
        $tags = Tag::all();
        $query = Novel::query();

        // 4. ジャンルが選択されていたら、条件を追加
        if ($request->filled('genre_id')) {
            $query->where('genre_id', $request->genre_id);
        }

        // 5. タグが選択されていたら、条件を追加（多対多のリレーションを想定）
        if ($request->filled('tag_id')) {
            // worksテーブルとtagsテーブルがリレーション（tags）で結ばれている場合
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('tags.id', $request->tag_id);
            });
        }

        // 6. 最終的な結果を取得
        $works = $query->get();
        return view('novels.index', compact('works','user','genres','tags'));
    }

    public function search()
    {

    }

    public function show(string $id)
    {
        // 指定されたIDの作品を、紐づくエピソードと一緒に取得　Eagerload
        $novel = Novel::with('episodes')->findOrFail($id);

        // viewに $novel を渡す
        return view('novels.show', compact('novel'));
    }

    public function episode_show(string $novel_id, string $episode_id)
    {
        // 1. まず該当の作品が存在するかチェック
        $novel = Novel::findOrFail($novel_id);

        // 2. その作品に紐づく、指定されたIDのエピソードを取得
        //    where で「作品ID」と「エピソードID」の両方が一致するものを探します
        $episode = Episode::where('novel_id', $novel_id)
                          ->where('id', $episode_id)
                          ->firstOrFail(); // 見つからなければ404エラー

        // 3. ビュー（novels.episode_show）にデータを渡して表示
        return view('novels.episode_show', compact('novel', 'episode'));
    }

}
