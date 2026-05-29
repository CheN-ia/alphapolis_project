{{-- layoutsディレクトリからnavメニュー呼び出し --}}
@extends('layouts.novels-nav')
@section('content')

<h1>{{ $user->name }}さんのユーザーページ</h1>
<div>
    <a href="{{ route('novels.index', $user->id) }}">トップページへ</a>
</div>

<p>resources/views/users/index.blade.php</p>

<div>
    <h2>プロフィール</h2>
    <a href="{{ route('usersettings.user_show', $user->id) }}">プロフィール設定</a>
</div>

<div>
    <h2>投稿作品</h2>
    <a href="{{ route('work.index') }}">投稿作品一覧へ</a>
</div>

<div>
    <h2>ブックマーク</h2>
    <a href="{{ route('users.bookmarks.index', $user->id) }}">ブックマーク一覧へ</a>
</div>

<div>
    <h2>投稿コメント</h2>
    <a href="{{ route('users.comment.index', $user->id) }}">コメント一覧へ</a>
</div>

@endsection
