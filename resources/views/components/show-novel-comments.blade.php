<div>
    @foreach($comments as $comment)
    <p>
        名前:{{ $comment->name }}<br>
        コメント:{{ $comment->pivot->comment }}<br>
    </p>
    @endforeach
</div>
