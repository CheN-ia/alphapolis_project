{{-- layoutsディレクトリからnavメニュー呼び出し --}}
@extends('layouts.novels-nav')
@section('content')

<h1>投稿コメント一覧</h1>
<p>resources/views/users/comments/index.blade.php</p>
@if(session('message'))
	<div>
		{{ session('message') }}
	</div>
@endif
@if ($comments->count() > 0)
        {{-- @foreach ディレクティブで、1件ずつ処理 --}}
        @foreach ($comments as $comment)
                <p><a  href="/novels/{{ $comment->id }}">{{ $comment->title }}</a>
                    <p>{{ $comment->pivot->comment }}</p>
                    <form action="/user/{{ $user->id }}/comment/{{ $comment->id }}" method="post">
                    @csrf
                    @method('Delete')
                        <input type="hidden" id="comment_id" name="comment_id" value="{{ $comment->id }}" />
                        <input type="submit" name="delete" value="削除">
                    </form>
                </p>
        @endforeach
@else
    <p>投稿コメントはありません！</p>
@endif
    <a href="{{ route('users.mypage', ['user_id' => $user->id]) }}">ユーザーページに戻る</a>


@endsection
