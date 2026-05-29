{{-- layoutsディレクトリからnavメニュー呼び出し --}}
@extends('layouts.novels-nav')
@section('content')

<h1>作品詳細画面</h1>
<p>resources/views/users/works/show.blade.php</p>
    <a href="{{ route('work.index') }}">戻る</a>

<div>
    <h2>作品情報</h2>
    <p>タイトル: {{ $work->title }}</p>
    <p>タグ:
        {{-- $work->tags で、紐づくすべてのタグがループで回せます --}}
        @foreach($work->tags as $tag)
            <span>{{ $tag->tag }}</span>
        @endforeach
    </p>

    <a href="{{ route('work.edit', $work->id) }}">この作品を編集する</a>
</div>

<hr>

<section>
    <div>
        <h2>エピソード一覧</h2>
        <a href="{{ route('work.episode.create', $work->id) }}">+.新しいエピソードを執筆</a>
    </div>

    @if($work->episodes->isEmpty())
        <p>まだエピソードが投稿されていません。</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>話数</th>
                    <th>サブタイトル</th>
                    <th>投稿日</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($work->episodes as $index => $episode)
                    <tr>
                        <td>第 {{ $index + 1 }} 話</td>
                        <td>
                        <a href="{{ route('work.episode.show', [$work->id, $episode->id]) }}">
                            {{ $episode->title }}
                        </a>
                        </td>
                        <td>{{ $episode->created_at->format('Y/m/d H:i') }}</td>
                        <td>
                            <form action="{{ route('work.episode.delete', [$work->id, $episode->id]) }}" method="POST" onsubmit="return confirm('本当にこのエピソードを削除しますか？');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</section>


@endsection
