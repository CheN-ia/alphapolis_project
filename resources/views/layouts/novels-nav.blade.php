<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
        <style>

        nav {
            background-color: #f8f9fa;
            margin-bottom: 16px;
            font-family: Arial, sans-serif;
            font-size: 24px;
        }
        nav ul {
            list-style: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 10px;
        }
        nav ul li a {
            color: #333;
            text-decoration: none;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        {{-- 小説投稿サイトのナビゲーションメニュー --}}
        <h1>
            <nav>
                <ul>
                    <li><a href="{{ route('novels.index') }}">トップページ</a></li>
                    @auth
                        <li><a href="{{ route('users.mypage', ['user_id' => auth()->id()]) }}">ユーザーページ</a></li>
                        <li><a href={{ route('logout') }} onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            ログアウト
                        </a>
                        <form id='logout-form' action={{ route('logout')}} method="POST" style="display: none;">
                        @csrf
                        </li>
                    @else
                        <li><a href="{{ route('login.with.redirect') }}">ログイン</a></li>
                        <li><a href="{{ route('register.with.redirect') }}">新規登録</a></li>
                    @endauth

                </ul>
            </nav>
    </h1>
    </header>

    <main>
        {{-- 各ページのコンテンツがここに差し込まれます --}}
        @yield('content')
    </main>

</body>
</html>
