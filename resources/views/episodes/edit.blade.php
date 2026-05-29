{{-- layoutsディレクトリからnavメニュー呼び出し --}}
@extends('layouts.novels-nav')
@section('content')

<h1>編集</h1>
<p>resources/views/episodes/edit.blade.php</p>

<form action="{{ route('work.episode.update', [$novel_id, $episode->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div>
        <label for="title">エピソードタイトル</label>
        <input type="text" id="title" name="title" value="{{ old('title', $episode->title) }}" required>
    </div>

    <div>
        <label for="text">本文</label>
        <textarea id="text" name="text" rows="15" cols="60" required>{{ old('text', $episode->text) }}</textarea>
    </div>

    <div>
        <label>画像（任意）:</label><br>
        <input type="file" name="image" accept="image/*">
    </div>

    <button type="submit">変更を保存する</button>
</form>

<a href="{{ route('work.episode.show', [$novel_id, $episode->id]) }}">戻る</a>

@endsection
