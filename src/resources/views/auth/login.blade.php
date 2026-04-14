@extends('layouts.app')

@section('header-button')
    <!-- ログイン画面から新規登録ページに遷移するリンク -->
    <a href="/register" class="header__link">register</a>
@endsection

@section('css')
    <!-- ログイン・会員登録画面用CSS -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <!-- 認証（ログイン）画面のコンテンツ -->
    <div class="auth auth--login">
        <!-- ログイン画面の見出し -->
        <h2 class="auth__heading">Login</h2>

        <div class="auth__content">

            <!-- ログインフォーム -->
            <form class="form" method="POST" action="/login" novalidate>
                @csrf
                <!-- メールアドレス入力フィールド -->
                <div class="form__group">
                    <label class="form__label">メールアドレス</label>
                    <input class="form__input" type="email" name="email" value="{{ old('email') }}" placeholder="例：test@example.com">

                    <!-- バリデーションエラー表示 -->
                    @error('email')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>


                <!-- パスワード入力フィールド -->
                <div class="form__group">
                    <label class="form__label">パスワード</label>
                    <input class="form__input" type="password" name="password" placeholder="例：coachtech1106">

                    <!-- バリデーションエラー表示 -->
                    @error('password')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ログインボタン -->
                <div class="form__button">
                    <button type="submit" class="form__button-submit">
                        ログイン
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection