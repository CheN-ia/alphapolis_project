{{-- layoutsディレクトリからnavメニュー呼び出し --}}
@extends('layouts.novels-nav')
@section('content')

<h1>エピソード詳細（管理画面）</h1>

<p><a href="{{ route('work.show', $novel_id) }}">作品詳細に戻る</a></p>

<hr>

<div>
    <h2>タイトル: {{ $episode->title }}</h2>
    <p>投稿日: {{ $episode->created_at->format('Y/m/d H:i') }} | PV: {{ $episode->PV }}</p>
</div>

@if($episode->image)
    <div>
        <h3>挿絵・カバー画像</h3>
        <img src="{{ asset('storage/' . $episode->image) }}" alt="エピソード画像" style="max-width: 100%; height: auto;">
    </div>
    <hr>
@endif

<div>
    <h3>本文</h3>
    <p>{!! nl2br(e($episode->text)) !!}</p>
</div>

<hr>

<div>
    <a href="{{ route('work.episode.edit', [$novel_id, $episode->id]) }}">
        <button type="button">このエピソードを編集する</button>
    </a>

    <form action="{{ route('work.episode.delete', [$novel_id, $episode->id]) }}" method="POST" onsubmit="return confirm('本当にこのエピソードを削除しますか？');" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" style="color: red;">このエピソードを削除する</button>
    </form>
</div>

@endsection
