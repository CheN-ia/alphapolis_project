<h1>プロフィール</h1>
<p>resources/views/user-setting/index.blade.php</p>
{{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
<div>
    <h2>{{ $user->name }}</h2>
    <h2>{{ $user->email }}</h2>
    <a href="{{ $user->id }}/edit">プロフィール編集</a>
</div>

<a href="/user/{{ $user->id }}">マイページに戻る</a>

