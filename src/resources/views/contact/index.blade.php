@extends('layouts.app')

@section('css')
  <!-- お問い合わせ入力画面専用CSS -->
  <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
    <div class="contact-form__content">

      <!-- ページタイトル -->
      <div class="contact-form__heading">
            <h2>Contact</h2>
      </div>

      <!-- お問い合わせフォーム -->
      <form class="form" action="/confirm" method="post" novalidate>
            @csrf

            <!-- =============================
                 お名前
            ============================== -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">お名前</span>
                    <span class="form__label--required">※</span>
                </div>

                <div class="form__group-content">
                    <div class="form__input--text">

                        <!-- 姓 -->
                        <div>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="例：山田" />
                            <div class="form__error">
                                @error('last_name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <!-- 名 -->
                        <div>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="例：太郎" />
                            <div class="form__error">
                                @error('first_name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- =============================
                 性別
            ============================== -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">性別</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--radio">
                        <label>
                            <input type="radio" name="gender" value="1" {{ old('gender', '1') == '1' ? 'checked' : '' }}>男性
                        </label>
                        <label>
                            <input type="radio" name="gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }}>女性
                        </label>
                        <label>
                            <input type="radio" name="gender" value="3" {{ old('gender') == '3' ? 'checked' : '' }}>その他
                        </label>
                    </div>

                    <!-- エラーメッセージ -->
                    <div class="form__error">
                        @error('gender')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <!-- =============================
                 メールアドレス
            ============================== -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">メールアドレス</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="例：test@example.com" />
                    </div>
                    <div class="form__error">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <!-- =============================
                 電話番号
            ============================== -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">電話番号</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--tel">

                        <!-- 電話番号1 -->
                        <input type="tel" name="tel1" value="{{ old('tel1') }}" maxlength="3" placeholder="080" />
                        <span>-</span>

                        <!-- 電話番号2 -->
                        <input type="tel" name="tel2" value="{{ old('tel2') }}" maxlength="4" placeholder="1234" />
                        <span>-</span>

                        <!-- 電話番号3 -->
                        <input type="tel" name="tel3" value="{{ old('tel3') }}" maxlength="4" placeholder="5678" />
                    </div>

                    <!-- 3項目まとめてエラー表示 -->
                    <div class="form__error">
                        @if ($errors->has('tel1') || $errors->has('tel2') || $errors->has('tel3'))
                            {{ $errors->first('tel1') ?: ($errors->first('tel2') ?: $errors->first('tel3')) }}
                        @endif
                    </div>
                </div>
            </div>

            <!-- =============================
                 住所
            ============================== -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">住所</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="address" value="{{ old('address') }}" placeholder="例：東京都渋谷区千駄ヶ谷1-2-3" />
                    </div>
                    <div class="form__error">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <!-- =============================
                 建物名（任意）
            ============================== -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">建物名</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="building" value="{{ old('building') }}" placeholder="例：千駄ヶ谷マンション101" />
                    </div>
                </div>
            </div>

            <!-- =============================
                 お問い合わせの種類
            ============================== -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">お問い合わせの種類</span>
                    <span class="form__label--required">※</span>
                </div>

                <div class="form__group-content">
                    <div class="form__input--select">
                        <select name="category">
                            <option value="">選択してください</option>
                            <option value="1" {{ old('category') == '1' ? 'selected' : '' }}>商品のお届けについて</option>
                            <option value="2" {{ old('category') == '2' ? 'selected' : '' }}>商品の交換について</option>
                            <option value="3" {{ old('category') == '3' ? 'selected' : '' }}>商品トラブル</option>
                            <option value="4" {{ old('category') == '4' ? 'selected' : '' }}>その他</option>
                        </select>
                    </div>

                    <!-- エラー -->
                    <div class="form__error">
                        @error('category')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <!-- =============================
                 お問い合わせ内容
            ============================== -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">お問い合わせ内容</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--textarea">
                        <textarea name="content" maxlength="120" placeholder="お問い合わせ内容をご記載ください(120文字以内)">{{ old('content') }}</textarea>
                    </div>
                    <div class="form__error">
                        @error('content')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <!-- 送信ボタン -->
            <div class="form__button">
                <button class="form__button-submit" type="submit">確認画面</button>
            </div>

        </form>
    </div>
@endsection