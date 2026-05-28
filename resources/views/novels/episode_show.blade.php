<p><a href="{{ route('novels.show', $novel->id) }}">&lt; {{ $novel->title }} の目次に戻る</a></p>

<hr>

<h1>{{ $episode->title }}</h1>

<div>
    {{ $episode->text }}
</div>
