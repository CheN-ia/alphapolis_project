<h1>ブックマーク一覧</h1>
<p>resources/views/users/bookmarks/index.blade.php</p>
@if ($bookmarks->count() > 0)
        {{-- @foreach ディレクティブで、1件ずつ処理 --}}
        @foreach ($bookmarks as $bookmark)
                <p><a  href="/bookmark/{{ $bookmark->id }}">{{ $bookmark->title }}</a>
                    <form action="/bookmark/{{ $bookmark->id }}" method="post">
                    @csrf
                    @method('Delete')
                        <input type="submit" name="delete" value="削除">
                    </form>
                </p>
        @endforeach
@else
    <p>投稿はありません！</p>
@endif
