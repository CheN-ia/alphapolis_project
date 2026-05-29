{{-- layoutsディレクトリからnavメニュー呼び出し --}}
@extends('layouts.novels-nav')
@section('content')

<h1>ブックマーク一覧</h1>
<p>resources/views/users/bookmarks/index.blade.php</p>
@if(session('message'))
	<div>
		{{ session('message') }}
	</div>
@endif
@if ($bookmarks->count() > 0)
        {{-- @foreach ディレクティブで、1件ずつ処理 --}}
        @foreach ($bookmarks as $bookmark)
                <p><a  href="/novels/{{ $bookmark->id }}">{{ $bookmark->title }}</a>
                    <form action="/user/{{ $user->id }}/bm/delete" method="post">
                    @csrf
                    @method('Delete')
                        <input type="hidden" id="novel_id" name="novel_id" value="{{ $bookmark->id }}" />
                        <input type="submit" name="delete" value="削除">
                    </form>
                </p>
        @endforeach
@else
    <p>投稿はありません！</p>
@endif
<a href="{{ route('users.mypage', $user->id) }}">ユーザーページに戻る</a>

@endsection
