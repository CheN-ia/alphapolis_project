{{-- layoutsディレクトリからnavメニュー呼び出し --}}
@extends('layouts.novels-nav')
@section('content')

<h1>小説管理画面</h1>
<p>resources/views/users/works/index.blade.php</p>
<a href="{{ route('users.mypage', Auth::user()->id) }}" >マイページに戻る</a>
<div class="actions" style="margin-bottom: 20px;">
    <a href="{{ route('work.create') }}" >新規小説を作成する</a>
</div>

{{-- コントローラーから渡された $works の件数チェック --}}
@if ($works && $works->count() > 0)
    <table border="1" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <th>小説タイトル</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($works as $work)
                <tr>
                    <td>
                        <a href="{{ route('work.show', $work->id) }}">
                            {{ $work->title }}
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('work.delete', $work->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    {{-- 作品がない場合は「まだありません」を表示 --}}
    <p>作品はまだありません。</p>
@endif

@endsection
