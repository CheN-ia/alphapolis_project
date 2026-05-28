<?php

namespace App\Http\Controllers;

use App\Models\Novel;
use App\Models\Genre;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class WorkController extends Controller
{
    public function work_index()
    {
        // 👇 Auth::user() でログインユーザーを取得
        $user = Auth::user();

        // ログインしていない場合のセーフティ（必要に応じて）
        if (!$user) {
            return redirect()->route('login');
        }

        // ユーザーに紐づく小説一覧（中間テーブル経由）を取得
        $works = $user->novels;

        // 画面に小説一覧を渡す
        return view('works.index', compact('works'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function work_create()
    {
        // ジャンル一覧とタグ一覧を全件取得
        $genres = Genre::all();
        $tags = Tag::all();

        // フォルダ階層に合わせてデータを渡して表示
        return view('works.create', compact('genres', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function work_store(Request $request)
    {
        // 2. 小説（novelsテーブル）の保存
    $novel = new Novel();
    $novel->title = $request->input('title');
    $novel->genre_id = $request->input('genre_id');
    $novel->abstract = ''; // あらすじは一旦空文字
    $novel->save();

    // 3. ユーザーと小説の紐づけ（中間テーブル works への保存）
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $user->novels()->attach($novel->id);

    // --- ここからタグの処理 ---

    // 4. 既存タグの紐づけ（チェックボックスで選ばれたIDたち）
    $existingTags = $request->input('existing_tags', []); // なければ空配列
    if (!empty($existingTags)) {
        // 小説とタグの中間テーブルにまとめてガッチャンコ保存
        $novel->tags()->attach($existingTags);
    }

    // 5. 新規タグの保存と紐づけ（テキスト入力欄）
    $newTagsString = $request->input('new_tags');
    if ($newTagsString) {
        // 全角・半角スペースを除去し、カンマ「,」で配列に分解
        $newTagNames = explode(',', str_replace(' ', '', $newTagsString));

        foreach ($newTagNames as $tagName) {
            if (empty($tagName)) continue;

            // すでに同じ名前のタグがなければ新しく登録、あれば既存データを取得
            $tag = Tag::firstOrCreate(['tag' => $tagName]);

            // 新しく作った（または見つかった）タグのIDを、小説の中間テーブルに紐づけ
            // すでに紐づいている場合の重複を防ぐため、安全に syncWithoutDetaching を使います
            $novel->tags()->syncWithoutDetaching([$tag->id]);
        }
    }
    // --- タグの処理ここまで ---

    // 6. 元のユーザー管理画面（一覧）にリダイレクト
    return redirect('/user/' . $user->id);
    }

    /**
     * Display the specified resource.
     */
    public function work_show(string $id)
    {
        // Contact モデルで、編集する対象のデータを取得する
        $work = Novel::find($id);
        return view('works.show', compact('work'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function work_edit(string $id)
    {
        // 1. 編集対象の作品データを取得
        $work = Novel::findOrFail($id);

        // 2. データの所有者チェック（セキュリティ）

    // ★ 3. ここが重要！ 正しいビューを return していますか？
    // フォルダ階層が users/works/edit.blade.php なので、ドット区切りで指定します
        return view('works.edit', compact('work'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function work_update(Request $request, string $id)
    {
        $work = Novel::findOrFail($id);

        // ここに更新処理を書く（例）
        $work->title = $request->title;
        $work->save();

        // 更新後は詳細画面（show）に戻す
        return redirect()->route('work.show', $work->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function work_delete(string $novel_id)
    {
        $work = Novel::findOrFail($novel_id);



        $work->delete();

        // 削除後は作品一覧（work.index）にリダイレクト
        return redirect()->route('work.index');
    }
}
