{{-- layoutsディレクトリからnavメニュー呼び出し --}}
@extends('layouts.novels-nav')
@section('content')

<h1>新規エピソード追加</h1>

<form action="{{ route('work.episode.store', $novel_id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label>エピソードタイトル:</label><br>
        <input type="text" name="title" required>
    </div>

    <div>
        <label>本文:</label><br>
        <textarea name="text" rows="15" cols="60" required></textarea>
    </div>

    <div>
        <label>画像（任意）:</label><br>
        <input type="file" name="image" accept="image/*">
    </div>

    <div>
        <button type="submit">エピソードを公開する</button>
        <a href="{{ route('work.show', $novel_id) }}">戻る</a>
    </div>
</form>


@endsection
