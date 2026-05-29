{{-- layoutsディレクトリからnavメニュー呼び出し --}}
@extends('layouts.novels-nav')
@section('content')

<p><a href="{{ route('novels.show', $novel->id) }}">&lt; {{ $novel->title }} の目次に戻る</a></p>

<hr>

<h1>{{ $episode->title }}</h1>

<div>
    @if($episode->image)
    <div>
        <h3>挿絵・カバー画像</h3>
        <img src="{{ asset('storage/' . $episode->image) }}" alt="エピソード画像" style="max-width: 100%; height: auto;">
    </div>
    <hr>
@endif
    {{ $episode->text }}
</div>

@endsection
