{{-- layoutsディレクトリからnavメニュー呼び出し --}}
@extends('layouts.novels-nav')
@section('content')

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


{{-- コメント表示・入力・ブックマーク追加用 --}}
<div>
    <h2>コメント</h2>
    <x-show-novel-comments :novel-id="$novel->id"/>
@auth
    <form action="{{ route('users.comment.store', ['user_id' => auth()->id()]) }}" method="POST">
        <h2>コメントする</h2>
            <textarea name="comment" rows="10" cols="50" placeholder="こちらにコメントを入力してください..."></textarea>
            <input type="hidden" name="novel_id" value ={{ $novel->id }}>
        <button type="submit">投稿</button>
    </form>

    <form action="{{ route('users.bookmarks.store', ['user_id' => auth()->id()]) }}" method="POST">
        @csrf
        <input type="hidden" name="novel_id" value ={{ $novel->id }}>
        <button type="submit">ブックマークに追加</button>
    </form>
@else
    <p>
        コメント機能・ブックマーク機能を使用するためには
        <a href="{{ route('login.with.redirect') }}">ログイン</a>が必要です
    </p>
@endauth

</div>
@endsection
