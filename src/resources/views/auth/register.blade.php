@extends('layouts.app')

@section('header-button')
<!-- ログイン画面へ遷移するリンク -->
<a href="/login" class="header__link">login</a>
@endsection

@section('css')
<!-- 認証画面共通CSS -->
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')

<!-- ページタイトル -->
<h2 class="auth__heading">Register</h2>

<div class="auth auth--register">
    <div class="auth__content">

        <!-- 会員登録フォーム -->
        <form method="POST" action="/register" novalidate>
            @csrf

            <!-- =============================
                 お名前
            ============================== -->
            <div class="form__group">
                <label class="form__label">お名前</label>

                <!-- 入力欄 -->
                <input class="form__input" type="text" name="name" value="{{ old('name') }}" placeholder="例：山田 太郎">

                <!-- バリデーションエラー表示 -->
                @error('name')
                <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <!-- =============================
                 メールアドレス
            ============================== -->
            <div class="form__group">
                <label class="form__label">メールアドレス</label>

                <!-- 入力欄 -->
                <input class="form__input" type="email" name="email" value="{{ old('email') }}" placeholder="例：test@example.com">

                <!-- バリデーションエラー表示 -->
                @error('email')
                <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <!-- =============================
                 パスワード
            ============================== -->
            <div class="form__group">
                <label class="form__label">パスワード</label>

                <!-- 入力欄 -->
                <input class="form__input" type="password" name="password"  placeholder="例：coachtech1106">

                <!-- バリデーションエラー表示 -->
                @error('password')
                <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <!-- =============================
                 登録ボタン
            ============================== -->
            <div class="form__button">
                <button type="submit" class="form__button-submit">
                    登録
                </button>
            </div>

        </form>
    </div>
</div>
@endsection