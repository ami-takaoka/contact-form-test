<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <title>thankspage</title>

    <!-- CSS読み込み（リセットCSS、共通CSS、サンクス画面専用CSS） -->
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}" />
    
    <!-- Googleフォント設定（Playfair Display） -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
</head>

<body class="thanks-body">

    <!-- サンクスメッセージ背景 -->
    <div class="thanks-bg">Thank you</div>

    <!-- サンクス画面コンテンツ -->
    <div class="thanks__content">
        
        <!-- 見出し（お問い合わせありがとうございました） -->
        <div class="thanks__heading">
            <h2>お問い合わせありがとうございました</h2>
        </div>

        <!-- ホームに戻るボタン -->
        <div class="thanks__home">
            <!-- ホームに遷移するリンク -->
            <a href="/" class="thanks__home-btn">HOME</a>
        </div>
        
    </div>

</body>

</html>