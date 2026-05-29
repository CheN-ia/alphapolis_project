{{-- //layoutsディレクトリからnavメニュー呼び出し --}}
@extends('layouts.novels-nav')
@section('content')

<h1>作品情報の編集</h1>
<p>resources/views/users/works/edit.blade.php</p>

<form action="{{ route('work.update', $work->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <div>
        <label for="title">作品タイトル</label>
        <input type="text" id="title" name="title" value="{{ old('title', $work->title) }}" required>
    </div>

    <div class="form-group">
        <label>タグ（チェックを外すと削除されます）:</label><br>
        @foreach($work->tags as $tag)
            <label >
                <input type="checkbox" name="existing_tags[]" value="{{ $tag->id }}" checked>
                {{ $tag->tag }}
            </label>
        @endforeach
    </div>
    <div>
        <label >新しいタグを追加（カンマ `,` 区切りで複数入力可）:</label><br>
        <input type="text" id="new_tags" name="new_tags" value="{{ old('new_tags') }}" placeholder="例: ファンタジー, 異世界">
        </div>
    <div>
        <label for="abstract">あらすじ:</label><br>
        <textarea id="abstract" name="abstract" rows="15" cols="60" required>{{ old('abstract', $work->abstract) }}</textarea>
    </div>
    <button type="submit">変更を保存する</button>
</form>

<a href="{{ route('work.show', $work->id) }}">戻る</a>

@endsection
