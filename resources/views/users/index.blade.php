<h1>{{ $user->name }}さんのマイページ</h1>
<p>resources/views/users/index.blade.php</p>
{{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
<div>
    <h2>プロフィール</h2>
    <a href="{{ route('UserSettings.user_show', ['user_id' => $user->id]) }}">プロフィール設定</a>
</div>
<div>
    <h2>投稿作品</h2>
    <a href="{{ route('users.work_index', ['user_id' => $user->id]) }}">投稿作品一覧へ</a></div>
<div>
    <h2>ブックマーク</h2>
    <a href="{{ route('users.Bookmarks.bm_show', ['user_id' => $user->id]) }}">ブックマーク一覧へ</a>
</div>
<div>
    <h2>投稿コメント</h2>
    <a href="{{ route('users.Comment.comment_show', ['user_id' => $user->id]) }}">コメント一覧へ</a>
</div>
