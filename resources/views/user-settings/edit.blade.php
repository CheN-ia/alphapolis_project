{{-- layoutsディレクトリからnavメニュー呼び出し --}}
@extends('layouts.novels-nav')
@section('content')

@if (auth()->id() == $user->id)
    <h1>プロフィール編集画面</h1>
    <p>resources/views/user-setting/edit.blade.php</p>
    <div>
        <form action="/user-settings/{{ $user->id }}" method="POST">
            @csrf
            @method('PATCH') {{-- フォームの送信時にHTTPメソッドをPATCHに変更(データ更新) --}}
            <div>
                <div>
                    名前:<input type="text" id="name" name="name"  value="{{ old('name', $user->name) }}">
                    @if ($errors->has('name'))
                    <span class="error">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div>
                メールアドレス：<input type="text" id="email" name="email"  value="{{ old('email', $user->email) }}">
                    @if ($errors->has('email'))
                    <span class="error">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div>
                新しいパスワード：<input type="text" id="password" name="password">
                    @if ($errors->has('password'))
                    <span class="error">{{ $errors->first('password') }}</span>
                    @endif
                <br>
                新しいパスワード（確認用）:<input type="password" id="password_confirmation" name="password_confirmation">
                </div>
            </div>
            <input type="hidden" name="id" value="{{ $user->id }}">
            <div><input type="submit" value="変更の反映"></div>
        </form>
        <a href="{{ route('users.mypage', ['user_id' => $user->id]) }}">ユーザーページに戻る</a>

    </div>
@else
間違ったURLが入力されています。表示できません。
@endif


@endsection
