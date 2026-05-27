<h1>新規小説作成</h1>

<form action="" method="POST">
    @csrf

    <div>
        <label>作品タイトル:</label>
        <input type="text" name="title" required>
    </div>

    <div style="margin-top: 15px;">
        <label>ジャンル:</label><br>
        @foreach($genres as $genre)
            <input type="radio" name="genre_id" value="{{ $genre->id }}" required> {{ $genre->genre }}
        @endforeach
    </div>

    <div style="margin-top: 15px;">
        <label>既存のタグ:</label><br>
        @foreach($tags as $tag)
            <input type="checkbox" name="existing_tags[]" value="{{ $tag->id }}"> {{ $tag->tag }}
        @endforeach
    </div>

    <div style="margin-top: 15px;">
        <label>新しいタグ（複数ある場合はカンマ「,」で区切る）:</label><br>
        <input type="text" name="new_tags" placeholder="例: 冒険,チート">
    </div>

    <div style="margin-top: 20px;">
        <button type="submit">作成する</button>
        <a href="../{{ Auth::id() }}">戻る</a>
    </div>
</form>
