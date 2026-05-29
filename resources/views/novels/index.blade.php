{{-- layoutsディレクトリからnavメニュー呼び出し --}}
@extends('layouts.novels-nav')
@section('content')

<h1>一覧画面</h1>
<p>resources/views/users/index.blade.php</p>

<link rel="stylesheet" href="{{ asset('css/style.css') }}">


<form action="{{ route('novels.index') }}" method="GET" class="search-form">
    <select name="genre_id">
        <option value="">すべてのジャンル</option>
        @foreach($genres as $genre)
            <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>
                {{ $genre->genre }}
            </option>
        @endforeach
    </select>
    <br>
    <div style="margin-top: 15px;">
        <label>タグ:</label><br>
        @foreach($tags as $tag)
            <input type="checkbox"
                name="tag_id[]"
                value="{{ $tag->id }}"
                {{ is_array(request('tag_id')) && in_array($tag->id, request('tag_id')) ? 'checked' : '' }}>
            {{ $tag->tag }}
        @endforeach
    </div>


    <button type="submit">検索</button>
</form>
@if ($works->count() > 0)
    <table>
        <tr>
            <th>title</th>
        </tr>
        {{-- @foreach ディレクティブで、1件ずつ処理 --}}
        @foreach ($works as $work)
            <tr>
                <td>
                    <a href="{{ route('novels.show', $work->id) }}">{{ $work->title }}</a>
                </td>
                </tr>
        @endforeach
    </table>
@else
    <p>作品はありません</p>
@endif

@endsection
