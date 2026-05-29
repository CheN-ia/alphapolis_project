{{-- layoutsディレクトリからnavメニュー呼び出し --}}
@extends('layouts.novels-nav')
@section('content')

@if (auth()->id() == $user->id)
    <h1>プロフィール</h1>
    <p>resources/views/user-setting/index.blade.php</p>
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    @if(session('message'))
        <div>
            {{ session('message') }}
        </div>
    @endif
    <div>
        <div>
            名前:{{ $user->name  }}
        </div>
        <div>
            ID:{{ $user->id }}
        </div>
        <div>
            メールアドレス:{{ $user->email }}
        </div>
        <a href="{{ $user->id }}/edit">プロフィール編集</a>
    </div>

    <a href="{{ route('users.mypage', ['user_id' => $user->id]) }}">ユーザーページに戻る</a>
@else
間違ったURLが入力されています。表示できません。
@endif

@endsection

