<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- タイトル -->
  <title>contact-form-test</title>

  <!-- CSSリセット -->
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">

  <!-- 共通CSS -->
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">

  <!-- Googleフォント -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">

  <!-- 各ページ固有CSS挿入 -->
  @yield('css')
</head>

<body>

  <!-- =============================
       ヘッダー
  ============================== -->
  <header class="header">
    <div class="header__inner">

      <!-- ロゴ -->
      <h1 class="header__logo">
        FashionablyLate
      </h1>

      <!-- 右上ボタンエリア -->
      <div class="header__button">

        <!-- 未ログイン時に表示（login/register） -->
        @guest
          @yield('header-button')
        @endguest

        <!-- ログイン時に表示（logout） -->
        @auth
          <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="header__link">logout</button>
          </form>
        @endauth

      </div>

    </div>
  </header>

  <!-- =============================
       メインコンテンツ
  ============================== -->
  <main>
    <!-- 各ページの内容がここに入る -->
    @yield('content')
  </main>

</body>

</html>