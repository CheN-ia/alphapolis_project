<h1>{{ $novel->title }}</h1>

<h2>エピソード一覧</h2>

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
