<h1>一覧画面</h1>
<p>resources/views/users/index.blade.php</p>

<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<a href="/user/{{ $user->id }}">入力画面へ</a>
@if ($works->count() > 0)
    <table>
        <tr>
            <th>ID</th>
            <th>title</th>
        </tr>
        {{-- @foreach ディレクティブで、1件ずつ処理 --}}
        @foreach ($works as $work)
            <tr>
                <td>{{ $work->id }}</td>
                <td>{{ $work->title }}</td>
            </tr>
        @endforeach
    </table>
@else
    <p>お問い合わせはありません</p>
@endif

