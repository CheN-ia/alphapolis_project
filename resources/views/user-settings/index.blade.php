<h1>プロフィール</h1>
<p>resources/views/user-setting/index.blade.php</p>
{{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
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

<a href="/user/{{ $user->id }}/index">マイページに戻る</a>

