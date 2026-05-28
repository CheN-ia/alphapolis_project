<h1>作品情報の編集</h1>
<p>resources/views/users/works/edit.blade.php</p>

<form action="{{ route('work.update', $work->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <div>
        <label for="title">作品タイトル</label>
        <input type="text" id="title" name="title" value="{{ old('title', $work->title) }}" required>
    </div>

    <div>
        <label for="tags">タグ</label>
        <input type="text" id="tags" name="tags" value="{{ old('tags', $work->tag) }}">
    </div>

    <button type="submit">変更を保存する</button>
</form>

<a href="{{ route('work.show', $work->id) }}">戻る</a>
