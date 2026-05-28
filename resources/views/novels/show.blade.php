<h1>{{ $novel->title }}</h1>

<h2>エピソード一覧</h2>
@if(session('message'))
	<div>
		{{ session('message') }}
	</div>
@endif

@if ($novel->episodes->count() > 0)
    <ul>
        @foreach ($novel->episodes as $episode)
            <li>
                <a href="{{ route('novels.episode_show', [$novel->id, $episode->id]) }}">
                    {{ $episode->title }}
                </a>
            </li>
        @endforeach
    </ul>
@else
    <p>エピソードはまだ投稿されていません。</p>
@endif

<a href="{{ route('novels.index') }}">作品一覧に戻る</a>

@auth
    <form action="{{ route('users.bookmarks.store', ['user_id' => auth()->id()]) }}" method="POST">
        @csrf
        <input type="hidden" name="novel_id" value ={{ $novel->id }}>
        <button type="submit">ブックマークに追加</button>
    </form>
@else
    ブックマーク機能を使うためには
    <a href="{{ route('login.with.redirect') }}">ログインが必要です</a>
@endauth

{{-- コメント表示・入力用 --}}
<div>
    <h2>コメント</h2>
    <div>

<form>
    <h2>コメントする</h2>
    <input type="text" name="comment" />
</form>
