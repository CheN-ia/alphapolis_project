<h1>{{ $user->name }}さんのマイページ</h1>
<p>resources/views/users/index.blade.php</p>
{{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
<div>
    <h2>プロフィール</h2>
    <a href="/user-settings/{{ $user->id }}">プロフィール設定</a>
</div>
<div>
    <h2>投稿作品</h2>
    <a href="{{ $user->id }}/index">投稿作品一覧へ</a>
</div>
<div>
    <h2>ブックマーク</h2>
    <a href="{{ $user->id }}/bm">ブックマーク一覧へ</a>
</div>
<div>
    <h2>投稿コメント</h2>
    <a href="{{ $user->id }}/comment">コメント一覧へ</a>
</div>
